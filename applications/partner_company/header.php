<?php

if (isset($_GET['logout'])) {
    logoutUser();
}

$homeurl = '/blitz/index.php';
$homepage = "/";
$currentpage = $_SERVER['REQUEST_URI'];

$user = @$_SESSION['pcompany_user'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/css/header.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
    <title>Blitz</title>
    <style>
        .badge {
            background-color: red;
            color: white;
            font-size: 10px;
            padding: 2.5px 5px;
            border-radius: 50%;
            position: relative;
            top: -20px;
            right: -5px;
        }
    </style>
</head>

<body>

    <header>

        <nav>
            <ul>
                <li><a href="../../home.php" title="Home">Home</a></li>
                <li><a href="#" title="About">About</a></li>

                <?php 
                $pdo = new PDO("mysql:host=localhost;dbname=blitz", "root", "");
                // Prepare the SQL query
                $sql = "SELECT COUNT(*) FROM notification WHERE status = 'unseen' AND notification_type = 1 AND username = '$user'";

                // Execute the query
                $stmt = $pdo->query($sql);

                // Retrieve the count of unseen messages
                $count = $stmt->fetchColumn(); ?>

                <li><a href="notification.php" title="Notification">Notification<span class="badge"><?php echo $count ?></span></a></li>
                

                <?php if (isset($_SESSION['user'])) : ?>
                    <li class="li-img">
                        <a href='applications/employee/profile.php'>
                            <?php

                            $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                            $user = $_SESSION['user'];
                            $sql = ("SELECT profilepic_e FROM employee WHERE username = '$user'");

                            $result = mysqli_query($con, $sql);

                            if ($result == TRUE) :

                                $count_rows = mysqli_num_rows($result);

                                if ($count_rows > 0) :
                                    while ($row = mysqli_fetch_assoc($result)) :
                                        $profilepic_e = $row['profilepic_e'];

                            ?>
                                        <?php if ($currentpage == $homeurl) : ?>
                                            <?php if (empty($profilepic_e)) : ?>
                                                <img id="profile-pic" src="views/images/user1.png" alt="user" title="Profile">
                                            <?php else : ?>
                                                <img id="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="user" title="Profile">
                                            <?php endif ?>
                                        <?php else : ?>
                                            <?php if (empty($profilepic_e)) : ?>
                                                <img id="profile-pic" src="../../views/images/user1.png" alt="male-user" title="Profile">
                                            <?php else : ?>
                                                <?php
                                                $base64_image = base64_encode($profilepic_e);

                                                // Build the data URI
                                                $mimetype = "image/jpeg"; // Change this to the appropriate MIME type for your image
                                                $data_uri = "data:$mimetype;base64,$base64_image";
                                                ?>
                                                <img id="profile-pic" src="<?php echo $data_uri ?>" alt="n-user" title="Profile">
                                            <?php endif ?>
                                        <?php endif ?>


                                    <?php endwhile ?>

                                <?php else : ?>
                                    <div></div>
                                <?php endif ?>

                            <?php endif ?>

                        </a>
                    </li>
                    <?php

                    if ($currentpage == $homeurl) :
                    ?>
                        <li><a href='?logout' onclick='return confirm("Are you sure you want to logout?")' title="Logout"><i style="font-size:40px;" class="fa fa-sign-out"></i></a></li>
                    <?php endif ?>
                <?php else : ?>

                    <li><a href='applications/employee/login.php' title="Login">Login</a></li>
                    <li><a href='g_signup.php' title="Register">Register</a></li>

                <?php endif ?>
            </ul>
        </nav>
    </header>

</body>

</html>