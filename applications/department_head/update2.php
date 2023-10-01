<?php
if(!isset($mysqli)){include 'functions.php';}
include 'header.php';
$mysqli = connect();
$id = $_GET['id'];
$sql="SELECT * from task_list WHERE id='$id'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_assoc($result);
$task = $row['task'];
$description = $row['description'];
$status = $row['status'];
$emp_id = $row['emp_id'];
if(isset($_POST['submit'])) {
    $task_assigned = $_POST['task_assigned'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $qry = "UPDATE `task_list` SET project_id='$id',task='$name',description='$description',status='$status',emp_id='$task_assigned' WHERE id='$id'";
    if(mysqli_query($mysqli,$qry)){
        header('location:project_view.php?id=' . $id);
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
    <input type="text" id="name" placeholder="Enter Task Name" name="name" value="<?php echo $task; ?>" required>
    <label for="status">Status:</label>
    <select name="status" id="status" class="custom-select custom-select-sm">
        <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Started</option>
        <option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>On-Progress</option>
        <option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Done</option>
    </select>
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
    <textarea required id="description" name="description"><?php echo $description; ?> </textarea>
    <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><b>Update</b></button>
            <button class="inner2" type="submit" name="submit1"><a href="project_list.php" > Cancel</a></b></button>
        </div>
    </div>
</form>
</body>
