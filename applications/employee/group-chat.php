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

                    <div class="member-section">
                        <div class="div-back-arrow">
                            <a class="back-arrow" href="javascript:history.back()"><i class='fa fa-long-arrow-left'></i>&nbsp;&nbsp;Back</a>
                        </div>
                        <?php
                        $user = $_SESSION['user'];

                        try {
                            // Establish database connection using PDO
                            $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE, USERNAME, PASSWORD);

                            // Prepare SELECT statement
                            $stmt = $pdo->prepare("SELECT * FROM project_list WHERE FIND_IN_SET('$user', user_ids) > 0 ");

                            // Execute SELECT statement
                            $stmt->execute();

                            // Fetch results as associative array
                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Loop through results and display name and email
                            foreach ($results as $row) { ?>
                                <a class="member-a" href="open-group-chat.php?id=<?php echo $row['id']; ?>">
                                    <div class="member">
                                        <?php echo $row['name'] ?>
                                    </div>
                                </a>
                        <?php
                            }
                        } catch (PDOException $e) {
                            echo "Database connection failed: " . $e->getMessage();
                            exit;
                        }
                        ?>


                    </div>
                    <div class="chat-area">
                        <h4>Your messages will display here</h4>
                    </div>
                </div>
            </div>

        </div>

        </div>

    </section>
</body>

</html>