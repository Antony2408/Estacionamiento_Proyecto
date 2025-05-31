<?php
include 'conexion.php';
include 'session.php';

if (!isset($_GET['id'])) {
    echo "ID no proporcionado.";
    exit;
}

$id = $_GET['id'];

// Borrar vehículo
$stmt = $conn->prepare("DELETE FROM vehiculos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: vehiculos_lista.php");
exit;
