<?php
// incluir la conexión
include("conexion.php");

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $marca   = $_POST['marca'];
    $modelo  = $_POST['modelo'];
    $anio    = intval($_POST['anio']);
    $color   = $_POST['color'];
    $patente = $_POST['patente'];
    $precio  = floatval($_POST['precio']); // convertir a número

    // Manejo de la imagen
    $foto = $_FILES['foto']['name'];
    $ruta_temporal = $_FILES['foto']['tmp_name'];
    $carpeta_destino = "uploads/"; // Carpeta donde se guardarán las imágenes
    if (!is_dir($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }
    $ruta_final = $carpeta_destino . basename($foto);

    if (move_uploaded_file($ruta_temporal, $ruta_final)) {
        // Insertar en la base de datos
        $sql = "INSERT INTO autos (marca, modelo, anio, color, patente, disponible, precio, foto) 
                VALUES (?, ?, ?, ?, ?, 1, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("❌ Error en prepare: " . $conn->error);
        }

        $stmt->bind_param("ssissds", $marca, $modelo, $anio, $color, $patente, $precio, $ruta_final);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>🚗 Auto registrado con éxito</p>";
        } else {
            echo "<p style='color:red;'>❌ Error al registrar: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color:red;'>❌ Error al subir la imagen.</p>";
    }
}

$conn->close();
?>
