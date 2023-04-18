<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Blitz</title>
    <style>
        .badge {
            background-color: red;
            color: white;
            font-size: 12px;
            padding: 2.5px 5px;
            border-radius: 50%;
            position: relative;
            top: -10px;
            right: -5px;
        }
    </style>
</head>

<body>
    <header>

        <nav>
            <div class="container">
                <div class="home">
                    <a href="index.php"> Home </a>
                </div>
                <div class="about">
                    <a href="about.php"> About </a>
                </div>
                <div class="help">
                    <a href="help.php"> Help </a>
                </div>
                <div class="notification">
                    <?php
                        $pdo = new PDO("mysql:host=localhost;dbname=blitz", "root", "");
                        // Prepare the SQL query
                        $sql = "SELECT COUNT(*) FROM notification WHERE status = 'unseen' AND notification_type = 2";

                        // Execute the query
                        $stmt = $pdo->query($sql);

                        // Retrieve the count of unseen messages
                        $count = $stmt->fetchColumn(); ?>

                    <li><a href="notification.php" title="Notification">Notification<span class="badge"><?php echo $count ?></span></a></li>
                </div>
                <div class="pcompany-logo">
                    <a href="partner-profile.php"><img src="images/keels.png" alt=""></a>
                </div>
            </div>
        </nav>

    </header>
</body>

</html>