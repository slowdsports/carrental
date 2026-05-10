<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','u6613652_root');
define('DB_PASS','sJmJPvG5?Q0n-+6Y');
define('DB_NAME','u6613652_carrental');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>