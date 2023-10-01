<?php 
include 'header.php'; 
include 'sidebar.php'; 
// include 'function.php';
session_start();
define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'blitz');

function connect() {
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'blitz';
    
    $mysqli = new mysqli($hostname, $username, $password, $dbname);
    
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    
    return $mysqli;
}
// if (isset($_POST['submit'])) {
//     $response = updateProfilePic($_POST['company_pic'], @$_SESSION['pcompany_user']);
// }

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
    
    <div class="wrapper">
    <div class="addbuttons">
                    <a href ="packages.php"><button type="button">Upgrade now</button></a>
                </div>

    <div class="page-content-profile" >
        
        <?php
        $mysqli = connect();
        $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
        $pcompany_user = $_SESSION['pcompany_user'];
        $stmt = $mysqli->prepare("SELECT companyname, companyemail, pcompanycon, companyaddress, industry, description, username, pcompany_pic, pcompany_cover FROM partner_company WHERE username = ?");
        $stmt->bind_param("s", $pcompany_user);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($companyname, $companyemail, $pcompanycon, $companyaddress, $industry, $description, $username, $pcompany_pic, $pcompany_cover);
            $current_date = NULL;
            while ($stmt->fetch()) {
        ?>
                <div class="profile-tbl">
                    <table>
                        <tr>
                            <th>
                                <?php if (empty($pcompany_pic)) : ?>
                                    <img class="profile-pic" src="../../views/images/pro-icon-partner.png" alt="test-user" title="Profile">
                                <?php else : ?>
                                    <img class="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($pcompany_pic); ?>" alt="n-user" title="Profile">
                                <?php endif ?>
                            </th>
                            <th class="th-edit-button">
                                <div class="edit-button" title="Edit Profile">
                                <?php echo $companyname ?>
                                    <a href="update-profile.php"><button class="btn-profile-edit"><i class="fas fa-pencil-alt"></i></button></a>
                                </div>
                            </th>
                                </tr>
                                <tr>
                                    <td class="profile-label">Company Name:</td>
                                    <td class="profile-data"><?php echo $companyname ?></td>
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
                                    <td class="profile-label">Catagory:</td>
                                    <td class="profile-data"><?php echo $industry ?></td>
                                </tr>
                                <tr>
                                    <td class="profile-label">Description:</td>
                                    <td class="profile-data"><?php echo $description ?></td>
                                </tr>
                                </table>
                                </div>
                                <?php
                                        }
                                    } else {
                                        echo "No data found!";
                                    }
                                    $stmt->close();
                                    ?>
                                </div>
                                </div>

                                </body>
                                </html>
