<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    require 'config.php';
    $stmt = $conn->prepare("INSERT INTO LIBROS (titulo, autor, precio, cantidad) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $titulo, $autor, $precio, $cantidad);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: ../libros.html");
}
?>