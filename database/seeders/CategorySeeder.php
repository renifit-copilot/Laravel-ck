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
            [
                'name' => 'Концерты',
                'description' => 'Музыкальные концерты различных жанров и направлений',
            ],
            [
                'name' => 'Фестивали',
                'description' => 'Многодневные мероприятия с разнообразной программой',
            ],
            [
                'name' => 'Выставки',
                'description' => 'Художественные, исторические и тематические выставки',
            ],
            [
                'name' => 'Конференции',
                'description' => 'Бизнес-мероприятия, встречи профессионалов, лекции',
            ],
            [
                'name' => 'Мастер-классы',
                'description' => 'Практические занятия по различным направлениям искусства и ремесел',
            ],
            [
                'name' => 'Спортивные мероприятия',
                'description' => 'Соревнования, турниры, спортивные шоу',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
} 