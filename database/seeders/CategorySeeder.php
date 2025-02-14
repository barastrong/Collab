<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Kaos'],
            ['name' => 'Kemeja'],
            ['name' => 'Celana'],
            ['name' => 'Jaket'],
            ['name' => 'Dress']
        ];
    
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}