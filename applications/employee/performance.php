<?php 
include '../function/function.php';
include 'sidebar.php';
include '../../header.php';
    
    if(!isset($_SESSION["user"])){
        header("location: login.php");

        exit();
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance</title>
    <link rel="stylesheet" href="../../views/css/performance.css">
    <link rel="stylesheet" href="../../views/css/header.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

    <section>
        <div class="profile-container">
            
            <div class="page-content">
            <div class="leave-container2">

<div class="header">
    <div class="topic"><h3>Member Performance Evaluation</h3></div>
    <div class= "button_p">
        <i class="fa-solid fa-print"></i> Print
    </div>
</div>

<div class="all-tasks">

    <table id="table" class="task-tbl">

</div>
<tr  class="table-header">
    <th>Employee ID</th>
    <th>Employee Name </th>
    <th>No.of Tasks Assigned</th>
    <th>Completed Tasks</th>
    <th>Attendance</th>
    <th>Performance</th>
    <th>User Type</th>
</tr>
<?php
$mysqli = connect();
$user = $_SESSION['user'];
$qry = "SELECT employeeid,name from employee WHERE username = '$user'";
$result = $mysqli->query($qry);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
<tr>
    <td>' . $row['employeeid'] . '</td>
    <td>' . $row['name'] . '</td>
    <td>10</td>
    <td>7</td>
    <td>70%</td>
    <td>70%</td>
    <td><span id="user_t">Silver</span></td>';

    }
}
else{
    echo mysqli_error($mysqli);
}
?>

</tr>
</table>
</div>
            </div>

            </div>
        </div>

    </section>
    
</body>
<script src="../../views/js/main.js"></script>

</html>