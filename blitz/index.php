<?php

  include "applications/function/function.php";

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
    <title>Blitz</title>
    <link rel="stylesheet" href="views/css/styles.css">
  </head>
<body>

  <header class="header-landing">
    <nav class="top-nav-landing">
        <a href="#"><img class="blitz-logo"src="views/images/Blitz - Logo.png" alt=""></a>
        <ul class="ul-top-nav-landing">
            <li><a href="#" class="top-nav-link">Home</a></li>
            <li><a href="#" class="top-nav-link">About</a></li>
            <li><a href="#" class="top-nav-link">Help</a></li>
            <?php 

              if (isset($_SESSION['user'])) {

                echo "<li>
                        <a href='applications/employee/profile.php' class='top-nav-link'>Profile</a>
                      </li>
                      <li>
                        <a href='index.php?logout='1' class='top-nav-link'>Logout</a>
                      </li>";
              } else {
                echo "<li>
                        <a href='applications/employee/login.php' class='top-nav-link'>Login</a>
                      </li>
                      <li>
                        <a href='applications/employee/signup.php' class='top-nav-link'>Register</a>
                      </li>";
              }
            
            ?>
        </ul>
        <div class="menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        
    </nav>
    <div class="header-space"></div>
    
    <span class="landing-header-p">
      We appreciate you for more than just your work. We also want to celebrate your character and the positive effect you have on others.Warmly welcome to the rewarding space for your contribution towards us!
    </span>
    
</header>
<?php if (isset($_SESSION['user'])) : ?>
  
<section id="section-landing-1">
  <h2>Loyalty Users of the Month</h2>
  <h2>Daily Offers</h2>
  <h2>Promotions</h2>
</section>
<?php else: ?>
<section id="section-landing-1">
  <button class="btn-get-started"><a href="applications/g_signup.php">Get Started</a></button>
</section>
<?php endif ?>
<section id="section-landing-2">

</section>

</body>

<script src="views/js/main.js"></script>
