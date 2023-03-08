<?php

    include ("../function/function.php");
    if(isset($_POST['submit'])){
        $response = registerUser($_POST['employeeid'],$_POST['name'],$_POST['department'],$_POST['jobrole'],$_POST['email'],$_POST['contactno'],$_POST['address'],$_POST['jobstartdate'],$_POST['username'],$_POST['password'],$_POST['conpassword'],@$_POST['gender'],@$_POST['user_type']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../../views/css/signup.css">
</head>
<body class="body-g_signup">

    <header class="header-signup">
        <div  class="wrapper-signup">
            <div class="div-logo">
                <img class="blitz-logo" src="../../views/images/Blitz - Logo.png">
            </div>
            <div class="signup-container">
                <form action="" method="POST">
                    <div class="inner-container">
                    <h1 style="align-items:none">SIGNUP</h1>

                    <?php if(@$response == "success") { ?>

                    <strong><p class="success">Your registration was successful</p></strong>

                    <?php }else{ ?>
                        <strong><p class="error"><?php echo @$response; ?></p></strong>

                    <?php } ?>
                    
                    <div class="outer-inner">

                        <div class="inner-inner-left">
                            <div class="input-box">
                                <label>Full Name</label>
                                <input type="text" name="name" value="<?php echo @$_POST['name']; ?>">
                            </div>

                            <div class="input-box">
                                <label>Email</label>
                                <input type="email" name="email" value="<?php echo @$_POST['email']; ?>">
                            </div>
    
                            
                            
                            <div class="input-box">
                                <label>Employee ID</label>
                                <input type="text" name="employeeid" value="<?php echo @$_POST['employeeid']; ?>">
                            </div>
                            
                            <div class="input-box">
                                <label>Department</label>
                                <select name="department">
                                        <option value="Administration">Administration</option>
                                        <option value="Investment">Investment</option>
                                        <option value="Accounting">Accounting</option>
                                        <option value="Claims">Claims</option>
                                        <option value="Underwriting">Underwriting</option>
                                        <option value="Sales">Sales</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Actuarial">Actuarial</option>
                                        <option value="Customer Service">Customer Service</option>
                                    </select> 
                            </div>
                            
                            <div class="input-box">
                                <label>Job Role</label>
                                <select name="jobrole">
                                        <option value="Project Manager">Project Manager</option>
                                        <option value="Employee">Employee</option>
                                    </select> 
                            </div>
    
                            <div class="input-box">
                                <label>Job Start Date</label>
                                <input type="date" id="date" name="jobstartdate" max="<?php date("m/d/y")?>" value="<?php echo @$_POST['jobstartdate']; ?>">
                            </div>
                        </div>

                        <div class="inner-inner-right">
                            <div class="input-box">
                                <span class="gender-title">Gender</span>
                                <div class="gender-category">
                                    <input type="radio" name="gender" id="male" value="Male">
                                    <label for="male">Male</label>
                                    <input type="radio" name="gender" id="female" value="Female">
                                    <label for="female">female</label>
                                    <input type="radio" name="gender" id="other" value="other">
                                    <label for="other">Other</label>
                                </div>
                            </div>
                            
                            <div class="input-box">
                                <label>Contact Number</label>
                                <input type="text" name="contactno" value="<?php echo @$_POST['contactno']; ?>">
                            </div>
    
                            <div class="input-box">
                                <label>Location</label>
                                <input type="text" name="address" value="<?php echo @$_POST['address']; ?>">
                            </div>
                            
                            <div class="input-box">
                                <label>Username</label>
                                <input type="text" name="username" value="<?php echo @$_POST['username']; ?>">
                            </div>
    
                            <div class="input-box">
                                <label>Password</label>
                                <input type="password" name="password" value="<?php echo @$_POST['password']; ?>">
                            </div>
    
                            <div class="input-box">
                                <label>Confirm Password</label>
                                <input type="password" name="conpassword" value="<?php echo @$_POST['conpassword']; ?>">
                            </div>
    
                            <div>
                                <input type="hidden" name="user_type" value="employee">
                            </div>
                        </div>
                    </div>


                        <div class="alert">
                            <p>By clicking Register, you agree to our<strong> <a href="#">Terms</a>, <a href="#">Privacy policy.</a></strong> You may receive notifications from us.</p>
                        </div>

                        <div class="button-container">
                            <button class="signup" type= "submit" name="submit"><strong>Register</strong></button>
                            <button class="cancel" type= "reset" name="reset"><strong>Cancel</strong></button>
                        </div>

                        <div class="login-here">
                            <p>Already have an account?
                            <a href="login.php" class="login-here"><strong>Login here<strong></a>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </header>

</body>

<script>
    document.getElementById("date").max = new Date().getFullYear() + "-" +  parseInt(new Date().getMonth() + 1 ) + "-" + new Date().getDate()
</script>

</html>