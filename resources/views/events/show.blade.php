@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="relative">
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" class="w-full h-96 object-cover">
            @else
                <div class="w-full h-80 bg-gray-300 flex items-center justify-center">
                    <span class="text-gray-500 text-lg">Нет изображения</span>
                </div>
            @endif
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $event->category->name }}
                </span>
                <h1 class="text-3xl font-bold text-white mt-2">{{ $event->title }}</h1>
            </div>
        </div>

        <div class="p-6">
            <div class="flex flex-wrap gap-6 mb-8 text-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">Дата начала</p>
                        <p class="text-gray-600">{{ $event->start_date->format('d.m.Y H:i') }}</p>
                    </div>
                </div>

                @if($event->end_date)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900">Дата окончания</p>
                            <p class="text-gray-600">{{ $event->end_date->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                @endif

                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">Место проведения</p>
                        <p class="text-gray-600">{{ $event->location->name }}</p>
                        <p class="text-gray-600">{{ $event->location->address }}, {{ $event->location->city }}, {{ $event->location->country }}</p>
                    </div>
                </div>

                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">Организатор</p>
                        <p class="text-gray-600">{{ $event->organizer->name }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Описание</h2>
                <div class="text-gray-700 prose max-w-none">
                    {{ $event->description }}
                </div>
            </div>

            @if($event->additional_info)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Дополнительная информация</h2>
                    <div class="text-gray-700 prose max-w-none">
                        {{ $event->additional_info }}
                    </div>
                </div>
            @endif

            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Место проведения</h2>
                <div class="bg-gray-100 p-6 rounded-lg">
                    <h3 class="text-xl font-bold">{{ $event->location->name }}</h3>
                    <p class="text-gray-700 mb-2">{{ $event->location->address }}</p>
                    <p class="text-gray-700 mb-4">{{ $event->location->city }}, {{ $event->location->state ?? '' }} {{ $event->location->postal_code ?? '' }}, {{ $event->location->country }}</p>
                    
                    @if($event->location->description)
                        <p class="text-gray-700 mb-4">{{ $event->location->description }}</p>
                    @endif
                    
                    @if($event->location->latitude && $event->location->longitude)
                        <div class="bg-gray-300 h-64 rounded-lg flex items-center justify-center">
                            <span class="text-gray-600">Карта будет здесь</span>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold mb-4">Организатор</h2>
                <div class="bg-gray-100 p-6 rounded-lg">
                    <div class="flex items-center">
                        @if($event->organizer->logo)
                            <img src="{{ asset('storage/' . $event->organizer->logo) }}" alt="{{ $event->organizer->name }}" class="w-16 h-16 rounded-full object-cover mr-4">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                                <span class="text-gray-500 text-xl font-bold">{{ substr($event->organizer->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold">{{ $event->organizer->name }}</h3>
                            @if($event->organizer->email || $event->organizer->phone || $event->organizer->website)
                                <div class="flex flex-wrap gap-4 text-sm mt-2">
                                    @if($event->organizer->email)
                                        <p class="text-gray-700">
                                            <span class="font-semibold">Email:</span> {{ $event->organizer->email }}
                                        </p>
                                    @endif
                                    
                                    @if($event->organizer->phone)
                                        <p class="text-gray-700">
                                            <span class="font-semibold">Телефон:</span> {{ $event->organizer->phone }}
                                        </p>
                                    @endif
                                    
                                    @if($event->organizer->website)
                                        <p class="text-gray-700">
                                            <span class="font-semibold">Сайт:</span> 
                                            <a href="{{ $event->organizer->website }}" class="text-blue-600 hover:text-blue-800" target="_blank" rel="noopener noreferrer">
                                                {{ $event->organizer->website }}
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($event->organizer->description)
                        <p class="text-gray-700 mt-4">{{ $event->organizer->description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($relatedEvents->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Похожие мероприятия</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedEvents as $relatedEvent)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        @if($relatedEvent->image)
                            <img src="{{ asset('storage/' . $relatedEvent->image) }}" alt="{{ $relatedEvent->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-500">Нет изображения</span>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $relatedEvent->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($relatedEvent->description, 100) }}</p>
                            <div class="flex items-center mb-4">
                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-500">{{ $relatedEvent->start_date->format('d.m.Y H:i') }}</span>
                            </div>
                            <a href="{{ route('events.show', $relatedEvent->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Подробнее →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection 