<?php
if (!isset($mysqli)) {
    include 'connection.php';
}

//include 'sidebar.php';
//include 'header.php';

// Fetch data for autofilling fields
$employeeid = "";
$name = "";
$department = "";
$jobrole = "";
$email = "";
$contactno = "";
$jobstartdate = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM employee WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employeeid = $row['employeeid'];
        $name = $row['name'];
        $department = $row['department'];
        $jobrole = $row['jobrole'];
        $email = $row['email'];
        $contactno = $row['contactno'];
        $jobstartdate = $row['jobstartdate'];
    }
}

if (isset($_POST['update'])) {
    // Fetch input $_POST
    $employeeid = $conn->real_escape_string($_POST['employeeid']);
    $name = $conn->real_escape_string($_POST['name']);
    $department = $conn->real_escape_string($_POST['department']);
    $jobrole = $conn->real_escape_string($_POST['jobrole']);
    $email = $conn->real_escape_string($_POST['email']);
    $contactno = $conn->real_escape_string($_POST['contactno']);
    $jobstartdate = $conn->real_escape_string($_POST['jobstartdate']);

    // Prepared statement
    $stmt = $conn->prepare("UPDATE `employee` SET `employeeid` =?, `name`=?, `department`=?, `jobrole`=?,`email`=?, `contactno`=?, `jobstartdate`=? WHERE `id`='$id'");

    // Bind params
    if (!$stmt) {
        echo ("Failed to prepare statement: " . $conn->error);
    } else {
        // Bind the parameter to the statement and execute the update
        $stmt->bind_param("sssssss", $employeeid, $name, $department, $jobrole, $email, $contactno, $jobstartdate);
        if (!$stmt->execute()) {
            echo ("Failed to execute statement: " . $stmt->error);
        }
        
        echo '<script>window.location.href = "http://localhost/interim/blitz/list_employee.php";</script>';
    }

    mysqli_stmt_close($stmt);
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="create.css">
</head>

<body>
    <div class="container">
        <br> <br> <br> <br> <br> <br>
        <div class="up">
            <h2>Update Employee</h2>
            <br> <br> <br> <br> <br> <br>
            <div class="error">* Required Field</div>
        </div>

        <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
            <table>

            <tr>
                    <td><label for="employeeid">Employee ID:</label></td>
                    <td><input type="text" id="employeeid" placeholder="Enter Employee ID" name="employeeid" value="<?php echo $employeeid; ?>" required>
                        <span class="error">*</span>
                        <div class="error"><?php echo @$employeeidErr; ?></div>
                    </td>
                </tr>

                <br><br>
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" id="name" placeholder="Enter Employee's Name" name="name" value="<?php echo $name; ?>" required>
                        <span class="error">*</span>
                        <div class="error"><?php echo @$nameErr; ?></div>
                    </td>
                </tr>

                <br><br>
                <tr> 
                    <td><label for="department">Department:</label></td>
                    <td>
                        <select id="department" name="department" required>
                            <option value="" selected disabled>Select Department</option>
                            <option value="HR" <?php if ($department == "HR") echo "selected"; ?>>HR</option>
                            <option value="Finance" <?php if ($department == "Finance") echo "selected"; ?>>Finance</option>
                            <option value="Marketing" <?php if ($department == "Marketing") echo "selected"; ?>>Marketing</option>
                            <option value="Administration" <?php if ($department == "Administration") echo "selected"; ?>>Administration</option>
                            <option value="Legal" <?php if ($department == "Legal") echo "selected"; ?>>Legal</option>
                            <option value="IT" <?php if ($department == "IT") echo "selected"; ?>>IT</option>
                        </select>
                        <span class="error">*</span>
                        <div class="error"><?php echo @$departmentErr; ?></div>
                    </td>
                </tr>

                <br><br>
                <tr> 
                    <td><label for="jobrole">Job Role:</label></td>
                    <td>
                        <select id="jobrole" name="jobrole" required>
                            <option value="" selected disabled>Select Job Role</option>
                            <option value="Manager" <?php if ($jobrole == "Manager") echo "selected"; ?>>Manager</option>
                            <option value="Employee" <?php if ($jobrole == "Employee") echo "selected"; ?>>Employee</option>
                        </select>
                        <span class="error">*</span>
                        <div class="error"><?php echo @$jobroleErr; ?></div>
                    </td>
                </tr>

                <br><br>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" placeholder="Enter E-mail" name="email" value="<?php echo $email; ?>" required>
                        <span class="error">*</span>
                        <div class="error"><?php echo @$emailErr; ?></div>
                    </td>
                </tr>
               
                <br><br>
                <tr>
                    <td><label for="contactno">Contact Number:</label></td>
                    <td><input type="text" id="contactno" placeholder="Enter Contact Number" name="contactno" value="<?php echo $contactno; ?>" required>
                        <span class="error">*</span>
                        <div class="error"><?php echo @$contactnoErr; ?></div>
    </td>
    <tr>
                    <td><label for="jobstartdate">Job Start Date:</label></td>
                    <td><input type="text" id="jobstartdate" placeholder="Enter Job Start Date" name="jobstartdate" value="<?php echo $jobstartdate; ?>" required>
                        <span class="error">*</span>
                        <div class="error"><?php echo @$jobstartdateErr; ?></div>
                    </td>
                </tr>
            </table>

            <br>

            <div class="inline-block">
                <div class="bar">
                    <button class="inner1" type="submit" name="update"><a href="list_employee.php"><b>Save</b></button>
                    <button class="inner2" type="input" name="reset"><b>Cancel</b></button>
                </div>
                <?php if (isset($msg)) {
                    echo $msg;
                } ?>
            </div>
        </form>
    </div>
</body>

</html>

