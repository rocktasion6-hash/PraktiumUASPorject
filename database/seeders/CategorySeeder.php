<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Kuliah',
            'color' => 'blue'
        ]);

        Category::create([
            'name' => 'Organisasi',
            'color' => 'green'
        ]);

        Category::create([
            'name' => 'Pribadi',
            'color' => 'red'
        ]);

        Category::create([
            'name' => 'Kerja',
            'color' => 'yellow'
        ]);
    }
}