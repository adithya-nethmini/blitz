
<?php

include "config.php";

function connect(){
	$mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
	if($mysqli->connect_error != 0){
		$error = $mysqli->connect_error;
		$error_date = date("F j, Y, g:i a");
		$message = "{$error} | {$error_date} \r\n";
		file_put_contents("db-log.txt", $message, FILE_APPEND);
		return false;
	}else{
		$mysqli->set_charset("utf8mb4");
		return $mysqli;
	}
}



function registerCompany($companyname, $companyemail, $pcompanycon, $companyaddress, $industry, $scale, $username, $password, $repassword){
	$mysqli = connect();
	$args = func_get_args();
	
	$args = array_map(function($value){
		return trim($value);
	}, $args);

	foreach ($args as $value){
		if(empty($value)){
			return "All fields are required";
		}
	}

	foreach ($args as $value){
		if(preg_match("/([<|>])/", $value)){
			return "<> characters are not allowed";
		}
	}

	if(!filter_var($companyemail, FILTER_VALIDATE_EMAIL)){
		return "Sorry! Email is not valid";
	}



	if(strlen($username) > 50){
		return "Username is too long";
	}

	$stmt = $mysqli->prepare("SELECT companyname FROM partner_company WHERE companyname = ?");
	$stmt->bind_param("s", $companyname);
	$stmt->execute();
	$result = $stmt->get_result();
	$data = $result->fetch_assoc();
	if($data != NULL){
		return "Company Name already exists, please use a different Company Name";
	}
	
	$stmt = $mysqli->prepare("SELECT companyemail FROM partner_company WHERE companyemail = ?");
	$stmt->bind_param("s", $companyemail);
	$stmt->execute();
	$result = $stmt->get_result();
	$data = $result->fetch_assoc();
	if($data != NULL){
		return "Email address already exists, please use a different email address";
	}

	if(strlen($password) > 50){
		return "Password is too long";
	}
	if(strlen($pcompanycon) > 10){
		return "Invalid contact numbefr";
	}

	if($password != $repassword){
		return "Passwords don't match";
	}

	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	$stmt = $mysqli->prepare("INSERT INTO partner_company(companyname, companyemail, pcompanycon, companyaddress, industry, scale, username, password) VALUES(?,?,?,?,?,?,?,?)");
	
	$stmt->bind_param("ssssssss", $companyname, $companyemail, $pcompanycon, $companyaddress, $industry, $scale, $username, $hashed_password);
	$stmt->execute();
	if($stmt->affected_rows != 1){
		return "An error occurred. Please try again";
	}else{
		 $_SESSION["user"] = $username; 
		header("location: login.php");
		exit();
	}

}

function loginUser($username, $password){
	$mysqli = connect();
	$username = trim($username);
	$password = trim($password);
	
	if( $username == "" || $password == ""){
		return "All fields are required";
	}

	$username = filter_var($username, FILTER_SANITIZE_STRING);
	$password = filter_var($password, FILTER_SANITIZE_STRING);

	$sql = "SELECT username, password FROM partner_company WHERE username = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	$data = $result->fetch_assoc();

	if($data == NULL){
		return "Wrong username or password";
	}

	 if(password_verify($password, $data["password"]) == FALSE){
		return "Wrong username or password";
	} else{
		$_SESSION["user"] = $username;
		header("location: offers-promotions.php");
		exit();
	}
}

function logoutUser(){

	session_destroy();
	header("location: login.php");
	exit();

}

function addpromo($type, $name, $date, $description, $promotion_cover){

	$mysqli = connect();
	$args = func_get_args();
	
	$args = array_map(function($value){
		return trim($value);
	}, $args);

	foreach ($args as $value){
		if(empty($value)){
			return "All fields are required";
		}
	}

	foreach ($args as $value){
		if(preg_match("/([<|>])/", $value)){
			return "<> characters are not allowed";
		}
	}

	$stmt = $mysqli->prepare("INSERT INTO promotions(type, name, date, description, promotion_cover) VALUES(?,?,?,?,?)");
	$stmt->bind_param("sssss", $type, $name, $date, $description, $promotion_cover);
	$stmt->execute();
	if($stmt->affected_rows != 1){
		return "An error occurred. Please try again";
		header("location: add-promo.php");
	}else{
		$_SESSION["add"] = "Promotion added successfully";
		header("location: offers-promotions.php");
		exit();
	}

}

function addoffer($offer_cover, $type, $name, $date, $amount){

	$mysqli = connect();
	$args = func_get_args();
	
	$args = array_map(function($value){
		return trim($value);
	}, $args);

	foreach ($args as $value){
		if(empty($value)){
			return "All fields are required";
		}
	}

	foreach ($args as $value){
		if(preg_match("/([<|>])/", $value)){
			return "<> characters are not allowed";
		}
	}

	$stmt = $mysqli->prepare("INSERT INTO offers(offer_cover, type, name, date, amount) VALUES(?,?,?,?,?)");
	$stmt->bind_param("sssss", $offer_cover, $type, $name, $date, $amount);
	$stmt->execute();
	if($stmt->affected_rows != 1){
		return "An error occurred. Please try again";
		header("location: add-offer.php");
	}else{
		$_SESSION["add"] = "Offer added successfully";
		header("location: offers-promotions.php");
		exit();
	}

}
?>
