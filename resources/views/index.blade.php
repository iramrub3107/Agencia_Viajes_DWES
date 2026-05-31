@extends('layouts.app')

@section('title', 'Dashboard de Exploración')

@section('content')
<div class="space-y-8">
    
    <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 rounded-2xl p-6 md:p-8 shadow-lg text-white flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black tracking-tight">Panel de destinos globales</h1>
            <p class="text-indigo-100 text-sm mt-1">Explora, filtra y gestiona los mejores paquetes vacacionales del mundo.</p>
        </div>
        
        <button onclick="toggleFiltros()" class="bg-white text-indigo-700 hover:bg-indigo-50 font-bold px-5 py-3 rounded-xl shadow-md transition-all duration-200 flex items-center gap-2 text-sm self-start md:self-auto group">
            <span>Filtrar paquetes</span>
            <svg id="flecha-filtros" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
    </div>

    <div id="contenedor-filtros" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">Parámetros de búsqueda</h3>
            
            <form action="{{ route('vacaciones.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">País de destino</label>
                    <input type="text" name="pais" value="{{ request('pais') }}" placeholder="Ej. España, Perú, México..." class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-3 border bg-gray-50/50">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tipo de experiencia</label>
                    <select name="idtipo" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-3 border bg-gray-50/50">
                        <option value="">Todas las experiencias</option>
                        @foreach($tipos ?? [] as $tipo)
                            <option value="{{ $tipo->id }}" {{ request('idtipo') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Presupuesto Máximo (€)</label>
                    <input type="number" name="precio_max" value="{{ request('precio_max') }}" placeholder="Ej. 2500" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-3 border bg-gray-50/50">
                </div>

                <div class="md:col-span-3 flex items-center justify-end gap-3 pt-2 border-t border-gray-50">
                    <a href="{{ route('vacaciones.index') }}" class="text-sm font-semibold text-gray-500 hover:text-red-500 px-4 py-2 transition">Quitar filtros</a>
                    
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition">
                        Aplicar filtros
                    </button>
                </div>
            </form>
        </div>
    </div>

    <section>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($vacaciones as $vacacion)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col justify-between border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div>
                        <div class="h-56 bg-gray-100 relative overflow-hidden">
                            @php
                                $nombreImagen = '';
                                if ($vacacion->fotos && $vacacion->fotos->isNotEmpty()) {
                                    $nombreImagen = $vacacion->fotos->first()->ruta;
                                } elseif (!empty($vacacion->foto)) {
                                    $nombreImagen = $vacacion->foto;
                                }

                                $nombreImagenClean = str_replace(['vacaciones/', 'storage/'], '', $nombreImagen);
                            @endphp

                            @if(!empty($nombreImagen))
                                <img src="{{ asset('vacaciones/' . $nombreImagenClean) }}" alt="{{ $vacacion->titulo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-50">
                                    <span class="text-xs mt-1 font-medium">Sin imagen promocional</span>
                                </div>
                            @endif
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-black px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wider">
                                {{ $vacacion->pais }}
                            </span>
                        </div>

                        <div class="p-6">
                            <span class="inline-block text-xs font-extrabold text-indigo-600 tracking-widest uppercase bg-indigo-50 px-2.5 py-1 rounded-md mb-3">
                                {{ $vacacion->tipo->nombre ?? 'General' }}
                            </span>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                {{ $vacacion->titulo }}
                            </h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                                {{ $vacacion->descripcion }}
                            </p>
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-4 border-t border-gray-50 flex items-center justify-between bg-gray-50/30">
                        <div>
                            <span class="text-xs text-gray-400 block font-medium uppercase tracking-wider">Precio final</span>
                            <span class="text-2xl font-black text-gray-900">{{ number_format($vacacion->precio, 2) }} €</span>
                        </div>
                        <a href="{{ url('/vacaciones/'.$vacacion->id) }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition duration-150">
                            Ver detalles
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-16 text-center rounded-2xl shadow-sm border border-dashed border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mt-3">No hay destinos disponibles</h3>
                    <p class="text-gray-500 text-sm max-w-sm mx-auto mt-1">Lo sentimos, actualmente ningún paquete vacacional cumple con las condiciones del filtro aplicado.</p>
                    <a href="{{ route('vacaciones.index') }}" class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs px-4 py-2 rounded-lg mt-4 transition">
                        Restablecer catálogo
                    </a>
                </div>
            @endforelse
        </div>

        @if(method_exists($vacaciones, 'links') && $vacaciones->hasPages())
            <div class="mt-12">
                {{ $vacaciones->links() }}
            </div>
        @endif
    </section>
</div>

<script>
function toggleFiltros() {
    const contenedor = document.getElementById('contenedor-filtros');
    const flecha = document.getElementById('flecha-filtros');
    
    if (contenedor.style.maxHeight === '0px' || !contenedor.style.maxHeight) {
        contenedor.style.maxHeight = '400px'; 
        flecha.style.transform = 'rotate(180deg)'; 
    } else {
        contenedor.style.maxHeight = '0px'; 
        flecha.style.transform = 'rotate(0deg)'; 
    }
}

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('pais') || urlParams.has('idtipo') || urlParams.has('precio_max')) {
        if (urlParams.get('pais') || urlParams.get('idtipo') || urlParams.get('precio_max')) {
            toggleFiltros();
        }
    }
});
</script>
@endsection