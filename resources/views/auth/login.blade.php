@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8 border border-gray-100 my-12">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-black text-gray-900 mt-2">Ingresar a tu cuenta</h2>
        <p class="text-sm text-gray-500 mt-1">¡Qué bueno verte de nuevo, viajero!</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 text-sm text-red-700 rounded-r-md">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
        </div>

        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center text-sm text-gray-600">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ml-2">Recuérdame</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 tracking-wide mt-2">
            Entrar
        </button>

        <p class="text-center text-sm text-gray-500 mt-4">
            ¿No tienes cuenta? 
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-semibold">Regístrate gratis</a>
        </p>
    </form>
</div>
@endsection