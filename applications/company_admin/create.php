<?php
if(!isset($mysqli)){include 'connection.php';}
include 'sidebar.php'; 
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
$employeeidErr= $nameErr = $departmentErr = $emailErr = $contactnoErr = $profilepic_mErr= $usernameErr = $pwderr =$confirmpwd= $agreeErr=  "";  
$employeeid= $name = $department = $email = $contactno = $profilepic_m= $username = $password1 = $password2  = $agree= "";  
  
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
                        if (empty($_POST["Department"])) {  
                            $departmentErr = "Department is required";  
                        } else {  
                            $department = input_data($_POST["department"]);  
                                // check if name only contains letters and whitespace  
                                if (!preg_match("/^[a-zA-Z ]*$/",$department)) {  
                                    $departmentErr = "Only alphabets and white space are allowed";  
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
                                           
                                                //username validation
                                                if(!isset($_POST['username'])){
                                                    $usernameErr = "Username is required";
                                                }
                                                else{
                                                    $username = input_data($_POST['username']);
                                                    //password Validation  
                                                    if(empty($_POST['password_1'])){
                                                        $pwderr = "Password is required";
                                                    }
                                                    else{
                                                        $password1 = $_POST['password_1'];
                                                        $password2 = $_POST['password_2'];
                                                        // Validate password strength
                                                        $uppercase = preg_match('@[A-Z]@', $password1);
                                                        $lowercase = preg_match('@[a-z]@', $password1);
                                                        $number    = preg_match('@[0-9]@', $password1);
                                                        $specialChars = preg_match('@[^\w]@', $password1);

                                                        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password1) < 8) {
                                                            $pwderr= 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                                                        }else{
                                                            $pwderr= 'Strong password.';
                                                            if($password1 != $password2){
                                                                    $confirmpwd = "Entered password dosen't match";
                                                                }else{
                                                                    // $hash_pwd =password_hash($password1,PASSWORD_DEFAULT);
                                                                    $sql = "INSERT INTO `dept_head` (`employeeid`,`name`,`department`,`email`,`contactno`,`profilepic_m`,`username`,`password`) VALUES ( '$employeeid','$name','$department','$email','$contactno','$profilepic_m','$username','$password_1')";
                                                                    $sql1 = "INSERT INTO `company_admin` (`username`,`password`) VALUES ('$username','$password1')";
                                                                    
                                                                    $result = $conn->query($sql);
                                                                    $result1 = $conn->query($sql1);
                                                                    if($result1 && $result){
                                                                    //$sql ="INSERT INTO `c_admins` (`id`, `employeeid`, `name`, `admin_type`, `email`, `contactno`, `username`, `password`) VALUES (NULL, '27', 'desfsf', 'sfgreg', 'egweg', 'wegweg', 'wegweg', 'wegfewg')";
                                                                    header("location: listadmin.php");
                                                                    
                                                                    
                                                                    
                                                                    
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
<h2>Department Head</h2>  
<div class = "error">* Required Field </div> 
</div> 
  
<!--  <div class="signupform"> -->

<form class="form-inline" action method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">    
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
<td><label for="department">Department: </label> </td> 
<td><input type="text" id="department" placeholder="Enter Department Name" name="department" required>   
    <span class="error">*  </span>  

<div class="error"> <?php echo $departmentErr; ?> </div>  </td> </tr>

<br><br>
<tr>  
<td><label for="email">Email: </label> </td>
<td><input type="email" id="email" placeholder="Enter E-mail" name="email" required>  
    <span class="error">* </span>   

<div class="error"> <?php echo $emailErr; ?> </div> </td> </tr>

   <br><br>
<tr>
    <td><label for="contactno">Contact Number : </label>  </td>  
    <td><input type="text" id="contactno" placeholder="Enter Contact Number" name="contactno" required>  
    <span class="error">* </span>  

<div class="error">  <?php echo $contactnoErr; ?> </div> </td> </tr> 

   <br><br>
<tr>
    <td><label for="username">Username: </label> </td>  
    <td><input type="text" id="username" placeholder="Enter the username" name="username" required>  
    <span class="error">*  </span>  

<div class="error">  <?php echo $usernameErr; ?> </div> </td> </tr> 

   <br><br>
<tr>
    <td><label for="password1">Enter Password: </label> </td>
    <td><input type="password" id="password1" placeholder="Enter the password" name="password1" required> 
    <span class="error">* </span>

<div class="error"> <?php echo $pwderr; ?></div> </td> </tr>

<br /> <br />
<tr>
<td><label for="password2">Confirm Password: </label> </td>
    <td><input type="password" id="password2" placeholder="Confirm the password" name="password2" required> 
    <span class="error">* </span>

<div class="error"> <?php echo $confirmpwd;?> </div></td> </tr></table>
 
    <br /> 

            <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><a href="listadmin.php"><b>Save</b></button>
            <button class="inner2" type="input" name="reset"><b>Cancel</b></button>
        </div>
            <?php if(isset($msg)) {echo $msg; } ?>

</div>                          
</form>  
</div>  


</div>  
    
</body>  
</html>


