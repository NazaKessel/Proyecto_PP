<?php

require '../src/DB/conexion.php';
$db = new Database();
$con = $db ->conectar();

$sql = $con->prepare("SELECT id, marca, precio, modelo, foto FROM autos WHERE disponible = 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thames Cars</title>
  <link rel="stylesheet" href="../public/principal.css">
</head>
<body>

  <!-- Banner principal -->
  <section class="banner">
    <header>
      <div class="logo">Thames Cars </div>
      <nav>
        <a href="productos.html">Productos</a>
        <a href="#servicios">Servicios</a>
        <a href="#contactanos">Contactanos</a>
      </nav>
    </header>
    <div class="banner-content">
      <h1>Movilidad a tu alcance!</h1>
      <p>Tu próximo viaje empieza aquí: vehículos confiables y listos para vos.</p>
      <button onclick="location.href='registrarse.html'" class="btn">Registrarse</button>
      <button onclick="location.href='inicioSesion.html'" class="btn">Iniciar Sesion</button>
    </div>
  </section>

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

    <!-- Auto destacado -->
     <section class="auto">
  <div class="carousel">
  <button class="prev">&#10094;</button>
  <div class="carousel-track">
    <img src="../public/img/ford/FordCostado.jpg" alt="Ford Costado" id="img1">
    <img src="../public/img/ford/FordAtras.jpg" alt="Ford Atrás" id="img2">
  </div>
  <button class="next">&#10095;</button>
</div> 

      <div class="auto-text">
        <h2>Ford Focus <span> 50%off</span></h2>
        <p>Comodidad y potencia en un solo vehículo. Ideal para tus viajes.</p>
        <button class="btn">Ver más</button>
      </div>
    </section>

    <!-- Productos -->
     <section class="carrusel">
    <button class="carrusel-btn prev">&#10094;</button>

    <div class="carrusel-contenedor">
        <?php foreach($resultado as $row) { ?>
        <div class="card">
            <?php 
            $id = $row['id'];
            $imagen = "../public/img/productos/$id/auto.jpg";
            
            if (!file_exists($imagen)){
              $imagen = "../public/img/no-photo.jpg";
            }
            ?>
            <img src="<?php echo $imagen; ?>">
            <p class="card-description"><?php echo $row['marca']. " ". $row['modelo']; ?></p>
            <p class="card-price">$ <?php echo $row['precio'];?></p>
            <button>ver mas</button>
        </div>
        <?php } ?>
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
 <script src="../src/CRUD/autos.js"></script>
</body>
</html>
