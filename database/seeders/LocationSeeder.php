<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Концертный зал "Гармония"',
                'address' => 'ул. Музыкальная, 15',
                'city' => 'Москва',
                'country' => 'Россия',
                'postal_code' => '123456',
                'latitude' => 55.7558,
                'longitude' => 37.6176,
                'description' => 'Современный концертный зал с отличной акустикой и вместимостью до 1000 человек.'
            ],
            [
                'name' => 'Выставочный центр "Арт-Пространство"',
                'address' => 'пр. Ленина, 42',
                'city' => 'Санкт-Петербург',
                'state' => 'Ленинградская обл.',
                'country' => 'Россия',
                'postal_code' => '198000',
                'latitude' => 59.9343,
                'longitude' => 30.3351,
                'description' => 'Многофункциональное пространство для выставок и культурных мероприятий.'
            ],
            [
                'name' => 'Конференц-центр "Бизнес-Плаза"',
                'address' => 'ул. Предпринимательская, 78',
                'city' => 'Екатеринбург',
                'country' => 'Россия',
                'postal_code' => '620000',
                'latitude' => 56.8389,
                'longitude' => 60.6057,
                'description' => 'Современный деловой центр с конференц-залами различной вместимости.'
            ],
            [
                'name' => 'Спортивный комплекс "Олимп"',
                'address' => 'ул. Спортивная, 100',
                'city' => 'Казань',
                'country' => 'Россия',
                'postal_code' => '420000',
                'latitude' => 55.7887,
                'longitude' => 49.1221,
                'description' => 'Многофункциональный спортивный комплекс с трибунами и разнообразными площадками.'
            ],
            [
                'name' => 'Парк культуры и отдыха "Зелёный остров"',
                'address' => 'ул. Парковая, 5',
                'city' => 'Нижний Новгород',
                'country' => 'Россия',
                'postal_code' => '603000',
                'latitude' => 56.3268,
                'longitude' => 44.0075,
                'description' => 'Живописный парк с открытыми площадками для проведения фестивалей и культурных мероприятий.'
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
} 