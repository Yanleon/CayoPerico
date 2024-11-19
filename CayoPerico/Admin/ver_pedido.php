<?php
session_start();
include '../conexion.php';
include_once "../Admin/encabezado.php";
include 'auth.php';
include 'logger.php';

// Verificar que se recibió el ID del cliente
if (!isset($_GET['cliente_id'])) {
    header("Location: admin_pedidos.php");
    exit();
}

$cliente_id = $_GET['cliente_id'];

// Obtener las fechas únicas de pedidos del cliente
$sql_fechas = "SELECT DISTINCT fecha_pedido 
               FROM pedidos 
               WHERE cliente_id = ? 
               ORDER BY fecha_pedido DESC";
$stmt_fechas = $conn->prepare($sql_fechas);
$stmt_fechas->bind_param("i", $cliente_id);
$stmt_fechas->execute();
$result_fechas = $stmt_fechas->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos por Fecha</title>
    <link rel="stylesheet" href="../Estilos/estilo_general.css">
</head>
<body>
    <div class="container">
        <h1>Pedidos por Fecha</h1>
        <header>
            <h1>Cayo Perico</h1>
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

        <h2>Fechas de pedidos del cliente</h2>
        <ul>
            <?php
            if ($result_fechas->num_rows > 0) {
                while ($row = $result_fechas->fetch_assoc()) {
                    echo '<li><a href="?cliente_id=' . $cliente_id . '&fecha_pedido=' . $row['fecha_pedido'] . '">' . htmlspecialchars($row['fecha_pedido']) . '</a></li>';
                }
            } else {
                echo '<li>No hay pedidos registrados.</li>';
            }
            ?>
        </ul>

        <?php
        // Mostrar los pedidos de una fecha específica si está seleccionada
        if (isset($_GET['fecha_pedido'])) {
            $fecha_pedido = $_GET['fecha_pedido'];

            $sql_pedidos = "SELECT pedidos.id, pedidos.producto_id, productos.nombre AS producto, 
                                   pedidos.cantidad, pedidos.estado, productos.precio
                            FROM pedidos
                            JOIN productos ON pedidos.producto_id = productos.id
                            WHERE pedidos.cliente_id = ? AND pedidos.fecha_pedido = ?";
            $stmt_pedidos = $conn->prepare($sql_pedidos);
            $stmt_pedidos->bind_param("is", $cliente_id, $fecha_pedido);
            $stmt_pedidos->execute();
            $result_pedidos = $stmt_pedidos->get_result();

            $total = 0;
            $estado_general = '';

            echo '<h2>Pedidos del ' . htmlspecialchars($fecha_pedido) . '</h2>';
            echo '<form action="actualizar_pedido.php" method="POST">
                    <input type="hidden" name="cliente_id" value="' . htmlspecialchars($cliente_id) . '">
                    <input type="hidden" name="fecha_pedido" value="' . htmlspecialchars($fecha_pedido) . '">
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';

            if ($result_pedidos->num_rows > 0) {
                while ($pedido = $result_pedidos->fetch_assoc()) {
                    $subtotal = $pedido['precio'] * $pedido['cantidad'];
                    $total += $subtotal;
                    $estado_general = $pedido['estado']; // Tomamos el estado del primer producto

                    echo '<tr>
                            <td>' . htmlspecialchars($pedido['producto']) . '</td>
                            <td>
                                <input type="number" name="cantidades[' . $pedido['id'] . ']" value="' . htmlspecialchars($pedido['cantidad']) . '" min="1">
                            </td>
                            <td>$' . number_format($subtotal, 2) . '</td>
                            <td>
                                <!-- Botón de eliminación con un formulario independiente -->
                                <form action="eliminar_item_pedido.php" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="pedido_id" value="' . htmlspecialchars($pedido['id']) . '">
                                    <button type="submit" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este producto?\')">Eliminar</button>
                                </form>
                            </td>
                        </tr>';
                }
                echo '<tr>
                        <td colspan="2"><strong>Total</strong></td>
                        <td colspan="2">$' . number_format($total, 2) . '</td>
                      </tr>';
            } else {
                echo '<tr><td colspan="4">No hay pedidos para esta fecha.</td></tr>';
            }

            echo '</tbody>
                </table>
                <label for="estado">Estado del pedido:</label>
                <select name="estado" id="estado">
                    <option value="Pendiente" ' . ($estado_general === 'Pendiente' ? 'selected' : '') . '>Pendiente</option>
                    <option value="Entregado" ' . ($estado_general === 'Entregado' ? 'selected' : '') . '>Entregado</option>
                </select>
                <button type="submit">Actualizar Pedido</button>
            </form>';
        }
        ?>
    </div>
</body>
</html>
