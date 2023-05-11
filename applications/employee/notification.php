<?php
include '../function/function.php';
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="../../views/css/notification.css">
    <style>
        .gray-text {
            color: gray;
        }

        <?php
        // Get the id of the notification from the URL parameter
        $id = $_GET['id'];

        // Generate a CSS class name based on the id
        $css_class = 'notification-' . $id;

        // Output the CSS rules for the generated class
        echo '.' . $css_class . ' { color: gray; }';
        ?>
    </style>
</head>

<body>
    <div class="page-content">
        <h2><i class="far fa-bell"></i>&nbsp;Notifications</h2>

        <?php

        $sql = ("SELECT * FROM notification WHERE notification_type = '1' AND username = '$user' OR username IN (SELECT name FROM project_list WHERE manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0)");

        $result = mysqli_query($mysqli, $sql);

        if ($result == TRUE) :

            $count_rows = mysqli_num_rows($result);

            if ($count_rows > 0) :
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) :

                    $id = $row['id'];
                    $notification_name = $row['notification_name'];
                    $notification_description = $row['notification_description'];
                    $notification_details = $row['notification_details'];
                    $notification_type = $row['notification_type'];
                    $username = $row['username'];
                    $date_time = $row['date_time'];
                    $status = $row['status'];
        ?>

                    <?php if ($notification_type == '1') {
                        $notification_type = 'Employee';
                    } elseif ($notification_type == '2') {
                        $notification_type = 'Partner Company';
                    } elseif ($notification_type == '3') {
                        $notification_type = 'Department Head';
                    } elseif ($notification_type == '4') {
                        $notification_type = 'Company Admin';
                    } else {
                        $notification_type = 'System';
                    } ?>

                    <div class="card-New">
                        <!-- <div id="notification" class="container"> -->
                        <div id="notification" class="container">
                            <?php if ($status == 'read') : ?>
                                <h3 class="read"><?php $i;
                                                    echo $i;
                                                    $i++; ?></h3>
                                <h4 class="read">
                                    <?php if ($notification_description == 'Direct Message' || $notification_description == 'Group Message') {
                                        echo  $notification_name . ' - ' . $notification_description . ' From ' . $notification_details;
                                    } else {
                                        echo  $notification_name . ' - ' . $notification_description;
                                    };
                                    ?>
                                </h4>
                            <?php else : ?>

                                <h3 class="unseen"><?php $i;
                                                    echo $i;
                                                    $i++; ?></h3>
                                <h4 class="unseen">
                                    <?php if ($notification_description == 'Direct Message' || $notification_description == 'Group Message') {
                                        echo  $notification_name . ' - ' . $notification_description . ' From ' . $notification_details;
                                    } else {
                                        echo  $notification_name . ' - ' . $notification_description;
                                    };
                                    ?>
                                </h4>

                            <?php endif; ?>
                            <a href="view-notification.php?id=<?php echo $id; ?>"><button id="test-view" class="view-btn">View</button></a>
                        </div>


                    </div>

                <?php endwhile ?>

            <?php else : ?>


                Caught up all notifications


            <?php endif ?>

        <?php endif ?>



    </div>


</body>

</html>