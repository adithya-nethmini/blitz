<?php

$homeurl = '/blitz/home.php';                               
$homepage = "/";
$currentpage = $_SERVER['REQUEST_URI'];

if(isset($_GET['logout'])){
// logoutUser();
    unset($_SESSION['login']);
    session_destroy();
    if($currentpage == "/github/blitz/home.php"){
        header("location: index.php"); 
    }else{
        header("location: index.php"); 
    }
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="views/css/header.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
    <title>Blitz</title>
    <style>
    </style>
</head>
<body>
    <header>

      <nav>
            <ul>
                <li><a href="index.php" title="Home">Home</a></li>
                <li><a href="applications/partner_company/about.php" title="About">About</a></li>
                <li><a href="applications/employee/notification.php" title="Notification">Notification</a></li>
                <?php if (isset($_SESSION['user'])): ?>  
                        <li>
                            <a href='applications/employee/profile.php'>
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
                        <?php if($currentpage == $homeurl): ?>
                                <?php if(empty($profilepic_e) && $gender == 'Male'): ?>
                                    <img style="width:60px;height:60px;margin-top:10px" class="profile-pic" src="views/images/pro-icon-male.png" alt="test-user">
                                    <?php elseif(empty($profilepic_e) && $gender == 'Female'): ?>
                                    <img style="width:60px;height:60px;margin-top:10px" class="profile-pic" src="views/images/pro-icon-female.png" alt="test-user">
                                    <?php else: ?>
                                        <img style="width:60px;height:60px;margin-top:10px" class="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="n-user">
                                    <?php endif ?>
                                    <?php else: ?>
                                        <?php if(empty($profilepic_e) && $gender == 'Male'): ?>
                                <img style="width:60px;height:60px;margin-top:10px" class="profile-pic" src="views/images/pro-icon-male.png" alt="test-user">
                                <?php elseif(empty($profilepic_e) && $gender == 'Female'): ?>
                                    <img style="width:60px;height:60px;margin-top:10px" class="profile-pic" src="views/images/pro-icon-female.png" alt="test-user">
                                    <?php else: ?>
                                        <img style="width:60px;height:60px;margin-top:10px" class="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="n-user">
                                    <?php endif ?>
                                    <?php endif ?>
                            <?php endwhile ?>
            
                                    <?php else: ?>
                                        <div></div>
                                <?php endif ?>
            
                            <?php endif ?>
        
                            </a>
                        </li>
                <?php
                                    
                    /* if($currentpage == $homeurl): */
                ?>
                <li><a href='?logout' onclick='return confirm("Are you sure you want to logout?")'><i style="font-size:40px;" class="fa fa-sign-out"></i></a></li>
                <?php /* endif */ ?>
                <?php else : ?>

                <li><a href='applications/login.php' title="Login">Login</a></li>
                <li><a href='applications/g_signup.php' title="Register">Register</a></li>
                
                <?php endif ?>
            </ul>
      </nav>
        
    </header> 
    
</body>
</html>