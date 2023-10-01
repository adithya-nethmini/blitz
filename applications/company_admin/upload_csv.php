<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($file, "r");

    include("connection.php");

    // Truncate existing data in the table before inserting new data
    $truncateSql = "TRUNCATE TABLE list_employee";
    $conn->query($truncateSql);

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $employeeid = $data[0];
        $name = $data[1];
        $department = $data[2];
        $jobrole = $data[3];
        $email = $data[4];
        $contactno = $data[5];
        $jobstartdate = $data[6];

        $sql = "INSERT INTO employee (employeeid, name, department, jobrole, email, contactno, jobstartdate) 
                VALUES ('$employeeid', '$name', '$department', '$jobrole', '$email', '$contactno', '$jobstartdate')";

        $result = $conn->query($sql);
        if (!$result) {
            die("Invalid Query: " . $conn->error);
        }
    }

    fclose($handle);

    // Send email to the entered email addresses
    try {
        // Create a new PHPMailer instance
        $mail = new PHPMailer();

        // Email configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server address
        $mail->SMTPAuth = true;
        $mail->Username = 'blitz.emp.mgt.sys@gmail.com'; // Replace with your SMTP username
        $mail->Password = 'ttnhncqwiclnzjif'; // Replace with your SMTP password
        $mail->SMTPSecure = 'tls'; // Use 'tls' or 'ssl' depending on your server configuration
        $mail->Port = 587; // Replace with the appropriate SMTP port
        $mail->setFrom('blitz.emp.mgt.sys@gmail.com', 'Blitz'); // Replace with your company email address and name

        // Fetch email addresses from the database
        $emailQuery = "SELECT DISTINCT email FROM employee";
        $emailResult = $conn->query($emailQuery);

        if ($emailResult) {
            while ($row = $emailResult->fetch_assoc()) {
                $to = $row['email'];
                $subject = "New Employee Registration";
                $message = "Dear $name,\n\nThank you for registering as a new employee.\n\nWe look forward to working with you. \n Your User Name: $employeeid \n Default Password: blitz@123 \n\nRegards,\nYour Company";

                $mail->addAddress($to);
                $mail->Subject = $subject;
                $mail->Body = $message;

                // Send the email
                $mail->send();
                $mail->clearAddresses();
            }
        }

        echo "<script>alert('CSV file uploaded successfully! Emails sent to the registered employees.')
        window.location.href = 'list_employee.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error sending emails.')</script>";
    }
}

// Function to sanitize input data
function input_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
