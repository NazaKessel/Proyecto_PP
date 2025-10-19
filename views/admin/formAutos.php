<?php
include("../../src/DB/conexion.php");
$db = new Database();
$conn = $db->conectar();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Auto</title>

  <!-- AdminLTE -->
  <link rel="stylesheet" href="../../adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../adminlte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../public/tamañoImg.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Botón de colapso del menú lateral -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../index.php" class="nav-link">Volver a la Página Principal</a>
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

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Registrar Auto</h1>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Datos del Vehículo</h3>
          </div>
          <form action="../../src/DB/formAutosBD.php" method="post" enctype="multipart/form-data">
            <div class="card-body">
              <!-- === Formulario de Registro === -->
              <div class="form-group">
                <label for="marca">Marca</label>
                <input list="marcas" id="marca" name="marca" class="form-control" required>
                <datalist id="marcas">
                  <option value="Fiat">
                  <option value="Renault">
                  <option value="Peugeot">
                  <option value="Citroën">
                  <option value="Chevrolet">
                  <option value="Ford">
                  <option value="Volkswagen">
                  <option value="Toyota">
                  <option value="Honda">
                  <option value="Nissan">
                  <option value="Kia">
                  <option value="Hyundai">
                  <option value="Mitsubishi">
                  <option value="Suzuki">
                  <option value="Chery">
                  <option value="BMW">
                  <option value="Mercedes-Benz">
                  <option value="Audi">
                  <option value="Jeep">
                  <option value="Dodge">
                </datalist>
              </div>

              <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" id="modelo" name="modelo" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="anio">Año</label>
                <select id="anio" name="anio" class="form-control" required></select>
              </div>

              <div class="form-group">
                <label for="color">Color</label>
                <input list="colores" id="color" name="color" class="form-control" required>
                <datalist id="colores">
                  <option value="Negro">
                  <option value="Blanco">
                  <option value="Gris">
                  <option value="Plata">
                  <option value="Rojo">
                  <option value="Azul">
                  <option value="Verde">
                  <option value="Amarillo">
                  <option value="Naranja">
                  <option value="Marrón">
                </datalist>
              </div>

              <div class="form-group">
                <label for="patente">Patente</label>
                <input type="text" id="patente" name="patente" class="form-control" placeholder="Ej: ABC 123 o AB 123 CD" required>
              </div>

              <div class="form-group">
                <label for="precio">Precio (alquiler diario)</label>
                <input type="text" id="precio" name="precio" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="foto">Imagen</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*" required>
              </div>
            </div>

            <div class="card-footer">
              <a href="indexAdmin.html" class="btn btn-secondary">Volver</a>
              <button type="submit" class="btn btn-primary">Registrar Auto</button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <!-- 🔹 Listado de Autos Registrados -->
    <section class="content mt-4">
      <div class="container-fluid">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Autos Registrados</h3>
          </div>
          <div class="card-body">
            <div class="row">

              <?php
              $sql = "SELECT id, marca, modelo, anio, color, patente, precio, foto FROM autos";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $autos = $stmt->fetchAll(PDO::FETCH_ASSOC);

              if ($autos) {
                foreach ($autos as $row) { ?>
                  <div class="col-md-3">
                    <div class="card">
                      <!-- ✅ Ruta corregida para mostrar imágenes -->
                      <img class="tamaño" src="../../src/DB/verImagen.php?img=<?php echo urlencode($row['foto']); ?>" 
                      class="card-img-top" alt="Imagen del auto">

                      <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['marca'] . " " . $row['modelo']); ?></h5>
                        <p class="card-text">
                          Año: <?php echo htmlspecialchars($row['anio']); ?><br>
                          Color: <?php echo htmlspecialchars($row['color']); ?><br>
                          Patente: <?php echo htmlspecialchars($row['patente']); ?><br>
                          Precio: $<?php echo number_format($row['precio'], 0, ',', '.'); ?>
                        </p>
                        <form method="POST" action="../../src/DB/eliminarAuto.php" class="form-eliminar-auto">
                          <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                          <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Eliminar
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                <?php }
              } else {
                echo "<p class='text-muted'>No hay autos registrados.</p>";
              }
              ?>

            </div>
          </div>
        </div>
      </div>
    </section>

  </div> <!-- /.content-wrapper -->

</div> <!-- /.wrapper -->

<!-- Scripts -->
<script src="../../adminlte/plugins/jquery/jquery.min.js"></script>
<script src="../../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../adminlte/dist/js/adminlte.min.js"></script>

<script>
  // Generar automáticamente los años desde 1950 hasta el actual
  const selectAnio = document.getElementById("anio");
  const anioActual = new Date().getFullYear();
  for (let i = anioActual; i >= 1950; i--) {
    let option = document.createElement("option");
    option.value = i;
    option.textContent = i;
    selectAnio.appendChild(option);
  }

  // Doble confirmación para eliminar
  $(document).on("submit", ".form-eliminar-auto", function (e) {
    e.preventDefault();
    if (confirm("¿Seguro que deseas eliminar este auto?")) {
      if (confirm("⚠️ Esta acción es irreversible. ¿Confirmas la eliminación?")) {
        this.submit();
      }
    }
  });
</script>

</body>
</html>
