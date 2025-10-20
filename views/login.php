<?php
session_start();
include("../src/DB/conexion.php");

$db = new Database();
$conn = $db->conectar();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $password = trim($_POST["password"]);

    // 🔹 CASO ESPECIAL: Usuario administrador fijo
    if ($nombre === "admin" && $password === "123") {
        $_SESSION["usuario"] = "admin";
        header("Location: admin/indexAdmin.php");
        exit;
    }

    // 🔹 Buscar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE nombre = :nombre";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 🔹 Verificar usuario y contraseña
    if ($user && password_verify($password, $user["password_hash"])) {
        $_SESSION["usuario"] = $user["nombre"];
        header("Location: ../index.php"); // si no es admin, va al index normal
        exit;
    } else {
        echo "<script>
            alert('❌ Nombre o contraseña incorrectos');
            window.location.href = 'login.php';
        </script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSS de AdminLTE -->
  <link rel="stylesheet" href="../adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <b>Ponga sus datos</b>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesión para continuar</p>

      <form action="login.php" method="post" id="loginForm">
        <div class="input-group mb-3">
          <input type="text" name="nombre" id="username" class="form-control" placeholder="Usuario" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- JS -->
<script src="../adminlte/plugins/jquery/jquery.min.js"></script>
<script src="../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../adminlte/dist/js/adminlte.min.js"></script>

</body>
</html>
