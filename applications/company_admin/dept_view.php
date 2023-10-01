<?php
    if (!isset($mysqli)) {
        include 'connection.php';
    }
    include 'sidebar.php';
    include 'header.php';
    ?>
    
    <div class="content-container">
        <div class="form-container">
            <?php
            // Retrieve the department ID from the URL parameter
            if (isset($_GET['id'])) {
                $department_id = $_GET['id'];

                // Prepare and execute the SQL query with the department ID
                $sql = "SELECT departmentname, description FROM department WHERE id = $department_id";
                $result = $conn->query($sql);

                if ($result === false) {
                    die("Error executing the query: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    echo "<form>";

                    // Fetch data from the result set
                    $row = $result->fetch_assoc();
                    $departmentname = $row["departmentname"];
                    $description = $row["description"];

                    // Display the data in a form
                    echo "<label>Department Name:</label>";
                    echo "<input type='text' value='$departmentname' readonly><br>";

                    echo "<label>Description:</label>";
                    echo "<textarea readonly>$description</textarea><br>";

                    echo "<hr>";

                    echo "</form>";
                } else {
                    echo "Department not found.";
                }
            } else {
                echo "Invalid department ID.";
            }

            // Close the database connection
            $conn->close();
            ?>


<!DOCTYPE html>
<html>
<head>
    <title>Department View</title>
    <link rel="stylesheet" href="deptview.css">
        
</head>
<body>
</body>
</html>
