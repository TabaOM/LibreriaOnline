<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $telefono = $conn->real_escape_string($_POST['telefono']);

    // Verificar si el usuario ya existe
    $query = "SELECT id FROM usuarios WHERE email='$email'";
    $resultado = $conn->query($query);

    if ($resultado->num_rows > 0) {
        echo "Error: El correo ya está registrado.";
    } else {
        // Insertar usuario
$sql = "INSERT INTO usuarios (nombre, email, contraseña, direccion, telefono)
        VALUES ('$nombre', '$email', '$password', '$direccion', '$telefono')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso. <a href='../login.html'>Inicia sesión aquí</a>";
        } else {
            echo "Error al registrar usuario: " . $conn->error;
        }
    }
}

$conn->close();
?>
