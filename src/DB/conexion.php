<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "thames";

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>