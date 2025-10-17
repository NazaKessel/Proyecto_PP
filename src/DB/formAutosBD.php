<?php
include("conexion.php");
$db = new Database();
$conn = $db->conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // === Captura de datos del formulario ===
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $anio = $_POST['anio'] ?? '';
    $color = $_POST['color'] ?? '';
    $patente = $_POST['patente'] ?? '';
    $precio = $_POST['precio'] ?? '';

    // === Manejo de imagen ===
    $directorioDestino = "../../src/DB/uploads/";
    if (!file_exists($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);
    }

    $nombreArchivo = basename($_FILES["foto"]["name"]);
    $rutaArchivo = $directorioDestino . $nombreArchivo;
    $rutaBD = "src/DB/uploads/" . $nombreArchivo;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaArchivo)) {
        // === Inserción en base de datos ===
        $sql = "INSERT INTO autos (marca, modelo, anio, color, patente, precio, foto) 
                VALUES (:marca, :modelo, :anio, :color, :patente, :precio, :foto)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':patente', $patente);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':foto', $rutaBD);

        if ($stmt->execute()) {
            echo "<script>
                    alert('✅ Auto registrado correctamente');
                    window.location.href='../../views/admin/formAutos.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Error al guardar en la base de datos');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('❌ Error al subir la imagen');
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
