@extends('layouts.app')

@section('title', 'Cancelación Exitosa')

@section('content')
<div class="bg-gradient-to-b from-green-50 to-white min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            
            <!-- Mensaje de Éxito con Animación -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-28 h-28 bg-gradient-to-br from-green-400 to-green-600 rounded-full mb-6 shadow-lg">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-3">¡Cancelación Exitosa!</h1>
                <p class="text-xl text-gray-600">Tu reserva ha sido cancelada correctamente</p>
            </div>

            <!-- Detalles de la Cancelación -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <!-- Header del Card -->
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 text-white p-6">
                    <h2 class="text-2xl font-bold flex items-center">
                        <svg class="w-7 h-7 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                        Detalles de la Reserva Cancelada
                    </h2>
                </div>

                <!-- Body del Card -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Recinto -->
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <p class="text-sm text-gray-500 mb-1">Recinto</p>
                            <p class="text-lg font-bold text-gray-800">{{ $reserva->recinto->nombre }}</p>
                        </div>
                        
                        <!-- Organización -->
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-purple-500">
                            <p class="text-sm text-gray-500 mb-1">Organización</p>
                            <p class="text-lg font-bold text-gray-800">{{ $reserva->nombre_organizacion }}</p>
                        </div>
                        
                        <!-- Fecha -->
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-green-500">
                            <p class="text-sm text-gray-500 mb-1">Fecha de la Reserva</p>
                            <p class="text-lg font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}
                            </p>
                        </div>
                        
                        <!-- Horario -->
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-orange-500">
                            <p class="text-sm text-gray-500 mb-1">Horario</p>
                            <p class="text-lg font-bold text-gray-800">
                                @php
                                    $inicio = \Carbon\Carbon::parse($reserva->hora_inicio);
                                    $fin = \Carbon\Carbon::parse($reserva->hora_fin);
                                    $duracion = $inicio->diffInHours($fin);
                                @endphp
                                {{ $inicio->format('H:i') }} - {{ $fin->format('H:i') }}
                                <span class="text-sm text-gray-500 font-normal">({{ $duracion }} horas)</span>
                            </p>
                        </div>
                        
                        <!-- Personas -->
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-indigo-500">
                            <p class="text-sm text-gray-500 mb-1">Cantidad de Personas</p>
                            <p class="text-lg font-bold text-gray-800">{{ $reserva->cantidad_personas }}</p>
                        </div>
                        
                        <!-- Fecha de Cancelación -->
                        <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                            <p class="text-sm text-red-600 mb-1">Cancelada el</p>
                            <p class="text-lg font-bold text-red-700">
                                {{ \Carbon\Carbon::parse($reserva->fecha_cancelacion)->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Motivo de Cancelación (si existe) -->
                    @if($reserva->motivo_cancelacion)
                    <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                        <p class="text-sm font-semibold text-yellow-800 mb-2">Motivo de la Cancelación:</p>
                        <p class="text-gray-700 italic">"{{ $reserva->motivo_cancelacion }}"</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Confirmación de Correo -->
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-500 p-6 mb-6 rounded-r-xl shadow-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="font-bold text-blue-900 text-lg mb-1">Correo de Confirmación Enviado</p>
                        <p class="text-blue-800">
                            Hemos enviado un correo de confirmación con todos los detalles a: 
                            <strong class="text-blue-900">{{ $reserva->email }}</strong>
                        </p>
                        <p class="text-sm text-blue-700 mt-2">
                            Revisa tu bandeja de entrada y la carpeta de spam.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h3 class="font-bold text-gray-800 text-xl mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    ¿Qué sigue ahora?
                </h3>
                <div class="space-y-3">
                    <div class="flex items-start bg-green-50 p-4 rounded-lg">
                        <span class="flex-shrink-0 w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="text-gray-700">
                            El horario <strong>quedará disponible inmediatamente</strong> para otras organizaciones
                        </span>
                    </div>
                    <div class="flex items-start bg-blue-50 p-4 rounded-lg">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="text-gray-700">
                            Puedes <strong>realizar una nueva reserva</strong> en cualquier momento ingresando al sistema
                        </span>
                    </div>
                    <div class="flex items-start bg-purple-50 p-4 rounded-lg">
                        <span class="flex-shrink-0 w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        <span class="text-gray-700">
                            Si tienes dudas, puedes <strong>contactar al Departamento de Deportes</strong> de la Municipalidad
                        </span>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('home') }}" 
                   class="flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Volver al Inicio
                </a>
                
                <a href="{{ route('calendario') }}" 
                   class="flex items-center justify-center bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Hacer Nueva Reserva
                </a>
            </div>

            <!-- Mensaje Final -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Gracias por utilizar el Sistema de Reservas Deportivas de la <strong>Municipalidad de Arica</strong>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection