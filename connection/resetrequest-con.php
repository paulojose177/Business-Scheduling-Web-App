<?php

if (isset($_POST["resetconfirm"])) {

    $selectortoken = bin2hex(random_bytes(8));
    $tokenassign = random_bytes(32);

    $urllink ="http://localhost/pjwebapp/newpwcreation.php?selector=" . $selectortoken . "&validator=" . bin2hex($tokenassign);

    $expirydate = date("U") + 1800;

    require 'database-con.php';

    $emailuser = $_POST["email"];

    $sqldel = "DELETE FROM resetpwd WHERE resetpwEmail=?";
    $statement = mysqli_stmt_init($connection);

    if (!mysqli_stmt_prepare($statement, $sqldel)) {
    echo "An error occured!";
    exit();
    } else {
        mysqli_stmt_bind_param($statement, "s", $emailuser);
        mysqli_stmt_execute($statement);
    }

    $sqldel = "INSERT INTO resetpwd (resetpwEmail, resetpwSelect, resetpwToken, resetpwExpiry) VALUES (?, ?, ?, ?);";
    $statement = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($statement, $sqldel)) {
    echo "An error occured!";
    exit();
    } else {
        $tokenhash = password_hash($tokenassign, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($statement, "ssss", $emailuser, $selectortoken, $tokenhash, $expirydate);
        mysqli_stmt_execute($statement);
} 

mysqli_stmt_close($statement);
mysqli_close($connection);

$towards = $emailuser;

$recsubject = 'Here is the reset for your password';

$recmessage = '<p>A password request has been received from this email. Here is the link that will enable you to reset your password, if this request was not made by you then please ignore</p>';

$recmessage .= '<p>Click on this link to reset your password: </br>';

$recmessage .= '<a href="' . $urllink . '">' . $urllink . '</a></p>';

require_once('PHPMailer/PHPMailerAutoload.php');


    $sendmail = new PHPMailer(true);
    $sendmail->isSMTP();
    $sendmail->Host = 'smtp.gmail.com';
    $sendmail->SMTPAuth = true;
    $sendmail->Username = 'pjbusinesswebapp@gmail.com';
    $sendmail->Password = 'fjfnqdmcfonnfbyy';
    $sendmail->SMTPSecure = 'ssl';
    $sendmail->Port = 465;

    $sendmail->setFrom('pjbusinesswebapp@gmail.com');
    $sendmail->addAddress($towards);

    $sendmail->isHTML(true);
    $sendmail->Subject = $recsubject;
    $sendmail->Body =$recmessage;

    $sendmail->Send();



$headermail = "From: PJ Web App <pjwebapp@gmail.com>\r\n";
$headermail .= "Reply-To: pjwebapp@gmail.com\r\n";
$headermail .= "Content-type: text/html\r\n";

mail($towards, $recsubject, $recmessage, $headermail);

header("location: ../resetpassword.php?pwreset=resetsuccess");
}

else {

    header("location: ../index.php");
}
