@extends('layouts.admin')

@section('title', 'Редактирование организатора')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.organizers.index') }}" class="text-blue-600 hover:text-blue-800">
            &larr; Назад к списку организаторов
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-6">Редактирование организатора: {{ $organizer->name }}</h2>

        <form action="{{ route('admin.organizers.update', $organizer) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Название организации:</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $organizer->name) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" 
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $organizer->email) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Телефон:</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $organizer->phone) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="website" class="block text-gray-700 text-sm font-bold mb-2">Веб-сайт:</label>
                    <input type="url" name="website" id="website" value="{{ old('website', $organizer->website) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('website') border-red-500 @enderror">
                    @error('website')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание организации:</label>
                <textarea name="description" id="description" rows="4" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description', $organizer->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Логотип:</label>
                
                @if($organizer->logo)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $organizer->logo) }}" alt="{{ $organizer->name }}" class="h-20 w-20 object-cover rounded">
                        <p class="text-sm text-gray-500 mt-1">Текущий логотип</p>
                    </div>
                @endif
                
                <input type="file" name="logo" id="logo" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('logo') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Допустимые форматы: JPEG, PNG, JPG, GIF. Максимальный размер: 2MB.</p>
                <p class="text-xs text-gray-500">Оставьте поле пустым, если не хотите менять логотип.</p>
                @error('logo')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                    Обновить организатора
                </button>
            </div>
        </form>
    </div>
@endsection 