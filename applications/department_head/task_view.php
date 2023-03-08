<?php
if(!isset($mysqli)){include 'functions.php';}
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
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
    <link rel="stylesheet" href="view.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
</head>
<section>
    <div class="profile-container">

        <div class="page">

            <div class="page-content">
                <div class="leave-container1">

                    <div class="header">
                        <div class="topic"><h2>View Task</h2></div>
                    </div>


                    <?php
                    $id = $_GET['id'];
                    $qry = "SELECT employeeid,name,description,status,start_date,end_date from task WHERE id= '$id'";
                    if(mysqli_query($mysqli,$qry)){
                        $row = mysqli_fetch_assoc(mysqli_query($mysqli,$qry));
                        $employeeid= $row['employeeid'];
                        $name= $row['name'];
                        $description= $row['description'];
                        $status = $row['status'];
                        $start_date = $row['start_date'];
                        $end_date = $row['end_date'];
                        echo '
<table class="table1">
                <tr>
                <td><label>Task Name </label><br><br>'.$name.'</td>
                <td><label>Start Date </label><br><br>'.$start_date.' </td> </tr>
                <tr>
                <td><label>End Date </label><br><br>'.$end_date.'</td> 
                <td><label>Status </label><br><br>';if($row['status']==0){echo '<span id="started"> Started</span>';}
                        elseif ($row['status']==3){echo'<span id="ongoing"> On-Progress</span>';}
                        elseif ($row['status']==5){echo'<span id="done"> Done</span>';}
                        echo ' </td></tr>
                <tr>
                <td><label>Description </label><br><br> '.$description.' </td>
                <td><label>Task Assigned To</label><br><br>Employee ID: '.$employeeid.'</td> 
                </tr>
                <tr> 
                </table>'; }
                    ?>
                <div class="foot">
                <label>Proof Of Work :</label>
                <div class= "button_d">
                    <a href="#"><i class="fa-solid fa-download"></i> Download here</a>
                </div>
                <label class="container">Verified
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label>
                </div>
                </div>
            </div>
        </div>
