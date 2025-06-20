@extends('layouts.admin')

@section('title', 'Панель управления')

@section('content')
    {{-- Здесь выводим общую статистику проекта в виде карточек --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Всего мероприятий</h3>
            <p class="text-3xl font-bold mt-2">{{ $eventsCount }}</p>
            <div class="mt-4">
                <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    Посмотреть все →
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Категории</h3>
            <p class="text-3xl font-bold mt-2">{{ $categoriesCount }}</p>
            <div class="mt-4">
                <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    Посмотреть все →
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Места проведения</h3>
            <p class="text-3xl font-bold mt-2">{{ $locationsCount }}</p>
            <div class="mt-4">
                <a href="{{ route('admin.locations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    Посмотреть все →
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Организаторы</h3>
            <p class="text-3xl font-bold mt-2">{{ $organizersCount }}</p>
            <div class="mt-4">
                <a href="{{ route('admin.organizers.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    Посмотреть все →
                </a>
            </div>
        </div>
    </div>

    {{-- TODO: Добавить график статистики по месяцам --}}
    
    {{-- Тут будет и статистика по статусам (если передана в контроллере) --}}
    @if(isset($eventsStatusCount))
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Статистика по статусам</h3>
        <div class="flex space-x-4">
            <div class="bg-green-100 p-3 rounded flex-1 text-center">
                <p class="text-green-800 font-bold text-xl">{{ $eventsStatusCount['published'] }}</p>
                <p class="text-green-700">Опубликовано</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded flex-1 text-center">
                <p class="text-yellow-800 font-bold text-xl">{{ $eventsStatusCount['draft'] }}</p>
                <p class="text-yellow-700">Черновики</p>
            </div>
            <div class="bg-red-100 p-3 rounded flex-1 text-center">
                <p class="text-red-800 font-bold text-xl">{{ $eventsStatusCount['cancelled'] }}</p>
                <p class="text-red-700">Отменено</p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Последние мероприятия -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700">Последние мероприятия</h3>
            </div>
            <div class="p-6">
                @if($latestEvents->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($latestEvents as $event)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.events.edit', $event) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $event->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- Можно было бы использовать метод из модели: $event->formattedDate() --}}
                                            {{ $event->start_date->format('d.m.Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : 
                                                  ($event->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $event->status === 'published' ? 'Опубликовано' : 
                                                  ($event->status === 'draft' ? 'Черновик' : 'Отменено') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Мероприятий пока нет.</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('admin.events.create') }}" class="text-blue-600 hover:text-blue-800">
                        + Добавить новое мероприятие
                    </a>
                </div>
            </div>
        </div>

        <!-- Популярные категории -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700">Популярные категории</h3>
            </div>
            <div class="p-6">
                @if($popularCategories->count() > 0)
                    <div class="space-y-4">
                        @foreach($popularCategories as $category)
                            <div class="flex justify-between items-center">
                                <span>{{ $category->name }}</span>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $category->events_count }} мероприятий</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Категорий пока нет.</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('admin.categories.create') }}" class="text-blue-600 hover:text-blue-800">
                        + Добавить новую категорию
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- 
    Здесь можно было бы добавить еще один блок со статистикой
    по посещаемости страниц и популярным мероприятиям, но это
    потребует дополнительной таблицы в БД для хранения счетчика просмотров.
    --}}
@endsection