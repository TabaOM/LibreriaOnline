<?php
session_start();
$response = ["autenticado" => false];

if (isset($_SESSION['usuario_id'])) {
    $response["autenticado"] = true;
}

echo json_encode($response);
?>
