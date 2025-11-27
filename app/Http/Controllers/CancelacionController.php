<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ReservaCancelada;

class CancelacionController extends Controller
{
    /**
     * Mostrar el formulario de cancelación
     */
    public function mostrarFormulario()
    {
        return view('reservas.cancelar');
    }
    
    /**
     * Buscar reserva por código
     */
    public function buscarReserva(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string'
        ], [
            'codigo.required' => 'Debes ingresar un código de cancelación'
        ]);
        
        $codigo = strtoupper(trim($request->codigo));
        
        Log::info('Buscando reserva con código: ' . $codigo);
        
        $reserva = Reserva::buscarPorCodigo($codigo);
        
        if (!$reserva) {
            Log::warning('Código no encontrado: ' . $codigo);
            return redirect()->back()
                ->withInput()
                ->withErrors(['codigo' => 'El código ingresado no es válido o no existe.']);
        }
        
        Log::info('Reserva encontrada', [
            'id' => $reserva->id,
            'estado' => $reserva->estado
        ]);
        
        // Verificar si la reserva puede cancelarse
        if (!$reserva->esCancelable()) {
            $mensaje = 'Esta reserva no puede ser cancelada. ';
            
            if ($reserva->estado === 'cancelada') {
                $mensaje .= 'La reserva ya fue cancelada anteriormente.';
            } elseif ($reserva->estado === 'rechazada') {
                $mensaje .= 'La reserva fue rechazada y no requiere cancelación.';
            } elseif ($reserva->estado === 'pendiente') {
                $mensaje .= 'La reserva aún está pendiente de aprobación. Solo se pueden cancelar reservas aprobadas.';
            } else {
                $mensaje .= 'La fecha de la reserva ya pasó.';
            }
            
            Log::warning('Reserva no cancelable', [
                'id' => $reserva->id,
                'estado' => $reserva->estado
            ]);
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['codigo' => $mensaje]);
        }
        
        // Cargar relación del recinto
        $reserva->load('recinto');
        
        return view('reservas.confirmar-cancelacion', compact('reserva'));
    }
    
    /**
     * Procesar la cancelación
     */
    public function cancelar(Request $request, $codigo)
    {
        $request->validate([
            'motivo' => 'required|string|max:500'
        ], [
            'motivo.required' => 'Debes proporcionar un motivo de cancelación',
            'motivo.max' => 'El motivo no puede exceder 500 caracteres'
        ]);
        
        $codigo = strtoupper(trim($codigo));
        $reserva = Reserva::buscarPorCodigo($codigo);
        
        if (!$reserva) {
            return redirect()->route('cancelacion.formulario')
                ->withErrors(['error' => 'Reserva no encontrada.']);
        }
        
        if (!$reserva->esCancelable()) {
            return redirect()->route('cancelacion.formulario')
                ->withErrors(['error' => 'Esta reserva no puede ser cancelada.']);
        }
        
        // Log antes de cancelar
        Log::info('Cancelando reserva', [
            'id' => $reserva->id,
            'estado_anterior' => $reserva->estado
        ]);
        
        // Cancelar la reserva (esto cambia el estado de 'aprobada' a 'cancelada')
        $reserva->cancelarPorUsuario($request->motivo);
        
        // Log después de cancelar
        Log::info('Reserva cancelada', [
            'id' => $reserva->id,
            'estado_nuevo' => $reserva->estado
        ]);
        
        // Recargar con la relación del recinto
        $reserva = $reserva->fresh(['recinto']);
        
        // Enviar correo de confirmación de cancelación
        try {
            Log::info('Enviando email de cancelación');
            Mail::to($reserva->email)->send(new ReservaCancelada($reserva));
            Log::info('Email enviado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error enviando correo de cancelación: ' . $e->getMessage());
        }
        
        // CAMBIO CRÍTICO: Pasar el ID en lugar del objeto completo
        return redirect()->route('cancelacion.exito', ['id' => $reserva->id]);
    }
    
    /**
     * Mostrar página de éxito
     */
    public function exito(Request $request)
    {
        $reservaId = $request->input('id');
        
        if (!$reservaId) {
            return redirect()->route('home');
        }
        
        $reserva = Reserva::with('recinto')->find($reservaId);
        
        if (!$reserva) {
            return redirect()->route('home');
        }
        
        return view('reservas.cancelacion-exitosa', compact('reserva'));
    }
}