<?php 

    require "../function/function.php";
    
    if(!isset($_SESSION["user"])){
        header("location: login.php");

        exit();
    }

    if(isset($_GET['logout'])){
		logoutUser();
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
</head>
<body>
    <div class="page">

        <nav>
            <div>
            <p>
                <a href="../task/task-manager.php">Manage Task</a>
            </p>
            </div>
        </nav>
        <h2>Welcome <?php echo $_SESSION['user'] ?></h2>
        
        <p>
        Lorem Ipsum is probably the most popular dummy text generator out there. 
        When analyzing a website template or theme, you probably saw the Latin filler text that gave structure to the page. 
        This was almost certainly generated with Lorem Ipsum or a similar tool. 
        It is a simple dummy text generator where you can specify how many words of filler text you need. You can download Lorem Ipsum as an add-on for Firefox, 
        which is quite convenient for web designers.
        </p>

        <a href="?logout">Logout</a>

        <br>

    </div>
</body>
</html>