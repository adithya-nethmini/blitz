<?php



session_start();
define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'blitz');

// Establish database connection using PDO
try {
    $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE, USERNAME, PASSWORD);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

/* database connection starts here */

function connect()
{
    $mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
    if ($mysqli->connect_error != 0) {
        $error = $mysqli->connect_error;
        $error_date = date("F j, Y, g:i a");
        $message = "{$error} | {$error_date} \r\n";
        file_put_contents("db-log.txt", $message, FILE_APPEND);
        return false;
    } else {
        $mysqli->set_charset("utf8mb4");
        return $mysqli;
    }
}

/* database connection ends here */

/* g_signup.php starts here */
function selectRadio($signup_Option)
{
    if (isset($_POST['signup-option'])) {
        $signup_Option = $_POST['signup-option'];
        if ($signup_Option == "Employee") {
            header("location: employee/signup.php");
        } else {
            header("location: partner_company/packages.php");
        }
    }
}

/* g_signup.php ends here */

/* Register user starts here */

function registerUser($employeeid, $name, $department, $jobrole, $email, $contactno, $address, $jobstartdate, $username, $password, $conpassword, $gender, $user_type)
{
    $mysqli = connect();
    $args = func_get_args();

    $args = array_map(function ($value) {
        return trim($value);
    }, $args);

    foreach ($args as $value) {
        if (empty($value)) {
            return "All fields are required";
        }
    }

    foreach ($args as $value) {
        if (preg_match("/([<|>])/", $value)) {
            return "<> characters are not allowed";
        }
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Sorry! Email is not valid";
    }

    $stmt = $mysqli->prepare("SELECT employeeid FROM employee WHERE employeeid = ?");
    $stmt->bind_param("s", $employeeid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if ($data != NULL) {
        return "Employee ID already exists. Please enter your employee id";
    }

    $stmt = $mysqli->prepare("SELECT email FROM employee WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if ($data != NULL) {
        return "Email already exists, please use a different email";
    }

    if (strlen($username) > 50) {
        return "Username is too long";
    }

    $stmt = $mysqli->prepare("SELECT username FROM employee WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if ($data != NULL) {
        return "Username already exists, please use a different username";
    }

    $stmt = $mysqli->prepare("SELECT contactno FROM employee WHERE contactno = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if ($data != NULL) {
        return "Contact number already exists, please use a different contact number";
    }

    if (strlen($password) > 50) {
        return "Password is too long";
    }

    if ($password != $conpassword) {
        return "Passwords don't match";
    }

    $number = preg_match('@[0-9]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (strlen($password) < 8) {
        return "Password must be at least 8 characters in length.";
    }
    if (strlen($password) < !$number) {
        return "Password must contain at least one number.";
    }
    if (strlen($password) < !$uppercase) {
        return "Password must contain at least one upper case letter.";
    }
    if (strlen($password) < !$lowercase) {
        return "Password must contain at least one lower case letter.";
    }
    if (strlen($password) < !$specialChars) {
        return "Password must contain at least one special character.";
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    function Unique_id($length)
    {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$&*';
        return substr(str_shuffle($str), 0, $length);
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
        if ($stmt->affected_rows != 1) {
            return "hey! An error occurred. Please try again";
        } else {
            echo 'success';
        }

        $stmt = $mysqli->prepare("INSERT INTO notification(notification_name,notification_description,notification_type,username,status) VALUES('User-Registration','Registered to the system','4',?,'unseen')");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->affected_rows != 1) {
            return "An error occurred. Please try again";
        } else {
            echo 'Notification sent';
        }

        $stmt = $mysqli->prepare("INSERT INTO employee(employeeid,name, department, jobrole, email, contactno, address, jobstartdate, username, password, gender, qr, loyalty_eligibility, unique_Id) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,'No',?)");
        $stmt->bind_param("sssssssssssss", $employeeid, $name, $department, $jobrole, $email, $contactno, $address, $jobstartdate, $username, $hashed_password, $gender, $qr, $unique_Id);
        $stmt->execute();
        if ($stmt->affected_rows != 1) {
            echo "Error: " . $mysqli->error;
        } else {
            $_SESSION["user"] = $username;
            $_SESSION["employeeid"] = $employeeid;
            header("location: login.php");
            exit();
        }
    }
}

/* Register user ends here */


/* Login user starts here */

function loginUser($username, $password)
{
    $mysqli = connect();
    $username = trim($username);
    $password = trim($password);

    if ($username == "" || $password == "") {
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


    if ($data == NULL) {
        return "Wrong username or password";
    }
    if (password_verify($password, $data["password"]) == FALSE) {
        return "Wrong username or password";
    }

    $userType = $data['user_type'];

    if (!isset($userType)) {
        return "Invalid user type";
    }

    switch ($userType) {

        case "employee":
            $_SESSION['user'] = $username;
            header('location: ../../blitz/home.php');
            break;
        case "company_admin":
            $_SESSION['cadmin_user'] = $username;
            header('location: ../applications/company_admin/Dash.php');
            break;
        case "Dept_head":
            $_SESSION['dept_user'] = $username;
            header('location: ../applications/department_head/dashboard.php');
            break;
        case "partner_company_admin":
            $_SESSION['padmin_user'] = $username;
            header('location: ../applications/partner_company/partner-profile.php');
            break;
        default:
            return "Error logging in. Please try again.";
    }
}

function forgotPassword($email)
{
    $mysqli = connect();

    $email = trim($email);

    if ($email == "") {
        return "Please enter your email address";
    }

    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $sql = "SELECT email FROM employee WHERE username = ?";
    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Sorry! Email is not valid";
    }

    if ($data == NULL) {
        return "Wrong email";
    }
}

function logoutUser()
{

    unset($_SESSION['login']);
    session_destroy();
    header("location: ../../landingpage.php");
    exit();
}
/*   function logoutUser(){
        unset($_SESSION['login']);
        session_destroy();
        $index = $_SERVER['REQUEST_URI'];
        header("location: $index");
        exit();
      }*/

function addTask($username, $name, $description, $priority, $deadline, $status)
{

    $mysqli = connect();
    $args = func_get_args();

    $args = array_map(function ($value) {
        return trim($value);
    }, $args);

    foreach ($args as $value) {
        if (empty($value)) {
            return "All fields are required";
        }
    }

    foreach ($args as $value) {
        if (preg_match("/([<|>])/", $value)) {
            return "<> characters are not allowed";
        }
    }

    /* $user = $_SESSION['user'];
        $employeeid = "SELECT employeeid FROM employee WHERE username = $user";

        $empid = $_SESSION["$employeeid"]; */

    $stmt = $mysqli->prepare("INSERT INTO task(username, name, description, priority, deadline, status) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $username, $name, $description, $priority, $deadline, $status);
    $stmt->execute();
    if ($stmt->affected_rows != 1) {
        return "An error occurred. Please try again";
        header("location: add-task.php");
    } else {
        $_SESSION["add"] = "Task added successfully";
        header("location: task-manager.php");
        exit();
    }
}

/* Apply Leave */
function applyLeaveTest($leave_type, $reason, $start_date, $last_date, $username, $assigned_person)
{
    $user = $_SESSION['user'];
    $mysqli = connect();
    $args = func_get_args();

    // Validate input data types
    // if (!is_string($leave_type) || !is_string($recipient) || !is_string($message)) {
    //     return "Invalid data types";
    // }

    $args = array_map(function ($value) use ($mysqli) {
        // Escape special characters
        $value = mysqli_real_escape_string($mysqli, trim($value));

        // Check for disallowed characters
        if (preg_match("/([<|>])/", $value)) {
            return "<> characters are not allowed";
        }

        return $value;
    }, $args);




    $sql = "SELECT * FROM e_leave WHERE name = '$user' AND status != 'Canceled' AND ((start_date <= '$start_date' AND last_date >= '$start_date') OR (start_date <= '$last_date' AND last_date >= '$last_date') OR (start_date >= '$start_date' AND last_date <= '$last_date'))";
    $result = mysqli_query($mysqli, $sql);
    $count_rows = mysqli_num_rows($result);

    if ($count_rows > 0) {
        // User has already taken a leave during requested time period
        echo "<div id='error-popup' class='error-popup'>
        <span class='error-popup-close'>&times;</span>
        <div>
            <i class='fa-solid fa-triangle-exclamation' style='font-size:50px'></i>
        </div>
        <div class='popup-inner'>
            <p>You have already taken a leave during the requested time period</p>
        </div>
    </div>
    <script>
    const errorPopup = document.getElementById('error-popup');
    const errorPopupClose = errorPopup.querySelector('.error-popup-close');
    errorPopup.style.display = 'block';
    errorPopupClose.addEventListener('click', function() {
      errorPopup.style.display = 'none';
    });
    </script>";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO notification(notification_name, notification_description, notification_type, username, status) VALUES('Leave Application', 'Apply for a leave', '4', ?, 'unseen')");
        $stmt->bind_param("s", $username);
        if (!$stmt->execute()) {
            $error_message = "Notification insert failed: " . $stmt->error;
            return $error_message;
        } else {
            $notification_id = $stmt->insert_id;
        }

        date_default_timezone_set('Asia/Kolkata');
        $current_date = date('Y-m-d H:i:s');
        $stmt2 = $mysqli->prepare("INSERT INTO e_leave(leave_type,reason,start_date,last_date,status,name,assigned_person,applied_date) VALUES(?, ?, ?, ?, 'Pending', ?, ?, '$current_date')");
        $stmt2->bind_param("ssssss", $leave_type, $reason, $start_date, $last_date, $username, $assigned_person);
        if (!$stmt2->execute()) {
            $error_message = "Leave application insert failed: " . $stmt2->error;
            return $error_message;
        } else {
            $leave_id = $stmt2->insert_id;
        }

        if ($notification_id && $leave_id) {
            echo '<script>window.location.href = "http://localhost/blitz/applications/employee/leave-status.php";</script>';
        } else {
            return "An error occurred. Please try again";
        }
    }
}

function check_availability($start_date, $last_date, $assigned_person)
{
    $mysqli = connect();
    $user = $_SESSION['user'];
    $stmt = $mysqli->prepare("SELECT assigned_person FROM `e_leave` WHERE assigned_person = '$assigned_person' AND status != 'Canceled' AND ((start_date <= '$start_date' AND last_date >= '$start_date') OR (start_date <= '$last_date' AND last_date >= '$last_date') OR (start_date >= '$start_date' AND last_date <= '$last_date'))");
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($database_assigned_person);
        while ($stmt->fetch()) {
            if ($assigned_person == $database_assigned_person) {
                return 'no';
                return 'Assigned Person: ' . $assigned_person;
                return 'Assigned to be: ' . $database_assigned_person;
            } else {
                return 'ok';
            }
        }
    }
}
//     }
// }

