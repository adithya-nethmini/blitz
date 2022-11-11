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
	<nav>
        <input type="checkbox" id="check">
        <label for="check" class="check-bar">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </label>
        <label><a class="a-logo"href="../home/home.php"><img src="../images/Blitz - Logo - white.png" class="logo"></a>
        </label>
        <ul>
            <li><a class="active" href="home.php"></i>Home</a></li>    
            <li><a href="About.php">About</a></li>    
            <li><a href="help.php">Help</a></li>    
            <li><a href=""><i class="fa fa-bell" aria-hidden="true"></i></a></li>    
            <li><a href="../employee/account.php"><i style="font-size:26px" class="fa fa-user" aria-hidden="true"></i></a></li>    
        </ul>
    </nav>
    <input type="checkbox" id="side-check">
    <label for="side-label">
        <i class="fa fa-bars" aria-hidden="true" id="side-bar"></i>
        <i class="fa fa-times" aria-hidden="true" id="side-cancel"></i>
    </label>
    <div class="sidebar">
        <ul>
            <li><a href="../task/task-manager.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Profile</a></li>
            <li><a href="../task/task-manager.php"><i class="fa fa-check-square" aria-hidden="true"></i> Offer Availability</a></li>
            <li><a href="../task/task-manager.php"><i class="fa fa-qrcode" aria-hidden="true"></i>QR Code</a></li>
            <li><a href="../task/task-manager.php"><i class="fa fa-tasks" aria-hidden="true"></i>Manage Task</a></li>
            <li><a href="../task/task-manager.php"><i class="fa fa-line-chart" aria-hidden="true"></i>Performance Result</a></li>
        </ul>
    </div>
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
