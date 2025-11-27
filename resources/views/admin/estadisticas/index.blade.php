@extends('layouts.app')

@section('title', 'Estadísticas y Reportes')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Estadísticas y Reportes</h1>
                    <p class="text-gray-600 mt-1">Análisis operacional del sistema de reservas</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </a>
            </div>
        </div>

        <!-- Filtros de Fecha -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.estadisticas.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" 
                           value="{{ $fechaDesde }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div class="flex-1 min-w-[200px]">
                    <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" 
                           value="{{ $fechaHasta }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <button type="submit" 
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    Aplicar Filtros
                </button>
            </form>
        </div>

        <!-- Estadísticas Generales -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <p class="text-sm text-gray-600 font-medium">Total Reservas</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalReservas }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <p class="text-sm text-gray-600 font-medium">Aprobadas</p>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $reservasAprobadas }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
                <p class="text-sm text-gray-600 font-medium">Rechazadas</p>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ $reservasRechazadas }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <p class="text-sm text-gray-600 font-medium">Pendientes</p>
                <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $reservasPendientes }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-gray-500">
                <p class="text-sm text-gray-600 font-medium">Canceladas</p>
                <p class="text-3xl font-bold text-gray-600 mt-2">{{ $reservasCanceladas }}</p>
            </div>
        </div>

        <!-- Gráficos: Fila 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            
            <!-- Tasa de Aprobación vs Rechazo -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Tasa de Aprobación vs Rechazo</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="tasaAprobacionChart"></canvas>
                </div>
            </div>

            <!-- Recintos Más Solicitados -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Recintos Más Solicitados</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="recintosSolicitadosChart"></canvas>
                </div>
            </div>

        </div>

        <!-- Gráficos: Fila 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            
            <!-- Organizaciones Recurrentes -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Organizaciones Más Recurrentes</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="organizacionesChart"></canvas>
                </div>
            </div>

            <!-- Deportes Más Practicados -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Deportes Más Practicados</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="deportesChart"></canvas>
                </div>
            </div>

        </div>

        <!-- Gráficos: Fila 3 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            
            <!-- Horarios Más Solicitados -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Horarios Más Solicitados</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="horariosChart"></canvas>
                </div>
            </div>

            <!-- Días Más Solicitados -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Días Más Solicitados</h3>
                <div style="position: relative; height: 300px;">
                    <canvas id="diasChart"></canvas>
                </div>
            </div>

        </div>

        <!-- Gráfico: Tendencia Mensual (Ancho completo) -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tendencia de Reservas (Últimos 12 Meses)</h3>
            <div style="position: relative; height: 350px;">
                <canvas id="tendenciaMensualChart"></canvas>
            </div>
        </div>

    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Configuración de colores
const colors = {
    primary: '#3b82f6',
    success: '#10b981',
    danger: '#ef4444',
    warning: '#f59e0b',
    info: '#06b6d4',
    purple: '#8b5cf6',
    pink: '#ec4899',
    indigo: '#6366f1'
};

// 1. Tasa de Aprobación vs Rechazo
new Chart(document.getElementById('tasaAprobacionChart'), {
    type: 'doughnut',
    data: {
        labels: ['Aprobadas', 'Rechazadas', 'Pendientes', 'Canceladas'],
        datasets: [{
            data: [{{ $reservasAprobadas }}, {{ $reservasRechazadas }}, {{ $reservasPendientes }}, {{ $reservasCanceladas }}],
            backgroundColor: [colors.success, colors.danger, colors.warning, '#6b7280'],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: { size: 12 }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const value = context.parsed;
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return context.label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// 2. Recintos Más Solicitados
new Chart(document.getElementById('recintosSolicitadosChart'), {
    type: 'bar',
    data: {
        labels: [
            @foreach($recintosMasSolicitados as $recinto)
                '{{ $recinto->recinto->nombre }}',
            @endforeach
        ],
        datasets: [{
            label: 'Reservas',
            data: [
                @foreach($recintosMasSolicitados as $recinto)
                    {{ $recinto->total }},
                @endforeach
            ],
            backgroundColor: colors.primary,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// 3. Organizaciones Más Recurrentes
new Chart(document.getElementById('organizacionesChart'), {
    type: 'bar',
    data: {
        labels: [
            @foreach($organizacionesRecurrentes as $org)
                '{{ Str::limit($org->nombre_organizacion, 20) }}',
            @endforeach
        ],
        datasets: [{
            label: 'Reservas',
            data: [
                @foreach($organizacionesRecurrentes as $org)
                    {{ $org->total }},
                @endforeach
            ],
            backgroundColor: colors.purple,
            borderRadius: 6
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// 4. Deportes Más Practicados
new Chart(document.getElementById('deportesChart'), {
    type: 'pie',
    data: {
        labels: [
            @foreach($deportesMasPracticados as $deporte)
                '{{ $deporte->deporte }}',
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($deportesMasPracticados as $deporte)
                    {{ $deporte->total }},
                @endforeach
            ],
            backgroundColor: [
                colors.primary, colors.success, colors.warning, colors.danger, 
                colors.purple, colors.pink, colors.indigo, colors.info,
                '#f97316', '#84cc16'
            ],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 10,
                    font: { size: 11 }
                }
            }
        }
    }
});

// 5. Horarios Más Solicitados
new Chart(document.getElementById('horariosChart'), {
    type: 'line',
    data: {
        labels: [
            @foreach($horariosMasSolicitados as $horario)
                '{{ str_pad($horario->hora, 2, "0", STR_PAD_LEFT) }}:00',
            @endforeach
        ],
        datasets: [{
            label: 'Reservas',
            data: [
                @foreach($horariosMasSolicitados as $horario)
                    {{ $horario->total }},
                @endforeach
            ],
            borderColor: colors.info,
            backgroundColor: colors.info + '20',
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointRadius: 5,
            pointBackgroundColor: colors.info
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// 6. Días Más Solicitados
new Chart(document.getElementById('diasChart'), {
    type: 'bar',
    data: {
        labels: [
            @foreach($diasMasSolicitados as $dia)
                '{{ $dia->dia_nombre }}',
            @endforeach
        ],
        datasets: [{
            label: 'Reservas',
            data: [
                @foreach($diasMasSolicitados as $dia)
                    {{ $dia->total }},
                @endforeach
            ],
            backgroundColor: [
                '#ef4444', '#3b82f6', '#10b981', '#f59e0b', 
                '#8b5cf6', '#ec4899', '#06b6d4'
            ],
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// 7. Tendencia Mensual
new Chart(document.getElementById('tendenciaMensualChart'), {
    type: 'line',
    data: {
        labels: [
            @foreach($tendenciaMensual as $mes)
                '{{ $mes->mes_nombre }} {{ $mes->año }}',
            @endforeach
        ],
        datasets: [{
            label: 'Reservas',
            data: [
                @foreach($tendenciaMensual as $mes)
                    {{ $mes->total }},
                @endforeach
            ],
            borderColor: colors.primary,
            backgroundColor: colors.primary + '20',
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointRadius: 6,
            pointBackgroundColor: colors.primary,
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
@endsection