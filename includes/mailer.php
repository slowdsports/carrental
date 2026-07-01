<?php
/**
 * Envío de correo de la aplicación.
 *
 * Usa la función mail() nativa de PHP, que en hosting cPanel (como Zomro)
 * funciona sin configuración adicional una vez desplegado el sitio, ya
 * que cPanel configura el agente de correo local para el dominio.
 * En localhost/XAMPP normalmente no hay un MTA configurado, así que
 * mail() puede devolver false aquí sin que eso indique un error de código.
 */

function destiny_mail_from()
{
    global $dbh;
    $from = null;
    try {
        $row = $dbh->query("SELECT EmailId FROM tblcontactusinfo LIMIT 1")->fetch(PDO::FETCH_OBJ);
        if ($row && !empty($row->EmailId)) {
            $from = $row->EmailId;
        }
    } catch (Exception $e) {
        // Ignorar y usar el valor por defecto
    }
    if (!$from) {
        $host = $_SERVER['HTTP_HOST'] ?? 'destinyrentacar.com';
        $host = preg_replace('/^www\./', '', $host);
        $from = 'no-reply@' . $host;
    }
    return $from;
}

function send_app_email($to, $subject, $bodyHtml)
{
    if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $fromEmail = destiny_mail_from();
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Destiny Rent a Car <" . $fromEmail . ">\r\n";

    return @mail($to, $subject, $bodyHtml, $headers);
}

function render_email_template($title, $bodyHtml)
{
    return '<!doctype html><html><head><meta charset="UTF-8"></head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f4f4f4; padding:24px 0; margin:0;">
  <div style="max-width:560px;margin:0 auto;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #ececec;">
    <div style="background:#004aad;padding:24px;text-align:center;">
      <h1 style="color:#ffffff;margin:0;font-size:22px;">Destiny Rent a Car</h1>
    </div>
    <div style="padding:24px;color:#333333;line-height:1.6;font-size:14px;">
      <h2 style="margin-top:0;color:#111111;font-size:18px;">' . htmlspecialchars($title) . '</h2>
      ' . $bodyHtml . '
    </div>
    <div style="background:#f7f8fa;padding:16px;text-align:center;color:#9e9e9e;font-size:12px;">
      Destiny Rent a Car &middot; San Pedro Sula, Honduras
    </div>
  </div>
</body></html>';
}
