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
    // Константы для настроек пагинации и валидации
    const PAGE_SIZE = 10;
    const MAX_IMAGE_SIZE = 2048;
    
    /**
     * Массив допустимых статусов мероприятия
     */
    protected $allowed_statuses = ['published', 'draft', 'cancelled'];

    /**
     * Показать список мероприятий.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Получаем все мероприятия с подгрузкой связанных данных
        $events = Event::with(['category', 'location', 'organizer'])
            ->orderByRaw("CASE WHEN status = 'published' THEN 1 WHEN status = 'draft' THEN 2 ELSE 3 END")
            ->orderBy('start_date')
            ->paginate(self::PAGE_SIZE);
        
        // Можно было бы использовать DB фасад и сделать более сложный запрос,
        // но это усложнит код для текущей задачи
        
        return view('admin.events.index', compact('events'));
    }

    /**
     * Показать форму создания нового мероприятия.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Загружаем данные для выпадающих списков
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $organizers = Organizer::orderBy('name')->get();
        
        return view('admin.events.create', compact('categories', 'locations', 'organizers'));
    }

    /**
     * Сохранить новое мероприятие.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Валидация данных формы
        $validated = $this->validateEvent($request);
        
        // Создаем slug из заголовка
        $validated['slug'] = Str::slug($validated['title']);
        
        // Обработка загруженного изображения
        if ($request->hasFile('image')) {
            $validated['image'] = $this->saveImage($request->file('image'));
        }
        
        // Создаем новое событие в базе данных
        // TODO: Добавить обработку ошибок при сохранении
        try {
            Event::create($validated);
        } catch (\Exception $e) {
            // return redirect()->back()->with('error', 'Ошибка при создании мероприятия: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при создании мероприятия');
        }
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Мероприятие успешно создано.');
    }

    /**
     * Показать форму редактирования мероприятия.
     * 
     * @param Event $event
     * @return \Illuminate\View\View
     */
    public function edit(Event $event)
    {
        // Загружаем данные для выпадающих списков
        $categories = Category::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        $organizers = Organizer::orderBy('name')->get();
        
        return view('admin.events.edit', compact('event', 'categories', 'locations', 'organizers'));
    }

    /**
     * Обновить мероприятие.
     * 
     * @param Request $request
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Event $event)
    {
        // Валидация данных формы
        $validated = $this->validateEvent($request);
        
        // Обновляем slug, если изменился заголовок
        if ($event->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Обработка загруженного изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение, если оно есть
            $this->deleteOldImage($event);
            
            $validated['image'] = $this->saveImage($request->file('image'));
        }
        
        $event->update($validated);
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Мероприятие успешно обновлено.');
    }

    /**
     * Удалить мероприятие.
     * 
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        // Удаляем изображение, если оно есть
        $this->deleteOldImage($event);
        
        $event->delete();
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Мероприятие успешно удалено.');
    }
    
    /**
     * Валидирует данные мероприятия
     * 
     * @param Request $request
     * @return array
     */
    private function validateEvent(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'additional_info' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:' . implode(',', $this->allowed_statuses),
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'organizer_id' => 'required|exists:organizers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:' . self::MAX_IMAGE_SIZE,
        ]);
    }
    
    /**
     * Сохраняет изображение и возвращает путь к нему
     * 
     * @param \Illuminate\Http\UploadedFile $image
     * @return string
     */
    private function saveImage($image)
    {
        // Тут мы могли бы обработать изображение,
        // например уменьшить его размер или добавить водяной знак
        // но для учебного проекта просто сохраняем
        return $image->store('events', 'public');
    }
    
    /**
     * Удаляет старое изображение мероприятия
     * 
     * @param Event $event
     * @return void
     */
    private function deleteOldImage(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
    }
}
