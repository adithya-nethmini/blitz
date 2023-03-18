<?php include("../function/function.php");

$mysqli=connect();

$stmt = $mysqli->prepare("UPDATE `employee` SET `profilepic_e`='' WHERE `username`=?");

// bind param
$stmt->bind_param("s", $_SESSION['user']);

if( $stmt->execute() ) {
	echo "<div class='alert alert-success'>Profile picture has been deleted. <a href='profile.php'>Profile</a></div>";
}  else {
	echo "<div class='alert alert-danger'>There was an error in deleting the task. Please try again.</div>";
}

// clsoe prepare statement
$stmt->close();

// close connection
$mysqli->close();

?>