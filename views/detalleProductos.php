<?php
session_start();
include("../src/DB/conexion.php");
$db = new Database();
$conn = $db->conectar();

if (!isset($_GET['id'])) {
  header("Location: autos.php");
  exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM autos WHERE id = :id AND disponible = 1";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$auto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$auto) {
  echo "<script>alert('El auto no está disponible.'); window.location.href='autos.php';</script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($auto['marca'] . ' ' . $auto['modelo']) ?></title>
  <link rel="stylesheet" href="../adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <div class="content-wrapper">
    <section class="content mt-4">
      <div class="container">
        <div class="card mx-auto shadow" style="max-width: 600px;">
          <img src="../src/DB/verImagen.php?img=<?= urlencode($auto['foto']) ?>" class="card-img-top" alt="">
          <div class="card-body">
            <h3 class="text-danger"><?= htmlspecialchars($auto['marca'] . ' ' . $auto['modelo']) ?></h3>
            <p><strong>Año:</strong> <?= $auto['anio'] ?></p>
            <p><strong>Color:</strong> <?= htmlspecialchars($auto['color']) ?></p>
            <p><strong>Patente:</strong> <?= htmlspecialchars($auto['patente']) ?></p>
            <p><strong>Precio por día:</strong> $<?= number_format($auto['precio'], 2) ?></p>

            <?php if (isset($_SESSION["usuario"])): ?>
              <hr>
              <h5 class="text-danger">Reservar este auto</h5>
              <form action="reservar.php" method="POST" onsubmit="return calcularPrecio()">
                <input type="hidden" name="auto_id" value="<?= $auto['id'] ?>">
                <div class="mb-3">
                  <label>Fecha de retiro:</label>
                  <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Fecha de devolución:</label>
                  <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Total estimado:</label>
                  <input type="text" id="precio_total" name="precio_total" class="form-control" readonly>
                </div>
                <button type="submit" class="btn btn-danger btn-block">Confirmar Reserva</button>
              </form>
            <?php else: ?>
              <div class="alert alert-warning mt-3">
                Debes <a href="login.php">iniciar sesión</a> para reservar este auto.
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<script>
function calcularPrecio() {
  const inicio = new Date(document.getElementById('fecha_inicio').value);
  const fin = new Date(document.getElementById('fecha_fin').value);
  const precioDia = <?= $auto['precio']; ?>;

  if (fin <= inicio) {
    alert("La fecha de devolución debe ser posterior a la de retiro.");
    return false;
  }

  const diffTime = Math.abs(fin - inicio);
  const dias = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
  const total = dias * precioDia;

  document.getElementById('precio_total').value = total.toFixed(2);
  return true;
}
</script>

<script src="../adminlte/plugins/jquery/jquery.min.js"></script>
<script src="../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
