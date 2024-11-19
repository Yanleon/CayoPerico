<?php
session_start();
include '../conexion.php';
include_once "../Admin/encabezado.php";
include 'auth.php';
include 'logger.php';

// Verificar si el usuario tiene permisos de admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

// Verificar si hay un mensaje de éxito o error
if (isset($_SESSION['message'])) {
    echo '<div class="alert ' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
    // Eliminar el mensaje de la sesión después de mostrarlo
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

// Verificar que se haya proporcionado el id del producto
if (!isset($_GET['id'])) {
    echo "ID de producto no proporcionado.";
    exit();
}

$producto_id = $_GET['id'];

// Consultar el producto de la base de datos
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Producto no encontrado.";
    exit();
}

$producto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../Estilos/estilo_general.css">

</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>
        <form action="actualizar_producto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>
            <div>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>
            <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required step="0.01">
            </div>
            <div>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
            </div>
            <div>
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen">
                <p>Imagen actual: <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen del producto" style="max-width: 100px;"></p>
            </div>
            <button type="submit">Actualizar Producto</button>
        </form>
        <a href="editar_producto.php">Volver a la lista de productos</a>
    </div>
</body>
</html>
