
<?php

include "config.php";

/* database connection starts here */

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

/* database connection ends here */
/*signup selection starts here */

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

/*signup selection ends here */
/* Register partner company starts here */

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

	$stmt = $mysqli->prepare("SELECT username FROM partner_company WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if($data != NULL){
            return "Username already exists, please use a different username";
        }

		$stmt = $mysqli->prepare("SELECT pcompanycon FROM partner_company WHERE pcompanycon = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if($data != NULL){
            return "Contact number already exists, please use a different contact number";
        }

	if(strlen($password) > 50){
		return "Password is too long";
	}
	if(strlen($pcompanycon) > 10){
		return "Invalid contact number";
	}
	if($password != $repassword){
		return "Passwords don't match";
	}

	$number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        
        if(strlen($password) < 8) {
            return "Password must be at least 8 characters in length.";
        }
        if(strlen($password) < !$number) {
            return "Password must contain at least one number.";
        }
        if(strlen($password) < !$uppercase) {
            return "Password must contain at least one upper case letter.";
        }
        if(strlen($password) < !$lowercase) {
            return "Password must contain at least one lower case letter.";
        }
        if(strlen($password) < !$specialChars) {
            return "Password must contain at least one special character.";
        }

	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	$stmt = $mysqli->prepare("INSERT INTO login(username, password, user_type) VALUES(?,?,'partner_company_admin')");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            return mysqli_error($mysqli);
        }else{
            echo 'success';
		}

	$stmt = $mysqli->prepare("INSERT INTO partner_company(companyname, companyemail, pcompanycon, companyaddress, industry, username, password) VALUES(?,?,?,?,?,?,?)");
	
	$stmt->bind_param("sssssss", $companyname, $companyemail, $pcompanycon, $companyaddress, $industry, $username, $hashed_password);
	$stmt->execute();
	if($stmt->affected_rows != 1){
		return "An error occurred. Please try again";
	}else{
		 $_SESSION["user"] = $username; 
		header("location: login.php");
		exit();
	}

}

/*register compaies: parnership packages starts here*/

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

/*register compaies: parnership packages ends here*/
/* Register partner company ends here */

/*partner comopany login starts here*/

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


/*add ad starts here*/

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

/*add ad ends here*/
/*add offer starts here*/

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

/*add offer ends here*/
/* Retrieving the offers/ads from the database starts here*/

function getOffers($partner_company) {
  // Modify the SQL query to filter results based on the logged-in partner company
  $query = "SELECT * FROM offers WHERE companyname = '$partner_company' AND start_date <= NOW() AND end_date >= NOW()";
  
  // Execute the query and retrieve the results
  // ...
}

// Call the function and retrieve the offers/ads
$offers = getOffers($_SESSION['partner_company']);

// Loop through the results and display them using HTML and CSS
foreach ($offers as $offer) {
  echo '<div class="offer">';
  echo '<h3>' . $offer['title'] . '</h3>';
  echo '<p>' . $offer['description'] . '</p>';
  echo '</div>';
}



/*convert datetime to time elapsed string starts here*/

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

/*convert datetime to time elapsed string ends here*/

?>



