@extends('layouts.app')

@section('title', 'Crear Cuenta')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6 md:p-8 border border-gray-100 my-12">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-black text-gray-900 mt-2">Registrarse como nuevo viajero</h2>
        <p class="text-sm text-gray-500 mt-1">Crea tu cuenta y empieza a comentar tus experiencias</p>
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

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nombre completo</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border">
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 tracking-wide mt-2">
            Crear mi cuenta
        </button>

        <p class="text-center text-sm text-gray-500 mt-4">
            ¿Ya tienes una cuenta activa? 
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">Inicia sesión aquí</a>
        </p>
    </form>
</div>
@endsection