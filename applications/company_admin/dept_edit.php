<?php
if (!isset($mysqli)) {
    include 'connection.php';
}
include 'sidebar.php';
include 'header.php';

// Fetch data for autofilling fields
$departmentname= "";
$description = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

        // Fetch the department data from the database
        $sql = "SELECT * FROM `department` WHERE `id`='$id'";
        $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employeeid = $row['departmentname'];
        $name = $row['description'];
    } else {
        echo mysqli_error($mysqli);
    }
}

if (isset($_POST['update'])) {
    $departmentname = $conn->real_escape_string($_POST['departmentname']);
	$description = $conn->real_escape_string($_POST['description']);

   	// Prepared statement
	$stmt = $conn->prepare("UPDATE `department` SET `departmentname` =?, `description`=? WHERE `id`='$id'");

	// Bind params
	mysqli_free_result($result);
    if (!$stmt) {
        echo ("Failed to prepare statement: " . $conn->error);
    }

    // Bind the parameter to the statement and execute the update
    $stmt->bind_param("ss", $departmentname,$description);
    if (!$stmt->execute()) {
        echo ("Failed to execute statement: " . $stmt->error);
    }
    
    echo '<script>window.location.href = "list_dept.php";</script>';
    mysqli_stmt_close($stmt);
    $conn->close();

}

?>

<link rel="stylesheet" href="createdept.css">
<title>Blitz</title>
<br/> <br/><br/> <br/> <br/><br/>
<h2>Edit Department</h2>
<form class="form-inline" action="" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="name">Department Name:</label>
    <input type="text" id="departmentname" placeholder="Enter Department Name" name="departmentname" required>
<br>
    <label for="description">Description:</label>
    <textarea required id="description" name="description"></textarea>
    <div class="inline-block">
<div class="bar">
    <button class="inner1" type="submit" name="update"><a href="list_depthead.php"><b>Save</b></button>
    <button class="inner2" type="input" name="reset"><b>Cancel</b></button>
</div>
<?php if (isset($msg)) {
    echo $msg;
} ?>
</div>
</form>
</body>
</body>
</html>
