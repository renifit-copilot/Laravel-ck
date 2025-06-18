<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    /**
     * Отображает список всех мероприятий с возможностью фильтрации.
     */
    public function index(Request $request)
    {
        $query = Event::query()
            ->where('status', 'published')
            ->with(['category', 'location', 'organizer']);
        
        // Фильтрация по категории
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Фильтрация по месту проведения
        if ($request->filled('location')) {
            $query->where('location_id', $request->location);
        }
        
        // Фильтрация по дате начала
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->where('start_date', '>=', $startDate);
        }
        
        // Фильтрация по дате окончания
        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->where('start_date', '<=', $endDate);
        }
        
        // Сортировка по дате (ближайшие сначала)
        $query->orderBy('start_date', 'asc');
        
        // Пагинация результатов
        $events = $query->paginate(9)->withQueryString();
        
        // Загружаем категории и локации для фильтров
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        
        return view('events.index', compact('events', 'categories', 'locations'));
    }

    /**
     * Показывает детальную информацию о мероприятии.
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'location', 'organizer'])
            ->firstOrFail();
        
        // Получаем похожие мероприятия из той же категории
        $relatedEvents = Event::where('status', 'published')
            ->where('id', '!=', $event->id)
            ->where('category_id', $event->category_id)
            ->with(['category', 'location'])
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();
        
        return view('events.show', compact('event', 'relatedEvents'));
    }
}
