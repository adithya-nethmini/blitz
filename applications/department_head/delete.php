<?php
if(!isset($mysqli)){include 'functions.php';}
$mysqli = connect();
$id=$_GET['id'];
$sql="DELETE from project_list WHERE id= '$id'";
$result=mysqli_query($mysqli,$sql);
if($result){
    header('location:project_list.php');
}
else{
    echo mysqli_error($mysqli);
}
$qry="DELETE from task_list WHERE project_id= '$id'";
$result=mysqli_query($mysqli,$qry);
if($result){
    header('location:project_list.php');
}
else{
    echo mysqli_error($mysqli);
}

?>