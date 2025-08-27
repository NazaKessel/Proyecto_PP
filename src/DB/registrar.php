<?php
// Datos de conexión
$host = "localhost";
$user = "root";      // Cambia por tu usuario de MySQL
$pass = "";          // Cambia por tu contraseña de MySQL
$db   = "thames";    // Nombre de tu base de datos

// Conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre    = $_POST['nombre'] ?? '';
$apellido  = $_POST['apellido'] ?? '';
$email     = $_POST['email'] ?? '';
$ciudad    = $_POST['ciudad'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$password  = $_POST['password'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

// Validar contraseñas en backend
if ($password !== $confirmar) {
    die("Las contraseñas no coinciden.");
}

// Verificar si el email ya está registrado
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("El correo electrónico ya está registrado.");
}
$stmt->close();

// Hashear contraseña
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insertar datos
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, ciudad, direccion, password_hash) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nombre, $apellido, $email, $ciudad, $direccion, $password_hash);

if ($stmt->execute()) {
    echo "Registro exitoso. ¡Bienvenido, $nombre!";
    // Redirigir a login o página principal si quieres:
    // header("Location: ../login.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>