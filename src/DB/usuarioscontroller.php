<?php
// Incluir la conexión a la base de datos
include(__DIR__ . "conexion.php");

// Obtener todos los usuarios
$stmt = $conn->query("SELECT id, nombre, apellido, email, ciudad, direccion, creado_en FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>