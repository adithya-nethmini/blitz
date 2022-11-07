<?php

    include ("../function/function.php");
    if(isset($_POST['submit'])){
        $response = registerUser($_POST['name'],$_POST['employeeid'],$_POST['department'],$_POST['jobrole'],$_POST['email'],$_POST['contactno'],$_POST['address'],$_POST['jobstartdate'],$_POST['username'],$_POST['password'],$_POST['conpassword']);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>

    <form action="" method="post" autocomplete="off">

    <h2>Registration</h2>

    <div class="grid">

        <div>
            <label>Full Name</label>
            <input type="text" name="name" value="<?php echo @$_POST['name']; ?>">
        </div>
        
        <div>
            <label>Employee ID</label>
            <input type="text" name="employeeid" value="<?php echo @$_POST['employeeid']; ?>">
        </div>
        
        <div>
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
        
        <div>
            <label>Job Role</label>
            <select name="jobrole">
                    <option value="Insurance Agent">Insurance Agent</option>
                    <option value="Actuary">Actuary</option>
                    <option value="Claims Adjuster">Claims Adjuster</option>
                    <option value="Insurance Underwriter">Insurance Underwriter</option>
                </select> 
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo @$_POST['email']; ?>">
        </div>
        
        <div>
            <label>Contact Number</label>
            <input type="text" name="contactno" value="<?php echo @$_POST['contactno']; ?>">
        </div>

        <div>
            <label>Address</label>
            <input type="text" name="address" value="<?php echo @$_POST['address']; ?>">
        </div>
        
        <div>
            <label>Job Start Date</label>
            <input type="date" name="jobstartdate" value="<?php echo @$_POST['jobstartdate']; ?>">
        </div>
        
        <div>
            <label>Username</label>
            <input type="text" name="username" value="<?php echo @$_POST['username']; ?>">
        </div>
        
        

        <div>
            <label>Password</label>
            <input type="password" name="password" value="<?php echo @$_POST['password']; ?>">
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="conpassword" value="<?php echo @$_POST['conpassword']; ?>">
        </div>

    </div>

        <button type= "submit" name="submit">Register</button>

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

</body>
</html>