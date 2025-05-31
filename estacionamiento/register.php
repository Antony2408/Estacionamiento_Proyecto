<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = password_hash($_POST['clave'], PASSWORD_BCRYPT);
    $rol = $_POST['rol']; // para el demo se elige nomás, confía xd

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $clave, $rol);

    if ($stmt->execute()) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<h2>Registro</h2>
<form method="POST">
    Nombre: <input type="text" name="nombre" required><br>
    Correo: <input type="email" name="correo" required><br>
    Clave: <input type="password" name="clave" required><br>
    Rol: 
    <select name="rol">
        <option value="operador">Operador</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Registrarse</button>
</form>
