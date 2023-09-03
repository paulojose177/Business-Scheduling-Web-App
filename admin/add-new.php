<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesanimation.css">  
    <link rel="stylesheet" href="../css/mainstyles.css">  
    <link rel="stylesheet" href="../css/adminstyle.css">
        
    <title>Employee</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['accountType']!='admin'){
            header("location: ../register.php");
        }

    }else{
        header("location: ../register.php");
    }
    
    

    //database connection
    include("../connection/database-con.php");
    include("../connection/function-con.php");



    if($_POST){
        $name = $_POST['name'];
        $jobpos = $_POST['spec'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        // Check if the password meets the strength requirements
        if (passwordstrength($password) !== false){
            $error = '5';
        } else {
            if ($password == $cpassword){
                $error='3';
                $statresult= $connection->query("select * from userdetails where email='$email';");
                if($statresult->num_rows==1){
                    $error='1';
                }else{
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Get the current admin's business name and timezone
                    $admin_email = $_SESSION['user'];
                    $admin_result = $connection->query("SELECT businessname FROM userdetails WHERE email = '$admin_email'");
                    $admin_row = $admin_result->fetch_assoc();
                    $business_name = $admin_row['businessname'];
                    $timezone_result = $connection->query("SELECT timezonelocation FROM userdetails WHERE email = '$admin_email'");
                    $timezone_row = $timezone_result->fetch_assoc();
                    $timezonelocation = $timezone_row['timezonelocation'];
                    
                    

                    $insert_specialty = $connection->query("INSERT INTO jobposition (jobtitle) VALUES ('$jobpos')");
                    $jobposition_id = $connection->insert_id;
                    $sql1="insert into employee(empemail,empname,emppassword,jobposition, businessname) values('$email','$name','$hashed_password','$jobposition_id', '$business_name');";
                    $sql2="insert into userdetails(email, name, password, accountType, businessname, timezonelocation) values('$email', '$name', '$hashed_password', 'employee', '$business_name', '$timezonelocation')";
                    $connection->query($sql1);
                    $connection->query($sql2);

                    $error= '4';
                }
            } else {
                $error='2';
            }
        }
    } else {
        $error='3';
    }
    

    header("location: employees.php?action=add&error=".$error);
    ?>
    
   

</body>
</html>