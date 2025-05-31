<?php
include 'session.php';
include 'conexion.php';

echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION['usuario_nombre']) . " (" . htmlspecialchars($_SESSION['usuario_rol']) . ")</h2>";

// Consultas para estadísticas básicas

// Total ingresos registrados
$result = $conn->query("SELECT COUNT(*) AS total_ingresos FROM registros");
$total_ingresos = $result->fetch_assoc()['total_ingresos'];

// Total salidas registradas
$result = $conn->query("SELECT COUNT(*) AS total_salidas FROM registros WHERE fecha_salida IS NOT NULL");
$total_salidas = $result->fetch_assoc()['total_salidas'];

// Vehículos con más ingresos (top 5)
$sql = "SELECT v.placa, u.nombre, COUNT(r.id) AS ingresos
        FROM registros r
        JOIN vehiculos v ON r.id_vehiculo = v.id
        JOIN usuarios u ON v.id_usuario = u.id
        GROUP BY r.id_vehiculo
        ORDER BY ingresos DESC
        LIMIT 5";
$topVehiculos = $conn->query($sql);

// Historial reciente (últimos 10 ingresos)
$historial = $conn->query("SELECT r.id, v.placa, u.nombre, r.fecha_ingreso, r.fecha_salida
                           FROM registros r
                           JOIN vehiculos v ON r.id_vehiculo = v.id
                           JOIN usuarios u ON v.id_usuario = u.id
                           ORDER BY r.fecha_ingreso DESC
                           LIMIT 10");

?>

<h3>Estadísticas generales</h3>
<ul>
    <li>Total ingresos registrados: <?= $total_ingresos ?></li>
    <li>Total salidas registradas: <?= $total_salidas ?></li>
</ul>

<h3>Vehículos con más ingresos</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Placa</th>
        <th>Dueño</th>
        <th>Número de ingresos</th>
    </tr>
    <?php while($row = $topVehiculos->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['placa']) ?></td>
            <td><?= htmlspecialchars($row['nombre']) ?></td>
            <td><?= $row['ingresos'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<h3>Historial reciente de estacionamientos</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID Registro</th>
        <th>Placa</th>
        <th>Dueño</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Salida</th>
        <th>Duración (minutos)</th>
    </tr>
    <?php while($row = $historial->fetch_assoc()): 
        $duracion = "N/A";
        if ($row['fecha_salida']) {
            $inicio = new DateTime($row['fecha_ingreso']);
            $fin = new DateTime($row['fecha_salida']);
            $interval = $inicio->diff($fin);
            $duracion = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
        }
    ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['placa']) ?></td>
            <td><?= htmlspecialchars($row['nombre']) ?></td>
            <td><?= $row['fecha_ingreso'] ?></td>
            <td><?= $row['fecha_salida'] ?? '-' ?></td>
            <td><?= $duracion ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="index.php">← Volver al índice</a></p>
