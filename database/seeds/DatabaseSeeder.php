<?php

use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        factory(App\User::class, 1000)->create();
        factory(App\Category::class, 30)->create();

        factory(App\Product::class, 1000)->create()->each(function ($product) {
            $categories = Category::all()->random(random_int(1, 5))->pluck('id');
            $product->categories()->attach($categories);
        });
        factory(App\Transaction::class, 1000)->create();
    }
}
