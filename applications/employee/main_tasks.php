<?php
if (!isset($mysqli)) {
    include '../function/function.php';
}
include 'sidebar.php';
include 'header.php';

$mysqli = connect();
$user = $_SESSION['user'];
if (isset($_POST['submit'])) {
    // Fetch input $_POST
    $name = $mysqli->real_escape_string($_POST['proof_of_work']);

    // Prepared statement
    $stmt = $mysqli->prepare("UPDATE `task_list` SET `proof_of_work`=?, WHERE `id`=? AND");

    // Bind params
    $stmt->bind_param("si", $proof_of_work, $_GET['id']);

    // Execute query
    if ($stmt->execute()) {
        /* $alert_message = "Task has been updated."; */
        header('location: project_list.php');
    } else {
        $alert_message = "There was an error in uploading the proofs. Please try again.";
    }

    // Close prepare statement
    $stmt->close();

    // }

    // // Prepare the SQL statement with a parameterized query
    // $sql2 = "UPDATE task_list SET proofs = ? WHERE id = ? ";
    // $stmt2 = $mysqli->prepare($sql2);
    // if (!$stmt2) {
    //     echo ("Failed to prepare statement: " . $mysqli->error);
    // }

    // // Bind the parameter to the statement and execute the update
    // $stmt2->bind_param("si", $proofs,$id);
    // if (!$stmt2->execute()) {
    //     echo ("Failed to execute statement: " . $stmt->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/css/list.css">
    <link rel="stylesheet" href="../../views/css/header.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
</head>
<title>Blitz</title>
<section>
    <div class="profile-container">

        <div class="page">

            <div class="page-content">

                <br>

                <br>
                <div class="leave-container">
                    <div class="header">
                        <div class="topic">
                            <h2>Task List</h2>
                        </div>
                        <div class="div-search">
                            &nbsp;&nbsp;<i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="search" onkeyup="searchFunctionTasks()" placeholder="Search" title="Search">
                        </div>

                    </div>

                    <div class="all-tasks">

                        <table id="table" class="task-tbl">

                    </div>
                    <tr class="table-header">
                        <th>Task</th>
                        <th>Description </th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <?php
                        $user = $_SESSION['user'];
                        $emp_id_query = "SELECT employeeid FROM employee WHERE username = '$user'";
                        $emp_id_result = $mysqli->query($emp_id_query);

                        if ($emp_id_result->num_rows > 0) :
                            // Get the employeeid value from the query result
                            $emp_id_row = $emp_id_result->fetch_assoc();
                            $emp_id = $emp_id_row['employeeid'];

                            // Use the employeeid in the $qry query
                            $qry = "SELECT * FROM task WHERE employeeid='$user'";
                            $result = $mysqli->query($qry);

                            if ($result->num_rows > 0) :
                                while ($row = $result->fetch_assoc()) :
                                    $id = $row['id'];
                                    $status = $row['status'];
                                    echo '
                                                <tr>
                                                    <td>' . @$row['name'] . '</td>
                                                    <td style="width:75%;text-align:justify">' . $row['description'] . '</td>';
                        ?>
                                    <td>
                                        <?php
                                        if ($status == '1') :
                                            $status = 'started'; ?>
                                            <span class="started"><?php echo $status; ?> </span>
                                        <?php
                                        elseif ($status == 3) :
                                            $status = 'On-Progress'; ?>
                                            <span class="ongoing"><?php echo $status; ?></span>
                                        <?php
                                        elseif ($status == 5) :
                                            $status = 'Done'; ?>
                                            <span class="done"><?php echo $status; ?></span>
                                        <?php
                                        else : ?>
                                            <span>No data</span>
                                        <?php
                                        endif; ?>
                                    </td>;
                                    <td>
                                        <a href="main_tasks_view.php?id=<?php echo $id ?>"><button class="view-btn">View</button></a>

                </div>
                </td>
    <?php

                                endwhile;

                            else :
                                echo mysqli_error($mysqli);
                            endif;
                        endif;
    ?>

    </tr>
    </table>

            </div>
            <br>

        </div>
    </div>

    </div>




</section>

</body>
<script src="../../views/js/main.js"></script>

</html>