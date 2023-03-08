<?php 
	require "functions.php";
	if(isset($_POST['submit'])){
		$response = loginUser($_POST['username'], $_POST['password']);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
	<title>KPI Manager Login</title>
</head>
<body>
	<div class="header">
        <img src="blitzi.png" alt="logo" />
    </div>
    <div class="main">
		<form action="" class="box" method="post" autocomplete="off">	
		<h1>Login</h1>

				<div class="username">
					<input type="text" name="username" id="username" placeholder="Enter Username" value="<?php echo @$_POST['username']; ?>">
					<i class="fa-solid fa-circle-user"></i>  
				</div>

				<div class="password">
					<input type="password" name="password" id="password" placeholder="Enter Password" value="<?php echo @$_POST['password']; ?>">
					<i class="fa-solid fa-lock-open"></i>
				</div>
			
			<button type="submit" id="btn" name="submit"><b>Login</b></button>
			<br>
			<p><a href="#">Forget Password?</a></p>
			<br>
			<p class="error"><?php echo $response; ?></p>
		</form>
	</div>
</body>
</html>
