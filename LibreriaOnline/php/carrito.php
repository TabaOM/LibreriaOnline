<?php
session_start();
include 'config.php';

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Manejar acciones del carrito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];
    $id_libro = intval($_POST['id_libro']);

    if ($accion == "agregar") {
        $cantidad = intval($_POST['cantidad']);

        // Verificar si el libro existe en la BD
        $query = "SELECT * FROM libros WHERE id = '$id_libro'";
        $resultado = $conn->query($query);

        if ($resultado->num_rows > 0) {
            $libro = $resultado->fetch_assoc();

            // Agregar al carrito
            if (!isset($_SESSION['carrito'][$id_libro])) {
                $_SESSION['carrito'][$id_libro] = [
                    "titulo" => $libro['titulo'],
                    "precio" => $libro['precio'],
                    "cantidad" => $cantidad
                ];
            } else {
                $_SESSION['carrito'][$id_libro]['cantidad'] += $cantidad;
            }
            echo json_encode(["mensaje" => "Libro agregado al carrito"]);
        } else {
            echo json_encode(["error" => "Error: El libro no existe"]);
        }
    } elseif ($accion == "eliminar") {
        unset($_SESSION['carrito'][$id_libro]);
        echo json_encode(["mensaje" => "Libro eliminado del carrito"]);
    } elseif ($accion == "vaciar") {
        $_SESSION['carrito'] = [];
        echo json_encode(["mensaje" => "Carrito vaciado"]);
    }
}

// Mostrar carrito en formato JSON
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    echo json_encode($_SESSION['carrito']);
}

$conn->close();
?>
