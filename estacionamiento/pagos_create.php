<?php
include 'session.php';
include 'conexion.php';

// Obtener registros para el select
$registros = $conn->query("SELECT r.id, v.placa FROM registros r JOIN vehiculos v ON r.id_vehiculo = v.id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_registro = $_POST['id_registro'];
    $monto = $_POST['monto'];
    $fecha_pago = $_POST['fecha_pago'];
    $estado = $_POST['estado'];
    $metodo_pago = $_POST['metodo_pago'];

    $stmt = $conn->prepare("INSERT INTO pagos (id_registro, monto, fecha_pago, estado, metodo_pago) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idsss", $id_registro, $monto, $fecha_pago, $estado, $metodo_pago);

    if ($stmt->execute()) {
        header("Location: pagos_list.php");
        exit;
    } else {
        echo "Error al registrar el pago: " . $stmt->error;
    }
}
?>

<h2>Nuevo Pago</h2>
<form method="POST">
    Registro:
    <select name="id_registro" required>
        <option value="">--Seleccionar registro--</option>
        <?php while ($row = $registros->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>">ID <?= $row['id'] ?> - Placa <?= htmlspecialchars($row['placa']) ?></option>
        <?php endwhile; ?>
    </select><br>

    Monto: <input type="number" step="0.01" name="monto" required><br>
    Fecha Pago: <input type="datetime-local" name="fecha_pago" required><br>
    Estado:
    <select name="estado" required>
        <option value="pendiente">Pendiente</option>
        <option value="pagado">Pagado</option>
    </select><br>
    Método de Pago: <input type="text" name="metodo_pago" required><br>
    <button type="submit">Guardar</button>
</form>

<p><a href="pagos_list.php">← Volver a la lista</a></p>
