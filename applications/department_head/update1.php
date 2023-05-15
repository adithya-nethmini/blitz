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
        header('location:task_list.php');
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
<!--
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
<!--                                    <option value="--><?php //echo $row['id'] ?><!--" --><?php //echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?><!-<?php //echo ucwords($row['name']) ?><!--</option>-->
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
        <option></option>
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
            <button class="inner2" type="submit" name="submit1"><b><a href="project_list.php" >Cancel</a></b></button>
        </div>
    </div>
    <script>


    </script>
</form>
</body>

