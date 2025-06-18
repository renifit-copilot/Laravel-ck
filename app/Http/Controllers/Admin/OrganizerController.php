<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizerController extends Controller
{
    /**
     * Показать список организаторов.
     */
    public function index()
    {
        $organizers = Organizer::withCount('events')->orderBy('name')->paginate(10);
        return view('admin.organizers.index', compact('organizers'));
    }

    /**
     * Показать форму создания нового организатора.
     */
    public function create()
    {
        return view('admin.organizers.create');
    }

    /**
     * Сохранить нового организатора.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обработка загруженного логотипа
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('organizers', 'public');
        }

        Organizer::create($validated);

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Организатор успешно добавлен.');
    }

    /**
     * Показать форму редактирования организатора.
     */
    public function edit(Organizer $organizer)
    {
        return view('admin.organizers.edit', compact('organizer'));
    }

    /**
     * Обновить организатора.
     */
    public function update(Request $request, Organizer $organizer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Обработка загруженного логотипа
        if ($request->hasFile('logo')) {
            // Удаляем старое изображение, если оно есть
            if ($organizer->logo) {
                Storage::disk('public')->delete($organizer->logo);
            }
            $validated['logo'] = $request->file('logo')->store('organizers', 'public');
        }

        $organizer->update($validated);

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Данные организатора успешно обновлены.');
    }

    /**
     * Удалить организатора.
     */
    public function destroy(Organizer $organizer)
    {
        // Проверяем, есть ли связанные события
        if ($organizer->events()->exists()) {
            return redirect()->route('admin.organizers.index')
                ->with('error', 'Нельзя удалить организатора, так как с ним связаны мероприятия.');
        }

        // Удаляем логотип, если он есть
        if ($organizer->logo) {
            Storage::disk('public')->delete($organizer->logo);
        }

        $organizer->delete();

        return redirect()->route('admin.organizers.index')
            ->with('success', 'Организатор успешно удален.');
    }
}
