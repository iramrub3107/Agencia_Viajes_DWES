@extends('layouts.app')

@section('title', 'Panel de Control')

@section('content')
<div class="space-y-8">

    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
            <h2 class="text-4xl font-black text-gray-900">¡Hola de nuevo, {{ auth()->user()->name }}!</h2>
        </div>
    </div>

    @if(auth()->user()->rol === 'admin')
        @if (session('status') === 'usuario-creado')
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4 text-sm text-green-700 rounded-r-md">
                ¡Usuario creado correctamente! Ya puede iniciar sesión
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm h-fit">
                <h3 class="font-bold text-gray-800 text-lg mb-1 flex items-center gap-2">Registrar un usuario</h3>
                <p class="text-xs text-gray-400 mb-4">Añade usuarios con diferentes roles</p>
                
                <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre completo</label>
                        <input type="text" name="name" required placeholder="Ej. Ana Gómez" class="w-full text-sm rounded-xl border-gray-200 border p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Correo electrónico</label>
                        <input type="email" name="email" required placeholder="ana@nomadaviajes.com" class="w-full text-sm rounded-xl border-gray-200 border p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Contraseña</label>
                        <input type="password" name="password" required placeholder="Mínimo 4 caracteres" class="w-full text-sm rounded-xl border-gray-200 border p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Rol del usuario</label>
                        <select name="rol" required class="w-full text-sm rounded-xl border-gray-200 border p-2.5 bg-white font-medium">
                            <option value="user">Cliente</option>
                            <option value="advanced">Gestor de viajes</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl text-sm shadow-md transition">
                        Crear cuenta
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden lg:col-span-2">
                <div class="p-6 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">Personal del sistema</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Lista de cuentas en la base de datos de NómadaViajes</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                       <thead class="bg-gray-100 text-xs text-gray-700 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 cursor-pointer select-none hover:bg-gray-200 transition group" onclick="gestionarOrdenacionUsuarios('name', 0)">
                                    <div class="flex items-center gap-1">
                                        <span>Nombre</span>
                                        <span id="indicador-user-name" class="text-gray-400 group-hover:text-gray-600">↕</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 cursor-pointer select-none hover:bg-gray-200 transition group" onclick="gestionarOrdenacionUsuarios('email', 1)">
                                    <div class="flex items-center gap-1">
                                        <span>Email</span>
                                        <span id="indicador-user-email" class="text-gray-400 group-hover:text-gray-600">↕</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 cursor-pointer select-none hover:bg-gray-200 transition group" onclick="gestionarOrdenacionUsuarios('rol', 2)">
                                    <div class="flex items-center gap-1">
                                        <span>Rol</span>
                                        <span id="indicador-user-rol" class="text-gray-400 group-hover:text-gray-600">↕</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="body-usuarios" class="divide-y divide-gray-100">
                            @forelse($usuarios as $u)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $u->name }}</td>
                                    <td class="px-6 py-4">{{ $u->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide {{ $u->rol === 'admin' ? 'bg-red-100 text-red-800' : ($u->rol === 'advanced' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700') }}">
                                            {{ $u->rol }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button type="button" onclick="confirmarEliminarUsuario('{{ route('usuarios.destroy', $u->id) }}')" class="bg-red-50 text-red-600 hover:bg-red-100 font-bold text-xs px-3 py-1.5 rounded-lg transition">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="p-6 text-center text-gray-400 text-xs">No hay usuarios registrados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif


    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'advanced')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm h-fit">
                <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">Lanzar nuevo paquete vacacional</h3>
                <form action="{{ route('vacaciones.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Título</label>
                        <input type="text" name="titulo" required class="w-full text-sm rounded-xl border-gray-200 border p-2.5">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">País</label>
                            <input type="text" name="pais" required class="w-full text-sm rounded-xl border-gray-200 border p-2.5">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Precio (€)</label>
                            <input type="number" step="0.01" name="precio" required class="w-full text-sm rounded-xl border-gray-200 border p-2.5">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Categoría/Tipo</label>
                        <select name="idtipo" required class="w-full text-sm rounded-xl border-gray-200 border p-2.5 bg-white">
                            @foreach($tipos as $t)
                                <option value="{{ $t->id }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Descripción</label>
                        <textarea name="descripcion" rows="3" required class="w-full text-sm rounded-xl border-gray-200 border p-2.5"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-xl text-sm shadow-md transition">
                        Añadir nuevo paquete
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden lg:col-span-2">
                <div class="p-6 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">Catálogo de paquetes</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="bg-gray-100 text-xs text-gray-700 uppercase">
                            <tr>
                                <th class="px-6 py-3 cursor-pointer select-none hover:bg-gray-200 transition group" onclick="gestionarOrdenacion('titulo', 0, 'texto')">
                                    <div class="flex items-center gap-1">
                                        <span>Paquete</span>
                                        <span id="indicador-titulo" class="text-gray-400 group-hover:text-gray-600">↕</span>
                                    </div>
                                </th>
                                <th class="px-6 py-3">Categoría</th>
                                <th class="px-6 py-3 cursor-pointer select-none hover:bg-gray-200 transition group" onclick="gestionarOrdenacion('precio', 2, 'numero')">
                                    <div class="flex items-center gap-1">
                                        <span>Precio</span>
                                        <span id="indicador-precio" class="text-gray-400 group-hover:text-gray-600">↕</span>
                                    </div>
                                </th>
                                @if(auth()->user()->rol === 'admin') 
                                    <th class="px-6 py-3 text-right">Acción</th> 
                                @endif
                            </tr>
                        </thead>
                        <tbody id="body-paquetes" class="divide-y divide-gray-100">
                            @foreach($vacaciones as $v)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $v->titulo }} <span class="text-xs text-gray-400 font-normal">({{ $v->pais }})</span></td>
                                    <td class="px-6 py-4 text-xs font-bold text-indigo-600">{{ $v->tipo->nombre ?? 'General' }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-800">${{ number_format($v->precio, 2) }}</td>
                                    @if(auth()->user()->rol === 'admin')
                                        <td class="px-6 py-4 text-right">
                                            <button type="button" onclick="confirmarEliminarPaquete('{{ route('vacaciones.destroy', $v->id) }}')" class="bg-red-50 text-red-600 hover:bg-red-100 font-bold text-xs px-3 py-1.5 rounded-lg transition">
                                                Eliminar
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif


    @if(auth()->user()->rol === 'user')
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">Mis reservas</h3>
            
            @if($reservas->isEmpty())
                <div class="text-center py-12 border-2 border-dashed border-gray-100 rounded-xl">
                    <h4 class="font-bold text-gray-700 mt-2">Aún no has hecho ninguna reserva</h4>
                    <p class="text-gray-400 text-xs mt-1">Explora nuestro catálogo y reserva tu próxima aventura</p>
                    <a href="{{ url('/catalogo') }}" class="inline-block mt-4 bg-indigo-600 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-sm hover:bg-indigo-700 transition">Ver destinos</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($reservas as $reserva)
                        <div class="p-4 rounded-xl border border-gray-100 flex items-center justify-between hover:border-indigo-100 transition">
                            <div>
                                <h4 class="font-bold text-gray-900 text-base">{{ $reserva->vacacion->titulo }}</h4>
                                <p class="text-xs text-gray-400">Destino: {{ $reserva->vacacion->pais }}</p>
                            </div>
                            <a href="{{ url('/vacaciones/'.$reserva->vacacion->id) }}" class="text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-2 rounded-lg transition">
                                Ver ficha y opinar
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

</div>

<div id="modal-eliminar-usuario" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 transition-all duration-200">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-xl border border-red-100 text-center transform scale-95 transition-transform duration-200">
        <h3 class="text-lg font-bold text-gray-900 mb-2">¿Deseas eliminar este usuario?</h3>
        <p class="text-sm text-gray-500 mb-6">Esta acción es irreversible y el perfil se borrará de forma permanente del sistema</p>
        <div class="flex gap-3 justify-center">
            <button type="button" onclick="cerrarModalUsuario()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-sm transition">
                No, mantener
            </button>
            <form id="form-eliminar-usuario" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm shadow-sm transition">
                    Sí, eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<div id="modal-eliminar-paquete" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 transition-all duration-200">
    <div class="bg-white rounded-2xl p-6 max-w-sm w-full mx-4 shadow-xl border border-red-100 text-center transform scale-95 transition-transform duration-200">
        <h3 class="text-lg font-bold text-gray-900 mb-2">¿Eliminar paquete?</h3>
        <p class="text-sm text-gray-500 mb-6">¿Estás seguro de que deseas borrar este paquete vacacional del catálogo permanentemente?</p>
        <div class="flex gap-3 justify-center">
            <button type="button" onclick="cerrarModalPaquete()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-sm transition">
                No, mantener
            </button>
            <form id="form-eliminar-paquete" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-sm shadow-sm transition">
                    Sí, eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmarEliminarUsuario(urlAccion) {
    const modal = document.getElementById('modal-eliminar-usuario');
    const form = document.getElementById('form-eliminar-usuario');
    form.action = urlAccion;
    modal.classList.remove('hidden');
}

function cerrarModalUsuario() {
    document.getElementById('modal-eliminar-usuario').classList.add('hidden');
}

function confirmarEliminarPaquete(urlAccion) {
    const modal = document.getElementById('modal-eliminar-paquete');
    const form = document.getElementById('form-eliminar-paquete');
    form.action = urlAccion;
    modal.classList.remove('hidden');
}

function cerrarModalPaquete() {
    document.getElementById('modal-eliminar-paquete').classList.add('hidden');
}

let filasOriginalesUsuarios = [];

const estadosOrdenacionUsuarios = {
    name: 'ninguno',
    email: 'ninguno',
    rol: 'ninguno'
};

document.addEventListener("DOMContentLoaded", () => {
    const tbodyPaquetes = document.getElementById('body-paquetes');
    if (tbodyPaquetes) {
        filasOriginalesPaquetes = Array.from(tbodyPaquetes.querySelectorAll('tr'));
    }

    const tbodyUsuarios = document.getElementById('body-usuarios');
    if (tbodyUsuarios) {
        filasOriginalesUsuarios = Array.from(tbodyUsuarios.querySelectorAll('tr'));
    }
});

function gestionarOrdenacionUsuarios(columnaKey, columnaIndex) {
    const tbody = document.getElementById('body-usuarios');
    if (!tbody) return;

    if (estadosOrdenacionUsuarios[columnaKey] === 'ninguno') {
        estadosOrdenacionUsuarios[columnaKey] = 'asc';
    } else if (estadosOrdenacionUsuarios[columnaKey] === 'asc') {
        estadosOrdenacionUsuarios[columnaKey] = 'desc';
    } else {
        estadosOrdenacionUsuarios[columnaKey] = 'ninguno';
    }

    Object.keys(estadosOrdenacionUsuarios).forEach(key => {
        if (key !== columnaKey) estadosOrdenacionUsuarios[key] = 'ninguno';
    });

    document.getElementById('indicador-user-name').innerText = estadosOrdenacionUsuarios.name === 'asc' ? '↑' : (estadosOrdenacionUsuarios.name === 'desc' ? '↓' : '↕');
    document.getElementById('indicador-user-email').innerText = estadosOrdenacionUsuarios.email === 'asc' ? '↑' : (estadosOrdenacionUsuarios.email === 'desc' ? '↓' : '↕');
    document.getElementById('indicador-user-rol').innerText = estadosOrdenacionUsuarios.rol === 'asc' ? '↑' : (estadosOrdenacionUsuarios.rol === 'desc' ? '↓' : '↕');

    if (estadosOrdenacionUsuarios[columnaKey] === 'ninguno') {
        tbody.innerHTML = '';
        filasOriginalesUsuarios.forEach(fila => tbody.appendChild(fila));
    } else {
        const filasParaOrdenar = Array.from(tbody.querySelectorAll('tr'));
        const esAscendente = estadosOrdenacionUsuarios[columnaKey] === 'asc';

        filasParaOrdenar.sort((filaA, filaB) => {
            const celdaA = filaA.children[columnaIndex].innerText.trim();
            const celdaB = filaB.children[columnaIndex].innerText.trim();

            return esAscendente 
                ? celdaA.localeCompare(celdaB) 
                : celdaB.localeCompare(celdaA);
        });

        tbody.innerHTML = '';
        filasParaOrdenar.forEach(fila => tbody.appendChild(fila));
    }
}

let filasOriginalesPaquetes = [];

const estadosOrdenacion = {
    titulo: 'ninguno',
    precio: 'ninguno'
};

document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById('body-paquetes');
    if (tbody) {
        filasOriginalesPaquetes = Array.from(tbody.querySelectorAll('tr'));
    }
});

function gestionarOrdenacion(columnaKey, columnaIndex, tipo) {
    const tbody = document.getElementById('body-paquetes');
    if (!tbody) return;

    if (estadosOrdenacion[columnaKey] === 'ninguno') {
        estadosOrdenacion[columnaKey] = 'asc';
    } else if (estadosOrdenacion[columnaKey] === 'asc') {
        estadosOrdenacion[columnaKey] = 'desc';
    } else {
        estadosOrdenacion[columnaKey] = 'ninguno';
    }

    Object.keys(estadosOrdenacion).forEach(key => {
        if (key !== columnaKey) estadosOrdenacion[key] = 'ninguno';
    });

    document.getElementById('indicador-titulo').innerText = estadosOrdenacion.titulo === 'asc' ? '↑' : (estadosOrdenacion.titulo === 'desc' ? '↓' : '↕');
    document.getElementById('indicador-precio').innerText = estadosOrdenacion.precio === 'asc' ? '↑' : (estadosOrdenacion.precio === 'desc' ? '↓' : '↕');

    if (estadosOrdenacion[columnaKey] === 'ninguno') {
        tbody.innerHTML = '';
        filasOriginalesPaquetes.forEach(fila => tbody.appendChild(fila));
    } else {
        const filasParaOrdenar = Array.from(tbody.querySelectorAll('tr'));
        const esAscendente = estadosOrdenacion[columnaKey] === 'asc';

        filasParaOrdenar.sort((filaA, filaB) => {
            let celdaA = filaA.children[columnaIndex].innerText.trim();
            let celdaB = filaB.children[columnaIndex].innerText.trim();

            if (tipo === 'numero') {
                celdaA = parseFloat(celdaA.replace(/[^0-9.-]+/g, ""));
                celdaB = parseFloat(celdaB.replace(/[^0-9.-]+/g, ""));
                return esAscendente ? celdaA - celdaB : celdaB - celdaA;
            } else {
                return esAscendente ? celdaA.localeCompare(celdaB) : celdaB.localeCompare(celdaA);
            }
        });

        tbody.innerHTML = '';
        filasParaOrdenar.forEach(fila => tbody.appendChild(fila));
    }
}

window.onclick = function(event) {
    const modalUser = document.getElementById('modal-eliminar-usuario');
    const modalPack = document.getElementById('modal-eliminar-paquete');
    if (event.target == modalUser) cerrarModalUsuario();
    if (event.target == modalPack) cerrarModalPaquete();
}
</script>

@endsection