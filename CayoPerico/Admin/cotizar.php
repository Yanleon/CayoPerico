<?php
include_once "../Admin/encabezado.php";

session_start();
include '../conexion.php';


$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizar Productos</title>
    <link rel="stylesheet" href="../Estilos/estilo_general.css">


    <script>
        function calcularTotal() {
            let total = 0;
            document.querySelectorAll('.cantidad').forEach(function(input) {
                const precio = parseFloat(input.getAttribute('data-precio'));
                const cantidad = parseInt(input.value) || 0;
                total += precio * cantidad;
            });
            document.getElementById('total').textContent = 'Total: $' + total.toFixed(2);
        }
    </script>
</head>
<body>
    <div class="container">
    <header>
        
        <h1>Bienvenido</h1>
        <div class="menu">
            <nav>
                <ul>
                <li><a href="../Admin/admin.php">Inicio</a></li>
                <li><a href="../Admin/cotizar.php">Calculadora</a></li>
                <li><a href="../Admin/editar_producto.php">Productos</a></li>
                <li><a href="../Admin/registrar_usuario.php">Registrar Usuario</a></li>
                <li><a href="../Admin/agregar_producto.php">Agregar Mercancia</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
        
    </header>
        <h1>Cotización de Productos</h1>
        <form method="POST" action="procesar_cotizacion.php">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
                            <tr>
                                <td>' . htmlspecialchars($row['nombre']) . '</td>
                                <td>$' . htmlspecialchars(number_format($row['precio'], 2)) . '</td>
                                <td>
                                    <input type="number" name="cantidad[' . $row['id'] . ']" class="cantidad" data-precio="' . $row['precio'] . '" value="0" min="0" onchange="calcularTotal()">
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">No hay productos disponibles.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

            <h2 id="total">Total: $0.00</h2>
            <button type="submit" class="btn">Generar Cotización</button>
          
          
        </form>
    </div>
</body>
</html>
