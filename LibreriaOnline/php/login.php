<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Buscar usuario en la base de datos
$sql = "SELECT id, nombre, contraseña FROM usuarios WHERE email='$email'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $usuario['contraseña'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            header("Location: ../index.html");
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró una cuenta con ese correo.";
    }
}

$conn->close();
?>
