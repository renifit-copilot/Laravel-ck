@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="bg-blue-600 text-white rounded-lg p-8 mb-8">
        <div class="max-w-3xl">
            <h1 class="text-4xl font-bold mb-4">Добро пожаловать в EventHub</h1>
            <p class="text-xl mb-6">Найдите интересные мероприятия в вашем городе или расскажите о своем событии</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('events.index') }}" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">Найти мероприятия</a>
            </div>
        </div>
    </div>

    @if($featuredEvents && $featuredEvents->count() > 0)
        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Рекомендуемые мероприятия</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredEvents as $event)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        @if($event->image)
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-500">Нет изображения</span>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $event->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">{{ $event->start_date->format('d.m.Y H:i') }}</span>
                                <a href="{{ route('events.show', $event->slug) }}" class="text-blue-600 hover:text-blue-800">Подробнее</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('events.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">Все мероприятия</a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Категории мероприятий</h2>
            <ul class="space-y-2">
                @foreach($categories as $category)
                    <li>
                        <a href="{{ route('events.index', ['category' => $category->slug]) }}" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                            <span>{{ $category->name }}</span>
                            <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs">{{ $category->events_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Популярные места</h2>
            <ul class="space-y-2">
                @foreach($locations as $location)
                    <li>
                        <a href="{{ route('events.index', ['location' => $location->id]) }}" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                            <div>
                                <span class="block">{{ $location->name }}</span>
                                <span class="text-sm text-gray-500">{{ $location->city }}, {{ $location->country }}</span>
                            </div>
                            <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs">{{ $location->events_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection 