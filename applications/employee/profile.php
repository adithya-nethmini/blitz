<?php
include '../function/function.php';
include 'sidebar.php';
include 'header.php';
?>

<?php

// if(isset($_POST['submit'])){
//     $response = updateProfilePic(@$_POST['profilepic_e'], $_SESSION['user']);
// }
$mysqli = connect();
$user = $_SESSION['user'];



$mysqli = connect();
$user = $_SESSION['user'];
if (isset($_POST['submit'])) {
    // Retrieve the profile picture from the database
    $sql = "SELECT * FROM employee WHERE username = '$user'";
    $result = mysqli_query($mysqli, $sql);
    if ($result === false) {
        echo "Error retrieving profile picture: " . mysqli_error($mysqli);
    } elseif (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imageData = $row['profilepic_e'];


        $sql = "UPDATE employee SET profilepic_e = NULL WHERE username = '$user'";
        $stmt = $mysqli->prepare($sql);
        mysqli_free_result($result);
        if (!$stmt) {
            echo ("Failed to prepare statement: " . $mysqli->error);
        }

        // Bind the parameter to the statement and execute the update
        if (!$stmt->execute()) {
            echo ("Failed to execute statement: " . $stmt->error);
        }

        // Delete the profile picture from the database
        // $sql = "UPDATE employee SET profilepic_e = NULL WHERE username = '$user'";
        // if (mysqli_query($mysqli, $sql)) {
        //     return "Profile picture deleted successfully from the database.";


        //     // Free up memory
        //     mysqli_free_result($result);
        //     header("Location: " . $_SERVER['PHP_SELF']); // refresh the page
        //     exit();
        // } else {
        //     echo "No profile picture found for user ID: $user";
        // }
    }
    $mysqli->close();
}


if (isset($_POST['upload'])) {

    // Update the profile picture from the database
    $image = $_FILES['profilepic_e']['tmp_name']; // retrieve the temporary path of the uploaded image
    $imageData = file_get_contents($image); // read the image data from the temporary file


    $sql = "UPDATE employee SET profilepic_e = ? WHERE username = '$user'";
    $stmt = $mysqli->prepare($sql);
    mysqli_free_result($result);
    if (!$stmt) {
        echo ("Failed to prepare statement: " . $mysqli->error);
    }

    // Bind the parameter to the statement and execute the update
    $stmt->bind_param("s", $imageData);
    if (!$stmt->execute()) {
        echo ("Failed to execute statement: " . $stmt->error);
    }

    mysqli_stmt_close($stmt);
    $mysqli->close();
}

