<?php 
$id = $_GET["id"];

require_once "function.php";
$mysqli = connect();

// Prepare the SQL statement with a parameterized query
$sql = "UPDATE e_leave SET status = 'Accepted' WHERE id = ?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("Failed to prepare statement: " . $mysqli->error);
}

// Bind the parameter to the statement and execute the update
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("Failed to execute statement: " . $stmt->error);
}
else {
    header("location: manage-leave.php?cancel-successfully");
}

$sql = "SELECT name,leave_type FROM e_leave WHERE id = ?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("Failed to prepare statement: " . $mysqli->error);
}

$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("Failed to execute statement: " . $stmt->error);
}

// Bind the results to variables and display them
$stmt->bind_result($name, $leave_type);
$stmt->fetch();
$stmt->close();

// Insert into notification table
$sql2 = "INSERT INTO notification(notification_name, notification_description, notification_type, username, status) VALUES('Leave Accepted', '$leave_type', 1, '$name', 'unseen')";
$stmt2 = $mysqli->prepare($sql2);
if (!$stmt2) {
    die("Failed to prepare statement: " . $mysqli->error);
}

$stmt2->bind_param("s", $name);
if (!$stmt2->execute()) {
    die("Failed to execute statement: " . $stmt2->error);
}
$stmt2->close();

$mysqli->close();
