<?php

namespace Database\Seeders;

use App\Models\testingExport\Product;
use App\Models\testingExport\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExportSeeder extends Seeder
{
    public function __construct()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function run()
    {
        ProductCategory::create(['name' => 'Toys']);
        ProductCategory::create(['name' => 'Gadgets']);

    //     Product::create([
    //         'name' => 'Barbie',
    //         'description' => 'Best doll',
    //         'price' => 19.99,
    //         'product_category_id' => 1
    //     ]);
    //     Product::create([
    //         'name' => 'Lego',
    //         'description' => 'Best constructor',
    //         'price' => 49.99,
    //         'product_category_id' => 1
    //     ]);
    //     Product::create([
    //         'name' => 'iPhone',
    //         'description' => 'Apple phone',
    //         'price' => 1099.99,
    //         'product_category_id' => 2
    //     ]);
    //     Product::create([
    //         'name' => 'Samsung Galaxy Buds',
    //         'description' => 'Best Earphones',
    //         'price' => 199.99,
    //         'product_category_id' => 2
    //     ]);

        // Insert 1 million records in batches of 50
        for ($i = 0; $i < 40000; $i++) {
            $products = [];

            // Create 50 products
            for ($j = 0; $j < 50; $j++) {
                $products[] = [
                    'name' => 'Product ' . ($i * 50 + $j + 1), // Generate unique name for each product
                    'description' => 'Description for product ' . ($i * 50 + $j + 1),
                    'price' => rand(10, 1000), // Random price between 10 and 1000
                    'product_category_id' => rand(1, 2), // Randomly select category ID 1 or 2
                ];
            }

            // Bulk insert the products
            Product::insert($products);
        }
    }

}
