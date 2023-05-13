<?php
if (!isset($mysqli)) {
    include 'connection.php';
}

include 'sidebar.php';
include 'header.php';

// Fetch data for autofilling fields
$employeeid = "";
$name = "";
$department = "";
$email = "";
$contactno = "";
$username = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM dept_head WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employeeid = $row['employeeid'];
        $name = $row['name'];
        $department = $row['department'];
        $email = $row['email'];
        $contactno = $row['contactno'];
    }
}

if (isset($_POST['update'])) {
    // Fetch input $_POST
    $employeeid = $conn->real_escape_string($_POST['employeeid']);
    $name = $conn->real_escape_string($_POST['name']);
    $department = $conn->real_escape_string($_POST['department']);
    $email = $conn->real_escape_string($_POST['email']);
    $contactno = $conn->real_escape_string($_POST['contactno']);
    // $profilepic_e = $mysqli->real_escape_string($_POST['profilepic_e']);

    // Prepared statement
    $stmt = $conn->prepare("UPDATE `dept_head` SET `employeeid` =?, `name`=?, `department`=?, `email`=?, `contactno`=? WHERE `id`='$id'");

    // Bind params
    mysqli_free_result($result);
    if (!$stmt) {
        echo ("Failed to prepare statement: " . $conn->error);
    }

    // Bind the parameter to the statement and execute the update
    $stmt->bind_param("sssss", $employeeid, $name, $department, $email, $contactno);
    if (!$stmt->execute()) {
        echo ("Failed to execute statement: " . $stmt->error);
    }

    echo '<script>window.location.href = "http://localhost/interim/blitz/list_depthead.php";</script>';
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
            <h2>Update Department Head</h2>
            <br> <br> <br> <br> <br> <br>
            <div class="error">* Required Field</div>
        </div>

        <form class="form-inline" action="" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                </tr>

            </table>

            <br>

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
    </div>
</body>

</html>