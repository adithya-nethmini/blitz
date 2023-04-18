<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
    <title></title>
</head>
<body>
    <header>

      <nav>
            <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Help</a></li>
                
                    <?php
                    $pdo = new PDO("mysql:host=localhost;dbname=blitz", "root", "");
                    // Prepare the SQL query
                    $sql = "SELECT COUNT(*) FROM notification WHERE status = 'unseen' AND notification_type = 4";

                    // Execute the query
                    $stmt = $pdo->query($sql);

                    // Retrieve the count of unseen messages
                    $count = $stmt->fetchColumn(); ?>

                    <li><a href="notification.php" title="Notification">Notification<span class="badge"><?php echo $count ?></span></a></li>
                
      </nav>
        
    </header> 
</body>
</html>