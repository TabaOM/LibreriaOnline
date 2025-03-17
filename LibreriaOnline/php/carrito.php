<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $cantidad = $_POST['cantidad'];
    $user_id = $_SESSION['user_id'];

    require 'config.php';
    $stmt = $conn->prepare("SELECT precio FROM LIBROS WHERE ID = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->bind_result($precio);
    $stmt->fetch();
    $stmt->close();

    $monto_total = $precio * $cantidad;

    $stmt = $conn->prepare("INSERT INTO CARRITO (ID_usuario, ID_libro, cantidad, monto_total) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $user_id, $book_id, $cantidad, $monto_total);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: ../carrito.html");
}
?>