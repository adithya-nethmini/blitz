<?php 



session_start();
define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'blitz');


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

    /* g_signup.php starts here */
    function selectRadio($signup_Option){
        if(isset($_POST['signup-option'])){
            $signup_Option = $_POST['signup-option'];
            if($signup_Option == "Employee"){
                header("location: employee/signup.php");
            }else{
                header("location: partner_company/signup.php");
            }
        }
    }

    /* g_signup.php ends here */

    /* Register user starts here */

    function registerUser($name, $employeeid, $department, $jobrole, $email, $contactno, $address, $jobstartdate, $username, $password, $conpassword, $gender){
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

        $stmt = $mysqli->prepare("INSERT INTO employee(name, employeeid, department, jobrole, email, contactno, address, jobstartdate,username, password, gender) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssssss", $name, $employeeid, $department, $jobrole, $email, $contactno, $address, $jobstartdate, $username, $hashed_password, $gender);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            return "An error occurred. Please try again";
        }else{
            $_SESSION["user"] = $username;
            $_SESSION["employeeid"] = $employeeid;
			header("location: login.php");
			exit();
        }

    }

    /* Register user ends here */


    /* Login user starts here */

    function loginUser($username, $password){
		$mysqli = connect();
		$username = trim($username);
		$password = trim($password);
		
		if($username == "" || $password == ""){
			return "All fields are required";
		}

		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$password = filter_var($password, FILTER_SANITIZE_STRING);

		$sql = "SELECT username, password FROM employee WHERE username = ?";
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
		}else{
			$_SESSION["user"] = $username;
			header("location: ../../index.php");
			exit();
		}
	}

    function logoutUser(){
        unset($_SESSION['login']);
        session_destroy();
        header("location: index.php");
        exit();

    }

    function addTask($username, $name, $description, $priority, $deadline, $status){

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

        /* $user = $_SESSION['user'];
        $employeeid = "SELECT employeeid FROM employee WHERE username = $user";

        $empid = $_SESSION["$employeeid"]; */

        $stmt = $mysqli->prepare("INSERT INTO task(username, name, description, priority, deadline, status) VALUES(?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $username, $name, $description, $priority, $deadline, $status);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            return "An error occurred. Please try again";
            header("location: add-task.php");
        }else{
            $_SESSION["add"] = "Task added successfully";
			header("location: task-manager.php");
			exit();
        }

        
    }

?>