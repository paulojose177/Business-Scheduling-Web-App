<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['accountType']!='customer'){
            header("location: ../register.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../register.php");
    }
    

    //database connection
    include("../connection/database-con.php");
    $sqlstate= "select * from customer where cemail=?";
    $stmt = $connection->prepare($sqlstate);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["customerid"];
    $username=$userfetch["customname"];

    
    if($_GET){
        //database connection
        include("../connection/database-con.php");
        $id=$_GET["id"];
        $sqlstate= "select * from customer where customerid=?";
        $stmt = $connection->prepare($sqlstate);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result001 = $stmt->get_result();
        $email=($result001->fetch_assoc())["cemail"];

        $sqlstate= "delete from userdetails where email=?;";
        $stmt = $connection->prepare($sqlstate);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $statresult = $stmt->get_result();


        $sqlstate= "delete from customer where cemail=?";
        $stmt = $connection->prepare($sqlstate);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $statresult = $stmt->get_result();

        //print_r($email);
        header("location: ../logout.php");
    }


?>