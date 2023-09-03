<?php

session_start();


$con = mysqli_connect('localhost', 'root');

mysqli_select_db($con, 'userdetails');

$email = $_POST['email'];
$name = $_POST['name'];
$businessname = $_POST['businessname'];
$password = $_POST['password'];
$accountType = $_POST['accountType'];
$timezonelocation = $_POST['timezonelocation'];

$s= " select * from userdetails where email = '$email'";

$results = mysqli_query($con, $s);

$num = mysqli_num_rows($results); 

if($num == 1){
echo" Email is already registered";

} else{
    $reg= " insert into userdetails(email, name, businessname, password, accountType, timezonelocation) values ('$email', '$name', '$businessname', '$password', '$accountType', '$timezonelocation')";
    mysqli_query($con, $reg);
    echo" Registration has been successful";

}




?>