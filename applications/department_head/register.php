<?php 
	require "functions.php";
	if(isset($_POST['submit'])){
		$response = registerUser($_POST['employeeid'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirmPassword']);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styleregister.css">
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
	<title>KPI Manager Register</title>
</head>
<body>
	<div class="header">
        <img src="blitzi.png" alt="logo" />
    </div>
    <div class="main">
		<div class="box1">
			<div class="pic">
				<img src="4.png" alt="pic" />
			</div>
		</div>
		<form action="" class="box" method="post" autocomplete="off">	
		<h1>Sign Up</h1>
				<div class="employeeid">
					<input type="text" name="employeeid" id="employeeid" placeholder="Enter Employee ID" value="<?php echo @$_POST['employeeid']; ?>">
					<i class="fa-regular fa-id-card"></i> 
				</div>

				<div class="email">
					<input type="text" name="email" id="email" placeholder="Enter Email" value="<?php echo @$_POST['email']; ?>">
					<i class="fa-solid fa-at"></i>
				</div>

				<div class="username">
					<input type="text" name="username" id="username" placeholder="Enter Username" value="<?php echo @$_POST['username']; ?>">
					<i class="fa-solid fa-circle-user"></i>  
				</div>

				<div class="password">
					<input type="password" name="password" id="password" placeholder="Enter Password" value="<?php echo @$_POST['password']; ?>">
					<i class="fa-solid fa-lock-open"></i>
				</div>

                <div class="password">
					<input type="password" name="confirmPassword" id="confirmPassword" placeholder="Re-Enter Password" value="<?php echo @$_POST['confirmPassword']; ?>">
					<i class="fa-solid fa-lock-open"></i>
				</div>
			
			<button type="submit" id="btn" name="submit"><b>Register</b></button>

			<p class="error"><?php echo @$response; ?></p>
		</form>
	</div>
</body>
</html>
