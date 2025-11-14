<?php
session_start();

/********************************************************
 * 1. Configuración de la base de datos
 ********************************************************/
$host = 'localhost';
$dbname = 'Personal';
$user = 'Piramideadmin';
$pass = 'Engteacher1';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error al conectar con la BD: " . $e->getMessage());
}

/********************************************************
 * 2. Permitir flush (logs en vivo)
 ********************************************************/
@ob_implicit_flush(true);
@ob_end_flush();

/********************************************************
 * 3. Función para loguear mensajes en la consola HTML
 ********************************************************/
function logMessage($msg) {
    echo "<script>
            const logDiv = document.getElementById('logConsola');
            if (logDiv) {
               logDiv.innerHTML += " . json_encode($msg) . " + '<br>';
               logDiv.scrollTop = logDiv.scrollHeight;
            }
          </script>\n";
    flush();
}

/********************************************************
 * 4. Descargar un archivo con cURL
 ********************************************************/
function descargarArchivo($url, $rutaDestino) {
    logMessage("Descargando: $url ...");

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    $data = curl_exec($ch);
    if(curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("Error cURL: $error");
    }
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($statusCode !== 200) {
        throw new Exception("HTTP $statusCode al descargar: $url");
    }

    if(!file_put_contents($rutaDestino, $data)) {
        throw new Exception("No se pudo guardar en: $rutaDestino");
    }
    logMessage("Guardado en: $rutaDestino (OK)");
}

/********************************************************
 * 5. Función que descarga esos 18 archivos exactos
 ********************************************************/
function descargarModelosFaceApiShards() {
    $baseDir = __DIR__;
    logMessage("Carpeta base: $baseDir");

    // 1) Crear carpeta /models/weights si no existe
    $weightsDir = $baseDir . '/models/weights';
    if(!is_dir($weightsDir)) {
        if(!mkdir($weightsDir, 0777, true) && !is_dir($weightsDir)) {
            throw new Exception("No se pudo crear $weightsDir");
        }
        logMessage("Creada carpeta: $weightsDir");
    } else {
        logMessage("Carpeta ya existe: $weightsDir");
    }

    // 2) Definir las descargas (18 archivos) 
    //    desde "https://github.com/justadudewhohacks/face-api.js/tree/master/weights"
    //    Se descargan desde "https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights/<filename>"
    $baseUrl = 'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/master/weights/';
    $descargas = [
        // age_gender
        'age_gender_model-shard1',
        'age_gender_model-weights_manifest.json',

        // face_expression
        'face_expression_model-shard1',
        'face_expression_model-weights_manifest.json',

        // face_landmark_68
        'face_landmark_68_model-shard1',
        'face_landmark_68_model-weights_manifest.json',

        // face_landmark_68_tiny
        'face_landmark_68_tiny_model-shard1',
        'face_landmark_68_tiny_model-weights_manifest.json',

        // face_recognition
        'face_recognition_model-shard1',
        'face_recognition_model-shard2',
        'face_recognition_model-weights_manifest.json',

        // mtcnn
        'mtcnn_model-shard1',
        'mtcnn_model-weights_manifest.json',

        // ssd_mobilenetv1
        'ssd_mobilenetv1_model-shard1',
        'ssd_mobilenetv1_model-shard2',
        'ssd_mobilenetv1_model-weights_manifest.json',

        // tiny_face_detector
        'tiny_face_detector_model-shard1',
        'tiny_face_detector_model-weights_manifest.json'
    ];

    // 3) Descargamos cada uno
    foreach($descargas as $filename) {
        $url        = $baseUrl . $filename;
        $dest       = $weightsDir . '/' . $filename;
        descargarArchivo($url, $dest);
    }

    logMessage("Archivos shards + manifest descargados correctamente en $weightsDir");
    return "¡Descarga completada de los 18 archivos de /master/weights!";
}

/********************************************************
 * 6. Lógica LOGIN (type=0)
 ********************************************************/
$loggedUserType = $_SESSION['user_type'] ?? null;
$loggedUser     = $_SESSION['usuario']   ?? null;
$error = '';

// Procesar login
if(isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM credentials WHERE username = :u LIMIT 1");
    $stmt->bindParam(':u', $username);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if($userData && $userData['type'] == 0) {
        if(password_verify($password, $userData['password'])) {
            $_SESSION['usuario']   = $userData['username'];
            $_SESSION['user_type'] = $userData['type'];
            header('Location: seterup.php');
            exit;
        } else {
            $error = "Contraseña inválida.";
        }
    } else {
        $error = "Usuario no encontrado o sin privilegios (type != 0).";
    }
}

/********************************************************
 * 7. Manejar action=update => descarga shards
 ********************************************************/
$mensaje = "";
if($loggedUser && $loggedUserType == 0) {
   if(isset($_GET['action']) && $_GET['action'] === 'update') {
     echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Descargando shards</title></head><body style='font-family:Arial;'>";
     echo "<h2>Descargando shards y manifests de /master/weights</h2>";
     echo "<div id='logConsola' style='width:100%;max-height:400px;overflow:auto;border:1px solid #ccc;padding:10px;background:#f9f9f9;margin-bottom:15px;'></div>";
     flush();

     try {
       $mensaje = descargarModelosFaceApiShards();
       logMessage("Proceso finalizado.");
       echo "<div style='color:green;font-weight:bold;margin-top:10px;'>".htmlspecialchars($mensaje)."</div>";
     } catch(Exception $e) {
       echo "<div style='color:red;font-weight:bold;'>Error descargando: ".htmlspecialchars($e->getMessage())."</div>";
     }

     // Botón para volver
     echo "<br><a href='seterup.php' style='padding:8px 12px;background:#eee;border:1px solid #ccc;text-decoration:none;'>Volver</a>";
     echo "</body></html>";
     exit;
   }
}

// (Opcional) logout
if(isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location: seterup.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>SeterUp - face-api.js master shards</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; }
    .login-box { max-width: 300px; margin: 0 auto; }
    .error { color: red; font-weight: bold; }
    .success { color: green; font-weight: bold; }
    .btn { padding: 8px 12px; font-size: 14px; cursor: pointer; }
  </style>
</head>
<body>

<?php if(!$loggedUser || $loggedUserType != 0): ?>
  <!-- Formulario de login -->
  <div class="login-box">
    <h1>Acceso restringido</h1>
    <?php if($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="seterup.php">
      <label>Usuario:</label><br>
      <input type="text" name="username" required><br><br>

      <label>Contraseña:</label><br>
      <input type="password" name="password" required><br><br>

      <button type="submit" class="btn">Ingresar</button>
    </form>
  </div>
<?php else: ?>
  <h2>Bienvenido, <?= htmlspecialchars($loggedUser) ?> (type=0)</h2>
  <?php if($mensaje): ?>
    <div class="success"><?= htmlspecialchars($mensaje) ?></div>
  <?php endif; ?>

  <p>Este script descarga los 18 archivos con shards y manifest de <code>/face-api.js/master/weights</code>. Al final, quedarán en <code>models/weights</code> dentro de tu hosting.</p>
  <a href="?action=update" class="btn">Descargar Shards</a>

  <form style="margin-top:20px;">
    <input type="hidden" name="action" value="logout">
    <button type="submit" class="btn">Cerrar Sesión</button>
  </form>
<?php endif; ?>

</body>
</html>
