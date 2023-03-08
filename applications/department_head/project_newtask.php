<?php
if(!isset($mysqli)){include 'functions.php';}
include 'header.php';
$mysqli = connect();
$id = $_GET['id'];
if(isset($_POST['submit'])) {
//    $task_assigned = $_POST['task_assigned'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $qry = "INSERT INTO `task_list`(`project_id`,`task`, `description`, `status`) VALUES ('$id','$name','$description','$status')";
    if(mysqli_query($mysqli,$qry)){
        header('location:project_view.php?id=' . $id);
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
<!                          </select>-->
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
<!--                                        <option value="--><?php //echo $row['id'] ?><!--" --><?php //echo isset($manager_id) && $manager_id == $row['id'] ? "selected" : '' ?><!----><?php //echo ucwords($row['name']) ?><!--</option>-->
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
<link rel="stylesheet" href="project_newtask.css">
<title>Blitz</title>
<h2>New Task</h2>
<form class="form-inline" action="" method="post" autocomplete="off">
    <label for="name">Name of the Task:</label>
    <input type="text" id="name" placeholder="Enter Task Name" name="name" required>
    <label for="status">Status:</label>
    <select name="status" id="status" class="custom-select custom-select-sm">
        <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
        <option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>On-Hold</option>
        <option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Done</option>
    </select>
    <br>
    <br>
<!--    <label for="task_assigned">Task Assigned To:</label>-->
<!--    <select required name="task_assigned" id="task_assigned" class="custom-select custom-select-sm">-->
<!--        <option></option>-->
<!--        --><?php
//        $sql = ("SELECT employeeid,name,jobrole FROM employee") ;
//        $result = mysqli_query($mysqli, $sql);
//        if($result){
//            $count_rows = mysqli_num_rows($result);
//            if($count_rows > 0){
//                while($row = mysqli_fetch_assoc($result)){
//                    $employeeid = $row['employeeid'];
//                    $name= $row['name'];
//                    $jobrole = $row['jobrole'];
//                    ?>
<!--                    <option value="--><?php //echo $row['employeeid'] ?><!--" --><?php //echo isset($status) && $status == 0 ? 'selected' : '' ?><!-->--><?php //echo $name . " - " . $jobrole?><!--</option>-->
<!--                    --><?php
//                }
//            }
//        }
//        ?>
<!--    </select>-->
<!--    <br>-->
<!--    <br>-->
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



