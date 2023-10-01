

<?php
include '../function/partner_companyf/add-offer-f.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
    session_destroy();
    header("location: ../../index.php");
    exit();
}
$mysqli = connect();
$user = $_SESSION['pcompany_user'];

if (isset($_POST['submit'])) {
    
    // Get the offer limit based on the package
    $packageLimit = fetchPackageLimits($user);
    $offerCount = fetchOfferCount($user);
    
    // Determine the offer limit based on the package
    if ($packageLimit == 'basic') {
        $limit = 5;
    } elseif ($packageLimit == 'premium') {
        $limit = 10;
    } else {
        $limit = 15;
    }
    
    // Check if the offer count exceeds the limit
    if ($offerCount >= $limit) {
        echo '<script>alert("You have reached the maximum limit of offers.");</script>';
    } else {
        $response = addoffer($_POST['offer_cover'], $_POST['type'], $_POST['name'], $_POST['end_date'], $_POST['amount'], $_SESSION['pcompany_user'], $_POST['offer_code']);
    }
}
?>




<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/add-style.css">
      <title>Add offers</title>
  </head>
  <body>

    <div class="main">
      <form action ="" method="post" class="box">
      <p style = "" class="error"><?php echo @$response; ?></p>
      <h1>Add Offer</h1>
      
        <div class="name">
            <label><b>Offer Name</b></label>
            <input type="text" id="name" name="name" value="<?php echo @$_POST['name']; ?>">
        </div>
        <div class="date">
            <label><b>Valid until</b></label>
            <input type="date" id="end_date" name="end_date" value="<?php echo @$_POST['end_date']; ?>">
        </div>
        <div class="type">
            <label><b>Offer Type</b></label>
            <select name="type" id="type" value="<?php echo @$_POST['type']; ?>">
                <option value="">Select an option</option>
                <option value="platinum">Platinum Offer</option>
                <option value="gold">Gold Offer</option>
                <option value="silver">Silver Offer</option>
            </select>

        </div>
        <div class="offer">
            <label><b>Promo Code</b></label>
            <input type="text" id="offer_code" name="offer_code" value="<?php echo @$_POST['offer_code']; ?>">
        </div>
        <div class="amount">
            <label><b>Offer Amount</b></label>
            <input type="number" id="amount" name="amount" value="<?php echo @$_POST['amount']; ?>">
        </div>
        <div class="cover">
            <label><b>Upload the product photo</b></label>
            <input type="file" name="offer_cover" value="<?php echo @$_POST['offer_cover']; ?>">
        </div>
          <button type="submit" class="btn1" name="submit">Save</button>
          <button type="cancel" class="btn2" name="cancel">Cancel</button>
      </form>

    </div>
  </body>



</html>