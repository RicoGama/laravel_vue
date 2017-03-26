<?php

use CodeFin\Models\BillReceive;
use CodeFin\Repositories\BillReceivesRepository;
use Illuminate\Database\Seeder;

class BillReceivesTableSeeder extends Seeder
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

        $repository = app(BillReceivesRepository::class);
        factory(BillReceive::class, 200)
            ->make()
            ->each(function ($billReceives) use ($clients, $repository) {
                $client = $clients->random();
                \Landlord::addTenant($client);
                $bankAccount = $client->bankAccounts->random();
                $category = $client->categoryExpanses->random();
                $billReceives->client_id = $client->id;
                $billReceives->bank_account_id = $bankAccount->id;
                $billReceives->category_id = $category->id;
                $data = $billReceives->toArray();
                $repository->create($data);
            });
    }
}
