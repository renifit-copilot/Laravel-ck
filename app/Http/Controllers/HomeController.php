<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Показать главную страницу.
     */
    public function index()
    {
        // Получить рекомендуемые мероприятия (опубликованные и ближайшие по дате)
        $featuredEvents = Event::where('status', 'published')
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(6)
            ->get();

        // Получить категории с количеством мероприятий
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

        return view('home', compact('featuredEvents', 'categories', 'locations'));
    }
}
