<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use App\Models\Organizer;
use Illuminate\Http\Request;

/**
 * Контроллер административной панели
 * Лабораторная работа №3 - Иванов И.И. ИС-31
 */
class DashboardController extends Controller
{
    // Количество мероприятий для отображения в последних добавленных
    private $latest_events_count = 5;

    /**
     * Показать панель управления администратора.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Счетчики для статистики
        // Считаем общее количество каждой сущности
        $events_count = Event::count();
        $categories_count = Category::count();
        $locations_count = Location::count();
        $organizers_count = Organizer::count();

        // Последние мероприятия
        // Сортировка по дате создания и ограничение количества
        $latestEvents = Event::latest()
            ->take($this->latest_events_count)
            ->get();

        // Популярные категории (по количеству связанных мероприятий)
        $popularCategories = $this->getPopularCategories();

        // Статистика по статусам мероприятий
        // TODO: Добавить график распределения статусов мероприятий
        $eventsStatusCount = [
            'published' => Event::where('status', 'published')->count(),
            'draft' => Event::where('status', 'draft')->count(),
            'cancelled' => Event::where('status', 'cancelled')->count(),
        ];

        return view('admin.dashboard', [
            'eventsCount' => $events_count,
            'categoriesCount' => $categories_count,
            'locationsCount' => $locations_count,
            'organizersCount' => $organizers_count,
            'latestEvents' => $latestEvents,
            'popularCategories' => $popularCategories,
            'eventsStatusCount' => $eventsStatusCount,
        ]);
    }

    /**
     * Получает популярные категории
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getPopularCategories()
    {
        return Category::withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(5)
            ->get();
    }
}
