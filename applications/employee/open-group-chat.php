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
                                <a class="member-a" href="open-chat.php?id=<?php echo $row['id']; ?>">
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
                        <?php
                        $mysqli = connect();
                        $id = $_GET["id"];

                        $user = $_SESSION['user'];
                        $stmt = $mysqli->prepare("SELECT name,description,start_date FROM `project_list` WHERE `id` = ?");
                        $stmt->bind_param("i", $_GET['id']);
                        $stmt->execute();
                        $stmt->store_result();
                        if ($stmt->num_rows == 1) {
                            $stmt->bind_result($name, $description, $start_date);
                            $stmt->fetch();
                        ?>
                            <div>
                                <h3><?php echo $name ?></h3>
                                <?php echo $description; ?>
                            </div>

                            

                        <?php } else {
                            echo "<p class='error' style='padding: 20px 0 20px 0;'>Invalid Notification</p>";
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