<?php

use CodeFin\Repositories\BillPayRepository;
use Illuminate\Database\Seeder;

class BillPaysTableSeeder extends Seeder
{
    use \CodeFin\Repositories\GetClientsTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = $this->getClients();

        $repository = app(BillPayRepository::class);
        factory(\CodeFin\Models\BillPay::class, 200)
            ->make()
            ->each(function ($billPay) use ($clients, $repository) {
                $client = $clients->random();
                \Landlord::addTenant($client);
                $bankAccount = $client->bankAccounts->random();
                $category = $client->categoryExpanses->random();
                $billPay->client_id = $client->id;
                $billPay->bank_account_id = $bankAccount->id;
                $billPay->category_id = $category->id;
                $data = $billPay->toArray();
                $repository->create($data);
            });
    }
}
