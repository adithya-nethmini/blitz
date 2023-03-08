<?php
if(!isset($mysqli)){include 'connection.php';}
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="manage-leave.css">
</head>
<body>
    
    <section>
        
        <div class="page-content">
    <br><br><br><br><br><br>
            <div class="heading">
                <h1>Manage Employee Leaves</h1>
            </div>
                <div class="container">

                <div class="header">
                    <div>
                        <h2>Pending&nbsp;Leaves</h2>
                    </div>
        
                    <div class="div-search">
                        <i class="fa fa-search" aria-hidden="true" title="Search"></i>
                        <input type="text" id="search" onkeyup="searchPendingFunction()" placeholder="Search by Employee Name" title="Search by Employee Name">

                    </div>
                </div>
                    
                    <div class="all-tasks">

                    <table id="table" class="task-tbl">
        
                        <thead>
        
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Reason</th>
                                <th>From</th>
                                <th>To </th>
                                <th>Assigned&nbsp;To</th>
                                <th>Applied&nbsp;Date</th>
                                <th>Action</th>
                            </tr>
        
                            <?php
        
                                $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                                /* $user = $_SESSION['user']; */
                                $sql = "SELECT * FROM e_leave WHERE status = 'Pending'";
                                
                                $result = mysqli_query($con, $sql);
        
                                if($result==TRUE):
        
                                    $count_rows = mysqli_num_rows($result);
        
                                    if($count_rows > 0):
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($result)):
                                            
                                            $id = $row['id'];
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
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo $name ?></td>
                                <td><?php echo $reason ?></td>
                                <td><?php echo $start_date ?></td>
                                <td><?php echo $last_date ?></td>
                                <td><?php echo $assigned_person ?></td>
                                <td><?php echo $applied_date ?></td>
                                <td class="action-col">
                                    <a class="accept" href="accept-leave?id=<?=$id?>"  onclick="return confirm('Are you sure you want to accept the leave?')"><i class='fas fa-check-double'></i></a>
                                    <a class="cancel" href="cancel-leave?id=<?=$id?>"  onclick="return confirm('Are you sure you want to cancel the leave?')"><i class='fa fa-remove'></i></a>
                                </td>
                            </tr>
                        </tbody>
                                        
                                        <?php endwhile ?>
        
                                    <?php else: ?>
        
                                        <tr>
                                            <td colspan="6">No leaves applied yet</td>
                                        </tr>
        
                                    <?php endif ?>
        
                                <?php endif ?>            
        
                    </table>

                    <script>
                        function searchPendingFunction() {
                            var input, filter, table, tr, td, i, txtValue;
                            input = document.getElementById("search");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("table");
                            tr = table.getElementsByTagName("tr");
                            for (i = 0; i < tr.length; i++) {
                                td = tr[i].getElementsByTagName("td")[1];
                                if (td) {
                                txtValue = td.textContent || td.innerText;
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                                }       
                            }
                        }
                    /* function searchFunction() {
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
                        } */

                    </script>
    
                </div>
                
            </div><br><br>
            <div class="container">
                <div class="header">
                        <div>
                            <h2>Accepted&nbsp;Leaves</h2>
                        </div>
            
                        <div class="div-search">
                            <i class="fa fa-search" aria-hidden="true" title="Search"></i>
                            <input type="text" id="search" onkeyup="searchFunction()" placeholder="Search by Employee Name" title="Search by Employee Name">

                        </div>
                    </div>
                    <div class="all-tasks">

                    <table id="table" class="task-tbl">
        
                        <thead>
        
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Reason</th>
                                <th>From</th>
                                <th>To </th>
                                <th>Assigned&nbsp;To</th>
                                <th>Applied&nbsp;Date</th>
                            </tr>
        
                            <?php
        
                                $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                                /* $user = $_SESSION['user']; */
                                $sql = "SELECT * FROM e_leave WHERE status = 'Accepted'";
                                
                                $result = mysqli_query($con, $sql);
        
                                if($result==TRUE):
        
                                    $count_rows = mysqli_num_rows($result);
        
                                    if($count_rows > 0):
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($result)):
                                            
                                            $id = $row['id'];
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
                                <td><?php echo $i; $i++; ?></td>
                                <td><?php echo $name ?></td>
                                <td><?php echo $reason ?></td>
                                <td><?php echo $start_date ?></td>
                                <td><?php echo $last_date ?></td>
                                <td><?php echo $assigned_person ?></td>
                                <td><?php echo $applied_date ?></td>
                            </tr>
                        </tbody>
                                        
                                        <?php endwhile ?>
        
                                    <?php else: ?>
        
                                        <tr>
                                            <td colspan="5">No leaves applied yet</td>
                                        </tr>
        
                                    <?php endif ?>
        
                                <?php endif ?>            
        
                    </table>

                    <script>
                        function searchPendingFunction() {
                            var input, filter, table, tr, td, i, txtValue;
                            input = document.getElementById("search");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("table");
                            tr = table.getElementsByTagName("tr");
                            for (i = 0; i < tr.length; i++) {
                                td = tr[i].getElementsByTagName("td")[1];
                                if (td) {
                                txtValue = td.textContent || td.innerText;
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                    tr[i].style.display = "";
                                } else {
                                    tr[i].style.display = "none";
                                }
                                }       
                            }
                        }

                    </script>
    
                </div>
            </div>
            <br><br>

    </section>

</body>
</html>