<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $autor = $conn->real_escape_string($_POST['autor']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    // Verificar que no existan valores vacíos
    if (empty($titulo) || empty($autor) || $precio <= 0 || $cantidad < 0) {
        echo "Error: Todos los campos deben estar correctamente llenados.";
        exit();
    }

    $sql = "INSERT INTO libros (titulo, autor, precio, cantidad)
            VALUES ('$titulo', '$autor', '$precio', '$cantidad')";

    if ($conn->query($sql) === TRUE) {
        echo "Libro agregado con éxito.";
    } else {
        echo "Error al agregar el libro: " . $conn->error;
    }
}

$conn->close();
?>
