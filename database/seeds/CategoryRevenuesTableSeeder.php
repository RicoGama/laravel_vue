<?php

use Illuminate\Database\Seeder;

class CategoryRevenuesTableSeeder extends Seeder
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

        factory(\CodeFin\Models\CategoryRevenue::class, 30)
            ->make()
            ->each(function ($category) use ($clients) {
                $client = $clients->random();
                $category->client_id = $client->id;
                $category->save();
            });

        $categoriesRoot = $this->getCategoriesRoot();

        foreach ($categoriesRoot as $root) {
            factory(\CodeFin\Models\CategoryRevenue::class, 3)
                ->make()
                ->each(function ($child) use ($root) {
                    $child->client_id = $root->client_id;
                    $child->save();
                    $child->parent()->associate($root);
                    $child->save();
                });
        }
    }

    private function getCategoriesRoot()
    {
        /** @var \CodeFin\Repositories\CategoryRevenueRepository $repository */
        $repository = app(\CodeFin\Repositories\CategoryRevenueRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }
}
