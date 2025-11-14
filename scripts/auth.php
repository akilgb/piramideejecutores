<?php
require_once 'session_manager.php';
header('Content-Type: application/json; charset=utf-8');

$inputJSON = file_get_contents('php://input');
$inputData = json_decode($inputJSON, true);

if (!$inputData || !isset($inputData['username'], $inputData['password'])) {
    echo json_encode(['ok' => false, 'error' => 'Datos no válidos']);
    exit;
}

$username = $inputData['username'];
$password = $inputData['password'];

try {
    $host = 'localhost';
    $dbname = 'Personal';
    $user = 'Piramideadmin';
    $pass = 'Engteacher1';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buscar credenciales en la base de datos
    $stmt = $pdo->prepare("SELECT * FROM credentials WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $cred = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cred && password_verify($password, $cred['password'])) {
        // Credenciales válidas, establecer sesión
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        echo json_encode(['ok' => true]);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Credenciales inválidas']);
    }
} catch (Exception $ex) {
    echo json_encode(['ok' => false, 'error' => $ex->getMessage()]);
}
?>
