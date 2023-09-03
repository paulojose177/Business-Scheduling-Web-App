<?php

if (isset($_POST["confirm"])) {

$email = $_POST["emailid"];
$password = $_POST["password"];

require_once 'database-con.php';
require_once 'function-con.php';

if (noinputlogin($email, $password) !== false) {

    header("location: ../register.php?error=noinput");
    exit();


}






else {

    userlogin($connection, $email, $password);
    header("location: ../register.php");
    exit();
}


}