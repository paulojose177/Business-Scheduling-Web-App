<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="formcontainer">
        <div class="box">
            <div class="innerbox" id="box">
                <div class="box-front">

                    <h2>RESET YOUR ACCOUNT</h2>
                    <p>You'll be receiving an email containing instructions that will enable you to reset your password.</p>
                    <form action="connection/resetrequest-con.php" method="post">
                        <input type="Email" name ="email" class="box-input" placeholder="Enter your email"
                        required>
                        <button type="submit" name="resetconfirm" class="confirm-btn">Receive email containing temp password</button>
                        
    
                    </form>
                    <?php
                    if (isset($_GET["pwreset"])) {
                        if ($_GET["pwreset"] == "resetsuccess") {
                            echo '<p class="registersuccess">Please check your email!</p>';
                        }
                    }

                    ?>
                  

                </div>
                
                
                



            </div>
        </div>


    </div>
    


</body>
</html>