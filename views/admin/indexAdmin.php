<?php
include("../../src/DB/conexion.php");
$db = new Database();
$conexion = $db->conectar();

// Cantidad de pedidos pendientes
$sqlPedidos = $conexion->query("SELECT COUNT(*) AS total FROM pedidos WHERE estado = 'pendiente'");
$pedidos = $sqlPedidos->fetch(PDO::FETCH_ASSOC)['total'];

// Cantidad de autos cargados
$sqlAutos = $conexion->query("SELECT COUNT(*) AS total FROM autos");
$autos = $sqlAutos->fetch(PDO::FETCH_ASSOC)['total'];

// Cantidad de promociones cargadas
$sqlPromos = $conexion->query("SELECT COUNT(*) AS total FROM promociones");
$promos = $sqlPromos->fetch(PDO::FETCH_ASSOC)['total'];

// Cantidad de usuarios registrados
$sqlUsuarios = $conexion->query("SELECT COUNT(*) AS total FROM usuarios");
$usuarios = $sqlUsuarios->fetch(PDO::FETCH_ASSOC)['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Administración</title>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../adminlte/dist/css/adminlte.min.css">
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
        <a href="../../index.php" class="nav-link">Volver a la Página Principal</a>
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
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <a href="formAutos.php" class="nav-link">
              <i class="fas fa-car nav-icon"></i><p>Añadir Autos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="promociones.php" class="nav-link">
              <i class="fas fa-percent nav-icon"></i><p>Promociones</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pedidos.php" class="nav-link">
              <i class="fas fa-shopping-cart nav-icon"></i><p>Pedidos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="usuarios.php" class="nav-link">
              <i class="fas fa-users nav-icon"></i><p>Usuarios</p>
            </a>
          </li> 
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Contenido principal -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1>Panel de Administración</h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <!-- Pedidos pendientes -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $pedidos; ?></h3>
                <p>Pedidos Pendientes</p>
              </div>
              <div class="icon">
                <i class="fas fa-clock"></i>
              </div>
              <a href="pedidos.php" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- Autos cargados -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $autos; ?></h3>
                <p>Autos Cargados</p>
              </div>
              <div class="icon">
                <i class="fas fa-car"></i>
              </div>
              <a href="formAutos.php" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- Promociones -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $promos; ?></h3>
                <p>Promociones</p>
              </div>
              <div class="icon">
                <i class="fas fa-percent"></i>
              </div>
              <a href="promociones.php" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- Usuarios -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $usuarios; ?></h3>
                <p>Usuarios Registrados</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="usuarios.php" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>

  <footer class="main-footer text-center">
    <strong>© 2025 Sistema de Alquiler de Autos.</strong> Todos los derechos reservados.
  </footer>

</div>

<script src="../../adminlte/plugins/jquery/jquery.min.js"></script>
<script src="../../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
