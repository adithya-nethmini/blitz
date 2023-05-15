<?php 
	require "config.php";

	function connect(){
		$mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);
		if($mysqli->connect_errno != 0){
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

//	function registerUser($employeeid, $username, $email, $password, $confirm_password){
//		$mysqli = connect();
//		$args = func_get_args();
//
//		$args = array_map(function($value){
//			return trim($value);
//		}, $args);
//
//		foreach ($args as $value) {
//			if(empty($value)){
//				return "All fields are required";
//			}
//		}
//
//		foreach ($args as $value) {
//			if(preg_match("/([<|>])/", $value)){
//				return "<> characters are not allowed";
//			}
//		}
//
//		$stmt = $mysqli->prepare("SELECT employeeid FROM kpi_manager WHERE employeeid = ?");
//		$stmt->bind_param("s", $employeeid);
//		$stmt->execute();
//		$result = $stmt->get_result();
//		$data = $result->fetch_assoc();
//		if($data != NULL){
//			return "Employee ID already exists";
//		}
//
//		if(strlen($username) > 100){
//			return "Username is to long";
//		}
//
//		$stmt = $mysqli->prepare("SELECT username FROM kpi_manager WHERE username = ?");
//		$stmt->bind_param("s", $username);
//		$stmt->execute();
//		$result = $stmt->get_result();
//		$data = $result->fetch_assoc();
//		if($data != NULL){
//			return "Username already exists, please use a different username";
//		}
//
//		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
//			return "Email is not valid";
//		}
//		$stmt = $mysqli->prepare("SELECT email FROM kpi_manager WHERE email = ?");
//		$stmt->bind_param("s", $email);
//		$stmt->execute();
//		$result = $stmt->get_result();
//		$data = $result->fetch_assoc();
//		if($data != NULL){
//			return "Email already exists, please use a different email";
//		}
//
//		if(strlen($password) > 255){
//			return "Password is too long";
//		}
//
//		if($password != $confirm_password){
//			return "Passwords don't match";
//		}
//
//		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
//
//		$stmt = $mysqli->prepare("INSERT INTO kpi_manager (username, password, employeeid, email) VALUES(?,?,?,?)");
//		$stmt->bind_param("ssss", $username, $hashed_password, $employeeid, $email);
//		$stmt->execute();
//		if($stmt->affected_rows != 1){
//			return "An error occurred. Please try again";
//		}else{
//			header("location: login.php");
//		}
//	}

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
            header('location: ../../index.php');
            break;
        case "company_admin":
            $_SESSION['cadmin_user'] = $username;
            header('location: ../company_admin/Dash.php');
            break;
        case "Dept_head":
            $_SESSION['dept_user'] = $username;
            header('location: ../department_head/dashboard.php');
            break;
        case "partner_company_admin":
            $_SESSION['padmin_user'] = $username;
            header('location: ../partner_company/partner-profile.php');
            break;
        default:
            echo 'error';
    }
}
