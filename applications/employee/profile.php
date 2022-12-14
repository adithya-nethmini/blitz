<?php 

    require "../function/function.php";
    
    if(!isset($_SESSION["user"])){
        header("location: login.php");

        exit();
    }

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
    <title>My Account</title>
    <link rel="stylesheet" href="../../views/css/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

</head>
<body>
<header class="header-profile">
    <nav class="top-nav-landing" style="background-color:#071D70">
        <a href="#"><img class="blitz-logo"src="../../views/images/Blitz - Logo - white.png" alt=""></a>
        <ul class="ul-top-nav-landing">
            <li><a href="../../index.php" class="top-nav-link">Home</a></li>
            <li><a href="#" class="top-nav-link">About</a></li>
            <li><a href="#" class="top-nav-link">Help</a></li>
            
            <?php  if (isset($_SESSION['user'])) : ?>
                    <li><a href='applications/employee/notifications.php' class='top-nav-link'>Notifications</a></li>
              <?php  else : ?>
                    <li><a href='applications/employee/login.php' class='top-nav-link'>Login</a></li>
                    <li><a href='applications/employee/signup.php' class='top-nav-link'>Register</a></li>
              <?php endif ?>
            
        </ul>
        <div class="menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        
    </nav>
    
</header>
    <section>
        <div class="profile-container">
            
            <div class="sidebar">
                
            <a class="sidebar-icon" href="profile.php"><i class='fa fa-user'></i>Profile</a>
                <a class="sidebar-icon" href="rewards.php"><i class="fas fa-award"></i>Rewards</a>
                <a class="sidebar-icon" href="QR.php"><i class="fa fa-qrcode"></i>QR&nbsp;Code</a>
                <a class="sidebar-icon" href="task-manager.php"><i class="fa fa-tasks"></i>Task&nbsp;Manager</a>
                <a class="sidebar-icon" href="performance.php"><i class="fa fa-line-chart"></i>Performance</a>
                <div style="margin: 120px 0 0 0;"></div>
                <div>
                    <a href="profile.php"><i class="fa fa-user-circle" aria-hidden="true"></i><?php echo $_SESSION['user']?></a>
                </div>
                <p class="profile-logout" ><a href="?logout"><i class="fa fa-sign-out"></i>Logout</a></p>
            </div>

            <?php 8
                /* if(isset()) */
            ?>
            <div class="page">
                <div class="profile">
                                    
                <?php
                
                    $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                    $user = $_SESSION['user'];
                    $sql = ("SELECT name,employeeid,department,jobrole,email,contactno,address,jobstartdate,username,gender FROM employee WHERE username = '$user'") ;
    
                    $result = mysqli_query($con, $sql);
    
                    if($result==TRUE):
    
                        $count_rows = mysqli_num_rows($result);
    
                        $number=1; /* # */
    
                        if($count_rows > 0):
                            while($row = mysqli_fetch_assoc($result)):
                                
                                $name = $row['name'];
                                $employeeid = $row['employeeid'];
                                $department = $row['department'];
                                $jobrole = $row['jobrole'];
                                $email = $row['email'];
                                $contactno = $row['contactno'];
                                $address = $row['address'];
                                $jobstartdate = $row['jobstartdate'];
                                $username = $row['username'];
                                $gender = $row['gender'];
    
                ?>
    
                    <div class="profile-tbl">
                        <table>
                            <tr>
                                <th>Name </th>
                                <th style="border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $name ?></th>
                            </tr>
                            <tr>
                                <th>Employee&nbsp;Id </th>
                                <th style="border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $employeeid ?></th>
                            </tr>
                            <tr>
                                <th>Department </th>
                                <th style="padding:8px 70px;border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $department ?></th>
                            </tr>
                            <tr>
                                <th>Job&nbsp;Role </th>
                                <th style="border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $jobrole ?></th>
                            </tr>
                            <tr>
                                <th>Email </th>
                                <th style="border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $email ?></th>
                            </tr>
                            <tr>
                                <th>Contact&nbsp;Number </th>
                                <th style="border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $contactno ?></th>
                            </tr>
                            <tr>
                                <th>Address </th>
                                <th style="border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $address ?></th>
                            </tr>
                            <tr>
                                <th>Job&nbsp;start&nbsp;date </th>
                                <th style="border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $jobstartdate ?></th>
                            </tr>
                            <tr>
                                <th>Username </th>
                                <th style="border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $username ?></th>
                            </tr>
                            <tr>
                                <th>Gender </th>
                                <th style="border: 1px solid #071D70;border-radius:10px;color:black"><?php echo $gender ?></th>
                            </tr>
                        </table>
                    </div>
                            
                                <?php endwhile ?>
    
                            <?php else: ?>
                                <div>No data is found</div>
                        <?php endif ?>
    
                    <?php endif ?>

            </div>
            
        </div>
        <div style="padding:50px;">
            <a class="page-a-space" href="update-profile.php"><button class="btn-profile-edit"><i class='fas fa-user-edit'></i><!-- Edit --></button></a>
        </div>

        </div>
    

    </section>
    
</body>
<script src="../../views/js/main.js"></script>
</html>

<?php

