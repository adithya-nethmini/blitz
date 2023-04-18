<?php

include '../function/function.php';
include 'sidebar.php';
include 'header.php';
$id = $_GET["id"];

$mysqli = connect();

// Prepare the SQL statement with a parameterized query
$sql = "UPDATE notification SET status = 'read' WHERE id = ?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("Failed to prepare statement: " . $mysqli->error);
}

// Bind the parameter to the statement and execute the update
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("Failed to execute statement: " . $stmt->error);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="../../views/css/view-project.css">
</head>

<body>
    <section>

        <div class="profile-container">

            <div class="page-content">
                <?php
                $user = $_SESSION['user'];
                $stmt = $mysqli->prepare("SELECT * FROM `notification` WHERE `id` = ?");
                $stmt->bind_param("i", $_GET['id']);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $notification_name, $notification_description, $notification_details, $notification_type, $username, $date_time, $status);
                    $stmt->fetch();
                ?>

                    <div class="heading">
                        <h1><?php echo $notification_name; ?></h1>
                    </div>
                    <div class="container">
                        <div class="up-outer-container">
                            <div class="up-inner-left">
                                <h3>Description</h3>
                                <?php if ($notification_description == "Direct Message") : ?>
                                    <?php echo $notification_name . ' - ' . $notification_description . ' - ' . $notification_details . 'just messaged'; ?>
                                <?php else : ?>
                                    <?php echo $notification_name . ' - ' . $notification_description ; ?>
                                <?php endif; ?>
                                <?php if ($notification_name == "Leave Cancelled" || $notification_name == "Leave Accepted") : ?>
                                    <a href="leave-status.php"><button class="btn">Leave&nbsp;Status</button></a>
                                <?php elseif ($notification_name == "Messages") : ?>
                                    <a href="chat.php"><button class="btn">View&nbsp;Messages</button></a>
                                <?php endif; ?>
                            </div>

                            <div class="up-inner-mid">
                                <?php $dateTime = new DateTime($date_time); ?>

                                <div>
                                    <h3>Date</h3>
                                    <?php echo $dateTime->format('Y-m-d'); ?>
                                </div>
                                <div>
                                    <h3>Status</h3>
                                    <?php echo $status; ?>
                                </div>


                            </div>
                            <div class="up-inner-right">
                                <div>
                                    <h3>Time</h3>
                                    <?php echo $dateTime->format('H:i:s'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else {
                    echo "<p class='error' style='padding: 20px 0 20px 0;'>Invalid Notification</p>";
                }
                ?>
            </div>
        </div>
    </section>
</body>