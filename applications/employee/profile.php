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

    // Sanitize and validate the $user variable to prevent SQL injection
    $user = $_SESSION['user'];

    // Check that the uploaded file is an image and validate its size
    $image = $_FILES['profilepic_e']['tmp_name'];
    $imageType = exif_imagetype($image);
    $allowedTypes = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);
    $maxFileSize = 5242880; // 5 MB in bytes
    if (!in_array($imageType, $allowedTypes) || filesize($image) > $maxFileSize) {
        echo "Error: Invalid image file or file size exceeded maximum limit.";
        exit();
    }

    // Read the image data from the temporary file
    $imageData = file_get_contents($image);

    // Prepare and execute the SQL query to update the profile picture
    $sql = "UPDATE employee SET profilepic_e = ? WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        echo "Error: Failed to prepare statement.";
        exit();
    }
    $stmt->bind_param("ss", $imageData, $user);
    if (!$stmt->execute()) {
        echo "Error: Failed to update profile picture.";
        exit();
    }
    $stmt->close();

    $mysqli->close();

    echo '<meta http-equiv="refresh" content="0;url=' . $_SERVER['PHP_SELF'] . '">';
    echo '<meta http-equiv="refresh" content="1;url=' . $_SERVER['PHP_SELF'] . '">';
    exit();
}


