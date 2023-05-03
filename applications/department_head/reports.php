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
                        <th>Overdue Tasks</th>
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
                    <td>' . $row['name'] . '<br>Due date : ' . $row['end_date'] . '</td>';

                            $total_tasks_query = "SELECT COUNT(*) FROM task_list WHERE project_id = '$id'";
                            $total_tasks_result = mysqli_query($mysqli, $total_tasks_query);
                            $total_tasks_row = mysqli_fetch_array($total_tasks_result);
                            $total_tasks = $total_tasks_row[0];

                      echo' <td>' . $total_tasks . '</td>';

                            $completed_tasks_query = "SELECT COUNT(*) FROM task_list WHERE project_id = '$id' AND status = 5";
                            $completed_tasks_result = mysqli_query($mysqli, $completed_tasks_query);
                            $completed_tasks_row = mysqli_fetch_array($completed_tasks_result);
                            $completed_tasks = $completed_tasks_row[0];

                            $project_progress = ($completed_tasks / $total_tasks) * 100;

                            $project_progress = number_format($project_progress, 1);

                            $overdue_tasks_query = "SELECT COUNT(*) FROM task_list WHERE project_id = '$id' AND overdue = 1";
                            $overdue_tasks_result = mysqli_query($mysqli, $overdue_tasks_query);
                            $overdue_tasks_row = mysqli_fetch_array($overdue_tasks_result);
                            $overdue_tasks = $overdue_tasks_row[0];

                      echo' <td>' . $completed_tasks . '</td>';

                      echo' <td>' . $overdue_tasks . '</td>  
                      
                    <td><div class="container_pro">
                        <div class="project progress project_' . $id . ' "> '. $project_progress .' %</div>
                        </div></td>';
                            echo '<style>
                                  .progress.project_' . $id . ' {
                                    width: ' . $project_progress . '%;
                                   }
                                  </style>';
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
                $qry = "SELECT employeeid,name,username from employee";
                $result = $mysqli->query($qry);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $employeeid = $row['employeeid'];
                        $name = $row['name'];
                        $username = $row['username'];

                        echo '
                <tr>
                    <td>' . $row['employeeid'] . '</td>
                    <td>' . $row['name'] . '</td>';

                        $assigned_tasks_query = "SELECT COUNT(*) FROM task WHERE employeeid = '$employeeid-$name'";
                        $assigned_tasks_result = mysqli_query($mysqli, $assigned_tasks_query);
                        $assigned_tasks_row = mysqli_fetch_array($assigned_tasks_result);
                        $assigned_tasks = $assigned_tasks_row[0];

                        $assigned_tasklist_query = "SELECT COUNT(*) FROM task_list WHERE emp_id = '$employeeid-$username'";
                        $assigned_tasklist_result = mysqli_query($mysqli, $assigned_tasklist_query);
                        $assigned_tasklist_row = mysqli_fetch_array($assigned_tasklist_result);
                        $assigned_tasklist = $assigned_tasklist_row[0];

                        $total_assigned_tasks = $assigned_tasks + $assigned_tasklist;

                        echo ' <td>' . $total_assigned_tasks . '</td>';

                        $completed_tasks_query = "SELECT COUNT(*) FROM task WHERE employeeid = '$employeeid-$name' AND status = 5";
                        $completed_tasks_result = mysqli_query($mysqli, $completed_tasks_query);
                        $completed_tasks_row = mysqli_fetch_array($completed_tasks_result);
                        $completed_tasks = $completed_tasks_row[0];

                        $completed_tasklist_query = "SELECT COUNT(*) FROM task_list WHERE emp_id = '$employeeid-$username' AND status = 5";
                        $completed_tasklist_result = mysqli_query($mysqli, $completed_tasklist_query);
                        $completed_tasklist_row = mysqli_fetch_array($completed_tasklist_result);
                        $completed_tasklist = $completed_tasklist_row[0];

                        $total_completed_tasks = $completed_tasks + $completed_tasklist;

                        echo ' <td>' . $total_completed_tasks . '</td>
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