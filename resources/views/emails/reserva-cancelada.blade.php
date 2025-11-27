<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.95;
            font-size: 15px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
        }
        .greeting strong {
            color: #111827;
        }
        .status-banner {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 5px solid #f59e0b;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .status-banner h3 {
            margin: 0 0 8px 0;
            color: #92400e;
            font-size: 20px;
            font-weight: 700;
        }
        .status-banner p {
            margin: 0;
            color: #78350f;
            font-size: 15px;
        }
        .details-section {
            background-color: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
        }
        .details-section h3 {
            margin: 0 0 20px 0;
            color: #111827;
            font-size: 20px;
            font-weight: 700;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
        }
        .detail-row {
            display: table;
            width: 100%;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            display: table-cell;
            font-weight: 600;
            color: #6b7280;
            width: 45%;
            font-size: 14px;
            padding-right: 15px;
        }
        .detail-value {
            display: table-cell;
            color: #111827;
            font-size: 15px;
            font-weight: 500;
        }
        .motivo-section {
            background-color: #fef2f2;
            border-left: 5px solid #dc2626;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .motivo-section h4 {
            margin: 0 0 12px 0;
            color: #991b1b;
            font-size: 16px;
            font-weight: 700;
        }
        .motivo-section p {
            margin: 0;
            color: #7f1d1d;
            font-style: italic;
            font-size: 15px;
            line-height: 1.6;
        }
        .info-box {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 5px solid #3b82f6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        .info-box h4 {
            margin: 0 0 15px 0;
            color: #1e40af;
            font-size: 18px;
            font-weight: 700;
        }
        .info-box ul {
            margin: 0;
            padding-left: 20px;
            color: #1e3a8a;
        }
        .info-box li {
            margin: 8px 0;
            font-size: 14px;
            line-height: 1.5;
        }
        .cta-button {
            text-align: center;
            margin: 30px 0;
        }
        .cta-button a {
            display: inline-block;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);
        }
        .footer {
            background-color: #1f2937;
            color: #9ca3af;
            text-align: center;
            padding: 30px;
            font-size: 13px;
        }
        .footer p {
            margin: 8px 0;
        }
        .footer strong {
            color: #d1d5db;
        }
        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
            margin: 25px 0;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <h1>Reserva Cancelada</h1>
            <p>Municipalidad de Arica - Recintos Deportivos</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                <strong>Estimado/a {{ $reserva->representante_nombre }},</strong>
            </div>
            
            <p style="margin: 20px 0; color: #4b5563; font-size: 15px;">
                Te confirmamos que tu reserva ha sido procesada correctamente:
            </p>
            
            <div class="status-banner">
                <h3>CANCELADA EXITOSAMENTE</h3>
                <p>Fecha de cancelación: {{ \Carbon\Carbon::parse($reserva->fecha_cancelacion)->format('d/m/Y H:i') }}</p>
            </div>
            
            <div class="divider"></div>
            
            <!-- Detalles de la Reserva Cancelada -->
            <div class="details-section">
                <h3>Detalles de la Reserva Cancelada</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Recinto:</span>
                    <span class="detail-value">{{ $reserva->recinto->nombre }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Fecha:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Horario:</span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($reserva->hora_inicio)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($reserva->hora_fin)->format('H:i') }}
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Organización:</span>
                    <span class="detail-value">{{ $reserva->nombre_organizacion }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Cancelada el:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($reserva->fecha_cancelacion)->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            <!-- Motivo de Cancelación -->
            @if($reserva->motivo_cancelacion)
            <div class="motivo-section">
                <h4>Motivo de la Cancelación</h4>
                <p>"{{ $reserva->motivo_cancelacion }}"</p>
            </div>
            @endif
            
            <div class="divider"></div>
            
            <!-- Información Importante -->
            <div class="info-box">
                <h4>Información Importante</h4>
                <ul>
                    <li>El horario quedará disponible inmediatamente para otras organizaciones</li>
                    <li>Si necesitas realizar una nueva reserva, puedes hacerlo ingresando a nuestro sistema</li>
                    <li>Recuerda solicitar futuras reservas con al menos 24 horas de anticipación</li>
                    <li>Para consultas, contacta al Departamento de Deportes</li>
                </ul>
            </div>
            
            <p style="margin-top: 30px; color: #4b5563; font-size: 15px; text-align: center;">
                Puedes consultar la disponibilidad de recintos en cualquier momento:
            </p>
            
            <div class="cta-button">
                <a href="{{ url('/calendario') }}">Ver Calendario de Disponibilidad</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>Municipalidad de Arica</strong></p>
            <p>Departamento de Deportes y Recreación</p>
            <div style="height: 1px; background-color: #374151; margin: 15px 0;"></div>
            <p style="margin-top: 15px;">© {{ date('Y') }} Sistema de Reservas Deportivas</p>
            <p style="opacity: 0.7; margin-top: 5px;">Este es un correo automático, por favor no responder.</p>
        </div>
    </div>
</body>
</html>