<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login";
//Establece comunicacao a base de dados
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>