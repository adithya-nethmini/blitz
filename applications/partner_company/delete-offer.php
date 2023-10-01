<?php include("function.php");

$mysqli=connect();

$stmt = $mysqli->prepare("DELETE FROM `offers` WHERE `id`=? AND `username` = ?");

// bind param
$stmt->bind_param("is", $_GET['id'], $_SESSION['pcompany_user']);

if( $stmt->execute() ) {
	echo "<div class='alert alert-success'>offer has been deleted. <a href='task-manager.php'>Back to company feed</a></div>";
}  else {
	echo "<div class='alert alert-danger'>There was an error in deleting the offer. Please try again.</div>";
}

// clsoe prepare statement
$stmt->close();

// close connection
$mysqli->close();

?>