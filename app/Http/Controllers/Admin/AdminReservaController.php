<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Recinto;
use App\Mail\ReservaAprobada;
use App\Mail\ReservaRechazada;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminReservaController extends Controller
{
    /**
     * Mostrar listado de reservas con filtros
     */
    public function index(Request $request)
    {
        $query = Reserva::with(['recinto']);

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por recinto
        if ($request->filled('recinto_id')) {
            $query->where('recinto_id', $request->recinto_id);
        }

        // Filtro por fecha desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_reserva', '>=', $request->fecha_desde);
        }

        // Filtro por fecha hasta
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_reserva', '<=', $request->fecha_hasta);
        }

        // Ordenar por fecha de reserva descendente
        $reservas = $query->orderBy('fecha_reserva', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->paginate(15)
            ->appends($request->query());
        
        $recintos = Recinto::orderBy('nombre')->get();
        
        return view('admin.reservas.index', compact('reservas', 'recintos'));
    }

    /**
     * Mostrar detalles de una reserva
     */
    public function show(Reserva $reserva)
    {
        $reserva->load(['recinto', 'aprobadaPor']);
        
        return view('admin.reservas.show', compact('reserva'));
    }

    /**
     * Aprobar una reserva
     */
    public function aprobar(Reserva $reserva)
    {
        // Verificar que esté pendiente
        if ($reserva->estado !== 'pendiente') {
            return redirect()->route('admin.reservas.show', $reserva)
                ->with('error', 'Esta reserva ya fue procesada anteriormente.');
        }

        // Generar código de cancelación si no existe
        if (!$reserva->codigo_cancelacion) {
            $reserva->codigo_cancelacion = $this->generarCodigoCancelacion();
        }
        
        // Actualizar estado
        $reserva->estado = 'aprobada';
        $reserva->fecha_respuesta = now();
        $reserva->aprobada_por = auth()->id();
        $reserva->save();
        
        // Log detallado antes de enviar
        Log::info('=== INICIANDO ENVÍO DE EMAIL DE APROBACIÓN ===');
        Log::info('Reserva ID: ' . $reserva->id);
        Log::info('Email destino: ' . $reserva->email);
        Log::info('Código cancelación: ' . $reserva->codigo_cancelacion);
        
        // Enviar correo de aprobación con el código
        try {
            Mail::to($reserva->email)->send(new ReservaAprobada($reserva));
            
            Log::info('✅ Email de aprobación enviado exitosamente');
            
            return redirect()->route('admin.reservas.show', $reserva)
                ->with('success', 'Reserva aprobada correctamente. Se ha enviado un correo de confirmación a ' . $reserva->email);
                
        } catch (\Exception $e) {
            Log::error('❌ ERROR AL ENVIAR EMAIL DE APROBACIÓN');
            Log::error('Mensaje: ' . $e->getMessage());
            Log::error('Archivo: ' . $e->getFile());
            Log::error('Línea: ' . $e->getLine());
            
            return redirect()->route('admin.reservas.show', $reserva)
                ->with('warning', 'Reserva aprobada, pero hubo un problema al enviar el correo. Error: ' . $e->getMessage());
        }
    }

    /**
     * Rechazar una reserva
     */
    public function rechazar(Request $request, Reserva $reserva)
    {
        // Verificar que esté pendiente
        if ($reserva->estado !== 'pendiente') {
            return redirect()->route('admin.reservas.show', $reserva)
                ->with('error', 'Esta reserva ya fue procesada anteriormente.');
        }

        $request->validate([
            'motivo_rechazo' => 'required|string|max:500'
        ], [
            'motivo_rechazo.required' => 'Debes proporcionar un motivo de rechazo',
            'motivo_rechazo.max' => 'El motivo no puede exceder 500 caracteres'
        ]);
        
        $reserva->estado = 'rechazada';
        $reserva->fecha_respuesta = now();
        $reserva->motivo_rechazo = $request->motivo_rechazo;
        $reserva->aprobada_por = auth()->id();
        $reserva->save();
        
        // Log detallado antes de enviar
        Log::info('=== INICIANDO ENVÍO DE EMAIL DE RECHAZO ===');
        Log::info('Reserva ID: ' . $reserva->id);
        Log::info('Email destino: ' . $reserva->email);
        Log::info('Motivo: ' . $reserva->motivo_rechazo);
        
        // Enviar correo de rechazo
        try {
            Mail::to($reserva->email)->send(new ReservaRechazada($reserva));
            
            Log::info('✅ Email de rechazo enviado exitosamente');
            
            return redirect()->route('admin.reservas.show', $reserva)
                ->with('success', 'Reserva rechazada. Se ha notificado al solicitante.');
                
        } catch (\Exception $e) {
            Log::error('❌ ERROR AL ENVIAR EMAIL DE RECHAZO');
            Log::error('Mensaje: ' . $e->getMessage());
            Log::error('Archivo: ' . $e->getFile());
            Log::error('Línea: ' . $e->getLine());
            
            return redirect()->route('admin.reservas.show', $reserva)
                ->with('warning', 'Reserva rechazada, pero hubo un problema al enviar el correo. Error: ' . $e->getMessage());
        }
    }

    /**
     * Genera un código único de cancelación
     */
    private function generarCodigoCancelacion()
    {
        do {
            $codigo = strtoupper(Str::random(8) . '-' . Str::random(8));
        } while (Reserva::where('codigo_cancelacion', $codigo)->exists());
        
        return $codigo;
    }
}