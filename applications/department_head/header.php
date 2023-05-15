<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleheader.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                    <a href="#"> About </a>
                </div>
                <div class="help">
                    <a href="#"> Help </a>
                </div>
                <div class="notification">
                    <?php
                    $pdo = new PDO("mysql:host=localhost;dbname=blitz", "root", "");
                    // Prepare the SQL query
                    $sql = "SELECT COUNT(*) FROM notification WHERE status = 'unseen' AND notification_type = 3";

                    // Execute the query
                    $stmt = $pdo->query($sql);

                    // Retrieve the count of unseen messages
                    $count = $stmt->fetchColumn(); ?>

                    <a href="notification.php" title="Notification">Notification<span class="badge"><?php echo $count ?></span></a>
                </div>
                <div class="pcompany-logo">
                    <a href="profile.php">
                    <img src="profile.png" alt="" style="width:60px;height:60px"></a>
                </div>
            </div>
      </nav>
        
    </header> 
</body>
</html>