<?php require_once "user-data-control.php"; ?>
<?php 
	require "function.php";
	

	if(isset($_POST['submit'])){
		$response = loginUser($_POST['username'], $_POST['password']);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/login.css">
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
	<title>Login</title>
</head>
<body>		
	<div class="logo">
		<img src="images/logo-blue.png" alt="logo">
	</div>

	<div class="pending-notice">
			<h3>Your partnership request is pending. Stay await!</h3>
	</div>
</body>
</html>


<?php 

include"function.php";

      if(isset($_GET['logout'])){
        unset($_SESSION['login']);
        session_destroy();
        header("location:../department_head/landingpage.php");
        exit();
      }

      if (!function_exists('connect')) {
        function connect(){
                $mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
                if($mysqli->connect_error != 0){
                    $error = $mysqli->connect_error;
                    $error_date = date("F j, Y, g:i a");
                    $message = "{$error} | {$error_date} \r\n";
                    file_put_contents("db-log.txt", $message, FILE_APPEND);
                    return false;
                }else{
                    $mysqli->set_charset("utf8mb4");
                    return $mysqli;
                }
            }
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
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous">

        var current_page = window.location.href;
        var links = document.querySelectorAll('.sidebar a');
        for (var i = 0; i < links.length; i++) {
        if (links[i].href === current_page) {
            links[i].classList.add('current-page');
            console.log('Link to current page found!')
            }
        }
    </script>
</head>
<body>
<div class="sidebar">

        <img src="images/logo-white.png" alt="logo">
        <div class="sidebar-menu">
            <ul>
                <li><a href="partner-profile.php" id="company-profile"><i class="fa-solid fa-building"></i><b>&nbsp;Company&nbsp;Profile</b></a></li>
                <li><a href="company-feed.php" id="company-feed"><i class="fa fa-gift" aria-hidden="true"></i><b>&nbsp;Company&nbsp;Feed</b></a></li>
                <li><a href="redeem-report.php" id="redeem-report"><i class="fa-solid fa-square-poll-vertical"></i><b>&nbsp;Offer&nbsp;Redeem&nbsp;Report</b></a></li>
            </ul>
        </div>

        <div class="sidebar-bottom">
            <div class="company-deets">

            <?php
                    $mysqli = connect();
                    $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                    $pcompany_user = $_SESSION['pcompany_user'];
                    // $sql= ("SELECT user_name, user_rating, user_review, datetime FROM review_table");
                    $stmt = $mysqli->prepare("SELECT companyname, pcompany_pic FROM partner_company WHERE username = $pcompany_user");
                    //echo $stmt;
                    $stmt->execute();
                    $stmt->store_result();
                    
                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($pcompany_pic);
                        $current_date = NULL;
                        while ($stmt->fetch()){?>


                        <?php if(empty($profilepic_e) ): ?>
                                   <a href="partner-profile.php"> <img class="profile-pic" src="../../views/images/pro-icon-partner.png" alt="test-user" title="Profile">
                                <?php else: ?>
                                    <img class="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($pcompany_pic); ?>" alt="n-user" title="Profile">
                                <?php endif ?></a>


                <h4><?php echo $companyname ?></h4>
            </div>
            <div class="logout">
                <button id="logout">
                    <h4><a href="?logout" onclick="return confirm('Are you sure you want to logout?')">Logout</a> </h4>
                </button>
            </div>
            <?php
                        }
                    }
            ?>

        </div>
    </div>
</body>
</html>









<?php
include 'header.php';
include 'sidebar.php';


if(isset($_POST['submit'])){
    $response = updateProfilePic($_POST['company_pic'],@$_SESSION['pcompany_user']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Blitz</title>
</head>
<body>

    <div class="page-content" style="margin-left:500px">
            <?php
                    $mysqli = connect();
                    $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                    $pcompany_user = $_SESSION['pcompany_user'];
                    $stmt = $mysqli->prepare("SELECT companyname, companyemail, pcompanycon, companyaddress, industry, description, username, pcompany_pic, pcompany_cover FROM partner_company WHERE username = $pcompany_user");
                    $stmt->execute();
                    $stmt->store_result();
                    
                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($companyname, $companyemail, $pcompanycon, $companyaddress, $industry, $description, $username, $pcompany_pic, $pcompany_cover);
                        $current_date = NULL;
                        while ($stmt->fetch()){?>
                            <div class="profile-tbl">
                        <table>
                            <tr>
                                <th>
                                    
                                <?php if(empty($profilepic_e) ): ?>
                                    <img class="profile-pic" src="../../views/images/pro-icon-partner.png" alt="test-user" title="Profile">
                                <?php else: ?>
                                    <img class="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($pcompany_pic); ?>" alt="n-user" title="Profile">
                                <?php endif ?>


                                </th>
                                <th class="th-edit-button"><div class="edit-button" title="Edit Profile">
                                    <?php echo $companyname ?>
                                
                                    
                                        <a href ="update-profile.php"><button class="btn-profile-edit"><i class="fas fa-pen"></i></button></a>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>Company Name </th>
                                <th ><?php echo $companyname ?></th>
                            </tr>
                            <tr>
                                <th>Company&nbsp;Email </th>
                                <th><?php echo $companyemail ?></th>
                            </tr>
                            <tr>
                                <th>Contact&nbsp;Number </th>
                                <th ><?php echo  $pcompanycon ?></th>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <th><?php echo $companyaddress ?></th>
                            </tr>
                            <tr>
                                <th>Company&nbsp;Sector</th>
                                <th><?php echo $industry ?></th>
                            </tr>
                            <tr>
                                <th>About</th>
                                <th><?php echo $description ?></th>
                            </tr>
                            <tr>
                                <th>Username </th>
                                <th><?php echo $username ?></th>
                            </tr>
                        </table>
                    </div>
                        <?php }
                    }?>
                    
                    
            
        </div>
</body>
<script src="../../views/js/main.js"></script>
<script type="text/javascript">
        function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>
</html>

<!-- style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"

style="padding:8px 70px;border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"
-->
<?php

$sql="SELECT offer_cover,type, name, date, amount FROM offers";
$result=mysqli_query($con,$sql);

if($result){
    while($row=mysqli_fetch_assoc($result))
    
{
        $offer_cover=$row['offer_cover'];
        $offertype=$row['type'];
        $offer_name=$row['name'];
        $offer_date=$row['date'];
        $amount=$row['amount'];

        echo 
        '<div style="padding: 20px;">
        <div class="promo">
                <div class="image-container"> 
                    <img src='.$offer_cover.' alt="cover photo">
                </div>
                    <ul>
                        <li><b>'.$offer_name.'</b></li>
                        <li>'.$offertype.' offer</li>
                        <li>Valid until: '.$offer_date.'</li>
                        <li>Save '.$amount.'/=</li>
                    </ul>
        
        </div></div>';
     
      
    }}

    $sql = "SELECT offer_cover, type, name, date, amount, logo, name AS company_name 
        FROM offers
        JOIN partner_company ON company_id = c.id";
$result = mysqli_query($con, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $offer_cover = $row['offer_cover'];
        $offertype = $row['type'];
        $offer_name = $row['name'];
        $offer_date = $row['date'];
        $amount = $row['amount'];
        $company_logo = $row['logo'];
        $company_name = $row['company_name'];

        echo '<div style="padding: 20px;">
        <div class="promo">
            <div class="image-container"> 
                <img src="' . $offer_cover . '" alt="cover photo">
            </div>
            <ul>
            <li><img src="' . $company_logo . '" alt="' . $company_name . '"></li>
            <li>' . $company_name . '</li>
                <li><b>' . $offer_name . '</b></li>
                <li>' . $offertype . ' offer</li>
                <li>Valid until: ' . $offer_date . '</li>
                <li>Save ' . $amount . '/=</li>
                <li><img src="' . $company_logo . '" alt="' . $company_name . '"></li>
                <li>' . $company_name . '</li>
            </ul>
        </div></div>';
    }
}

    

?>  