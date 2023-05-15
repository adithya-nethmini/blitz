<?php

include 'sidebar.php';
include 'header.php';
$mysqli = connect();

$user = $_SESSION['dept_user'];

if (isset($_POST['submit'])) {
    @$response = sendDirectMessage($_SESSION['dept_user'], $_POST['recipient'], $_POST['message']);
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

            <div class="chat-container" style="margin-top:150px">

                <div class="member-chat">

                    <div class="member-section" onscroll="saveScrollPosition('scroll2', this)">
                        <div class="main-chat-container-inner">


                            <a class="member-a" href="depat_head-chat.php">
                                <div class="main-chat-member" style="background-color: #D9D9D9;">
                                    <h3><i class="fa-sharp fa-solid fa-user"></i>&nbsp;Project&nbsp;Manager Chat</h3>
                                </div>
                            </a>

                        </div>
                        <div class="member-section-inner">

                            <?php
                            $mysqli = connect();
                            $user = $_SESSION['dept_user'];
                            $stmt = $mysqli->prepare("SELECT department FROM dept_head WHERE employeeid = '$user'");
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows > 0) {
                                $stmt->bind_result($department);
                                while ($stmt->fetch()) {

                                    // Prepare SELECT statement
                                    $sql = "SELECT manager_id FROM project_list WHERE dept_name = ?";
                                    $stmt = mysqli_prepare($mysqli, $sql);
                                    mysqli_stmt_bind_param($stmt, "s", $department);

                                    // Execute SELECT statement
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    // Loop through results and display name and email
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $member = strtolower($row['manager_id']);
                                        // $sql2 = "SELECT COUNT(*),sender FROM chat WHERE status = 'unseen' AND recipient = ? AND sender = ?";
                                        // $stmt = mysqli_prepare($mysqli, $sql2);
                                        $stmt2 = $mysqli->prepare("SELECT COUNT(*),sender FROM chat WHERE status = 'unseen' AND recipient = ? AND sender = ?");
                                        mysqli_stmt_bind_param($stmt2, "ss", $user, $member);

                                        // Execute SELECT statement
                                        mysqli_stmt_execute($stmt2);
                                        $result2 = mysqli_stmt_get_result($stmt2);

                                        // Loop through results and display name and email
                                        while ($row2 = mysqli_fetch_assoc($result2)) {
                                            $sender_unseen = $row2['sender'];
                                            $count = $row2['COUNT(*)'];
                            ?>

                                            <a class="member-a" href="open-project_manager-chat.php?manager_id=<?php echo $member; ?>">
                                                <div class="member">
                                                    <?php echo $row['manager_id'];

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
                                }
                                // Close connection
                                mysqli_close($mysqli);
                            }
                            ?>


                        </div>
                    </div>
                    <div class="vertical-line"></div>
                    <div class="chat-area">

                        <?php
                        $mysqli = connect();
                        $stmt = $mysqli->prepare("SELECT name,username FROM `employee` WHERE username = ?");
                        $stmt->bind_param("s", $_GET['manager_id']);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows == 1) {
                            $stmt->bind_result($name, $username);
                            $stmt->fetch();
                        ?>
                            <div class="chat-name-display">
                                <h3><?php echo $name;
                                    echo $username;
                                    echo $_SESSION['dept_user'] ?></h3>
                            </div>
                            <hr>


                            <div class="display-message">
                                <?php
                                $first_sender = "";
                                $stmt = $mysqli->prepare("SELECT id, sender, recipient, message, created_date_time, status FROM `chat` WHERE chat_type = 'Direct' AND (`recipient` = ? AND `sender` = ?) OR (`recipient` = ? AND `sender` = ?) ORDER BY created_date_time, id");
                                $stmt->bind_param("ssss", $_SESSION['dept_user'], $username, $username, $_SESSION['dept_user']);
                                $stmt->execute();
                                $stmt->store_result();
                                if ($stmt->num_rows > 0) {
                                    $stmt->bind_result($id, $sender, $recipient, $message, $created_date_time, $status);
                                    $current_date = NULL;
                                    while ($stmt->fetch()) {
                                        if ($sender == $_SESSION['dept_user']) { // Check if sender is current user
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
                                <?= $name ?>
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

<?php
function sendDirectMessage($sender, $recipient, $message)
{
    $mysqli = connect();
    $args = func_get_args();

    // Validate input data types
    if (!is_string($sender) || !is_string($recipient) || !is_string($message)) {
        return "Invalid data types";
    }

    $args = array_map(function ($value) use ($mysqli) {
        //     // Escape special characters
        //     $value = mysqli_real_escape_string($mysqli, trim($value));

        //     // Check for disallowed characters
        //     if (preg_match("/([<|>])/", $value)) {
        //         return "<> characters are not allowed";
        //     }

        return $value;
    }, $args);

    $stmt = $mysqli->prepare("INSERT INTO notification(notification_name, notification_description, notification_details, notification_type, username, status) VALUES('Messages', 'Direct Message', ?, '1', ?, 'unseen')");
    $stmt->bind_param("ss", $sender, $recipient);
    $stmt->execute();
    if ($stmt->affected_rows != 1) {
        return "An error occurred. Please try again";
    } else {
        echo 'Notification sent';
    }
    date_default_timezone_set('Asia/Kolkata');
    $current_date = date('Y-m-d H:i:s');
    $stmt = $mysqli->prepare("INSERT INTO chat(chat_type, sender, recipient, message, created_date_time, status) VALUES('Direct', ?, ?, ?, '$current_date', 'unseen')");
    $stmt->bind_param("sss", $sender, $recipient, $message);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            return true; // message sent successfully
        } else {
            return "Error: No rows affected";
        }
    } else {
        return "Error: " . $stmt->error;
    }
}
?>