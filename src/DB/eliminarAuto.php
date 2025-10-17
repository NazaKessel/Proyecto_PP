<?php
include("conexion.php");
$db = new Database();
$conn = $db->conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {

    $id = $_POST['id'];

    // 🔹 Primero obtener la ruta de la imagen para borrarla del servidor
    $sql = "SELECT foto FROM autos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $auto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($auto) {
        $rutaImagen = "../../" . $auto['foto']; // Ajuste para llegar correctamente desde src/DB/

        // 🔹 Eliminar el registro de la base de datos
        $sqlDelete = "DELETE FROM autos WHERE id = :id";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmtDelete->execute()) {
            // 🔹 Si existe la imagen, eliminarla físicamente
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }

            echo "<script>
                    alert('✅ Auto eliminado correctamente');
                    window.location.href='../../views/admin/formAutos.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Error al eliminar el auto');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('⚠️ Auto no encontrado');
                window.history.back();
              </script>";
    }

} else {
    echo "<script>
            alert('Acceso no permitido');
            window.history.back();
          </script>";
}
?>
