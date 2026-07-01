<?php
error_reporting(0);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('includes/config.php');

define('ADMIN_ROOT', __DIR__ . '/');

$loginError = '';
if (!isset($_SESSION['alogin']) && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT admin.id, admin.UserName, admin.RoleId, tbladminroles.RoleName
            FROM admin
            LEFT JOIN tbladminroles ON tbladminroles.id = admin.RoleId
            WHERE admin.UserName=:username and admin.Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $adminRow = $query->fetch(PDO::FETCH_OBJ);
    if ($adminRow) {
        $_SESSION['alogin'] = $adminRow->UserName;
        $_SESSION['aadminid'] = $adminRow->id;
        $_SESSION['aroleid'] = $adminRow->RoleId;
        $_SESSION['arolename'] = $adminRow->RoleName;
        header('Location: index.php');
        exit;
    } else {
        $loginError = 'Credenciales inválidas';
    }
}

if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == 0) {
    include('includes/login-view.php');
    exit;
}

// Autenticado: enrutamos por ?p=
$p = isset($_GET['p']) ? basename($_GET['p']) : 'dashboard';
$pageFile = ADMIN_ROOT . 'pages/' . $p . '.php';

// El logout destruye la sesión y redirige por header(); debe ejecutarse
// antes de que header.php empiece a enviar HTML.
if ($p === 'logout') {
    include($pageFile);
    exit;
}

include('includes/header.php');
if (file_exists($pageFile)) {
    include($pageFile);
} else {
    echo '<div class="alert alert-warning">Página no encontrada.</div>';
}
include('includes/footer.php');
