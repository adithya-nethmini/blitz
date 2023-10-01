<?php

include "applications/function/function.php";
include 'header.php';

$mysqli = connect();
$user = $_SESSION['user'];


if (isset($_POST['update'])) {
  // Fetch input $_POST
  $password = $mysqli->real_escape_string($_POST['password']);
  $conpassword = $mysqli->real_escape_string($_POST['confirm_password']);
  // $profilepic_e = $mysqli->real_escape_string($_POST['profilepic_e']);

  if (strlen($password) > 50) {
    return "Password is too long";
  }

  if ($password != $conpassword) {
    return "Passwords don't match";
  }

  $number = preg_match('@[0-9]@', $password);
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $specialChars = preg_match('@[^\w]@', $password);

  if (strlen($password) < 8) {
    return "Password must be at least 8 characters in length.";
  }
  if (strlen($password) < !$number) {
    return "Password must contain at least one number.";
  }
  if (strlen($password) < !$uppercase) {
    return "Password must contain at least one upper case letter.";
  }
  if (strlen($password) < !$lowercase) {
    return "Password must contain at least one lower case letter.";
  }
  if (strlen($password) < !$specialChars) {
    return "Password must contain at least one special character.";
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);


  // Prepared statement
  $stmt = $mysqli->prepare("UPDATE `login` SET `password`=?, logs = '1' WHERE `username`='$user'");

  // Bind params
  mysqli_free_result($result);
  if (!$stmt) {
    echo ("Failed to prepare statement: " . $mysqli->error);
  }

  // Bind the parameter to the statement and execute the update
  $stmt->bind_param("s", $hashed_password);
  if (!$stmt->execute()) {
    echo ("Failed to execute statement: " . $stmt->error);
  }

  mysqli_stmt_close($stmt);
  $mysqli->close();
}

if (isset($error)) {
  echo $error;
}


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
  $mysqli = connect();
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

    <h2>Best Performers of the Month</h2>
    <!-- ?php if (isset($_SESSION['user'])) : ? -->
    <div style="display:flex;flex-direction:row;justify-content:center;align-items:center">
      <?php

      $stmt = $mysqli->prepare("SELECT name,profilepic_e FROM employee WHERE loyalty_eligibility = 'YES'");
      $stmt->execute();
      $stmt->store_result();
      if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $profilepic_e);
        while ($stmt->fetch()) {
      ?>
          <div style="padding:20px"><img class="profile-pic" src="data:image/png;charset=utf8;base64,<?php echo base64_encode($profilepic_e); ?>" alt="Profile Picture" title="Update Profile Picture">
            <h4><?= $name ?></h4>
          </div>


      <?php
        }
      }
      ?>
    </div>
    <!-- ?php endif ? -->

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
    <h2>Published Promotions</h2>
    <div class="flex grid-container">
      <?php
      $sql = "SELECT partner_company.companyname, partner_company.pcompany_pic, promotions.type, promotions.name, promotions.end_date, promotions.description, promotions.promotion_cover 
      FROM promotions 
      JOIN partner_company ON promotions.username = partner_company.username";
      $result = mysqli_query($mysqli, $sql);

      if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
          $type = $row['type'];
          $name = $row['name'];
          $end_date = $row['end_date'];
          $description = $row['description'];
          $promotion_cover = $row['promotion_cover'];
          $companyname = $row['companyname'];
          $pcompany_pic = $row['pcompany_pic'];

          echo '
          <div style="padding: 20px;">
            <div class="promo">
              <div class="image-container"> 
                <img src="applications/partner_company/' . $promotion_cover . '" alt="cover photo">
              </div>
              <ul>
                <li><b>' . $name . '</b></li>
                <li style="font-size:8px"><a href="applications/partner_company/partner-page.php">by <b>' . $companyname . '</b></a></li>
                <li>Valid until: ' . $end_date . '</li>
                <li>' . $description . '</li>
              </ul>
            </div>
          </div>';
        }
      }
      ?>
    </div>
  </div>


</body>

<script src="views/js/main.js"></script>

</html>
