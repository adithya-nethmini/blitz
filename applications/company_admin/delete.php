<?php
include 'connection.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];
    $sql = "UPDATE `dept_head` SET `status` = 'inactive' WHERE `id` = $id";
    $result = $conn->query($sql);
    if($result){
        echo "<script>alert('Record has been deleted successfully.')</script>";
    }
}

?>
