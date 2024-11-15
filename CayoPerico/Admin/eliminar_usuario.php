<?php
include_once "../Admin/encabezado.php";

include '../conexion.php';

if (!isset($_GET['id'])) {
    header("Location: usuarios.php");
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: usuarios.php");
    exit();
} else {
    echo "Error al eliminar el usuario.";
}
?>
