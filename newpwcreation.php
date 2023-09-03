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

                    <h2>ENTER YOUR NEW PASSWORD</h2>
                    <p>Please enter your new password</p>
                        
                        <?php

                        $selectortoken = $_GET["selector"];
                        $tokenvalidator = $_GET["validator"];

                        if (empty($selectortoken) || empty($tokenvalidator)) {
                            echo "Request could not be validated!";
                        } else {
                            if (ctype_xdigit($selectortoken) !== false && ctype_xdigit($tokenvalidator) !==false) {
                                ?>

                                <form action="connection/newpwcreation-con.php" method="post">
                                <input type="hidden" name="selector" class="box-input" value="<?php echo $selectortoken ?>">
                                <input type="hidden" name="validator" class="box-input" value="<?php echo $tokenvalidator ?>">
            
                                <input type="Password" name="newpw" class="box-input" placeholder="Enter your new password" required>
                                <input type="Password" name="repeat-newpw" class="box-input" placeholder="Repeat your new password" required>
                                <button type="submit" name="resetconfirm" class="confirm-btn">Reset your password</button>
                            </form>
                            <?php

                            }
                        }

                        ?>
    
                    
                   
                </div>
                
                
                



            </div>
        </div>


    </div>
    


</body>
</html>