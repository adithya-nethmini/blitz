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
        echo '<script>window.location.href = "http://localhost/blitz_new/applications/department_head/project_list.php";</script>';
//        header('location:project_list.php');
    }
    else{
        echo mysqli_error($mysqli);
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
<!--                            <select name="status" id="status" class="custom-select custom-select-sm">-->
<!--
<!--                            </select>-->
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
<!--                                --><?php
//                                $employees = $mysqli->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
//                                while($row= $employees->fetch_assoc()):
//                                    ?>
<!--                                    <option value="--><?php //echo $row['id'] ?><!--" --><?php //echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?><!-->--><?php //echo ucwords($row['name']) ?><!--</option>-->
<!--                                --><?php //endwhile; ?>
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col-md-10">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Description</label>-->
<!--                            <textarea name="description" id="" cols="30" rows="10" class="summernote form-control">-->
<!--						--><?php //echo isset($description) ? $description : '' ?>
<!--					</textarea>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--        <div class="card-footer border-top border-info">-->
<!--            <div class="d-flex w-100 justify-content-center align-items-center">-->
<!--                <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-project">Save</button>-->
<!--                <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<script>-->
<!--    $('#manage-project').submit(function(e){-->
<!--        e.preventDefault()-->
<!--        start_load()-->
<!--        $.ajax({-->
<!--            url:'ajax.php?action=save_project',-->
<!--            data: new FormData($(this)[0]),-->
<!--            cache: false,-->
<!--            contentType: false,-->
<!--            processData: false,-->
<!--            method: 'POST',-->
<!--            type: 'POST',-->
<!--            success:function(resp){-->
<!--                if(resp == 1){-->
<!--                    alert_toast('Data successfully saved',"success");-->
<!--                    setTimeout(function(){-->
<!--                        location.href = 'index.php?page=project_list'-->
<!--                    },2000)-->
<!--                }-->
<!--            }-->
<!--        })-->
<!--    })-->
<!--</script>-->
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