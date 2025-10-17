<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../vendor/autoload.php';

class CorreoModel extends Model
{
    private static function createMailer()
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = "smtp.gmail.com";
            $mail->SMTPAuth   = true;
            $mail->Username   = "foxy49amer@gmail.com";
            $mail->Password   = "xfln aric ytww wccr"; // App Password de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS
            $mail->Port       = 587;

            $mail->CharSet = 'UTF-8';
            $mail->setLanguage('es');

            // Opcional: depuración detallada
            // $mail->SMTPDebug = 2;

            return $mail;
        } catch (Exception $e) {
            error_log("Error creando PHPMailer: " . $e->getMessage());
            return null;
        }
    }

    public static function enviarCorreoProtagonista($nombreUsuario, $emailUsuario, $asunto = null, $mensaje = null)
    {
        if (!filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $subject = $asunto ?: 'Cuenta creada en LEShealth - Información de acceso y recomendaciones';

        $safeName  = htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8');
        $safeEmail = htmlspecialchars($emailUsuario, ENT_QUOTES, 'UTF-8');

        if ($mensaje) {
            $bodyText = nl2br(htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'));
        } else {
            $bodyText = <<<HTML
<p>Le damos la bienvenida a <strong>LEShealth</strong>, un sistema de gestión de salud centrado en pacientes con enfermedades autoinmunes como el lupus.</p>
<p><strong>Nombre:</strong> {$safeName}<br>
<strong>Email de contacto (login):</strong> {$safeEmail}</p>
<p>Su cuenta ha sido creada correctamente. Por seguridad, si se le asignó una clave temporal, le recomendamos cambiarla inmediatamente desde su perfil.</p>
<h4>Información y recomendaciones importantes</h4>
<ul>
    <li>Mantenga su contraseña privada y cámbiela periódicamente.</li>
    <li>En caso de empeoramiento de síntomas (fiebre alta, dolor intenso, sangrados inusuales, dificultad para respirar) contacte de inmediato a su equipo de salud o acuda a urgencias.</li>
    <li>Si requiere soporte con la plataforma, responda a este correo o contacte al equipo de soporte.</li>
</ul>
<p>Atentamente,<br>Equipo LEShealth</p>
HTML;
        }

        $mail = self::createMailer();

        // Si PHPMailer falla, usar mail() como fallback
        if (!$mail) {
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";

            return mail($emailUsuario, $subject, $bodyText, $headers);
        }

        try {
            $mail->setFrom("foxy49amer@gmail.com", "LEShealth");
            $mail->addAddress($emailUsuario, $safeName);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $bodyText;
            $mail->AltBody = strip_tags(str_replace(["<br>", "<br/>", "<br />"], "\n", $bodyText));

            return (bool)$mail->send();
        } catch (Exception $e) {
            error_log("Error enviando correo a protagonista: " . $e->getMessage());
            return false;
        }
    }

    public static function enviarCorreoDoctor($nombreDoctor, $emailDoctor, $asunto = null, $mensaje = null)
    {
        if (!filter_var($emailDoctor, FILTER_VALIDATE_EMAIL)) {
            return false;
        }


        $subject = $asunto ?: 'Cuenta profesional creada en LEShealth - Acceso y pasos siguientes';

        $safeName  = htmlspecialchars($nombreDoctor, ENT_QUOTES, 'UTF-8');
        $safeEmail = htmlspecialchars($emailDoctor, ENT_QUOTES, 'UTF-8');

        if ($mensaje) {
            $bodyText = nl2br(htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'));
        } else {
            $bodyText = <<<HTML
<p>Saludos Dr./Dra. <strong>{$safeName}</strong>,</p>
<p>Su cuenta profesional en <strong>LEShealth</strong> ha sido creada correctamente. Esta cuenta le permite gestionar su perfil profesional, acceder a la lista de pacientes que le sean asignados y colaborar en planes de manejo.</p>
<p><strong>Email de acceso:</strong> {$safeEmail}</p>
<h4>Recomendaciones de seguridad y uso</h4>
<ul>
    <li>Confirme y complete su perfil profesional (especialidad, información de contacto y foto).</li>
    <li>Mantenga la confidencialidad de la información clínica de sus pacientes y siga las normas locales de protección de datos.</li>
    <li>Si necesita integrar su cuenta con servicios adicionales, contacte al equipo técnico.</li>
</ul>
<p>Gracias por colaborar con LEShealth.<br>Atentamente,<br>Equipo LEShealth</p>
HTML;
        }

        $mail = self::createMailer();
        if (!$mail) {
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";

            return mail($emailDoctor, $subject, $bodyText, $headers);
        }

        try {
            $mail->setFrom("foxy49amer@gmail.com", "Johandry");
            $mail->addAddress($emailDoctor, $safeName);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $bodyText;
            $mail->AltBody = strip_tags(str_replace(["<br>", "<br/>", "<br />"], "\n", $bodyText));
            return (bool)$mail->send();
        } catch (Exception $e) {
            error_log("Error enviando correo a doctor: " . $e->getMessage());
            echo "<script>alert('Error enviando correo: " . $e->getMessage() . "');</script>";
            return false;
        }
    }
}