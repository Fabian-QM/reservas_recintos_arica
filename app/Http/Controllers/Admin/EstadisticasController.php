<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Recinto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadisticasController extends Controller
{
    public function index(Request $request)
    {
        // Rango de fechas (por defecto últimos 30 días)
        $fechaDesde = $request->input('fecha_desde', now()->subDays(30)->format('Y-m-d'));
        $fechaHasta = $request->input('fecha_hasta', now()->format('Y-m-d'));

        // Estadísticas generales
        $totalReservas = Reserva::whereBetween('created_at', [$fechaDesde, $fechaHasta])->count();
        $reservasAprobadas = Reserva::where('estado', 'aprobada')
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->count();
        $reservasRechazadas = Reserva::where('estado', 'rechazada')
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->count();
        $reservasPendientes = Reserva::where('estado', 'pendiente')
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->count();
        $reservasCanceladas = Reserva::where('estado', 'cancelada')
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->count();

        // Tasa de aprobación vs rechazo
        $tasaAprobacion = $totalReservas > 0 ? round(($reservasAprobadas / $totalReservas) * 100, 1) : 0;
        $tasaRechazo = $totalReservas > 0 ? round(($reservasRechazadas / $totalReservas) * 100, 1) : 0;

        // Recintos más solicitados
        $recintosMasSolicitados = Reserva::select('recinto_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->with('recinto')
            ->groupBy('recinto_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Organizaciones más recurrentes
        $organizacionesRecurrentes = Reserva::select('nombre_organizacion', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->groupBy('nombre_organizacion')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Deportes más practicados
        $deportesMasPracticados = Reserva::select('deporte', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->whereNotNull('deporte')
            ->where('deporte', '!=', '')
            ->groupBy('deporte')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Horarios más solicitados (agrupados por hora de inicio)
        $horariosMasSolicitados = Reserva::select(DB::raw('HOUR(hora_inicio) as hora'), DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->groupBy('hora')
            ->orderBy('hora', 'asc')
            ->get();

        // Días de la semana más solicitados
        $diasMasSolicitados = Reserva::select(
                DB::raw('DAYOFWEEK(fecha_reserva) as dia_numero'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->groupBy('dia_numero')
            ->orderBy('dia_numero', 'asc')
            ->get()
            ->map(function ($item) {
                $dias = [
                    1 => 'Domingo',
                    2 => 'Lunes',
                    3 => 'Martes',
                    4 => 'Miércoles',
                    5 => 'Jueves',
                    6 => 'Viernes',
                    7 => 'Sábado'
                ];
                $item->dia_nombre = $dias[$item->dia_numero];
                return $item;
            });

        // Tendencia de reservas por mes (últimos 12 meses)
        $tendenciaMensual = Reserva::select(
                DB::raw('YEAR(created_at) as año'),
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('año', 'mes')
            ->orderBy('año', 'asc')
            ->orderBy('mes', 'asc')
            ->get()
            ->map(function ($item) {
                $meses = [
                    1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
                    5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
                    9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
                ];
                $item->mes_nombre = $meses[$item->mes];
                return $item;
            });

        return view('admin.estadisticas.index', compact(
            'totalReservas',
            'reservasAprobadas',
            'reservasRechazadas',
            'reservasPendientes',
            'reservasCanceladas',
            'tasaAprobacion',
            'tasaRechazo',
            'recintosMasSolicitados',
            'organizacionesRecurrentes',
            'deportesMasPracticados',
            'horariosMasSolicitados',
            'diasMasSolicitados',
            'tendenciaMensual',
            'fechaDesde',
            'fechaHasta'
        ));
    }
}