
    <?php
    
    

    //database connection
    include("../connection/database-con.php");



    if($_POST){
        //print_r($_POST);
        $statresult= $connection->query("select * from userdetails");
        $name=$_POST['name'];
       
        $oldemail=$_POST["oldemail"];
        $address=$_POST['address'];
        $email=$_POST['email'];
        
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        if ($password==$cpassword){
            $error='3';

            $sqlstate= "select customer.customerid from customer inner join userdetails on customer.cemail=userdetails.email where userdetails.email=?;";
            $stmt = $connection->prepare($sqlstate);
            $stmt->bind_param("s",$email);
            $stmt->execute();
            $statresult = $stmt->get_result();
            
            if($statresult->num_rows==1){
                $id2=$statresult->fetch_assoc()["customerid"];
            }else{
                $id2=$id;
            }
            

            if($id2!=$id){
                $error='1';
               
                    
            }else{

                
                $sql1="update customer set cemail='$email',customname='$name',custpassword='$password' where customerid=$id ;";
                $connection->query($sql1);
                echo $sql1;
                $sql1="update userdetails set email='$email' where email='$oldemail' ;";
                $connection->query($sql1);
                echo $sql1;
                
                $error= '4';
                
            }
            
        }else{
            $error='2';
        }
    
    
        
        
    }else{
        //header('location: signup.php');
        $error='3';
    }
    

    header("location: settings.php?action=edit&error=".$error."&id=".$id);
    ?>
    
   

</body>
</html>