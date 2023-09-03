
    <?php
    
    session_start();

    //database connection
    include("../connection/database-con.php");
    include("../connection/function-con.php");



    if($_POST){
        //print_r($_POST);
        $statresult= $connection->query("select * from userdetails");
        $name=$_POST['name'];
        
        $oldemail=$_POST["oldemail"];
        $jobpos=$_POST['spec'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        if ($password==$cpassword){
            $passwordError = passwordstrength($password);
            if ($passwordError !== false){
                $error = '5';
            } else {
                $error='3';
                $statresult= $connection->query("select employee.empid from employee inner join userdetails on employee.empemail=userdetails.email where userdetails.email='$email';");
                if($statresult->num_rows==1){
                    $id2=$statresult->fetch_assoc()["empid"];
                }else{
                    $id2=$id;
                }
                
                if($id2!=$id){
                    $error='1';
                }else{
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Update employee and user details

                    $jobposition_id_query = "SELECT jobposition FROM employee WHERE empid='$id';";
                    $statresult = $connection->query($jobposition_id_query);
                    $row = $statresult->fetch_assoc();
                    $jobposition_id = $row["jobposition"];

                $update_jobtitle = "update jobposition SET jobtitle='$jobpos' WHERE id='$jobposition_id' ;";
                $connection->query($update_jobtitle);

                    
                    $sql1="update employee set empemail='$email',empname='$name',emppassword='$hashed_password', jobposition=$jobposition_id where empid='$id' ;";
                    $connection->query($sql1);
                    
                    $sql2 = "update userdetails set email='$email', name='$name', password='$hashed_password' WHERE email='$oldemail';";
                    $connection->query($sql2);
                    
                    $error= '4';
                }
            }
        }else{
            $error='2';
        }
    }else{
        $error='3';
    }
    

    header("location: employees.php?action=edit&error=".$error."&id=".$id);
    ?>
    
   

</body>
</html>