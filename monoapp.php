<?php
session_start();

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'Personal';
$dbuser = 'Piramideadmin';
$dbpass = 'Engteacher1';

// Función para conectar a la base de datos
function conectarDB($host, $dbname, $dbuser, $dbpass) {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

// Manejar solicitud de cierre de sesión (logout)
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: app.php");
    exit();
}

// Manejador de autenticación
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['authenticated'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $pdo = conectarDB($host, $dbname, $dbuser, $dbpass);
        $stmt = $pdo->prepare("SELECT * FROM credentials WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $cred = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cred && password_verify($password, $cred['password'])) {
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $username;
        } else {
            $loginError = 'Credenciales inválidas';
        }
    } catch (Exception $ex) {
        $loginError = 'Error en la conexión a la base de datos';
    }
}

// Si el usuario no está autenticado, mostrar formulario de login
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Psigna - Login</title>
      <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; 
               font-family: Arial, sans-serif; background-color: #f0f2f5; }
        .login-container { background: white; padding: 2rem; border-radius: 8px; 
                           box-shadow: 0px 0px 10px rgba(0,0,0,0.1); width: 300px; }
        .login-container h2 { text-align: center; margin-bottom: 1rem; }
        .login-container label { display: block; margin-top: 1rem; }
        .login-container input { width: 100%; padding: 0.5rem; margin-top: 0.5rem; }
        .login-container button { width: 100%; padding: 0.7rem; margin-top: 1rem; 
                                  background-color: #007bff; border: none; color: white; cursor: pointer; }
        .error { color: red; text-align: center; margin-top: 1rem; }
      </style>
    </head>
    <body>
      <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="app.php">
          <label for="username">Usuario:</label>
          <input type="text" id="username" name="username" required>
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required>
          <button type="submit">Entrar</button>
        </form>
        <?php if ($loginError): ?>
          <p class="error"><?php echo htmlspecialchars($loginError); ?></p>
        <?php endif; ?>
      </div>
    </body>
    </html>
    <?php
    exit();
}

// Si el usuario está autenticado, mostrar el dashboard
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Psigna - Dashboard</title>
  <style>
    /* Estilos para el dashboard */
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
    header { background-color: #007bff; padding: 10px; color: white; }
    nav ul { list-style: none; display: flex; gap: 20px; }
    nav ul li a { color: white; text-decoration: none; }
    main { padding: 20px; }
    #cardsContainer { display: flex; flex-wrap: wrap; gap: 20px; }
    .card { background: #f8f9fa; border: 1px solid #ddd; border-radius: 8px; padding: 15px; width: 200px; cursor: pointer; }
    .card h3 { margin-top: 0; }
    /* Estilos adicionales para modales, tablas, etc., si se requieren */
  </style>
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="?logout=true">Logout</a></li>
        <li><a href="#" id="menuGeneral">General</a></li>
        <li><a href="#" id="menuExportar">Exportar</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div id="cardsContainer">Cargando datos...</div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      cargarMarcaciones();
      configurarMenus();
      actualizarConexion();
      setInterval(actualizarConexion, 60000); // Actualizar la conexión cada minuto
    });

    let marcacionesData = [];

    async function cargarMarcaciones() {
      try {
        const response = await fetch('fetch_marcaciones.php');
        const result = await response.json();
        if (result.ok) {
          marcacionesData = result.data;
          procesarDatos();
        } else {
          console.error('Error al cargar marcaciones:', result.error);
        }
      } catch (error) {
        console.error('Error en la solicitud de marcaciones:', error);
      }
    }

    function procesarDatos() {
      const diasAsistidos = {};
      marcacionesData.forEach(m => {
        const nombre = m.nombre_personal;
        if (!diasAsistidos[nombre]) {
          diasAsistidos[nombre] = new Set();
        }
        diasAsistidos[nombre].add(m.fecha);
      });

      const cardsContainer = document.getElementById('cardsContainer');
      cardsContainer.innerHTML = '';
      for (const [nombre, dias] of Object.entries(diasAsistidos)) {
        const card = document.createElement('div');
        card.className = 'card';
        card.innerHTML = `<h3>${nombre}</h3><p>Días asistidos: ${dias.size}</p>`;
        // Agregar evento de clic si es necesario para mostrar detalles
        cardsContainer.appendChild(card);
      }
    }

    function configurarMenus() {
      document.getElementById('menuGeneral').addEventListener('click', () => {
        // Implementar vista general si se requiere
      });
      document.getElementById('menuExportar').addEventListener('click', () => {
        // Implementar exportación si se requiere
      });
    }

    function actualizarConexion() {
      fetch('update_connection.php')
        .then(res => res.json())
        .then(data => {
          if (!data.ok) {
            console.error("Error actualizando la conexión:", data.error);
          }
        })
        .catch(err => console.error('Error en la actualización de conexión:', err));
    }
  </script>
</body>
</html>
