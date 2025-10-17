<?php
include("conexion.php");

$db = new Database();
$conn = $db->conectar();

// Verificar que se recibió el ID del pedido
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  try {
    // Obtener el auto asociado al pedido antes de eliminar
    $sqlAuto = "SELECT auto_id FROM pedidos WHERE id = :id";
    $stmtAuto = $conn->prepare($sqlAuto);
    $stmtAuto->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtAuto->execute();
    $pedido = $stmtAuto->fetch(PDO::FETCH_ASSOC);

    if ($pedido) {
      $auto_id = $pedido['auto_id'];

      // Eliminar el pedido
      $sqlDelete = "DELETE FROM pedidos WHERE id = :id";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
      $stmtDelete->execute();

      // Marcar el auto como disponible nuevamente
      $sqlUpdate = "UPDATE autos SET disponible = 1 WHERE id = :auto_id";
      $stmtUpdate = $conn->prepare($sqlUpdate);
      $stmtUpdate->bindParam(':auto_id', $auto_id, PDO::PARAM_INT);
      $stmtUpdate->execute();

      echo "<script>
        alert('✅ Pedido eliminado correctamente.');
        window.location.href='../../views/admin/pedidos.php';
      </script>";
    } else {
      echo "<script>
        alert('❌ No se encontró el pedido.');
        window.location.href='../../views/admin/pedidos.php';
      </script>";
    }
  } catch (PDOException $e) {
    echo "<script>
      alert('❌ Error al eliminar el pedido: " . $e->getMessage() . "');
      window.location.href='../../views/admin/pedidos.php';
    </script>";
  }
} else {
  echo "<script>
    alert('No se recibió el ID del pedido.');
    window.location.href='../../views/admin/pedidos.php';
  </script>";
}
?>
