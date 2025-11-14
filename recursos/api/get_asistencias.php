<?php
// recursos/api/get_marcaciones.php

header('Content-Type: application/json; charset=utf-8');

// Función para registrar logs en un archivo de texto (opcional para depuración)
function registrar_log($mensaje) {
    $archivo = 'debug_log_get_marcaciones.txt'; // Nombre del archivo de log
    $fecha = date('Y-m-d H:i:s');
    $mensaje_con_fecha = "[$fecha] $mensaje\n";
    file_put_contents($archivo, $mensaje_con_fecha, FILE_APPEND | LOCK_EX);
}

try {
    // Configuración de conexión a la base de datos
    $host = 'localhost';
    $dbname = 'Personal';
    $user = 'Piramideadmin';
    $pass = 'Engteacher1';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener todos los registros de la tabla 'marcaciones'
    $stmt = $pdo->query("SELECT * FROM marcaciones ORDER BY id DESC");
    $marcaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Registrar cuántos registros se obtuvieron (opcional)
    registrar_log("Registros obtenidos: " . count($marcaciones));

    echo json_encode($marcaciones);
} catch (Exception $ex) {
    registrar_log('Error en get_marcaciones.php: ' . $ex->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener los datos de la base de datos']);
}

