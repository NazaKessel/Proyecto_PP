<?php
$archivo = basename($_GET['img']);
$ruta = __DIR__ . "/uploads/" . $archivo;

if (file_exists($ruta)) {
    $tipo = mime_content_type($ruta);
    header("Content-Type: $tipo");
    readfile($ruta);
} else {
    http_response_code(404);
}