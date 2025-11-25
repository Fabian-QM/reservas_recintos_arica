@extends('layouts.app')

@section('title', 'Calendario de Recintos Deportivos - Municipalidad de Arica')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                Sistema de Reservas - Recintos Deportivos Arica
            </h1>
            <p class="text-gray-600">
                Consulta la disponibilidad y solicita reservas para nuestros recintos deportivos
            </p>
        </div>

        <!-- Cards de Recintos Mejorados -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            @foreach($recintos as $recinto)
            @php
                $horarios = is_array($recinto->horarios_disponibles) 
                    ? $recinto->horarios_disponibles 
                    : json_decode($recinto->horarios_disponibles, true);
                
                $diasCerrados = is_array($recinto->dias_cerrados) 
                    ? $recinto->dias_cerrados 
                    : ($recinto->dias_cerrados ? json_decode($recinto->dias_cerrados, true) : null);
            @endphp
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <!-- Header del Card -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                    <h3 class="text-xl font-bold mb-2">{{ $recinto->nombre }}</h3>
                    <p class="text-sm text-blue-100">{{ $recinto->descripcion ?? 'Multicancha techada para deportes varios' }}</p>
                </div>
                
                <!-- Body del Card -->
                <div class="p-6">
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-sm"><strong>Capacidad:</strong> {{ $recinto->capacidad_maxima ?? '100' }} personas</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm"><strong>Horario:</strong> {{ $horarios['inicio'] ?? '08:00' }} - {{ $horarios['fin'] ?? '23:00' }}</span>
                        </div>
                        @if($diasCerrados && count($diasCerrados) > 0)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-3">
                            <p class="text-yellow-800 text-sm font-semibold flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Cerrado: Lunes (mantenimiento)
                            </p>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('reservas.create', $recinto) }}" 
                       class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        Solicitar Reserva
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Calendario Semanal Mejorado -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Disponibilidad Próximos 7 Días</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
                @for($i = 0; $i < 7; $i++)
                    @php
                        $fecha = now()->addDays($i);
                        $fechaString = $fecha->format('Y-m-d');
                        $esHoy = $fecha->isToday();
                        
                        // Configurar Carbon en español
                        \Carbon\Carbon::setLocale('es');
                    @endphp
                    
                    <div class="bg-gradient-to-b from-gray-50 to-white rounded-lg border-2 {{ $esHoy ? 'border-blue-500 shadow-lg' : 'border-gray-200' }} overflow-hidden">
                        <!-- Header del día -->
                        <div class="bg-gradient-to-r {{ $esHoy ? 'from-blue-600 to-blue-700' : 'from-gray-700 to-gray-800' }} text-white p-3 text-center">
                            <div class="text-sm font-semibold uppercase">
                                {{ $fecha->locale('es')->isoFormat('ddd') }}
                                @if($esHoy)
                                    <span class="text-xs block mt-1">(Hoy)</span>
                                @endif
                            </div>
                            <div class="text-2xl font-bold mt-1">
                                {{ $fecha->format('d') }}
                            </div>
                            <div class="text-xs mt-1">
                                {{ $fecha->locale('es')->isoFormat('MMM') }}
                            </div>
                        </div>
                        
                        <!-- Recintos -->
                        <div class="p-3 space-y-2">
                            @if($recintos->count() > 0)
                                @foreach($recintos as $recinto)
                                    @php
                                        // Verificar si hay reservas NO canceladas para este recinto en esta fecha
                                        $tieneReservas = isset($reservas[$recinto->id][$fechaString]) && 
                                                        $reservas[$recinto->id][$fechaString]->count() > 0;
                                        
                                        $diasCerradosCalendario = is_array($recinto->dias_cerrados) 
                                            ? $recinto->dias_cerrados 
                                            : ($recinto->dias_cerrados ? json_decode($recinto->dias_cerrados, true) : null);
                                        
                                        $esDiaCerrado = false;
                                        if ($diasCerradosCalendario && is_array($diasCerradosCalendario)) {
                                            $esDiaCerrado = in_array(strtolower($fecha->format('l')), $diasCerradosCalendario);
                                        }
                                    @endphp
                                    
                                    <button onclick="verDisponibilidadRecinto({{ $recinto->id }}, '{{ $recinto->nombre }}', '{{ $fechaString }}')"
                                        class="w-full text-xs p-2 rounded-lg transition-all hover:shadow-md border {{ 
                                        $esDiaCerrado ? 'bg-yellow-50 text-yellow-800 border-yellow-200 hover:bg-yellow-100' : 
                                        ($tieneReservas ? 'bg-red-50 text-red-800 border-red-200 hover:bg-red-100' : 'bg-green-50 text-green-800 border-green-200 hover:bg-green-100') 
                                    }}">
                                        <div class="font-semibold mb-1">{{ Str::limit($recinto->nombre, 15) }}</div>
                                        <div class="flex items-center justify-center text-xs">
                                            @if($esDiaCerrado)
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Cerrado</span>
                                            @elseif($tieneReservas)
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Ocupado</span>
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Disponible</span>
                                            @endif
                                        </div>
                                    </button>
                                @endforeach
                            @else
                                <div class="text-xs text-gray-500 text-center py-4">
                                    Sin recintos
                                </div>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        
        <!-- Información adicional mejorada -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-600 rounded-lg p-6">
            <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                Información Importante
            </h3>
            <ul class="space-y-2 text-blue-800">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Las reservas deben solicitarse con al menos 24 horas de anticipación</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>La Piscina Olímpica permanece cerrada todos los lunes por mantenimiento</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Horario de funcionamiento: 08:00 - 23:00 horas</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Todas las solicitudes requieren aprobación del jefe de recintos</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Recibirá confirmación por correo electrónico</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Modal de Disponibilidad -->
