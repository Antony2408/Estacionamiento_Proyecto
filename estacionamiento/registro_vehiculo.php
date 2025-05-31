<?php
include 'session.php';
include 'conexion.php';

// Verificamos si el usuario actual es admin
if ($_SESSION['usuario_rol'] !== 'admin') {
    die("Acceso denegado. Solo los administradores pueden registrar vehículos.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $color = $_POST['color'];
    $tipo = $_POST['tipo'];
    $id_usuario = $_POST['id_usuario'];

    $stmt = $conn->prepare("INSERT INTO vehiculos (placa, modelo, color, tipo, id_usuario) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $placa, $modelo, $color, $tipo, $id_usuario);

    if ($stmt->execute()) {
        echo "<p>Vehículo registrado correctamente.</p>";
    } else {
        echo "<p>Error al registrar el vehículo: " . $stmt->error . "</p>";
    }
}

// Obtenemos lista de usuarios para el select
$resultado = $conn->query("SELECT id, nombre FROM usuarios");
?>

<h2>Registrar Vehículo</h2>
<form method="POST">
    Placa: <input type="text" name="placa" required><br>
    Modelo: <input type="text" name="modelo" required><br>
    Color: <input type="text" name="color" required><br>
    Tipo: <input type="text" name="tipo" required><br>
    Usuario dueño: 
    <select name="id_usuario" required>
        <option value="">--Seleccionar usuario--</option>
        <?php while ($row = $resultado->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nombre']) ?> (ID <?= $row['id'] ?>)</option>
        <?php endwhile; ?>
    </select><br>
    <button type="submit">Registrar Vehículo</button>
</form>

<p><a href="index.php">← Volver al índice</a></p>
