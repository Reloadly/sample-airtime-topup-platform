<?php

namespace App\Console\Commands;

use Exception;
use App\Models\User;
use App\Models\Country;
use Illuminate\Console\Command;

class SyncCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Countries with the Reloadly platform';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("");
        $this->line("****************************************************************");
        $this->info("Started Sync of Countries with Reloadly Platform");
        $this->line("****************************************************************");
        $this->line("Fetching Countries list from Reloadly");
        try{
            $countries = User::admin()->getCountries();
            $this->info("Fetching Complete.");
            $this->line("Syncing with database.");
            foreach ($countries as $country) {
                Country::query()->updateOrCreate(
                    ['iso' => $country['isoName']],
                    [
                        'name' => $country['name'],
                        'currency_code' => $country['currencyCode'],
                        'currency_name' => $country['currencyName'],
                        'currency_symbol' => $country['currencySymbol'],
                        'flag' => $country['flag'],
                        'calling_codes' => $country['callingCodes']
                    ]
                );
            }
            $this->line("****************************************************************");
            $this->info("Sync Complete !!! ".count($countries)." Countries Synced.");
        }catch (Exception $exception){
            $this->error($exception->getMessage());
        }
        $this->line("****************************************************************");
        $this->line("");
        return 0;
    }
}
