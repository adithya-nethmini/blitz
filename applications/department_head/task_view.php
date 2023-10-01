<?php
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
?>
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
                    $current_date = date('Y-m-d');
                    $qry = "SELECT employeeid,name,description,status,start_date,end_date,proof_uploaded_date,proofs from task WHERE id= '$id'";
                    if(mysqli_query($mysqli,$qry)){
                        $row = mysqli_fetch_assoc(mysqli_query($mysqli,$qry));
                        $employeeid= $row['employeeid'];
                        $name= $row['name'];
                        $description= $row['description'];
                        $status = $row['status'];
                        $start_date = $row['start_date'];
                        $end_date = $row['end_date'];
                        $proofs = $row['proofs'];
                        $proof_uploaded_date = $row['proof_uploaded_date'];
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
                        echo ' 
                <br><br>';if ($end_date < $current_date && $proof_uploaded_date==NULL) {
                            echo '<span id="overdue"> Behind The Schedule</span>';
                        }
                           elseif ($end_date < $proof_uploaded_date) {
                               echo '<span id="overdue"> Behind The Schedule</span>';

                }  echo'
                </td></tr>
                <tr>
                <td><label>Description </label><br><br> '.$description.' </td>
                <td><label>Task Assigned To</label><br><br> '.$employeeid.'</td> 
                </tr>
                <tr> 
                </table>'; }
                    ?>
                <div class="foot">
                <?php
                if (!is_null($proofs)) {
                echo ' 
                    <label>Proof Of Work :</label>
                    <div class= "button_d">
                    <a href="download.php?id='.$id.'"><i class="fa-solid fa-download"></i> Download here</a>
                </div>
                <form id="myForm" method="post" action="update_status.php">
                <label class="container" >Verified ';
                    $qry = "SELECT employeeid,name,description,status,start_date,end_date,proof_uploaded_date from task WHERE id= '$id'";
                    if(mysqli_query($mysqli,$qry)) {
                        $row = mysqli_fetch_assoc(mysqli_query($mysqli, $qry));
                        $checked = isset($_GET['checked']) ? $_GET['checked'] : '';
                        if ($row['status'] == 5) {
                            $checked = 'checked';
                        }
                    }

                    echo '<input type="checkbox" id="myCheckbox" name="id" value="' . $id . '" ' . $checked . '>
                    <span class="checkmark"></span>
                </label>' ;} ?>
                </div>
                </div>
            </div>
        </div>
<script>
    var form = document.getElementById("myForm");
    var checkbox = document.getElementById("myCheckbox");

    checkbox.addEventListener("click", function() {
        if (checkbox.checked) {
            form.submit();
        }
    });

    checkbox.addEventListener("click", function(event) {
        event.preventDefault();
        if (confirm("Are you sure you want to verify this task?")) {
            checkbox.checked = true;
            form.submit();
        } else {
            checkbox.checked = false;
        }
    });
</script>