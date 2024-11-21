<?php
session_start();
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que se reciba el ID del pedido
    if (isset($_POST['pedido_id'])) {
        $pedido_id = intval($_POST['pedido_id']); // Convertir a entero

        // Verificar que el ID del pedido sea válido
        if ($pedido_id <= 0) {
            $_SESSION['mensaje_error'] = "ID de pedido inválido.";
            header("Location: admin_pedidos.php");
            exit();
        }

        // Preparar la consulta para eliminar el pedido
        $sql_delete = "DELETE FROM pedidos WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);

        if ($stmt_delete) {
            $stmt_delete->bind_param("i", $pedido_id); // Asociar el parámetro
            if ($stmt_delete->execute()) {
                // Eliminar exitosamente
                $_SESSION['mensaje'] = "El pedido fue eliminado correctamente.";
            } else {
                // Error al ejecutar la consulta
                $_SESSION['mensaje_error'] = "No se pudo eliminar el pedido. Error: " . $stmt_delete->error;
            }
            $stmt_delete->close(); // Cerrar la consulta preparada
        } else {
            // Error al preparar la consulta
            $_SESSION['mensaje_error'] = "Error en la consulta: " . $conn->error;
        }
    } else {
        $_SESSION['mensaje_error'] = "No se recibió el ID del pedido.";
    }
} else {
    $_SESSION['mensaje_error'] = "Método de solicitud no permitido.";
}

// Redirigir siempre a admin_pedidos.php
header("Location: ver_pedido.php");
exit();
?>
