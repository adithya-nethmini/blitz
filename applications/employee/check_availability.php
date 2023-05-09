<?php

$mysqli = connect();
$user = $_SESSION['user'];
$stmt = $mysqli->prepare("SELECT name FROM `employee`");
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($assigned_to_be);
    while ($stmt->fetch()) {
        $stmt = $mysqli->prepare("SELECT assigned_person FROM `e_leave` WHERE status != 'Canceled' AND ((start_date <= '$start_date' AND last_date >= '$start_date') OR (start_date <= '$last_date' AND last_date >= '$last_date') OR (start_date >= '$start_date' AND last_date <= '$last_date'))");
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($assigned_person);
            $current_date = NULL;
            while ($stmt->fetch()) {
            }
        }
    }
}