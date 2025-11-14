<?php
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';

$response = ['success' => false, 'message' => 'Error: Solicitud inválida.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'] ?? '';

    switch ($form_type) {
        case 'contact':
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $asunto = trim($_POST['asunto'] ?? 'Sin Asunto');
            $mensaje = trim($_POST['mensaje'] ?? '');

            if (empty($nombre) || empty($email) || empty($mensaje)) {
                $response['message'] = 'Por favor, complete los campos obligatorios: Nombre, Email y Mensaje.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = 'Por favor, ingrese una dirección de correo electrónico válida.';
            } else {
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host       = 'mail.piramideejecutores.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'usuarios_web@piramideejecutores.com';
                    $mail->Password   = 'Webusers99@';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    $mail->CharSet    = 'UTF-8';

                    $mail->setFrom('usuarios_web@piramideejecutores.com', 'Formulario de Contacto Web');
                    $mail->addAddress('ventas@piramideejecutores.com', 'Ventas Pirámide Ejecutores');
                    $mail->addReplyTo($email, $nombre);

                    $mail->Subject = 'Mensaje de Contacto Web: ' . $asunto;

                    $body = "Se ha recibido un nuevo mensaje a través del formulario de contacto:\n\n"
                          . "============================================\n"
                          . "DATOS DEL REMITENTE\n"
                          . "============================================\n"
                          . "Nombre: {$nombre}\n"
                          . "Email: {$email}\n\n"
                          . "============================================\n"
                          . "CONTENIDO DEL MENSAJE\n"
                          . "============================================\n"
                          . "Asunto: {$asunto}\n"
                          . "Mensaje:\n{$mensaje}\n";

                    $mail->Body = $body;
                    $mail->send();

                    $response['success'] = true;
                    $response['message'] = '¡Mensaje enviado con éxito! Gracias por contactarnos.';

                } catch (Exception $e) {
                    $response['message'] = 'Hubo un error al enviar el mensaje. Error: ' . $mail->ErrorInfo;
                }
            }
            break;

        case 'reclamaciones':
            $nombre = trim($_POST['nombre'] ?? '');
            $dni = trim($_POST['dni'] ?? '');
            $domicilio = trim($_POST['domicilio'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $bien_tipo = trim($_POST['bien_tipo'] ?? '');
            $monto = trim($_POST['monto'] ?? '0.00');
            $descripcion_bien = trim($_POST['descripcion_bien'] ?? '');
            $reclamacion_tipo = trim($_POST['reclamacion_tipo'] ?? '');
            $detalle_reclamo = trim($_POST['detalle_reclamo'] ?? '');
            $pedido_consumidor = trim($_POST['pedido_consumidor'] ?? '');

            if (empty($nombre) || empty($dni) || empty($email) || empty($descripcion_bien) || empty($detalle_reclamo) || empty($pedido_consumidor)) {
                $response['message'] = 'Por favor, complete todos los campos obligatorios.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = 'Por favor, ingrese una dirección de correo electrónico válida.';
            } else {
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host       = 'mail.piramideejecutores.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'usuarios_web@piramideejecutores.com';
                    $mail->Password   = 'Webusers99@';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    $mail->CharSet    = 'UTF-8';

                    $mail->setFrom('usuarios_web@piramideejecutores.com', 'Libro de Reclamaciones');
                    $mail->addAddress('denuncias@piramideejecutores.com', 'Área de Denuncias/Reclamos');
                    $mail->addReplyTo($email, $nombre);

                    $mail->Subject = 'Nuevo Registro en Libro de Reclamaciones: ' . $reclamacion_tipo;

                    $body = "Se ha registrado un nuevo {$reclamacion_tipo} en el Libro de Reclamaciones:\n\n"
                          . "============================================\n"
                          . "1. DATOS DEL CONSUMIDOR\n"
                          . "============================================\n"
                          . "Nombre Completo: {$nombre}\n"
                          . "DNI/CE: {$dni}\n"
                          . "Domicilio: {$domicilio}\n"
                          . "Teléfono: {$telefono}\n"
                          . "Email: {$email}\n\n"
                          . "============================================\n"
                          . "2. DATOS DEL BIEN O SERVICIO\n"
                          . "============================================\n"
                          . "Tipo: {$bien_tipo}\n"
                          . "Monto Reclamado: S/. {$monto}\n"
                          . "Descripción: {$descripcion_bien}\n\n"
                          . "============================================\n"
                          . "3. DETALLE DE LA RECLAMACIÓN\n"
                          . "============================================\n"
                          . "Tipo de Reclamación: {$reclamacion_tipo}\n"
                          . "Detalle: {$detalle_reclamo}\n"
                          . "Pedido del Consumidor: {$pedido_consumidor}\n";

                    $mail->Body = $body;
                    $mail->send();

                    $response['success'] = true;
                    $response['message'] = 'Su ' . strtolower($reclamacion_tipo) . ' ha sido registrado exitosamente. Nos pondremos en contacto con usted a la brevedad.';

                } catch (Exception $e) {
                    $response['message'] = 'Hubo un error al registrar su solicitud. Error: ' . $mail->ErrorInfo;
                }
            }
            break;

        case 'denuncia':
            // Anti-spam checks
            $honeypot = $_POST['honeypot'] ?? '';
            if (!empty($honeypot)) {
                $response['message'] = 'Error: Envío automático detectado.';
                echo json_encode($response);
                exit;
            }

            $form_time = (int)($_POST['form_time'] ?? 0) / 1000; // JS timestamp is in ms
            $now = time();
            if (($now - $form_time) < 5) {
                $response['message'] = 'Error: El formulario se envió demasiado rápido.';
                echo json_encode($response);
                exit;
            }

            $remitente = trim($_POST['remitente'] ?? 'Anónimo');
            if (empty($remitente)) {
                $remitente = 'Anónimo';
            }
            $email = trim($_POST['email'] ?? '');
            $tipo = trim($_POST['tipo'] ?? '');
            $asunto = trim($_POST['asunto'] ?? 'Sin Asunto');
            $mensaje = trim($_POST['mensaje'] ?? '');

            if (empty($tipo) || empty($asunto) || empty($mensaje)) {
                $response['message'] = 'Por favor, complete los campos obligatorios: Tipo de comunicación, Asunto y Mensaje.';
            } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = 'Por favor, ingrese una dirección de correo electrónico válida para el remitente.';
            } else {
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host       = 'mail.piramideejecutores.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'usuarios_web@piramideejecutores.com';
                    $mail->Password   = 'Webusers99@';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    $mail->CharSet    = 'UTF-8';

                    $mail->setFrom('usuarios_web@piramideejecutores.com', 'Canal de Denuncias Web');
                    $mail->addAddress('denuncias@piramideejecutores.com', 'Canal de Denuncias');
                    if (!empty($email)) {
                        $mail->addReplyTo($email, $remitente);
                    }

                    $mail->Subject = 'Nueva Comunicación en Canal de Denuncias: [' . $tipo . ']';

                    $body = "Se ha recibido una nueva comunicación a través del Canal de Denuncias:\n\n"
                          . "============================================\n"
                          . "DATOS DEL REMITENTE\n"
                          . "============================================\n"
                          . "Remitente: {$remitente}\n";
                    if (!empty($email)) {
                        $body .= "Email: {$email}\n";
                    }
                    $body .= "\n============================================\n"
                          . "CONTENIDO DE LA COMUNICACIÓN\n"
                          . "============================================\n"
                          . "Tipo de Comunicación: {$tipo}\n"
                          . "Asunto: {$asunto}\n"
                          . "Mensaje:\n{$mensaje}\n";

                    $mail->Body = $body;
                    $mail->send();

                    $response['success'] = true;
                    $response['message'] = '¡Su comunicación ha sido enviada con éxito! Gracias por su colaboración.';

                } catch (Exception $e) {
                    $response['message'] = 'Hubo un error al enviar su comunicación. Error: ' . $mail->ErrorInfo;
                }
            }
            break;

        case 'aporte':
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $tipo_aporte = trim($_POST['tipo_aporte'] ?? 'Sugerencia');
            $mensaje = trim($_POST['mensaje'] ?? '');

            if (empty($mensaje)) {
                $response['message'] = 'El campo del mensaje no puede estar vacío.';
            } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'] = 'Por favor, ingrese una dirección de correo electrónico válida para el remitente.';
            } else {
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host       = 'mail.piramideejecutores.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'usuarios_web@piramideejecutores.com';
                    $mail->Password   = 'Webusers99@';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    $mail->CharSet    = 'UTF-8';

                    $mail->setFrom('usuarios_web@piramideejecutores.com', 'Formulario de Aportes Web');
                    $mail->addAddress('etica@piramideejecutores.com', 'Canal Ético / Aportes');
                    if (!empty($email)) {
                        $mail->addReplyTo($email, $nombre);
                    }

                    $mail->Subject = 'Nuevo Aporte Recibido: ' . $tipo_aporte;

                    $body = "Se ha recibido un nuevo aporte a través del formulario web:\n\n"
                          . "============================================\n"
                          . "DATOS DEL REMITENTE\n"
                          . "============================================\n"
                          . "Nombre: " . (!empty($nombre) ? $nombre : 'Anónimo') . "\n";
                    if (!empty($email)) {
                        $body .= "Email: {$email}\n";
                    }
                    $body .= "\n============================================\n"
                          . "CONTENIDO DEL APORTE\n"
                          . "============================================\n"
                          . "Tipo de Aporte: {$tipo_aporte}\n"
                          . "Mensaje:\n{$mensaje}\n";

                    $mail->Body = $body;
                    $mail->send();

                    $response['success'] = true;
                    $response['message'] = '¡Gracias por tu aporte! Tu mensaje ha sido enviado correctamente.';

                } catch (Exception $e) {
                    $response['message'] = 'Hubo un error al enviar tu mensaje. Error: ' . $mail->ErrorInfo;
                }
            }
            break;

        default:
            $response['message'] = 'Tipo de formulario no reconocido.';
            break;
    }
} else {
    $response['message'] = 'Método no permitido.';
}

echo json_encode($response);
?>