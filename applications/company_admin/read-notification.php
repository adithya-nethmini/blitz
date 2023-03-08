<?php 

$id = $_GET["id"];

require_once "function.php";
$mysqli = connect();
$sql = "UPDATE notification SET status = 'Read' WHERE id = '$id' ";
$result = mysqli_query($mysqli , $sql);
if($result){
    header("Location: notification.php?remove-notification-successfuly");
}

?>