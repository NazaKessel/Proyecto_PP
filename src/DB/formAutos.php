<?php
// incluir la conexión
include("conexion.php");
$db = new Database();
$conn = $db->conectar();

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
    $carpeta_destino = "uploads/"; 
    if (!is_dir($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }
    $ruta_final = $carpeta_destino . basename($foto);

    if (move_uploaded_file($ruta_temporal, $ruta_final)) {
        try {
            // Insertar en la base de datos con PDO
            $sql = "INSERT INTO autos (marca, modelo, anio, color, patente, disponible, precio, foto) 
                    VALUES (:marca, :modelo, :anio, :color, :patente, 1, :precio, :foto)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":marca", $marca);
            $stmt->bindParam(":modelo", $modelo);
            $stmt->bindParam(":anio", $anio, PDO::PARAM_INT);
            $stmt->bindParam(":color", $color);
            $stmt->bindParam(":patente", $patente);
            $stmt->bindParam(":precio", $precio);
            $stmt->bindParam(":foto", $ruta_final);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>🚗 Auto registrado con éxito</p>";
            } else {
                echo "<p style='color:red;'>❌ Error al registrar</p>";
            }

        } catch (PDOException $e) {
            echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ Error al subir la imagen.</p>";
    }
}
?>
