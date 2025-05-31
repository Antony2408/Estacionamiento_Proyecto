<?php
include 'conexion.php';
include 'session.php';

if (!isset($_GET['id'])) {
    echo "ID de vehículo no proporcionado.";
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $color = $_POST['color'];
    $tipo = $_POST['tipo'];

    $stmt = $conn->prepare("UPDATE vehiculos SET placa = ?, modelo = ?, color = ?, tipo = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $placa, $modelo, $color, $tipo, $id);
    $stmt->execute();

    echo "Vehículo actualizado. <a href='vehiculos_lista.php'>Volver</a>";
    exit;
}

$stmt = $conn->prepare("SELECT * FROM vehiculos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$vehiculo = $stmt->get_result()->fetch_assoc();
?>

<h2>Editar Vehículo</h2>
<form method="POST">
    Placa: <input type="text" name="placa" value="<?= htmlspecialchars($vehiculo['placa']) ?>" required><br>
    Modelo: <input type="text" name="modelo" value="<?= htmlspecialchars($vehiculo['modelo']) ?>" required><br>
    Color: <input type="text" name="color" value="<?= htmlspecialchars($vehiculo['color']) ?>" required><br>
    Tipo: <input type="text" name="tipo" value="<?= htmlspecialchars($vehiculo['tipo']) ?>" required><br>
    <button type="submit">Guardar Cambios</button>
</form>
