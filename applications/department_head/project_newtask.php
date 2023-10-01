<?php
if(!isset($mysqli)){include 'functions.php';}
// include 'header.php';
$mysqli = connect();
$id = $_GET['id'];
if(isset($_POST['submit'])) {
    $task_assigned = $_POST['task_assigned'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $qry = "INSERT INTO `task_list`(`project_id`,`task`, `description`, `status`, `emp_id`, `start_date`, `end_date`) VALUES ('$id','$name','$description','$status','$task_assigned','$start_date','$end_date')";
    if(mysqli_query($mysqli,$qry)){
        echo '<script>window.location.href = "http://localhost/blitz/applications/department_head/project_view.php?id=' . $id . '";</script>';
    }
    else{
        echo mysqli_error($mysqli);
    }

}
?>

<link rel="stylesheet" href="project_newtask.css">
<title>Blitz</title>
<h2>New Task</h2>
<form class="form-inline" action="" method="post" autocomplete="off">
    <label for="name">Name of the Task:</label>
    <input type="text" id="name" placeholder="Enter Task Name" name="name" required>
    <label for="status">Status:</label>
    <select name="status" id="status" class="custom-select custom-select-sm">
        <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Started</option>
        <option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>On-Progress</option>
        <option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Done</option>
    </select>
    <br>
    <br>
    <label for="strDate" class="control-label">Start Date:</label>
    <input required id="strDate" type="date" class="form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d",strtotime ($start_date)) : '' ?>">
    <script type="text/javascript">
        strDate = document.getElementById('strDate');
        strDate.min = new Date().toISOString().split("T")[0];
    </script>
    <label for="endDate" class="control-label">End Date:</label>
    <input required id="endDate" type="date" class="form-control-sm" autocomplete="off" name="end_date" value="<?php echo isset($end_date) ? date("Y-m-d",strtotime($end_date)) : '' ?>">
    <script type="text/javascript">
        endDate = document.getElementById('endDate');
        endDate.min = new Date().toISOString().split("T")[0];
    </script>
    <br>
    <br>
    <br>
    <label for="task_assigned">Task Assigned To:</label>
    <select required name="task_assigned" id="task_assigned" class="custom-select custom-select-sm">
        <option></option>
            <?php
            $sql = "SELECT manager_id,user_ids FROM project_list WHERE id='$id'";
            $result = mysqli_query($mysqli, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $manager_id = $row['manager_id'];
                    $user_ids = $row['user_ids'];
                    $data = explode(',', $user_ids);
                    echo "<option value='$manager_id'>$manager_id (Project Manager)</option>";
                    foreach ($data as $task_assigned) {
                        echo "<option value=\"$task_assigned\"";
                        if (isset($status) && $status == $task_assigned) {
                            echo " selected";
                        }
                        echo ">$task_assigned</option>";
                    }
                }
            }
            ?>
    </select>
    <br>
    <br>
    <label for="description">Description:</label>
    <textarea required id="description" name="description"></textarea>
    <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><b>Save</b></button>
            <button class="inner2" type="submit" name="submit1"><a href="project_list.php" > Cancel</a></b></button>
        </div>
    </div>
</form>
</body>