function updateProfilePic($profilepic_e, $username)
{
    $mysqli = connect();
    $args = func_get_args();

    $args = array_map(function ($value) {
        return trim($value);
    }, $args);

    foreach ($args as $value) {
        if (empty($value)) {
            return "All fields are required";
        }
    }

    $stmt = $mysqli->prepare("UPDATE employee SET profilepic_e = ? WHERE username = '$username'");
    $stmt->bind_param("s", $profilepic_e);
    $stmt->execute();
    if ($stmt->affected_rows != 1) {
        return mysqli_error($mysqli);
    } else {
        return "Success";
        header('location: profile.php');
        exit();
    }
}

function sendDirectMessage($sender, $recipient, $message)
{
    $mysqli = connect();
    $args = func_get_args();

    // Validate input data types
    if (!is_string($sender) || !is_string($recipient) || !is_string($message)) {
        return "Invalid data types";
    }

    $args = array_map(function ($value) use ($mysqli) {
        // Escape special characters
        $value = mysqli_real_escape_string($mysqli, trim($value));

        // Check for disallowed characters
        if (preg_match("/([<|>])/", $value)) {
            return "<> characters are not allowed";
        }

        return $value;
    }, $args);

    $stmt = $mysqli->prepare("INSERT INTO notification(notification_name, notification_description, notification_details, notification_type, username, status) VALUES('Messages', 'Direct Message', ?, '1', ?, 'unseen')");
    $stmt->bind_param("ss", $sender, $recipient);
    $stmt->execute();
    if ($stmt->affected_rows != 1) {
        return "An error occurred. Please try again";
    } else {
        echo 'Notification sent';
    }

    date_default_timezone_set('Asia/Kolkata');
    $current_date = date('Y-m-d H:i:s');
    $stmt = $mysqli->prepare("INSERT INTO chat(chat_type, sender, recipient, message, created_date_time, status) VALUES('Direct', ?, ?, ?, '$current_date', 'unseen')");
    $stmt->bind_param("sss", $sender, $recipient, $message);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            return true; // message sent successfully
        } else {
            return "Error: No rows affected";
        }
    } else {
        return "Error: " . $stmt->error;
    }
}

