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
    @$response = sendGroupMessage($_SESSION['user'], $_POST['recipient'], $_POST['message']);
}

$id = $_GET['id'];

$stmt = $mysqli->prepare("SELECT name,manager_id,user_ids FROM `project_list` WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($name, $manager_id, $user_ids);
    while ($stmt->fetch()) {

        // Prepare the SQL statement with a parameterized query
        $sql2 = "UPDATE chat SET status = 'seen' WHERE recipient = ? AND sender != '$user'";
        $stmt2 = $mysqli->prepare($sql2);
        if (!$stmt2) {
            echo ("Failed to prepare statement: " . $mysqli->error);
        }

        // Bind the parameter to the statement and execute the update
        $stmt2->bind_param("s", $name);
        if (!$stmt2->execute()) {
            echo ("Failed to execute statement: " . $stmt->error);
        }
    }
    error_log("Error: " . $mysqli->error);
}
$stmt->close();
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
                    <div class="member-section">
                        <div class="div-back-arrow">
                            <a class="back-arrow" href="chat.php"><i class='fa fa-long-arrow-left'></i>&nbsp;&nbsp;Back</a>

                        </div>
                        <div class="member-section-inner">

                            <?php
                            $user = $_SESSION['user'];

                            try {
                                // Establish database connection using PDO
                                $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE, USERNAME, PASSWORD);

                                // Prepare SELECT statement with parameter binding
                                $stmt = $pdo->prepare("SELECT * FROM project_list WHERE manager_id = ? OR FIND_IN_SET(?, user_ids) > 0");

                                // Bind values to the prepared statement
                                $stmt->execute([$user, $user]);

                                // Fetch results as associative array
                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($results) > 0) {
                                    // Loop through results and display name and email
                                    foreach ($results as $row) {
                                        $project_name = $row['name'];
                                        $stmt2 = $pdo->prepare("SELECT COUNT(*),sender FROM chat WHERE status = 'unseen' AND recipient = '$project_name' AND sender != '$user'");

                                        // Execute SELECT statement
                                        $stmt2->execute();

                                        // Fetch results as associative array
                                        $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                        // Loop through results and display name and email
                                        foreach ($results2 as $row2) {
                                            $sender_unseen = $row2['sender'];
                                            $count = $row2['COUNT(*)'];
                            ?>

                                            <a class="member-a" href="open-group-chat.php?id=<?php echo $row['id']; ?>">
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
                                } else {
                                    // Display message when there are no projects assigned
                                    echo "No projects assigned.";
                                }
                            } catch (PDOException $e) {
                                echo "Database connection failed: " . $e->getMessage();
                                exit;
                            }
                            ?>

                        </div>


                    </div>
                    <div class="vertical-line"></div>
                    <div class="chat-area">

                        <?php
                        $stmt = $mysqli->prepare("SELECT name,manager_id,user_ids FROM `project_list` WHERE `id` = ?");
                        $stmt->bind_param("s", $_GET['id']);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows == 1) {
                            $stmt->bind_result($name, $manager_id, $user_ids);
                            $stmt->fetch();
                        ?>
                            <div class="chat-name-display">
                                <h3><?php echo $name  ?></h3>
                                <h4><?php echo $manager_id . '(Project Manager), ' . $user_ids ?></h4>
                            </div>
                            <hr>
                            <div class="display-message">
                                <?php
                                $first_sender = "";
                                $stmt = $mysqli->prepare("SELECT id, sender, recipient, message, created_date_time, status FROM `chat` WHERE chat_type = 'Group' AND recipient = ? ORDER BY created_date_time, id");
                                $stmt->bind_param("s", $name);
                                $stmt->execute();
                                $stmt->store_result();
                                if ($stmt->num_rows > 0) {
                                    $stmt->bind_result($id, $sender, $recipient, $message, $created_date_time, $status);
                                    $current_date = NULL;
                                    while ($stmt->fetch()) {
                                        if (strtolower($sender) == strtolower($_SESSION['user'])) { // Check if sender is current user
                                ?>
                                            <div class="outgoing-messages">
                                                <?php
                                                $message_date = date("Y-m-d", strtotime($created_date_time)); // extract the date from the created_date_time

                                                // display the date if it's different from the current date
                                                if ($current_date === null || $message_date !== $current_date) {
                                                    echo '<div>' . date("F j, Y", strtotime($created_date_time)) . '</div>';
                                                    $current_date = $message_date;
                                                }
                                                ?>
                                                <span class="sender-name"><?php echo $sender; ?></span>
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
                                                    echo '<div>' . date("F j, Y", strtotime($created_date_time)) . '</div>';
                                                    $current_date = $message_date;
                                                }
                                                ?>
                                                <span class="sender-name"><?php echo $sender; ?></span>
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
                                <div class="type-message">
                                    <form action="" method="POST">
                                        <input type="text" name="message" id="message" class="message" required placeholder="Type your message here..." autocomplete="nope-123456789">
                                        <input type="hidden" name="recipient" value="<?php echo $name; ?>">
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

        </div>

    </section>
</body>

</html>