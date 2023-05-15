<?php
if(!isset($mysqli)){include 'functions.php';}
include 'header.php';
$mysqli = connect();
$current_date = date('Y-m-d');
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
    <link rel="stylesheet" href="progress.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
</head>

    <div class="page">

        <div class="page-content">
            <div class="group">
                <?php
                $id = $_GET['id'];
                $qry = "SELECT id,name,start_date,end_date,status from project_list WHERE id= '$id'";
                $result = $mysqli->query($qry);

                if ($result->num_rows > 0) {
                    $row = mysqli_fetch_assoc(mysqli_query($mysqli,$qry));
                    $id = $row ['id'];
                    $start_date = $row ['start_date'];
                    $end_date = $row ['end_date'];
                    echo '
                    <div class= "button_new">
                        <a href="project_view.php?id=' . $id . '"><i class="fa-sharp fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Back</a>
                    </div>';
                }
                ?>
            </div>
        <div class="containers">
            <div class="leave-container1">

                <div class="header">
                    <div class="topic"><h3>Overall Project Progress Up To <?php
                            echo $current_date;
                            ?> </h3></div>
                </div>
                 <?php
                    $id = $_GET['id'];
                    $qry = "SELECT id,name,start_date,end_date,status from project_list WHERE id= '$id' ";
                    $result = $mysqli->query($qry);

                    if ($result->num_rows > 0) {
                        $row = mysqli_fetch_assoc(mysqli_query($mysqli,$qry));
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

                            $remaining_tasks = $total_tasks - $completed_tasks;

                            echo '<div class="container_pro">
                        <div id="bar" class="project progress project_' . $id . ' "> '. $project_progress .' %</div>
                        </div>';
                            echo '<style>
                                  .progress.project_' . $id . ' {
                                    width: ' . $project_progress . '%;
                                   }
                                  </style>';
                            echo '
                                <div class="task_pro">
                                        <div class ="total"><i class="fa-solid fa-list-check"></i><br>Total Tasks:&nbsp;'.$total_tasks.'</div>
                                        <div class="vl"></div>
                                        <div class ="total1"><i class="fa-solid fa-square-check"></i><br>Completed Tasks:&nbsp;'.$completed_tasks.'</div>
                                        <div class="vl"></div>
                                        <div class ="total1"><i class="fa-solid fa-stopwatch"></i><br>Remaining Tasks:&nbsp;'.$remaining_tasks.'</div>
                                        <div class="vl"></div>
                                        <div class ="total1"><i class="fa-solid fa-circle-half-stroke"></i><br>Overall Progress:&nbsp;'.$project_progress.'%</div>
                                </div>
                                
                                ';

}?>
            </div>
            <?php
            if($start_date<=$current_date){
                echo '<div class="leave-container2">

                <div class="header1">
                    <div class="topic1"><h3>Project Launched Date </h3></div>';

                $formatted_date = date('jS \of F Y', strtotime($start_date));
                 echo '<div class ="total2">&nbsp;'.$formatted_date.'</div>
                
                </div>
                    <br>
                    <div class="topic1"><h3>Remaining Days </h3></div>';
                    $current_timestamp = time();
                    $end_timestamp = strtotime($end_date);

                    $days = ($end_timestamp > $current_timestamp) ?
                        floor(abs($end_timestamp - $current_timestamp)/ (60 * 60 * 24) ) :
                        0;

                    echo '<div class ="total2"><div class="inside">&nbsp;'.$days.'</div>&nbsp;&nbsp;Days</div>
                </div>';
            }
                    ?>

            </div>
            <div class="topics">
            <div class="topic3"><h3>Overdue Tasks</h3></div>
            <div class="topic4"><h3>Upcoming Deadlines</h3></div></div>
        <div class="tables">
            <table id="table" class="task-tbl">
                <?php
                if ($total_tasks != 0){
                echo'
            <tr  class="table-header">
                <th>Overdue</th>
                <th>Task </th>
                <th>Deadline</th>
                <th>Assigned Employee</th>
            </tr>';}

            $qry = "SELECT * from task_list WHERE project_id= '$id' AND overdue =1";
            $result = $mysqli->query($qry);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $end_date= $row ['end_date'];
                    $proof_uploaded_date= $row ['proof_uploaded_date'];

                    $current_timestamp = time();
                    $end_timestamp = strtotime($end_date);
                    $proof_uploaded_timestamp = strtotime($proof_uploaded_date);

                    $overdue_days = ($proof_uploaded_date==NULL) ?
                        floor(abs($current_timestamp - $end_timestamp)/ (60 * 60 * 24) ) :
                        floor(abs($proof_uploaded_timestamp - $end_timestamp)/ (60 * 60 * 24) )
                        ;

                        echo '
                <tr>
                    <td id="over">' . $overdue_days . ' Days</td>
                    <td>' . $row['task'] . '</td>
                    <td>' . $row['end_date'] . '</td> 
                    <td>' . $row['emp_id'] . '</td>
                    ';

                }
            }
            else{
                echo mysqli_error($mysqli);
            }
            ?>
                </tr>

            </table>
                <table id="table" class="task-tbl">
                    <?php
                    if ($total_tasks != 0){
                        echo'
            <tr  class="table-header">
                <th>Employee</th>
                <th>Task </th>
                <th>Deadline</th>
            </tr>';}

                    $qry = "SELECT id,emp_id,task,end_date from task_list WHERE project_id= '$id' AND overdue IS NULL AND end_date >= '$current_date'";
                    $result = $mysqli->query($qry);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
                    <tr>
                    <td>' . $row['emp_id'] . '</td>
                    <td>' . $row['task'] . '</td> 
                    <td>' . $row['end_date'] . '</td>';
                        }
                    }
                    else{
                        echo mysqli_error($mysqli);
                    }
                    ?>
                </tr>

                </table>
            </div>
        </div>

        </div>
<script>
function move() {
  var elem = document.getElementById("bar");
  var width = 0;
  var id = setInterval(frame, 20);
  function frame() {
    if (width >= <?php echo $project_progress; ?>) {
      clearInterval(id);
    } else {
      width++;
      elem.style.width = width + '%';
      elem.innerHTML = width * 1  + '%';
    }
  }
}

move();
</script>
