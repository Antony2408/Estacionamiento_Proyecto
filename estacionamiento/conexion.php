<?php
$host = "localhost";
$usuario = "root";       // Usuario por defecto
$clave = "";             // Sin contraseña por defecto
$base_datos = "estacionamiento";

// Crear conexión
$conn = new mysqli($host, $usuario, $clave, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
