<?php
/**
 * DENUNCIAS.PHP
 *
 * - Formulario de quejas, reclamaciones y denuncias.
 * - Usa PHPMailer en la carpeta 'PHPMailer/src/' para envío vía SMTP.
 * - Incluye:
 *   1) Honeypot: campo oculto.
 *   2) Verificación de tiempo mínimo (5s).
 *
 * NOTA: No incluye reCAPTCHA (descartado según tu solicitud).
 *
 * Reemplaza "usuarios_web@piramideejecutores.com" y "Webusers99@" si cambian
 * las credenciales. Los correos llegarán a 'denuncias@piramideejecutores.com'.
 */
                // e) Enviar correo usando PHPMailer
                //    1. Incluir las clases desde la carpeta PHPMailer/src/
                require __DIR__ . '/PHPMailer/src/Exception.php';
                require __DIR__ . '/PHPMailer/src/PHPMailer.php';
                require __DIR__ . '/PHPMailer/src/SMTP.php';

                //    2. Usar los namespaces
                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\SMTP;
                use PHPMailer\PHPMailer\Exception;
// ---------------------------------------------
// 1) Configuración inicial
// ---------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', 0); // En producción, suele ponerse 0
session_start();

// Para mostrar mensajes de éxito/error en la misma página
$mensajeResultado = null;

// Campos del formulario
$datos = [
    'remitente' => '',
    'email'     => '',
    'tipo'      => '',
    'asunto'    => '',
    'mensaje'   => ''
];

