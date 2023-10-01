<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

$mail = new PHPMailer(true);

if(!isset($mysqli)){include 'connection.php';}
//include 'sidebar.php'; 
include 'header.php'; 
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
$employeeidErr= $nameErr = $departmentErr = $jobroleErr = $emailErr = $contactnoErr = $jobstartdateErr = $profilepic_mErr= "";  
$employeeid= $name = $department = $jobrole = $email = $contactno = $jobstartdateErr = $profilepic_m= "";  
  
//Input fields validation  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
      
//String Validation  
if (empty($_POST["employeeid"])) {  
    $employeeidErr = "Employee ID is required";  
} else {  
   $employeeid = input_data($_POST["employeeid"]);  
       // check if name only contains letters and whitespace  
       if (!preg_match("/^[a-zA-Z0-9 ]*$/",$employeeid)) {  
           $employeeidErr = "Only alphabets and numbers are allowed";  
       } 
       else{
            //name validation
            if (empty($_POST["name"])) {  
                $nameErr = "Name is required";  
            } else {  
                $name = input_data($_POST["name"]);  
                    // check if name only contains letters and whitespace  
                    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {  
                        $nameErr = "Only alphabets and white space are allowed";  
                    }
                    else{
                        //department validation
                        $department = $_POST['department'];

if ($department == "") {
    $departmentErr = "Please select a department";
}

else{
    //jobrole validation
    $jobrole = $_POST['jobrole'];

if ($jobrole == "") {
$jobroleErr = "Please select a department";
}
                    else{
                        //Email Validation   
                        if (empty($_POST["email"])) {  
                                $emailErr = "Email is required";  
                        } else {  
                                $email = input_data($_POST["email"]);  
                                // check that the e-mail address is well-formed  
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                                    $emailErr = "Invalid email format";  
                              
                                    }
                                    else{
                                     
                                        //Number Validation  
                                    if (empty($_POST["contactno"])) {  
                                        $contactnoErr = "Mobile no is required";  
                                    } else {  
                                        $contactno = input_data($_POST["contactno"]);  
                                        // check if mobile no is well-formed  
                                        if (!preg_match ("/^[0-9]*$/", $contactno) ) {  
                                        $contactnoErr = "Only numeric value is allowed.";  
                                        } 
                                        else{
                                            //check mobile no length should not be less and greator than 10  
                                            if (strlen ($contactno) != 10) {  
                                            $contactnoErr = "Mobile no must contain 10 digits.";  
                                            }else{
                                                $profilepic_m = input_data($_POST['profilepic_m']) ;
                                           
                                                
                                                                    // $hash_pwd =password_hash($password1,PASSWORD_DEFAULT);
                                                                    $sql = "INSERT INTO `employee` (`employeeid`,`name`,`department`,`jobrole`,`email`,`contactno`, `jobstartdate`) VALUES ( '$employeeid','$name','$department','$jobrole','$email','$contactno','$jobstartdate')";
                                                                    $sql1 = "INSERT INTO `login` (username, password, usertype)
                                                                    VALUES ('$username', '$password', 
                                                                            CASE 
                                                                                WHEN '$@usertype' IN ('Manager', 'Employee') THEN 'employee'
                                                                                ELSE '$@usertype' IN ('Department Head') THEN 'dept_head'
                                                                            END);
                                                                    ";
                                                                    
                                                                    $result = $conn->query($sql);
                                                               
                                                                
                                                                    //$sql ="INSERT INTO `c_admins` (`id`, `employeeid`, `name`, `admin_type`, `email`, `contactno`, `username`, `password`) VALUES (NULL, '27', 'desfsf', 'sfgreg', 'egweg', 'wegweg', 'wegweg', 'wegfewg')";
                                                               
                                                                    
                                                                    if ($result) {
                                                                        try {
                                                                            // Email sending
                                                                            $to = $email;
                                                                            $subject = "New Employee Registration";
                                                                            $message = "Dear $name,\n\nThank you for registering as a new employee.\n\nWe look forward to working with you. \n Your User Name: $employeeid \n Default Password:blitz@123 \n\nRegards,\nYour Company";
                                                                    
                                                                            // Configure PHPMailer
                                                                            $mail->isSMTP();
                                                                            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server address
                                                                            $mail->SMTPAuth = true;
                                                                            $mail->Username = 'blitz.emp.mgt.sys@gmail.com'; // Replace with your SMTP username
                                                                            $mail->Password = 'ttnhncqwiclnzjif'; // Replace with your SMTP password
                                                                            $mail->SMTPSecure = 'tls'; // Use 'tls' or 'ssl' depending on your server configuration
                                                                            $mail->Port = 587; // Replace with the appropriate SMTP port
                                                                    
                                                                            // Set email details
                                                                            $mail->setFrom('blitz.emp.mgt.sys@gmail.com', 'Blitz'); // Replace with your company email address and name
                                                                            $mail->addAddress($to);
                                                                            $mail->Subject = $subject;
                                                                            $mail->Body = $message;
                                                                    
                                                                            // Send the email
                                                                            $mail->send();
                                                                    
                                                                            // Email sent successfully
                                                                            header("location: list_employee.php");
                                                                            exit;
                                                                        } catch (Exception $e) {
                                                                            // Failed to send email
                                                                            $emailErr = "Failed to send email. Please try again later.";
                                                                        }
                                                                    }
                                                                    
                                                                    }
                                                                    
                                                                    
                                                                    
                                                                    } 

                                                                     }
                                                            
                                                            }
                                                        
                                                        }
                                                    }
                                                
                                                } 
                                            }  
                                            }    

                                        }
                                            } 
                                          
                                    }

