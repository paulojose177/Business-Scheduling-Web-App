<?php



require_once('PHPMailer/PHPMailerAutoload.php');
require 'connection/resetrequest-con.php';

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

