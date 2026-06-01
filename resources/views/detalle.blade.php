@extends('layouts.app')

@section('title', $vacacion->titulo)

@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden p-6 md:p-8">
    <div class="mb-6">
        <span class="text-sm font-semibold text-indigo-600 uppercase tracking-wider">{{ $vacacion->tipo->nombre }}</span>
        <h1 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $vacacion->titulo }}</h1>
        <p class="text-gray-500 mt-1">{{ $vacacion->pais }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        @foreach($vacacion->fotos as $index => $foto)
            @php
                $nombreImagenClean = str_replace(['vacaciones/', 'storage/'], '', $foto->ruta);
            @endphp
            <div class="{{ $index === 0 ? 'md:col-span-3 h-96' : 'h-48' }} bg-gray-100 rounded-lg overflow-hidden shadow-sm">
                <img src="{{ asset('img-vacaciones/' . $nombreImagenClean) }}" alt="Foto {{ $index + 1 }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 border-b pb-8">
        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold text-gray-900 mb-3">Sobre este paquete</h2>
            <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $vacacion->descripcion }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
            <p class="text-xs text-gray-400">Precio por persona</p>
            <p class="text-3xl font-black text-gray-900 mb-4">{{ number_format($vacacion->precio, 2) }} €</p>

            @auth
                @if($usuarioHaReservado)
                    <div class="space-y-3">
                        <div id="contenedor-cancelar-inicial" class="space-y-3">
                            <button type="button" disabled class="w-full bg-gray-100 text-gray-400 font-bold py-3 px-4 rounded-xl text-sm flex items-center justify-center gap-2 cursor-not-allowed">
                                ¡Ya has reservado este paquete vacacional!
                            </button>

                            <button type="button" onclick="mostrarConfirmacion()" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-bold py-2 px-4 rounded-xl text-xs transition border border-red-200">
                                Cancelar mi reserva
                            </button>
                        </div>

                        <div id="contenedor-cancelar-confirmacion" class="hidden p-4 bg-red-50 border border-red-200 rounded-xl text-center">
                            <p class="text-xs font-bold text-red-700 mb-3">¿Estás seguro de que deseas cancelar la reserva?</p>
                            
                            <div class="flex justify-center items-center gap-3">
                                
                                <form action="{{ route('reservas.destroy') }}" method="POST" class="m-0 p-0 flex items-center">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                                    
                                    <button type="submit" class="h-10 px-5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg text-xs transition shadow-sm whitespace-nowrap">
                                        Sí, cancelar
                                    </button>
                                </form>

                                <button type="button" onclick="ocultarConfirmacion()" class="h-10 px-5 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-lg text-xs transition border border-gray-300 whitespace-nowrap">
                                    No, mantener
                                </button>
                            </div>
                        </div>

                    </div>
                @else
                    <form action="{{ route('reservas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl text-sm shadow-md transition">
                            Reservar
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center font-bold py-3 px-4 rounded-xl text-sm shadow-md transition">
                    Inicia sesión para reservar
                </a>
            @endauth

            <p class="text-[10px] text-gray-400 mt-3">Confirmación inmediata sujeta a disponibilidad de fechas.</p>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Opiniones de viajeros</h3>

        @auth
            @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'advanced' || $usuarioHaReservado)
                
                <form action="{{ route('comentarios.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4 mb-6">
                    @csrf
                    <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Escribe tu opinión...</label>
                        <textarea name="texto" rows="3" required placeholder="Escribe aquí..." class="w-full text-sm rounded-xl border-gray-200 border p-2.5"></textarea>
                    </div>
                    
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                        Publicar comentario
                    </button>
                </form>

            @else
                <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl flex items-start gap-3 mb-6">
                    <p class="text-sm text-amber-800">
                        Solo los clientes que han <strong>comprado y reservado</strong> este paquete vacacional pueden hacer comentarios.
                    </p>
                </div>
            @endif
        @else
            <p class="text-sm text-gray-400">Para poder comentar, necesitas <a href="{{ route('login') }}" class="text-indigo-600 underline font-semibold">iniciar sesión</a>.</p>
        @endauth
    </div>

    <div class="mt-6 space-y-4">
        <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Comentarios de la comunidad</h4>
        
        @forelse($comentarios as $comentario)
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col gap-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-gray-900">{{ $comentario->user->name }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-extrabold uppercase tracking-wide {{ $comentario->user->rol === 'admin' ? 'bg-red-100 text-red-800' : ($comentario->user->rol === 'advanced' ? 'bg-amber-100 text-amber-800' : 'bg-gray-200 text-gray-700') }}">
                            {{ $comentario->user->rol }}
                        </span>
                    </div>
                    <span class="text-xs text-gray-400">{{ $comentario->created_at?->diffForHumans() ?? 'Reciente' }}</span>
                </div>
                
                <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                    {{ $comentario->texto }}
                </p>
            </div>
        @empty
            <p class="text-sm text-gray-400 italic py-2">Nadie ha comentado sobre este paquete todavía. ¡Sé el primero!</p>
        @endforelse
    </div>
</div>
@endsection

<script>
    function mostrarConfirmacion() {
        document.getElementById('contenedor-cancelar-inicial').classList.add('hidden');
        document.getElementById('contenedor-cancelar-confirmacion').classList.remove('hidden');
    }

    function ocultarConfirmacion() {
        document.getElementById('contenedor-cancelar-confirmacion').classList.add('hidden');
        document.getElementById('contenedor-cancelar-inicial').classList.remove('hidden');
    }
</script>