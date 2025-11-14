<?php
// app3plus_endpoint.php

header('Content-Type: application/json; charset=utf-8');

// Función para registrar logs en un archivo de texto
function registrar_log($mensaje) {
    $archivo = 'debug_log.txt'; // Nombre del archivo de log
    $fecha = date('Y-m-d H:i:s'); // Fecha y hora actual
    $mensaje_con_fecha = "[$fecha] $mensaje\n"; // Formato del mensaje
    // Escribir el mensaje en el archivo, agregando al final y bloqueando el archivo durante la escritura
    file_put_contents($archivo, $mensaje_con_fecha, FILE_APPEND | LOCK_EX);
}

// Lectura del JSON recibido
$inputJSON = file_get_contents('php://input');
$inputData = json_decode($inputJSON, true);

// Verificar si se recibieron datos válidos
if (!$inputData) {
    registrar_log('Error: No se recibieron datos o el formato JSON es inválido.');
    echo json_encode([
        'ok' => false,
        'error' => 'No se recibieron datos o el formato JSON es inválido.'
    ]);
    exit;
}

// Registrar los datos recibidos en el archivo de log
$datos_recibidos = print_r($inputData, true);
registrar_log("Datos recibidos: $datos_recibidos");

// Extraer datos del arreglo
$nombrePersonal       = $inputData['nombrePersonal']       ?? '';
$ipPublica            = $inputData['ipPublica']            ?? '';
$ipLocal              = $inputData['ipLocal']              ?? '';
$fotoEvidencia        = $inputData['fotoEvidencia']        ?? '';
$dispositivoDetectado = $inputData['dispositivoDetectado'] ?? false;
$fraudeDetectado      = $inputData['fraudeDetectado']      ?? false;
$cambioDeRostro       = $inputData['cambioDeRostro']       ?? false;
$marcacionExitosa     = $inputData['marcacionExitosa']     ?? false;

// Construir un string de observaciones
$observaciones = [];
if ($dispositivoDetectado) $observaciones[] = "Dispositivo electrónico";
if ($fraudeDetectado)      $observaciones[] = "Fraude Detectado";
if ($cambioDeRostro)       $observaciones[] = "Cambio de Rostro";
if ($marcacionExitosa)     $observaciones[] = "Marcación Exitosa";

$strObservaciones = implode(" | ", $observaciones);

// Continuar con la lógica de la base de datos
try {
    // Configura tu conexión a la BD
    $host = 'localhost';
    $dbname = 'Personal';
    $user = 'Piramideadmin';
    $pass = 'Engteacher1';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertar en la tabla (tomando la fecha y hora del servidor)
    // Usamos DATE_FORMAT para guardar la fecha/hora en formato latino (dd-mm-YYYY / HH:MM:SS).
    $sql = "INSERT INTO marcaciones (
                fecha,
                hora,
                nombre_personal,
                observaciones,
                ip_publica,
                ip_local,
                foto_evidencia
            )
            VALUES (
                DATE_FORMAT(NOW(), '%d-%m-%Y'),
                DATE_FORMAT(NOW(), '%H:%i:%s'),
                :nombre_personal,
                :observaciones,
                :ip_publica,
                :ip_local,
                :foto_evidencia
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre_personal', $nombrePersonal);
    $stmt->bindParam(':observaciones',   $strObservaciones);
    $stmt->bindParam(':ip_publica',      $ipPublica);
    $stmt->bindParam(':ip_local',        $ipLocal);
    $stmt->bindParam(':foto_evidencia',  $fotoEvidencia, PDO::PARAM_STR);

    $stmt->execute();

    registrar_log('Datos insertados correctamente en la base de datos.');

    echo json_encode(['ok' => true]);
} catch (Exception $ex) {
    registrar_log('Error al procesar la solicitud: ' . $ex->getMessage());
    echo json_encode(['ok' => false, 'error' => $ex->getMessage()]);
}
