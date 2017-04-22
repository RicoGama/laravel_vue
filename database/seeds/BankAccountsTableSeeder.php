<?php

use Illuminate\Database\Seeder;

class BankAccountsTableSeeder extends Seeder
{
    use \CodeFin\Repositories\GetClientsTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = $this->getBanks();
        $clients = $this->getClients();
        $max = 50;
        $bankAccountId = rand(1, $max);
        factory(\CodeFin\Models\BankAccount::class, $max)
            ->make()
            ->each(function($bankAccount) use ($banks, $bankAccountId, $clients) {
                $bank = $banks->random();
                $client = $clients->random();

                $bankAccount->bank_id = $bank->id;
                $bankAccount->client_id = $client->id;

                $bankAccount->save();

                if ($bankAccountId == $bankAccount->id) {
                    $bankAccount->default = 1;
                    $bankAccount->save();
                }
            });
    }

    private function getBanks()
    {
        /** @var \CodeFin\Repositories\BankRepository $repository */
        $repository = app(\CodeFin\Repositories\BankRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }
}
