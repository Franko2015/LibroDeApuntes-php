<?php

if (!function_exists('conn')) {  // Verifica si la función ya está declarada
    function conn() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Activar excepciones en errores
        $servername = "localhost";
        $username = "root";
        $password = "leica666";
        $dbname = "libro_de_apuntes";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        return $conn;

        $conn->close();
    }

}

?>
