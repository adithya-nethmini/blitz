<?php 

include"function.php";

if(!isset($_SESSION["padmin_user"])){
    header("location: login.php");

    exit();
}
      if(isset($_GET['logout'])){
        unset($_SESSION['login']);
        session_destroy();
        header("location:../department_head/landingpage.php");
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
    <link rel="stylesheet" href="css/sidebar.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="sidebar">

        <img src="images/logo-white.png" alt="logo">
        <div class="sidebar-menu">
            <ul>
                <li><a href="partner-profile.php"><i class="fa-solid fa-building"></i><b>&nbsp;Company&nbsp;Profile</b></a></li>
                <li><a href="offers-promotions.php"><i class="fa fa-gift" aria-hidden="true"></i><b>&nbsp;Offers&nbsp;&&nbsp;Promotions</b></a></li>
                <li><a href=""><i class="fa-solid fa-square-poll-vertical"></i><b>&nbsp;Offer&nbsp;Redeem&nbsp;Report</b></a></li>
            </ul>
        </div>

        <div class="sidebar-bottom">
            <div class="company-deets">
                <img src="images/keels.png" alt="partner company logo">
                <h4>Company Name</h4>
            </div>
            <div class="logout">
                <button id="logout">
                    <h4><a href="?logout" onclick="return confirm('Are you sure you want to logout?')">Logout</a> </h4>
                </button>
            </div>

        </div>
    </div>
</body>
</html>