function input_data($data) {  
  $data = trim($data);  
  $data = stripslashes($data);  
  $data = htmlspecialchars($data);  
  return $data;  
}  

?>  
<div class ="container">
<br/> <br/><br/> <br/> <br/><br/>
<div class="up">
<h2>New Employee</h2>  
<div class = "error">* Required Field </div> 
</div> 
  
<!--  <div class="signupform"> -->

<form class="form-inline" action="" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">    
<table>
<tr>
<td><label for="employeeid">Employee ID: </label></td>
<td><input type="text" id="employeeid" placeholder="Enter Employee ID" name="employeeid" required>  
    <span class="error">* </span>
         <div class="error"> <?php echo $employeeidErr; ?> </div></td></tr>  
    <br><br>  
<tr>
<td><label for="name">Name: </label></td>
<td><input type="text" id="name" placeholder="Enter Employee's Name" name="name" required>  
    <span class="error">* </span>  

    <div class="error"> <?php echo $nameErr; ?> </div></td> </tr>

<br><br>  
<tr> 
<td><label for="department">Department:</label></td>

<td> <select id="department" name="department" required>
        <option value="" selected disabled>Select Department</option>
        <option value="HR">HR</option>
        <option value="Finance">Finance</option>
        <option value="Marketing">Marketing</option>
        <option value="Administration">Administration</option>
        <option value="Legal">Legal</option>
        <option value="IT">IT</option>
    </select>
    <span class="error">*  </span>  

<div class="error"> <?php echo $departmentErr; ?> </div>  </td> </tr>

<br><br>

<tr> 
<td><label for="jobrole">Job Role:</label></td>
<td><select id="jobrole" name="jobrole" required>
        <option value="" selected disabled>Select Job Role</option>
        <option value="Manager">Manager</option>
        <option value="Employee">Employee</option>
    </select>
  
    <span class="error">*  </span>  

<div class="error"> <?php echo $jobroleErr; ?> </div>  </td> </tr>

<br><br>
<tr>  
<td><label for="email">Email: </label> </td>
<td><input type="email" id="email" placeholder="Enter E-mail" name="email" required>  
    <span class="error">* </span>   

<div class="error"> <?php echo $emailErr; ?> </div> </td> </tr>

   <br><br>
<tr>
    <td><label for="contactno">Contact Number: </label>  </td>  
    <td><input type="text" id="contactno" placeholder="Enter Contact Number" name="contactno" required>  
    <span class="error">* </span>  

<div class="error">  <?php echo $contactnoErr; ?> </div> </td> </tr> 

<br><br>
<tr>
    <td><label for="jobstartdate">Job Start Date : </label>  </td>  
    <td><input type="date" id="jobstartdate" placeholder="Enter Job Start Date" name="jobstartdate" required>  
    <span class="error">* </span>  

<div class="error">  <?php echo $jobstartdateErr; ?> </div> </td> </tr> 


</table>
  
    <br /> 

            <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><a href="list_employee.php"><b>Save</b></button>
            <button class="inner2" type="input" name="reset"><b>Cancel</b></button>
        </div>
            <?php if(isset($msg)) {echo $msg; } ?>

</div>                          
</form>  
</div>  


</div>  
    
</body>  
</html>