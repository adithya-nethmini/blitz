<?php
// include '../function/function.php';
// $mysqli = connect();
// $user = $_SESSION['user'];
// $username = strtolower($_GET['username']);
// $stmt = $mysqli->prepare("SELECT email FROM `employee` WHERE `username` = ?");
// $stmt->bind_param("s", $username);
// $stmt->execute();
// $stmt->store_result();
// if ($stmt->num_rows == 1) {
//     $stmt->bind_result($email);
//     $stmt->fetch();
//     $response = $email;
// } else {
//     $response = 'User not found';
// }
// echo $response;
?>


<?php
include '../function/function.php';
$mysqli = connect();
$user = $_SESSION['user'];
$username = $_GET['username'];
// $stmt = $mysqli->prepare("SELECT message FROM `chat` WHERE `sender` = ?");
// $stmt->bind_param("s", $username);
// $stmt->execute();
// $stmt->store_result();
// if ($stmt->num_rows > 0) {
//     $stmt->bind_result($message);
//     while($stmt->fetch()){;
//     $response = $message;
//     }
// } else {
//     $response = 'User not found';
//     echo 'Error: ' . $mysqli->error;
// }
// echo $response;
?>


<?php

                        $user = $_SESSION['user'];
                        $stmt = $mysqli->prepare("SELECT name,username FROM `employee` WHERE `username` = ?");
                        $stmt->bind_param("s", $_GET['username']);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows == 1) {
                            $stmt->bind_result($name, $username);
                            $stmt->fetch();
                        ?>
                            <div class="chat-name-display">
                                <h3><?php echo $name; ?></h3>
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