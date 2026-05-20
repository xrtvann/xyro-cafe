<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coffeeCat = Category::where('name', 'Coffee')->first();
        $nonCoffeeCat = Category::where('name', 'Non-Coffee')->first();
        $pastryCat = Category::where('name', 'Pastry & Food')->first();

        // If categories don't exist yet, we should exit or ideally run CategorySeeder first
        if (!$coffeeCat || !$nonCoffeeCat || !$pastryCat) {
            $this->command->error('Please run CategorySeeder first.');
            return;
        }

        $products = [
            // Coffee
            [
                'name' => 'Caramel Macchiato',
                'description' => 'Espresso with vanilla-flavored syrup, milk and caramel drizzle.',
                'price' => 45000,
                'stock_quantity' => 50,
                'category_id' => $coffeeCat->id,
            ],
            [
                'name' => 'Americano',
                'description' => 'Espresso shots topped with hot water create a light layer of crema.',
                'price' => 25000,
                'stock_quantity' => 100,
                'category_id' => $coffeeCat->id,
            ],
            [
                'name' => 'Cafe Latte',
                'description' => 'Dark, rich espresso lies in wait under a smoothed and stretched layer of thick milk foam.',
                'price' => 35000,
                'stock_quantity' => 75,
                'category_id' => $coffeeCat->id,
            ],
            [
                'name' => 'Cappuccino',
                'description' => 'Dark, rich espresso lies in wait under a smoothed and stretched layer of thick milk foam.',
                'price' => 35000,
                'stock_quantity' => 80,
                'category_id' => $coffeeCat->id,
            ],

            // Non-Coffee
            [
                'name' => 'Matcha Latte',
                'description' => 'Smooth and creamy matcha sweetened just right and served with steamed milk.',
                'price' => 40000,
                'stock_quantity' => 60,
                'category_id' => $nonCoffeeCat->id,
            ],
            [
                'name' => 'Chocolate Cream',
                'description' => 'Rich chocolate sauce, milk and ice blended, finished with whipped cream.',
                'price' => 38000,
                'stock_quantity' => 40,
                'category_id' => $nonCoffeeCat->id,
            ],
            [
                'name' => 'Lychee Tea',
                'description' => 'Refreshing black tea infused with lychee flavor, served over ice.',
                'price' => 28000,
                'stock_quantity' => 90,
                'category_id' => $nonCoffeeCat->id,
            ],

            // Pastry & Food
            [
                'name' => 'Butter Croissant',
                'description' => 'A classic, buttery, flaky French pastry.',
                'price' => 22000,
                'stock_quantity' => 30,
                'category_id' => $pastryCat->id,
            ],
            [
                'name' => 'Almond Croissant',
                'description' => 'A rich, flaky croissant filled with sweet almond paste and topped with sliced almonds.',
                'price' => 32000,
                'stock_quantity' => 25,
                'category_id' => $pastryCat->id,
            ],
            [
                'name' => 'Beef Quiche',
                'description' => 'A savory pie filled with beef, cheese, and a rich custard.',
                'price' => 45000,
                'stock_quantity' => 15,
                'category_id' => $pastryCat->id,
            ]
        ];

        foreach ($products as $item) {
            $id = Str::uuid()->toString();
            Product::firstOrCreate(
                ['name' => $item['name']],
                [
                    'id' => $id,
                    'category_id' => $item['category_id'],
                    'slug' => Str::slug($item['name']) . '-' . substr($id, 0, 8),
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'stock_quantity' => $item['stock_quantity'],
                    'image_url' => null, // Placeholder for later
                    'is_active' => true,
                    'low_stock_threshold' => 10,
                ]
            );
        }
    }
}
