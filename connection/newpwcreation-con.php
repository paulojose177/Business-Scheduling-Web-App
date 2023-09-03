<?php


if (isset($_POST["resetconfirm"])) {

    $selectortoken = $_POST["selector"];
    $tokenvalidator = $_POST["validator"];
    $newpassword = $_POST["newpw"];
    $repeatnewpw = $_POST["repeat-newpw"];

    
    if (empty($newpassword) || empty($repeatnewpw)) {
        header("location: ../register.php?newpassword=empty");
        exit();

    } else if ($newpassword != $repeatnewpw ) {
        header("Location: ../newpwcreation.php?newpassword=notsamepw");
        exit();

    }

    $todaysdate = date("U");

    require 'database-con.php';

    $sqlstat = "SELECT * FROM resetpwd WHERE resetpwSelect=? AND resetpwExpiry >= ?";
    $statement = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($statement, $sqlstat)) {
    echo "An error occured!";
    exit();
    } else {
        mysqli_stmt_bind_param($statement, "ss", $selectortoken, $todaysdate);
        mysqli_stmt_execute($statement);

        $resulttoken = mysqli_stmt_get_result($statement);
        if (!$rowcheck = mysqli_fetch_assoc($resulttoken)) {
            echo "You need to submit your reset password request again.";
            exit();
        } else{

            $bintoken = hex2bin($tokenvalidator);
            $checktoken = password_verify($bintoken, $rowcheck ["resetpwToken"]);

            if ($checktoken === false) {
                echo "You need to submit your reset password request again.";
                exit();
            } else if ($checktoken === true) {

                $emailtoken = $rowcheck ['resetpwEmail'];

                $sqlstat = "SELECT * FROM userdetails WHERE email=?;";
                $statement = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare ($statement, $sqlstat)) {
                   echo "An error has occured!";
                    exit();
                } else {
                    mysqli_stmt_bind_param($statement, "s", $emailtoken);
                    mysqli_stmt_execute($statement);
                    $resulttoken = mysqli_stmt_get_result($statement);
        if (!$rowcheck = mysqli_fetch_assoc($resulttoken)) {
            echo "An error has occured!";
            exit();
        } else {

            $sqlstat = "UPDATE userdetails SET password=?  WHERE email=?";
            $statement = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare ($statement, $sqlstat)) {
                   echo "An error has occured!";
                    exit();
                } else {
                    $newhashpw = password_hash($newpassword, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($statement, "ss", $newhashpw, $emailtoken);
                    mysqli_stmt_execute($statement);

                    $sqlstat = "DELETE FROM resetpwd WHERE resetpwEmail=?";
                    $statement = mysqli_stmt_init($connection);
                    if (!mysqli_stmt_prepare($statement, $sqlstat)) {
                        echo "An error occured!";
                        exit();
                    } else {
                        mysqli_stmt_bind_param($statement, "s", $emailtoken);
                        mysqli_stmt_execute($statement);
                        header("location: ../register.php?newpassword=pwhasbeenupdated");
                    }
                    
                }

        }


                }

            }
        }
    }

} else {
    header("location: ../index.php");
}