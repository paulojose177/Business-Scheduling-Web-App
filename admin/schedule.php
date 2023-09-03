<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/stylesanimation.css">  
    <link rel="stylesheet" href="../css/mainstyles.css">  
    <link rel="stylesheet" href="../css/adminstyle.css">
    
    
    
        
    <title>Event Schedule</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .inner-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    //pj web application

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

    $email = $_SESSION['user'];
$statresult = $connection->query("SELECT businessname FROM userdetails WHERE email='$email'");
$row = $statresult->fetch_assoc();
$businessName = $row['businessname'];
$result1 = $connection->query("SELECT name FROM userdetails WHERE email='$email'");
$row = $result1->fetch_assoc();
$personalname = $row['name'];
$timezone_result = $connection->query("SELECT timezonelocation FROM userdetails WHERE email='$email'");
$timezone_row = $timezone_result->fetch_assoc();
$user_timezone = $timezone_row['timezonelocation'];

    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                <p class="profile-title"><?php echo $businessName; ?></p>
                                    <p class="profile-subtitle"><?php echo $personalname; ?></p>
                                    <p class="profile-subtitle"><?php echo $email; ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-employee ">
                        <a href="employees.php" class="non-style-link-menu "><div><p class="menu-text">Employees</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule menu-active menu-icon-schedule-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Event Schedule</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-customer">
                        <a href="customer.php" class="non-style-link-menu"><div><p class="menu-text">Customers</p></a></div>
                    </td>
                </tr>

            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Event Schedule Manager</p>
                                           
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 

                        date_default_timezone_set($user_timezone);

                        $datetoday = date('l, F jS Y');
                        echo $datetoday;

                        $list110 = $connection->query("select  * from  schedule;");

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
               
                <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule an Event</div>
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add an Event</font></button>
                        </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                    
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Events (<?php echo $list110->num_rows; ?>)</p>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
                        <tr>
                           <td width="10%">

                           </td> 
                        <td width="5%" style="text-align: center;">
                        Date:
                        </td>
                        <td width="30%">
                        <form action="" method="post">
                            
                            <input type="date" name="scheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">

                        </td>
                        <td width="5%" style="text-align: center;">
                        Employee:
                        </td>
                        <td width="30%">
                        <select name="empid" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0; " >
                            <option value="" disabled selected hidden>Choose Employee Name from the list</option><br/>
                                
                            <?php 
                            
                                $showlist = $connection->query("select  * from  employee WHERE businessname='$businessName' order by empname asc;");

                                for ($y=0;$y<$showlist->num_rows;$y++){
                                    $row00=$showlist->fetch_assoc();
                                    $sn=$row00["empname"];
                                    $id00=$row00["empid"];
                                    echo "<option value=".$id00.">$sn</option><br/>";
                                };


                                ?>

                        </select>
                    </td>
                    <td width="12%">
                        <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                        </form>
                    </td>

                    </tr>
                            </table>

                        </center>
                    </td>
                    
                </tr>
                
                <?php
                    if($_POST){
                        //print_r($_POST);
                        $sqlpt1="";
                        if(!empty($_POST["scheduledate"])){
                            $dateofschedule=$_POST["scheduledate"];
                            $sqlpt1=" schedule.scheduledate='$dateofschedule' ";
                        }


                        $sqlpt2="";
                        if(!empty($_POST["empid"])){
                            $empid=$_POST["empid"];
                            $sqlpt2=" employee.empid=$empid ";
                        }
                        //echo $sqlpt2;
                        //echo $sqlpt1;
                        $sqlstate= "SELECT 
                        MIN(schedule.scheduleid) as scheduleid,
                        schedule.title,
                        GROUP_CONCAT(DISTINCT COALESCE(employee.empname, userdetails.name)) as name,
                        schedule.scheduledate,
                        schedule.scheduletime,
                        schedule.noc 
                    FROM schedule 
                    LEFT JOIN employee ON schedule.empid = employee.empid AND employee.businessname = '$businessName' 
                    LEFT JOIN userdetails ON schedule.empid = userdetails.id AND userdetails.businessname = '$businessName'
                    WHERE COALESCE(employee.businessname, userdetails.businessname) = '$businessName'
                    GROUP BY schedule.title, schedule.scheduledate, schedule.scheduletime";
                        $sqllist=array($sqlpt1,$sqlpt2);
                        $sqlkeywords=array(" where "," and ");
                        $key2=0;
                        foreach($sqllist as $key){

                            if(!empty($key)){
                                $sqlstate.=$sqlkeywords[$key2].$key;
                                $key2++;
                            };
                        };
                        //echo $sqlstate;

                        
                        
                        //
                    }else{
                        $sqlstate= "SELECT 
                        MIN(schedule.scheduleid) as scheduleid,
                        schedule.title,
                        GROUP_CONCAT(DISTINCT COALESCE(employee.empname, userdetails.name)) as name,
                        schedule.scheduledate,
                        schedule.scheduletime,
                        schedule.noc 
                    FROM schedule 
                    LEFT JOIN employee ON schedule.empid = employee.empid AND employee.businessname = '$businessName' 
                    LEFT JOIN userdetails ON schedule.empid = userdetails.id AND userdetails.businessname = '$businessName'
                    WHERE COALESCE(employee.businessname, userdetails.businessname) = '$businessName'
                    GROUP BY schedule.title, schedule.scheduledate, schedule.scheduletime
                    ORDER BY schedule.scheduledate DESC";

                    }



                ?>
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                        <tr>
                                <th class="table-headin">
                                    
                                
                                Event Title
                                
                                </th>
                                
                                <th class="table-headin">
                                    Employee
                                </th>
                                <th class="table-headin">
                                    
                                    Scheduled Event Date & Time
                                    
                                </th>
                                <th class="table-headin">
                                    
                                Max that can be booked
                                    
                                </th>
                                
                                <th class="table-headin">
                                    
                                    Events
                                    
                                </tr>
                        </thead>
                        <tbody>
                        
                            <?php

                                
                                $statresult= $connection->query($sqlstate);

                                if($statresult->num_rows==0){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/company-enterprise-icon.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No events have been found to be booked !</p>
                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show All Events &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                for ( $x=0; $x<$statresult->num_rows;$x++){
                                    $row=$statresult->fetch_assoc();
                                    $scheduleid=$row["scheduleid"];
                                    $title=$row["title"];
                                    $empname=$row["name"];
                                    $scheduledate=$row["scheduledate"];
                                    $scheduletime=$row["scheduletime"];
                                    $noc=$row["noc"];
                                    echo '<tr>
                                        <td> &nbsp;'.
                                        substr($title,0,30)
                                        .'</td>
                                        <td>
                                        '.substr($empname,0,20).'
                                        </td>
                                        <td style="text-align:center;">
                                            '.substr($scheduledate,0,10).' '.substr($scheduletime,0,5).'
                                        </td>
                                        <td style="text-align:center;">
                                            '.$noc.'
                                        </td>

                                        <td>
                                        <div style="display:flex;justify-content: center;">
                                        
                                        <a href="?action=view&id='.$scheduleid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="?action=drop&id='.$scheduleid.'&name='.$title.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Remove</font></button></a>
                                        </div>
                                        </td>
                                    </tr>';
                                    
                                }
                            }
                                 
                            ?>
 
                            </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
    </div>
    <?php
    
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='add-session'){

            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    
                    
                        <a class="close" href="schedule.php">&times;</a> 
                        <div style="display: flex;justify-content: center;">
                        <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                                <td class="label-td" colspan="2">'.
                                   ""
                                
                                .'</td>
                            </tr>

                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Event.</p><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                <form action="add-event.php" method="POST" class="add-new-form">
                                    <label for="title" class="form-label">Event Title : </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="text" name="title" class="input-text" placeholder="Name of this Event" required><br>
                                </td>
                            </tr>
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="empid" class="form-label">Select Employee: </label>
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                                <select name="empid[]" id="employeeSelect" class="box" multiple>
                                    <option value="" disabled hidden>Choose Employee Name(s) from the list</option>';
                        
                                    $showlist = $connection->query("select  * from  employee WHERE businessname='$businessName' order by empname asc;");
                        
                                    for ($y=0;$y<$showlist->num_rows;$y++){
                                        $row00=$showlist->fetch_assoc();
                                        $sn=$row00["empname"];
                                        $id00=$row00["empid"];
                                        echo "<option value=".$id00.">$sn</option>";
                                    };
                        
                                echo '
                                </select><br><br>
                                <input type="checkbox" id="adminParticipation" name="adminParticipation" value="1">
                                <label for="adminParticipation">Include Admin in the Event</label><br><br>
                            </td>
                        </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="noc" class="form-label">Include customers? Specify number : </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="number" name="noc" class="input-text" min="0"  placeholder="Enter 0 if this is not an event reserved for customers, enter a number higher than 1 for appointment entries" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="date" class="form-label">Event Date: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="date" name="date" class="input-text" min="'.date('l, F jS Y').'" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="time" class="form-label">Schedule Time: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="time" name="time" class="input-text" placeholder="Time" required><br>
                                </td>
                            </tr>
                           
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                
                                    <input type="submit" value="Create new Event" class="login-btn btn-primary btn" name="shedulesubmit">
                                </td>
                
                            </tr>
                           
                            </form>
                            
                            </tr>
                        </table>
                        </div>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        }elseif($action=='session-added'){
            $titleget=$_GET["title"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br>
                        <h2>Session Placed. You have also received an email for notification</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                        '.substr($titleget,0,40).' was scheduled.<br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
            </div>
            </div>
            ';
        }elseif($action=='drop'){
            $nameget=$_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br>('.substr($nameget,0,40).').
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-event.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            '; 
        }elseif($action=='view'){
            $sqltitle = "SELECT title FROM schedule WHERE scheduleid = $id";
    $resulttitle = $connection->query($sqltitle);
    $rowtitle = $resulttitle->fetch_assoc();
    $titleForQuery = $rowtitle['title'];

    $sqlstate= "
        SELECT 
            MIN(schedule.scheduleid) as scheduleid,
            schedule.title,
            GROUP_CONCAT(DISTINCT COALESCE(employee.empname, userdetails.name)) as name,
            schedule.scheduledate,
            schedule.scheduletime,
            schedule.noc 
        FROM schedule 
        LEFT JOIN employee ON schedule.empid = employee.empid 
        LEFT JOIN userdetails ON schedule.empid = userdetails.id 
        WHERE schedule.title = '$titleForQuery'
        GROUP BY schedule.title, schedule.scheduledate, schedule.scheduletime";
        
    $statresult= $connection->query($sqlstate);
    $row=$statresult->fetch_assoc();
    $empname=$row["name"]; // string of names
    $scheduleid=$row["scheduleid"];
    $title=$row["title"];
    $scheduledate=$row["scheduledate"];
    $scheduletime=$row["scheduletime"];
            
           
            $noc=$row['noc'];


            $sqlmain12= " SELECT 
            employee.*, 
            userdetails.*, 
            schedule.*,
            COALESCE(employee.empname, userdetails.name) as name,
            COALESCE(employee.empemail, userdetails.email) as email
        FROM schedule 
        LEFT JOIN employee ON schedule.empid = employee.empid 
        LEFT JOIN userdetails ON schedule.empid = userdetails.id 
        WHERE schedule.title = '$titleForQuery'";
            $result12= $connection->query($sqlmain12);
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup" style="width: 70%;">
                    <center>
                        <h2></h2>
                        <a class="close" href="schedule.php">&times;</a>
                        <div class="content">
                            
                            
                        </div>
                        <div class="abc scroll" style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            
                            <tr>
                                
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Event Title: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$title.'<br><br>
                                </td>
                                
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Member(s) for this session: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$empname.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">Scheduled Date: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$scheduledate.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Scheduled Time: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$scheduletime.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label"><b>Staff that are registered for this event:</b> (' . ($result12->num_rows) . ')</label>
                                    <br><br>
                                </td>
                            </tr>

                            
                            <tr>
                            <td colspan="4">
                                <center>
                                 <div class="abc scroll">
                                 <table width="100%" class="sub-table scrolldown" border="0">
                                 <thead>
                                 <tr>   
                                        <th class="table-headin">
                                             Member ID
                                         </th>
                                         <th class="table-headin">
                                             Member name
                                         </th>
                                         <th class="table-headin">
                                             
                                             Event ID
                                             
                                         </th>
                                        
                                         
                                         <th class="table-headin">
                                             Member Email
                                         </th>
                                         
                                 </thead>
                                 <tbody>';
                                 
                
                
                                         
                                         $statresult= $connection->query($sqlmain12);
                
                                         if($statresult->num_rows==0){
                                             echo '<tr>
                                             <td colspan="7">
                                             <br><br><br><br>
                                             <center>
                                             <img src="../img/company-enterprise-icon.svg" width="25%">
                                             
                                             <br>
                                             <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)"> No events  have been found to be booked !</p>
                                             <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                             </a>
                                             </center>
                                             <br><br><br><br>
                                             </td>
                                             </tr>';
                                             
                                         }
                                         else{
                                     
                                         for ( $x=0; $x<$statresult->num_rows;$x++){
                                             $row=$statresult->fetch_assoc();
                                             
                                             $empid=$row["empid"];
                                             $empname=$row["name"];
                                             $empemail=$row["email"];
                                             
                                             echo '<tr style="text-align:center;">
                                                <td>
                                                '.substr($empid,0,15).'
                                                </td>
                                                 <td style="font-weight:600;padding:25px">'.
                                                 
                                                 substr($empname,0,25)
                                                 .'</td >
                                                 <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                                 '.$scheduleid.'
                                                 
                                                 </td>
                                                 <td>
                                                 '.substr($empemail,0,25).'
                                                 </td>
                                                 
                                                 
                
                                                 
                                             </tr>';
                                             
                                         }
                                     }
                                          
                                     
                
                                    echo '</tbody>
                
                                 </table>
                                 </div>
                                 </center>
                            </td> 
                         </tr>

                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';  
    }
}
        
    ?>
    </div>


</body>
</html>