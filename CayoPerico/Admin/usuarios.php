<?php
include '../conexion.php';
include_once "../Admin/encabezado.php";



$sql = "SELECT id, nombre, email, username, role FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
    <link rel="stylesheet" href="../Estilos/estilo_general.css">

</head>
<body>
    <div class="container">
        <h1>Usuarios Registrados</h1>
        <header>
<div class="menu">
                <nav>
                    <ul>
                    <li><a href="../Admin/admin.php">Inicio</a></li>
                <li><a href="../Admin/usuarios.php">Usuarios</a></li>
                <li><a href="../Admin/agregar_producto.php">Agregar Mercancia</a></li>
                <li><a href="../logout.php">Cerrar Sesión</a></li>
                    </ul>
                </nav>
    </header>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nombre']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['role']}</td>
                            <td>
                                <a href='editar_usuario.php?id={$row['id']}'>Editar</a> | 
                                <a href='eliminar_usuario.php?id={$row['id']}' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este usuario?\")'>Eliminar</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay usuarios registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
