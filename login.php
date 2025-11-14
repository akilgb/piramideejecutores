<?php
session_start();

// Datos de conexión a la base de datos
$host = 'localhost';
$dbname = 'Personal';
$user = 'Piramideadmin';
$pass = 'Engteacher1';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

// Recibir datos del formulario
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Consultar si existe ese usuario en la tabla `credentials`
$stmt = $pdo->prepare("SELECT * FROM credentials WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();

$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($userData) {
  // Verificar contraseña con password_verify (asume que está hasheada en la DB)
  if (password_verify($password, $userData['password'])) {
    // Si coincide, creamos la sesión
    $_SESSION['usuario'] = $userData['username'];
    // Redirigir a dashboard
    header('Location: dashboard.php');
    exit;
  } else {
    // Contraseña incorrecta
    header('Location: login.html?error=1');
    exit;
  }
} else {
  // Usuario no encontrado
  header('Location: login.html?error=1');
  exit;
}
