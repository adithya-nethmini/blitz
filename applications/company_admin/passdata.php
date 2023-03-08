<?php  
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
}  
    if (empty($_POST["name"])) {  
         $nameErr = "Name is required";  
    } else {  
        $name = input_data($_POST["name"]);  
            // check if name only contains letters and whitespace  
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {  
                $nameErr = "Only alphabets and white space are allowed";  
            }  
    }  
      
    //Email Validation   
    if (empty($_POST["email"])) {  
            $emailErr = "Email is required";  
    } else {  
            $email = input_data($_POST["email"]);  
            // check that the e-mail address is well-formed  
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                $emailErr = "Invalid email format";  
            }  
     }  
    
    //Number Validation  
    if (empty($_POST["contactno"])) {  
            $contactnoErr = "Mobile no is required";  
    } else {  
            $contactno = input_data($_POST["contactno"]);  
            // check if mobile no is well-formed  
            if (!preg_match ("/^[0-9]*$/", $contactno) ) {  
            $contactnoErr = "Only numeric value is allowed.";  
            }  
        //check mobile no length should not be less and greator than 10  
        if (strlen ($contactno) != 10) {  
            $contactnoErr = "Mobile no must contain 10 digits.";  
            }  
    }  
      
    
    //Checkbox Validation  
    if (!isset($_POST['agree'])){  
            $agreeErr = "Accept terms of services before submit.";  
    } else {  
            $agree = input_data($_POST["agree"]);  
    }  


    //password check
    // if(!isset($_POST['password1'])){
    //          $password1
    
    // Given password
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];


// Validate password strength
$uppercase = preg_match('@[A-Z]@', $password1);
$lowercase = preg_match('@[a-z]@', $password1);
$number    = preg_match('@[0-9]@', $password1);
$specialChars = preg_match('@[^\w]@', $password1);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password1) < 8) {
    $pwderr= 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
}else{
    $pwderr= 'Strong password.';
    if(
        $password1 != $password2)
        {
            $confirmpwd = "Entered password dosen't match";
        }
    
}
    } else {  
        $formerr= "<h3> <b>You didn't filled up the form correctly.</b> </h3>";  
    
}  
function input_data($data) {  
  $data = trim($data);  
  $data = stripslashes($data);  
  $data = htmlspecialchars($data);  
  return $data;  
}  
?>  