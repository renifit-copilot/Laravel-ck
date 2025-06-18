<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Показать список мероприятий.
     */
    public function index()
    {
        $events = Event::with(['category', 'location', 'organizer'])
            ->orderByRaw("CASE WHEN status = 'published' THEN 1 WHEN status = 'draft' THEN 2 ELSE 3 END")
            ->orderBy('start_date')
            ->paginate(10);
        
        return view('admin.events.index', compact('events'));
    }

    /**
     * Показать форму создания нового мероприятия.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $organizers = Organizer::orderBy('name')->get();
        
        return view('admin.events.create', compact('categories', 'locations', 'organizers'));
    }

    /**
     * Сохранить новое мероприятие.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'additional_info' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:published,draft,cancelled',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'organizer_id' => 'required|exists:organizers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Создаем slug из заголовка
        $validated['slug'] = Str::slug($validated['title']);
        
        // Обработка загруженного изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }
        
        Event::create($validated);
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Мероприятие успешно создано.');
    }

    /**
     * Показать форму редактирования мероприятия.
     */
    public function edit(Event $event)
    {
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $organizers = Organizer::orderBy('name')->get();
        
        return view('admin.events.edit', compact('event', 'categories', 'locations', 'organizers'));
    }

    /**
     * Обновить мероприятие.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'additional_info' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:published,draft,cancelled',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'organizer_id' => 'required|exists:organizers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Обновляем slug, если изменился заголовок
        if ($event->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Обработка загруженного изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение, если оно есть
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }
        
        $event->update($validated);
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Мероприятие успешно обновлено.');
    }

    /**
     * Удалить мероприятие.
     */
    public function destroy(Event $event)
    {
        // Удаляем изображение, если оно есть
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Мероприятие успешно удалено.');
    }
}
