<?php
if(!isset($mysqli)){include 'functions.php';}
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
?>
<!--<div class="col-lg-12">-->
<!--    <div class="card card-outline card-primary">-->
<!--        <div class="card-body">-->
<!--            <form action="" id="manage-project">-->
<!---->
<!--                <input type="hidden" name="id" value="--><?php //echo isset($id) ? $id : '' ?><!--">-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Name</label>-->
<!--                            <input type="text" class="form-control form-control-sm" name="name" value="--><?php //echo isset($name) ? $name : '' ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="">Status</label>-->

<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Start Date</label>-->
<!--                            <input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="--><?php //echo isset($start_date) ? date("Y-m-d",strtotime($start_date)) : '' ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">End Date</label>-->
<!--                            <input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" value="--><?php //echo isset($end_date) ? date("Y-m-d",strtotime($end_date)) : '' ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    --><?php //if($_SESSION['login_type'] == 1 ): ?>
<!--                        <div class="col-md-6">-->
<!--                            <div class="form-group">-->
<!--                                <label for="" class="control-label">Project Manager</label>-->
<!--                                <select class="form-control form-control-sm select2" name="manager_id">-->
<!--                                    <option></option>-->
<!--                                    --><?php
//                                    $managers = $mysqli->query("SELECT *,concat(name,' ',jobrole) as name FROM employee order by concat(name,' ',jobrole) asc ");
//                                    while($row= $managers->fetch_assoc()):
//                                        ?>
<!--                                        <option value="--><?php //echo $row['id'] ?><!--" --><?php //echo isset($manager_id) && $manager_id == $row['id'] ? "selected" : '' ?><!-->--><?php //echo ucwords($row['name']) ?><!--</option>-->
<!--                                    --><?php //endwhile; ?>
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //else: ?>
<!--                        <input type="hidden" name="manager_id" value="--><?php //echo $_SESSION['login_id'] ?><!--">-->
<!--                    --><?php //endif; ?>
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Project Team Members</label>-->
<!--                            <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">-->
<!--                                <option></option>-->
<!--                                --><?//php?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blitz</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reports.css">
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
                        <div class= "button_p">
                            <i class="fa-solid fa-print"></i> Print
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
                    $qry = "SELECT id,name,start_date,end_date,status from project_list";
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
                $qry = "SELECT employeeid,name from employee";
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