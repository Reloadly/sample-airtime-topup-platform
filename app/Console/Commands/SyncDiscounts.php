<?php

namespace App\Console\Commands;

use App\Models\Discount;
use App\Models\Operator;
use App\Models\Country;
use App\Models\User;
use Illuminate\Console\Command;

class SyncDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:discounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Operators Discount with the Reloadly Platform';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("");
        $this->line("****************************************************************");
        $this->info("Started Sync of Operators Discount with Reloadly Platform");
        $this->line("****************************************************************");
        $page=1;
        do{
            $this->line("Fetching Discounts Page : ".$page);
            $response = User::admin()->getOperatorsDiscount($page);
            $this->info("Fetch Success !!!");
            $page++;
            $this->line("Syncing with Database");
            //print_r($response->content);
            foreach ($response->content as $discount){
                if (@$discount->operator->operatorId){
                    $operatorId = Operator::where('rid',$discount->operator->operatorId)->first()['id'];
                    if($operatorId) {
                        Discount::updateOrCreate(
                            ['rid' => @$discount->operator->operatorId],
                            [
                                'rid' => $discount->operator->operatorId,
                                'operator_id' => $operatorId,
                                'percentage' => $discount->percentage,
                                'international_percentage' => $discount->internationalPercentage,
                                'local_percentage' => $discount->localPercentage,
                                'updated_at' => $discount->updatedAt
                            ]
                        );
                    }
                }
            }
            $this->info("Sync Completed For ".sizeof($response->content)." Discounts");
        }while($response->totalPages >= $page);
        $this->line("****************************************************************");
        $this->info("All Discounts Synced !!! ");
        $this->line("****************************************************************");
        $this->line("");
    }
}
