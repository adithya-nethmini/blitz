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
</head>

<body>
    <section>
        <div class="page-content">

            <div class="chat-container">

                <div class="member-chat">

                    <div class="member-section" onscroll="saveScrollPosition('scroll2', this)">

                        <div class="main-chat-container-inner">

                            <a class="member-a" href="direct-chat.php">

                                <div class="main-chat-member" style="background-color: #ffffff;">
                                    <h3><i class="fa-sharp fa-solid fa-user"></i>&nbsp;Direct Chat</h3>
                                </div>
                            </a>
                            <a class="member-a" href="group-chat.php">
                                <div class="main-chat-member" style="background-color: #ffffff;">
                                    <h3><i class="fa-sharp fa-solid fa-users"></i>&nbsp;Group Chat</h3>
                                </div>
                            </a>
                            <?php
                            $mysqli = connect();
                            $stmt = $mysqli->prepare("SELECT manager_id FROM project_list WHERE manager_id = '$user'");
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows > 0) {
                                $stmt->bind_result($manager);
                                while ($stmt->fetch()) { ?>
                                    <a class="member-a" href="depat_head-chat.php">
                                        <div class="main-chat-member" style="background-color: #D9D9D9;">
                                            <h3><i class="fa-sharp fa-solid fa-user"></i>&nbsp;Dept&nbsp;Head Chat</h3>
                                        </div>
                                    </a>
                            <?php }
                            }
                            ?>

                        </div>
                        <div class="member-section-inner">

                            <?php
                            $user = $_SESSION['user'];
                            $stmt = $mysqli->prepare("SELECT department FROM employee WHERE username = '$user'");
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows > 0) {
                                $stmt->bind_result($department);
                                while ($stmt->fetch()) {

                                    try {
                                        // Establish database connection using PDO
                                        $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE, USERNAME, PASSWORD);


                                        // Prepare SELECT statement
                                        $stmt = $pdo->prepare("SELECT * FROM dept_head WHERE department = '$department'");

                                        // Execute SELECT statement
                                        $stmt->execute();

                                        // Fetch results as associative array
                                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        // Loop through results and display name and email
                                        foreach ($results as $row) {
                                            $member = strtolower($row['name']);
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

                                                <a class="member-a" href="open-dept_head-chat.php?name=<?php echo $member; ?>">
                                                    <div class="member">
                                                        <?php echo $row['name'];

                                                        if ($count > 0) : ?>
                                                            <div class="div-badge">
                                                                <i class='fa-solid fa-message' style="font-size: 30px; color: white"></i><span class="span-badge"><?php echo $count ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </a>

                            <?php
                                            }
                                        }
                                    } catch (PDOException $e) {
                                        echo "Database connection failed: " . $e->getMessage();
                                        exit;
                                    }
                                }
                            }
                            ?>


                        </div>
                    </div>
                    <div class="vertical-line"></div>
                    <div class="chat-area">

                        <?php

                        $user = $_SESSION['user'];
                        $stmt = $mysqli->prepare("SELECT employeeid,name FROM `dept_head` WHERE `name` = ?");
                        $stmt->bind_param("s", $_GET['name']);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows > 0) {
                            $stmt->bind_result($username,$name);
                            $stmt->fetch();
                        ?>
                            <div class="chat-name-display">
                                <h3><?php echo $name;  ?></h3>
                            </div>
                            <hr>


                            <div class="display-message">
                                <?php
                                $first_sender = "";
                                $stmt = $mysqli->prepare("SELECT id, sender, recipient, message, created_date_time, status FROM `chat` WHERE chat_type = 'Direct' AND (`recipient` = ? AND `sender` = ?) OR (`recipient` = ? AND `sender` = ?) ORDER BY created_date_time, id");
                                $stmt->bind_param("ssss", $_SESSION['user'], $username, $username, $_SESSION['user']);
                                $stmt->execute();
                                $stmt->store_result();
                                if ($stmt->num_rows > 0) {
                                    $stmt->bind_result($id, $sender, $recipient, $message, $created_date_time, $status);
                                    $current_date = NULL;
                                    while ($stmt->fetch()) {
                                        if ($sender == $_SESSION['user']) { // Check if sender is current user
                                ?>
                                            <div class="outgoing-messages">

                                                <?php

                                                $message_date = date("Y-m-d", strtotime($created_date_time)); // extract the date from the created_date_time

                                                // display the date if it's different from the current date
                                                if ($current_date === null || $message_date !== $current_date) {
                                                    echo '<div class="message-date">' . date("F j, Y", strtotime($created_date_time)) . '</div>';
                                                    $current_date = $message_date;
                                                }
                                                ?>
                                                <h6 title="<?php echo date("H:i:s", strtotime($created_date_time)); ?>">
                                                    <span><?php echo $message; ?></span>
                                                    <span class="message-details">
                                                        <?php if ($status == 'seen') : ?>
                                                            <span class="status-seen"><?php echo $status; ?></span>
                                                        <?php else : ?>
                                                            <span class="status-unseen"><?php echo $status; ?></span>
                                                        <?php endif; ?>
                                                    </span>

                                                </h6>

                                            </div>
                                        <?php } else { // Messages from receiver 
                                        ?>
                                            <div class="incoming-messages">
                                                <?php
                                                $message_date = date("Y-m-d", strtotime($created_date_time)); // extract the date from the created_date_time

                                                // display the date if it's different from the current date
                                                if ($current_date === null || $message_date !== $current_date) {
                                                    echo '<div class="message-date">' . date("F j, Y", strtotime($created_date_time)) . '</div>';
                                                    $current_date = $message_date;
                                                }
                                                ?>
                                                <h6 title="<?php echo date("H:i:s", strtotime($created_date_time)); ?>">
                                                    <?php echo $message; ?>
                                                </h6>
                                            </div>
                                <?php }
                                    }
                                    error_log("Error: " . $mysqli->error);
                                }
                                ?>
                            </div>



                            <div class="message-sending-section">
                                <?=$name?>
                                <div class="type-message">
                                    <form action="" method="POST">
                                        <input type="text" name="message" id="message" class="message" required placeholder="Type your message here..." autocomplete="nope-123456789">
                                        <input type="hidden" name="recipient" value="<?php echo $username; ?>">
                                </div>
                                <div class="send-message">
                                    <button type="submit" name="submit" class="msg-send-btn">Send</button>
                                </div>
                                </form>
                            </div>
                        <?php } else {
                            error_log("Error: " . $mysqli->error);
                            echo "<div class='chat-area-inner'>
                            <h4>Your messages will display here</h4>
                        </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>


        <?php

        $stmt = $mysqli->prepare("SELECT username FROM `employee` WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($username);
            while ($stmt->fetch()) {

                // Prepare the SQL statement with a parameterized query
                $sql2 = "UPDATE chat SET status = 'seen' WHERE recipient = '$user' AND sender = ?";
                $stmt2 = $mysqli->prepare($sql2);
                if (!$stmt2) {
                    echo ("Failed to prepare statement: " . $mysqli->error);
                }

                // Bind the parameter to the statement and execute the update
                $stmt2->bind_param("s", $username);
                if (!$stmt2->execute()) {
                    echo ("Failed to execute statement: " . $stmt->error);
                }
            }
            error_log("Error: " . $mysqli->error);
        }
        ?>

    </section>
</body>
<script>
    // retrieve and set the saved scroll position
    window.onload = function() {
        var scrollY = localStorage.getItem('scroll2');
        if (scrollY !== null) {
            var scrollableContainer = document.querySelector('.member-section');
            scrollableContainer.scrollTo(0, parseInt(scrollY));
        }
    }

    // save the scroll position in localStorage
    function saveScrollPosition(key, element) {
        localStorage.setItem(key, element.scrollTop.toString());
    }
</script>
<script>
    // Reload the page if the message input field loses focus
    document.addEventListener("click", function(event) {
        var messageInput = document.getElementById("message");
        if (document.activeElement !== messageInput) {
            location.reload();
        }
    });
</script>

</html>