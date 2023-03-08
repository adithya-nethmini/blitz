<?php 
include '../function/function.php';
include 'header.php';
    
    if(isset($_GET['logout'])){
		unset($_SESSION['login']);
        session_destroy();
        header("location: ../department_head/landingpage.php");
        exit();
	}

    $mysqli = connect();
    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="feedback_form.css">
</head>
<body>
<h2>Feedback Form</h2>
<form class="form-inline" action="" method="post" autocomplete="off">
    <label for="name">Subject</label>
    <input type="text" id="name" placeholder="Enter Subject" name="name" required>
    <label for="status">Feedback</label>
    <input type="text" id="name" placeholder="Enter Your Feedback" name="name" required>
    <br>
    <br>
    <label for="description">Description:</label>
    <textarea required id="description" name="description"></textarea>
    <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><b>Save</b></button>
            <button class="inner2" type="submit" name="submit1"><a href="" > Cancel</a></b></button>
</body>
</html>

