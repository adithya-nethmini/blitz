<?php
include '../function/function.php';
//include 'sidebar.php';
include 'header.php';
$mysqli = connect();
$current_date = date('Y-m-d');
?>

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

                            $project_progress = ($completed_tasks / $total_tasks) * 100;

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
            <div class="leave-container2">

                <div class="header">
                    <div class="topic1"><h3>Project Launched Date </h3></div>
                <?php
                $formatted_date = date('jS \of F Y', strtotime($start_date));
                 echo '<div class ="total2">&nbsp;'.$formatted_date.'</div>';
                ?>
                </div>
                    <br>
                    <div class="topic1"><h3>Remaining Days </h3></div>
                    <?php
                    $current_timestamp = time();
                    $end_timestamp = strtotime($end_date);

                    $days = ($end_timestamp > $current_timestamp) ?
                        floor(abs($end_timestamp - $current_timestamp) / (60 * 60 * 24)) :
                        0;

                    echo '<div class ="total2"><div class="inside1">&nbsp;'.$days.'</div>Days</div>';
                    ?>
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