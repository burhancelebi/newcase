<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = file_get_contents(public_path('json/products.json'));
        $products = json_decode($file);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::query()->truncate();

        foreach ($products as $product)
        {
            Product::query()->create([
                'name' => $product->name ?? $product->description,
                'category' => $product->category,
                'price' => $product->price,
                'stock' => $product->stock,
            ]);
        }
    }
}
