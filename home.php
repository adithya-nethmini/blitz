<?php

include "applications/function/function.php";
include 'header.php';

$mysqli = connect();
$user = $_SESSION['user'];

// $stmt = $mysqli->prepare("SELECT logs FROM login WHERE employeeid = ?");
// $stmt->bind_param("s", $user);
// $stmt->execute();
// $stmt->store_result();
// if ($stmt->num_rows > 0) {
//   $stmt->bind_result($logs);
//   while ($stmt->fetch()) {
//     if($logs == 0){
?>

<?php
// }
// }
// }

// if(isset($_GET['logout'])){
//   unset($_SESSION['login']);
//   session_destroy();
//   /* $index = $_SERVER['REQUEST_URI']; */
//   header("location: landingpage.php");
//   exit();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blitz</title>
  <link rel="stylesheet" href="views/css/styles.css">
  <link rel="stylesheet" href="views/css/index.css">
  <link rel="stylesheet" href="views/css/home.css">

  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <style>
    ::placeholder {
      color: #ffffff94;
      font-size: 18px;
    }
  </style>
</head>

<body>

  <?php
  $user = $_SESSION['user'];
  $stmt = $mysqli->prepare("SELECT logs FROM login WHERE username = ?");
  $stmt->bind_param("s", $user);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    $stmt->bind_result($logs);
    while ($stmt->fetch()) {
      if ($logs == 0) {
  ?>
        <div id="update-username-modal" style="flex-direction:column;justify-content:center;align-items: center;">
          <div class="update-container">
            <div class="update-heading">
              <h3>Update Username & Password</h3>
              <div>
                <div class="update-content">
                  <form action="" method="POST">
                    <table>
                      <tr>
                        <!-- <td class="update-label"></td> -->
                        <td class="update-input"><span>Username</span><br><input type="text" name="username" placeholder="Enter your username"></td>
                      </tr>
                      <tr>
                        <!-- <td class="update-label"></td> -->
                        <td class="update-input"><span>Password</span><br><input type="password" name="password" placeholder="Enter your password"></td>
                      </tr>
                      <tr>
                        <!-- <td class="update-label"></td> -->
                        <td class="update-input"><span>Confirm Password</span><br><input type="password" name="confirm_password" placeholder="Confirm your password"></td>
                      </tr>

                    </table>

                    <div style="width:100%">
                      <button type="submit" name="update" class="btn-update">UPDATE</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
  <?php
      }
    }
  }
  ?>
<?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } elseif (isset($success)) { ?>
        <p><?php echo $success; ?></p>
    <?php } ?>
  <!-- ?php endif ? -->

  <div class="div-feedback">
    <a href="applications/employee/feedback_form.php"><button class="feedback-button" title="Submit your feedbacks">Feedback</button></a>
  </div>

  <section id="section-landing-2">

    <!-- ?php if (isset($_SESSION['user'])) : ? -->
    <div class="div-loyalty">
      <h2>Best Performers of the Month</h2>
      <table>
        <tr>
          <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/jessica.jpg" alt=""></td><a href="applications/partner_company/images/"></a>
          <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/emp2.png" alt=""></td>
          <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/emp3.png" alt=""></td>
          <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/emp4.png" alt=""></td>
          <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/emp6.jpg" alt=""></td>
        </tr>
        <tr class="rrr">
          <td>Anne Jessica Fernando</td>
          <td>Penelope Hartley F'do</td>
          <td>Tina Catalina Rose</td>
          <td>Francis Safwan Mcleod</td>
          <td>Todd Sebastian O'Brien</td>
        </tr>
      </table>
    </div>
    <!-- ?php endif ? -->

    </div>
  </section>
  <section id="section-landing-1">
    <div style="padding: 40px 50px;">
      <div class="search-div">
        <a href=""><i class="fa fa-sliders" aria-hidden="true"></i></a>
        <input class="search-input" type="text" name="search" required placeholder="Search">
        <a href=""><i class='fa fa-search'></i></a>
      </div>
    </div>
  </section>
  <br>


  <div class="promo-grid">
    <h2>Promotions</h2>
    <div class="flex grid-container">
      <?php

      $sql = "SELECT type,name, date, description, promotion_cover FROM promotions";
      $result = mysqli_query($con, $sql);

      if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
          $type = $row['type'];
          $name = $row['name'];
          $date = $row['date'];
          $description = $row['description'];
          $promotion_cover = $row['promotion_cover'];


          echo '<a href="applications/employee/partner-page.php"><div style="padding:20px">
    <div class="promo">
        <div class="image-container"> 
            <img src=applications/partner_company/' . $promotion_cover . ' alt="cover photo">
        </div>
            <ul>
                <li><b>' . $name . '</b></li>
                <li>Valid until:' . $date . '</li>
                <li>' . $type . '</li>
                <li>' . $description . '</li>
            </ul>

      </div>
      </div></a>';
        }
      }
      ?>
    </div>
    <!-- <a href="applications/partner_company/partner-feed.php"></a>
 -->


</body>

<script src="views/js/main.js"></script>

</html>



<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the form data
    if ($newPassword !== $confirmPassword) {
        $error = "Password and Confirm Password do not match.";
    } else {
        // Generate a verification token
        $verificationToken = generateVerificationToken();

        // Perform password reset
        $sql = "UPDATE login SET password = ?, verification_token = ?, logs = '1' WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $hashedPassword, $verificationToken, $username);

        if ($stmt->execute()) {
            // Send the verification email
            $to = $_POST['email'];
            $subject = "Password Reset Verification";
            $message = "Dear user, your password has been reset. Please click the following link to verify your email and complete the password reset process:\n\n";
            $message .= "Verification Link: verify.php" . $verificationToken;

            $headers = "From: blitz.emp.mgt.sys@gmail.com\r\n";
            $headers .= "Reply-To: $email.com\r\n";
            $headers .= "Content-type: text/plain\r\n";

            if (mail($to, $subject, $message, $headers)) {
                $success = "Password reset successfully. Please check your email for the verification link.";
            } else {
                $error = "Error sending verification email.";
            }
        } else {
            $error = "Error resetting password.";
        }
    }
}

// Function to generate a random verification token
function generateVerificationToken()
{
    $length = 32;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $verificationToken = $_GET['token'];

    // Check if the verification token exists in the database
    // Assuming you have a table called "users" with columns "username", "password", and "verification_token"
    $sql = "SELECT username login users WHERE verification_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $verificationToken);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Verification token is valid
        $stmt->bind_result($username);
        @$stmt->fetch();
        $stmt->close();

        // Update the user's account status or perform any other necessary operations
        // For example, you can set a flag to indicate that the user has successfully verified their email

        // Display a success message
        $success = "Email verification successful. You can now login with your new password.";
    } else {
        // Verification token is invalid or expired
        $error = "Invalid verification token.";
    }
} else {
    // No token provided
    $error = "Invalid request.";
}
?>