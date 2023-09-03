<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['accountType']!='admin'){
            header("location: ../register.php");
        }

    }else{
        header("location: ../register.php");
    }
    
    
    if($_GET){
        //database connection
        include("../connection/database-con.php");
        $id=$_GET["id"];

        $sqltitle = "SELECT title FROM schedule WHERE scheduleid = $id";
    $resulttitle = $connection->query($sqltitle);
    $rowtitle = $resulttitle->fetch_assoc();
    $titleForQuery = $rowtitle['title'];
        //$result001= $connection->query("select * from schedule where scheduleid=$id;");
        //$email=($result001->fetch_assoc())["empemail"];
        $sql= $connection->query("delete from schedule where title='$titleForQuery';");
        //$sql= $connection->query("delete from employee where empemail='$email';");
        //print_r($email);
        header("location: schedule.php");
    }


?>