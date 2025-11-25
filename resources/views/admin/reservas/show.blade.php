@extends('layouts.app')

@section('title', 'Detalle de Reserva')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('admin.reservas.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Volver a reservas</a>
        <div class="mt-2 flex justify-between items-start">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Detalle de Reserva #{{ $reserva->id }}</h2>
                <p class="text-gray-600 mt-1">Código: <span class="font-mono bg-gray-200 px-2 py-1 rounded">{{ $reserva->codigo_cancelacion ?? 'N/A' }}</span></p>
            </div>
            @if($reserva->estado === 'pendiente')
                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                    Pendiente
                </span>
            @elseif($reserva->estado === 'aprobada')
                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                    Aprobada
                </span>
            @else
                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                    Rechazada
                </span>
            @endif
        </div>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg mb-6">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Principal -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Card: Datos de la Organización -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Datos de la Organización
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Organización</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->nombre_organizacion }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Representante</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->representante_nombre }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">RUT</p>
                            <p class="font-semibold text-gray-900 font-mono">{{ $reserva->rut_formateado }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Teléfono</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->telefono }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Email</p>
                            <p class="font-semibold text-gray-900 break-all">{{ $reserva->email }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Región / Comuna</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->region ?? 'N/A' }}, {{ $reserva->comuna ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg col-span-2">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Dirección</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->direccion }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card: Detalles de la Reserva -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Detalles de la Reserva
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <p class="text-xs text-blue-600 uppercase tracking-wide mb-1">Recinto</p>
                            <p class="font-bold text-blue-900 text-lg">{{ $reserva->recinto->nombre }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Deporte</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->deporte ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Fecha</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->fecha_reserva->format('d/m/Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Horario</p>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }} 
                                ({{ \Carbon\Carbon::parse($reserva->hora_inicio)->diffInHours(\Carbon\Carbon::parse($reserva->hora_fin)) }} horas)
                            </p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Participantes</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->cantidad_personas }} personas</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Fecha de Solicitud</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($reserva->observaciones)
                        <div class="bg-gray-50 p-3 rounded-lg col-span-2">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Observaciones</p>
                            <p class="text-gray-900">{{ $reserva->observaciones }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Motivo de rechazo si existe -->
            @if($reserva->estado === 'rechazada' && $reserva->motivo_rechazo)
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-semibold text-red-800">Motivo de Rechazo:</h4>
                        <p class="text-sm text-red-700 mt-1">{{ $reserva->motivo_rechazo }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Alerta de Tiempo Pendiente -->
            @if($reserva->estado === 'pendiente')
            @php
                $horasPendientes = (int) $reserva->created_at->diffInHours(now());
                $diasPendientes = floor($horasPendientes / 24);
                $horasRestantes = $horasPendientes % 24;
            @endphp
            <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-orange-700">
                            <span class="font-bold">Atención:</span> Esta solicitud lleva 
                            @if($diasPendientes > 0)
                                <span class="font-bold">{{ $diasPendientes }} {{ $diasPendientes == 1 ? 'día' : 'días' }}</span>
                                @if($horasRestantes > 0)
                                    <span class="font-bold">y {{ $horasRestantes }} {{ $horasRestantes == 1 ? 'hora' : 'horas' }}</span>
                                @endif
                            @else
                                <span class="font-bold">{{ $horasRestantes }} {{ $horasRestantes == 1 ? 'hora' : 'horas' }}</span>
                            @endif
                            pendiente de revisión.
                        </p>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- Sidebar de Acciones -->
        <div class="space-y-6">
            
            <!-- Card: Acciones Principales -->
            @if($reserva->estado === 'pendiente')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-4">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>
                    <div class="space-y-3">
                        <button onclick="document.getElementById('modalAprobar').classList.remove('hidden')" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-md hover:shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Aprobar Reserva
                        </button>
                        <button onclick="document.getElementById('modalRechazar').classList.remove('hidden')" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-md hover:shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Rechazar Reserva
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Card: Estado e Historial -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de Estado</h3>
                    <div class="space-y-4">
                        <div class="border-l-4 {{ $reserva->estado === 'pendiente' ? 'border-yellow-400' : ($reserva->estado === 'aprobada' ? 'border-green-400' : 'border-red-400') }} pl-3">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Estado Actual</p>
                            <p class="font-bold text-gray-900 text-lg">{{ ucfirst($reserva->estado) }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Tiempo de Espera</p>
                            @php
                                $horasTotales = (int) $reserva->created_at->diffInHours(now());
                                $dias = floor($horasTotales / 24);
                                $horas = $horasTotales % 24;
                            @endphp
                            <p class="font-semibold text-gray-900">
                                @if($dias > 0)
                                    {{ $dias }} {{ $dias == 1 ? 'día' : 'días' }}
                                    @if($horas > 0)
                                        , {{ $horas }} {{ $horas == 1 ? 'hora' : 'horas' }}
                                    @endif
                                @else
                                    {{ $horas }} {{ $horas == 1 ? 'hora' : 'horas' }}
                                @endif
                            </p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Días hasta la Reserva</p>
                            @php
                                $diasHastaReserva = (int) now()->diffInDays($reserva->fecha_reserva, false);
                            @endphp
                            <p class="font-semibold text-gray-900">
                                @if($diasHastaReserva >= 0)
                                    {{ $diasHastaReserva }} {{ $diasHastaReserva == 1 ? 'día' : 'días' }}
                                @else
                                    Reserva pasada
                                @endif
                            </p>
                        </div>
                        @if($reserva->fecha_respuesta)
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Fecha de Respuesta</p>
                            <p class="font-semibold text-gray-900">{{ $reserva->fecha_respuesta->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card: Información del Recinto -->
            <div class="bg-blue-50 rounded-lg shadow-sm border border-blue-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">{{ $reserva->recinto->nombre }}</h3>
                    <div class="space-y-2 text-sm text-blue-800">
                        @if($reserva->recinto->capacidad ?? false)
                        <p><span class="font-semibold">Capacidad:</span> {{ $reserva->recinto->capacidad }} personas</p>
                        @endif
                        @if($reserva->recinto->tipo ?? false)
                        <p><span class="font-semibold">Tipo:</span> {{ $reserva->recinto->tipo }}</p>
                        @endif
                        @if($reserva->recinto->direccion ?? false)
                        <p><span class="font-semibold">Ubicación:</span> {{ $reserva->recinto->direccion }}</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Aprobar -->
<div id="modalAprobar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4 shadow-2xl">
        <form method="POST" action="{{ route('admin.reservas.aprobar', $reserva) }}">
            @csrf
            <div class="flex items-center mb-4">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Aprobar Reserva</h3>
            </div>
            
            <div class="mb-6">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <p class="text-green-800 text-sm">
                        <span class="font-semibold">{{ $reserva->nombre_organizacion }}</span> - {{ $reserva->recinto->nombre }}<br>
                        <span class="text-green-600">{{ $reserva->fecha_reserva->format('d/m/Y') }} de {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} a {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}</span>
                    </p>
                </div>
                
                <p class="text-gray-600 mb-4">¿Está seguro que desea aprobar esta reserva?</p>
                <p class="text-xs text-gray-500 mt-1">Se enviará un email de confirmación al solicitante con el código de cancelación.</p>
            </div>
            
            <div class="flex gap-3">
                <button type="button"
                        onclick="document.getElementById('modalAprobar').classList.add('hidden')"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-md">
                    ✓ Aprobar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Rechazar -->
<div id="modalRechazar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-lg w-full mx-4 shadow-2xl">
        <form method="POST" action="{{ route('admin.reservas.rechazar', $reserva) }}">
            @csrf
            <div class="flex items-center mb-4">
                <div class="bg-red-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Rechazar Reserva</h3>
            </div>
            
            <div class="mb-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <p class="text-red-800 text-sm">
                        <span class="font-semibold">{{ $reserva->nombre_organizacion }}</span> - {{ $reserva->recinto->nombre }}<br>
                        <span class="text-red-600">{{ $reserva->fecha_reserva->format('d/m/Y') }} de {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} a {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}</span>
                    </p>
                </div>
                
                <p class="text-gray-600 mb-4">Indique el motivo del rechazo:</p>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Motivo del rechazo <span class="text-red-500">*</span>
                    </label>
                    <textarea name="motivo_rechazo" 
                              rows="4" 
                              required
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"
                              placeholder="Ejemplo: El recinto ya está reservado en ese horario por otra organización..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">Se enviará un email al solicitante con este motivo.</p>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button type="button"
                        onclick="document.getElementById('modalRechazar').classList.add('hidden')"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-md">
                    ✗ Rechazar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection