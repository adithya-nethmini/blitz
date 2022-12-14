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
    <title>QR Code</title>
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

            <?php 
                /* if(isset()) */
            ?>
            <div class="page">
            
                <div class="rewards-page">
                    <form action="" method="post">
                        <div class="div-rewards">
                            <div>
                                <input class="rewards-input" type="text" name="uniqueId" required placeholder="Enter Unique Id" value="<?php echo @$_POST['deadline']; ?>">
                            </div>    
                            <div>
                                <button class="btn-go" type= "submit" name="submit">Go&nbsp;<i class='fa-solid fa-arrow-right-long'></i></button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="div-profile-space">
            </div>

        </div>
    

    </section>
    
</body>
<script src="../../views/js/main.js"></script>
</html>