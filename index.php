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
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <style>
      ::placeholder{
        color: #ffffff94;
        font-size: 18px;
      }
    </style>
  </head>
<body>
<?php if (!isset($_SESSION['user'])) : ?>
  <header class="header-landing">
<?php else: ?>
  <header class="header-landing-logged">
    <?php endif ?>
    <nav class="top-nav-landing">
        <a href="#"><img class="blitz-logo"src="views/images/Blitz - Logo.png" alt=""></a>
        <ul class="ul-top-nav-landing">
            <li><a href="#" class="top-nav-link">Home</a>
            </li>
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
                        <a href='applications/g_signup.php' class='top-nav-link'>Register</a>
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
    <?php if (!isset($_SESSION['user'])) : ?>
      <div class="header-space"></div>
      
      <span class="landing-header-p">
        We appreciate you for more than just your work. We also want to celebrate your character and the positive effect you have on others.Warmly welcome to the rewarding space for your contribution towards us!
      </span>
    <?php endif ?>
    
</header>
<?php if (isset($_SESSION['user'])) : ?>

<section id="section-landing-1">
  <div style="padding: 40px 50px;">
    <div class="search-div">
      <a href=""><i class="fa fa-sliders" aria-hidden="true"></i></a>
      <input class="search-input" type="text" name="search" required placeholder="Search">
      <a href=""><i class='fa fa-search'></i></a>
    </div>
  </div>
</section>  

<section id="section-landing-2">
  <div class="div-loyalty">
    <h2>Loyalty Users of the Month</h2>
    <table>
      <tr>
        <td><i class='fa fa-user'></i></td>
        <td><i class='fa fa-user'></i></td>
        <td><i class='fa fa-user'></i></td>
        <td><i class='fa fa-user'></i></td>
        <td><i class='fa fa-user'></i></td>
      </tr>
      <tr>
        <td>Employee 1</td>
        <td>Employee 2</td>
        <td>Employee 3</td>
        <td>Employee 4</td>
        <td>Employee 5</td>
      </tr>
    </table>
  </div>
  <div class="div-offers">
    <h2>Daily Offers</h2>
    <table>
      <tr>
        <td><i class='fas fa-percentage'></i></td>
        <td><i class='fas fa-percentage'></i></td>
        <td><i class='fas fa-percentage'></i></td>
        <td><i class='fas fa-percentage'></i></td>
        <td><i class='fas fa-percentage'></i></td>
      </tr>
      <tr>
        <td>Offer 1</td>
        <td>Offer 2</td>
        <td>Offer 3</td>
        <td>Offer 4</td>
        <td>Offer 5</td>
      </tr>
    </table>
  </div>
  <div class="div-promotions">
    <h2>Promotions</h2>
    <table>
      <tr>
        <td><i class="fas fa-award"></i></td>
        <td><i class="fas fa-award"></i></td>
        <td><i class="fas fa-award"></i></td>
        <td><i class="fas fa-award"></i></td>
        <td><i class="fas fa-award"></i></td>
      </tr>
      <tr>
        <td>Promotion 1</td>
        <td>Promotion 2</td>
        <td>Promotion 3</td>
        <td>Promotion 4</td>
        <td>Promotion 5</td>
      </tr>
    </table>
  </div>
</section>

<?php else: ?>

<section id="section-landing-2">
  <button class="btn-get-started"><a href="applications/g_signup.php">Get Started</a></button>
</section>

<?php endif ?>



<footer>
  <div style="width: 100%; height:100px;background-color:#071D70"></div>
</footer>

</body>

<script src="views/js/main.js"></script>

</html>