<?php
include '../function/function.php';
include 'sidebar.php';
include 'header.php';
if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
    session_destroy();
    header("location: ../../index.php");
    exit();
}

$mysqli = connect();
$user = $_SESSION['user'];

if (isset($_POST['submit'])) {
    @$response = sendDirectMessage($_SESSION['user'], $_POST['recipient'], $_POST['message']);
}

$stmt = $mysqli->prepare("SELECT username FROM `employee` WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($username);
    while ($stmt->fetch()) {

        // Prepare the SQL statement with a parameterized query
        $sql2 = "UPDATE chat SET status = 'seen' WHERE recipient = ? AND sender = '$user'";
        $stmt2 = $mysqli->prepare($sql2);
        if (!$stmt2) {
            echo ("Failed to prepare statement: " . $mysqli->error);
        }

        // Bind the parameter to the statement and execute the update
        $stmt2->bind_param("i", $username);
        if (!$stmt2->execute()) {
            echo ("Failed to execute statement: " . $stmt->error);
        }
    }
    error_log("Error: " . $mysqli->error);
}


?>


<html>

<head>
    <link rel="stylesheet" href="../../views/css/chat.css">
    <link rel="stylesheet" href="../../views/css/notification.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <section>
        <div class="page-content">
            <div class="chat-container">
                <div class="member-chat">
                    <div class="member-section" onscroll="saveScrollPosition('scroll2', this)">
                        <div class="div-back-arrow">
                            <a class="back-arrow" href="chat.php"><i class='fa fa-long-arrow-left'></i>&nbsp;&nbsp;Back</a>
                        </div>

                        <div class="member-section-inner">
                            <?php
                            $user = $_SESSION['user'];

                            try {
                                // Establish database connection using PDO
                                $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE, USERNAME, PASSWORD);

                                // Prepare SELECT statement
                                $stmt = $pdo->prepare("SELECT * FROM employee");

                                // Execute SELECT statement
                                $stmt->execute();

                                // Fetch results as associative array
                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Loop through results and display name and email
                                foreach ($results as $row) {
                                    $member = $row['username'];
                                    $stmt2 = $pdo->prepare("SELECT COUNT(*),sender FROM chat WHERE status = 'unseen' AND recipient = '$user' AND sender = '$member'");

                                    // Execute SELECT statement
                                    $stmt2->execute();

                                    // Fetch results as associative array
                                    $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                    // Loop through results and display name and email
                                    foreach ($results2 as $row2) {
                                        $sender_unseen = $row2['sender'];
                                        $count = $row2['COUNT(*)'];
                                        // echo $sender_unseen, $member;
                            ?>

                                        <a class="member-a" href="open-direct-chat.php?username=<?php echo $member; ?>">
                                            <div class="member">
                                                <?php echo $row['name'];

                                                if ($count > 0) : ?>
                                                    <a href="chat.php"><i class='fa-solid fa-message' style="font-size: 30px; color: white"></i><span class="badge"><?php echo $count ?></span></a>

                                                    <?php endif; ?><?php

                                                                    if ($count > 0 && $sender_unseen == $member) {
                                                                        echo $count;
                                                                    }

                                                                    ?>

                                            </div>
                                        </a>

                            <?php
                                    }
                                }
                            } catch (PDOException $e) {
                                echo "Database connection failed: " . $e->getMessage();
                                exit;
                            }
                            ?>
                        </div>

                    </div>
                    <div class="vertical-line"></div>
                    <div class="chat-area" id="chat-area">

                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "get_msgs.php",
            type: "GET",
            data: {
                username: "<?php echo $_GET['username']; ?>"
            },
            success: function(data) {
                $("#chat-area").html(data);
            }
        });
    });
</script>