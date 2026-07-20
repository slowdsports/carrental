<?php
error_reporting(0);
if (session_status() === PHP_SESSION_NONE) session_start();
include('includes/config.php');

// Modo mantenimiento: mostrar coming soon si COMING_SOON está activo y no hay sesión de admin
if (defined('COMING_SOON') && COMING_SOON && empty($_SESSION['alogin'])) {
    include('coming-soon.php');
    exit;
}

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