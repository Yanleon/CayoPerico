<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

include '../conexion.php';
include_once "../Admin/encabezado.php";



$sql = "SELECT DISTINCT usuarios.id, usuarios.nombre 
        FROM pedidos 
        JOIN usuarios ON pedidos.cliente_id = usuarios.id";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Pedidos</title>
    <link rel="stylesheet" href="../Estilos/estilo_general.css">

</head>

<body>
    <div class="container">
        <h1>Pedidos por Cliente</h1>
        <header>
        <div class="menu">
            <nav>
                <ul>
                <li><a href="../Admin/admin.php">Inicio</a></li>
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
                    <th>Cliente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>' . htmlspecialchars($row['nombre']) . '</td>
                            <td><a href="ver_pedido.php?cliente_id=' . htmlspecialchars($row['id']) . '">Ver Pedidos</a></td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">No hay pedidos disponibles.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>