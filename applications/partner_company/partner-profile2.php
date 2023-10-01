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