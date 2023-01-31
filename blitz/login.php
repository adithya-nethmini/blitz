<?php 
	require "function.php";
	if(isset($_POST['submit'])){
		$response = loginUser($_POST['username'], $_POST['password']);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/login.css">
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
	<title>Login</title>
</head>
<body>		
	<div class="logo">
		<img src="images/logo-blue.png" alt="logo">
	</div>

	<div class="login-box">
			<form action="" class="box" method="post" autocomplete="off">	
				<h1>Login</h1>
				<input type="text" name="username" id="username" placeholder="Username" value="<?php echo @$_POST['username']; ?>" autocomplete="off">
				<input type="password" name="password" id="password" placeholder="Password" value="<?php echo @$_POST['password']; ?>" autocomplete="new-password">
			
				<button type="submit" id="btn1" name="submit"><b>Login</b></button>
				<button type="cancel" id="btn2" name="cancel"><b>Cancel</b></button>
				<p>Haven't registered yet?<a href="signup.php">Sign-up here</a></p>
				<p class="error"><?php echo @$response; ?></p>
			</form>
	
	</div>
</body>
</html>
