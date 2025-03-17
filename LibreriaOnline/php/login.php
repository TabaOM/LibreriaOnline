<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    require 'config.php';
    $stmt = $conn->prepare("SELECT id, contraseña FROM USUARIOS WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $hash);
    $stmt->fetch();

    if (password_verify($password, $hash)) {
        $_SESSION['user_id'] = $id;
        header("Location: ../index.html");
    } else {
        echo "Credenciales incorrectas.";
    }
    $stmt->close();
    $conn->close();
}
?>