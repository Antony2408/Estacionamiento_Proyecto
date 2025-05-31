<?php
include 'session.php'; // Para validar sesión


echo "<h1>Bienvenido, " . $_SESSION['usuario_nombre'] . "</h1>";

echo "<ul>";
echo "<li><a href='dashboard.php'>Dashboard</a></li>";
echo "<li><a href='registro_vehiculo.php'>Registrar Vehículo</a></li>";
echo "<li><a href='registro_estacionamiento.php'>Registrar Estacionamiento</a></li>";
echo "<li><a href='logout.php'>Cerrar Sesión</a></li>";
<li><a href='vehiculos_lista.php'>Vehículos</a></li>

echo "</ul>";
