<?php
include '../function/function.php';
include 'sidebar.php';
include '../../header.php';

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

        // Delete the profile picture from the database
        $sql = "UPDATE employee SET profilepic_e = NULL WHERE username = '$user'";
        if (mysqli_query($mysqli, $sql)) {
            return "Profile picture deleted successfully from the database.</br>Please refresh the";

            // Free up memory
            mysqli_free_result($result);
        } else {
            echo "No profile picture found for user ID: $user";
        }
    }
    $mysqli->close();
}


if (isset($_POST['upload'])) {

    // Update the profile picture from the database
    $image = $_FILES['profilepic_e']['tmp_name']; // retrieve the temporary path of the uploaded image
    $imageData = file_get_contents($image); // read the image data from the temporary file

    $sql = "UPDATE employee SET profilepic_e = ? WHERE username = '$user'";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 's', $imageData);
    if (mysqli_stmt_execute($stmt)) {
        return "Profile picture updated successfully to the database.</div>";
    } else {
        echo "No profile picture found for user ID: $user";
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
    <title>Offers & Promotions</title>
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
                                            <!-- <div class="popup" onclick="myFunction()"><i class='fas fa-pen'></i>
                                    <span class="popuptext" id="myPopup">Update Profile
                                        <input type="file" name="profilepic_e" value="<?php echo $_POST['profilepic_e'] ?>">
                                        <button type= "submit" name="submit"><strong>UPDATE</strong></button>
                                    </span>
                                    </div> -->
                                        </a>

                                        <div id="update-profile-pic-modal">
                                            <form method="POST" enctype="multipart/form-data" action="">
                                                <?php if (empty($profilepic_e) && $gender == 'Male') : ?>
                                                    <img class="profile-pic" src="../../views/images/pro-icon-male.png" alt="Profile Picture" title="Update Profile Picture">
                                                    <input type="file" name="profilepic_e">
                                                    <button class="btn-update" type="submit" name="upload">Upload</button>
                                                <?php elseif (empty($profilepic_e) && $gender == 'Female') : ?>
                                                    <img class="profile-pic" src="../../views/images/pro-icon-female.png" alt="Profile Picture" title="Update Profile Picture">
                                                    <input type="file" name="profilepic_e">
                                                    <button type="submit" class="btn-update" name="upload">Upload</button>
                                                <?php else :
                                                    $base64Image = base64_encode($profilepic_e);
                                                ?>

                                                    <img class="profile-pic" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="Profile Picture" title="Update Profile Picture">

                                                    <a href="" onclick="return confirm('Are you sure you want to delete?')"><button type="submit" name="submit" class="btn-delete">Delete</button></a>
                                                <?php endif ?>

                                            </form>
                                        </div>
                                    </th>
                                    <th class="th-edit-button">
                                        <div class="edit-button" title="Edit Profile">
                                            <?php echo $name ?>


                                            <a href="update-profile.php"><button class="btn-profile-edit"><i class='fas fa-pen'></i></button></a>
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
</script>

</html>