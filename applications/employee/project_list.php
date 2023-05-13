<?php
if (!isset($mysqli)) {
    include '../function/function.php';
}
include 'sidebar.php';
include 'header.php';

$mysqli = connect();
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

                <div class="group">
                    <div class="button">
                    <?php
                        $user = $_SESSION['user'];
                        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM project_list WHERE manager_id = ? OR FIND_IN_SET(?, user_ids) > 0");
                        $stmt->bind_param("ss", $user, $user);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_array();
                        $count = $row[0];
                        ?>

                            <a href="task_list.php"><i class="fa fa-tasks"></i>&nbsp;&nbsp;<?php echo $count;?>&nbsp;Projects</a>

                    </div>
                </div>
                <br>
                <div class="leave-container">

                    <div class="header">
                        <div class="topic">
                            <h2>Project List</h2>
                        </div>
                        <div class="div-search">
                            &nbsp;&nbsp;<i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="search" onkeyup="searchFunctionProjects()" placeholder="Search" title="Search">
                        </div>
                    </div>
                    <div class="all-tasks">
                        <table id="table" class="task-tbl">

                    </div>
                    <tr class="table-header">
                        <th>Project</th>
                        <th>Date Started </th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $user = $_SESSION['user'];
                    
                    $qry = "SELECT * FROM project_list WHERE manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0";
                    $result = $mysqli->query($qry);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            echo '
                            <tr>
                                <td>' . $row['name'] . '</td>
                                <td>' . $row['start_date'] . '</td>
                                <td>' . $row['end_date'] . '</td> ';
                            if ($row['status'] == 0) {
                                echo '<td><span class="started"> Started</span></td>';
                            } elseif ($row['status'] == 3) {
                                echo '<td><span class="ongoing"> On-Progress</span></td>';
                            } elseif ($row['status'] == 5) {
                                echo '<td><span class="done"> Done</span></td>';
                            }
                            echo ' <td>
                                    <div class="">
                                        <a href="project_view.php?id=' . $id . '"><button class="view-btn">View</button></a>
                                    </div>
                                </td>';
                        }
                    } else {
                        echo mysqli_error($mysqli);
                    }
                    ?>

                    </tr>
                    </table>

                    <script>
                        function searchFunctionProjects() {
                            var input, filter, table, tr, td, i;
                            input = document.getElementById("search");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("table");
                            tr = table.getElementsByTagName("tr");
                            for (var i = 0; i < tr.length; i++) {
                                var tds = tr[i].getElementsByTagName("td");
                                var flag = false;
                                for (var j = 0; j < tds.length; j++) {
                                    var td = tds[j];
                                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                        flag = true;
                                    }
                                }
                                if (flag) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    </script>

                </div>
            </div>

        </div>
        </td>

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