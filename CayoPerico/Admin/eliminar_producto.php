<?php
include_once "../Admin/encabezado.php";

session_start();
include '../conexion.php';

// Verificar si el usuario tiene permisos de admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

// Verificar que se recibió el id del producto
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Eliminar el producto
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $producto_id);

    if ($stmt->execute()) {
        header("Location: editar_producto.php"); // Redirigir a la página de administración de productos
        exit();
    } else {
        echo "Error al eliminar el producto.";
    }
} else {
    echo "ID de producto no proporcionado.";
}
?>
