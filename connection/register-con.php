<?php

if (isset($_POST["confirm"])) {
    
    $email = $_POST["email"];
    $name = $_POST["name"];
    $businessname = $_POST["businessname"];
    $password = $_POST["password"];
    $passwordrepeat = $_POST["passwordrepeat"];
    $accountType = $_POST["accountType"];
    $timezonelocation = $_POST["timezonelocation"];

    require_once 'database-con.php';
    require_once 'function-con.php';

    if (noinputsignup($email, $name, $businessname, $password, $passwordrepeat, $accountType, $timezonelocation) !== false) {

        header("location: ../register.php?error=emptyinput");
        exit();


    }

    if (isinvalidEmail($email) !== false) {
        

        header("location: ../register.php?error=invalidemail");
        exit();
    }

    if (passwordmatch($password, $passwordrepeat) !== false) {
        

        header("location: ../register.php?error=pwsdifferent");
        exit();
    }

    if (emailexists($connection, $email) !== false) {
        

        header("location: ../register.php?error=emailalreadyregistered");
        exit();
    }

    if (passwordstrength($password) !== false) {


        header("location: ../register.php?error=weakpassword");
        exit();

    }

  createnewuser($connection, $email, $name, $businessname, $password, $accountType, $timezonelocation);





} else {

    header("location: ../register.php");

    
} 