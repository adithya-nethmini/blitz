<?php 

//signup selection

function selectRadio($signup_Option){
	if(isset($_POST['signup-option'])){
		$signup_Option = $_POST['signup-option'];
		if($signup_Option == "Employee"){
			header("location: signup.php");
		}else{
			header("location: packages.php");
		}}}

function logoutUser(){

	session_destroy();
	header("location: ../../login.php");
	exit();

}
?>