function sendGroupMessage($sender, $recipient, $message)
{
    $mysqli = connect();
    $args = func_get_args();

    // Validate input data types
    if (!is_string($sender) || !is_string($recipient) || !is_string($message)) {
        return "Invalid data types";
    }

    $args = array_map(function ($value) use ($mysqli) {
        // Escape special characters
        $value = mysqli_real_escape_string($mysqli, trim($value));

        // Check for disallowed characters
        if (preg_match("/([<|>])/", $value)) {
            return "<> characters are not allowed";
        }

        return $value;
    }, $args);

    $stmt = $mysqli->prepare("INSERT INTO notification(notification_name, notification_description, notification_details, notification_type, username, status) VALUES('Messages', 'Group Message', ?, '1', ?, 'unseen')");
    $stmt->bind_param("ss", $sender, $recipient);
    $stmt->execute();
    if ($stmt->affected_rows != 1) {
        return "An error occurred. Please try again";
    } else {
        echo 'Notification sent';
    }
    date_default_timezone_set('Asia/Kolkata');
    $current_date = date('Y-m-d H:i:s');
    $stmt = $mysqli->prepare("INSERT INTO chat(chat_type, sender, recipient, message, created_date_time, status) VALUES('Group', ?, ?, ?, '$current_date', 'unseen')");
    $stmt->bind_param("sss", $sender, $recipient, $message);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            return true; // message sent successfully
        } else {
            return "Error: No rows affected";
        }
    } else {
        return "Error: " . $stmt->error;
    }
}







