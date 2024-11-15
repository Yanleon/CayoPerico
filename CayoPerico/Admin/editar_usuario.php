<?php
include_once "../Admin/encabezado.php";

include '../conexion.php';

if (!isset($_GET['id'])) {
    header("Location: usuarios.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Usuario no encontrado.";
    exit();
}

$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    $sql_update = "UPDATE usuarios SET nombre = ?, email = ?, username = ?, role = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $nombre, $email, $username, $role, $id);

    if ($stmt_update->execute()) {
        header("Location: usuarios.php");
        exit();
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../Estilos/estilo_general.css">

</head>
<body>
    <div class="container">
        <h1>Editar Usuario</h1>
        <form method="POST">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
            
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <label for="username">Usuario</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            
            <label for="role">Rol</label>
            <select id="role" name="role" required>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="cliente" <?php echo $user['role'] === 'cliente' ? 'selected' : ''; ?>>Cliente</option>
            </select>
            
            <button type="submit">Actualizar</button>
        </form>
        <a href="usuarios.php" class="btn">Cancelar</a>
    </div>
</body>
</html>
