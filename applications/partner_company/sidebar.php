<?php
// include_once 'function.php';
if(!isset($_SESSION["pcompany_user"])){
    header("location: ../login.php");

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
    <title>Blitz</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="sidebar">
        <img src="images/logo-white.png" alt="logo">
        <div class="sidebar-menu">
            <ul>
                <li><a href="partner-profile.php" id="company-profile"><i class="fa-solid fa-building"></i><b>&nbsp;Company&nbsp;Profile</b></a></li>
                <li><a href="company-feed.php" id="company-feed"><i class="fa fa-gift" aria-hidden="true"></i><b>&nbsp;Company&nbsp;Feed</b></a></li>
                <li><a href="partner-page.php" id="company-feed"><i class="fa fa-gift" aria-hidden="true"></i><b>&nbsp;Company&nbsp;Page</b></a></li>
                <li><a href="redeem-report.php" id="redeem-report"><i class="fa-solid fa-square-poll-vertical"></i><b>&nbsp;Offer&nbsp;Redeem&nbsp;Report</b></a></li>
            </ul>
        </div>
        <div class="sidebar-bottom">
            <div class="company-deets">

           
         
                <?php
                $mysqli = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                $user = $_SESSION['pcompany_user'];
                $sql = ("SELECT pcompany_pic FROM partner_company WHERE username = '$user'");
                    //$mysqli=connect();
                    $username = $_SESSION['pcompany_user'];
                    $details = getPartnerCompanyDetails($mysqli, $username);
                    $pcompany_pic = $details['pcompany_pic'];
                    $companyName = $details['companyname'];
                    
                    if ($profilePicture) {
                        echo '<img src=' . $pcompany_pic . ' alt="Profile Picture">';
                    } else {
                        echo '<img src="../../views/images/pro-icon-partner.png" alt="Profile Picture">';
                    }
                    echo '<h3>' . $companyName . '</h3>';
                ?>
            </div>
            
            <div class="logout">
                <button id="logout">
                    <h4><a href="?logout" onclick="return confirm('Are you sure you want to logout?')">Logout</a></h4>
                </button>
            </div>
        </div>
    </div>
</body>
</html>
