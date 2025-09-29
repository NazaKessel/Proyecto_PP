<?php
include("conexion.php");   // incluye la clase Database

$db = new Database();
$conn = $db->conectar();

// Consulta con JOIN para traer pedidos + autos + usuarios
$sql = "SELECT p.id, 
        u.nombre, u.apellido, u.email, 
        a.marca, a.modelo, a.patente, 
        p.fecha_inicio, p.fecha_fin, 
        p.precio_total, p.estado, 
        p.creado_en
        FROM pedidos p
        INNER JOIN usuarios u ON p.usuario_id = u.id
        INNER JOIN autos a ON p.auto_id = a.id
        ORDER BY p.creado_en DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