// /* Apply Leave */
// function applyLeave($leave_type, $reason, $start_date, $last_date, $username, $assigned_person)
// {
//     $mysqli = connect();
//     $args = func_get_args();

//     $args = array_map(function ($value) {
//         return trim($value);
//     }, $args);

//     foreach ($args as $value) {
//         if (empty($value)) {
//             return "All fields are required";
//         }
//     }

//     foreach ($args as $value) {
//         if (preg_match("/([<|>])/", $value)) {
//             return "<> characters are not allowed";
//         }
//     }

//     $sql = "SELECT name FROM employee WHERE username = '$username'";
//     $result = mysqli_query($mysqli, $sql);

//     if ($result == TRUE) :

//         $count_rows = mysqli_num_rows($result);

//         if ($count_rows > 0) :
//             while ($row = mysqli_fetch_assoc($result)) :
//                 $name = $row['name'];
//             endwhile;
//         endif;
//     endif;

//     $stmt = $mysqli->prepare("INSERT INTO notification(notification_name,notification_description,notification_type,username,status) VALUES('Leave Application','Apply for a leave','4',?,'unseen')");
//     $stmt->bind_param("s", $username);
//     $stmt->execute();
//     if ($stmt->affected_rows != 1) {
//         return "An error occurred. Please try again";
//     } else {
//         echo 'Notification sent';
//     }


//     $stmt = $mysqli->prepare("INSERT INTO e_leave(leave_type, reason, start_date, last_date, status, name, assigned_person) VALUES(?,?,?,?,'Pending',?,?)");
//     $stmt->bind_param("ssssss", $leave_type, $reason, $start_date, $last_date, $name, $assigned_person);
//     $stmt->execute();
//     if ($stmt->affected_rows != 1) {

//         header("location: leave-status.php");
//     } else {
//         header("location: leave-status.php");
//         exit();
//     }
// }