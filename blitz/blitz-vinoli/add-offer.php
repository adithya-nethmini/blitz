
<?php

require "function.php";
if(isset($_POST['submit'])){
	$response = addoffer($_POST['offer_cover'],$_POST['type'],$_POST['name'],$_POST['date'] ,$_POST['amount']);
}

?>




<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="add-style.css">
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
            <input type="date" id="date" name="date" value="<?php echo @$_POST['date']; ?>">
        </div>
        <div class="type">
            <label><b>Offer Type</b></label>
            <select name="type" id="type" value="<?php echo @$_POST['type']; ?>">
                <option value="Loyalty">Loyalty Offer</option>
                <option value="Daily">Daily Offer</option>
            </select>
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