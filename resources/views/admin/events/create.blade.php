@extends('layouts.admin')

@section('title', 'Создание нового мероприятия')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800">
            &larr; Назад к списку мероприятий
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-6">Создание нового мероприятия</h2>

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Название мероприятия*</label>
                <input type="text" name="title" id="title" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" 
                    value="{{ old('title') }}" required>
                @error('title')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание мероприятия*</label>
                <textarea name="description" id="description" rows="5" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" 
                    required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="additional_info" class="block text-gray-700 text-sm font-bold mb-2">Дополнительная информация</label>
                <textarea name="additional_info" id="additional_info" rows="3" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('additional_info') border-red-500 @enderror">{{ old('additional_info') }}</textarea>
                @error('additional_info')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Дата и время начала*</label>
                    <input type="datetime-local" name="start_date" id="start_date" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('start_date') border-red-500 @enderror" 
                        value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Дата и время окончания</label>
                    <input type="datetime-local" name="end_date" id="end_date" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('end_date') border-red-500 @enderror" 
                        value="{{ old('end_date') }}">
                    @error('end_date')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Статус мероприятия*</label>
                <select name="status" id="status" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror" 
                    required>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Опубликовано</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Черновик</option>
                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Отменено</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Категория*</label>
                <select name="category_id" id="category_id" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category_id') border-red-500 @enderror" 
                    required>
                    <option value="">-- Выберите категорию --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="location_id" class="block text-gray-700 text-sm font-bold mb-2">Место проведения*</label>
                <select name="location_id" id="location_id" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location_id') border-red-500 @enderror" 
                    required>
                    <option value="">-- Выберите место проведения --</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->name }} ({{ $location->address }}, {{ $location->city }})
                        </option>
                    @endforeach
                </select>
                @error('location_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="organizer_id" class="block text-gray-700 text-sm font-bold mb-2">Организатор*</label>
                <select name="organizer_id" id="organizer_id" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('organizer_id') border-red-500 @enderror" 
                    required>
                    <option value="">-- Выберите организатора --</option>
                    @foreach($organizers as $organizer)
                        <option value="{{ $organizer->id }}" {{ old('organizer_id') == $organizer->id ? 'selected' : '' }}>
                            {{ $organizer->name }}
                        </option>
                    @endforeach
                </select>
                @error('organizer_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Изображение мероприятия</label>
                <input type="file" name="image" id="image" 
                    class="w-full @error('image') border-red-500 @enderror">
                <p class="text-gray-500 text-xs mt-1">Рекомендуемый размер: 1200x630 пикселей. Максимальный размер: 2MB.</p>
                @error('image')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                    Создать мероприятие
                </button>
            </div>
        </form>
    </div>
@endsection 