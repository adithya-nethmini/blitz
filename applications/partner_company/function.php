
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


function registerCompany($companyname, $companyemail, $pcompanycon, $companyaddress, $industry, $username, $password, $repassword){
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

	$stmt = $mysqli->prepare("INSERT INTO login(username, password, user_type) VALUES(?,?,'partner_company_admin')");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            echo 'error: ' . $mysqli->error;
        }else{
            echo 'success';
		}

	$stmt = $mysqli->prepare("INSERT INTO partner_company(companyname, companyemail, pcompanycon, companyaddress, industry, username, password) VALUES(?,?,?,?,?,?,?)");
	
	$stmt->bind_param("sssssss", $companyname, $companyemail, $pcompanycon, $companyaddress, $industry, $username, $hashed_password);
	$stmt->execute();
	if($stmt->affected_rows != 1){
		echo 'error: ' . $mysqli->error;
	}else{
		 $_SESSION["user"] = $username; 
		header("location: login.php");
		exit();
	}

}

function package_basic($amount, $companyname, $partnership_period, $package_type, $ads_space){
	$mysqli = connect();
	$stmt = $mysqli->prepare("INSERT INTO package(amount,partnership_period,package_type,ads_space,username) VALUES('7','3','3 Loyality offers','5-10% off from the original amount',?)");
			header("location: signup.php");
			exit();
}

function package_premium($amount, $companyname, $partnership_period, $package_type, $ads_space, $username){
	$mysqli = connect();
		$stmt = $mysqli->prepare("INSERT INTO package(amount,partnership_period,package_type,ads_space,username) VALUES('14','3 months','6 Loyality offers','10-15% off from the original amount',?)");
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$result = $stmt->get_result();
		$data = $result->fetch_assoc();

		if($data == NULL){
			return "Wrong username or password";
		}
		else{
			header("location: signup.php");
			exit();
		}
}

function package_premiumplus($amount, $companyname, $partnership_period, $package_type, $ads_space, $username){
	$mysqli = connect();
	$stmt = $mysqli->prepare("INSERT INTO packages(amount,partnership_period,package_type,ads_space,username) VALUES('30','6 months','15 Loyality offers','15-20% off from the original amount',?)");
		$stmt->bind_param("s", $username);
		$stmt->execute();
			if($stmt->affected_rows != 1){
				return "hey! An error occurred. Please try again";
			}else{
				echo '';
			}
}

function package_custom($amount, $companyname, $partnership_period, $package_type, $ads_space, $username){
	$mysqli = connect();
	$stmt = $mysqli->prepare("INSERT INTO packages(amount,partnership_period,package_type,ads_space,username) VALUES(?,?,?,?,?)");
		$stmt->bind_param("s", $username);
		$stmt->execute();
			if($stmt->affected_rows != 1){
				return "hey! An error occurred. Please try again";
			}else{
					echo '';
			}
}		

function loginUser($username, $password){
	$mysqli = connect();
	$username = trim($username);
	$password = trim($password);
	
	if($username == "" || $password == ""){
		return "All fields are required";
	}

	$username = filter_var($username, FILTER_SANITIZE_STRING);
	$password = filter_var($password, FILTER_SANITIZE_STRING);
		  
	$sql = "SELECT username, password, user_type FROM login WHERE username = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$result = $stmt->get_result();
	$data = $result->fetch_assoc();

	$userType = $data['user_type'];

	if($data == NULL){
		return "Wrong username or password";
	}
	if(password_verify($password, $data["password"]) == FALSE){
		return "Wrong username or password";
	}
			switch ($userType) {
				case "employee":
				$_SESSION['user'] = $username;
				header('location: index.php');
				  break;
				case "company_admin":
					$_SESSION['cadmin_user'] = $username;
					header('location: partner_profile.php');
				  break;
				case "partner_company_admin":
					$_SESSION['padmin_user'] = $username;
					header('location: partner-profile.php');
				  break;
				}
			}

function selectRadio($signup_Option){
	if(isset($_POST['signup-option'])){
		$signup_Option = $_POST['signup-option'];
		if($signup_Option == "Employee"){
			header("location: signup.php");
		}else{
			header("location: packages.php");
		}}}

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



// Below function will convert datetime to time elapsed string.
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if (isset($_GET['companyname'])) {
// Page ID needs to exist, this is used to determine which reviews are for which page.
if (isset($_GET['companyname'])) {
    if (isset($_POST['name'], $_POST['rating'], $_POST['content'])) {
        // Insert a new review (user submitted form)
        $stmt = $pdo->prepare('INSERT INTO review (companyname, employee, content, rating, submit_date) VALUES (?,?,?,?,NOW())');
        $stmt->execute([$_GET['companyname'], $_POST['employee'], $_POST['content'], $_POST['rating']]);
        exit('Your review has been submitted!');
    }
    // Get all reviews by the Page ID ordered by the submit date
    $stmt = $pdo->prepare('SELECT * FROM review WHERE companyname = ? ORDER BY submit_date DESC');
    $stmt->execute([$_GET['companyname']]);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Get the overall rating and total amount of reviews
    $stmt = $pdo->prepare('SELECT AVG(rating) AS overall_rating, COUNT(*) AS total_reviews FROM review WHERE companyname = ?');
    $stmt->execute([$_GET['companyname']]);
    $reviews_info = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    exit('Please provide the company name.');
} 
}

if (isset($_POST['employee'], $_POST['rating'], $_POST['content'])) {
    // Insert a new review (user submitted form)
    $stmt = $pdo->prepare('INSERT INTO review (companyname, employee, content, rating, submit_date) VALUES (?,?,?,?,NOW())');
    $stmt->execute([$_GET['companyname'], $_POST['employee'], $_POST['content'], $_POST['rating']]);
    exit('Your review has been submitted!');
}



?>



