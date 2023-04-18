<?php 
    include '../function/function.php';
    include 'sidebar.php';
    include '../../header.php';

    if(isset($_GET['logout'])){
        logoutUser();
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../views/css/leave-status.css">
    <link rel="stylesheet" href="../../views/css/header.css">
</head>
<body>
    <section>
        <div class="profile-container">
            
            <div class="page">
                <div class="page-content">

                    <div class="leave-container">

                        <div class="header">
                            
                            <div>
                                <h1>Leave Status - Month <?php echo date('F') ?></h1>
                            </div>
    
                            <div class="div-search">
                                <img src="../../views/images/search.png" alt="search" title="Search">
                                <input type="text" id="search" onkeyup="searchFunction()" placeholder="Search" title="Search">
                                <img src="../../views/images/filter.png" alt="filter" title="Filter">
                            </div>

                        </div>
    
                        <div class="all-tasks">
    
                            <table id="table" class="task-tbl">
    
                                <thead>
    
                                    <tr>
                                        <th class="number-h">#</th>
                                        <th>Leave Type</th>
                                        <th>Reason</th>
                                        <th>Start&nbsp;Date</th>
                                        <th>End&nbsp;Date</th>
                                        <th>Assigned&nbsp;To</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
    
                                    <?php
                                        $mysqli = connect();
                                        $user = @$_SESSION['user'];

                                        $query = ("SELECT * FROM employee WHERE username = '$user'");
                                        $result = mysqli_query($mysqli, $query);
    
                                        if($result==TRUE):
    
                                            $count_rows = mysqli_num_rows($result);
    
                                            if($count_rows > 0):
                                                while($row = mysqli_fetch_assoc($result)):
                                                    $fname = $row['name'];

                                        $sql = ("SELECT * FROM e_leave WHERE name = '$fname' AND MONTH(applied_date)=MONTH(CURRENT_TIMESTAMP) ");
                                               
                                        $result = mysqli_query($con, $sql);
    
                                        if($result==TRUE):
    
                                            $count_rows = mysqli_num_rows($result);
    
                                            if($count_rows > 0):
                                                $i = 1;
                                                while($row = mysqli_fetch_assoc($result)):
                                                   
                                                    $id = $row['id'];
                                                    $leave_type = $row['leave_type'];
                                                    $reason = $row['reason'];
                                                    $start_date = $row['start_date'];
                                                    $last_date = $row['last_date'];
                                                    $status = $row['status'];
                                                    $name = $row['name'];
                                                    $assigned_person = $row['assigned_person'];
                                                    $applied_date = $row['applied_date'];
                                                 
                                    ?>
                                    
                                </thead>
         
                                <tbody>        
                                    <tr>
                                        <td class="number-d"><?php echo $i; $i++; ?></td>
                                        <td><?php echo @$leave_type ?></td>
                                        <td><?php echo $reason ?></td>
                                        <td><?php echo $start_date ?></td>
                                        <td><?php echo $last_date ?></td>
                                        <td><?php echo $assigned_person ?></td>
                                        <td><?php if($status == 'Pending'): ?>
                                            <b class="status-pending" title="<?php echo $applied_date; ?>"><?php echo $status ?></b>
                                            <?php elseif($status == 'Accepted'): ?>
                                            <b class="status-accepted"><?php echo $status ?></b>
                                            <?php else: ?>
                                            <b class="status-cancel"><?php echo $status ?></b>
                                            <?php endif ?>
                                        </td>
                                        <td class="action-col">
                                            <a href="delete-leave?id=<?=$id?>"  onclick="return confirm('Are you sure you want to delete?')"><button class="btn-task-delete">Delete</button></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php endwhile;
                                            endif;
                                        endif;
                                               endwhile ?>
    
                                            <?php else: ?>
    
                                                <tr>
                                                    <td colspan="8">No leaves applied yet</td>
                                                </tr>
    
                                            <?php endif ?>
    
                                        <?php endif ?>  
    
                            </table>

                            <script>
                                function searchFunction() {
                                    var input, filter, table, tr, td, i;
                                    input = document.getElementById("search");
                                    filter = input.value.toUpperCase();
                                    table = document.getElementById("table");
                                    tr = table.getElementsByTagName("tr");
                                    for (var i = 0; i < tr.length; i++) {
                                        var tds = tr[i].getElementsByTagName("td");
                                        var flag = false;
                                        for(var j = 0; j < tds.length; j++){
                                        var td = tds[j];
                                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                            flag = true;
                                        } 
                                        }
                                        if(flag){
                                            tr[i].style.display = "";
                                        }
                                        else {
                                            tr[i].style.display = "none";
                                        }
                                    }
                                }
                            </script>

                        </div>        
                </div>

                <br><br>

                <div class="leave-container">

                        <div class="header">
                            
                            <div>
                                <h1>Leave Status - Older</h1>
                            </div>
    
                            <div class="div-search">
                                <img src="../../views/images/search.png" alt="search" title="Search">
                                <input type="text" id="search" onkeyup="searchFunction()" placeholder="Search" title="Search">
                                <img src="../../views/images/filter.png" alt="filter" title="Filter">
                            </div>

                        </div>
    
                        <div class="all-tasks">
    
                            <table id="table" class="task-tbl">
    
                                <thead>
    
                                    <tr>
                                        <th class="number-h">#</th>
                                        <th>Leave Type</th>
                                        <th>Reason</th>
                                        <th>Start&nbsp;Date</th>
                                        <th>End&nbsp;Date</th>
                                        <th>Assigned&nbsp;To</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
    
                                    <?php
                                        $mysqli = connect();
                                        $user = @$_SESSION['user'];

                                        $query = ("SELECT * FROM employee WHERE username = '$user'");
                                        $result = mysqli_query($mysqli, $query);
    
                                        if($result==TRUE):
    
                                            $count_rows = mysqli_num_rows($result);
    
                                            if($count_rows > 0):
                                                while($row = mysqli_fetch_assoc($result)):
                                                    $fname = $row['name'];

                                        $sql = ("SELECT * FROM e_leave WHERE name = '$fname' AND MONTH(applied_date)!=MONTH(CURRENT_TIMESTAMP) ");
                                               
                                        $result = mysqli_query($con, $sql);
    
                                        if($result==TRUE):
    
                                            $count_rows = mysqli_num_rows($result);
    
                                            if($count_rows > 0):
                                                $i = 1;
                                                while($row = mysqli_fetch_assoc($result)):
                                                   
                                                    $id = $row['id'];
                                                    $leave_type = $row['leave_type'];
                                                    $reason = $row['reason'];
                                                    $start_date = $row['start_date'];
                                                    $last_date = $row['last_date'];
                                                    $status = $row['status'];
                                                    $name = $row['name'];
                                                    $assigned_person = $row['assigned_person'];
                                                    $applied_date = $row['applied_date'];
                                                 
                                    ?>
                                    
                                </thead>
         
                                <tbody>        
                                    <tr>
                                        <td class="number-d"><?php echo $i; $i++; ?></td>
                                        <td><?php echo @$leave_type ?></td>
                                        <td><?php echo $reason ?></td>
                                        <td><?php echo $start_date ?></td>
                                        <td><?php echo $last_date ?></td>
                                        <td><?php echo $assigned_person ?></td>
                                        <td><?php if($status == 'Pending'): ?>
                                            <b class="status-pending" title="<?php echo $applied_date; ?>"><?php echo $status ?></b>
                                            <?php elseif($status == 'Accepted'): ?>
                                            <b class="status-accepted"><?php echo $status ?></b>
                                            <?php else: ?>
                                            <b class="status-cancel"><?php echo $status ?></b>
                                            <?php endif ?>
                                        </td>
                                        <td class="action-col">
                                            <a href="delete-leave?id=<?=$id?>"  onclick="return confirm('Are you sure you want to delete?')"><button class="btn-task-delete">Delete</button></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php endwhile;
                                            endif;
                                        endif;
                                               endwhile ?>
    
                                            <?php else: ?>
    
                                                <tr>
                                                    <td colspan="8">No leaves applied yet</td>
                                                </tr>
    
                                            <?php endif ?>
    
                                        <?php endif ?>  
    
                            </table>

                            <script>
                                function searchFunction() {
                                    var input, filter, table, tr, td, i;
                                    input = document.getElementById("search");
                                    filter = input.value.toUpperCase();
                                    table = document.getElementById("table");
                                    tr = table.getElementsByTagName("tr");
                                    for (var i = 0; i < tr.length; i++) {
                                        var tds = tr[i].getElementsByTagName("td");
                                        var flag = false;
                                        for(var j = 0; j < tds.length; j++){
                                        var td = tds[j];
                                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                            flag = true;
                                        } 
                                        }
                                        if(flag){
                                            tr[i].style.display = "";
                                        }
                                        else {
                                            tr[i].style.display = "none";
                                        }
                                    }
                                }
                            </script>

                        </div>        
                </div>

            </div>

            </div>
            

        </div>
    

    </section>
    
</body>
<script src="../../views/js/main.js"></script>
</html>