@extends('layouts.admin')

@section('title', 'Редактирование места проведения')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.locations.index') }}" class="text-blue-600 hover:text-blue-800">
            &larr; Назад к списку мест
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold mb-6">Редактирование места: {{ $location->name }}</h2>

        <form action="{{ route('admin.locations.update', $location) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Название места:</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $location->name) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" 
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Адрес:</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $location->address) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address') border-red-500 @enderror" 
                        required>
                    @error('address')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="city" class="block text-gray-700 text-sm font-bold mb-2">Город:</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $location->city) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('city') border-red-500 @enderror" 
                        required>
                    @error('city')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="state" class="block text-gray-700 text-sm font-bold mb-2">Регион/Область:</label>
                    <input type="text" name="state" id="state" value="{{ old('state', $location->state) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('state') border-red-500 @enderror">
                    @error('state')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="country" class="block text-gray-700 text-sm font-bold mb-2">Страна:</label>
                    <input type="text" name="country" id="country" value="{{ old('country', $location->country) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('country') border-red-500 @enderror" 
                        required>
                    @error('country')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="postal_code" class="block text-gray-700 text-sm font-bold mb-2">Почтовый индекс:</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $location->postal_code) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('postal_code') border-red-500 @enderror">
                    @error('postal_code')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="latitude" class="block text-gray-700 text-sm font-bold mb-2">Широта:</label>
                    <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $location->latitude) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('latitude') border-red-500 @enderror">
                    @error('latitude')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="longitude" class="block text-gray-700 text-sm font-bold mb-2">Долгота:</label>
                    <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $location->longitude) }}" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('longitude') border-red-500 @enderror">
                    @error('longitude')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание места:</label>
                <textarea name="description" id="description" rows="4" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description', $location->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                    Обновить место
                </button>
            </div>
        </form>
    </div>
@endsection 