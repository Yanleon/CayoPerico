<?php
session_start();
include '../conexion.php';
include_once "../Admin/encabezado.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedido_id = $_POST['pedido_id'];

    // Eliminar el producto del pedido
    $sql = "DELETE FROM pedidos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();

    // Redirigir a la página anterior
    $referer = $_SERVER['HTTP_REFERER'] ?? 'admin_pedidos.php';
    header("Location: $referer");
    exit();
}
?>
