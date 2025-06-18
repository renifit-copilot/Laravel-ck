<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use App\Models\Organizer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Показать панель управления администратора.
     */
    public function index()
    {
        // Счетчики для статистики
        $eventsCount = Event::count();
        $categoriesCount = Category::count();
        $locationsCount = Location::count();
        $organizersCount = Organizer::count();

        // Последние мероприятия
        $latestEvents = Event::latest()->take(5)->get();

        // Популярные категории
        $popularCategories = Category::withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'eventsCount',
            'categoriesCount',
            'locationsCount',
            'organizersCount',
            'latestEvents',
            'popularCategories'
        ));
    }
}
