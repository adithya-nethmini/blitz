<?php 
if(!isset($_SESSION["user"])){
    header("location: login.php");

    exit();
}
      if(isset($_GET['logout'])){
        unset($_SESSION['login']);
        session_destroy();
        header("location: ../../landingpage.php"); 
        exit();
      }

      if(!isset($_SESSION["user"])){
        header("location: ../login.php");
    
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="../../views/css/sidebar.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="sidebar">

        <img class="logo" src="../../views/images/Blitz - Logo - white.png" alt="logo" title="Blitz">
        <div class="sidebar-menu">
            <ul>
                <li><a href="profile.php"><i class="fa fa-user"></i><b>&nbsp;Profile</b></a></li>
                <li><a href="rewards.php"><i class="fas fa-award" aria-hidden="true"></i><b>Rewards</b></a></li>
                <li><a href="QR.php"><i class="fa fa-qrcode"></i><b>&nbsp;QR&nbsp;Code</b></a></li>
                <li><a href="project_list.php"><i class="fa fa-tasks"></i><b>&nbsp;Projects</b></a></li>
                <li><a href="performance.php"><i class="fa fa-line-chart"></i><b>&nbsp;Performance</b></a></li>
                <li><a href="apply-leave.php"><i class='fa fa-paper-plane'></i><b>&nbsp;Apply&nbsp;For&nbsp;Leave</b></a></li>
                <li><a href="leave-status.php"><i class="fas fa-circle-notch"></i><b>&nbsp;Leave&nbsp;Status</b></a></li>
             </ul>
        </div>

        <div class="sidebar-bottom">
            <div class="user-details">
            <?php
                    
                    $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                    $user = $_SESSION['user'];
                    $sql = ("SELECT profilepic_e, gender FROM employee WHERE username = '$user'") ;
    
                    $result = mysqli_query($con, $sql);
    
                    if($result==TRUE):
    
                        $count_rows = mysqli_num_rows($result);
    
                        if($count_rows > 0):
                            while($row = mysqli_fetch_assoc($result)):
                                $profilepic_e = $row['profilepic_e'];
                                $gender = $row['gender'];
    
                ?>
                <!-- <img class="profile-pic" src="../../views/images/<?php /*echo  $profilepic_e */ ?>" alt="test-user"> -->
                <?php if(empty($profilepic_e) && $gender == 'Male'): ?>
                    <img class="profile-pic" src="../../views/images/pro-icon-male.png" alt="test-user" title="Profile">
                    <?php elseif(empty($profilepic_e) && $gender == 'Female'): ?>
                        <img class="profile-pic" src="../../views/images/pro-icon-female.png" alt="test-user" title="Profile">
                        <?php else: ?>
                            <img class="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="n-user" title="Profile">
                        <?php endif ?>
                <?php endwhile ?>
    
                            <?php else: ?>
                                <div>No data is found</div>
                        <?php endif ?>
    
                    <?php endif ?>
                
                <h4 style="text-transform: capitalize;"><?php echo $_SESSION['user'] ?></h4>
            </div>
            <div class="user-details">
                <div class="div-logout" title="Logout">
                    <a href="?logout" class="profile-logout" onclick="return confirm('Are you sure you want to logout?')"><i class="fa fa-sign-out"></i>&nbsp;Logout</a>
                </div>
            </div>
            <!-- <div class="logout">
                <button id="logout">
                    <h4><a href="?logout" onclick="return confirm('Are you sure you want to logout?')">Logout</a> </h4>
                </button>
            </div> -->

        </div>
    </div>
</body>
</html>