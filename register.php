<html>
<head>
    <title>Registration/Login Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .error-message {
            margin-top: 20px;  
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="formcontainer">
        <div class="box">
            <div class="innerbox" id="box">
                <div class="box-front">

                    <h2>LOGIN TO YOUR ACCOUNT</h2>
                    <form action= "connection/login-con.php" method="post">
                        <input type="Email" name="emailid" class="box-input" placeholder="Enter your email"
                        required>
    
                        <input type="Password" name="password" class="box-input" placeholder="Enter your password" required>
                        <button type="submit" name="confirm" class="confirm-btn">Confirm</button>
                        
    
                    </form>
                    <button type="button" class="newbtn" onclick="openRegisterform()">Create New Account</button>
                    <a href="resetpassword.php">Forgot Password</a>
                    <?php
                        if(isset($_GET["error"])) {
                            echo '<p class="error-message">';
                            if ($_GET["error"] == "noinput") {
                                echo "Please ensure that fields are filled!";
                            }
                            else if ($_GET["error"] == "loginiswrong") {
                                echo "Login is wrong!";
                            }
                            echo '</p>';
                        }
                    ?>
                </div>
                
                <?php

if(isset($_GET["error"])) {

    if ($_GET["error"] == "noinput") {
        echo "<p>Please ensure that fields are filled!</p>";
    }
    else if ($_GET["error"] == "loginiswrong") {
        echo "<p> Login is wrong</p>";
    }

    
}

session_start();

    $_SESSION["user"]="";
    $_SESSION["accountType"]="";
    
    // Set the new timezone
    date_default_timezone_set('Europe/London');
    $date = date('l, F jS Y');

    $_SESSION["date"]=$date;
    

    //database connection
    include("connection/database-con.php");

    



    if($_POST){

        $email=$_POST['emailid'];
        $password=$_POST['password'];
        
        $error='<label for="promter" class="form-label"></label>';

        $statresult= $connection->query("select * from userdetails where email='$email'");
        if($statresult->num_rows==1){
            $usertype=$statresult->fetch_assoc()['accountType'];
            if ($usertype=='customer'){
                //TODO
                $checker = $connection->query("select * from customer where cemail='$email' and custpassword='$password'");
                if ($checker->num_rows==1){


                    //   Customer dashboard
                    $_SESSION['user']=$email;
                    $_SESSION['accountType']='customer';
                    
                    header('location: customer/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }elseif($usertype=='admin'){
                //TODO
                $checker = $connection->query("select * from userdetails where email='$email' and password='$password'");
                if ($checker->num_rows==1){


                    //   Admin dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['accountType']='admin';
                    
                    header('location: admin/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }


            }elseif($usertype=='employee'){
                //TODO
                $checker = $connection->query("select * from employee where empemail='$email' and emppassword='$password'");
                if ($checker->num_rows==1){


                    //   employee dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['accountType']='employee';
                    header('location: employee/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }
            
        }else{
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
        }






        
    }else{
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }


?>
                
                <div class="box-back">
                    <h2>REGISTER</h2>
                    <form action= "connection/register-con.php" method="post">
                        <input type="email" name="email" class="box-input" placeholder="Enter your email"
                        required>

                        <input type="text" name="name"class="box-input" placeholder="Enter your name"
                        required>

                        <input type="text" name="businessname"class="box-input" placeholder="Enter your business name"
                        required>
    
                        <input type="Password" name="password" class="box-input" placeholder="Enter your password" required>

                        <input type="Password" name="passwordrepeat" class="box-input" placeholder="Repeat password" required>

                        <select name="accountType" class="box-input">
    <option value="" selected disabled>Choose an account type</option>
    <option value="admin">Admin</option>
    <option value="employee">Employee/Personal</option>
    <option value="customer">Customer/Client</option>
</select>

                        <select name="timezonelocation" id="timezoneloc" class="box-input">
                        <option value="" disabled selected>Select a time zone</option>
    <?php
        $timezone_identifiers = DateTimeZone::listIdentifiers();
        foreach($timezone_identifiers as $timezone_identifier) {
            echo '<option value="'.$timezone_identifier.'">'.$timezone_identifier.'</option>';
        }
    ?>
                        </select>
                        <button type="submit" name="confirm" class="confirm-btn">Confirm</button>
                        
    
                    </form>
                    <button type="button" class="newbtn" onclick="openLoginform()">Have an account? Login here</button>
                    
                    <?php

if(isset($_GET["error"])) {

    echo '<p class="error-message">';

    if ($_GET["error"] == "emptyinput") {
        echo "<p>Please ensure that fields are filled!";
    }
    else if ($_GET["error"] == "invalidemail") {
        echo "<p> Please ensure that email input is in the appropriate format";
    }

    else if ($_GET["error"] == "pwsdifferent") {
        echo "<p>The passwords that have been entered do not match";
    }
    else if ($_GET["error"] == "stmtcheckhasfailed") {
        echo "<p>Something has gone wrong, please do it again";
    }

    else if ($_GET["error"] == "emailalreadyregistered") {
        echo "<p>Email is already registered!";

    }
    else if ($_GET["error"] == "noerror") {
        echo "<p> You have successfully registered!";
    }
    

    echo '</p>';
}

?>


                </div>

<?php

if(isset($_GET["error"])) {

    

    if ($_GET["error"] == "noinput") {
        echo "<p>Please ensure that fields are filled!</p>";
    }
    else if ($_GET["error"] == "invalidemail") {
        echo "<p> Please ensure that email input is in the appropriate format</p>";
    }

    else if ($_GET["error"] == "pwsdifferent") {
        echo "<p>The passwords that have been entered do not match</p>";
    }
    else if ($_GET["error"] == "stmtcheckhasfailed") {
        echo "<p>Something has gone wrong, please do it again</p>";
    }

    else if ($_GET["error"] == "emailalreadyregistered") {
        echo "<p>Email is already registered!</p?";

    }
    else if ($_GET["error"] == "noerror") {
        echo "<p> You have successfully registerd!</p>";


    }
}

?>



            </div>
        </div>


    </div>
    
    <script>

        var box = document.getElementById("box");

        function openRegisterform() {
            box.style.transform = "rotateY(-180deg)";
        }

        function openLoginform() {
            box.style.transform = "rotateY(0deg)";
        }



        </script>


</body>
</html>