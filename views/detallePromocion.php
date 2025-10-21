<?php
session_start();
include("../src/DB/conexion.php");

$db = new Database();
$conn = $db->conectar();

if (!isset($_GET['id'])) {
    echo "❌ Promoción no encontrada.";
    exit;
}

$auto_id = $_GET['id'];

// 🔹 Obtener datos de la promoción + auto asociado
$sql = "SELECT p.*, a.marca, a.modelo, a.foto 
        FROM promociones p 
        JOIN autos a ON p.auto_id = a.id 
        WHERE p.auto_id = :auto_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':auto_id', $auto_id);
$stmt->execute();
$promo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$promo) {
    echo "❌ No se encontró la promoción.";
    exit;
}

// 🔹 Procesar reserva si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['usuario'])) {
        echo "<script>alert('Debes iniciar sesión para reservar.'); window.location.href='login.php';</script>";
        exit;
    }

    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $dias = (strtotime($fecha_fin) - strtotime($fecha_inicio)) / 86400;
    if ($dias <= 0) {
        echo "<script>alert('Las fechas no son válidas.');</script>";
    } else {
        $check = "SELECT * FROM pedidos 
                  WHERE auto_id = :auto_id 
                  AND estado != 'cancelado'
                  AND (
                      (fecha_inicio <= :fecha_fin AND fecha_fin >= :fecha_inicio)
                  )";
        $stmt_check = $conn->prepare($check);
        $stmt_check->bindParam(':auto_id', $auto_id);
        $stmt_check->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt_check->bindParam(':fecha_fin', $fecha_fin);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            echo "<script>alert('❌ El auto ya está reservado en las fechas seleccionadas.');</script>";
        } else {
            $precio_total = $promo['precio'] * $dias;

            $sql_user = "SELECT id FROM usuarios WHERE nombre = :nombre";
            $stmt_user = $conn->prepare($sql_user);
            $stmt_user->bindParam(':nombre', $_SESSION['usuario']);
            $stmt_user->execute();
            $usuario = $stmt_user->fetch(PDO::FETCH_ASSOC);

            $insert = "INSERT INTO pedidos (usuario_id, auto_id, fecha_inicio, fecha_fin, precio_total, estado, creado_en) 
                       VALUES (:usuario_id, :auto_id, :fecha_inicio, :fecha_fin, :precio_total, 'pendiente', NOW())";
            $stmt_insert = $conn->prepare($insert);
            $stmt_insert->bindParam(':usuario_id', $usuario['id']);
            $stmt_insert->bindParam(':auto_id', $auto_id);
            $stmt_insert->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt_insert->bindParam(':fecha_fin', $fecha_fin);
            $stmt_insert->bindParam(':precio_total', $precio_total);
            $stmt_insert->execute();

            $update_auto = "UPDATE autos SET disponible = 0 WHERE id = :auto_id";
            $stmt_update = $conn->prepare($update_auto);
            $stmt_update->bindParam(':auto_id', $auto_id);
            $stmt_update->execute();

            echo "<script>alert('✅ Reserva realizada con éxito. Total: $$precio_total'); window.location.href='../index.php';</script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Promoción</title>
    <link rel="stylesheet" href="../public/detallePromocion.css">
</head>
<body>

<div class="detalle-container">
    <div class="detalle-imagen">
        <img src="../src/DB/verImagen.php?img=<?= urlencode($promo['foto']); ?>" alt="<?= htmlspecialchars($promo['marca']); ?>">
    </div>

    <div class="detalle-info">
        <h2><?= htmlspecialchars($promo['marca'] . " " . $promo['modelo']); ?></h2>
        <p><?= htmlspecialchars($promo['descripcion']); ?></p>
        <p><strong>Precio por día:</strong> $<?= number_format($promo['precio'], 2); ?></p>

        <?php if (isset($_SESSION['usuario'])): ?>
            <form method="POST" id="formReserva">
                <label>Fecha de inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" required>

                <label>Fecha de fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" required>

                <p id="total" class="total"></p>

                <button type="submit" class="btn-reservar">Reservar</button>
                <a href="../index.php" class="btn-volver">Volver atrás</a>
            </form>

            <script>
                const inicio = document.getElementById('fecha_inicio');
                const fin = document.getElementById('fecha_fin');
                const total = document.getElementById('total');
                const precioDia = <?= $promo['precio']; ?>;

                function calcularTotal() {
                    const f1 = new Date(inicio.value);
                    const f2 = new Date(fin.value);
                    if (f1 && f2 && f2 > f1) {
                        const dias = (f2 - f1) / (1000 * 60 * 60 * 24);
                        const totalPrecio = dias * precioDia;
                        total.textContent = `💰 Total estimado: $${totalPrecio.toFixed(2)} (${dias} días)`;
                    } else {
                        total.textContent = '';
                    }
                }

                inicio.addEventListener('change', calcularTotal);
                fin.addEventListener('change', calcularTotal);
            </script>
        <?php else: ?>
            <p class="login-msg">🔒 Debes <a href="login.php">iniciar sesión</a> para reservar.</p>
            <a href="../index.php" class="btn-volver">Volver atrás</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
