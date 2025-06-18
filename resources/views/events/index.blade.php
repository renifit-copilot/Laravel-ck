@extends('layouts.app')

@section('title', 'Мероприятия')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h1 class="text-2xl font-bold mb-4">Мероприятия</h1>
        
        <form action="{{ route('events.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Категория</label>
                    <select name="category" id="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Место проведения</label>
                    <select name="location" id="location" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Все места</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}, {{ $location->city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Дата</label>
                    <div class="flex space-x-2">
                        <input 
                            type="date" 
                            name="start_date" 
                            id="start_date" 
                            value="{{ request('start_date') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                        <input 
                            type="date" 
                            name="end_date" 
                            id="end_date" 
                            value="{{ request('end_date') }}" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                        >
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Фильтровать
                </button>
            </div>
        </form>
    </div>
    
    @if($events->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-lg text-gray-600">По вашему запросу не найдено мероприятий.</p>
            <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">Сбросить фильтры</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-500">Нет изображения</span>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="text-xl font-bold">{{ $event->title }}</h2>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $event->category->name }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                        
                        <div class="flex items-center mb-3">
                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-500">{{ $event->start_date->format('d.m.Y H:i') }}</span>
                        </div>
                        
                        <div class="flex items-center mb-4">
                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-500">{{ $event->location->name }}, {{ $event->location->city }}</span>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('events.show', $event->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Подробнее →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    @endif
@endsection 