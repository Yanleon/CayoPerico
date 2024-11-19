<?php


session_start();
include '../conexion.php';
include_once "../Admin/encabezado.php";


// Verificar si el usuario está logueado y es admin
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

// Verificar si el ID del producto fue enviado
if (!isset($_POST['id'])) {
    echo "ID del producto no proporcionado.";
    exit();
}

$producto_id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$imagen = $_FILES['imagen']['name'];  // Obtener el nombre del archivo de la imagen
$imagen_tmp = $_FILES['imagen']['tmp_name'];  // Ruta temporal de la imagen

if (!empty($_FILES['imagen']['name'])) {
    $imagen = $_FILES['imagen']['name'];
    $imagen_tmp = $_FILES['imagen']['tmp_name'];
    
    // Usar la ruta absoluta para mayor seguridad
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/CayoPerico/Admin/uploads/';
    $target_file = $target_dir . basename($imagen);

    // Verificar si la carpeta uploads existe
    if (!is_dir($target_dir)) {
        echo "La carpeta de destino no existe.";
        exit();
    }

    // Verificar si el archivo es una imagen válida
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "Solo se permiten imágenes JPG, JPEG, PNG y GIF.";
        exit();
    }

    // Intentar mover el archivo
    if (move_uploaded_file($imagen_tmp, $target_file)) {
        $imagen_url = "uploads/" . basename($imagen);  // Ruta relativa a la carpeta uploads
    } else {
        echo "Hubo un error al subir la imagen.";
        echo " Intentando mover el archivo a: " . $target_file;  // Depuración
        exit();
    }
} else {
    // Si no se sube una nueva imagen, mantener la imagen actual
    $sql = "SELECT imagen FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        $imagen_url = $producto['imagen'];  // Usar la imagen existente
    } else {
        echo "Producto no encontrado.";
        exit();
    }
}

// Actualizar el producto en la base de datos
$sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, imagen = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

// Verifica si las variables no son vacías y depura las variables
echo "nombre: $nombre<br>";
echo "descripcion: $descripcion<br>";
echo "precio: $precio<br>";
echo "stock: $stock<br>";
echo "imagen_url: $imagen_url<br>";
echo "producto_id: $producto_id<br>";

// Verificar que las variables están bien definidas
$stmt->bind_param("ssdssi", $nombre, $descripcion, $precio, $stock, $imagen_url, $producto_id);


// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Producto actualizado con éxito.";
} else {
    echo "Error al actualizar el producto: " . $stmt->error;
}

// Redirigir a la página de editar producto
header("Location: editar_producto.php?id=" . $producto_id);
exit();


$stmt->close();
$conn->close();

