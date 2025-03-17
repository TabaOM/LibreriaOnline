<?php
$conn = new mysqli("localhost:8889", "root", "root", "LIBRERIA");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>