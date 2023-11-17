<?php

namespace App\Console\Commands;

use Exception;
use App\Models\User;
use App\Models\Discount;
use App\Models\Operator;
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
        do {
            $this->line("Fetching Discounts Page : ".$page);
            $response = User::admin()->getOperatorsDiscount($page);
            $this->info("Fetch Success !!!");
            $page++;
            $this->line("Syncing with Database");
            foreach ($response['content'] as $discount) {
                try{
                    if (isset($discount['operator']['operatorId'])) {
                        $operator = Operator::query()
                            ->where('rid', $discount['operator']['operatorId'])
                            ->first();
                        Discount::query()->updateOrCreate(
                            ['rid' => $discount['operator']['operatorId']],
                            [
                                'rid' => $discount['operator']['operatorId'],
                                'operator_id' => $operator['id'],
                                'percentage' => $discount['percentage'],
                                'international_percentage' => $discount['internationalPercentage'],
                                'local_percentage' => $discount['localPercentage'],
                                'updated_at' => $discount['updatedAt']
                            ]
                        );
                    }
                }catch (Exception $exception){
                    $this->error('Operator not found '.$discount['operator']['name']);
                }
            }
            $this->info("Sync Completed For ".count($response['content'])." Discounts");
        } while ($response['totalPages'] >= $page);
        $this->line("****************************************************************");
        $this->info("All Discounts Synced !!! ");
        $this->line("****************************************************************");
        $this->line("");
        return 0;
    }
}
