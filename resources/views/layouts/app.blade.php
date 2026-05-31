<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NómadaViajes') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 flex flex-col justify-between min-h-screen font-sans antialiased">

        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="text-2xl font-bold text-indigo-600 tracking-wide">
                            NómadaViajes
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ url('/catalogo') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 font-medium">Catálogo</a>
                        
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 font-medium">Mi panel</a>
                            
                            <span class="text-sm bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full font-semibold">
                                <a href="{{ url('/dashboard') }}">
                                    {{ auth()->user()->name }}
                                </a>
                            </span>
                            
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm ml-2">Cerrar sesión</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 text-sm font-medium">Iniciar Sesión</a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">Registrarse</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        @isset($header)
            <header class="bg-white shadow-sm border-b">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="mb-auto py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </div>
        </main>

        <footer class="bg-gray-800 text-gray-400 py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 text-center text-sm">
                &copy; {{ date('Y') }} NómadaViajes. Todos los derechos reservados.
            </div>
        </footer>

    </body>
</html>