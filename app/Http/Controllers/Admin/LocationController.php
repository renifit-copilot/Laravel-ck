<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Показать список локаций.
     */
    public function index()
    {
        $locations = Location::withCount('events')->orderBy('name')->paginate(10);
        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Показать форму создания новой локации.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Сохранить новую локацию.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string',
        ]);

        Location::create($validated);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Место проведения успешно создано.');
    }

    /**
     * Показать форму редактирования локации.
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Обновить локацию.
     */
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'description' => 'nullable|string',
        ]);

        $location->update($validated);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Место проведения успешно обновлено.');
    }

    /**
     * Удалить локацию.
     */
    public function destroy(Location $location)
    {
        // Проверяем, есть ли связанные события
        if ($location->events()->exists()) {
            return redirect()->route('admin.locations.index')
                ->with('error', 'Нельзя удалить место проведения, так как с ним связаны мероприятия.');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Место проведения успешно удалено.');
    }
}
