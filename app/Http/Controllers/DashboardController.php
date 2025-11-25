<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Recinto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas
        $reservasPendientes = Reserva::where('estado', 'pendiente')->count();
        
        $reservasHoy = Reserva::whereDate('fecha_reserva', Carbon::today())
            ->where('estado', 'aprobada')
            ->whereNull('fecha_cancelacion')
            ->count();
        
        $reservasEsteMes = Reserva::whereYear('fecha_reserva', Carbon::now()->year)
            ->whereMonth('fecha_reserva', Carbon::now()->month)
            ->where('estado', 'aprobada')
            ->whereNull('fecha_cancelacion')
            ->count();

        // Conteo de recintos activos
        $recintosActivos = Recinto::where('activo', true)->count();
        
        // Últimas reservas pendientes
        $ultimasReservasPendientes = Reserva::where('estado', 'pendiente')
            ->with('recinto')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'reservasPendientes',
            'reservasHoy',
            'reservasEsteMes',
            'recintosActivos',
            'ultimasReservasPendientes'
        ));
    }
}