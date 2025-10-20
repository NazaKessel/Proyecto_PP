<?php include("../../src/DB/pedidos_bd.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pedidos</title>
  <link rel="stylesheet" href="../../adminlte/plugins/fontawesome-free/css/all.min.css">
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
        <ul class="nav nav-pills nav-sidebar flex-column" data-accordion="false">
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
            <a href="pedidos.php" class="nav-link active">
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
    </div>
  </aside>

  <!-- Contenido principal -->
  <div class="content-wrapper p-4">
    <section class="content">
      <div class="container-fluid">
        <h2 class="mb-4">📋 Lista de Pedidos</h2>

        <div class="card">
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Cliente</th>
                  <th>Email</th>
                  <th>Auto</th>
                  <th>Patente</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Fin</th>
                  <th>Precio Total</th>
                  <th>Estado</th>
                  <th>Creado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($pedidos)): ?>
                  <tr>
                    <td colspan="11" class="text-center">No hay pedidos cargados</td>
                  </tr>
                <?php else: ?>
                  <?php $hoy = date('Y-m-d'); ?>
                  <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                      <td><?= $pedido['id'] ?></td>
                      <td><?= $pedido['nombre'] . " " . $pedido['apellido'] ?></td>
                      <td><?= $pedido['email'] ?></td>
                      <td><?= $pedido['marca'] . " " . $pedido['modelo'] ?></td>
                      <td><?= $pedido['patente'] ?></td>
                      <td><?= $pedido['fecha_inicio'] ?></td>
                      <td><?= $pedido['fecha_fin'] ?></td>
                      <td>$<?= number_format($pedido['precio_total'], 2) ?></td>
                      <td>
                        <?php
                          if ($pedido['fecha_fin'] <= $hoy) {
                            echo '<span class="badge badge-success">Finalizado</span>';
                          } else {
                            echo '<span class="badge badge-warning">En Proceso</span>';
                          }
                        ?>
                      </td>
                      <td><?= $pedido['creado_en'] ?></td>
                      <td class="text-center">
                        <a href="../../src/DB/eliminarPedido.php?id=<?= $pedido['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Seguro que deseas eliminar este pedido? Esto volverá a poner el auto como disponible.');">
                           <i class="fas fa-trash-alt"></i> Eliminar
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

