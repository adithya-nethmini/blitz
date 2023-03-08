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
                header("location: partner_company/packages.php");
            }
        }
    }

    /* g_signup.php ends here */

    /* Register user starts here */

    function registerUser($employeeid, $name, $department, $jobrole, $email, $contactno, $address, $jobstartdate, $username, $password, $conpassword, $gender, $user_type){
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

        function Unique_id($length){
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$&*';
        return substr(str_shuffle($str), 0 , $length);
        }
        $unique_Id = unique_id(8);
        
        include "phpqrcode/qrlib.php";
        $PNG_TEMP_DIR = '../employee/temp/';
        
        if (!file_exists($PNG_TEMP_DIR))
            mkdir($PNG_TEMP_DIR);

        $qr = $PNG_TEMP_DIR . 'test.png';

        if (isset($_POST["submit"])) {
        

        $codeString = $employeeid . "\n";
        $codeString = $name . "\n";
        $codeString .= $username . "\n";
        $codeString .= $email . "\n"; 
        $codeString .= 
        '
        localhost/blitz/application/employee/attendance.php
        
        ' . "\n";
            
        $qr = $PNG_TEMP_DIR . 'test' . md5($codeString) . '.png'; 

        QRcode::png($codeString, $qr); 

        $stmt = $mysqli->prepare("INSERT INTO login(username, password, user_type) VALUES(?,?,?)");
        $stmt->bind_param("sss", $username, $hashed_password, $user_type);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            return "hey! An error occurred. Please try again";
        }else{
            echo 'success';
        }

        $stmt = $mysqli->prepare("INSERT INTO notification(notification_name,notification_description,notification_type,username,status) VALUES('User-Registration','Registered to the system','4',?,'unseen')");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            return "An error occurred. Please try again";
        }else{
            echo 'Notification sent';
        }
        
        $stmt = $mysqli->prepare("INSERT INTO employee(employeeid,name, department, jobrole, email, contactno, address, jobstartdate, username, password, gender, qr, loyalty_eligibility, unique_Id) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,'No',?)");
        $stmt->bind_param("sssssssssssss", $employeeid, $name, $department, $jobrole, $email, $contactno, $address, $jobstartdate, $username, $hashed_password, $gender, $qr, $unique_Id);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            echo "Error: " . $mysqli->error;
        }else{
            $_SESSION["user"] = $username;
            $_SESSION["employeeid"] = $employeeid;
			header("location: login.php");
			exit();
        }
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
              
		$sql = "SELECT username, password, user_type FROM login WHERE username = ?";
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
        }
        
        $userType = $data['user_type'];
        
        if(!isset($userType)){
            return "Invalid user type";
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
                        return "Error logging in. Please try again.";
                  }
	}

    function forgotPassword($email){
        $mysqli = connect();

        $email = trim($email);
		
		if($email == ""){
			return "Please enter your email address";
		}

		$email = filter_var($email, FILTER_SANITIZE_STRING);

		$sql = "SELECT email FROM employee WHERE username = ?";
		$stmt = $mysqli->prepare($sql);
        
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_assoc();

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    return "Sorry! Email is not valid";
        }
        
		if($data == NULL){
			return "Wrong email";
		}        

    }

     function logoutUser(){
        unset($_SESSION['login']);
        session_destroy();
        header("location: ../department_head/landingpage.php");
        exit();

    } 
 /*   function logoutUser(){
        unset($_SESSION['login']);
        session_destroy();
        $index = $_SERVER['REQUEST_URI'];
        header("location: $index");
        exit();
      }*/

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

    /* Apply Leave */
    function applyLeave($reason, $start_date, $last_date, $username, $assigned_person){
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

       /*  $sql = "SELECT * FROM emp_leave WHERE status = 'Pending' AND status = 'Accepted'";
		$result = mysqli_query($mysqli, $sql);

            if($result==TRUE):

                $count_rows = mysqli_num_rows($result);

                if($count_rows > 0):
                    while($row = mysqli_fetch_assoc($result)):
                        $username_all = $row['username'];
                        $start_date_all = $row['start_date'];
                        $last_date_all = $row['last_date'];
                        $assigned_person_all = $row['assigned_person'];

                        if($assigned_person == $username_all && $username_all == $_SESSION['user']):
                            return 'Your assigned person is on a leave';
                        elseif($assigned_person_all == $assigned_person):
                            return 'Your assigned person is already assigned to someone else';
                        else:
                            return 'success';
                        endif;
                    endwhile;
                endif; 
            endif;
 */
        $sql = "SELECT name FROM employee WHERE username = '$username'";
        $result = mysqli_query($mysqli, $sql);

            if($result==TRUE):

                $count_rows = mysqli_num_rows($result);

                if($count_rows > 0):
                    while($row = mysqli_fetch_assoc($result)):
                        $name = $row['name'];
                    endwhile;
                endif;
            endif;
            
        $stmt = $mysqli->prepare("INSERT INTO e_leave(reason, start_date, last_date, status, name, assigned_person) VALUES(?,?,?,'Pending',?,?)");
        $stmt->bind_param("sssss", $reason, $start_date, $last_date, $name, $assigned_person);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            echo $mysqli -> error;
            header("location: apply-leave.php");
        }else{
            header('location: leave-status.php');
			exit();
        }

    }

    function updateProfilePic($profilepic_e, $username){
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

        $stmt = $mysqli->prepare("UPDATE employee SET profilepic_e = '?' WHERE user = '$username'");
        $stmt->bind_param("s", $profilepic_e);
        $stmt->execute();
        if($stmt->affected_rows != 1){
            return "An error occurred. Please try again";
        }else{
            return "Success";
            header('location: profile.php');
			exit();
        }
    }

?>