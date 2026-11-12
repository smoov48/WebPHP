<?php 

$serverName = "localhost";
$userName = "root";
$dbPwd = "";
$dbName = "dieringhauser-berufskolleg";

$conn = mysqli_connect($serverName, $userName, $dbPwd, $dbName);

if(!$conn) {
    die("Verbindung fehlgeschlagen.". mysqli_connect_error());
}