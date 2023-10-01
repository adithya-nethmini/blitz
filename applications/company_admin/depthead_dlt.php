<?php 
if(!isset($c)){include 'connection.php';}

$stmt = $conn->prepare("DELETE FROM `dept_head` WHERE `id`=?");

// bind param
$stmt->bind_param("i", $_GET['id']);

if ($stmt->execute()) {
    header('location: list_depthead.php');
    echo "<div class='alert alert-danger'>Succesfully Deleted.</div>";
} else {
    echo "<div class='alert alert-danger'>There was an error in deleting. Please try again.</div>";
}


// close prepare statement
$stmt->close();

// close connection
$conn->close();

?><?php
if (!isset($mysqli)) {
    include 'connection.php';
}

$mysqli = conn();

$stmt = $mysqli->prepare("DELETE FROM `dept_head` WHERE `id`=?");

// bind param
$stmt->bind_param("i", $_GET['id']);

if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    if ($stmt->execute()) {
        header('location: list_depthead.php');
        echo "<div class='alert alert-danger'>Successfully Deleted.</div>";
    } else {
        echo "<div class='alert alert-danger'>There was an error in deleting. Please try again.</div>";
    }
} else {
    echo "
        <script>
            var confirmDelete = confirm('Do you really want to delete this record?');
            if (confirmDelete) {
                window.location.href = 'delete_record.php?id={$_GET['id']}&confirm=true';
            } else {
                window.location.href = 'list_depthead.php';
            }
        </script>
    ";
}

// close prepare statement
$stmt->close();

// close connection
$mysqli->close();
?>
