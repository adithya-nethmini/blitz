<?php 
include '../function/function.php';
include 'sidebar.php';
include 'header.php';

    if(isset($_GET['logout'])){
		unset($_SESSION['login']);
        session_destroy();
        header("location: ../../index.php");
        exit();
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="../../views/css/projects.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

    <section>
        <div class="profile-container">
                        
        <div class="page-content">
            
            <div class="outer-container">
                <div class="project-container">
    
                    <div class="header">
                        <div>
                            <h2>Project&nbsp;Progress</h2>
                        </div>
            
                        <div class="div-search">
                            <img src="../../views/images/search.png" alt="search" title="Search">
                            <input type="text" id="search" onkeyup="searchFunction()" placeholder="Search by Employee Name" title="Search by Employee Name">
                            <img src="../../views/images/filter.png" alt="filter" title="Filter">
                        </div>
                    </div>
    
                    <div class="all-task">
                        <table id="table" class="task-tbl">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <hr>
                            </thead>
                            <tbody>
                                <?php 
                                    $mysqli = connect();
                                    $sql = "SELECT * FROM project_list Where status = '0'";
                                    $i = 1; 
                                    $result = mysqli_query($mysqli, $sql);
        
                                            if($result==TRUE):
        
                                                $count_rows = mysqli_num_rows($result);
        
                                                if($count_rows > 0):
                                                    while($row = mysqli_fetch_assoc($result)):
                                                        $name = $row['name'];
                                                        $description = $row['description'];
                                                        $status = $row['status'];
                                                        $start_date = $row['start_date'];
                                                        $end_date = $row['end_date'];
                                                        $date_created = $row['date_created'];
                                ?>
                                <tr>
                                    <td><?php echo $i; $i++;?></td>
                                    <td style="text-align: left;">
                                        <a>
                                            <?php echo $name; ?>
                                        </a>
                                        <br>
                                        <small>
                                            Due: <?php echo date("Y-m-d",strtotime($row['end_date'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="progress-container">
                                            <div class="progress value"></div>
                                        </div>80% <!-- $prog -->
                                    </td>
                                    <td>
                                       <?php
                                            if($status == '0'){
                                                echo '<b class="status-pending">Started</b>';
                                            }elseif($status == '1'){
                                                echo '<b class="status-on-hold">Ongoing</b>';
                                            }else{
                                                echo '<b class="status-done">Done</b>';
                                            }
                                       ?>
                                    </td>
                                    <td>
                                    <a class="view-project" href="view-project?id=<?php /* $id */ ?>">View</a>                                  
                                    </td>
                                </tr>
                                
                                <?php 
                                    endwhile;
                                endif;
                            endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
    
                </div>
                <br>
                <div class="dashboard">
                    <div class="all-project-container">
                        <h1>Total&nbsp;Projects</h1>
                        <?php  $where = " where manager_id = '{$_SESSION['login_id']}' "; ?>
                        <h3><?php echo $mysqli->query("SELECT * FROM project_list $where")->num_rows; ?></h3>
                    </div>
                    <br>
                    <div class="all-task-container">
                        <h1>Total&nbsp;Tasks</h1>
    
                    </div>
                </div>

            </div>

            </div>
        </div>
            <div class="div-profile-space">
            </div>

        </div>
    

    </section>
    
</body>
<script src="../../views/js/main.js"></script>
</html>