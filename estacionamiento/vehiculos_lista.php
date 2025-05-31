<?php
include 'conexion.php';
include 'session.php';

$result = $conn->query("SELECT v.id, v.placa, v.modelo, v.color, v.tipo, u.nombre AS propietario 
                        FROM vehiculos v 
                        JOIN usuarios u ON v.id_usuario = u.id");
?>

<h2>Lista de Vehículos</h2>
<a href="registro_vehiculo.php">Registrar nuevo vehículo</a>
<table border="1" cellpadding="5">
    <tr>
        <th>Placa</th><th>Modelo</th><th>Color</th><th>Tipo</th><th>Propietario</th><th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['placa']) ?></td>
        <td><?= htmlspecialchars($row['modelo']) ?></td>
        <td><?= htmlspecialchars($row['color']) ?></td>
        <td><?= htmlspecialchars($row['tipo']) ?></td>
        <td><?= htmlspecialchars($row['propietario']) ?></td>
        <td>
            <a href="editar_vehiculo.php?id=<?= $row['id'] ?>">Editar</a> |
            <a href="eliminar_vehiculo.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

