<?php
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
$id=$_GET['id'];
$sql="SELECT * from task WHERE id='$id'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_assoc($result);
$employeeid = $row['employeeid'];
$name = $row['name'];
$description = $row['description'];
$status = $row['status'];
$start_date = $row['start_date'];
$end_date = $row['end_date'];
if(isset($_POST['submit'])) {
    $task_assigned = $_POST['task_assigned'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];


    $qry = "UPDATE `task` SET employeeid='$task_assigned',name='$name',description='$description', status='$status',start_date='$start_date', end_date='$end_date'WHERE id='$id'";
    if(mysqli_query($mysqli,$qry)){
        echo '<script>window.location.href = "http://localhost/blitz/applications/department_head/task_list.php";</script>';
    }
    else{
        echo mysqli_error($mysqli);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project List</title>
    <link rel="stylesheet" href="newproject.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
</head>
<title>Blitz</title>
<body>
<h2>New Task</h2>
<form class="form-inline" action="" method="post" autocomplete="off">
    <label for="name">Name:</label>
    <input type="text" id="name" placeholder="Enter Task Name" name="name" value="<?php echo $name; ?>" required>
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
    <select required name="task_assigned" id="task_assigned" class="custom-select custom-select-sm" >
        <option value="<?php echo $row['employeeid'] ?>" selected><?php echo $row['employeeid'] ?></option>
        <?php
        $sql = ("SELECT employeeid,name,jobrole FROM employee") ;
        $result = mysqli_query($mysqli, $sql);
        if($result){
            $count_rows = mysqli_num_rows($result);
            if($count_rows > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $employeeid = $row['employeeid'];
                    $name= $row['name'];
                    $jobrole = $row['jobrole'];
                    ?>
                    <option value="<?php echo $row['employeeid']."-".$row['name'] ?>" <?php echo isset($task_assigned) && $task_assigned == $row['employeeid']."-".$row['name'] ? 'selected' : '' ?> ><?php echo $employeeid ."". " - " .$name ."". " - " . $jobrole?></option>
                    <?php
                }
            }
        }
        ?>
    </select>
    <br>
    <br>
    <label for="">Description:</label>
    <textarea required id="description" name="description"><?php echo $description; ?> </textarea>
    <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><b>Update</b></button>
            <button class="inner2" type="button" name="submit1"><b><a href="task_list.php" >Cancel</a></b></button>
        </div>
    </div>
    <script>


    </script>
</form>
</body>

