<?php

use App\Http\Controllers\GiftCardProductsController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\OperatorsController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('get_token', [ApiController::class,'getToken']);

Route::middleware(['auth:api','ipr'])->group(function () {
    Route::get('countries', [CountriesController::class, 'getAll']);
    Route::get('operators', [ApiController::class,'operators']);
    Route::get('countries/{id}/operators', [CountriesController::class, 'getOperatorsForCountry']);
    Route::get('operators/{id}', [OperatorsController::class, 'get']);
    Route::get('countries/{id}/operators/detect/{number}', [OperatorsController::class, 'detect']);
    Route::get('currencies', [CurrenciesController::class, 'getAll']);
    Route::post('topup', [ApiController::class,'sendTopUp']);
    Route::get('transactions',[TransactionsController::class,'index']);
    Route::get('transactions/id/{ref}',[TransactionsController::class,'showById']);
    Route::get('transactions/reference/{ref}',[TransactionsController::class,'showByRef']);
    Route::post('gift_cards/receipt',[GiftCardProductsController::class,'createInvoice']);

    Route::get('gift_cards/products',[GiftCardProductsController::class,'getGiftCardProducts']);
    Route::get('gift_cards/products/{id}',[GiftCardProductsController::class,'getGiftCardProductById']);
    Route::post('gift_cards/order',[GiftCardProductsController::class,'orderGiftCardProduct']);
});
