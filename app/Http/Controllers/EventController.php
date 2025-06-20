<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    protected $eventsPerPage = 9; // Константа для пагинации

    /**
     * Отображает список всех мероприятий с возможностью фильтрации.
     * 
     * Эта функция получает список мероприятий с учетом фильтров
     * Вообще тут можно было бы использовать Form Request для валидации,
     * но для этого проекта так тоже подойдет
     */
    public function index(Request $request)
    {
        // Базовый запрос с подгрузкой связанных моделей (eager loading)
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

        // TODO: Добавить поиск по названию мероприятия
        
        // Сортировка по дате (ближайшие сначала)
        $query->orderBy('start_date', 'asc');
        
        // Пагинация результатов
        // $events = $query->paginate(9)->withQueryString();
        // Используем свойство класса для количества элементов на странице
        $events = $query->paginate($this->eventsPerPage)->withQueryString();
        
        // Загружаем категории и локации для фильтров
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        
        return view('events.index', compact('events', 'categories', 'locations'));
    }

    /**
     * Показывает детальную информацию о мероприятии.
     * 
     * @param string $slug URL-идентификатор мероприятия
     * @return \Illuminate\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException если мероприятие не найдено
     */
    public function show($slug)
    {
        // Находим мероприятие по slug и проверяем что оно опубликовано
        $event = Event::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'location', 'organizer'])
            ->firstOrFail();
        
        // Получаем похожие мероприятия из той же категории
        $similar_events = Event::where('status', 'published')
            ->where('id', '!=', $event->id) // Исключаем текущее мероприятие
            ->where('category_id', $event->category_id)
            ->with(['category', 'location'])
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();
        
        /* 
        // Можно было бы добавить счетчик просмотров
        Event::where('id', $event->id)->increment('views');
        */
        
        return view('events.show', [
            'event' => $event, 
            'relatedEvents' => $similar_events
        ]);
    }
}
