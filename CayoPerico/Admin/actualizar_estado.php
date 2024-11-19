<?php
session_start();

include '../conexion.php';
include_once "../Admin/encabezado.php";


// Verificar si el pedido_id y estado están presentes
if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
    $pedido_id = $_POST['pedido_id'];
    $estado = $_POST['estado'];

    // Actualizar el estado del pedido
    $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $estado, $pedido_id);

    if ($stmt->execute()) {
        // Redirigir a la página de pedidos con un mensaje de éxito
        header("Location: pedidos_cliente.php?success=Estado del pedido actualizado.");
        exit();
    } else {
        // Si ocurre un error, redirigir con un mensaje de error
        header("Location: pedidos_cliente.php?error=Error al actualizar el estado.");
        exit();
    }
}
?>
