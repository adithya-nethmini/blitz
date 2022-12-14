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
    <title>Log In</title>
    <link rel="stylesheet" href="../../views/css/login.css">
</head>
<body>
    <div class="outer-container">
        <div>
            <header>
            <h1>Welcome Back</h1>
            </header>
        </div>
        <div class="container" style="--clr:#004AAD">
            <form action="" method="post" autocomplete="off">

            <div class="heading">
                <div>
                    <h2>Log In</h2>
                </div>
                <div>
                <img class="logo" src="../../views/images/Blitz - Logo.png" alt="Blitz-Logo">
                </div>
            </div>

            <p class="error"><strong><?php echo @$response; ?></strong></p>

            <div class="content">
                
                <div class="input-box">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username" value="<?php echo @$_POST['username']; ?>">
                </div>

                <div class="input-box">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password" value="<?php echo @$_POST['password']; ?>">
                </div>

            </div>

            <div class="login-bottom">
                <input class="login-checkbox" type="checkbox" id="remember_me" name="remember_me" value="remember_me">
                <label for="remember_me">Remember Me</label><t></t>
                <a href="forgot-password.php"><strong>Forgot Password?<strong></a>
            </div>

            <div class="button-container">
                <button style="--clr:#004AAD" type= "submit" name="submit"><strong>Login</strong></button>
            </div>

            <p>
                Don't have an account?
                <a href="../g_signup.php" class="register-here" style="--clr:#F8C000"><strong>Register here<strong></a>
            </p>

            </form> 
        </div>
    </div>
</body>
</html>