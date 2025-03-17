<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    require 'config.php';
    $stmt = $conn->prepare("INSERT INTO USUARIOS (nombre, email, contraseña, direccion, telefono) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $email, $password, $direccion, $telefono);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: ../login.html");
}
?>