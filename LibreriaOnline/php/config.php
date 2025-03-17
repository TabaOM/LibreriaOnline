<?php
$conn = new mysqli("localhost:3306", "root", "", "LIBRERIA");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>