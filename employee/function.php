<?php

    require "../config.php";

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

    function registerUser($name, $employeeid, $department, $jobrole, $email, $contactno, $address, $jobstartdate, $username, $password, $conpassword){
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

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return "Sorry! Email is not valid";
        }

        $stmt = $mysqli->prepare("SELECT employeeid FROM employee WHERE employeeid = ?");
        $stmt->bind_param("s", $employeeid);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if($data != NULL){
            return "Employee ID already exists. Please enter your employee id";
        }
        
        $stmt = $mysqli->prepare("SELECT email FROM employee WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if($data != NULL){
            return "Email already exists, please use a different email";
        }

        if(strlen($username) > 50){
            return "Username is too long";
        }

        $stmt = $mysqli->prepare("SELECT username FROM employee WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if($data != NULL){
            return "Username already exists, please use a different username";
        }
        
        $stmt = $mysqli->prepare("SELECT contactno FROM employee WHERE contactno = ?");
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

        if($password != $conpassword){
            return "Passwords don't match";
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO employee(name, employeeid, department, jobrole, email, contactno, address, jobstartdate,username, password) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssss", $name, $employeeid, $department, $jobrole, $email, $contactno, $address, $jobstartdate, $username, $hashed_password);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            return "An error occurred. Please try again";
        }else{
            $_SESSION["user"] = $username;
			header("location: login.php");
			exit();
        }

    }

    function loginUser($employeeid, $username, $password){
		$mysqli = connect();
		$employeeid = trim($employeeid);
		$username = trim($username);
		$password = trim($password);
		
		if($employeeid == "" || $username == "" || $password == ""){
			return "All fields are required";
		}

		$employeeid = filter_var($employeeid, FILTER_SANITIZE_STRING);
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$password = filter_var($password, FILTER_SANITIZE_STRING);

		$sql = "SELECT employeeid, username, password FROM employee WHERE employeeid = ? AND username = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("ss", $employeeid, $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_assoc();

		if($data == NULL){
			return "Wrong employeeid or username or password";
		}

		if(password_verify($password, $data["password"]) == FALSE){
			return "Wrong employeeid or username or password";
		}else{
			$_SESSION["user"] = $username;
			header("location: account.php");
			exit();
		}
	}

    function logoutUser(){

        session_destroy();
        header("location: login.php");
        exit();

    }

?>