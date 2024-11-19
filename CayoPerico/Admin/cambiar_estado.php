<?php


session_start();
include '../conexion.php';
include_once "../Admin/encabezado.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'], $_POST['estado'])) {
    $pedido_id = $_POST['pedido_id'];
    $estado = $_POST['estado'];

    // Preparar la consulta para actualizar el estado del pedido
    $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $estado, $pedido_id);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la página de pedidos del cliente después de la actualización
        header("Location: admin_pedidos.php?mensaje=Pedido actualizado correctamente");
        exit();
    } else {
        echo "Error al actualizar el estado del pedido.";
    }
} else {
    echo "Datos no válidos.";
}
?>

