<?php include("../function/function.php");

$mysqli = connect();

$stmt = $mysqli->prepare("DELETE FROM `e_leave` WHERE `id`=?");

// bind param
$stmt->bind_param("i", $_GET['id']);

if ($stmt->execute()) {
    header('location: leave-status.php');
} else {
    echo "<div class='alert alert-danger'>There was an error in deleting the leave. Please try again.</div>";
}

// clsoe prepare statement
$stmt->close();

// close connection
$mysqli->close();
