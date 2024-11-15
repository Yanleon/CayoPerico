<?php
include_once "../Admin/encabezado.php";

include_once "../Admin/encabezado.php";

session_start();

include '../conexion.php';

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    // Si no ha iniciado sesión o no es administrador, redirigir al login
    header("Location: login.html");
    exit();
}

// Procesar el registro de usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO usuarios (nombre, email, username, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $email, $username, $password, $role);

    if ($stmt->execute()) {
        echo "Usuario registrado correctamente";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
   
    <link rel="stylesheet" href="../Estilos/estilo_general.css">
</head>
<body>
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
    <div class="container">
        <h1>Registrar Nuevo Usuario</h1>
        <form action="registrar_usuario.php" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="email">Correo Electrónico</label>
        <input type="email" id="email" name="email" required>
        
        <label for="username">Usuario</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
        
        <label for="role">Rol</label>
        <select id="role" name="role">
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
            
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
