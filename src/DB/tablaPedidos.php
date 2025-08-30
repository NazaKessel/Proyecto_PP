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

// Consulta a la tabla
$sql = "SELECT * FROM pedidos";
$result = $conn->query($sql);

// Guardar resultados en un array
$datos = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }
}

$conn->close();
?>