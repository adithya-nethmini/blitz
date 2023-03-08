<?php include("../function/function.php");

$mysqli=connect();

$stmt = $mysqli->prepare("DELETE FROM `task` WHERE `id`=? AND `username` = ?");

// bind param
$stmt->bind_param("is", $_GET['id'], $_SESSION['user']);

if( $stmt->execute() ) {
	echo "<div class='alert alert-success'>Task has been deleted. <a href='task-manager.php'>Back to Task Manager</a></div>";
}  else {
	echo "<div class='alert alert-danger'>There was an error in deleting the task. Please try again.</div>";
}

// clsoe prepare statement
$stmt->close();

// close connection
$mysqli->close();

?>