<?php
// if (!isset($mysqli)) {
//     include 'functions.php';
// }
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
?>

<html>

<head>
    <link rel="stylesheet" href="../../views/css/chat.css">
    <link rel="stylesheet" href="../../views/css/notification.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-L6U8bFP+JQ6U2PzXkypJZ8d+UKErfxUx1v4D4g3q72xtlFRA0sHnTD/d9S2oTfEKnT1Tn+Rv75VwIdt8DnsJzA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <section>

        <div class="page-content">
            <div class="chat-container" style="margin-top:150px">

                <div class="member-chat">

                    <div class="member-section" onscroll="saveScrollPosition('scroll2', this)">
                        <div class="main-chat-container-inner">


                            <a class="member-a" href="project_manager-chat.php">
                                <div class="main-chat-member" style="background-color: #D9D9D9;">
                                    <h3><i class="fa-sharp fa-solid fa-user"></i>&nbsp;Project&nbsp;Manager Chat</h3>
                                </div>
                            </a>

                        </div>
                        <div class="member-section-inner">

                            <?php
                            $user = $_SESSION['dept_user'];
                            $stmt = $mysqli->prepare("SELECT department FROM dept_head WHERE employeeid = '$user'");
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows > 0) {
                                $stmt->bind_result($department);
                                while ($stmt->fetch()) {

                                    // Prepare SELECT statement
                                    $sql = "SELECT manager_id FROM project_list WHERE dept_name = ?";
                                    $stmt2 = mysqli_prepare($mysqli, $sql);
                                    mysqli_stmt_bind_param($stmt2, "s", $department);

                                    // Execute SELECT statement
                                    mysqli_stmt_execute($stmt2);
                                    $result = mysqli_stmt_get_result($stmt2);

                                    // Loop through results and display name and email
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $member = strtolower($row['manager_id']);
                                        // $sql2 = "SELECT COUNT(*),sender FROM chat WHERE status = 'unseen' AND recipient = ? AND sender = ?";
                                        // $stmt = mysqli_prepare($mysqli, $sql2);
                                        $stmt3 = $mysqli->prepare("SELECT COUNT(*),sender FROM chat WHERE status = 'unseen' AND recipient = ? AND sender = ?");
                                        mysqli_stmt_bind_param($stmt3, "ss", $user, $member);

                                        // Execute SELECT statement
                                        mysqli_stmt_execute($stmt3);
                                        $result2 = mysqli_stmt_get_result($stmt3);

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
                        <div class="chat-area-inner">
                            <h4>Your messages will display here</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>

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

</html>