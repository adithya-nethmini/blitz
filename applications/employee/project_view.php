<?php
if(!isset($mysqli)){include '../function/function.php';}
include 'sidebar.php';
include 'header.php';

$mysqli = connect();
if( isset($_POST['submit']) ) {
    // Fetch input $_POST
    $name = $mysqli->real_escape_string( $_POST['proof_of_work'] );

    // Prepared statement
    $stmt = $mysqli->prepare("UPDATE `task_list` SET `proof_of_work`=?, WHERE `id`=? AND");

    // Bind params
    $stmt->bind_param( "si", $proof_of_work, $_GET['id']);

    // Execute query
    if( $stmt->execute() ) {
        /* $alert_message = "Task has been updated."; */
        header('location: project_list.php');
    } else {
        $alert_message = "There was an error in uploading the proofs. Please try again.";
    }

    // Close prepare statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blitz</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/css/view.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
</head>
<section>
    <div class="profile-container">

        <div class="page">

            <div class="page-content">
            <div class="heading">
                    <h1>View Project</h1>
                </div>
                


     <?php
        $id = $_GET['id'];
        $qry = "SELECT name,description,start_date,end_date,status,manager_id,user_ids from project_list WHERE id=$id";
        if(mysqli_query($mysqli,$qry)):
            $row = mysqli_fetch_assoc(mysqli_query($mysqli,$qry));
            $name= $row['name'];
            $description= $row['description'];
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $status = $row['status'];
            $manager_id = $row['manager_id'];
            $user_ids = $row['user_ids'];
            ?>

                <div class="container">
                    <div class="up-outer-container">
                        <div class="up-inner-left">
                            <div>
                                <h3>Project Name</h3>
                                <?php echo $name; ?>
                            </div>
                            <div>
                                <h3>Description</h3>
                                <?php echo $description; ?>
                            </div>
                        </div>
                        <div class="up-inner-right">
                            <div>
                                <h3>Start Date</h3>
                                <?php echo $start_date ?>
                            </div>
                            <div>
                                <h3>End Date</h3>
                                <?php echo $end_date ?>
                            </div>
                            <div>
                                <h3>Status</h3>
                                <?php 
                                if($status=='0'):
                                    $status = 'started';?>
                                    <span id="started"><?php echo $status; ?></span>
                                <?php 
                                elseif ($status == 3):
                                    $status = 'On-Progress';?>
                                    <span id="ongoing"><?php echo $status; ?></span>
                                <?php
                                elseif ($status == 5):
                                    $status = 'Done';?>
                                    <span id="done"><?php echo $status; ?></span>
                                <?php
                                else:
                                    ?>
                                    <span>No data</span>
                                    <?php endif; ?>

                            </div>
                            <div>
                                <h3>Project Manager</h3>
                                <?php echo $manager_id ?>
                            </div>
                            <div>
                                <h3>Team Members</h3>
                                <?php echo $user_ids; ?>
                            </div>
                        </div>
                    </div>
                </div>
<?php endif; ?>
                <br>
                
            </div>
<div class="page">

<div class="page-content1">
     <div class="leave-container2">

        <div class="header">
            <div class="topic1"><h2>Task List</h2></div>
            


        </div>

        <div class="all-tasks">

            <table id="table" class="task-tbl">

        </div>
        <tr  class="table-header">
            <th>Task</th>
            <th>Description </th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        // $qry = "SELECT task,description,status from task_list WHERE project_id=$id";
        $user = $_SESSION['user'];
        $qry = "SELECT * FROM task_list WHERE project_id=$id AND FIND_IN_SET('$user', emp_id) > 0";
        $result = $mysqli->query($qry);

        if ($result->num_rows > 0) :
            while ($row = $result->fetch_assoc()) :
                echo '
                <tr>
                    <td>' . $row['task'] . '</td>
                    <td style="width:50%">' . $row['description'] . '</td>';
                if($row['status']==1){echo '<td><span id="started"> Started</span></td>';}
                elseif ($row['status']==3){echo'<td><span id="ongoing"> On-Progress</span></td>';}
                elseif ($row['status']==5){echo'<td><span id="done"> Done</span></td>';}?>
                 <td>
                    <div class="tiny-container">
                        <input  type="file" name="proof_of_work" value="<?php echo @$_POST['proof_of_work']?>" title="Provide your proofs of work">
                        <button class="upload" type="submit" name="submit">Upload</button>
                    </div>
                 <!-- <div class="dropdown">
                        <button class="dropbtn">Action</button>
                        <div class="dropdown-content">
                            <a style="text-align:center" href="#">View</a>
                        </div>
                        
                    </div> -->
                    </td>
                    <?php

            endwhile;
        else:
                echo mysqli_error($mysqli);
            
        endif;
//        ?>

        </tr>
         </table></div>
                </div><br>
            </div>
        </div>
    </div>