<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buscar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Verificar la contraseña
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Guardar la información del usuario en la sesión
            $_SESSION['username'] = $row['nombre'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            
            // Redirigir según el rol del usuario
            if ($row['role'] == 'admin') {
                header("Location: Admin/admin.php");
            } else {
                header("Location: User/index_cliente.php");
            }
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }

    // Cerrar la conexión
    $conn->close();
}
?>


