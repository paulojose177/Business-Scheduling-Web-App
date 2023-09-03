<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['accountType']!='admin'){
            header("location: ../register.php");
        }

    }else{
        header("location: ../register.php");
    }
    
    
    if($_POST){
        //this is to import the database
        include("../connection/database-con.php");
        $title=$_POST["title"];
        $empids=$_POST["empid"]; // this is for the array
        $noc=$_POST["noc"];
        $date=$_POST["date"];
        $time=$_POST["time"];
        $adminParticipation = isset($_POST["adminParticipation"]) ? 1 : 0; // this is to check if admin is participating
    
        foreach($empids as $empid) {
            $empid = intval($empid); // This is to ensure it's an integer
    
            $sql_emp = "SELECT empname, empemail, businessname FROM employee WHERE empid=$empid;";
            $result_emp = $connection->query($sql_emp);

            $admin_id = $_SESSION['id'];
            $admin_result = $connection->query("SELECT * FROM userdetails WHERE id='$admin_id'");
            $admin_row = $admin_result->fetch_assoc();
    
            if($result_emp->num_rows > 0) {
                $row_emp = $result_emp->fetch_assoc();
                $empname = $row_emp["empname"];
                $empemail = $row_emp["empemail"];
                $businessname = $row_emp["businessname"];
    
               
    
                $sql="insert into schedule (empid,title,scheduledate,scheduletime,noc) values ($empid,'$title','$date','$time',$noc);";
                $statresult= $connection->query($sql);

       

        $towards = $empemail;

$recsubject = 'You have been booked for a business event on  Business Scheduling Web App';

$recmessage = '<p>Dear ' . $empname . ', if you are receiving this email then it is because you have been booked for a business event on Business Scheduling Web App by the ' . $businessname . ' administrator, if in doubt then please contact your administrator. Here are the details of the business event in which you have been booked for: </p>';

$recmessage .= '<p>Employee ID: ' . $empid . '</br>';

$recmessage .= '<p>Event Title: ' . $title . '</br>';

$recmessage .= '<p>Date: ' . $date . '</br>';

$recmessage .= '<p>Time: ' . $time . '</br>';


require_once('../PHPMailer/PHPMailerAutoload.php');


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
        header("location: schedule.php?action=session-added&title=$title");
        }
        }

        // If admin is participating, add the admin to the event
        if($adminParticipation) {
            // These are the details that will be inserted in the schedule table
            $sql1="insert into schedule (empid,title,scheduledate,scheduletime,noc) values ($admin_id,'$title','$date','$time',$noc);";
        $statresult= $connection->query($sql1);

        $sql_emp1 = "SELECT name, email, businessname FROM userdetails WHERE id=$admin_id;";
        $result_emp1 = $connection->query($sql_emp1);

        $row_emp1 = $result_emp1->fetch_assoc();
        $name = $row_emp1["name"];
        $email = $row_emp1["email"];
        $businessname1 = $row_emp1["businessname"];

        $towards = $email;

$recsubject = 'As an admin user, you have booked a business event via Business Scheduling Web app in which you will be participating';

$recmessage = '<p>Dear ' . $name . ' if you are receiving this email then it is because, as an administrator, you have booked for a business event on the Business Scheduling Web App under the ' . $businessname1 . ' in which you have indicated you that you will attend. Here are the details of the business event in which you have booked: </p>';

$recmessage .= '<p>Admin ID: ' . $admin_id . '</br>';

$recmessage .= '<p>Event Title: ' . $title . '</br>';

$recmessage .= '<p>Date: ' . $date . '</br>';

$recmessage .= '<p>Time: ' . $time . '</br>';


require_once('../PHPMailer/PHPMailerAutoload.php');


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
header("location: schedule.php?action=session-added&title=$title");


        }
        
    }


?>