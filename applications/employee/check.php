<?php
include '../function/function.php';

$mysqli = connect();

$assigned_to_be = $_GET["assigned_person"];
$start_date = $_GET["start_date"];
$last_date = $_GET["last_date"];
$stmt = $mysqli->prepare("SELECT assigned_person FROM `e_leave` WHERE assigned_person = ? AND status != 'Canceled' AND ((start_date <= '$start_date' AND last_date >= '$start_date') OR (start_date <= '$last_date' AND last_date >= '$last_date') OR (start_date >= '$start_date' AND last_date <= '$last_date'))");
$stmt->bind_param("s", $assigned_to_be);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($assigned_person);
    $current_date = NULL;
    while ($stmt->fetch()) {
        echo '<lottie-player src="https://assets2.lottiefiles.com/packages/lf20_0iuu9o.json"  background="transparent"  speed="1"  style="width: 40px; height: 40px;"  loop  autoplay></lottie-player> Not available';        
        break;
    }
} else {
    $assigned_person = $assigned_to_be;
    echo '<lottie-player src="https://assets2.lottiefiles.com/packages/lf20_65DYreJ7ru.json"  background="transparent"  speed="1"  style="width: 45px; height: 45px;"  loop autoplay></lottie-player> <span style="color:green">Available</span>';
    
}