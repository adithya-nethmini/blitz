<?php
include("connection.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<?php  
include("connection.php");
// define variables to empty values  
$employeeidErr= $nameErr = $admin_typeErr = $emailErr = $contactnoErr = $usernameErr = $pwderr =$confirmpwd= $agreeErr=  "";  
$employeeid= $name = $admin_type = $email = $contactno = $username = $password1 = $password2  = $agree= "";  
  
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
                        //Email Validation   
                        if (empty($_POST["email"])) {  
                                $emailErr = "Email is required";  
                        } else {  
                                $email = input_data($_POST["email"]);  
                                // check that the e-mail address is well-formed  
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                                    $emailErr = "Invalid email format";  
                                } else{
                                    if(empty($_POST["admin_type"])){
                                        $admin_typeErr = "Admin Type is required";
                                    
                                    }
                                    else{
                                        $admin_type = input_data($_POST['admin_type']) ;
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
                                                                    $sql = "INSERT INTO `c_admins` (`employeeid`,`name`,`admin_type`,`email`,`contactno`,`username`,`password`) VALUES ( '$employeeid','$name','$admin_type','$email','$contactno','$username','$password1')";
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
      
function input_data($data) {  
  $data = trim($data);  
  $data = stripslashes($data);  
  $data = htmlspecialchars($data);  
  return $data;  
}  


?>  

<img src="logowhite.png" alt="">  
<div class="box">
  
<p>Department Head</p>  
<div class = "error">* Required Field </div>  
  
 <div class="signupform">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">    
<div class="input-row">
    <label>Employee ID: </label>  
<div class="inputerr">
<div class="flexrow">
    <input type="text" name="employeeid">  
    <span class="error">* </span>
</div>
         <div class="error"> <?php echo $employeeidErr; ?> </div>  
</div>
    <br><br>  
</div>
<div class="input-row">
    <label>Name: </label>
<div class="inputerr">
<div class="flexrow">  
    <input type="text" name="name">  
    <span class="error">* </span>  
</div>
    <div class="error"> <?php echo $nameErr; ?> </div>  
</div>
<br><br>  
</div>
<div class="input-row">
    <label>Email: </label> 
<div class="inputerr">
<div class="flexrow"> 
    <input type="text" name="email">  
    <span class="error">* </span>   
</div>
<div class="error"> <?php echo $emailErr; ?> </div>  
</div>
<br><br>  
</div>
<div class="input-row">
    <label>Admin Type: </label>  
    <div class="inputerr">
    <div class="flexrow">   
    <select name="admin_type" id="admin_type">
    <option value=""></option>  
    <option value="Admin">Admin</option>  
    <option value="KPI_Manager">KPI Manager</option>  
    <span class="error">*  </span>  
   </select> 
</div>
<div class="error"> <?php echo $admin_typeErr; ?> </div>  
</div>
   <br><br>
</div> 
<div class="input-row">
    <label>Contact Number : </label>  
    <div class="inputerr">
    <div class="flexrow">   
    <input type="text" name="contactno">  
    <span class="error">* </span>  
    </div>
<div class="error">  <?php echo $contactnoErr; ?> </div>  
</div>
   <br><br>
</div> 
<div class="input-row">
    <label>Username: </label>   
    <div class="inputerr">
    <div class="flexrow"> 
    <input type="text" name="username">  
    <span class="error">*  </span>  
    </div>
<div class="error">  <?php echo $usernameErr; ?> </div>  
</div>
   <br><br>
</div>
<div class="input-row">
    <label>Enter Password: </label> 
    <div class="inputerr">
    <div class="flexrow"> 
    <input type="password" name="password_1">
    <div class="error">* </div>
</div>
<div class="error"> <?php echo $pwderr; ?></div> 
</div> 
<br /> <br />
</div>
<div class="input-row">
    <label>Confirm Password: </label> 
    <div class="inputerr">
    <div class="flexrow"> 
    <input type="password" name="password_2">
    <div class="error">* </div>
</div>
<div class="error"> <?php echo $confirmpwd;?> </div>
    </div> 
    <br /> 
 </div>  
                    
    <div class="input-group flexrow">
			
            <button type="submit" class="btn">+Add</button>
            <button class="btn"><a href="listadmin.php">Cancel</a></button>
            <?php if(isset($msg)) {echo $msg; } ?>
		</div>
                            
</form>  
</div>  


</div>  
    
</body>  
</html>


