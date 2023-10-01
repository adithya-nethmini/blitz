<?php 

    require("../function/partner_companyf/g_signup-f.php");
    if(isset($_POST['submit'])){
        $response = selectRadio(@$_POST['$signup_Option']);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</head>
<body class="body-g_signup">
    <header class="header-signup">
        <div class="wrapper-signup">
            <div class="div-logo">
                <img class="blitz-logo" src="images/logo-blue.png">
            </div>
            <div class="signup-container"> 
                <!-- container -->

                <div class="heading">
                    <h1>Signup As a,</h1>
                </div>

                <form action="" method="post">
                <div class="content">
                    <input type="radio" id="employee" name="signup-option" value="Employee">
                    <label for="employee">As an employee</label><br>
                    <input type="radio" id="company" name="signup-option" value="Company">
                    <label for="company">As a Partner Company</label>
                </div>
                <div class="div-g_signup-btn-go">
                    <button class="g_signup-btn-go" type= "submit" name="submit"><strong><i class='fa fa-arrow-right'></i> Go</strong></button>
                </div>
                </form>
            </div>
        </div>
    </header>
    

</body>
</html>