<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // TODO: Добавить кеширование популярных запросов
    
    /**
     * Показать главную страницу.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Получить рекомендуемые мероприятия (опубликованные и ближайшие по дате)
        $featured_events = Event::where('status', 'published')
            ->where('start_date', '>=', now()) // Убедимся что не показываем прошедшие события
            ->orderBy('start_date')
            ->take(6) // Берем только 6 событий, чтобы страница не была перегружена
            ->get();

        // Получить категории с количеством мероприятий
        // Используем withCount - это круто, лучше чем делать count в цикле!
        $categories = Category::withCount(['events' => function($query) {
            $query->where('status', 'published');
        }])
        ->orderBy('events_count', 'desc')
        ->take(5)
        ->get();

        // Получить популярные местоположения с количеством мероприятий
        $locations = Location::withCount(['events' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('events_count', 'desc')
            ->take(5)
            ->get();
        
        // Вернуть представление с данными
        // compact создает массив из переменных - очень удобно!
        return view('home', [
            'featuredEvents' => $featured_events, 
            'categories' => $categories, 
            'locations' => $locations
        ]);
    }
}
