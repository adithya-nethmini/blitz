<?php

if(isset($_GET['logout'])){
logoutUser();
}

$homeurl = '/blitz/index.php';                               
$homepage = "/";
$currentpage = $_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/css/header.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
    <title>Blitz</title>
</head>
<body>
    
    <header>
        
      <nav>
            <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Notification</a></li>
                <?php if (isset($_SESSION['user'])): ?>  
                        <li class="li-img">
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
                                <img class="profile-pic" src="../../views/pro-icon-male.png" alt="male-user">
                                <?php elseif(empty($profilepic_e) && $gender == 'Female'): ?>
                                    <img class="profile-pic" src="../../views/pro-icon-female.png" alt="female-user">
                                    <?php else: ?>
                                    <img class="profile-pic" src="views/images/<?php echo  $profilepic_e ?>" alt="user">
                                    <?php endif ?>
                                    <?php else: ?>
                                        <?php if(empty($profilepic_e) && $gender == 'Male'): ?>
                                <img class="profile-pic" src="../../views/images/pro-icon-male.png" alt="male-user">
                                <?php elseif(empty($profilepic_e) && $gender == 'Female'): ?>
                                    <img class="profile-pic" src="../../views/images/pro-icon-female.png" alt="female-user">
                                    <?php else: ?>
                                    <img class="profile-pic" src="../../views/images/<?php echo  $profilepic_e ?>" alt="user">
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
                                    
                    if($currentpage == $homeurl):
                ?>
                <li><a href='?logout' onclick='return confirm("Are you sure you want to logout?")'><i style="font-size:40px;" class="fa fa-sign-out"></i></a></li>
                <?php endif ?>
                <?php else : ?>

                <li><a href='applications/employee/login.php'>Login</a></li>
                <li><a href='g_signup.php'>Register</a></li>
                
                <?php endif ?>
            </ul>
      </nav>
        
    </header> 
    
    <footer style="margin-left: 400px;">
    <?php echo $currentpage; ?>
    </footer>
</body>
</html>