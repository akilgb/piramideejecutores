<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$mensajeResultado = null;
$datosEnviados = [
    'nombre' => '', 'dni' => '', 'domicilio' => '', 'telefono' => '', 'email' => '',
    'bien_tipo' => 'Producto', 'monto' => '', 'descripcion_bien' => '',
    'reclamacion_tipo' => 'Queja', 'detalle_reclamo' => '', 'pedido_consumidor' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($datosEnviados as $key => $value) {
        if (isset($_POST[$key])) {
            $datosEnviados[$key] = trim($_POST[$key]);
        }
    }

    if (empty($datosEnviados['nombre']) || empty($datosEnviados['dni']) || empty($datosEnviados['email']) || empty($datosEnviados['descripcion_bien']) || empty($datosEnviados['detalle_reclamo']) || empty($datosEnviados['pedido_consumidor'])) {
        $mensajeResultado = [
            'tipo'    => 'danger',
            'mensaje' => 'Por favor, complete todos los campos obligatorios.'
        ];
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
            $mail->addReplyTo($datosEnviados['email'], $datosEnviados['nombre']);

            $mail->Subject = 'Nuevo Registro en Libro de Reclamaciones: ' . $datosEnviados['reclamacion_tipo'];

            $body = "Se ha registrado un nuevo {" . $datosEnviados['reclamacion_tipo'] . "} en el Libro de Reclamaciones:\n\n"
                  . "============================================\n"
                  . "1. DATOS DEL CONSUMIDOR\n"
                  . "============================================\n"
                  . "Nombre Completo: {" . $datosEnviados['nombre'] . "}\n"
                  . "DNI/CE: {" . $datosEnviados['dni'] . "}\n"
                  . "Domicilio: {" . $datosEnviados['domicilio'] . "}\n"
                  . "Teléfono: {" . $datosEnviados['telefono'] . "}\n"
                  . "Email: {" . $datosEnviados['email'] . "}\n\n"
                  . "============================================\n"
                  . "2. DATOS DEL BIEN O SERVICIO\n"
                  . "============================================\n"
                  . "Tipo: {" . $datosEnviados['bien_tipo'] . "}\n"
                  . "Monto Reclamado: S/. {" . $datosEnviados['monto'] . "}\n"
                  . "Descripción: {" . $datosEnviados['descripcion_bien'] . "}\n\n"
                  . "============================================\n"
                  . "3. DETALLE DE LA RECLAMACIÓN\n"
                  . "============================================\n"
                  . "Tipo de Reclamación: {" . $datosEnviados['reclamacion_tipo'] . "}\n"
                  . "Detalle: {" . $datosEnviados['detalle_reclamo'] . "}\n"
                  . "Pedido del Consumidor: {" . $datosEnviados['pedido_consumidor'] . "}\n";

            $mail->Body = $body;
            $mail->send();

            $mensajeResultado = [
                'tipo'    => 'success',
                'mensaje' => 'Su ' . strtolower($datosEnviados['reclamacion_tipo']) . ' ha sido registrado exitosamente. Nos pondremos en contacto con usted a la brevedad.'
            ];
            $datosEnviados = array_fill_keys(array_keys($datosEnviados), '');

        } catch (Exception $e) {
            $mensajeResultado = [
                'tipo'    => 'danger',
                'mensaje' => 'Hubo un error al registrar su solicitud. Error: ' . $mail->ErrorInfo
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Reclamaciones - Pirámide Ejecutores EIRL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <style>
      .form-section { padding: 4rem 0; background-color: #f8f9fa; }
      .form-container { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
      .form-container h2 { margin-bottom: 1.5rem; }
      .form-label { font-weight: 600; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="https://www.piramideejecutores.com/recursos/logo%20piramide.svg" alt="Pirámide Ejecutores Logo" style="max-height: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="servicios.html">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="nosotros.html">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contacto.html">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="form-section mt-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-container">
                        <h2 class="text-center">Libro de Reclamaciones</h2>
                        <p class="text-muted text-center">Conforme a lo establecido en el Código de Protección y Defensa del Consumidor, Ley N° 29571, en esta página puede registrar su queja o reclamo sobre un producto o servicio adquirido.</p>
                        <hr>
                        <?php if ($mensajeResultado): ?>
                            <div class="alert alert-<?php echo htmlspecialchars($mensajeResultado['tipo']); ?> text-center" role="alert">
                                <?php echo htmlspecialchars($mensajeResultado['mensaje']); ?>
                            </div>
                        <?php endif; ?>
                        <form action="reclamaciones.php" method="POST">
                            <h5 class="mt-4">1. Identificación del Consumidor</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombres y Apellidos</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($datosEnviados['nombre']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dni" class="form-label">DNI / CE</label>
                                    <input type="text" class="form-control" id="dni" name="dni" value="<?php echo htmlspecialchars($datosEnviados['dni']); ?>" required>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="domicilio" class="form-label">Domicilio</label>
                                    <input type="text" class="form-control" id="domicilio" name="domicilio" value="<?php echo htmlspecialchars($datosEnviados['domicilio']); ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($datosEnviados['telefono']); ?>" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($datosEnviados['email']); ?>" required>
                                </div>
                            </div>
                            <h5 class="mt-4">2. Identificación del Bien o Servicio</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bien_tipo" id="producto" value="Producto" <?php if ($datosEnviados['bien_tipo'] === 'Producto') echo 'checked'; ?>/>
                                        <label class="form-check-label" for="producto">Producto</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bien_tipo" id="servicio" value="Servicio" <?php if ($datosEnviados['bien_tipo'] === 'Servicio') echo 'checked'; ?>/>
                                        <label class="form-check-label" for="servicio">Servicio</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="monto" class="form-label">Monto Reclamado (S/.)</label>
                                    <input type="number" step="0.01" class="form-control" id="monto" name="monto" value="<?php echo htmlspecialchars($datosEnviados['monto']); ?>">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="descripcion_bien" class="form-label">Descripción del Producto o Servicio</label>
                                    <textarea class="form-control" id="descripcion_bien" name="descripcion_bien" rows="2" required><?php echo htmlspecialchars($datosEnviados['descripcion_bien']); ?></textarea>
                                </div>
                            </div>
                            <h5 class="mt-4">3. Detalle de la Reclamación</h5>
                             <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Tipo de Reclamación</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="reclamacion_tipo" id="queja" value="Queja" <?php if ($datosEnviados['reclamacion_tipo'] === 'Queja') echo 'checked'; ?>/>
                                        <label class="form-check-label" for="queja">Queja <small class="text-muted">(Disconformidad con la atención)</small></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="reclamacion_tipo" id="reclamo" value="Reclamo" <?php if ($datosEnviados['reclamacion_tipo'] === 'Reclamo') echo 'checked'; ?>/>
                                        <label class="form-check-label" for="reclamo">Reclamo <small class="text-muted">(Disconformidad con el producto/servicio)</small></label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="detalle_reclamo" class="form-label">Detalle del Reclamo o Queja</label>
                                <textarea class="form-control" id="detalle_reclamo" name="detalle_reclamo" rows="4" required><?php echo htmlspecialchars($datosEnviados['detalle_reclamo']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="pedido_consumidor" class="form-label">Pedido del Consumidor</label>
                                <textarea class="form-control" id="pedido_consumidor" name="pedido_consumidor" rows="3" required><?php echo htmlspecialchars($datosEnviados['pedido_consumidor']); ?></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger btn-lg">Enviar Reclamación</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2024 Pirámide Ejecutores EIRL. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>