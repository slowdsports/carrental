<?php
// ARCHIVO TEMPORAL DE DIAGNÓSTICO — ELIMINAR DESPUÉS DE USAR
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo '<pre>';
echo "PHP version: " . PHP_VERSION . "\n";
echo "SERVER_NAME: " . ($_SERVER['SERVER_NAME'] ?? '(no definido)') . "\n";
echo "HTTP_HOST: "   . ($_SERVER['HTTP_HOST']   ?? '(no definido)') . "\n";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? '(no definido)') . "\n";
echo "__DIR__: " . __DIR__ . "\n\n";

// Test detección de entorno
$host = $_SERVER['SERVER_NAME'] ?? 'localhost';
$isLocal = in_array($host, array('localhost', '127.0.0.1'));
echo "Entorno detectado: " . ($isLocal ? 'LOCAL' : 'PRODUCCIÓN') . "\n";
echo "DB_NAME que usaría: " . ($isLocal ? 'carrental' : 'u6613652_carrental') . "\n\n";

// Test archivos críticos
$files = array(
    'includes/config.php',
    'includes/header.php',
    'includes/footer.php',
    'includes/mailer.php',
    'home.php',
    '404.php',
);
echo "Archivos críticos:\n";
foreach ($files as $f) {
    echo "  " . $f . ": " . (file_exists(__DIR__ . '/' . $f) ? "OK" : "FALTA") . "\n";
}

// Test conexión DB (sin mostrar contraseña)
echo "\nConexión a la base de datos: ";
try {
    include_once __DIR__ . '/includes/config.php';
    echo "OK (DB: " . DB_NAME . ")\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo '</pre>';
