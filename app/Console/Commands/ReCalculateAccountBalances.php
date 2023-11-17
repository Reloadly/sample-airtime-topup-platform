<?php

namespace App\Console\Commands;

use Exception;
use App\Models\User;
use Illuminate\Console\Command;

class ReCalculateAccountBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $users = User::query()
                ->where('user_role_id', 2)
                ->with('account_transactions')
                ->get();
            $this->withProgressBar($users, function ($user) {
                $transactions = $user['account_transactions']->sortBy('id');
                $balance = 0;
                foreach ($transactions as $transaction) {
                    if ($transaction['type'] === "CREDIT") {
                        $balance += $transaction['amount'];
                    } else {
                        $balance -= $transaction['amount'];
                    }
                    if ($transaction['ending_balance'] !== $balance) {
                        $transaction['ending_balance'] = $balance;
                        $transaction->save();
                    }
                }
            });
        }catch (Exception $exception){
            $this->error($exception->getMessage());
        }
        $this->line(' ');
        return 0;
    }
}
