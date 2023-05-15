<?php
if(!isset($mysqli)){include 'functions.php';}
$mysqli = connect();
$id=$_GET['id'];
$sql="DELETE from task_list WHERE id= '$id'";
$result=mysqli_query($mysqli,$sql);
if($result){
    header('location:project_list.php?id=' . $id);
}
else{
    echo mysqli_error($mysqli);
}
