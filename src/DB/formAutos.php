<?php
include("../src/DB/conexion.php");
$db = new Database();
$conn = $db->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Buscar foto para borrarla
    $sqlFoto = "SELECT foto FROM autos WHERE id = :id";
    $stmtFoto = $conn->prepare($sqlFoto);
    $stmtFoto->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtFoto->execute();
    $row = $stmtFoto->fetch(PDO::FETCH_ASSOC);

    if ($row && file_exists("../" . $row['foto'])) {
        unlink("../" . $row['foto']); // elimina imagen
    }

    // Borrar registro
    $sql = "DELETE FROM autos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: autos.php?msg=eliminado");
    } else {
        echo "❌ Error al eliminar auto.";
    }
}
?>
