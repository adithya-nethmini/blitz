<?php
include '../function/function.php';

$mysqli = connect();

$start_date = $_GET["start_date"];
$last_date = $_GET["last_date"];
/* display the number of days */


$start_date = strtotime($start_date);
$last_date = strtotime($last_date);
$daysCount = ($last_date) - ($start_date);
/* convert time into dates */
$daysCount = floor($daysCount / (60 * 60 * 24));

echo $daysCount;

// $stmt = $mysqli->prepare("UPDATE INTO e_leave() VALUES('User-Registration','Registered to the system','4',?,'unseen')");
// $stmt->bind_param("s", $username);
// $stmt->execute();
// if ($stmt->affected_rows != 1) {
//     return "An error occurred. Please try again";
// } else {
//     echo 'Notification sent';
// }
