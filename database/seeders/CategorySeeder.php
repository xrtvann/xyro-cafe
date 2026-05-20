<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Coffee'],
            ['name' => 'Non-Coffee'],
            ['name' => 'Pastry & Food'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'id' => Str::uuid()->toString(),
                    'name' => $cat['name'],
                    'is_active' => true,
                ]
            );
        }
    }
}