if (isset($_POST['update'])) {
    // Fetch input $_POST
    $name = $mysqli->real_escape_string($_POST['name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $contactno = $mysqli->real_escape_string($_POST['contactno']);
    // $profilepic_e = $mysqli->real_escape_string($_POST['profilepic_e']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Sorry! Email is not valid";
    } else {
        // Prepared statement
        $stmt = $mysqli->prepare("UPDATE `employee` SET `name`=?, `email`=?, `contactno`=? WHERE `username`='$user'");
    
        // Bind params
        mysqli_free_result($result);
        if (!$stmt) {
            echo ("Failed to prepare statement: " . $mysqli->error);
        }
    
        // Bind the parameter to the statement and execute the update
        $stmt->bind_param("sss", $name, $email, $contactno);
        if (!$stmt->execute()) {
            echo ("Failed to execute statement: " . $stmt->error);
        }
    
        mysqli_stmt_close($stmt);
        $mysqli->close();
    }
    
    if (isset($error)) {
        echo $error;
    }
}    

// Charts


// Awards Chart 

$mysqli = connect();

$query = "SELECT DATE_FORMAT(month, '%M') AS month, COUNT(*) AS num_awards FROM loyalty WHERE username = '$user' GROUP BY MONTH(month)";

$result = mysqli_query($mysqli, $query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Step 3: Format the data for the chart (example assumes two columns: 'label' and 'value')
$chartData = [];
foreach ($data as $row) {
    $chartData[] = [$row['month'], (int)$row['num_awards']];
}



// // Get the counts of awards by month for the user
// $query = "SELECT DATE_FORMAT(month, '%m') AS month, COUNT(*) AS num_awards FROM loyalty WHERE username = '$user' GROUP BY MONTH(month)";

// $result = mysqli_query($mysqli, $query);
// $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// // Initialize an array to hold the counts of awards for each month
// $countsByMonth = array_fill(1, 12, 0);

// // Store the counts of awards in the array by month
// foreach ($data as $row) {
//     $month = intval($row['month']);
//     $countsByMonth[$month] = intval($row['num_awards']);
// }

// // Generate the chart data
// $chartData = array();
// for ($month = 1; $month <= 12; $month++) {
//     $monthName = date("F", mktime(0, 0, 0, $month, 1));
//     $chartData[] = array($monthName, $countsByMonth[$month]);
// }


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

            $sql = ("SELECT name,employeeid,department,jobrole,email,contactno,jobstartdate,username,profilepic_e FROM employee WHERE username = '$user'");

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
                        $jobstartdate = $row['jobstartdate'];
                        $username = $row['username'];
                        $profilepic_e = $row['profilepic_e'];

            ?>

                        <div class="profile-tbl">
                            <table>
                                <tr>
                                    <th>
                                        <a id="update-profile-pic-btn">
                                            <?php if (empty($profilepic_e)) : ?>
                                                <img class="profile-pic" src="../../views/images/user1.png" alt="Profile Picture" title="Update Profile Picture">
                                            <?php else : ?>
                                                <img class="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="Profile Picture" title="Update Profile Picture">
                                            <?php endif ?>
                                        </a>

                                        <div id="update-profile-pic-modal">
                                            <form id="update-pro-pic" method="POST" enctype="multipart/form-data" action="">
                                                <?php if (empty($profilepic_e)) : ?>
                                                    <img style="border: #ffff solid 1.5px;width: 200px;height: 200px;" class="profile-pic-update" src="../../views/images/pro-icon-male.png" alt="Profile Picture" title="Update Profile Picture">
                                                    <input type="file" name="profilepic_e">
                                                    <button class="btn-upload" type="submit" name="upload">Upload</button>
                                                <?php else :
                                                    $base64Image = base64_encode($profilepic_e);
                                                ?>

                                                    <img style="border: #ffff solid 1.5px;width: 200px;height: 200px;" class="profile-pic-update" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="Profile Picture" title="Update Profile Picture">
                                                    <input type="file" name="profilepic_e">
                                                    <button type="submit" class="btn-upload" name="upload">Upload</button>
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
                                                $stmt = $mysqli->prepare("SELECT `name`,`email`,`contactno` FROM `employee` WHERE `username` = ?");
                                                $stmt->bind_param("s", $_SESSION['user']);
                                                $stmt->execute();
                                                $stmt->store_result();
                                                if ($stmt->num_rows == 1) {
                                                    $stmt->bind_result($name, $email, $contactno);
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
                                    <th>Job&nbsp;start&nbsp;date </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $jobstartdate ?></th>
                                </tr>
                                <tr>
                                    <th>Username </th>
                                    <th style="border: 1px solid #071D70;border-radius:10px;color:white;background-color:#071D70;text-align:center"><?php echo $username ?></th>
                                </tr>
                            </table>
                        </div>

                    <?php endwhile ?>

                <?php else : ?>
                    <div>No data is found</div>
                <?php endif ?>

            <?php endif ?>

            <!-- </div> -->

            <div class="profile-dashboard">
                <div class="group">

                    <a id="project-chart">
                        <div class="button">
                            <?php
                            $user = $_SESSION['user'];
                            $stmt = $mysqli->prepare("SELECT COUNT(*) FROM project_list WHERE manager_id = ? OR FIND_IN_SET(?, user_ids) > 0");
                            $stmt->bind_param("ss", $user, $user);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_array();
                            $count = $row[0];
                            ?>

                            <i class="fa fa-tasks"></i>
                            <h4><?php echo $count; ?>&nbsp;Projects</h4>

                        </div>
                    </a>

                    <div id="project-chart-modal" style="flex-direction:column;justify-content:center;align-items: center;">
                        <div class="project-chart-container">
                            <h3 style="padding:20px 0 30px 0">Monthly Project Distribution</h3>
                            <table class="project-tbl">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $mysqli = connect();
                                    date_default_timezone_set('Asia/Kolkata');
                                    $current_month = date('n');
                                    $stmt = $mysqli->prepare("SELECT name, status FROM project_list WHERE (MONTH(start_date) = '$current_month' OR MONTH(end_date) = '$current_month') AND manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0");
                                    $stmt->execute();
                                    $stmt->store_result();
                                    if ($stmt->num_rows > 0) {
                                        $stmt->bind_result($name, $status);
                                        while ($stmt->fetch()) { ?>
                                            <tr>
                                                <td><?= $name ?></td>
                                                <?php if ($status == 0) {
                                                    $status = 'Started'; ?>
                                                    <td><span class="started"><?= $status ?></span></td>
                                                <?php } elseif ($status == 3) {
                                                    $status = 'On-Progress'; ?>
                                                    <td><span class="ongoing"><?= $status ?></span></td>
                                                <?php } else {
                                                    $status = 'Done'; ?>
                                                    <td><span class="done"><?= $status ?></span></td>
                                                <?php } ?>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <a id="project-task-chart">
                        <div class="button">
                            <?php
                            $user = $_SESSION['user'];
                            $stmt = $mysqli->prepare("SELECT COUNT(*) FROM task_list WHERE emp_id = ?");
                            $stmt->bind_param("s",  $user);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_array();
                            $count = $row[0];
                            ?>
                            <i class="fa fa-tasks"></i>
                            <h4><?php echo $count; ?>&nbsp;Project Tasks</h4>
                        </div>
                    </a>
                    <div id="project-task-chart-modal" style="flex-direction:column;justify-content:center;align-items: center;">
                        <div class="project-task-chart-container">

                            <h3 style="padding:20px 0 30px 0">Monthly Project Task Distribution</h3>
                            <table class="project-tbl">
                                <thead>
                                    <tr>
                                        <th>Project Task</th>
                                        <th>Status</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    $mysqli = connect();
                                    $user = $_SESSION['user'];
                                    date_default_timezone_set('Asia/Kolkata');
                                    $current_month = date('n');
                                    $stmt = $mysqli->prepare("SELECT task, status FROM task_list WHERE emp_id = '$user' AND (MONTH(start_date) = '$current_month' OR MONTH(end_date) = '$current_month') ");

                                    $stmt->execute();

                                    $stmt->store_result();
                                    if ($stmt->num_rows > 0) {
                                        $stmt->bind_result($name, $status);
                                        while ($stmt->fetch()) { ?>
                                            <tr>
                                                <td><?= $name ?></td>
                                                <?php if ($status == 0) {
                                                    $status = 'Started'; ?>
                                                    <td><span class="started"><?= $status ?></span></td>
                                                <?php } elseif ($status == 3) {
                                                    $status = 'On-Progress'; ?>
                                                    <td><span class="ongoing"><?= $status ?></span></td>
                                                <?php } else {
                                                    $status = 'Done'; ?>
                                                    <td><span class="done"><?= $status ?></span></td>
                                                <?php } ?>


                                            <?php }
                                    } else { ?>
                                            <td>No any allocated tasks from the projects</td>
                                        <?php } ?>
                                            </tr>
                                            <?php $stmt->close(); // close the statement
                                            ?>

                                </tbody>
                            </table>

                        </div>
                    </div>



                    <a id="task-chart">
                        <div class="button">
                            <?php
                            $user = $_SESSION['user'];
                            $stmt = $mysqli->prepare("SELECT COUNT(*) FROM task WHERE employeeid = ?");
                            $stmt->bind_param("s", $user);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_array();
                            $count = $row[0];
                            ?>

                            <i class="fa fa-list-alt"></i>
                            <h4><?php echo $count; ?>&nbsp;Tasks</h4>

                        </div>
                    </a>
                    <div id="task-chart-modal" style="flex-direction:column;justify-content:center;align-items: center;">
                        <div class="task-chart-container">

                            <h3 style="padding:20px 0 30px 0">Monthly Task Distribution</h3>
                            <table class="project-tbl">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $mysqli = connect();
                                    date_default_timezone_set('Asia/Kolkata');
                                    $current_month = date('n');


                                    $stmt = $mysqli->prepare("SELECT name, status FROM task WHERE (MONTH(start_date) = '$current_month' OR MONTH(end_date) = '$current_month') AND employeeid = ?");
                                    $stmt->bind_param("s", $user);
                                    $stmt->execute();
                                    $stmt->store_result();
                                    if ($stmt->num_rows > 0) {
                                        $stmt->bind_result($name, $status);
                                        $current_date = NULL;
                                        while ($stmt->fetch()) { ?>
                                            <tr>
                                                <td><?= $name ?></td>
                                                <?php if ($status == 0) {
                                                    $status = 'Started'; ?>
                                                    <td><span class="started"><?= $status ?></span></td>
                                                <?php } elseif ($status == 3) {
                                                    $status = 'On-Progress'; ?>
                                                    <td><span class="ongoing"><?= $status ?></span></td>
                                                <?php } else {
                                                    $status = 'Done'; ?>
                                                    <td><span class="done"><?= $status ?></span></td>
                                                <?php } ?>

                                            </tr>
                                    <?php }
                                    }

                                    $stmt->close();
                                    $mysqli->close(); ?>
                                </tbody>
                            </table>

                        </div>
                    </div>



                    <a id="awards-chart">
                        <div class="button">
                            <?php
                            $mysqli = connect();
                            $user = $_SESSION['user'];
                            $stmt = $mysqli->prepare("SELECT COUNT(*) FROM loyalty WHERE username = ?");
                            $stmt->bind_param("s", $user);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_array();
                            $count = $row[0];

                            ?>
                            <i class="fas fa-award" aria-hidden="true"></i>
                            <h4><?php echo $count; ?>&nbsp;&nbsp;Awards</h4>


                        </div>
                    </a>
                    <div id="awards-chart-modal" style="flex-direction:column;justify-content:center;align-items: center;">
                        <div class="awards-chart-container">
                            <h3 style="padding:20px 0 30px 0">Monthly Award Distribution</h3>
                            <div id="award_column_chart_div" style="width: 100%; height: 400px;"></div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        </div>

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

    // var updateProfileBtn2 = document.getElementById("update-profile-btn2");
    // var updateProfileModal2 = document.getElementById("update-profile-modal3");

    // updateProfileBtn2.addEventListener("click", function() {
    //     updateProfileModal2.style.display = "block";
    // });

    // window.addEventListener("click", function(event) {
    //     if (event.target == updateProfileModal2) {
    //         updateProfileModal2.style.display = "none";
    //     }
    // });

    var projectChart = document.getElementById("project-chart");
    var projectChartModal = document.getElementById("project-chart-modal");

    projectChart.addEventListener("click", function() {
        projectChartModal.style.display = "block";
    });

    window.addEventListener("click", function(event) {
        if (event.target == projectChartModal) {
            projectChartModal.style.display = "none";
        }
    });

    var projectTaskChart = document.getElementById("project-task-chart");
    var projectTaskChartModal = document.getElementById("project-task-chart-modal");

    projectTaskChart.addEventListener("click", function() {
        projectTaskChartModal.style.display = "block";
    });

    window.addEventListener("click", function(event) {
        if (event.target == projectTaskChartModal) {
            projectTaskChartModal.style.display = "none";
        }
    });

    var TaskChart = document.getElementById("task-chart");
    var TaskChartModal = document.getElementById("task-chart-modal");

    TaskChart.addEventListener("click", function() {
        TaskChartModal.style.display = "block";
    });

    window.addEventListener("click", function(event) {
        if (event.target == TaskChartModal) {
            TaskChartModal.style.display = "none";
        }
    });

    var awardsChart = document.getElementById("awards-chart");
    var awardsChartModal = document.getElementById("awards-chart-modal");

    awardsChart.addEventListener("click", function() {
        awardsChartModal.style.display = "block";
    });

    window.addEventListener("click", function(event) {
        if (event.target == awardsChartModal) {
            awardsChartModal.style.display = "none";
        }
    });
</script>

<?php
$stmt = $mysqli->prepare("SELECT loyalty_type FROM loyalty WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($loyalty_type);
    while ($stmt->fetch()) {

?>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawColumnChart);

            function drawColumnChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Label');
                data.addColumn('number', 'value');
                data.addRows(<?php echo json_encode($chartData); ?>);

                var options = {
                    title: 'Monthly Award Distribution',
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('award_column_chart_div'));
                chart.draw(data, options);
            }
        </script>
<?php
    }
} ?>

</html>