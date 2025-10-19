<?php

require '../src/DB/conexion.php';
$db = new Database();
$con = $db ->conectar();

$sql = $con->prepare("SELECT id, marca, precio, modelo, foto 
                      FROM autos 
                      WHERE disponible = 1 
                      ORDER BY RAND() 
                      LIMIT 8");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
$sql = $con->prepare("SELECT id, auto_id, descripcion, precio FROM promociones"); 

session_start();
// Promociones
$sqlPromo = $con->prepare("
    SELECT p.id AS promo_id, p.precio AS promo_precio, p.descripcion AS promo_desc,
    a.id AS auto_id, a.marca, a.modelo, a.foto
    FROM promociones p
    INNER JOIN autos a ON p.auto_id = a.id
    ORDER BY p.id DESC
");
$sqlPromo->execute();
$promociones = $sqlPromo->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thames Cars</title>
  <link rel="stylesheet" href="../public/principal.css">
  <link rel="stylesheet" href="../public/login.css">
  <link rel="stylesheet" href="../public/tamañoImg.css">
</head>
<body>

  <!-- Banner principal -->
  <section class="banner">
    <header>
      <div class="logo">Thames Cars</div>
      <nav>
        <a href="productos.php">Productos</a>
        <a href="#servicios">Servicios</a>
        <a href="#contactanos">Contactanos</a>
      </nav>

      <?php if (isset($_SESSION["usuario"])): ?>
        <!-- Menú del usuario logueado -->
        <nav class="login">
          <button class="user-btn" id="userMenuBtn">
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Usuario">
            <span><?= htmlspecialchars($_SESSION["usuario"]) ?></span>
            <span class="arrow">▼</span>
          </button>

          <div class="dropdown" id="userDropdown">
            <p>Hola, <?= htmlspecialchars($_SESSION["usuario"]) ?></p>
            <form action="logout.php" method="post">
              <button type="submit" class="logout-btn">Cerrar sesión</button>
            </form>
          
            <?php if (isset($_SESSION["usuario"]) && $_SESSION["usuario"] === "admin"): ?>
      <!-- Solo el admin ve este botón -->
      <button type="button" class="admin-btn" onclick="location.href='./admin/indexAdmin.php'">Panel de Administracion</button>
  <?php endif; ?>
         
             
            ?>
          </div>
        </nav>
      <?php else: ?>
        <!-- Botones si no está logueado -->
        <div class="auth-buttons">
          <button onclick="location.href='registrarse.html'" class="btn">Registrarse</button>
          <button onclick="location.href='login.php'" class="btn">Iniciar Sesión</button>
        </div>
      <?php endif; ?>
    </header>

    <div class="banner-content">
      <h1>¡Movilidad a tu alcance!</h1>
      <p>Tu próximo viaje empieza aquí: vehículos confiables y listos para vos.</p>
    </div>
  </section>

  <script>
    const userMenuBtn = document.getElementById('userMenuBtn');
    const dropdown = document.getElementById('userDropdown');
    const arrow = document.querySelector('.arrow');

    if (userMenuBtn) {
      userMenuBtn.addEventListener('click', () => {
        dropdown.classList.toggle('show');
        arrow.classList.toggle('open');
      });

      window.addEventListener('click', (e) => {
        if (!userMenuBtn.contains(e.target) && !dropdown.contains(e.target)) {
          dropdown.classList.remove('show');
          arrow.classList.remove('open');
        }
      });
    }
  </script>

  <main class="container">

    <!-- Sección marcas -->
    <h2 class="section-title"> Nuestras marcas </h2>
    <div class="circles">
      <div class="circle-item">
        <div class="circle">
            <img src="../public/img/marcas/toyota.png" alt="">
        </div>
        <p>Toyota</p>
      </div>
      <div class="circle-item">
        <div class="circle">
            <img src="../public/img/marcas/renault.png" alt="">
        </div>
        <p>Renault</p>
      </div>
      <div class="circle-item">
        <div class="circle">
            <img src="../public/img/marcas/volkswagen.png" alt="">
        </div>
        <p>Volkswagen</p>
      </div>
      <div class="circle-item">
        <div class="circle">
            <img src="../public/img/marcas/ford.png" alt="">
        </div>
        <p>Ford</p>
      </div>
    </div>

    <!-- Segundo banner -->
    <section class="banner-2" id="servicios">
      <div class="banner-2-content">
        <h2>Conduce sin preocupaciones</h2>
        <p>Ofrecemos el mejor servicio de alquiler con beneficios únicos para vos, descubre mas:</p>
        <button class="btn">Promos</button>
      </div>
      <img src="../public/img/208Promo.png" alt="Servicio">
    </section>

    <!-- PROMOS -->
    <section class="carrusel promo"> 
    <button class="btn-promo prev">&#10094;</button>

    <div class="promo-contenedor">
    <?php foreach($promociones as $promo): ?>
        <div class="promo-card">
            <div class="promo-img">
                <?php 
                $imagen = "../src/DB/verImagen.php?img=" . urlencode($promo['foto']);
                ?>
                <img src="<?php echo $imagen; ?>" alt="Imagen de <?php echo htmlspecialchars($promo['marca']); ?>">
            </div>
            <div class="promo-content">
              <p class="promo-text"><?php echo htmlspecialchars($promo['promo_desc']); ?></p>
                <p class="promo-description"><?php echo htmlspecialchars($promo['marca'] . " " . $promo['modelo']); ?></p>
                <p class="promo-price">$ <?php echo number_format($promo['promo_precio'], 2); ?></p>
                <button onclick="location.href='detallePromocion.php?id=<?= $promo['auto_id'] ?>'">Ver más</button>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

    <button class="btn-promo next">&#10095;</button>
</section>

    <!-- Productos -->
    <section class="carrusel"> 
    <button class="carrusel-btn prev">&#10094;</button>

    <div class="carrusel-contenedor">
    <?php foreach($resultado as $row): ?>
        <div class="card">
            <?php 
            $imagen = "../src/DB/verImagen.php?img=" . urlencode($row['foto']);
            ?>
            <img class="img-auto" src="<?php echo $imagen; ?>" alt="Imagen de <?php echo htmlspecialchars($row['marca']); ?>">
            <p class="card-description"><?php echo htmlspecialchars($row['marca'] . " " . $row['modelo']); ?></p>
            <p class="card-price">$ <?php echo number_format($row['precio'], 2); ?></p>
            
            <!-- Botón adaptado -->
            <button onclick="location.href='detalleProductos.php?id=<?= $row['id'] ?>'">Ver más</button>
        </div>
    <?php endforeach; ?>
</div>

    <button class="carrusel-btn next">&#10095;</button>
</section>


    <!-- Preferencias -->
    <section class="preferencias">
      <h2 class="section-title">¿Qué prefieres?</h2>
      <div class="preferencias-grid">
        <div class="pref-card">
          <img src="../public/img/iconAuto.png" alt="Auto">
          <h3>Autos</h3>
          <p>Comodidad diaria</p>
        </div>
        <div class="pref-card">
          <img src="../public/img/iconCamioneta.png" alt="Camioneta">
          <h3>Camionetas</h3>
          <p>Potencia segura</p>
        </div>
        <div class="pref-card">
          <img src="../public/img/iconFamiliar.png" alt="Auto Familiar">
          <h3>Familiar</h3>
          <p>Libertad total</p>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer id="contactanos">
    <h2>Contactanos!</h2>
    <p>Tu movilidad comienza aquí</p>
    <div class="footer-grid">
      <div><a href="#">Tel: 3364383533</a></div>
      <div><a href="#">Naza.kessel@gmail.com</a></div>
      <div><a href="#">Isft38 Somisa</a></div>
    </div>
    <p>2do año Analisis en Sistemas, Kessel Nazareth y Coyle Pedro</p>
  </footer>


<script src="carrusel.js"></script>
<script src="carrusel-promos.js"></script>
<<<<<<< HEAD
<script src="../src/CRUD/autos.js"></script>
=======
<script src="header.js"></script>
 <script src="../src/CRUD/autos.js"></script>
>>>>>>> 0e992733bc1d36bf1b51e0807668f25577b71af0
</body>
</html>
