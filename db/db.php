<?php

$host = "localhost";
$user = "root";
$password = "root";
$db = "test_db";
$dsn = "mysql:host=".$host.";dbname=".$db;

$debug = false;
try
{
	$pdo= new PDO($dsn, $user,$password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (PDOException $e)
{
	echo 'PDO error: could not connect to DB, error: '.$e;
}

$mysqli = new mysqli($host, $user, $password, $db) or die($mysqli->error);

?>
