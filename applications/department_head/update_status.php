<?php
if(!isset($mysqli)){include 'functions.php';}
//include 'sidebar.php';
//include 'header.php';
$mysqli = connect();
if(isset($_POST["id"])) {
    $id = $_POST["id"];
    $sql = "UPDATE task SET status=5 WHERE id='$id'";
    if (mysqli_query($mysqli, $sql)) {
        $checked = '';
        if ($_POST["status"] == 5) {
            $checked = 'checked';
        }
        header('location:task_view.php?id=' . $id . '&checked=' . $checked);
    } else {
        echo  mysqli_error($mysqli);
    }
}
?>
