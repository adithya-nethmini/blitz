
<?php
session_start();
define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'blitz');

function connect() {
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'blitz';
    
    $mysqli = new mysqli($hostname, $username, $password, $dbname);
    
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    
    return $mysqli;
}

function getPartnerCompanyID($mysqli, $username) {
    $query = "SELECT company_id FROM partner_company WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($companyID);
    $stmt->fetch();
    $stmt->close();

    return $companyID;
}

function checkCompanyName($mysqli, $companyname) {
    $stmt = $mysqli->prepare("SELECT companyname FROM partner_company WHERE companyname = ?");
    $stmt->bind_param("s", $companyname);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    
    return $count;
}

function checkContactNumber($mysqli, $pcompanycon) {
    $stmt = $mysqli->prepare("SELECT pcompanycon FROM partner_company WHERE pcompanycon = ?");
    $stmt->bind_param("s", $pcompanycon);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    
    return $count;
}

function addProfilePicture($mysqli, $username, $profilePicture) {
    $stmt = $mysqli->prepare("UPDATE partner_company SET pcompany_pic = ? WHERE username = ?");
    $stmt->bind_param("ss", $profilePicture, $username);
    $stmt->execute();
    $stmt->close();
}

// Example function:
function getPartnerCompanyDetails($mysqli, $username) {
    $stmt = $mysqli->prepare("SELECT companyname, companyemail, pcompanycon, companyaddress, description, pcompany_pic FROM partner_company WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($companyname, $companyemail, $pcompanycon, $companyaddress, $description, $pcompany_pic);
    
    // Fetch the results
    $stmt->fetch();
    
    // Create an associative array with the retrieved details
    $details = array(
        'companyname' => $companyname,
        'companyemail' => $companyemail,
        'pcompanycon' => $pcompanycon,
        'companyaddress' => $companyaddress,
        'description' => $description,
        'pcompany_pic' => $pcompany_pic
    );
    
    $stmt->close();
    
    return $details;
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
	header("location: ../../landingpage.php");
	exit();

}

/*signup selection ends here */
/* Register partner company starts here */

function registerCompany($companyname, $companyemail, $pcompanycon, $companyaddress, $industry, $username, $password, $repassword, $package, $user_type){
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

	$stmt = $mysqli->prepare("INSERT INTO partner_company(companyname, companyemail, pcompanycon, companyaddress, industry, username, password, package) VALUES(?,?,?,?,?,?,?,?)");
	
	$stmt->bind_param("ssssssss", $companyname, $companyemail, $pcompanycon, $companyaddress, $industry, $username, $hashed_password, $package);
	$stmt->execute();
	if($stmt->affected_rows != 1){
		return "An error occurred. Please try again";
	}else{
		 $_SESSION["user"] = $username; 
		header("location: ../../login.php");
		exit();
	}
}

/*register compaies: parnership packages starts here*/

// function package_basic($amount, $companyname, $partnership_period, $package_type, $ads_space){
// 	$mysqli = connect();
// 	$stmt = $mysqli->prepare("INSERT INTO package(amount,partnership_period,package_type,ads_space,username) VALUES('7','3','3 Loyality offers','5-10% off from the original amount',?)");
// 			header("location: signup.php");
// 			exit();
// }

// function package_premium($amount, $companyname, $partnership_period, $package_type, $ads_space, $username){
// 	$mysqli = connect();
// 		$stmt = $mysqli->prepare("INSERT INTO package(amount,partnership_period,package_type,ads_space,username) VALUES('14','3 months','6 Loyality offers','10-15% off from the original amount',?)");
// 			$stmt->bind_param("s", $username);
// 			$stmt->execute();
// 			$result = $stmt->get_result();
// 		$data = $result->fetch_assoc();

// 		if($data == NULL){
// 			return "Wrong username or password";
// 		}
// 		else{
// 			header("location: signup.php");
// 			exit();
// 		}
// }

// function package_premiumplus($amount, $companyname, $partnership_period, $package_type, $ads_space, $username){
// 	$mysqli = connect();
// 	$stmt = $mysqli->prepare("INSERT INTO packages(amount,partnership_period,package_type,ads_space,username) VALUES('30','6 months','15 Loyality offers','15-20% off from the original amount',?)");
// 		$stmt->bind_param("s", $username);
// 		$stmt->execute();
// 			if($stmt->affected_rows != 1){
// 				return "hey! An error occurred. Please try again";
// 			}else{
// 				echo '';
// 			}
// }

// function package_custom($amount, $companyname, $partnership_period, $package_type, $ads_space, $username){
// 	$mysqli = connect();
// 	$stmt = $mysqli->prepare("INSERT INTO packages(amount,partnership_period,package_type,ads_space,username) VALUES(?,?,?,?,?)");
// 		$stmt->bind_param("s", $username);
// 		$stmt->execute();
// 			if($stmt->affected_rows != 1){
// 				return "hey! An error occurred. Please try again";
// 			}else{
// 					echo '';
// 			}
// }		

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
				header('location: applications/employee/profile.php');
				  break;
				case "company_admin":
					$_SESSION['cadmin_user'] = $username;
					header('location: partner_profile.php');
				  break;
				case "partner_company_admin":
					$_SESSION['pcompany_user'] = $username;
					header('location: applications/partner_company/partner-profile.php');
				  break;
				}
			}

