<?php
$host = "smartapp.com.co";
$port = 3306;
$username = "techwor2_cayo";
$password = "Cayo;13934";
$database = "techwor2_cayo";

$conn = new mysqli($host, $username, $password, $database, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}
?>
