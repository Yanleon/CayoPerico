<?php
include_once "../Admin/encabezado.php";

session_start();

include '../conexion.php';

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    // Si no ha iniciado sesión o no es administrador, redirigir al login
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Manejo de la carga de la imagen
    $imagen = $_FILES['imagen']['name'];
    $ruta_imagen = 'uploads/' . basename($imagen);

    // Verificación del tipo de archivo
    $tipo_imagen = $_FILES['imagen']['type'];
    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($tipo_imagen, $tipos_permitidos)) {
        echo "Solo se permiten imágenes JPG, PNG y GIF.";
        exit();
    }

    // Mover la imagen a la carpeta "uploads"
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
        // Insertar producto en la base de datos
        $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, stock) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $ruta_imagen, $stock);

        if ($stmt->execute()) {
            echo "Producto agregado exitosamente.";
        } else {
            echo "Error al agregar el producto: " . $stmt->error;
        }
    } else {
        echo "Error al subir la imagen.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="../Estilos/estilo_general.css">

</head>
<body>
<header>
<div class="menu">
                <nav>
                    <ul>
                    <li><a href="../Admin/admin_pedidos.php">Ver Pedidos</a></li>
                    <li><a href="../Admin/registrar_usuario.php">Registrar Usuario</a></li>
                <li><a href="../Admin/agregar_producto.php">Agregar Mercancia</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
    </header>
    <div class="container">
        <h1>Agregar Producto</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required></textarea>
            <label for="precio">Precio:</label>
            <input type="number" name="precio" step="0.01" required>
            <label for="stock">Stock:</label>
            <input type="number" name="stock" required>
            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" accept="image/*" required>
            <button type="submit">Agregar Producto</button>
        </form>
    </div>
</body>
</html>
