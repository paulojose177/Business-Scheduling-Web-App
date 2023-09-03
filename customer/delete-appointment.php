<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['accountType']!='a'){
            header("location: ../register.php");
        }

    }else{
        header("location: ../register.php");
    }
    
    
    if($_GET){
        //database connection
        include("../connection/database-con.php");
        $id=$_GET["id"];
        
        $sql= $connection->query("delete from appointment where appoid='$id';");
        $stmt = $connection->prepare($sqlstate);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        
        header("location: appointment.php");
    }


?>