//iiiiiiiiiiiiiiiiiiii
// if (mysqli_num_rows($result) === 1) {
// 	$row = mysqli_fetch_assoc($result);
// 	$_SESSION['id'] = $row['company_id'];
// 	$_SESSION['name'] = $row['name'];

// 	switch ($row['user_role']) {
// 		case 'company_admin':
// 			header('location: partner-profile.php');
// 			break;
// 		case 'partner_company_admin':
// 			$sql_getcompanyid = "SELECT * FROM partner_company WHERE companyemail='$email'";
// 			$result_getcompanyid = mysqli_query($con,$sql_getcompanyid);
// 			$row_getcompanyid = mysqli_fetch_assoc($result_getcompanyid);

// 			$_SESSION['company_id'] = $row_getmomid['company_id'];

// 		header("location: partner-profile.php");
// 			header("location: partner-profile.php");
// 			break;
// 		case 'employee':
// 			header("Location: ../View/VOG/dashboardVog.php");
// 			break;
		
// 	}
// 	exit();
// } else {
// 	header("Location: Login.php?error=Incorrect User name or password");
// 	exit();
// }
//kkkkkkkkkkkkkkkkkkkkkkk
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
		header("location: company-feed.php");
		exit();
	}

}

/*add ad ends here*/
/*add offer starts here*/

function addoffer($offer_cover, $type, $name, $date, $amount, $company_name, $offer_code){

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

	$stmt = $mysqli->prepare("INSERT INTO offers(offer_cover, type, name, end_date, amount, username, offer_code) VALUES(?,?,?,?,?,?,?)");
	$stmt->bind_param("sssssss", $offer_cover, $type, $name, $date, $amount, $company_name, $offer_code);
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

//$response = addoffer($_POST['offer_cover'], $_POST['type'], $_POST['name'], $_POST['date'], $_POST['amount'], $_POST['promo_code']);

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


function get_reviews($companyname) {
    $mysqli = new mysqli("localhost", "username", "password", "database_name");

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    // Prepare the SQL statement
    $stmt = $mysqli->prepare("SELECT * FROM reviews WHERE company_name = ?");
    $stmt->bind_param("s", $companyname);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Create an array to store the reviews
    $reviews = array();

    // Loop through the result set and add each review to the array
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    // Close the statement and database connection
    $stmt->close();
    $mysqli->close();

    // Return the reviews array
    return $reviews;
}

// Function to update the feedback with the reply in the database
function updateFeedbackReply($mysqli, $feedbackId, $reply) {
    $sql = "UPDATE ratings_feedbacks SET reply = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("si", $reply, $feedbackId);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

// Function to retrieve feedbacks by partner company ID
function getFeedbacksByPartnerCompanyId($mysqli, $partnerCompanyId) {
    $sql = "SELECT * FROM ratings_feedbacks WHERE company_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $partnerCompanyId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}
?>