if (isset($_POST['update'])) {
	// Fetch input $_POST
	$name = $mysqli->real_escape_string($_POST['name']);
	$email = $mysqli->real_escape_string($_POST['email']);
	$contactno = $mysqli->real_escape_string($_POST['contactno']);
	$address = $mysqli->real_escape_string($_POST['address']);
	// $profilepic_e = $mysqli->real_escape_string($_POST['profilepic_e']);

	// Prepared statement
	$stmt = $mysqli->prepare("UPDATE `employee` SET `name`=?, `email`=?, `contactno`=?, `address`=? WHERE `username`='$user'");

	// Bind params
	mysqli_free_result($result);
    if (!$stmt) {
        echo ("Failed to prepare statement: " . $mysqli->error);
    }

    // Bind the parameter to the statement and execute the update
    $stmt->bind_param("ssss", $name,$email,$contactno,$address);
    if (!$stmt->execute()) {
        echo ("Failed to execute statement: " . $stmt->error);
    }

    mysqli_stmt_close($stmt);
    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../views/css/profile.css">
    <link rel="stylesheet" href="../../views/css/header.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Blitz</title>
</head>

<body>
    <section>

        <div class="page-content">

            <!-- <div class="container"> -->

            <?php

            $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
            $user = $_SESSION['user'];

            $sql = ("SELECT name,employeeid,department,jobrole,email,contactno,address,jobstartdate,username,gender,profilepic_e FROM employee WHERE username = '$user'");

            $result = mysqli_query($con, $sql);

            if ($result == TRUE) :

                $count_rows = mysqli_num_rows($result);

                $number = 1; /* # */

                if ($count_rows > 0) :
                    while ($row = mysqli_fetch_assoc($result)) :

                        $name = $row['name'];
                        $employeeid = $row['employeeid'];
                        $department = $row['department'];
                        $jobrole = $row['jobrole'];
                        $email = $row['email'];
                        $contactno = $row['contactno'];
                        $address = $row['address'];
                        $jobstartdate = $row['jobstartdate'];
                        $username = $row['username'];
                        $gender = $row['gender'];
                        $profilepic_e = $row['profilepic_e'];

            ?>

                        <div class="profile-tbl">
                            <table>
                                <tr>
                                    <th>
                                        <a id="update-profile-pic-btn">
                                            <?php if (empty($profilepic_e) && $gender == 'Male') : ?>
                                                <img class="profile-pic" src="../../views/images/pro-icon-male.png" alt="Profile Picture" title="Update Profile Picture">
                                            <?php elseif (empty($profilepic_e) && $gender == 'Female') : ?>
                                                <img class="profile-pic" src="../../views/images/pro-icon-female.png" alt="Profile Picture" title="Update Profile Picture">
                                            <?php else : ?>
                                                <img class="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="Profile Picture" title="Update Profile Picture">
                                            <?php endif ?>
                                        </a>

                                        <div id="update-profile-pic-modal" style="flex-direction:column;justify-content:center;align-items: center;">
                                            <form method="POST" enctype="multipart/form-data" action="" style="flex-direction:column;justify-content:center;align-items: center;">
                                                <?php if (empty($profilepic_e) && $gender == 'Male') : ?>
                                                    <img style="border: #ffff solid 1.5px;width: 200px;height: 200px;" class="profile-pic-update" src="../../views/images/pro-icon-male.png" alt="Profile Picture" title="Update Profile Picture">
                                                    <input type="file" name="profilepic_e">
                                                    <button class="btn-upload" type="submit" name="upload">Upload</button>
                                                <?php elseif (empty($profilepic_e) && $gender == 'Female') : ?>
                                                    <img class="profile-pic-update" src="../../views/images/pro-icon-female.png" alt="Profile Picture" title="Update Profile Picture">
                                                    <input type="file" name="profilepic_e">
                                                    <button type="submit" class="btn-upload" name="upload">Upload</button>
                                                <?php else :
                                                    $base64Image = base64_encode($profilepic_e);
                                                ?>

                                                    <img class="profile-pic-update" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="Profile Picture" title="Update Profile Picture">

                                                    <a href="" onclick="return confirm('Are you sure you want to delete?')"><button type="submit" name="submit" class="btn-delete">Delete</button></a>
                                                <?php endif ?>

                                            </form>
                                        </div>
                                    </th>
                                    <th class="th-edit-button">
                                    <div class="edit-button" title="Edit Profile">
                                        <?php echo $user ?>
                                    <a id="update-profile-btn" class="edit-button" title="Edit Profile">
                                    <button class="btn-profile-edit"><i class='fas fa-pen'></i></button>
                                        </a>
                                        </div>
                                        
                                        <div id="update-profile-modal" style="flex-direction:column;justify-content:center;align-items: center;">
                                            <div class="update-container">
                                                <div class="update-heading">
                                                    <div>
                                                        <h4>Update Employee</h4>
                                                    </div>

                                                </div>
                                                <?php
                                                if (isset($alert_message) and !empty($alert_message)) {
                                                    echo "<div class='alert alert-success'>" . $alert_message . "</div>";
                                                }
                                                ?>

                                                <?php
                                                $mysqli = connect();
                                                // Get employee details
                                                $stmt = $mysqli->prepare("SELECT `name`,`email`,`contactno`,`address` FROM `employee` WHERE `username` = ?");
                                                $stmt->bind_param("s", $_SESSION['user']);
                                                $stmt->execute();
                                                $stmt->store_result();
                                                if ($stmt->num_rows == 1) {
                                                    $stmt->bind_result($name, $email, $contactno, $address);
                                                    $stmt->fetch();
                                                ?>
                                                    <div class="update-content">
                                                        <form action="" method="post" enctype="multipart/form-data">

                                                            <table>
                                                                <tr>
                                                                    <!-- <td class="update-label"></td> -->
                                                                    <td class="update-input"><span>Full Name</span><br><input required type="text" name="name" value="<?= $name ?>"></td>
                                                                </tr>
                                                                <tr>
                                                                    <!-- <td class="update-label"></td> -->
                                                                    <td class="update-input"><span>Email</span><br><input required type="email" name="email" value="<?= $email ?>"></td>
                                                                </tr>
                                                                <tr>
                                                                    <!-- <td class="update-label"></td> -->
                                                                    <td class="update-input"><span>Contact Number</span><br><input required type="text" name="contactno" value="<?= $contactno ?>"></td>
                                                                </tr>
                                                                <tr>
                                                                    <!-- <td class="update-label"></td> -->
                                                                    <td class="update-input"><span>Location</span><br><input required type="text" name="address" value="<?= $address ?>"></td>
                                                                </tr>

                                                            </table>

                                                            <div style="width:100%">
                                                                <button type="submit" name="update" class="btn-update">UPDATE</button>
                                                            </div>

                                                        <?php } else {
                                                        echo "Error: " . mysqli_error($mysqli);
                                                        // echo "<p class='error' style='padding: 20px 0 20px 0;'>Invalid Employee</p>";
                                                    }
                                                        ?>
                                                        </form>


                                                    </div>
                                            </div>
                                        </div>
                                        


                                    </th>
                                </tr>
                                <tr>
                                    <th>Name </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $name ?></th>
                                </tr>
                                <tr>
                                    <th>Employee&nbsp;Id </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $employeeid ?></th>
                                </tr>
                                <tr>
                                    <th>Department </th>
                                    <th style="padding:8px 70px;border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $department ?></th>
                                </tr>
                                <tr>
                                    <th>Job&nbsp;Role </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $jobrole ?></th>
                                </tr>
                                <tr>
                                    <th>Email </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $email ?></th>
                                </tr>
                                <tr>
                                    <th>Contact&nbsp;Number </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $contactno ?></th>
                                </tr>
                                <tr>
                                    <th>Location </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $address ?></th>
                                </tr>
                                <tr>
                                    <th>Job&nbsp;start&nbsp;date </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $jobstartdate ?></th>
                                </tr>
                                <tr>
                                    <th>Username </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $username ?></th>
                                </tr>
                                <tr>
                                    <th>Gender </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $gender ?></th>
                                </tr>
                            </table>
                        </div>

                    <?php endwhile ?>

                <?php else : ?>
                    <div>No data is found</div>
                <?php endif ?>

            <?php endif ?>


            <!-- </div> -->

        </div>
    </section>
</body>
<script src="../../views/js/main.js"></script>
<script type="text/javascript">
    function myFunction() {
        var popup = document.getElementById("myPopup");
        popup.classList.toggle("show");
    }
</script>
<script>
    var updateProfilePicBtn = document.getElementById("update-profile-pic-btn");
    var updateProfilePicModal = document.getElementById("update-profile-pic-modal");

    updateProfilePicBtn.addEventListener("click", function() {
        updateProfilePicModal.style.display = "block";
    });

    window.addEventListener("click", function(event) {
        if (event.target == updateProfilePicModal) {
            updateProfilePicModal.style.display = "none";
        }
    });

    var updateProfileBtn = document.getElementById("update-profile-btn");
    var updateProfileModal = document.getElementById("update-profile-modal");

    updateProfileBtn.addEventListener("click", function() {
        updateProfileModal.style.display = "block";
    });

    window.addEventListener("click", function(event) {
        if (event.target == updateProfileModal) {
            updateProfileModal.style.display = "none";
        }
    });
</script>

</html>