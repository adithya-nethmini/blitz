<?php
include 'sidebar.php';
include 'header.php';
if(!isset($mysqli)){include("connection.php");}
$mysqli = connect();
if(isset($_POST['submit'])) {
   $departmentname = $_POST['departmentname'];
    $description = $_POST['description'];
  
    
    $qry = "INSERT INTO `department`(`departmentname`,`description`) VALUES ('$departmentname','$description')";
    if(mysqli_query($mysqli,$qry)){
        header('location:list_dept.php');
    }
    else{
        echo mysqli_error($mysqli);
    }
}

?>

<link rel="stylesheet" href="createdept.css">
<title>Blitz</title>
<br/> <br/><br/> <br/> <br/><br/>
<h2>New Department</h2>
<form class="form-inline" action="" method="post" autocomplete="off">
    <label for="name">Department Name:</label>
    <input type="text" id="departmentname" placeholder="Enter Department Name" name="departmentname" required>
<br>
    <label for="description">Description:</label>
    <textarea required id="description" name="description"></textarea>
    <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><a href="list_dept.php"><b>Save</b></button>
            <button class="inner2" type="input" name="reset"><b>Cancel</b></button>
        </div>
    </div>
</form>
</body>

</html>