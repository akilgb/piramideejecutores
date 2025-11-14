
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ruta a la carpeta de las imágenes
$dir = '/home/piramid1/public_html/recursos/personal';

// Verificar si el directorio existe
if (!is_dir($dir)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'El directorio especificado no existe']);
    exit();
}

// Obtener todos los archivos del directorio
$allFiles = scandir($dir);
if ($allFiles === false) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No se pudo leer el directorio']);
    exit();
}

// Filtrar para mostrar solo imágenes
$images = array_filter($allFiles, function($file) use ($dir) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $allowedExtensions);
});

// Convertir la lista de imágenes en JSON para enviarlo al frontend
header('Content-Type: application/json');
echo json_encode(array_values($images));
?>

