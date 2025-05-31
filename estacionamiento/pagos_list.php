<?php
include 'session.php';
include 'conexion.php';

$result = $conn->query("SELECT p.id, p.id_registro, p.monto, p.fecha_pago, p.estado, p.metodo_pago,
                              r.fecha_ingreso, r.fecha_salida
                       FROM pagos p
                       JOIN registros r ON p.id_registro = r.id
                       ORDER BY p.fecha_pago DESC");
?>

<h2>Lista de Pagos</h2>
<a href="pagos_create.php">Nuevo Pago</a>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>ID Registro</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Salida</th>
        <th>Monto</th>
        <th>Fecha Pago</th>
        <th>Estado</th>
        <th>Método de Pago</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['id_registro'] ?></td>
        <td><?= $row['fecha_ingreso'] ?></td>
        <td><?= $row['fecha_salida'] ?? '-' ?></td>
        <td><?= $row['monto'] ?></td>
        <td><?= $row['fecha_pago'] ?></td>
        <td><?= $row['estado'] ?></td>
        <td><?= htmlspecialchars($row['metodo_pago']) ?></td>
        <td>
            <a href="pagos_edit.php?id=<?= $row['id'] ?>">Editar</a> |
            <a href="pagos_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este pago?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<p><a href="index.php">← Volver al índice</a></p>

