<?php 
    require_once 'function.php';
    include 'header.php'; 
   // include 'sidebar.php';
?>
<!-- HTML code for the partner profile page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
</head>
<body>
    

<div class="profile-details">
    <?php
    $username = $_SESSION['pcompany_user'];
    
    // Retrieve the profile details from the database
    $stmt = $mysqli->prepare("SELECT companyname, companyemail, pcompanycon, companyaddress, description, pcompany_pic FROM partner_company WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($companyname, $companyemail, $pcompanycon, $companyaddress, $description, $pcompany_pic);
    $stmt->fetch();
    $stmt->close();
    ?>
    <div class="page-content">
    <div class="profile-tbl">
    <div class="addbuttons">
                    <a href ="package.php"><button type="button">Upgrade!</button></a>
                </div>
        <table>
            <tr>
                <th>
                    <div class="profile-picture">
                    <?php
                        //$mysqli=connect();
                        $username = $_SESSION['pcompany_user'];
                        $details = getPartnerCompanyDetails($mysqli, $username);
                        $profilePicture = $details['pcompany_pic'];
                            
                        if ($profilePicture) {
                            echo '<img src="' . $profilePicture . '" alt="Profile Picture">';
                        } else {
                            echo '<img src="../../views/images/pro-icon-partner.png" alt="Profile Picture">';
                        }
                    ?>
                    </div>
                </th>
                <th class="th-edit-button">
                    <div class="edit-button" title="Edit Profile">
                        <div class="edit-button-name">
                            <?php echo $companyname ?>
                        </div>    
                        <a href="update-profile.php">
                            <button class="btn-profile-edit"><i classclass="fas fa-pencil-alt"></i></button>
                        </a>
                        
                    </div>
                </th>
            </tr>
            <tr>
                <td class="profile-label">Company Email:</td>
                <td class="profile-data"><?php echo $companyemail ?></td>
            </tr>
            <tr>
                <td class="profile-label">Company Contact:</td>
                <td class="profile-data"><?php echo $pcompanycon ?></td>
            </tr>
            <tr>
                <td class="profile-label">Company Address:</td>
                <td class="profile-data"><?php echo $companyaddress ?></td>
            </tr>
            <tr>
                <td class="profile-label">Industry:</td>
                <td class="profile-data"><?php echo $industry ?></td>
            </tr>
            <tr>
                <td class="profile-label">Description:</td>
                <td class="profile-data"><?php echo $description ?></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>