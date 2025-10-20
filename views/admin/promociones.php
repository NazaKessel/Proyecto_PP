<?php
// Archivo: promociones.php
include("../../src/DB/promociones_model.php");

$model = new PromocionesModel();

// Eliminar promoción si se envía por GET
if (isset($_GET['eliminar_id'])) {
    $idEliminar = intval($_GET['eliminar_id']);
    if ($idEliminar > 0) {
        $model->eliminarPromocion($idEliminar);
        header("Location: promociones.php");
        exit;
    }
}

// Insertar promoción si se envió formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $auto_id = intval($_POST['auto_id']);
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);

    if ($auto_id > 0 && !empty($descripcion) && $precio > 0) {
        $model->insertarPromocion($auto_id, $descripcion, $precio);
    } else {
        echo "<div class='alert alert-danger'>Datos inválidos para la promoción</div>";
    }
}

// Cargar autos y promociones
$autos = $model->getAutos();
$promociones = $model->getPromociones();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Promociones</title>
  <link rel="stylesheet" href="../../adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Botón de colapso del menú lateral -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index.php" class="nav-link">Volver a la Página Principal</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="indexAdmin.php" class="brand-link">
      <i class="fas fa-car-side brand-image"></i>
      <span class="brand-text font-weight-light">Panel Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="formAutos.php" class="nav-link">
              <i class="fas fa-car nav-icon"></i>
              <p>Añadir de Autos</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="promociones.php" class="nav-link">
              <i class="fas fa-percent nav-icon"></i>
              <p>Promociones</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="pedidos.php" class="nav-link">
              <i class="fas fa-shopping-cart nav-icon"></i>
              <p>Pedidos</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="usuarios.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Usuarios</p>
            </a>
          </li> 

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Contenido principal -->
  <div class="content-wrapper p-4">
    <section class="content">
      <div class="container-fluid">

        <!-- Formulario -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">➕ Nueva Promoción</h3>
          </div>
          <form method="POST" action="">
            <div class="card-body">
              <div class="form-group">
                <label>Auto</label>
                <select name="auto_id" class="form-control" required>
                  <option value="">-- Seleccione un auto --</option>
                  <?php foreach ($autos as $auto): ?>
                    <option value="<?= $auto['id'] ?>">
                      <?= $auto['marca'] . " " . $auto['modelo'] . " (" . $auto['patente'] . ")" ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <input type="text" name="descripcion" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Precio Promoción ($)</label>
                <input type="number" step="0.01" name="precio" class="form-control" required>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>

        <!-- Lista de promociones -->
        <div class="card mt-4">
          <div class="card-header">
            <h3 class="card-title">📋 Promociones Registradas</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Auto</th>
                  <th>Descripción</th>
                  <th>Precio</th>
                  <th>Creado</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($promociones)): ?>
                  <tr>
                    <td colspan="6" class="text-center">No hay promociones cargadas</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($promociones as $promo): ?>
                    <tr>
                      <td><?= $promo['id'] ?></td>
                      <td><?= $promo['marca'] . " " . $promo['modelo'] . " (" . $promo['patente'] . ")" ?></td>
                      <td><?= $promo['descripcion'] ?></td>
                      <td>$<?= number_format($promo['precio'], 2) ?></td>
                      <td><?= $promo['creado_en'] ?></td>
                      <td>
                        <a href="promociones.php?eliminar_id=<?= $promo['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Está seguro de eliminar esta promoción?');">
                           Eliminar
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>
  </div>

</div>

<script src="../../adminlte/plugins/jquery/jquery.min.js"></script>
<script src="../../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
