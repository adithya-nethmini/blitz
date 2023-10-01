<?php

    include ("function.php");
    if(isset($_POST['submit'])){
        $response = registerCompany($_POST['companyname'],$_POST['companyemail'],$_POST['pcompanycon'],@$_POST['companyaddress'],$_POST['industry'],@$_POST['username'],@$_POST['repassword'], $_POST['password'],@$_POST['package'],@$_POST['user_type']);
    }
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signup.css">
    <title>Registration</title>
</head>
<body>
    <div class="logo">
		<img src="images/logo-blue.png" alt="logo">
	</div>
   

    

    <div class="signup_box">
    <form action="" method="post" >
    <h1>Signup to Blitz</h1>
        
            <label>Company Name</label><br>
            <input type="text" name="companyname" value="<?php echo @$_POST['companyname']; ?>"><br>
        
            <label>Company Email</label><br>
            <input type="email" name="companyemail" value="<?php echo @$_POST['companyemail']; ?>"><br>
        
            <label>Contact Number</label><br>
            <input type="text" name="pcompanycon" value="<?php echo @$_POST['pcompanycon']; ?>"><br>
        
            <label>Company Address</label><br>
            <input type="text" name="companyaddress" value="<?php echo @$_POST['companyaddress']; ?>"><br>

            <label><b>catagory</b></label><br>
            <select name="industry" id="industry" value="<?php echo @$_POST['industry']; ?>">
                <option value="">Select an option</option>
                <option value="super-market">Super Market</option>
                <option value="textile">Textile</option>
                <option value="pharmacy">Pharmacy</option>
            </select><br>
            <label><b>Partnership Package</b></label><br>
            <select name="package" id="package" value="<?php echo @$_POST['package']; ?>">
                <option value="">Select an option</option>
                <option value="basic">Basic</option>
                <option value="premium">Premium</option>
                <option value="premium-plus">Premium Plusy</option>
            </select><br>
       
            <label>Username</label><br>
            <input type="text" name="username" value="<?php echo @$_POST['username']; ?>"><br>
        
            <label>Password</label><br>
            <input type="password" name="password" value="<?php echo @$_POST['password']; ?>"><br>
       
            <label>Confirm Password</label><br>
            <input type="password" name="repassword" value="<?php echo @$_POST['repassword']; ?>"><br>

            <input type="hidden" name="user_type" value="employee">

        
        <button type= "submit" name="submit" id="btn1">Register</button>
        <button type= "cancel" name="cancel" id="btn2">Cancel</button>
        <p>
            Already have an account?
            <a href="../employee/login.php">Login here</a>
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