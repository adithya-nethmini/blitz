<?php
if(!isset($mysqli)){include 'functions.php';}
$mysqli = connect();
if(isset($_POST["id"])) {
    $id = $_POST["id"];
    $sql = "UPDATE task_list SET status=5 WHERE id='$id'";
    if (mysqli_query($mysqli, $sql)) {
        $checked = '';
        if ($_POST["status"] == 5) {
            $checked = 'checked';
        }
        header('location:project_viewtask.php?id=' . $id . '&checked=' . $checked);
    } else {
        echo  mysqli_error($mysqli);
    }
}
?>
