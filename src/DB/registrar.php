<?php
require_once("conexion.php");

// Crear y Obtener Conexión
// Se asume que $db->conectar() devuelve un objeto PDO.
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

// --- 1. Verificación de Contraseñas ---
if ($password !== $confirmar) {
    // Es mejor usar un header para redirigir con un error, pero mantenemos el die simple
    die("Las contraseñas no coinciden.");
}

// --- 2. Verificar si el email ya está registrado (PDO) ---
$sql_check = "SELECT id FROM usuarios WHERE email = ?";
$stmt_check = $conn->prepare($sql_check);

// PDO: Usamos el array en execute() para enlazar el parámetro
$stmt_check->execute([$email]);

// PDO: fetchColumn() verifica si se encontró al menos una fila
if ($stmt_check->fetchColumn()) {
    die("El correo electrónico ya está registrado.");
}

// --- 3. Hashear Contraseña e Insertar Datos (PDO) ---

// Hashear contraseña (¡esencial para seguridad!)
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Array de todos los valores a insertar, en el orden de los '?'
$parametros = [
    $nombre,
    $apellido,
    $email,
    $ciudad,
    $direccion,
    $password_hash
];

$sql_insert = "INSERT INTO usuarios (nombre, apellido, email, ciudad, direccion, password_hash) VALUES (?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);

// PDO: Ejecutamos pasando el array de parámetros
if ($stmt_insert->execute($parametros)) {
    // Redirigir al index al completar el registro
    header("Location: ../../index.php");
    exit();
} else {
    // Mostrar detalles del error de PDO si la inserción falla
    echo "Error al registrar el usuario: ";
    print_r($stmt_insert->errorInfo());
}

?>