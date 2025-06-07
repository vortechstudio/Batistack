<?php

namespace App\Jobs\Core;

use App\Enum\Core\UserRole;
use App\Models\Core\BanqueAggregate;
use App\Models\Core\BanqueAggregateMouvement;
use App\Models\Core\Company;
use App\Models\User;
use App\Notifications\Core\AggregateAccountNotificationSuccessful;
use App\Services\Bridges\Api;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AggregateBankMouvement implements ShouldQueue
{
    use Queueable;
    private string $token;
    public Api $api;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public BanqueAggregate $banque,
    )
    {
        $this->api = new Api();
        $this->getAccessToken();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->banque->accounts as $account) {
            $transactions = $this->api->get('aggregation/transactions?limit=500&account_id=' . $account->id, [], $this->token);

            foreach ($transactions['resources'] as $transaction) {
                BanqueAggregateMouvement::updateOrCreate([
                    'transaction_id' => $transaction['id'],
                ], [
                    'title' => $transaction['clean_description'],
                    'description' => $transaction['provider_description'],
                    'amount' => $transaction['amount'],
                    'date' => $transaction['date'],
                    'booking_date' => $transaction['booking_date'] ?? null,
                    'transaction_date' => $transaction['transaction_date'] ?? null,
                    'value_date' => $transaction['value_date'] ?? null,
                    'category_id' => $transaction['category_id'] ?? null,
                    'operation_type' => $transaction['operation_type'] ?? null,
                    'future' => $transaction['future'],
                    'banque_aggregate_account_id' => $account->id,
                ]);
            }
        }
        foreach (User::where('role', UserRole::ADMINISTRATEUR)->orWhere('role', UserRole::COMPTABILITE)->get() as $user) {
            $user->notify(new AggregateAccountNotificationSuccessful());
        }
    }

    private function getAccessToken()
    {
        $this->token = $this->api->post('aggregation/authorization/token', [
            'user_uuid' => Company::first()->info->bridge_client_id,
        ])['access_token'];
    }
}
