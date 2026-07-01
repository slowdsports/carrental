<?php
// Credenciales según entorno (local XAMPP vs producción Zomro)
if (in_array($_SERVER['SERVER_NAME'] ?? 'localhost', array('localhost', '127.0.0.1'))) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'carrental');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'u6613652_root');
    define('DB_PASS', 'sJmJPvG5?Q0n-+6Y');
    define('DB_NAME', 'u6613652_carrental');
}
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS, array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT,
));
}
catch (PDOException $e)
{
exit("Error al conectar a la base de datos.");
}

// Auto-migrations: crean/alteran tablas del panel admin al primer arranque en producción
$_adminMigrate = function ($dbh) {
    $db = DB_NAME;

    try {
        // 1. Tabla de roles de admin
        $dbh->exec("CREATE TABLE IF NOT EXISTS `tbladminroles` (
            `id`           int(11)      NOT NULL AUTO_INCREMENT,
            `RoleName`     varchar(100) NOT NULL,
            `CreationDate` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        // Sembrar roles por defecto si la tabla está vacía
        $q = $dbh->query("SELECT COUNT(*) FROM `tbladminroles`");
        if ($q && (int)$q->fetchColumn() === 0) {
            $dbh->exec("INSERT INTO `tbladminroles` (`RoleName`) VALUES ('Super Admin'), ('Editor'), ('Soporte')");
        }
    } catch (Exception $e) { /* Ignorar */ }

    try {
        // 2. Columna RoleId en tabla admin (asigna Super Admin a cuentas existentes)
        $q = $dbh->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA='{$db}' AND TABLE_NAME='admin' AND COLUMN_NAME='RoleId'");
        if ($q && (int)$q->fetchColumn() === 0) {
            $dbh->exec("ALTER TABLE `admin` ADD COLUMN `RoleId` int(11) NOT NULL DEFAULT 1");
            $dbh->exec("UPDATE `admin` SET `RoleId`=1");
        }
    } catch (Exception $e) { /* Ignorar */ }
};
$_adminMigrate($dbh);
unset($_adminMigrate);
?>