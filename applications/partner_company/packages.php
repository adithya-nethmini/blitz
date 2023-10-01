<?php

   require "function.php";
   $mysqli = connect();
   ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
    <title>Blitz</title>
</head>
<body class="pkg">
    <div class="logo">
		<img src="images/logo-blue.png" alt="logo">
	</div>
    <div class="packages">
        <div class="pkgbox">
            <h3>Basic</h3>
            <ul>
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;15 advertisements per week</li>
                <!-- <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;valid for 3 months</li> -->
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;5 Loyality offers</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;5-10% off from the original amount</li>
            </ul>
            <br><br>
        </div>
        <div class="pkgbox">
            <h3>Premium</h3>
            <ul>
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;30 advertisements per week</li>
                <!-- <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;valid for 3 months</li> -->
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;10 Loyality offers</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;10-15% off from the original amount</li>
            </ul>
            <br><br>
        </div>
        <div class="pkgbox">
            <h3>Premium Plus</h3>
            <ul>
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;45 advertisements per week</li>
                <!-- <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;valid for 6 months</li> -->
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;15 Loyality offers</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;15-20% off from the original amount</li>
            </ul>
            <br><br>
        </div>
        <div class="pkgbox">
            <h3>Custom</h3>
            <ul>
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Customized amount of advertisements</li>
                <!-- <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;For a customized time period</li> -->
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Customized number of offers</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Custermized amount of off fromthe original amount</li>
            </ul>
        </div>
</div>
</body>
</html>