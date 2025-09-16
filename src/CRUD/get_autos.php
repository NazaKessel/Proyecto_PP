<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "thames";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "❌ Conexión fallida: " . $conn->connect_error]));
}

$sql = "SELECT * FROM autos";
$result = $conn->query($sql);

$autos = [];
while ($row = $result->fetch_assoc()) {
    $autos[] = $row;
}

$conn->close();

// Devolver en formato JSON
header('Content-Type: application/json');
echo json_encode($autos);
?>
