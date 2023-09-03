<?php

function noinputsignup($email, $name, $businessname, $password, $passwordrepeat, $accountType, $timezonelocation) {
    
    if (empty($email) || empty($name) || empty($businessname) || empty($password) || empty($passwordrepeat) || empty($accountType) || empty($timezonelocation)) {
            
       $statresult = true;
    }

    else {
        $statresult = false;
    }

    return $statresult;

}

function isinvalidEmail($email) {
    
    // Validates the email address format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // If the email address format is invalid, return true
        $statresult = true;
    }

    // If the email address format is valid, return false
    else {


        $statresult = false;
    }
    return $statresult;
    
}

function passwordmatch($password, $passwordrepeat) {
    

    if ($password !== $passwordrepeat) {

        $statresult = true;
    }

    else {
        $statresult = false;
    }

    return $statresult;
  
}

function emailexists($connection, $email) {
    $sqlstat = "SELECT * FROM userdetails WHERE email = ?; ";
    $stmtcheck = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmtcheck, $sqlstat)) {

        header("location: ../register.php?error=stmtcheckhasfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmtcheck, "s", $email);
    mysqli_stmt_execute($stmtcheck);

    $dataresult = mysqli_stmt_get_result($stmtcheck);

    if ($rowcheck = mysqli_fetch_assoc($dataresult)) {
        return $rowcheck;


    }

    else {
        $statresult = false;
        return $statresult;


    }
   
    mysqli_stmt_close($stmtcheck);
}

function passwordstrength($password) {
    
    $passwordlengthreq = strlen($password) >= 6;

    // Checks if there is at minimum one uppercase letter
    $includeuppercase = preg_match('/[A-Z]/', $password);

    // Checks if there is at minimum one lowercase letter
    $includelowercase = preg_match('/[a-z]/', $password);

    // If all requirements are met, the password is considered strong
    if (!$passwordlengthreq || !$includeuppercase || !$includelowercase) {
        return true;
    };

    return false;
}


function createnewuser($connection, $email, $name, $businessname, $password, $accountType, $timezonelocation) {

    $sqlstat = "INSERT INTO userdetails (email, name, businessname, password, accountType, timezonelocation) VALUES (?, ?, ?, ?, ?, ?);";
    $stmtcheck = mysqli_stmt_init($connection);


    if (!mysqli_stmt_prepare($stmtcheck, $sqlstat)) {

        header("location: ../register.php?error=stmtcheckhasfailed");
        exit();
    }

    $hashpassword = password_hash($password, PASSWORD_DEFAULT);




    mysqli_stmt_bind_param($stmtcheck, "ssssss", $email, $name, $businessname, $hashpassword, $accountType, $timezonelocation);
    mysqli_stmt_execute($stmtcheck);

     // If the accountType is 'customer' then also insert into the customer table
     if($accountType == 'customer') {
        $sqlstatCustomer = "INSERT INTO customer (cemail, customname, custpassword) VALUES (?, ?, ?);";
        $stmtcheckCustomer = mysqli_stmt_init($connection);
        if (!mysqli_stmt_prepare($stmtcheckCustomer, $sqlstatCustomer)) {
            header("location: ../register.php?error=stmtcheckhasfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmtcheckCustomer, "sss", $email, $name, $hashpassword);
        mysqli_stmt_execute($stmtcheckCustomer);
        mysqli_stmt_close($stmtcheckCustomer);
    }


    mysqli_stmt_close($stmtcheck);
    header("location: ../register.php?error=noerror");
    exit();
        

}


function noinputlogin ($email, $password) {
    
    if (empty($email) || empty($password)) {
            
       $statresult = true;
    }

    else {
        $statresult = false;
    }

    return $statresult;

}

function userlogin($connection, $email, $password){
$emailexists = emailexists($connection, $email);

if ($emailexists === false){
    header("location: ../register.php?error=loginiswrong");
}


$hashpassword = $emailexists["password"];
$passwordcheck = password_verify($password, $hashpassword);

if ($passwordcheck === false) {
    header("location: ../register.php?error=loginiswrong");
    exit();


}

else if ($passwordcheck === true){
    session_start();
    $_SESSION["id"] = $emailexists["id"];
    $_SESSION["email"] = $emailexists["email"];
    $user_timezone = $emailexists["timezone"];


    date_default_timezone_set($user_timezone);;
    $date = date('l, F jS Y');

    $_SESSION["date"]=$date;
    $email=$_POST['emailid'];
        $password=$_POST['password'];
        
        $error='<label for="promter" class="form-label"></label>';

        $statresult= $connection->query("select * from userdetails where email='$email'");
        if($statresult->num_rows==1){
            $usertype=$statresult->fetch_assoc()['accountType'];
            if ($usertype=='customer'){
                
                $checker = $connection->query("select * from userdetails where email='$email'");
                if ($checker->num_rows==1){


                    //   Customer dashboard
                    $_SESSION['user']=$email;
                    $_SESSION['accountType']='customer';
                    
                    header('location: ../customer/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong details: Email or password are invalid</label>';
                }

            }elseif($usertype=='admin'){
                //admin account type
                $checker = $connection->query("select * from userdetails where email='$email'");
                if ($checker->num_rows==1){


                    //   Administrator dashboard
                    $_SESSION['user']=$email;
                    $_SESSION['accountType']='admin';
                    
                    header('location: ../admin/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong details: Email or password are invalid</label>';
                }


            }elseif($usertype=='employee'){
                //employee account type
                $checker = $connection->query("select * from userdetails where email='$email'");
                if ($checker->num_rows==1){


                    //   employee dashboard
                    $_SESSION['user']=$email;
                    $_SESSION['accountType']='employee';
                    header('location: ../employee/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong details: Email or password are invalid</label>';
                }

            }
            
        }else{
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
        }

    
    
    exit();
}
}

