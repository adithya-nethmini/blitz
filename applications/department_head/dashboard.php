<?php
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
$current_month = date('m');
$dept_user = $_SESSION["dept_user"];
$sql = "SELECT * from dept_head WHERE employeeid = '$dept_user' ";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while ($row2 = $result->fetch_assoc()) {
        $dept_name = $row2 ['department'];
        $sql = "SELECT count(*) as total FROM project_list WHERE dept_name = '$dept_name'AND MONTH(end_date) = $current_month";
        $result = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($result);
        $qry = "SELECT count(*) as sum FROM task WHERE dept_name = '$dept_name'AND MONTH(end_date) = $current_month";
        $result = mysqli_query($mysqli, $qry);
        $row1 = mysqli_fetch_assoc($result);
    }
}
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
    <link rel="stylesheet" href="dashboard.css">
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
                    <a href="project_list.php"><i class="fa-solid fa-sheet-plastic"></i> &nbsp;&nbsp;<?= $row['total'] ?> Projects</a>
                    </div>
                    <div class= "button">
                        <a href="task_list.php"><i class="fa-solid fa-list-check"></i> &nbsp;&nbsp;<?= $row1['sum'] ?> Tasks</a>
                    </div>
                    <div class= "button1">
                    <a href="emp_details.php"><i class="fa-solid fa-users"></i> &nbsp;&nbsp;Employee details</a>
                    </div>
                </div>
                <div class="leave-container1">

                    <div class="header">
                        <div class="topic"><h3>Project Progress</h3></div>
                    </div>

                    <div class="all-tasks">

                        <table id="table" class="task-tbl">

                    </div>
                    <tr  class="table-header">
                        <th>Project</th>
                        <th>Progress </th>
                        <th>Status</th>
                        <th>View Project</th>
                    </tr>
                    <?php
                    $sql = "SELECT * from dept_head WHERE employeeid = '$dept_user' ";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $dept_name = $row ['department'];
                            $qry = "SELECT id,name,start_date,end_date,status from project_list WHERE dept_name = '$dept_name'AND MONTH(end_date) = $current_month ";
                            $result = $mysqli->query($qry);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row ['id'];
                                    echo '
                <tr>
                    <td>' . $row['name'] . '<br>Due date : ' . $row['end_date'] . '</td>';
                                    $completed_tasks_query = "SELECT COUNT(*) FROM task_list WHERE project_id = '$id' AND status = 5";
                                    $completed_tasks_result = mysqli_query($mysqli, $completed_tasks_query);
                                    $completed_tasks_row = mysqli_fetch_array($completed_tasks_result);
                                    $completed_tasks = $completed_tasks_row[0];

                                    $total_tasks_query = "SELECT COUNT(*) FROM task_list WHERE project_id = '$id'";
                                    $total_tasks_result = mysqli_query($mysqli, $total_tasks_query);
                                    $total_tasks_row = mysqli_fetch_array($total_tasks_result);
                                    $total_tasks = $total_tasks_row[0];

                                    if ($total_tasks == 0) {
                                        $project_progress = 0;
                                    } else {
                                        $project_progress = ($completed_tasks / $total_tasks) * 100;
                                    }


                                    $project_progress = number_format($project_progress, 1);

                                    echo '<td><div class="container_pro">
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
                                    echo ' <td><div class="dropdown">
                        <div class="dropbtn"><a href="project_view.php?id=' . $id . '">View</a></div>
                    </div>
                    </td>';

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
                        <div class="topic"><h3>Task Progress</h3></div>
                    </div>

                    <div class="all-tasks">

                        <table id="table" class="task-tbl">

                    </div>
                    <tr  class="table-header">
                        <th>Task</th>
                        <th>Proof Of Work </th>
                        <th>Status</th>
                        <th>View Task</th>
                    </tr>
                    <?php
                    $sql = "SELECT * from dept_head WHERE employeeid = '$dept_user' ";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $dept_name = $row ['department'];
                            $qry = "SELECT id,name,start_date,end_date,status,proofs from task WHERE dept_name = '$dept_name'";
                            $result = $mysqli->query($qry);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row ['id'];
                                    $proofs = $row['proofs'];
                                    echo '
                <tr>
                    <td>' . $row['name'] . '<br>Due date : ' . $row['end_date'] . '</td>
                    <td>
                        ';
                                    if (!is_null($proofs)) {
                                        echo '<span id="upload"> Uploaded</span>';
                                    } else {
                                        echo '<span id="upload1"> Not Uploaded</span>';
                                    }
                                    echo '
                    </td>';
                                    if ($row['status'] == 0) {
                                        echo '<td><span id="started"> Started</span></td>';
                                    } elseif ($row['status'] == 3) {
                                        echo '<td><span id="ongoing"> On-Progress</span></td>';
                                    } elseif ($row['status'] == 5) {
                                        echo '<td><span id="done"> Done</span></td>';
                                    }
                                    echo ' <td><div class="dropdown">
                        <div class="dropbtn"><a href="task_view.php?id=' . $id . '">View</a></div>
                    </div>
                    </td>';

                                }
                            } else {
                                echo mysqli_error($mysqli);
                            }
                        }
                    } else {
                        echo mysqli_error($mysqli);
                    }
                    ?>

                    </tr>
                    </table>
                </div>