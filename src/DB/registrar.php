<?php
require_once("conexion.php");

// Crear conexión
$db   = new Database();
$conn = $db->conectar();

// Obtener datos del formulario
$nombre    = $_POST['nombre'] ?? '';
$apellido  = $_POST['apellido'] ?? '';
$email     = $_POST['email'] ?? '';
$ciudad    = $_POST['ciudad'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$password  = $_POST['password'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

if ($password !== $confirmar) {
    die("Las contraseñas no coinciden.");
}

// Verificar si el email ya está registrado
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

if ($stmt->num_rows > 0) {
    die("El correo electrónico ya está registrado.");
}

// Hashear contraseña
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insertar datos
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, ciudad, direccion, password_hash) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nombre, $apellido, $email, $ciudad, $direccion, $password_hash);

if ($stmt->execute()) {
    // Redirigir directamente al index
    header("Location: ../../views/index.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
