<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Показать список категорий.
     */
    public function index()
    {
        $categories = Category::withCount('events')->orderBy('name')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Показать форму создания новой категории.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Сохранить новую категорию.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        // Автоматически создаем slug из имени
        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория успешно создана.');
    }

    /**
     * Показать форму редактирования категории.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Обновить категорию.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // Автоматически обновляем slug из нового имени, если имя изменилось
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория успешно обновлена.');
    }

    /**
     * Удалить категорию.
     */
    public function destroy(Category $category)
    {
        // Проверяем, есть ли связанные события
        if ($category->events()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Нельзя удалить категорию, так как с ней связаны мероприятия.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория успешно удалена.');
    }
}
