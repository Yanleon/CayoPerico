<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

include '../conexion.php';
include_once "../Admin/encabezado.php";
include 'auth.php';
include 'logger.php';


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../Estilos/admin.css">
    <link rel="stylesheet" href="../Estilos/dashboard.css">
    
</head>
<body>
    <div class="container">
        <header>
        <h1>
    Hola, <?= $_SESSION['username'] ?>
</h1>
                    <h1>Panel de Administración</h1>
            <div class="menu">
                <nav>
                    <ul>
                        <li><a href="../Admin/admin_pedidos.php">Ver Pedidos</a></li>
                        <li><a href="../Admin/cotizar.php">Calculadora</a></li>
                        <li><a href="../Admin/editar_producto.php">Productos</a></li>
                        <li><a href="../Admin/registrar_usuario.php">Registrar Usuario</a></li>
                        <li><a href="../Admin/agregar_producto.php">Agregar Mercancía</a></li>
                        <li><a href="../logout.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dashboard-cards">
            <div class="card">
                <h3>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM pedidos");
                    $total_pedidos = $result->fetch_assoc()['total'];
                    echo $total_pedidos;
                    ?>
                </h3>
                <p>Total de Pedidos</p>
            </div>
            <div class="card">
                <h3>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM usuarios");
                    $total_usuarios = $result->fetch_assoc()['total'];
                    echo $total_usuarios;
                    ?>
                </h3>
                <p>Total de Usuarios</p>
            </div>
            <div class="card">
                <h3>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) AS total FROM productos");
                    $total_productos = $result->fetch_assoc()['total'];
                    echo $total_productos;
                    ?>
                </h3>
                <p>Total de Productos</p>
            </div>
        </div>

        <h2>Historial de Pedidos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Obtener los pedidos de la base de datos
                $sql = "SELECT p.id, u.nombre AS cliente, pr.nombre AS producto, p.cantidad, p.fecha_pedido, p.estado
                        FROM pedidos p
                        JOIN usuarios u ON p.cliente_id = u.id
                        JOIN productos pr ON p.producto_id = pr.id
                        ORDER BY p.fecha_pedido DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . $row['cliente'] . '</td>
                            <td>' . $row['producto'] . '</td>
                            <td>' . $row['cantidad'] . '</td>
                            <td>' . $row['fecha_pedido'] . '</td>
                            <td>' . $row['estado'] . '</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No hay pedidos realizados.</td></tr>';
                }

                // Cerrar la conexión
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