// ---------------------------------------------
// 2) Ver si se envió el formulario (POST)
// ---------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturamos campos
    $datos['remitente'] = trim($_POST['remitente'] ?? '');
    $datos['email']     = trim($_POST['email'] ?? '');
    $datos['tipo']      = trim($_POST['tipo'] ?? '');
    $datos['asunto']    = trim($_POST['asunto'] ?? '');
    $datos['mensaje']   = trim($_POST['mensaje'] ?? '');

    // a) HONEYPOT: campo oculto
    $honeypot = $_POST['honeypot'] ?? '';
    if (!empty($honeypot)) {
        // Alguien (o un bot) llenó este campo invisible => spam
        $mensajeResultado = [
            'tipo'    => 'danger',
            'mensaje' => 'Detectado envío automático (honeypot).'
        ];
    } else {
        // b) Verificación de tiempo mínimo (ej.: 5s)
        $form_time  = (int)($_POST['form_time'] ?? 0);
        $now        = time();
        $minSeconds = 5; // Cambia si deseas más o menos

        if (($now - $form_time) < $minSeconds) {
            // Se envió demasiado rápido => probable bot
            $mensajeResultado = [
                'tipo'    => 'danger',
                'mensaje' => 'El formulario se ha enviado demasiado rápido. Inténtalo de nuevo.'
            ];
        } else {
            // c) Validar campos obligatorios
            if (empty($datos['tipo']) || empty($datos['asunto']) || empty($datos['mensaje'])) {
                $mensajeResultado = [
                    'tipo'    => 'danger',
                    'mensaje' => 'Faltan campos obligatorios (tipo, asunto, mensaje).'
                ];
            } else {
                // d) Remitente anónimo si está vacío
                if ($datos['remitente'] === '') {
                    $datos['remitente'] = 'Anónimo';
                }



                try {
                    $mail = new PHPMailer(true);

                    // Configurar SMTP
                    $mail->isSMTP();
                    $mail->Host       = 'mail.piramideejecutores.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'usuarios_web@piramideejecutores.com'; // REEMPLAZA si cambian
                    $mail->Password   = 'Webusers99@';                        // REEMPLAZA si cambian
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // ssl
                    $mail->Port       = 465;

                    // Origen
                    $mail->setFrom('usuarios_web@piramideejecutores.com', 'Formulario Web');

                    // Destinatario
                    $mail->addAddress('denuncias@piramideejecutores.com', 'Área de Denuncias');

                    // Reply-To: si el usuario dejó email, podemos responderle
                    if (!empty($datos['email'])) {
                        $mail->addReplyTo($datos['email'], $datos['remitente']);
                    }

                    // Asunto => anteponemos el tipo entre **
                    $fullSubject = '**' . $datos['tipo'] . '** ' . $datos['asunto'];
                    $mail->Subject = $fullSubject;

                    // Cuerpo (texto plano)
                    $body  = "Remitente: {$datos['remitente']}\n";
                    if (!empty($datos['email'])) {
                        $body .= "Email: {$datos['email']}\n";
                    }
                    $body .= "\n{$datos['mensaje']}\n";

                    $mail->Body = $body;

                    // Enviar
                    $mail->send();

                    // Éxito
                    $mensajeResultado = [
                        'tipo'    => 'success',
                        'mensaje' => '¡Tu mensaje ha sido enviado exitosamente!'
                    ];

                    // Limpiamos los campos para que no queden
                    $datos = [
                        'remitente' => '',
                        'email'     => '',
                        'tipo'      => '',
                        'asunto'    => '',
                        'mensaje'   => ''
                    ];
                } catch (Exception $e) {
                    // Error al enviar
                    $mensajeResultado = [
                        'tipo'    => 'danger',
                        'mensaje' => 'Hubo un error al enviar el correo: ' . $mail->ErrorInfo
                    ];
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pirámide Ejecutores EIRL - Denuncias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      rel="stylesheet"
    />

    <style>
      body { margin: 0; padding: 0; }
      .navbar { background-color: #fff; padding: 1rem; }
      .navbar-brand img { max-height: 50px; }
      .nav-link { color: #333 !important; margin: 0 10px; }
      .nav-link.active { font-weight: bold; }
      .submenu-static {
        background: #f8f9fa;
        padding: 0.5rem 0;
        box-shadow: 0 2px 2px rgba(0,0,0,0.1);
      }
      .submenu-static ul {
        list-style: none; margin: 0; padding: 0;
        display: flex; gap: 1rem; justify-content: center;
      }
      .submenu-static a {
        color: #333;
        text-decoration: none;
      }
      .submenu-static a:hover {
        text-decoration: underline;
      }
      .hero-section {
        background: #eee;
        padding: 60px 0; text-align: center;
      }
      .hero-section h1 { font-size: 2rem; margin-bottom: 1rem; }
      .hero-section p {
        font-size: 1.1rem; line-height: 1.5;
        max-width: 800px; margin: 0 auto;
      }
      .denuncias-section { padding: 3rem 0; }
      footer {
        background: #333; color: #fff; padding: 2rem 0;
      }
      footer a { color: #fff; text-decoration: none; }
      footer a:hover { text-decoration: underline; }
      .social-links a { color: #fff; margin-right: 10px; }
      .whatsapp-btn {
        position: fixed; bottom: 20px; right: 20px;
        background-color: #25d366; color: #fff;
        padding: 14px 16px; border-radius: 50%;
        font-size: 20px; z-index: 9999;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
      }
      .whatsapp-btn:hover {
        color: #fff; background-color: #20b955;
        text-decoration: none;
      }
      /* Honeypot: campo oculto */
      .honeypot { display: none; }
    </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="index.html">
        <img
          src="https://piramideejecutores.com/wp-content/uploads/2024/02/cropped-logo2.png"
          alt="Pirámide Ejecutores Logo"
          onerror="this.onerror=null;this.src='https://via.placeholder.com/150x50?text=Pirámide+Ejecutores';"
        />
      </a>
      <button class="navbar-toggler" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false" aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.html">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="servicios.html">Servicios</a></li>
          <li class="nav-item"><a class="nav-link" href="index.html#about">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
          <li class="nav-item"><a class="nav-link active" href="denuncias.php">Denuncias</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Submenú Estático -->
  <div class="submenu-static">
    <div class="container">
      <ul>
        <li><a href="reclamaciones.php"><i class="fas fa-comment-alt"></i> Reclamaciones</a></li>
        <li><a href="aportes.php"><i class="fas fa-hand-holding-heart"></i> Aportes</a></li>
        <li><a href="denuncias.php"><i class="fas fa-exclamation-circle"></i> Denuncias</a></li>
        <li><a href="faq.html"><i class="fas fa-question-circle"></i> FAQ's</a></li>
        <li><a href="encuesta.html"><i class="fas fa-star"></i> Encuesta de Satisfacción</a></li>
      </ul>
    </div>
  </div>

  <!-- Hero Section -->
  <div class="hero-section">
    <div class="container">
      <h1 class="mb-3">Quejas, reclamaciones y denuncias</h1>
      <p>
        Bienvenido(a) al canal oficial de Pirámide Ejecutores E.I.R.L. para la
        gestión de quejas, reclamaciones y denuncias. Ponemos a tu disposición
        esta plataforma con el fin de recibir cualquier inquietud o inconveniente
        que pudiera presentarse en nuestras operaciones o en los servicios
        brindados. Toda información será tratada con confidencialidad y
        discreción, y tendrá prioridad de atención para evitar vacíos o malos
        entendidos.
      </p>
    </div>
  </div>

  <!-- Sección de Denuncias -->
  <section class="denuncias-section">
    <div class="container">
      <!-- Modal Polita de tratamiento... (opcional) -->
      <div class="text-center mb-4">
        <button
          type="button"
          class="btn btn-outline-primary"
          data-bs-toggle="modal"
          data-bs-target="#politicaModal"
        >
          Polita de tratamiento de la Informacion sobre denuncias
        </button>
      </div>
      <div class="modal fade" id="politicaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title">Política de Tratamiento de la Información</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
              <img
                src="https://www.piramideejecutores.com/recursos/39.%20CANAL%20DE%20DENUNCIAS%20_001.jpg"
                alt="Política de Tratamiento"
                class="img-fluid"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Mensaje de resultado -->
      <?php if ($mensajeResultado): ?>
        <div class="alert alert-<?= $mensajeResultado['tipo'] ?> text-center" role="alert">
          <?= htmlspecialchars($mensajeResultado['mensaje'], ENT_QUOTES, 'UTF-8') ?>
        </div>
      <?php endif; ?>

      <h2 class="mb-4 text-center">Envía tu Queja, Reclamo o Denuncia</h2>
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <form action="denuncias.php" method="POST">
            <div class="row">
              <!-- Remitente -->
              <div class="col-md-6 mb-3">
                <label for="remitente" class="form-label">Remitente (opcional)</label>
                <input
                  type="text"
                  class="form-control"
                  id="remitente"
                  name="remitente"
                  placeholder="Tu nombre o seudónimo"
                  value="<?= htmlspecialchars($datos['remitente'], ENT_QUOTES, 'UTF-8') ?>"
                />
                <small class="text-muted">
                  Si lo dejas vacío, se considerará como "Anónimo".
                </small>
              </div>
              <!-- Email -->
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Correo electrónico (opcional)</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="tucorreo@ejemplo.com"
                  value="<?= htmlspecialchars($datos['email'], ENT_QUOTES, 'UTF-8') ?>"
                />
                <small class="text-muted">
                  Ingresa tu email si deseas recibir respuesta directa.
                </small>
              </div>
            </div>
            <!-- Tipo de comunicación -->
            <div class="mb-3">
              <label for="tipo" class="form-label">Tipo de comunicación</label>
              <select class="form-control" id="tipo" name="tipo" required>
                <option value="" disabled <?= ($datos['tipo']==='')?'selected':'' ?>>Selecciona una opción</option>
                <option value="Reclamo" <?= ($datos['tipo']==='Reclamo')?'selected':'' ?>>Reclamo</option>
                <option value="Recomendación" <?= ($datos['tipo']==='Recomendación')?'selected':'' ?>>Recomendación</option>
                <option value="Denuncia" <?= ($datos['tipo']==='Denuncia')?'selected':'' ?>>Denuncia</option>
              </select>
            </div>
            <!-- Asunto -->
            <div class="mb-3">
              <label for="asunto" class="form-label">Asunto</label>
              <input
                type="text"
                class="form-control"
                id="asunto"
                name="asunto"
                placeholder="Breve resumen"
                value="<?= htmlspecialchars($datos['asunto'], ENT_QUOTES, 'UTF-8') ?>"
                required
              />
            </div>
            <!-- Mensaje -->
            <div class="mb-3">
              <label for="mensaje" class="form-label">Mensaje o descripción</label>
              <textarea
                class="form-control"
                id="mensaje"
                name="mensaje"
                rows="5"
                placeholder="Detalle aquí su queja, reclamo o denuncia..."
                required
              ><?= htmlspecialchars($datos['mensaje'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <!-- Honeypot (campo oculto) -->
            <div class="honeypot">
              <label>No llenar este campo</label>
              <input type="text" name="honeypot" value="">
            </div>

            <!-- Campo tiempo (evitar envíos instantáneos) -->
            <input type="hidden" name="form_time" value="<?= time() ?>">

            <button type="submit" class="btn btn-primary">Enviar</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>Pirámide Ejecutores E.I.R.L.</h5>
          <p>Tecnología y networking para el éxito empresarial</p>
        </div>
        <div class="col-md-4">
          <h5>Enlaces Rápidos</h5>
          <ul class="list-unstyled">
            <li><a href="index.html">Inicio</a></li>
            <li><a href="servicios.html">Servicios</a></li>
            <li><a href="index.html#about">Nosotros</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="denuncias.php">Denuncias</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5>Contáctanos</h5>
          <p>Av. Antonio Jose de Sucre - 195, Pueblo Libre, Lima</p>
          <p>Teléfono: +51 952 381 521</p>
          <p>
            Email:
            <a href="mailto:ventas@piramideejecutores.com">ventas@piramideejecutores.com</a>
          </p>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-6">
          <p>&copy; 2024 Pirámide Ejecutores EIRL. Todos los derechos reservados.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <div class="social-links">
            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Botón de WhatsApp -->
  <a
    href="https://wa.me/51952381521"
    class="whatsapp-btn"
    target="_blank"
    rel="noopener noreferrer"
  >
    <i class="fab fa-whatsapp"></i>
  </a>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
