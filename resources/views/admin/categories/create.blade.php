@extends('layouts.admin')

@section('title', 'Создание категории')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800">
            &larr; Назад к списку категорий
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-6">Создание новой категории</h2>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Название категории:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" 
                    required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание:</label>
                <textarea name="description" id="description" rows="4" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                    Создать категорию
                </button>
            </div>
        </form>
    </div>
@endsection 