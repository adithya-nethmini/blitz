<?php
include '../function/function.php';
$mysqli = connect();
$user = $_SESSION['user'];
$id = $_GET['id'];
// prepare the UPDATE query
$stmt = $mysqli->prepare("UPDATE `task_list` SET `proofs` = NULL, `proof_name` = NULL WHERE `id` = ?");

// bind the parameter and execute the query
$stmt->bind_param("i", $id);
$stmt->execute();

// check if the query was successful
if ($stmt->affected_rows > 0) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
} else {
    echo ("Failed to execute statement: " . $stmt->error);
}
?>
