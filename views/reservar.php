<?php
session_start();
include("../src/DB/conexion.php");
$db = new Database();
$conn = $db->conectar();

if (!isset($_SESSION["usuario"])) {
  echo "<script>alert('Debes iniciar sesión para reservar.'); window.location.href='login.php';</script>";
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $usuario = $_SESSION["usuario"];
  $auto_id = $_POST["auto_id"];
  $fecha_inicio = $_POST["fecha_inicio"];
  $fecha_fin = $_POST["fecha_fin"];
  $precio_total = $_POST["precio_total"];

  // Obtener ID de usuario
  $sqlUser = "SELECT id FROM usuarios WHERE nombre = :nombre";
  $stmtUser = $conn->prepare($sqlUser);
  $stmtUser->bindParam(':nombre', $usuario);
  $stmtUser->execute();
  $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    echo "<script>alert('Error al identificar usuario.'); window.location.href='autos.php';</script>";
    exit;
  }

  $usuario_id = $user['id'];

  // 🔹 Insertar pedido (en lugar de reserva)
  $sqlPedido = "INSERT INTO pedidos (usuario_id, auto_id, fecha_inicio, fecha_fin, precio_total, estado, creado_en)
                VALUES (:usuario_id, :auto_id, :fecha_inicio, :fecha_fin, :precio_total, 'Pendiente', NOW())";
  $stmt = $conn->prepare($sqlPedido);
  $stmt->bindParam(':usuario_id', $usuario_id);
  $stmt->bindParam(':auto_id', $auto_id);
  $stmt->bindParam(':fecha_inicio', $fecha_inicio);
  $stmt->bindParam(':fecha_fin', $fecha_fin);
  $stmt->bindParam(':precio_total', $precio_total);
  $stmt->execute();

  // 🔹 Marcar auto como no disponible
  $sqlUpdate = "UPDATE autos SET disponible = 0 WHERE id = :id";
  $stmtUpdate = $conn->prepare($sqlUpdate);
  $stmtUpdate->bindParam(':id', $auto_id);
  $stmtUpdate->execute();

  echo "<script>
    alert('✅ Pedido realizado con éxito.');
    window.location.href='index.php';
  </script>";
}
?>
