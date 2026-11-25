<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="margin:0; padding:0; background:#f1f3f5; font-family: Arial, Helvetica, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f3f5; padding:30px 10px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background:#ffffff; border-radius:8px; overflow:hidden;">

      <tr><td style="background:#212529; padding:24px 30px; color:#ffffff;">
        <div style="font-size:22px; font-weight:bold;">CrickoStore</div>
        <div style="font-size:13px; color:#adb5bd; margin-top:4px;">Directorio comercial en línea</div>
      </td></tr>

      <tr><td style="padding:30px;">
        <h2 style="margin:0 0 10px; color:#212529; font-size:20px;">Nuevo mensaje para {{ $tienda->nombre }}</h2>
        <p style="margin:0 0 20px; color:#6c757d; font-size:14px;">Un visitante te escribió desde el formulario de contacto de tu tienda.</p>

        <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; color:#212529; margin-bottom:20px;">
          <tr>
            <td style="padding:8px 0; width:90px; color:#6c757d;">Nombre:</td>
            <td style="padding:8px 0;"><strong>{{ $datos['nombre'] }}</strong></td>
          </tr>
          <tr>
            <td style="padding:8px 0; color:#6c757d;">Correo:</td>
            <td style="padding:8px 0;"><a href="mailto:{{ $datos['correo'] }}" style="color:#0d6efd;">{{ $datos['correo'] }}</a></td>
          </tr>
        </table>

        <div style="color:#6c757d; font-size:13px; margin-bottom:6px;">Mensaje:</div>
        <div style="background:#f8f9fa; border-left:4px solid #212529; padding:16px; font-size:15px; line-height:1.6; color:#212529; white-space:pre-line;">{{ $datos['mensaje'] }}</div>

        <p style="margin:25px 0 0; font-size:13px; color:#6c757d;">Puedes responder directamente a este correo y tu respuesta llegará a {{ $datos['nombre'] }}.</p>
      </td></tr>

      <tr><td style="background:#f8f9fa; padding:16px 30px; text-align:center; font-size:12px; color:#adb5bd;">
        © {{ date('Y') }} CrickoStore · Este mensaje fue enviado desde la plataforma.
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>
