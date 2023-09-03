<?php

$serverName = "localhost";
$databaseUsername = "root";
$databasepw = "";
$databasename = "registrationuser";


$connection = mysqli_connect($serverName, $databaseUsername, $databasepw, $databasename);

if (!$connection) {

    die("Connection failed: " . mysqli_connect_error());
}




