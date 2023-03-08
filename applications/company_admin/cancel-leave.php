<?php 

$id = $_GET["id"];

require_once "function.php";
$mysqli = connect();
$sql = "UPDATE e_leave SET status = 'Canceled' WHERE id = '$id' ";
$result = mysqli_query($mysqli , $sql);
if($result){
    header("Location: manage-leave.php?cancel-successfuly");
}

?>