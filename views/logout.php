<?php
session_start();
session_unset(); // elimina las variables de sesión
session_destroy(); // destruye la sesión
header("Location: index.php");
exit;
?>
