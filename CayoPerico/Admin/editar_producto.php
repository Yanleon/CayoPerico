<?php
session_start();
include '../conexion.php';
include_once "../Admin/encabezado.php";


// Verificar si el usuario tiene permisos de admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

// Consultar todos los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Productos</title>
    <link rel="stylesheet" href="../Estilos/estilo_general.css">

</head>
<body>
    <div class="container">
        <h1>Gestionar Productos</h1>
        <header>
        <div class="menu">
                <nav>
                    <ul>
                    <li><a href="../Admin/admin.php">Inicio</a></li>
                    <li><a href="../Admin/cotizar.php">Calculadora</a></li>
                    <li><a href="../Admin/registrar_usuario.php">Registrar Usuario</a></li>
                    <li><a href="../Admin/agregar_producto.php">Agregar Mercancia</a></li>
                    <li><a href="../logout.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </div>
</header>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($producto = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($producto['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($producto['nombre']) . '</td>';
                        echo '<td>' . htmlspecialchars($producto['descripcion']) . '</td>';
                        echo '<td>' . htmlspecialchars($producto['precio']) . '</td>';
                        echo '<td>' . htmlspecialchars($producto['stock']) . '</td>';
                        echo '<td><img src="' . htmlspecialchars($producto['imagen']) . '" alt="Imagen" style="max-width: 100px;"></td>';
                        echo '<td>';
                        echo '<a href="editar_detalle_producto.php?id=' . htmlspecialchars($producto['id']) . '">Editar</a> | ';
                        echo '<a href="eliminar_producto.php?id=' . htmlspecialchars($producto['id']) . '" onclick="return confirm(\'¿Estás seguro de eliminar este producto?\')">Eliminar</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7">No hay productos disponibles.</td></tr>';
                }
                ?>
            </tbody>
        </table>

    </div>
</body>
</html>
