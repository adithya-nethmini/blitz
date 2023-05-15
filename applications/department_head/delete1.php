<?php
if(!isset($mysqli)){include 'functions.php';}
$mysqli = connect();
$id=$_GET['id'];
$sql="DELETE from task WHERE id= '$id'";
$result=mysqli_query($mysqli,$sql);
if($result){
    header('location:task_list.php');
}
else{
    echo mysqli_error($mysqli);
}
?>