<div id="modalDisponibilidad" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Header -->
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-t-xl z-10">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-2xl font-bold mb-1" id="modalRecintoNombre">Cargando...</h3>
                    <p class="text-blue-100" id="modalFecha">Cargando...</p>
                </div>
                <button onclick="cerrarModal()" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Loading State -->
        <div id="modalLoading" class="p-8 text-center">
            <svg class="animate-spin h-12 w-12 text-blue-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-600">Cargando disponibilidad...</p>
        </div>

        <!-- Content -->
        <div id="modalContent" class="hidden p-6">
            <!-- Estado General -->
            <div id="estadoGeneral" class="mb-6"></div>

            <!-- Franjas Horarias -->
            <div class="mb-4">
                <h4 class="text-lg font-bold text-gray-800 mb-3">Disponibilidad por Horario</h4>
                <div id="franjasHorarias" class="space-y-2"></div>
            </div>

            <!-- Botón de Reserva -->
            <div class="mt-6">
                <a id="btnReservar" href="#" 
                   class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors shadow-md hover:shadow-lg">
                    Solicitar Reserva
                </a>
            </div>
        </div>

        <!-- Error State -->
        <div id="modalError" class="hidden p-6 text-center">
            <svg class="w-12 h-12 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-red-600 font-semibold mb-2">Error al cargar la disponibilidad</p>
            <p class="text-gray-600 text-sm mb-4" id="errorMessage"></p>
            <button onclick="cerrarModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                Cerrar
            </button>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function verDisponibilidadRecinto(recintoId, recintoNombre, fecha) {
    document.getElementById('modalDisponibilidad').classList.remove('hidden');
    document.getElementById('modalLoading').classList.remove('hidden');
    document.getElementById('modalContent').classList.add('hidden');
    document.getElementById('modalError').classList.add('hidden');

    fetch(`/api/disponibilidad?recinto_id=${recintoId}&fecha=${fecha}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta API:', data);
        mostrarDisponibilidad(data, recintoId);
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarError('No se pudo cargar la disponibilidad. Por favor, intenta nuevamente.');
    });
}

function mostrarError(mensaje) {
    document.getElementById('modalLoading').classList.add('hidden');
    document.getElementById('modalContent').classList.add('hidden');
    document.getElementById('modalError').classList.remove('hidden');
    document.getElementById('errorMessage').textContent = mensaje;
}

function mostrarDisponibilidad(data, recintoId) {
    if (!data.horarios || !Array.isArray(data.horarios)) {
        console.error('Estructura de datos inválida:', data);
        mostrarError('La respuesta del servidor no tiene el formato esperado.');
        return;
    }

    document.getElementById('modalLoading').classList.add('hidden');
    document.getElementById('modalContent').classList.remove('hidden');

    document.getElementById('modalRecintoNombre').textContent = data.recinto || 'Recinto';
    document.getElementById('modalFecha').textContent = data.fecha || new Date().toLocaleDateString();

    const estadoDiv = document.getElementById('estadoGeneral');
    const disponibles = data.horarios.filter(h => h.disponible).length;
    const total = data.horarios.length;
    
    estadoDiv.innerHTML = `
        <div class="grid grid-cols-3 gap-4 text-center">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <p class="text-2xl font-bold text-blue-600">${total}</p>
                <p class="text-sm text-gray-600">Franjas Totales</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <p class="text-2xl font-bold text-green-600">${disponibles}</p>
                <p class="text-sm text-gray-600">Disponibles</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                <p class="text-2xl font-bold text-red-600">${total - disponibles}</p>
                <p class="text-sm text-gray-600">Ocupadas</p>
            </div>
        </div>
    `;

    const franjasDiv = document.getElementById('franjasHorarias');
    franjasDiv.innerHTML = data.horarios.map(horario => {
        let bgColor, textColor, borderColor, icon, estadoHtml;
        
        if (horario.disponible) {
            bgColor = 'bg-green-50';
            borderColor = 'border-green-200';
            textColor = 'text-green-700';
            icon = '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            estadoHtml = '<p class="text-sm ' + textColor + ' font-medium">Disponible</p>';
        } else {
            bgColor = 'bg-red-50';
            borderColor = 'border-red-200';
            textColor = 'text-red-700';
            icon = '<svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            estadoHtml = '<p class="text-sm ' + textColor + ' font-medium">No disponible</p>';
        }

        return `
            <div class="${bgColor} ${borderColor} border-2 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        ${icon}
                        <div>
                            <p class="font-bold ${textColor} text-base">${horario.hora_inicio} - ${horario.hora_fin}</p>
                            ${estadoHtml}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    const soloFecha = data.fecha.match(/\d{4}-\d{2}-\d{2}/);
    const fechaFormateada = soloFecha ? soloFecha[0] : new Date().toISOString().split('T')[0];
    
    document.getElementById('btnReservar').href = `/reservas/crear/${recintoId}?fecha=${fechaFormateada}`;
}

function cerrarModal() {
    document.getElementById('modalDisponibilidad').classList.add('hidden');
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        cerrarModal();
    }
});

document.getElementById('modalDisponibilidad').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModal();
    }
});
</script>
@endsection