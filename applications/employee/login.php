<?php 

    require("../function/function.php");
    if(isset($_POST['submit'])){
        $response = loginUser($_POST['username'], $_POST['password']);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="../../views/css/login.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</head>
<body class="body-g_signup">
    <header class="header-signup">
        <div class="wrapper-signup">
            <div class="div-logo">
                <img class="blitz-logo" src="../../views/images/Blitz - Logo.png">
            </div>
            <div class="signup-container"> <!-- container -->

                <div class="inner-container">
                    <h1>LOGIN</h1>
                    <form action="" method="POST" autocomplete="off"> 
                        
                        <p class="error"><strong><?php echo @$response; ?></strong></p>
                        
                        <div>
                            <label for="">USERNAME</label>
                            <input type="text" name="username" placeholder="Username" value="<?php echo @$_POST['username']; ?>">
                        </div>
                        
                        <div>
                            <label for="">PASSWORD</label>
                            <input type="password" name="password" placeholder="Password" value="<?php echo @$_POST['password']; ?>">
                        </div>

                        <div>
                            <a href="forgot-password.php"><strong>Forgot&nbsp;Password?</strong></a>
                        </div>

                        <div class="button-container">
                            <button class="login" type= "submit" name="submit"><strong>Login</strong></button>
                            <button class="cancel" type= "reset" name="reset"><strong>Cancel</strong></button>
                        </div>

                        <div>
                            <p>Don't Have an Account yet?&nbsp;
                            <a href="../g_signup.php"><strong>Register&nbsp;Here</strong></a></p>
                        </div>

                    </form>                    
                </div>

                <!-- <div class="heading">
                    <h1>Signup As a,</h1>
                </div>

                <form action="" method="post">
                <div class="content">
                    <input type="radio" id="employee" name="signup-option" value="Employee">
                    <label for="employee">As an employee</label><br>
                    <input type="radio" id="company" name="signup-option" value="Company">
                    <label for="company">As a Partner Company</label>
                </div>
                <div class="div-g_signup-btn-go">
                    <button class="g_signup-btn-go" type= "submit" name="submit"><strong><i class='fa fa-arrow-right'></i> Go</strong></button>
                </div>
                </form> -->
            </div>
        </div>
    </header>
    

</body>
</html>