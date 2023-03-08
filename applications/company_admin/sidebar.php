<?php include "function.php";

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
    <title>sidebar</title>
    <link rel="stylesheet" href="sidebar.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="sidebar">

        <img src="logowhite.png" alt="logo">
        <div class="sidebar-menu">
            <ul>
            <div class="box">
<!-- <a href="add.php">Home</a> -->
                <li><a href="Dash.php"><i class="fa fa-tachometer" aria-hidden="true"></i><b>&nbsp;Dashboard</b></a></li>
                <li><a href="listadmin.php"><i class="fa fa-user-plus" aria-hidden="true"></i><b>&nbsp;Add&nbsp;Roles</b></a></li>
                <li><a href="table.php"><i class="fa fa-university" aria-hidden="true"></i><b>&nbsp;Departments</b></a></li>
                <li><a href="partner.php"><i class="fa fa-users" aria-hidden="true"></i><b>&nbsp;Partner&nbsp;Companies</b></a></li>
                <li><a href="feed.php"><i class="fa fa-comments-o" aria-hidden="true"></i><b>&nbsp;Feedbacks</b></a></li>
                <li><a href="manage-leave.php"><i class="fa fa-calendar" aria-hidden="true"></i><b>&nbsp;Leave Management</b></a></li>
            </ul>
        </div>

        <div class="sidebar-bottom">
        <div class="user-details">
                <div class="div-logout" title="Logout">
                    <a href="?logout" class="profile-logout" onclick="return confirm('Are you sure you want to logout?')"><i class="fa fa-sign-out"></i>&nbsp;Logout</a>
                </div>
            </div>

        </div>
    </div>
</body>
</html>