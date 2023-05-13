<?php

require("applications/function/function.php");

if(isset($_SESSION["user"])){
	header("location: home.php");

	exit();
}

if(isset($_SESSION["cadmin_user"])){
	header("location: applications/company_admin/Dash.php");

	exit();
}

if(isset($_SESSION["dept_user"])){
	header("location: applications/department_head/dashboard.php");

	exit();
}

if(isset($_SESSION["padmin_user"])){
	header("location: applications/partner_company/partner-profile.php");

	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="views/css/styleforlanding.css">
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
</head>
    <body>
	<nav>
		<div class="logo">
			<img src="views/images/Blitz - Logo.png" alt="logo" />
		</div>
		<ul>    
			<li><a href="About.php">About</a></li>    
			<li><a href="help.php">Help</a></li>    
			<li><a href="applications/g_signup.php">Register</a></li>    
			<li><a href="applications/login.php">Login</a></li>    
		</ul>
	</nav>
	<br></br>
    <div class="word">
	We appreciate you for more than just your work. We also want to
	celebrate your character and the positive effect you have on others.
	<br>
    </br>
	Warmly welcome to the rewarding space for your contribution towards us!
	<br>
	<br>
	<br>
	<a href="../g_signup.php">Get Started<i class="fa-sharp fa-solid fa-arrow-right"></i></a>
    </div>

</body>