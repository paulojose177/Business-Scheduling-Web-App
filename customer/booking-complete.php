<?php

    //pj web application

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


    if($_POST){
        if(isset($_POST["booknow"])){
            $apponum=$_POST["apponum"];
            $scheduleid=$_POST["scheduleid"];
            $date=$_POST["date"];
            $scheduleid=$_POST["scheduleid"];
            $sql2="insert into appointment(customerid,apponum,scheduleid,appodate) values ($userid,$apponum,$scheduleid,'$date')";
            $statresult= $connection->query($sql2);
            //echo $apponom;
            header("location: appointment.php?action=booking-added&id=".$apponum."&titleget=none");

        }
    }
 ?>