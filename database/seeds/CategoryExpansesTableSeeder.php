<?php

use Illuminate\Database\Seeder;

class CategoryExpansesTableSeeder extends Seeder
{
    use \CodeFin\Repositories\GetClientsTrait;

    public function run()
    {
        $clients = $this->getClients();

        factory(\CodeFin\Models\CategoryExpense::class, 30)
            ->make()
            ->each(function($category) use ($clients){
                $client = $clients->random();
                $category->client_id = $client->id;
                $category->save();
            });

        $categoriesRoot = $this->getCategoriesRoot();

        foreach ($categoriesRoot as $root) {
            factory(\CodeFin\Models\CategoryExpense::class, 3)
                ->make()
                ->each(function($child) use ($root) {
                    $child->client_id = $root->client_id;
                    $child->save();
                    $child->parent()->associate($root);
                    $child->save();
                });
        }
    }

    private function getCategoriesRoot()
    {
        /** @var \CodeFin\Repositories\CategoryExpenseRepository $repository */
        $repository = app(\CodeFin\Repositories\CategoryExpenseRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }
}