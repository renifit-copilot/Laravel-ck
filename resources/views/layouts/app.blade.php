<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'EventHub') }} - @yield('title', 'Каталог мероприятий')</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-white shadow">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div>
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">EventHub</a>
            </div>
            <div class="space-x-4 flex items-center">
                <a href="{{ route('events.index') }}" class="text-gray-700 hover:text-blue-600">Мероприятия</a>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">Админ-панель</a>
                    <span class="text-gray-700 mx-2">|</span>
                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600">Выйти</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Войти</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
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

    <footer class="bg-white shadow-inner mt-8 py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600">© {{ date('Y') }} EventHub. Все права защищены.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-blue-600">О нас</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600">Контакты</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600">Политика конфиденциальности</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html> 