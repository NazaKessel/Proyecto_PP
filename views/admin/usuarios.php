<?php
require_once "../../src/DB/conexion.php";

$db = new Database();
$conexion = $db->conectar();

// Consulta de usuarios
$query = $conexion->prepare("SELECT id, nombre, apellido, email, ciudad, direccion, creado_en FROM usuarios");
$query->execute();
$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Usuarios - Panel Admin</title>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../adminlte/dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../index.php" class="nav-link">Volver a la Página Principal</a>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="indexAdmin.php" class="brand-link">
      <i class="fas fa-car-side brand-image"></i>
      <span class="brand-text font-weight-light">Panel Admin</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="formAutos.php" class="nav-link">
              <i class="fas fa-car nav-icon"></i>
              <p>Añadir Autos</p>
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
            <a href="usuarios.php" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>Usuarios</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper p-3">
    <section class="content">
      <div class="container-fluid">
        <h3 class="mb-3">Lista de Usuarios</h3>
        <div class="card">
          <div class="card-body">
            <table id="tablaUsuarios" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Email</th>
                  <th>Ciudad</th>
                  <th>Dirección</th>
                  <th>Creado en</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($usuarios as $fila) { ?>
                <tr>
                  <td><?= htmlspecialchars($fila['id']) ?></td>
                  <td><?= htmlspecialchars($fila['nombre']) ?></td>
                  <td><?= htmlspecialchars($fila['apellido']) ?></td>
                  <td><?= htmlspecialchars($fila['email']) ?></td>
                  <td><?= htmlspecialchars($fila['ciudad']) ?></td>
                  <td><?= htmlspecialchars($fila['direccion']) ?></td>
                  <td><?= htmlspecialchars($fila['creado_en']) ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>© 2025 Sistema de Alquiler de Autos.</strong> Todos los derechos reservados.
  </footer>

</div>

<!-- Scripts -->
<script src="../../adminlte/plugins/jquery/jquery.min.js"></script>
<script src="../../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../adminlte/dist/js/adminlte.min.js"></script>

<!-- DataTables -->
<script src="../../adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../adminlte/plugins/jszip/jszip.min.js"></script>
<script src="../../adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
  $(function () {
    $("#tablaUsuarios").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#tablaUsuarios_wrapper .col-md-6:eq(0)');
  });
</script>

</body>
</html>
