<?php
function write_log($message) {
    $log_file = __DIR__ . '/logs.txt'; // Archivo donde se guardarán los logs
    $date = date('Y-m-d H:i:s'); // Fecha y hora actual
    $log_message = "[$date] $message" . PHP_EOL;
    file_put_contents($log_file, $log_message, FILE_APPEND); // Agregar el log al archivo
}

?>



