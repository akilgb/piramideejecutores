<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
if (isset($_SESSION['usuario'])) {
    echo json_encode(["logged_in" => true]);
} else {
    echo json_encode(["logged_in" => false]);
}
?>
