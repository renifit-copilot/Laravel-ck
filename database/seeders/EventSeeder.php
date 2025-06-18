<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use App\Models\Organizer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $locations = Location::all();
        $organizers = Organizer::all();
        
        $events = [
            [
                'title' => 'Концерт симфонического оркестра',
                'description' => 'Насладитесь классической музыкой в исполнении симфонического оркестра под руководством известного дирижера.',
                'start_date' => Carbon::now()->addDays(10)->setTime(19, 0),
                'end_date' => Carbon::now()->addDays(10)->setTime(21, 30),
                'status' => 'published',
                'category_id' => $categories->where('name', 'Концерты')->first()->id,
                'location_id' => $locations->where('name', 'Концертный зал "Гармония"')->first()->id,
                'organizer_id' => $organizers->where('name', 'АртПродакшн')->first()->id,
                'additional_info' => 'В программе произведения Моцарта, Бетховена, Чайковского. Рекомендуется классический стиль одежды.'
            ],
            [
                'title' => 'Фестиваль уличной культуры',
                'description' => 'Масштабный фестиваль уличной культуры с граффити, брейк-дансом, скейтбордингом и выступлениями хип-хоп исполнителей.',
                'start_date' => Carbon::now()->addDays(15)->setTime(12, 0),
                'end_date' => Carbon::now()->addDays(15)->setTime(23, 0),
                'status' => 'published',
                'category_id' => $categories->where('name', 'Фестивали')->first()->id,
                'location_id' => $locations->where('name', 'Парк культуры и отдыха "Зелёный остров"')->first()->id,
                'organizer_id' => $organizers->where('name', 'АртПродакшн')->first()->id,
                'additional_info' => 'Приходите в удобной одежде. На территории работают фуд-корты и точки продажи воды.'
            ],
            [
                'title' => 'Бизнес-конференция "Инновации 2023"',
                'description' => 'Ежегодная конференция для предпринимателей и руководителей бизнеса с обсуждением актуальных трендов и инноваций.',
                'start_date' => Carbon::now()->addDays(20)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(21)->setTime(18, 0),
                'status' => 'published',
                'category_id' => $categories->where('name', 'Конференции')->first()->id,
                'location_id' => $locations->where('name', 'Конференц-центр "Бизнес-Плаза"')->first()->id,
                'organizer_id' => $organizers->where('name', 'Бизнес Форум')->first()->id,
                'additional_info' => 'Для участия необходима предварительная регистрация. Бизнес-дресс-код.'
            ],
            [
                'title' => 'Выставка современного искусства',
                'description' => 'Выставка работ молодых художников, представляющая различные направления современного искусства.',
                'start_date' => Carbon::now()->addDays(7)->setTime(11, 0),
                'end_date' => Carbon::now()->addDays(28)->setTime(19, 0),
                'status' => 'published',
                'category_id' => $categories->where('name', 'Выставки')->first()->id,
                'location_id' => $locations->where('name', 'Выставочный центр "Арт-Пространство"')->first()->id,
                'organizer_id' => $organizers->where('name', 'Арт-Галерея "Импрессио"')->first()->id,
                'additional_info' => 'Выставка работает ежедневно, кроме понедельника. Билеты можно приобрести онлайн или на месте.'
            ],
            [
                'title' => 'Мастер-класс по гончарному делу',
                'description' => 'Практический мастер-класс по созданию керамических изделий под руководством опытного мастера.',
                'start_date' => Carbon::now()->addDays(12)->setTime(15, 0),
                'end_date' => Carbon::now()->addDays(12)->setTime(18, 0),
                'status' => 'published',
                'category_id' => $categories->where('name', 'Мастер-классы')->first()->id,
                'location_id' => $locations->where('name', 'Выставочный центр "Арт-Пространство"')->first()->id,
                'organizer_id' => $organizers->where('name', 'Образовательный центр "Эврика"')->first()->id,
                'additional_info' => 'Все материалы предоставляются. Рекомендуется взять с собой фартук и сменную обувь.'
            ],
            [
                'title' => 'Городской марафон',
                'description' => 'Ежегодный марафон по историческому центру города с профессиональным хронометражем и поддержкой участников.',
                'start_date' => Carbon::now()->addDays(25)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(25)->setTime(15, 0),
                'status' => 'published',
                'category_id' => $categories->where('name', 'Спортивные мероприятия')->first()->id,
                'location_id' => $locations->where('name', 'Спортивный комплекс "Олимп"')->first()->id,
                'organizer_id' => $organizers->where('name', 'СпортИвент')->first()->id,
                'additional_info' => 'Регистрация участников заканчивается за 3 дня до мероприятия. Выдача стартовых пакетов с 7:00.'
            ],
            [
                'title' => 'Джазовый вечер',
                'description' => 'Атмосферный вечер джазовой музыки с выступлением известного квартета и приглашенными солистами.',
                'start_date' => Carbon::now()->addDays(8)->setTime(20, 0),
                'end_date' => Carbon::now()->addDays(8)->setTime(23, 0),
                'status' => 'published',
                'category_id' => $categories->where('name', 'Концерты')->first()->id,
                'location_id' => $locations->where('name', 'Концертный зал "Гармония"')->first()->id,
                'organizer_id' => $organizers->where('name', 'АртПродакшн')->first()->id,
            ],
            [
                'title' => 'Технологическая выставка "Будущее сегодня"',
                'description' => 'Выставка новейших технологических разработок от ведущих компаний и стартапов.',
                'start_date' => Carbon::now()->addDays(30)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(32)->setTime(18, 0),
                'status' => 'draft',
                'category_id' => $categories->where('name', 'Выставки')->first()->id,
                'location_id' => $locations->where('name', 'Конференц-центр "Бизнес-Плаза"')->first()->id,
                'organizer_id' => $organizers->where('name', 'Бизнес Форум')->first()->id,
            ],
            [
                'title' => 'Детский турнир по шахматам',
                'description' => 'Городской турнир по шахматам среди детей школьного возраста с ценными призами и подарками.',
                'start_date' => Carbon::now()->addDays(18)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(18)->setTime(17, 0),
                'status' => 'cancelled',
                'category_id' => $categories->where('name', 'Спортивные мероприятия')->first()->id,
                'location_id' => $locations->where('name', 'Спортивный комплекс "Олимп"')->first()->id,
                'organizer_id' => $organizers->where('name', 'СпортИвент')->first()->id,
            ],
        ];

        foreach ($events as $eventData) {
            $event = new Event($eventData);
            $event->slug = Str::slug($eventData['title']);
            $event->save();
        }
    }
} 