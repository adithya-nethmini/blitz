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
                <div class="main-chat-container-inner">
                    <a class="member-a" href="group-chat.php">
                        <div class="main-chat-member">
                            <h3><i class="fa-sharp fa-solid fa-users"></i>&nbsp;&nbsp;Group&nbsp;Chat</h3>
                        </div>
                    </a>
                    <a class="member-a" href="direct-chat.php">
                        <div class="main-chat-member">
                            <h3><i class="fa-sharp fa-solid fa-user"></i>&nbsp;&nbsp;Direct&nbsp;Messages</h3>
                        </div>
                    </a>
                </div>

                </div>
            </div>

        </div>

        </div>

    </section>
</body>

</html>