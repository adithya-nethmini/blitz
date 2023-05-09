<?php
if(!isset($mysqli)){include 'functions.php';}
//include 'sidebar.php';
//include 'header.php';
$mysqli = connect();
$id=$_GET['id'];
$sql="SELECT proofs from task WHERE id='$id'";
$result=mysqli_query($mysqli,$sql);
$row = mysqli_fetch_assoc($result);
$document_data = $row['proofs'];


header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"document.pdf\"");

echo $document_data;

?>
