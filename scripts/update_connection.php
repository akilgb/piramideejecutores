<?php
require_once 'session_manager.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['username'])) {
  echo json_encode(['ok' => false, 'error' => 'No hay sesión de usuario']);
  exit;
}

$username = $_SESSION['username'];

try {
    $host = 'localhost';
    $dbname = 'Personal';
    $user = 'Piramideadmin';
    $pass = 'Engteacher1';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("UPDATE credentials SET estado = 1 WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    echo json_encode(['ok' => true]);
} catch(Exception $ex) {
    echo json_encode(['ok' => false, 'error' => $ex->getMessage()]);
}
?>
