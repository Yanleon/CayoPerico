<?php
include_once "../Admin/encabezado.php";

session_start();
include '../conexion.php';

$total = 0;
$productos_cotizados = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cantidad'])) {
    foreach ($_POST['cantidad'] as $id_producto => $cantidad) {
        $cantidad = intval($cantidad);
        if ($cantidad > 0) {
             $sql = "SELECT nombre, precio FROM productos WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_producto);
            $stmt->execute();
            $result = $stmt->get_result();
            $producto = $result->fetch_assoc();

            if ($producto) {
                $subtotal = $producto['precio'] * $cantidad;
                $total += $subtotal;

                // Almacenar detalles del producto para el resumen
                $productos_cotizados[] = [
                    'nombre' => $producto['nombre'],
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto['precio'],
                    'subtotal' => $subtotal
                ];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Estilos/estilo_general.css"> 
    <title>Resumen de Cotización</title>
</head>
<body>
    <div class="container">
        <h1>Resumen de Cotización</h1>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos_cotizados as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                        <td>$<?php echo number_format($producto['precio_unitario'], 2); ?></td>
                        <td>$<?php echo number_format($producto['subtotal'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Total: $<?php echo number_format($total, 2); ?></h2>
        <a href="admin.php">Regresar</a>
    </div>
</body>
</html>
