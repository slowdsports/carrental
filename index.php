<?php
// Empieza la sesión
session_start();
// Archivos necesarios
include('includes/config.php');
// Error debug
error_reporting(error_level: 0);
// Cabecera
include('includes/header.php');
// Lógica de indexación
$paginaSolicitada = isset($_GET['p']) ? basename($_GET['p']) : 'home';
// Ruta al directorio de páginas
$rutaDirectorio = __DIR__ . '/';
// Verificar si el archivo existe
if (file_exists($rutaDirectorio . $paginaSolicitada . ".php")) {
    // Si existe, cárgalo 
    include($rutaDirectorio . $paginaSolicitada . ".php");
} else {
    // Si no existe, mostrar 404.php
    include("404.php");
}
// Footer
include('includes/footer.php');
?>