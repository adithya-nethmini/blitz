<?php
if(!isset($mysqli)){include 'functions.php';}
//include 'sidebar.php';
//include 'header.php';
$mysqli = connect();
$id=$_GET['id'];
$sql="SELECT proofs from task_list WHERE id='$id'";
$result=mysqli_query($mysqli,$sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $document_data = $row['proofs'];

    $download_file_name = 'proofs.pdf';

    $file_path = '/path/to/save/' . $download_file_name;
    file_put_contents($file_path,  $document_data);

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $download_file_name);

    echo $document_data;
} else {
    echo "Error retrieving PDF from database";
}
?>
