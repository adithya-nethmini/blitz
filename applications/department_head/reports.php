<?php
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
$current_date = date('Y-m-d');
$current_month = date('m');
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
                            <button style="background-color:transparent;border:none;color:white" id="PrintButton" onclick="PrintTable()"><i class='fa-solid fa-print'></i>&nbsp;&nbsp;Print</button>
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
                    $dept_user = $_SESSION["dept_user"];
                    $sql = "SELECT * from dept_head WHERE employeeid = '$dept_user' ";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $dept_name = $row ['department'];
                            $qry = "SELECT id,name,start_date,end_date,status from project_list WHERE dept_name = '$dept_name'AND MONTH(end_date) = $current_month";
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

                                    echo ' <td>' . $total_tasks . '</td>';

                                    $completed_tasks_query = "SELECT COUNT(*) FROM task_list WHERE project_id = '$id' AND status = 5";
                                    $completed_tasks_result = mysqli_query($mysqli, $completed_tasks_query);
                                    $completed_tasks_row = mysqli_fetch_array($completed_tasks_result);
                                    $completed_tasks = $completed_tasks_row[0];

                                    if ($total_tasks == 0) {
                                        $project_progress = 0;
                                    } else {
                                        $project_progress = ($completed_tasks / $total_tasks) * 100;
                                    }


                                    $project_progress = number_format($project_progress, 1);

                                    $overdue_tasks_query = "SELECT COUNT(*) FROM task_list WHERE project_id = '$id' AND overdue = 1";
                                    $overdue_tasks_result = mysqli_query($mysqli, $overdue_tasks_query);
                                    $overdue_tasks_row = mysqli_fetch_array($overdue_tasks_result);
                                    $overdue_tasks = $overdue_tasks_row[0];

                                    echo ' <td>' . $completed_tasks . '</td>';

                                    echo ' <td>' . $overdue_tasks . '</td>  
                      
                    <td><div class="container_pro">
                        <div class="project progress project_' . $id . ' "> ' . $project_progress . ' %</div>
                        </div></td>';
                                    echo '<style>
                                  .progress.project_' . $id . ' {
                                    width: ' . $project_progress . '%;
                                   }
                                  </style>';
                                    if ($row['status'] == 0) {
                                        echo '<td><span id="started"> Started</span></td>';
                                    } elseif ($row['status'] == 3) {
                                        echo '<td><span id="ongoing"> On-Progress</span></td>';
                                    } elseif ($row['status'] == 5) {
                                        echo '<td><span id="done"> Done</span></td>';
                                    }

                                }
                            } else {
                                echo mysqli_error($mysqli);
                            }
                        }
                    }else {
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
                        <button style="background-color:transparent;border:none;color:white" id="PrintButton" onclick="PrintTable1()"><i class='fa-solid fa-print'></i>&nbsp;&nbsp;Print</button>
                    </div>
                </div>

                <div class="all-tasks">

                    <table id="table1" class="task-tbl1">

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
                $dept_user = $_SESSION["dept_user"];
                $sql = "SELECT * from dept_head WHERE employeeid = '$dept_user' ";
                $result = $mysqli->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dept_name = $row ['department'];
                        $qry = "SELECT employeeid,name,username,unique_Id from employee WHERE department = '$dept_name' ";
                        $result = $mysqli->query($qry);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $employeeid = $row['employeeid'];
                                $name = $row['name'];
                                $username = $row['username'];
                                $unique_Id = $row['unique_Id'];

                                echo '
                <tr>
                    <td>' . $row['employeeid'] . '</td>
                    <td>' . $row['name'] . '</td>';

                                $assigned_tasks_query = "SELECT COUNT(*) FROM task WHERE employeeid = '$employeeid' AND MONTH(end_date) = $current_month ";
                                $assigned_tasks_result = mysqli_query($mysqli, $assigned_tasks_query);
                                $assigned_tasks_row = mysqli_fetch_array($assigned_tasks_result);
                                $assigned_tasks = $assigned_tasks_row[0];

                                $assigned_tasklist_query = "SELECT COUNT(*) FROM task_list WHERE emp_id = '$employeeid' AND MONTH(end_date) = $current_month ";
                                $assigned_tasklist_result = mysqli_query($mysqli, $assigned_tasklist_query);
                                $assigned_tasklist_row = mysqli_fetch_array($assigned_tasklist_result);
                                $assigned_tasklist = $assigned_tasklist_row[0];

                                $total_assigned_tasks = $assigned_tasks + $assigned_tasklist;

                                echo ' <td>' . $total_assigned_tasks . '</td>';

                                $completed_tasks_query = "SELECT COUNT(*) FROM task WHERE employeeid = '$employeeid' AND status = 5 AND overdue IS NULL AND MONTH(end_date) = $current_month ";
                                $completed_tasks_result = mysqli_query($mysqli, $completed_tasks_query);
                                $completed_tasks_row = mysqli_fetch_array($completed_tasks_result);
                                $completed_tasks = $completed_tasks_row[0];

                                $completed_tasklist_query = "SELECT COUNT(*) FROM task_list WHERE emp_id = '$employeeid' AND status = 5 AND overdue IS NULL AND MONTH(end_date) = $current_month ";
                                $completed_tasklist_result = mysqli_query($mysqli, $completed_tasklist_query);
                                $completed_tasklist_row = mysqli_fetch_array($completed_tasklist_result);
                                $completed_tasklist = $completed_tasklist_row[0];

                                $total_completed_tasks = $completed_tasks + $completed_tasklist;

                                if ($total_assigned_tasks == 0) {
                                    $total_task_progress = 0;
                                } else {
                                    $total_task_progress = ($total_completed_tasks / $total_assigned_tasks) * 100;;
                                }

                                $total_task_progress = number_format($total_task_progress, 1);

                                echo ' <td>' . $total_completed_tasks . '</td>';

                                $month = date('m');
                                $year = date('Y');

                                $leave_query = "SELECT SUM(DATEDIFF(last_date, start_date) + 1) as total_leave FROM e_leave WHERE name = '$employeeid' AND (start_date BETWEEN '$year-$month-01' AND LAST_DAY('$year-$month-01') OR last_date BETWEEN '$year-$month-01' AND LAST_DAY('$year-$month-01') OR (start_date < '$year-$month-01' AND last_date > LAST_DAY('$year-$month-01'))) AND status = 'Accepted'";
                                $leave_result = mysqli_query($mysqli, $leave_query);
                                $leave_row = mysqli_fetch_assoc($leave_result);
                                $total_leave = $leave_row['total_leave'];

                                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                $total_working_days = 0;

                                $leave_query = "SELECT * FROM e_leave WHERE name = '$employeeid' AND (start_date BETWEEN '$year-$month-01' AND '$year-$month-$days_in_month' OR last_date BETWEEN '$year-$month-01' AND '$year-$month-$days_in_month'AND status = 'Accepted')";
                                $leave_result = mysqli_query($mysqli, $leave_query);
                                $leave_count = mysqli_num_rows($leave_result);

                                for ($day = 1; $day <= $days_in_month; $day++) {
                                    $date = "$year-$month-$day";
                                    $day_of_week = date('N', strtotime($date));
                                    if ($day_of_week <= 5) {
                                        $is_leave_day = false;
                                        $leave_from = '';
                                        $leave_to = '';
                                        mysqli_data_seek($leave_result, 0);
                                        while ($leave_row = mysqli_fetch_assoc($leave_result)) {
                                            $leave_date_from = date_create($leave_row['start_date']);
                                            $leave_date_to = date_create($leave_row['last_date']);
                                            if ($leave_date_from->format('m') == $month && $leave_date_from->format('d') <= $day && $leave_date_to->format('m') == $month && $leave_date_to->format('d') >= $day) {
                                                $is_leave_day = true;
                                                $leave_from = $leave_date_from->format('Y-m-d');
                                                $leave_to = $leave_date_to->format('Y-m-d');
                                                break; // exit loop if leave spans only current month
                                            } else if ($leave_date_from->format('m') < $month && $leave_date_to->format('m') > $month) {
                                                $is_leave_day = true;
                                                $leave_from = date_create("$year-$month-01")->format('Y-m-d');
                                                $leave_to = date_create("$year-$month-$days_in_month")->format('Y-m-d');
                                                break; // exit loop if leave spans across two months
                                            }
                                        }
                                        if (!$is_leave_day) {
                                            $total_working_days++;
                                        }
                                    }
                                }


                                $attendance = ($total_working_days - $total_leave) / $total_working_days * 100;

                                $attendance = number_format($attendance, 1);

                                echo ' <td>' . $attendance . '%</td>';

                                $employee_performance = ($total_task_progress + $attendance) / 2;

                                echo ' <td>' . $employee_performance . '%</td>';
                                $loyalty_type = "";
                                if (70 <= $employee_performance && $employee_performance <= 80) {
                                    echo '<td><span id="user_t">Silver</span></td>';
                                } elseif (80 <= $employee_performance && $employee_performance <= 90) {
                                    echo '<td><span id="user_t1">Gold</span></td>';
                                } elseif (90 <= $employee_performance && $employee_performance <= 100) {
                                    echo '<td><span id="user_t2">Platinum</span></td>';
                                } else {
                                    echo '<td><span id="user_t3">Not Applicable</span></td>';
                                }
                            }
                        }
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
    height: 450px;
    border-collapse: separate;
    border-spacing: 0px;
    color: #51619b;
    font-weight: 520;
    margin-top: 20px;
    padding-left: 10px;
}

