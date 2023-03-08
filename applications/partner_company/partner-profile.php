<?php
    include 'header.php'; 
    include 'sidebar.php';
    $mysqli = connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
    <title>Blitz</title>
</head>
<body>
    <div class="page-content">
        <div>
            <?php echo "hello" . @$_SESSION['padmin_user']; ?>
        </div>
        <div class="addbuttons">
            <a href ="upgrade.php"><button type="button" >Upgrade your package!</button></a>
            <a href ="add-offer.php"><button type="button">Add Offers</button></a>
            <a href ="add-promo.php"><button type="button">Add Promotions</button></a>
        </div>
        <?php
                    
                    // $user = $_SESSION['padmin_user'];
                    $number=1;                    
                    $sql = ("SELECT * FROM partner_company where `id` = 1");    
                    $result = mysqli_query($mysqli, $sql); 
                    $row = mysqli_fetch_assoc($result);                               
                    if($result==TRUE){                                
                        $companyname = $row['companyname'];
                        $companyemail = $row['companyemail'];
                        $pcompanycon = $row['pcompanycon'];
                        $companyaddress = $row['companyaddress'];
                        $description = $row['description'];
                        $pcompany_pic = $row['pcompany_pic'];
            ?>        
                    <div class="profile-box">
                        <div class="profile-heading">
                            <img src="images/keels.png" alt="partner company logo">
                            <h3><?php echo $companyname; ?></h3>
                            <i class="fa-regular fa-pen-to-square"></i>
                        </div>
                        <div class="profile-content">
                            <div class="profile-content-in-line">
                                <span id="content-name">Company Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span id="content-detail"><?php echo $companyname; ?></span>
                            </div>
                            <div class="profile-content-in-line">
                                <span id="content-name">Company Email Address&nbsp;&nbsp;&nbsp;</span><span id="content-detail"><?php echo $companyemail; ?></span>
                            </div>
                            <div class="profile-content-in-line">
                                <span id="content-name">Location&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span id="content-detail"><?php echo $companyaddress; ?></span>
                            </div>
                            <div class="profile-content-in-line">
                                <span id="content-name">About company&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span id="content-detail">Keells is a chain of supermarkets in Sri Lanka owned by John Keells Holdings. <br>It is one of the three largest retail operators on the island, alongside Cargills<br> Food City and Arpico Super Center.</span>
                            </div>
                            <div class="profile-content-in-line">
                                <span id="content-name">Contact us&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span id="content-detail"><?php echo $pcompanycon; ?></span>
                            </div>
                        </div>
                    </div>
        <?php
            }
        ?>
    </div>

    <div class="upgrade-btn">
        <a href ="upgrade.php"><button type="button" >Upgrade your package!</button></a>
    </div>

</body>
