<?php

use App\Http\Controllers\IpRestrictionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ResellersController;
use App\Http\Controllers\PromotionsController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\OperatorsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\BillingsController;
use App\Http\Controllers\TopupsController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletTransferController;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\DropzoneController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/','dashboard.login');
Route::view('/login','dashboard.login')->name('login');
Route::post('/login',[AuthController::class,'login']);
Route::view('/forgot/password','dashboard.forgot-password');
Route::post('/forgot/password',[AuthController::class,'forgotPassword']);
Route::get('/register', [AuthController::class,'getRegister']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/logout',[AuthController::class,'logout']);
Route::get('/widget',[TopupsController::class,'getHomePageTopup']);
Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('app/public/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});
Route::middleware(['auth'])->group(function (){
    Route::view('/2fa/required','dashboard.2fa.home');
    Route::post('/2fa/required',[AuthController::class,'tfaVerify']);
    Route::post('/2fa/required/send',[AuthController::class,'sendCode']);
    Route::view('ip_address/blocked','dashboard.ips.blocked');
});

Route::middleware(['auth','tfa','ipr'])->group(function () {
    Route::middleware(['role:dashboard'])->group(function (){
        Route::get('/dashboard', [DashboardController::class,'index']);
        Route::get('dashboard/stats/topups/amounts',[DashboardController::class,'statsTopupAmount']);
    });
    Route::middleware(['role:profile'])->group(function (){
        Route::get('/profile', [ProfileController::class,'index']);
        Route::post('/profile', [ProfileController::class,'save']);
        Route::post('/profile/image/remove',[ProfileController::class,'removeProfileImage']);
        Route::post('/profile/image/upload',[ProfileController::class,'uploadProfileImage']);
        Route::post('/profile/2fa/change',[ProfileController::class,'changeTwoFAStatus']);
    });

    Route::middleware(['role:ip_restriction'])->group(function (){
        Route::resource('ip_restriction',IpRestrictionController::class);
        Route::post('/ip_restriction/status/change',[IpRestrictionController::class,'changeStatus']);
    });

    Route::resource('/users/customers',CustomersController::class)->middleware(['role:users_customers']);
    Route::middleware(['role:users_resellers'])->group(function () {
        Route::resource('/users/resellers', ResellersController::class);
        Route::get('/users/resellers/{id}/rates', [ResellersController::class,'showResellerRates']);
        Route::post('/users/resellers/{id}/rates', [ResellersController::class,'saveResellerRates']);
        Route::post('/users/accounts/{id}/2fa/change',[ResellersController::class,'changeTFAStatus']);
        Route::post('/users/accounts/{id}/ip_restriction/change',[ResellersController::class,'changeIPRStatus']);
    });

    Route::post('/settings/full_logo/remove',[SettingsController::class,'removeFullLogo']);
    Route::post('/settings/full_logo/upload',[SettingsController::class,'uploadFullLogo']);
    Route::post('/settings/mini_logo/remove',[SettingsController::class,'removeMiniLogo']);
    Route::post('/settings/mini_logo/upload',[SettingsController::class,'uploadMiniLogo']);
    Route::post('/settings/favicon/remove',[SettingsController::class,'removeFavicon']);
    Route::post('/settings/favicon/upload',[SettingsController::class,'uploadFavicon']);
    Route::post('/settings/login_logo/remove',[SettingsController::class,'removeLoginLogo']);
    Route::post('/settings/login_logo/upload',[SettingsController::class,'uploadLoginLogo']);

    Route::middleware(['role'])->group(function () {
        Route::get('/settings', [SettingsController::class,'index']);
        Route::post('/settings', [SettingsController::class,'save']);
    });

    Route::middleware(['role:topups_promotions'])->group(function (){
        Route::get('topups/promotions', [PromotionsController::class,'index']);
        Route::post('topups/promotions/sync', [PromotionsController::class,'sync']);
        Route::get('topups/promotions/{id}', [PromotionsController::class,'show']);
    });

    Route::middleware(['role:topups_countries'])->group(function (){
        Route::get('topups/countries', [CountriesController::class,'index']);
        Route::post('topups/countries/sync', [CountriesController::class,'sync']);
        Route::get('topups/countries/{id}/operators', [CountriesController::class,'operators']);
    });

    Route::middleware(['role:topups_operators'])->group(function (){
        Route::get('topups/operators', [OperatorsController::class,'index']);
        Route::post('topups/operators/sync', [OperatorsController::class,'sync']);
        Route::get('topups/operators/{id}/promotions', [OperatorsController::class,'promotions']);
    });

    Route::middleware(['role:topups_discounts'])->group(function (){
        Route::get('topups/discounts', [DiscountsController::class,'index']);
        Route::post('topups/discounts/sync', [DiscountsController::class,'sync']);
    });

    Route::middleware(['role:topups_send'])->group(function () {
        Route::get('/topups/send', [TopupsController::class,'getWizard']);
        Route::post('/topups/send', [TopupsController::class,'sendTopUp']);
    });

    Route::middleware(['role:topups_history'])->group(function () {
        Route::get('/topups/history', [TopupsController::class,'index']);
        Route::get('/topups/history/{id}/pin_detail', [TopupsController::class,'getPinDetail']);
        Route::get('/topups/history/{id}/failed', [TopupsController::class,'getFailedDetail']);
        Route::post('/topups/{id}/retry', [TopupsController::class,'retrySendTopup']);
    });

    Route::middleware(['role:invoices'])->group(function () {
        Route::get('/invoices/view/{id}',[InvoicesController::class,'view']);
        Route::post('/invoices/{id}/mark_paid',[InvoicesController::class,'markInvoicePaid']);
        Route::resource('/invoices',InvoicesController::class);
        Route::get('/invoices/{id}/stripe/checkout',[InvoicesController::class,'stripeCheckout']);
        Route::post('/invoices/{id}/paypal/checkout',[InvoicesController::class,'PaypalCheckout']);
        Route::post('/checkout/stripe/response',[InvoicesController::class,'stripeResponse']);
        Route::post('/checkout/paypal/response/invoice/{id}',[InvoicesController::class,'paypalResponse']);
        Route::get('/invoices/{id}/numbers',[InvoicesController::class,'getTopupsForInvoice']);
        Route::post('/invoices/{id}/pay/balance',[InvoicesController::class,'balanceCheckout']);
        Route::get('/invoices/print/{id}',[InvoicesController::class,'print']);
    });

    Route::middleware(['role:billings'])->group(function (){
        Route::get('/billings', [BillingsController::class,'index']);
        Route::get('/billings/stripe/add',[BillingsController::class,'show']);
        Route::delete('/billings/stripe/{id}',[BillingsController::class,'destroy']);
        Route::post('/billings/stripe/sync',[BillingsController::class,'sync']);
    });

    Route::middleware(['role:wallet_account'])->group(function (){
        Route::get('/wallet/account',[WalletController::class,'index']);
        Route::get('/wallet/account/balance/add',[WalletController::class,'show']);
        Route::post('/wallet/account/balance/create',[WalletController::class,'create']);
    });

    Route::middleware(['role:wallet_accounts'])->group(function (){
        Route::get('/wallet/accounts',[WalletController::class,'wallets']);
        Route::get('/wallet/accounts/balance/add/{id}',[WalletController::class,'showModal']);
        Route::post('/wallet/accounts/balance/create',[WalletController::class,'storeBalance']);
    });

    /*Route::middleware(['role:wallet_transfer'])->group(function (){
        Route::get('/wallet/transfer',[WalletTransferController::class,'index']);
        Route::post('/wallet/transfer',[WalletTransferController::class,'store']);
    });*/

    Route::middleware(['role:wallet_transactions'])->get('/wallet/transactions',[WalletController::class,'transactions']);

    Route::post('/file/upload',[DropzoneController::class,'upload']);

    Route::get('/topups/bulk', [WizardController::class,'index']);
    Route::get('/topups/bulk/wizard/template', [WizardController::class,'getTemplate']);
    Route::get('/topups/bulk/wizard/start/file/{id}', [WizardController::class,'start']);
    Route::post('/topups/bulk/wizard/start/file/{id}', [WizardController::class,'process']);
    Route::post('/topups/bulk/wizard/entry/delete/{id}', [WizardController::class,'deleteEntry']);
    Route::get('/topups/bulk/wizard/schedule/file/{id}',[WizardController::class,'schedule']);
    Route::post('/topups/bulk/wizard/schedule/file/{id}',[WizardController::class,'scheduleTopup']);
    Route::get('/topups/bulk/operators/{id}', [WizardController::class,'getOperators']);



});
