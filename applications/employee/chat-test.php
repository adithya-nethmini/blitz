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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/bf10032598.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
            <?php 
                $recipient = mysqli_real_escape_string($conn, $_GET['username']);
                $sql = mysqli_query($conn,"SELECT * FROM employee WHERE username = '{$user}'");
                if(mysqli_num_rows($sql)>0){
                    $row = mysqli_fetch_assoc($sql);
                }
                
                
                ?>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo $row['img']; ?>" alt="">
                    <div class="details">
                        <span><?php echo $row['fname']." ".$row['lname']; ?></span>
                        <p><?php echo $row['status']; ?></p>
                    </div>
            </header>
            <div class="chat-box">
            
          
            </div>
            <form action="#" class="typing-area" autocomplete="off">
                <input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id']; ?>" hidden>
                <input type="text" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here...">
                <button><i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </section>
    </div>
    <script src="javascript/chat.js"></script>
</body>
</html>