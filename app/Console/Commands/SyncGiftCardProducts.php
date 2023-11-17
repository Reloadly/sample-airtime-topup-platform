<?php

namespace App\Console\Commands;

use Exception;
use App\Models\User;
use App\Models\Country;
use Illuminate\Console\Command;
use App\Models\GiftCardProduct;
use OTIFSolutions\ACLMenu\Models\UserRole;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class SyncGiftCardProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:gift_products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Gift Products with the Reloadly Platform';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("");
        $this->line("****************************************************************");
        $this->info("Started Sync of Gift Products with Reloadly Platform");
        $this->line("****************************************************************");

        try {
            $page = 1;
            do {
                $this->line("Fetching Gift Products Page : ".$page);
                $response = User::admin()->getReloadlyGiftProducts($page);
                $this->info("Fetch Success !!!");
                $page++;
                $this->line("Syncing with Database");
                foreach ($response['content'] as $product) {
                    if (isset($product['productId'], $product['country']['isoName'])) {
                        $country = Country::query()
                            ->where('iso', $product['country']['isoName'])
                            ->first();
                        if (!$country) {
                            $country = Country::query()->updateOrCreate(['iso' => $product['country']['isoName']], [
                                'name' => $product['country']['name'],
                                'flag' => $product['country']['flagUrl'],
                                'currency_code' => $product['recipientCurrencyCode'],
                                'currency_name' => $product['recipientCurrencyCode'],
                                'currency_symbol' => $product['recipientCurrencyCode'],
                                'calling_codes' => []
                            ]);
                        }
                        GiftCardProduct::query()->updateOrCreate(
                            ['rid' => $product['productId']],
                            [
                                'rid' => $product['productId'],
                                'country_id' => $country['id'],
                                'title' => $product['productName'],
                                'is_global' => $product['global'],
                                'sender_fee' => $product['senderFee'],
                                'discount_percentage' => $product['discountPercentage'],
                                'denomination_type' => $product['denominationType'],
                                'recipient_currency_code' => $product['recipientCurrencyCode'],
                                'min_recipient_denomination' => $product['minRecipientDenomination'],
                                'max_recipient_denomination' => $product['maxRecipientDenomination'],
                                'sender_currency_code' => $product['senderCurrencyCode'],
                                'min_sender_denomination' => $product['minSenderDenomination'],
                                'max_sender_denomination' => $product['maxSenderDenomination'],
                                'fixed_recipient_denominations' => $product['fixedRecipientDenominations'],
                                'fixed_sender_denominations' => $product['fixedSenderDenominations'],
                                'fixed_denominations_map' => $product['fixedRecipientToSenderDenominationsMap'],
                                'logo_urls' => $product['logoUrls'],
                                'brand' => $product['brand'],
                                'country' => $product['country'],
                                'redeem_instruction' => $product['redeemInstruction'],
                            ]
                        );
                    }
                }
                $this->info("Sync Completed For ".count($response['content'])." Gift Products");
            } while ($response['totalPages'] >= $page);
            $this->line("****************************************************************");
            $this->info("All Gift Products Synced !!! ");
            $this->line("Re-Syncing Reseller User's Rates");
            $role = UserRole::query()->where('name', 'RESELLER')->first();
            $resellers = User::query()->where('user_role_id', $role['id'])->get();
            foreach ($resellers as $reseller) {
                $exists = $reseller->gift_cards()->pluck('id');
                $products = GiftCardProduct::query()->whereNotIn('id', $exists)->pluck('id');
                $reseller->gift_cards()->syncWithoutDetaching($products);
                $userGiftCards = $reseller->gift_cards()->whereIn('id', $products)->get();
                foreach ($userGiftCards as $giftCard) {
                    $giftCard->pivot->discount = $giftCard['discount_percentage'] * (Setting::get('reseller_discount') / 100);
                    $giftCard->pivot->save();
                }
            }
        }catch (Exception $exception){
            $this->error($exception->getMessage());
        }
        $this->line("****************************************************************");
        $this->line("");
        return 0;
    }
}
