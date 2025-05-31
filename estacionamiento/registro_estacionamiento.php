<?php
include 'session.php';
include 'conexion.php';

// Obtener vehículos para ingreso
$vehiculosIngreso = $conn->query("SELECT v.id, v.placa, u.nombre 
                                  FROM vehiculos v 
                                  JOIN usuarios u ON v.id_usuario = u.id");

// Obtener registros sin salida (vehículos dentro)
$vehiculosDentro = $conn->query("SELECT r.id, v.placa, u.nombre 
                                 FROM registros r 
                                 JOIN vehiculos v ON r.id_vehiculo = v.id 
                                 JOIN usuarios u ON v.id_usuario = u.id 
                                 WHERE r.fecha_salida IS NULL");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['registro_ingreso'])) {
        $id_vehiculo = $_POST['id_vehiculo'];
        $fecha_ingreso = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO registros (id_vehiculo, fecha_ingreso) VALUES (?, ?)");
        $stmt->bind_param("is", $id_vehiculo, $fecha_ingreso);

        if ($stmt->execute()) {
            header("Location: registro_estacionamiento.php");
            exit;
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

    } elseif (isset($_POST['registro_salida'])) {
        $id_registro = $_POST['id_registro'];
        $fecha_salida = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("UPDATE registros SET fecha_salida = ? WHERE id = ?");
        $stmt->bind_param("si", $fecha_salida, $id_registro);

        if ($stmt->execute()) {
            header("Location: registro_estacionamiento.php");
            exit;
        } else {
            echo "<p>Error al registrar salida: " . $stmt->error . "</p>";
        }
    }
}
?>

<h2>Registrar Ingreso</h2>
<form method="POST">
    <select name="id_vehiculo" required>
        <option value="">--Selecciona un vehículo--</option>
        <?php while ($v = $vehiculosIngreso->fetch_assoc()): ?>
            <option value="<?= $v['id'] ?>"><?= $v['placa'] ?> - <?= htmlspecialchars($v['nombre']) ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit" name="registro_ingreso">Registrar Ingreso</button>
</form>

<hr>

<h2>Registrar Salida</h2>
<form method="POST">
    <select name="id_registro" required>
        <option value="">--Selecciona un vehículo dentro--</option>
        <?php while ($v = $vehiculosDentro->fetch_assoc()): ?>
            <option value="<?= $v['id'] ?>"><?= $v['placa'] ?> - <?= htmlspecialchars($v['nombre']) ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit" name="registro_salida">Registrar Salida</button>
</form>

<p><a href="index.php">← Volver al índice</a></p>
