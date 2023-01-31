<?php

    include ("function.php");
    if(isset($_POST['submit'])){
        $response = registerCompany($_POST['companyname'],$_POST['companyemail'],$_POST['pcompanycon'],@$_POST['companyaddress'],$_POST['industry'],@$_POST['scale'],@$_POST['username'],$_POST['password'],@$_POST['repassword']);
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <title>Registration</title>
</head>
<body>
    <div class="logo">
		<img src="logo-blue.png" alt="logo">
	</div>
   

    

    <div class="signup_box">
    <form action="" method="post" autocomplete="off">
    <h1>Signup to Blitz</h1>
        
            <label>Company Name</label><br>
            <input type="text" name="companyname" value="<?php echo @$_POST['companyname']; ?>"><br>
        
            <label>Company Email</label><br>
            <input type="email" name="companyemail" value="<?php echo @$_POST['companyemail']; ?>"><br>
        
            <label>Contact Number</label><br>
            <input type="text" name="pcompanycon" value="<?php echo @$_POST['pcompanycon']; ?>"><br>
        
            <label>Company Address</label><br>
            <input type="text" name="companyaddress" value="<?php echo @$_POST['companyaddress']; ?>"><br>
        
            <label>Industry Category</label><br>
            <input type="text" name="industry" value="<?php echo @$_POST['industry']; ?>"><br>
        
            <label>Scale</label><br>
            <select name="type" id="type" value="<?php echo @$_POST['scale']; ?>">
                <option value="Large"><b>Large</b> (more than 300 employees)</option>
                <option value="Medium"><b>Medium</b> (50-300 employees)</option>
                <option value="Small"><b>Small</b> (0-50 employees)</option>
            </select><br>
       
            <label>Username</label><br>
            <input type="text" name="username" value="<?php echo @$_POST['username']; ?>"><br>
        
            <label>Password</label><br>
            <input type="password" name="password" value="<?php echo @$_POST['password']; ?>"><br>
       
            <label>Confirm Password</label><br>
            <input type="password" name="repassword" value="<?php echo @$_POST['repassword']; ?>"><br>
        
        <button type= "submit" name="submit" id="btn1">Register</button>
        <button type= "cancel" name="cancel" id="btn2">Cancel</button>
        <p>
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

        <?php if(@$response == "success") { ?>

            <p class="success">Your registration was successful</p>

            <?php }else{ ?>
                <p class="error"><?php echo @$response; ?></p>
        
        <?php } ?>

    </form>
    </div>

</body>
</html>