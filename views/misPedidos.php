<?php
session_start();
include("../src/DB/conexion.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$conn = $db->conectar();

// Obtener el nombre del usuario logueado
$nombreUsuario = $_SESSION["usuario"];

// Obtener el ID del usuario
$sqlUsuario = "SELECT id FROM usuarios WHERE nombre = :nombre";
$stmtUsuario = $conn->prepare($sqlUsuario);
$stmtUsuario->bindParam(":nombre", $nombreUsuario);
$stmtUsuario->execute();
$usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "<p>Error: usuario no encontrado.</p>";
    exit;
}

$usuario_id = $usuario["id"];

// Consulta para obtener los pedidos del usuario con información de autos
$sql = "SELECT 
            p.id AS pedido_id,
            a.marca,
            a.modelo,
            a.color,
            a.precio,
            p.fecha_inicio,
            p.fecha_fin,
            p.precio_total,
            p.estado
        FROM pedidos p
        INNER JOIN autos a ON p.auto_id = a.id
        WHERE p.usuario_id = :usuario_id
        ORDER BY p.creado_en DESC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":usuario_id", $usuario_id);
$stmt->execute();
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis pedidos</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .pedido-card {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
            transition: 0.3s;
        }
        .pedido-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .estado {
            font-weight: bold;
            text-transform: capitalize;
        }
        .estado.pendiente {
            color: #ffc107;
        }
        .estado.completado {
            color: #28a745;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="../index.php">🚗 Thames Autos</a>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">Hola, <?php echo htmlspecialchars($nombreUsuario); ?></span>
            <a href="../logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4 text-center">Mis pedidos</h2>

    <?php if (count($pedidos) > 0): ?>
        <div class="row">
            <?php foreach ($pedidos as $pedido): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="pedido-card">
                        <h5><?php echo htmlspecialchars($pedido['marca'] . ' ' . $pedido['modelo']); ?></h5>
                        <p><strong>Color:</strong> <?php echo htmlspecialchars($pedido['color']); ?></p>
                        <p><strong>Precio por día:</strong> $<?php echo number_format($pedido['precio'], 2); ?></p>
                        <p><strong>Fecha inicio:</strong> <?php echo htmlspecialchars($pedido['fecha_inicio']); ?></p>
                        <p><strong>Fecha fin:</strong> <?php echo htmlspecialchars($pedido['fecha_fin']); ?></p>
                        <p><strong>Total:</strong> $<?php echo number_format($pedido['precio_total'], 2); ?></p>
                        <p class="estado <?php echo strtolower($pedido['estado']); ?>">
                            Estado: <?php echo htmlspecialchars($pedido['estado']); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            No tenés pedidos realizados todavía.
        </div>
    <?php endif; ?>
</div>

<footer class="text-center mt-5 mb-3 text-muted">
    &copy; <?php echo date("Y"); ?> Thames Autos - Todos los derechos reservados
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
