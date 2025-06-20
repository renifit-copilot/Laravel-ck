<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - {{ config('app.name', 'EventHub') }}</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Боковое меню -->
        <aside class="w-64 bg-gray-800 min-h-screen fixed">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-2xl font-semibold">EventHub</a>
                <p class="text-gray-400 text-sm mt-1">Админ-панель</p>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mx-3">Панель управления</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mx-3">Категории</span>
                </a>
                <a href="{{ route('admin.events.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.events.*') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mx-3">Мероприятия</span>
                </a>
                <a href="{{ route('admin.locations.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.locations.*') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mx-3">Локации</span>
                </a>
                <a href="{{ route('admin.organizers.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.organizers.*') ? 'bg-gray-700 text-white' : '' }}">
                    <span class="mx-3">Организаторы</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full p-6">
                <a href="{{ route('home') }}" class="flex items-center text-gray-300 hover:text-white mb-4">
                    <span class="mx-3">Перейти на сайт</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mx-3">
                    @csrf
                    <button type="submit" class="text-gray-300 hover:text-white">Выйти</button>
                </form>
            </div>
        </aside>

        <!-- Основной контент -->
        <div class="ml-64 w-full">
            <!-- Верхняя панель -->
            <header class="bg-white shadow">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-900">@yield('title', 'Панель управления')</h1>
                    <div class="flex items-center">
                        <span class="text-gray-700 mr-4">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                Выйти
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Контент страницы -->
            <main class="p-6">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html> 