<?php

namespace Database\Seeders;

use App\Models\Organizer;
use Illuminate\Database\Seeder;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizers = [
            [
                'name' => 'АртПродакшн',
                'email' => 'info@artprod.ru',
                'phone' => '+7 (999) 123-45-67',
                'website' => 'https://artprod.ru',
                'description' => 'Организация концертов и фестивалей с 2010 года.'
            ],
            [
                'name' => 'Бизнес Форум',
                'email' => 'contact@bizforum.ru',
                'phone' => '+7 (495) 987-65-43',
                'website' => 'https://bizforum.ru',
                'description' => 'Организация бизнес-мероприятий, конференций и деловых встреч.'
            ],
            [
                'name' => 'СпортИвент',
                'email' => 'info@sportevent.ru',
                'phone' => '+7 (812) 456-78-90',
                'website' => 'https://sportevent.ru',
                'description' => 'Проведение спортивных соревнований и турниров различного уровня.'
            ],
            [
                'name' => 'Арт-Галерея "Импрессио"',
                'email' => 'gallery@impressio.ru',
                'phone' => '+7 (343) 111-22-33',
                'website' => 'https://impressio.ru',
                'description' => 'Организация художественных выставок и культурных мероприятий.'
            ],
            [
                'name' => 'Образовательный центр "Эврика"',
                'email' => 'info@evrika.edu',
                'phone' => '+7 (831) 555-44-33',
                'website' => 'https://evrika.edu',
                'description' => 'Проведение образовательных мастер-классов и семинаров для всех возрастов.'
            ],
        ];

        foreach ($organizers as $organizer) {
            Organizer::create($organizer);
        }
    }
} 