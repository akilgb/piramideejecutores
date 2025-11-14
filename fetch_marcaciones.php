<?php
session_start();

// Database connection details
$host = 'localhost';
$dbname = 'Personal';
$user = 'Piramideadmin';
$pass = 'Engteacher1';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Retrieve search and sort parameters
$searchTerm = $_POST['search'] ?? '';
$sortOption = $_POST['sort'] ?? 'nombre_personal'; // Default sort option

// Prepare the base query
$sql = "SELECT * FROM marcaciones WHERE 1=1";

// Add search condition if searchTerm is provided
if (!empty($searchTerm)) {
    $sql .= " AND nombre_personal LIKE :searchTerm";
}

// Add sort order
$sql .= " ORDER BY $sortOption";

$stmt = $pdo->prepare($sql);

// Bind parameters if needed
if (!empty($searchTerm)) {
    $searchTerm = "%$searchTerm%";
    $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
}

$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['ok' => true, 'data' => $data]);
?>