<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="margin:0; padding:0; background:#f1f3f5; font-family: Arial, Helvetica, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f3f5; padding:30px 10px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background:#ffffff; border-radius:8px; overflow:hidden;">

      <tr><td style="background:#212529; padding:24px 30px; color:#ffffff;">
        <div style="font-size:22px; font-weight:bold;">CrickoStore</div>
        <div style="font-size:13px; color:#adb5bd; margin-top:4px;">Confirmación de pedido</div>
      </td></tr>

      <tr><td style="padding:30px;">
        <h2 style="margin:0 0 8px; color:#212529; font-size:20px;">¡Gracias por tu compra, {{ $pedido->cliente }}!</h2>
        <p style="margin:0 0 20px; color:#6c757d; font-size:14px;">
          Recibimos tu pedido <strong>#{{ $pedido->id_pedido }}</strong> el {{ $pedido->fecha->format('d/m/Y H:i') }}.
          Cada tienda lo irá preparando y te contactaremos para la entrega.
        </p>

        <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#212529; border-collapse:collapse;">
          <thead>
            <tr style="background:#f8f9fa;">
              <th align="left" style="padding:10px; border-bottom:2px solid #dee2e6;">Producto</th>
              <th align="center" style="padding:10px; border-bottom:2px solid #dee2e6;">Cant.</th>
              <th align="right" style="padding:10px; border-bottom:2px solid #dee2e6;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pedido->detalles as $d)
            <tr>
              <td style="padding:10px; border-bottom:1px solid #e9ecef;">
                {{ $d->nombre_producto }}<br>
                <span style="font-size:12px; color:#6c757d;">{{ $d->nombre_tienda }} · ₡{{ number_format($d->precio, 0, ',', '.') }} c/u</span>
              </td>
              <td align="center" style="padding:10px; border-bottom:1px solid #e9ecef;">{{ $d->cantidad }}</td>
              <td align="right" style="padding:10px; border-bottom:1px solid #e9ecef;">₡{{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:16px;">
          <tr>
            <td align="right" style="font-size:18px; font-weight:bold; color:#212529;">Total: ₡{{ number_format($pedido->total, 0, ',', '.') }}</td>
          </tr>
        </table>

        <div style="margin-top:25px; background:#f8f9fa; padding:16px; border-radius:6px; font-size:13px; color:#495057; line-height:1.6;">
          <strong>Datos del cliente</strong><br>
          Nombre: {{ $pedido->cliente }}<br>
          Correo: {{ $pedido->correo }}<br>
          @if ($pedido->telefono) Teléfono: {{ $pedido->telefono }} @endif
        </div>
      </td></tr>

      <tr><td style="background:#f8f9fa; padding:16px 30px; text-align:center; font-size:12px; color:#adb5bd;">
        © {{ date('Y') }} CrickoStore · Gracias por comprar en nuestras tiendas.
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>
