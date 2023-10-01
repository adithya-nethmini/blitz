<?php
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
$dept_user = $_SESSION["dept_user"];
$sql = "SELECT * from dept_head WHERE employeeid = '$dept_user' ";
$result = $mysqli->query($sql); 
$row = $result->fetch_assoc();
$dept_name = $row ['department'];
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $manager_id = $_POST['manager_id'];
    $user_ids = $_POST['user_ids'];
    $data = '';
    if(isset($user_ids)) {
        $data = implode(',', $user_ids);
    }

    $qry = "INSERT INTO `project_list`(`name`,`dept_name`, `description`, `status`, `start_date`, `end_date`, `manager_id`, `user_ids`) VALUES ('$name','$dept_name','$description','$status','$start_date','$end_date','$manager_id','$data')";
    if(mysqli_query($mysqli,$qry)){
        echo '<script>window.location.href = "http://localhost/blitz/applications/department_head/project_list.php";</script>';
//        header('location:project_list.php');
    }
    else{
        echo mysqli_error($mysqli);
    }
}
?>

<link rel="stylesheet" href="newproject.css">
<title>Blitz</title>
<h2>New Project</h2>
<form class="form-inline" action="" method="post" autocomplete="off">
    <label for="name">Name:</label>
    <input type="text" id="name" placeholder="Enter Project Name" name="name" required>
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
        var minDate = strDate.toISOString().slice(0, 10);
        endDate.setAttribute("min", minDate);
    </script>
    <br>
    <br>
    <br>
    <label for="manager_id">Project Manager:</label>
    <select required name="manager_id" id="manager_id" class="custom-select custom-select-sm">
        <option></option>
        <?php
        $dept_user = $_SESSION["dept_user"];
        $sql = "SELECT * from dept_head WHERE employeeid = '$dept_user' ";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        $dept_name = $row ['department'];
        $sql = ("SELECT employeeid,username,name,jobrole FROM employee WHERE department = '$dept_name' AND jobrole='Manager'") ;
        $result = mysqli_query($mysqli, $sql);
        if ($result->num_rows > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    $username = $row['username'];
                    $name= $row['name'];
                    $jobrole = $row['jobrole'];
                    $employeeid = $row['employeeid'];
                    ?>
                    <option value="<?php echo $row['employeeid'] ?>" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>><?php echo $employeeid ."". " - " .$name ?></option>
                <?php
                }
            }
        }
        }
        ?>
    </select>
    <br>
    <br>
    <label for="user_ids[]">Project Members:</label>
    <select required multiple="multiple" name="user_ids[]" id="user_ids[]">
        <option></option>
        <?php
        $employees = $mysqli->query("SELECT *,concat(employeeid,'',' - ',name,'',' - ',jobrole) as name FROM employee  WHERE department = '$dept_name'AND jobrole='Employee' ");
        while($row= $employees->fetch_assoc()){
            $employeeid= $row['employeeid'];
            $username = $row['username'];
            $name = $row['name'];
            $jobrole = $row['jobrole'];
            ?>
            <option value="<?php echo $row['employeeid'] ?>"><?php echo ucwords($row['name']) ?></option>
        <?php
        }


        ?>
    </select>
    <script>
        new MultiSelectTag('user_ids[]', {
            rounded: true
        })
    </script>
    <br>
    <label for="description">Description:</label>
    <textarea required id="description" name="description"></textarea>
    <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><b>Save</b></button>
            <button class="inner2" type="submit" name="submit1"><b>Cancel</b></button>
        </div>
    </div>
</form>
</body>