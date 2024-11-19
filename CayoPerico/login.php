<?php
// Incluir el archivo de conexión
include 'conexion.php';
include 'Admin/logger.php'; // Asegúrate de tener el archivo para los registros

// Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar los datos del formulario para evitar inyecciones SQL
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Consultar al usuario por nombre de usuario
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Establecer las variables de sesión
            $_SESSION['username'] = $row['nombre'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];

            // Registrar inicio de sesión exitoso
            write_log("Inicio de sesión exitoso para el usuario ID: {$row['id']} ({$row['username']})");

            // Redirigir según el rol del usuario
            if ($row['role'] == 'admin') {
                header("Location: Admin/admin.php");
            } else {
                header("Location: User/index_cliente.php");
            }
            exit();
        } else {
            // Registrar fallo de inicio de sesión (contraseña incorrecta)
            write_log("Fallo de inicio de sesión: contraseña incorrecta para el usuario: $username");
            echo "Contraseña incorrecta";
        }
    } else {
        // Registrar fallo de inicio de sesión (usuario no encontrado)
        write_log("Fallo de inicio de sesión: usuario no encontrado: $username");
        echo "Usuario no encontrado";
    }

    // Cerrar el statement y la conexión
    $stmt->close();
    $conn->close();
}
?>



