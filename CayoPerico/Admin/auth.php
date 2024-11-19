<?php
// Verificar si ya hay una sesión activa antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    
    header("Location: ../Login.html");
    exit();
}
?>