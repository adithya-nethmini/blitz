<?php 

    require("function.php");
    if(isset($_POST['submit'])){
        $response = loginUser($_POST['employeeid'],$_POST['username'], $_POST['password']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="" method="post" autocomplete="off">

        <h2>LOG IN</h2>

        <div class="grid">

            <div>
                <label>Employee ID</label>
                <input type="text" name="employeeid" value="<?php echo @$_POST['employeeid']; ?>">
            </div>
            
            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?php echo @$_POST['username']; ?>">
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" value="<?php echo @$_POST['password']; ?>">
            </div>

        </div>

        <button type="submit" name="submit">LOGIN</button>

        <p>
            Don't have an account?
            <a href="signup.php">Register here</a>
        </p>

        <p class="error"><?php echo @$response; ?></p>

    </form>
</body>
</html>