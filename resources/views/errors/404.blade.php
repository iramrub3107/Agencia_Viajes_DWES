@extends('layouts.app')

@section('content')
<div class="text-center py-20 space-y-4">
    <h1 class="text-6xl font-black text-indigo-600">404 | Not found</h1>
    <h2 class="text-2xl font-bold text-gray-900">¡Ups! Ha ocurrido un error: no se ha podido encontrar esta página</h2>
    <div class="pt-4">
        <a href="{{ url('/') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition inline-block">
            Volver al inicio
        </a>
    </div>
</div>
@endsection