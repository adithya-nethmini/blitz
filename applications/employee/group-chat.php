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
            <div class="chat-container">

                <div class="member-chat">

                    

                    <div class="member-section" onscroll="saveScrollPosition('scroll2', this)">
                        <!-- <div class="div-back-arrow">
                            <a class="back-arrow" href="javascript:history.back()"><i class='fa fa-long-arrow-left'></i>&nbsp;&nbsp;Back</a>
                        </div> -->
                        <div class="main-chat-container-inner">

                    <a class="member-a" href="direct-chat.php">
                        <div class="main-chat-member" style="background-color: #ffffff;">
                            <h3><i class="fa-sharp fa-solid fa-user"></i>&nbsp;&nbsp;Direct&nbsp;Messages</h3>
                        </div>
                    </a>
                    <a class="member-a" href="group-chat.php">
                        <div class="main-chat-member">
                            <h3><i class="fa-sharp fa-solid fa-users"></i>&nbsp;&nbsp;Group&nbsp;Chat</h3>
                        </div>
                    </a>
                    <?php
                            $mysqli = connect();
                            $stmt = $mysqli->prepare("SELECT manager_id FROM project_list WHERE manager_id = '$user'");
                            $stmt->execute();
                            $stmt->store_result();
                            if ($stmt->num_rows > 0) {
                                $stmt->bind_result($manager);
                                while ($stmt->fetch()) {?>
                            <a class="member-a" href="dept_head-chat.php">
                                <div class="main-chat-member" style="background-color: #D9D9D9;">
                                    <h3><i class="fa-sharp fa-solid fa-users"></i>&nbsp;Dept&nbsp;Head Chat</h3>
                                </div>
                            </a>
                                <?php }
                            }
                            ?>

                </div>
                        <div class="member-section-inner">

                            <?php
                            $user = $_SESSION['user'];

                            try {
                                // Establish database connection using PDO
                                $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE, USERNAME, PASSWORD);

                                // Prepare SELECT statement
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

                                        <a class="member-a" href="open-depat_head-chat.php?id=<?php echo $row['id']; ?>">
                                            <div class="member" style="width: 275px;">
                                                <?php echo $row['name']; 
                                                if ($count > 0) : ?>
                                                <div class="div-badge">
                                                    <i class='fa-solid fa-message' style="font-size: 30px; color: white"></i><span class="span-badge"><?php echo $count ?></span>
                                                </div>

                                                    <?php endif; ?>
                                                    
                                                
                                            </div>
                                        </a>
                            <?php
                                    }}
                                }else {
                                    // Display message when there are no projects assigned
                                    echo "No projects assigned.";
                                }
                            } catch (PDOException $e) {
                                echo "Database connection failed: " . $e->getMessage();
                                exit;
                            }
                            ?>
                        </div>
                        
                    </div><div class="vertical-line"></div>
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

</html>