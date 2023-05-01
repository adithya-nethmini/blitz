<?php
include '../function/function.php';
include 'sidebar.php';
include 'header.php';

if (!isset($_SESSION["user"])) {
    header("location: login.php");

    exit();
}
$mysqli = connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blitz</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/css/reports.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
</head>
<section>
    <div class="profile-container">

        <div class="page">

            <div class="page-content">
                <div class="group">
                    <div class= "button">
                        <a href="stats.php"><i class="fa-solid fa-chart-simple"></i> &nbsp;Stats</a>
                    </div>
                </div>
                <div class="leave-container1">

                    <div class="header">
                        <div class="topic"><h3>Project Progress Evaluation</h3></div>
                        <div class="button_p">
                        <button style="background-color:transparent;border:none;color:white" id="PrintButton" onclick="PrintTable()"><i class='fa-solid fa-print'></i>Print</button>
                        <!-- <a href=""><i class='fa-solid fa-print'></i>Print</a> -->
                    </div>
                    </div>

                    <div class="all-tasks">

                        <table id="table" class="task-tbl">

                    </div>
                    <tr  class="table-header">
                        <th>Project</th>
                        <th>Total No. of Tasks </th>
                        <th>Completed Tasks</th>
                        <th>Work Duration</th>
                        <th>Progress</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $qry = "SELECT id,name,start_date,end_date,status from project_list WHERE manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0";
                    $result = $mysqli->query($qry);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row ['id'];
                            echo '
                <tr>
                    <td>' . $row['name'] . '<br>Due date : ' . $row['end_date'] . '</td>
                    <td>10</td>
                    <td>7</td>
                    <td>6Hr/s</td>
                    <td><div class="container_pro">
                        <div class="project progress">70%</div>
                        </div></td>';
                            if($row['status']==0){echo '<td><span id="started"> Started</span></td>';}
                            elseif ($row['status']==3){echo'<td><span id="ongoing"> On-Progress</span></td>';}
                            elseif ($row['status']==5){echo'<td><span id="done"> Done</span></td>';}

                        }
                    }
                    else{
                        echo mysqli_error($mysqli);
                    }
                    ?>

                    </tr>
                    </table>
                </div></div>

            <div class="leave-container2">

                <div class="header">
                    <div class="topic"><h3>Member Performance Evaluation</h3></div>
                    <div class= "button_p">
                        <i class="fa-solid fa-print"></i> Print
                    </div>
                </div>

                <div class="all-tasks">

                    <table id="table" class="task-tbl">

                </div>
                <tr  class="table-header">
                    <th>Employee ID</th>
                    <th>Employee Name </th>
                    <th>No.of Tasks Assigned</th>
                    <th>Completed Tasks</th>
                    <th>Attendance</th>
                    <th>Performance</th>
                    <th>User Type</th>
                </tr>
                <?php
                $user = $_SESSION['user'];
                $qry = "SELECT employeeid,name from employee where username = '$user'";
                $result = $mysqli->query($qry);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                <tr>
                    <td>' . $row['employeeid'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>10</td>
                    <td>7</td>
                    <td>70%</td>
                    <td>70%</td>
                    <td><span id="user_t">Silver</span></td>';

                    }
                }
                else{
                    echo mysqli_error($mysqli);
                }
                ?>

                </tr>
                </table>
            </div>
            <script type="text/javascript">
    function PrintTable() {
        var printContents = document.getElementById('table').outerHTML;
        var originalContents = document.body.innerHTML;

        // Create a new style element and set its content to the CSS styles of the table
        var style = document.createElement('style');
        style.innerHTML = `
        .task-tbl{
    width: 100%;
    overflow-x: auto;
    overflow-y: auto;
    table-layout: fixed;
    display: inline-block;
    height: 250px;
    border-collapse: separate;
    border-spacing: 0px;
    color: #51619b;
    font-weight: 520;
    margin-top: 10px;
}

.task-tbl tr {
    border: 2px solid grey ;
}


.task-tbl tr th{
    border-bottom: 2px solid grey ;
    padding: 10px 5px;
    font-size: 17px;
    position: sticky;
    position: -webkit-sticky;
    top: 0;
    z-index: 2;
}

.task-tbl tr td{
    text-align: center;
    padding: 10px 5px;
    font-size: 14px;
    border-bottom: 1px solid grey ;
    z-index: -2;
}

        `;

        // Append the style element to the HTML content of the table
        printContents = style.outerHTML + printContents;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
    }
    window.addEventListener('DOMContentLoaded', (event) => {
        PrintPage()
        setTimeout(function() {
            window.close()
        }, 750)
    });
    </script>