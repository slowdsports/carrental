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

// Auto-migrations: crean/alteran tablas al primer arranque en producción
$_migrate = function ($dbh) {
    $db = DB_NAME;

    try {
        // 1. Tabla de ubicaciones de recogida
        $dbh->exec("CREATE TABLE IF NOT EXISTS `tblpickuplocations` (
            `id`           int(11)      NOT NULL AUTO_INCREMENT,
            `LocationName` varchar(200) NOT NULL,
            `IsActive`     tinyint(1)   NOT NULL DEFAULT 1,
            `SortOrder`    int(11)      NOT NULL DEFAULT 0,
            `CreationDate` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        // Sembrar ubicación por defecto si la tabla está vacía
        $q = $dbh->query("SELECT COUNT(*) FROM `tblpickuplocations`");
        if ($q && (int)$q->fetchColumn() === 0) {
            $s = $dbh->prepare("INSERT INTO `tblpickuplocations` (`LocationName`, `IsActive`, `SortOrder`) VALUES (:n, 1, 1)");
            $s->execute(array(':n' => 'Aeropuerto Internacional Ramón Villeda Morales (SAP) - San Pedro Sula'));
        }
    } catch (Exception $e) { /* Ignorar — tabla ya existe o sin privilegios */ }

    // 2. Renombrar columnas de accesorios en tblvehicles preservando el tipo original
    $renames = array('CDPlayer' => 'CarplayAndroidAuto', 'CentralLocking' => 'RearCamera',
                     'PowerDoorLocks' => 'StabilityControl', 'CrashSensor' => 'ParkingSensor');
    foreach ($renames as $old => $new) {
        try {
            $q = $dbh->query("SELECT COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA='{$db}' AND TABLE_NAME='tblvehicles' AND COLUMN_NAME='{$old}'");
            if (!$q) continue;
            $col = $q->fetch(PDO::FETCH_OBJ);
            if (!$col) continue;
            $def = $col->COLUMN_TYPE;
            if ($col->IS_NULLABLE === 'NO')       $def .= ' NOT NULL';
            if ($col->COLUMN_DEFAULT !== null)     $def .= ' DEFAULT ' . $col->COLUMN_DEFAULT;
            $dbh->exec("ALTER TABLE `tblvehicles` CHANGE `{$old}` `{$new}` {$def}");
        } catch (Exception $e) { /* Columna no existe o ya fue renombrada */ }
    }

    // 3. Columna VehicleCategory en tblvehicles
    try {
        $q = $dbh->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA='{$db}' AND TABLE_NAME='tblvehicles' AND COLUMN_NAME='VehicleCategory'");
        if ($q && (int)$q->fetchColumn() === 0) {
            $dbh->exec("ALTER TABLE `tblvehicles` ADD COLUMN `VehicleCategory` VARCHAR(50) DEFAULT NULL AFTER `TransmissionType`");
        }
    } catch (Exception $e) { /* Ignorar */ }
};
$_migrate($dbh);
unset($_migrate);

if (file_exists(__DIR__ . '/mailer.php')) {
    require_once(__DIR__ . '/mailer.php');
}
?>