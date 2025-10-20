<?php
session_start();
include("../src/DB/conexion.php");
$db = new Database();
$conn = $db->conectar();

// Obtener marcas disponibles
$sqlMarcas = "SELECT DISTINCT marca FROM autos WHERE disponible = 1 ORDER BY marca ASC";
$stmtMarcas = $conn->prepare($sqlMarcas);
$stmtMarcas->execute();
$marcas = $stmtMarcas->fetchAll(PDO::FETCH_COLUMN);

$filtroMarca = isset($_GET['marca']) ? $_GET['marca'] : '';

if ($filtroMarca != '') {
  $sql = "SELECT * FROM autos WHERE marca = :marca AND disponible = 1";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':marca', $filtroMarca);
} else {
  $sql = "SELECT * FROM autos WHERE disponible = 1";
  $stmt = $conn->prepare($sql);
}
$stmt->execute();
$autos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Autos Disponibles</title>
  <link rel="stylesheet" href="../adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../adminlte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../public/productos.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <div class="content-wrapper">
    <section class="content mt-4">
      <div class="container">
        <div class="text-center mb-4">
          <h2 class="text-danger">Autos Disponibles</h2>
        </div>

        <!-- Filtro -->
        <form method="GET" class="mb-5 text-center">
          <div class="d-flex justify-content-center">
            <a href="../index.php" class="btn btn-secondary">Volver atrás</a>
            <select name="marca" class="form-control w-auto mx-2">
              <option value="">Todas las marcas</option>
              <?php foreach ($marcas as $marca): ?>
                <option value="<?= htmlspecialchars($marca) ?>" <?= $filtroMarca == $marca ? 'selected' : '' ?>>
                  <?= htmlspecialchars($marca) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button class="btn btn-danger mx-2" type="submit">Buscar</button>
            <a href="Productos.php" class="btn btn-secondary">Mostrar todos</a>
          </div>
        </form>

        <!-- Autos -->
        <div class="row">
          <?php if ($autos): ?>
            <?php foreach ($autos as $auto): ?>
              <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                  <img src="../src/DB/verImagen.php?img=<?= urlencode($auto['foto']) ?>" class="card-img-top" alt="">
                  <div class="card-body text-center">
                    <h5 class="card-title text-danger">
                      <?= htmlspecialchars($auto['marca'] . ' ' . $auto['modelo']) ?>
                    </h5>
                    <p class="card-text">$<?= number_format($auto['precio'], 2) ?> x día</p>
                    <a href="detalleProductos.php?id=<?= $auto['id'] ?>" class="btn btn-outline-danger">Ver más</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12 text-center"><p>No hay autos disponibles.</p></div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </div>
</div>

<script src="../adminlte/plugins/jquery/jquery.min.js"></script>
<script src="../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
