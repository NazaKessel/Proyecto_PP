<?php
// incluir la conexión
include("../src/DB/conexion.php");

$sql = "SELECT usuario_id, auto_id, precio_total FROM pedidos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion Thames Car</title>
    <link rel="stylesheet" href="../public/indexAdmin.css">
</head>

<body>
    <div class="titulo">
        <button type="button" class="btn-volver">←</button>
        <h1>Thames Car</h1>
    </div>

    <table border="1" class="tabla">
        <tr>
            <th>ID Usuario</th>
            <th>ID Auto</th>
            <th>Precio</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['usuario_id'] ?></td>
                <td><?= $row['auto_id'] ?></td>
                <td><?= $row['precio_total'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
<?php $conn->close(); ?>