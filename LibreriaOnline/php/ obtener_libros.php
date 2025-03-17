<?php
include 'config.php';

header("Content-Type: application/json");

// Verificar conexión
if (!$conn) {
    die(json_encode(["error" => "Error de conexión a la base de datos"]));
}

$sql = "SELECT id, titulo, autor, precio, cantidad FROM libros";
$resultado = $conn->query($sql);

$libros = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $libros[] = $fila;
    }
    echo json_encode($libros);
} else {
    echo json_encode(["error" => "Error en la consulta SQL: " . $conn->error]);
}

$conn->close();
?>
