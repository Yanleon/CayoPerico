<?php
session_start();
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $fecha_pedido = $_POST['fecha_pedido'];
    $estado = $_POST['estado'];
    $cantidades = $_POST['cantidades'];

    // Actualizar cantidades de productos
    foreach ($cantidades as $pedido_id => $cantidad) {
        $sql = "UPDATE pedidos SET cantidad = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cantidad, $pedido_id);
        $stmt->execute();
    }

    // Actualizar estado general del pedido
    $sql_estado = "UPDATE pedidos SET estado = ? WHERE cliente_id = ? AND fecha_pedido = ?";
    $stmt_estado = $conn->prepare($sql_estado);
    $stmt_estado->bind_param("sis", $estado, $cliente_id, $fecha_pedido);
    $stmt_estado->execute();

    // Redirigir de nuevo a la página de pedidos
    header("Location: admin_pedidos.php");
    exit();
}
?>