.task-tbl tr {
    border: 2px solid grey ;
}


.task-tbl tr th{
    border-bottom: 2px solid grey ;
    padding: 10px 40px;
    font-size: 17px;
    position: sticky;
    position: -webkit-sticky;
    top: 0;
    z-index: 2;
}

.task-tbl tr td{
    text-align: center;
    padding: 20px;
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

                function PrintTable1() {
                    var printContents = document.getElementById('table1').outerHTML;
                    var originalContents = document.body.innerHTML;

                    // Create a new style element and set its content to the CSS styles of the table
                    var style = document.createElement('style');
                    style.innerHTML = `
        .task-tbl1{
    width: 100%;
    overflow-x: auto;
    overflow-y: auto;
    table-layout: fixed;
    display: inline-block;
    height: 450px;
    border-collapse: separate;
    border-spacing: 0px;
    color: #51619b;
    font-weight: 520;
    margin-top: 20px;
    padding-left: 10px;
}

.task-tbl1 tr {
    border: 2px solid grey ;
}


.task-tbl1 tr th{
    border-bottom: 2px solid grey ;
    padding: 10px 40px;
    font-size: 17px;
    position: sticky;
    position: -webkit-sticky;
    top: 0;
    z-index: 2;
}

.task-tbl1 tr td{
    text-align: center;
    padding: 20px;
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