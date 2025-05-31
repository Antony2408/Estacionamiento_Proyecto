<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    $stmt = $conn->prepare("SELECT id, nombre, clave, rol FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($clave, $user['clave'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nombre'] = $user['nombre'];
            $_SESSION['usuario_rol'] = $user['rol'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Clave incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>

<h2>Login</h2>
<form method="POST">
    Correo: <input type="email" name="correo" required><br>
    Clave: <input type="password" name="clave" required><br>
    <button type="submit">Iniciar Sesión</button>
</form>
