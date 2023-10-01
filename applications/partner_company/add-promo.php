<?php
include '../function/partner_companyf/add-promo-f.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Rest of your PHP code goes here
// ...

session_start();

if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
    session_destroy();
    header("location: ../../landingpage.php");
    exit();
}

$mysqli = connect();
$user = @$_SESSION['pcompany_user'];
if (isset($_POST['submit'])) {
    $response = addpromo($_POST['type'], $_POST['name'], $_POST['end_date'], $_POST['description'], $_POST['promotion_cover'], $_SESSION['pcompany_user']);
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
  <?php
  $industry = @$company['industry'];
echo $industry;
?>

    <div class="main">
      <form action ="" method="post" class="box">
      <p style = "" class="error"><?php echo @$response; ?></p>
      <h1>Add Promotion</h1>
      
        <div class="name">
            <label><b>Promotion heading</b></label>
            <input type="text" id="name" name="name" value="<?php echo @$_POST['name']; ?>">
        </div>
        <div class="date">
            <label><b>Valid until</b></label>
            <input type="date" id="end_date" name="end_date" value="<?php echo @$_POST['end_date']; ?>">
			<script type="text/javascript">
				end_date = document.getElementById('end_date');
				end_date.min = new Date().toISOString().split("T")[0];
		    </script>
        </div>
        <div class="type">
		<label><b>Product type</b></label>
			<select name="type" id="type">
				<option value="">Select an option</option>
				<?php
				$industry = $_SESSION['industry'];
				$promotionTypes = [
					"super-market" => ["Fresh produce", "Dairy products", "Bakery items", "Beverages"],
					"textile" => ["Women's clothing", "Men's clothing", "Children's clothing", "Footwear"],
					"pharmacy" => ["Vitamins and supplements", "Skincare products", "First aid supplies", "Baby care items"]
				];

				if (isset($promotionTypes[$industry])) {
					foreach ($promotionTypes[$industry] as $type) {
						echo "<option value=\"$type\"";
						if (isset($_POST['type']) && $_POST['type'] == $type) {
							echo " selected";
						}
						echo ">$type</option>";
					}
				}
				?>
</select>

        </div>
        <div class="offer">
            <label><b>Description</b></label>
            <input type="text" id="description" name="description" value="<?php echo @$_POST['description']; ?>">
        </div>
        <div class="amount">
            <label><b>Promotion cover photo</b></label>
            <input type="file" id="promotion_cover" name="promotion_cover" value="<?php echo @$_POST['promotion_cover']; ?>">
        </div>
        
          <button type="submit" class="btn1" name="submit">Save</button>
          <button type="cancel" class="btn2" name="cancel">Cancel</button>
      </form>

    </div>
  </body>



</html>