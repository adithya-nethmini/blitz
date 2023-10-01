<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

$mail = new PHPMailer(true);
if (!isset($mysqli)) {
    include 'connection.php';
}
// include 'sidebar.php';
// include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="create.css">
</head>

<body>
    <?php
    include("connection.php");
    // define variables to empty values
    $employeeidErr = $nameErr = $departmentErr = $emailErr = $contactnoErr = $profilepic_mErr = "";
    $employeeid = $name = $department = $email = $contactno = $profilepic_m = "";

    //Input fields validation
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Employee ID Validation
        if (empty($_POST["employeeid"])) {
            $employeeidErr = "Employee ID is required";
        } else {
            $employeeid = input_data($_POST["employeeid"]);
            // Check if employee ID follows the format E00000
            if (!preg_match("/^E\d{5}$/", $employeeid)) {
                $employeeidErr = "Employee ID should follow the format E00000";
            }
        }

        // Name Validation
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = input_data($_POST["name"]);
            // Check if name contains only alphabets, dots, and whitespace
            if (!preg_match("/^[a-zA-Z .]*$/", $name)) {
                $nameErr = "Only alphabets, dots, and whitespace are allowed";
            }
        }

        // Department Validation
        if (empty($_POST["department"])) {
            $departmentErr = "Department is required";
        } else {
            $department = input_data($_POST["department"]);
        }

        // Email Validation
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = input_data($_POST["email"]);
            // Check if email is in a valid format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        // Contact Number Validation
        if (empty($_POST["contactno"])) {
            $contactnoErr = "Mobile no is required";
        } else {
            $contactno = input_data($_POST["contactno"]);
            // Check if contact number contains exactly 10 digits
            if (!preg_match("/^\d{10}$/", $contactno)) {
                $contactnoErr = "Mobile no must contain 10 digits.";
            }
        }

        // If all fields are valid, insert data into the database
        if ($employeeidErr == "" && $nameErr == "" && $departmentErr == "" && $emailErr == "" && $contactnoErr == "") {
            @$profilepic_m = input_data($_POST['profilepic_m']);

            $sql = "INSERT INTO `dept_head` (`employeeid`,`name`,`department`,`email`,`contactno`) VALUES ('$employeeid','$name','$department','$email','$contactno')";
            $sql1 = "INSERT INTO `login` (`username`,`password`,`user_type`,`logs`) VALUES ('$employeeid','blitz@123','Dept_head','')";
          
            $result = $conn->query($sql);
            $result1 = $conn->query($sql1);

            if ($result && $result1) {
                try {
                    // Email sending
                    $to = $email;
                    $subject = "New Department Head Registration";
                    $message = "Dear $name,\n\nCongratulations! You are promoted as $department's Department Head of Blitz Pvt.Ltd.\n\nWe look forward to working with you. \nYour User Name: $employeeid \n Default Password:blitz@123 \n\nRegards,\nYour Company";

                    // Configure PHPMailer
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Our SMTP server address
                    $mail->SMTPAuth = true;
                    $mail->Username = 'blitz.emp.mgt.sys@gmail.com'; // Our SMTP username
                    $mail->Password = 'ttnhncqwiclnzjif'; // Our SMTP password
                    $mail->SMTPSecure = 'tls'; // 'tls'/'ssl' depending on server configuration
                    $mail->Port = 587; // Appropriate SMTP port

                    // Set email details
                    $mail->setFrom('blitz.emp.mgt.sys@gmail.com', 'Blitz'); // our company email address and name
                    $mail->addAddress($to);
                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    // Send the email
                    $mail->send();

                    // Email sent successfully
                    header("location: list_depthead.php");
                    exit;
                } catch (Exception $e) {
                    // Failed to send email
                    $emailErr = "Failed to send email. Please try again later.";
                }
            }
        }
    }

    function input_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <div class="container">
        <br /><br /><br /><br /><br /><br />
        <div class="up">
            <h2>New Department Head</h2>
            <div class="error">* Required Field </div>
        </div>
        <br><br><br><br> <br>
    </div>

    <form id="myForm" class="form-inline" action="" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <tr>
                <td><label for="employeeid">Employee ID: </label></td>
                <td><input type="text" id="employeeid" placeholder="Enter Employee ID" name="employeeid" required>
                    <span class="error">* </span>
                    <div class="error"> <?php echo $employeeidErr; ?> </div>
                </td>
            </tr>
            <br><br>
            <tr>
                <td><label for="name">Name: </label></td>
                <td><input type="text" id="name" placeholder="Enter Employee's Name" name="name" required>
                    <span class="error">* </span>
                    <div class="error"> <?php echo $nameErr; ?> </div>
                </td>
            </tr>
            <tr>
                <td><label for="department">Department:</label></td>
                <td>
                    <select id="department" name="department">"required>
                        <option value="" selected disabled>Select Department</option>
                        <option value="HR">HR</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Administration">Administration</option>
                        <option value="Legal">Legal</option>
                        <option value="IT">IT</option>
                    </select>
                    <span class="error">*  </span>
                    <div class="error"> <?php echo $departmentErr; ?> </div>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email: </label> </td>
                <td><input type="email" id="email" placeholder="Enter E-mail" name="email" required>
                    <span class="error">* </span>
                    <div class="error"> <?php echo $emailErr; ?> </div>
                </td>
            </tr>
            <tr>
                <td><label for="contactno">Contact Number : </label>  </td>
                <td><input type="text" id="contactno" placeholder="Enter Contact Number" name="contactno"? required>
                    <span class="error">* </span>
                    <div class="error">  <?php echo $contactnoErr; ?> </div>
                </td>
            </tr>
        </table>

        <div class="inline-block">
            <div class="bar">
                <button class="inner1" type="submit" name="submit"><a href="list_depthead.php"><b>Save</b></button>
                <button class="inner2" type="button" name="reset" onclick="resetForm()"><b>Cancel</b></button>
            </div>
            <?php if(isset($msg)) {echo $msg; } ?>
        </div>
    </form>
</div>

<script>
    function resetForm() {
        document.getElementById("myForm").reset();
    }
</script>

</body>
</html>