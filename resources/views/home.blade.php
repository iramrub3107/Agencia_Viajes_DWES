@extends('layouts.app') {{-- O el layout base que estés utilizando --}}

@section('content')
<div class="relative bg-gradient-to-r from-indigo-900 to-slate-900 text-white py-24 px-6 rounded-3xl overflow-hidden shadow-xl mb-12">
    <div class="absolute inset-0 opacity-20 bg-[url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80')] bg-cover bg-center"></div>
    <div class="relative max-w-3xl mx-auto text-center space-y-6">
        <span class="bg-indigo-500/30 text-indigo-300 font-extrabold text-xs uppercase tracking-widest px-4 py-1.5 rounded-full border border-indigo-400/20">
            Descubre tu próximo destino
        </span>
        <h1 class="text-5xl md:text-6xl font-black tracking-tight leading-none">
            Viaja sin límites con <span class="text-indigo-400">NómadaViajes</span>
        </h1>
        <p class="text-lg text-slate-300 max-w-xl mx-auto font-medium">
            Diseñamos experiencias inolvidables y paquetes vacacionales a medida para los espíritus más aventureros.
        </p>
        <div class="pt-4">
            <a href="{{ route('vacaciones.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-3.5 rounded-xl text-sm shadow-lg transition transform hover:-translate-y-0.5 inline-block">
                Explorar catálogo de paquetes vacacionales
            </a>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 px-4 mb-12">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3">
        <h3 class="font-bold text-gray-900 text-base">Destinos Exclusivos</h3>
        <p class="text-xs text-gray-500 leading-relaxed">Seleccionamos minuciosamente cada hotel y actividad para garantizar la máxima calidad.</p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3">
        <h3 class="font-bold text-gray-900 text-base">Precios Transparentes</h3>
        <p class="text-xs text-gray-500 leading-relaxed">Sin sorpresas de última hora ni comisiones ocultas. Lo que ves es lo que pagas.</p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3">
        <h3 class="font-bold text-gray-900 text-base">Soporte Avanzado</h3>
        <p class="text-xs text-gray-500 leading-relaxed">Nuestro equipo de expertos y gestores avanzados está a tu disposición en cualquier momento.</p>
    </div>
</div>
@endsection