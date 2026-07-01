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

    // Intentar query completo con roles (requiere migraciones aplicadas)
    $adminRow = false;
    $query = $dbh->prepare(
        "SELECT a.id, a.UserName, COALESCE(a.RoleId, 1) AS RoleId, COALESCE(r.RoleName, 'Super Admin') AS RoleName
         FROM admin a
         LEFT JOIN tbladminroles r ON r.id = COALESCE(a.RoleId, 1)
         WHERE a.UserName=:username AND a.Password=:password"
    );
    if ($query) {
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $adminRow = $query->fetch(PDO::FETCH_OBJ);
    }

    // Fallback: query simple si tbladminroles o RoleId aún no existen
    if (!$adminRow) {
        $query2 = $dbh->prepare("SELECT id, UserName FROM admin WHERE UserName=:username AND Password=:password");
        if ($query2) {
            $query2->bindParam(':username', $username, PDO::PARAM_STR);
            $query2->bindParam(':password', $password, PDO::PARAM_STR);
            $query2->execute();
            $row2 = $query2->fetch(PDO::FETCH_OBJ);
            if ($row2) {
                $adminRow = (object) array('id' => $row2->id, 'UserName' => $row2->UserName,
                                           'RoleId' => 1, 'RoleName' => 'Super Admin');
            }
        }
    }

    if ($adminRow) {
        $_SESSION['alogin']    = $adminRow->UserName;
        $_SESSION['aadminid']  = $adminRow->id;
        $_SESSION['aroleid']   = $adminRow->RoleId;
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
