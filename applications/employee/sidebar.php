<?php if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
    session_destroy();
    header("location: ../../index.php");
    exit();
}

if (!isset($_SESSION["user"])) {
    header("location: ../login.php");

    exit();
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="../../views/css/sidebar.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="sidebar">

        <img class="logo" src="../../views/images/Blitz - Logo - white.png" alt="logo" title="Blitz">
        <div class="sidebar-menu" onscroll="saveScrollPosition('scroll1', this)">
            <ul>
                <li><a href="profile.php"><i class="fa fa-user"></i><b>&nbsp;Profile</b></a></li>
                <li><a href="rewards.php"><i class="fas fa-award" aria-hidden="true"></i><b>Rewards</b></a></li>
                <li><a href="project_list.php"><i class="fa fa-tasks"></i><b>&nbsp;Projects</b></a></li>
                <li><a href="main_tasks.php"><i class="fa fa-list-alt"></i><b>&nbsp;Tasks</b></a></li>
                <li><a href="performance.php"><i class="fa fa-line-chart"></i><b>&nbsp;Performance</b></a></li>
                <li><a href="apply-leave.php"><i class='fa fa-paper-plane'></i><b>&nbsp;Apply&nbsp;For&nbsp;Leave</b></a></li>
                <li><a href="leave-status.php"><i class="fas fa-circle-notch"></i><b>&nbsp;Leave&nbsp;Status</b></a></li>
            </ul>
        </div>

        <div class="sidebar-bottom">
            <div class="user-details">
                <?php $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                $user = $_SESSION['user'];
                $sql = ("SELECT profilepic_e FROM employee WHERE username = '$user'");

                $result = mysqli_query($con, $sql);

                if ($result == TRUE) :

                    $count_rows = mysqli_num_rows($result);

                    if ($count_rows > 0) :
                        while ($row = mysqli_fetch_assoc($result)) :
                            $profilepic_e = $row['profilepic_e'];
                             ?>
                            <!-- <img class="profile-pic" src="../../views/images/<?php /*echo  $profilepic_e */ ?>" alt="test-user"> -->
                            <?php if (empty($profilepic_e)) : ?>
                                <img class="profile-pic" src="../../views/images/user1.png" alt="test-user" title="Profile">                    
                            <?php else : ?>
                                <?php $base64_image = base64_encode($profilepic_e);

                                // Build the data URI
                                $mimetype = "image/jpeg"; // Change this to the appropriate MIME type for your image
                                $data_uri = "data:$mimetype;base64,$base64_image"; ?>
                                <img class="profile-pic" id="profile-pic" src="<?php echo $data_uri; ?>" alt="user" title="Profile">
                            <?php endif ?>
                        <?php endwhile ?>
                    <?php else : ?>
                        <div>No data is found</div>
                    <?php endif ?>
                <?php endif ?>
                <h4 style="text-transform: capitalize;"><?php echo $_SESSION['user'] ?></h4>

                <?php

$user = $_SESSION['user'];
$mysqli = connect();
$qry = "SELECT COUNT(*) FROM chat WHERE status = 'unseen' AND sender != '$user' AND (recipient = '$user' OR recipient IN (SELECT name FROM project_list WHERE manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0))";
$result = $mysqli->query($qry);
$row = $result->fetch_row();
$count = $row[0]; ?>

<div title="chat">
    <?php if ($count > 0) : ?>
        <a href="direct-chat.php"><i class='fa-solid fa-message' style="font-size: 30px; color: white"></i><span class="badge"><?php echo $count ?></span></a>
    <?php else : ?>
        <a href="direct-chat.php"><i class='fa-solid fa-message' style="font-size: 30px; color: white"></i><span class="badge"><?php echo $count ?></span></a>
    <?php endif; ?>
</div>


            </div>
            <div class="user-details">
                <div class="div-logout" title="Logout">
                    <a href="?logout" class="profile-logout" onclick="return confirm('Are you sure you want to logout?')"><i class="fa fa-sign-out"></i>&nbsp;Logout</a>
                </div>
            </div>

        </div>
    </div>
</body>
<script>
    // retrieve and set the saved scroll position
    window.onload = function() {
        var scrollY = localStorage.getItem('scroll1');
        if (scrollY !== null) {
            var scrollableContainer = document.querySelector('.sidebar-menu');
            scrollableContainer.scrollTo(0, parseInt(scrollY));
        }
    }

    // save the scroll position in localStorage
    function saveScrollPosition(key, element) {
        localStorage.setItem(key, element.scrollTop.toString());
    }
</script>

</html>