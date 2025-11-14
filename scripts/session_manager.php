<?php
session_start();

// Tiempo máximo de inactividad en segundos (10 minutos)
$inactivityLimit = 600;

// Verificar si existe un registro de la última actividad
if (isset($_SESSION['LAST_ACTIVITY'])) {
    // Calcular el tiempo transcurrido desde la última actividad
    $elapsedTime = time() - $_SESSION['LAST_ACTIVITY'];
    
    // Si el tiempo transcurrido excede el límite, destruir la sesión
    if ($elapsedTime > $inactivityLimit) {
        session_unset();     // Liberar variables de sesión
        session_destroy();   // Destruir la sesión
        // Redirigir al usuario a la página de login
        header("Location: login.html");
        exit();
    }
}

// Actualizar el tiempo de la última actividad
$_SESSION['LAST_ACTIVITY'] = time();
?>
