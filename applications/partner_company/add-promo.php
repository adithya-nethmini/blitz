
<?php

require "function.php";
if(isset($_POST['submit'])){
	$response = addpromo($_POST['type'],$_POST['name'],$_POST['date'],$_POST['description'] ,$_POST['promotion_cover']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/add-style.css">
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
	<title>Add promotions</title>
</head>
<body>

    <div class="main">
	<p style = "" class="error"><?php echo @$response; ?></p>
		<form action="" class="box" method="post" autocomplete="off">	
		<h1><i class="fa-regular fa-square-plus"></i> Add Promotion</h1>
				<div class="name">
                    <label><b>Promotion Name</b></label>
					<input type="text" name="name" id="name" value="<?php echo @$_POST['name']; ?>">
				</div>

				<div class="type">
                    <label><b>Promotion Type</b></label>
					<input type="text" name="type" id="type" value="<?php echo @$_POST['type']; ?>">
				</div>

				<div class="Date">
                    <label><b>Valid until</b></label>
					<input type="date" name="date" id="date" value="<?php echo @$_POST['date']; ?>">
				</div>
			
                <div class="description">
                    <label><b>Description</b></label>
					<input type="text" name="description" id="description" value="<?php echo @$_POST['description']; ?>">
				</div>
				<div class="promotion_cover">
  					<label><b>Upload the product photo</b></label>
					<input type="file" name="promotion_cover" value="<?php echo @$_POST['promotion_cover']; ?>">
					</div>
            <div class="inline-block">
            
                <button id="btn1" type="submit" name="submit">Save</button>
                <button id="btn2" type="submit" name="cancel">Cancel</button>
            
        	</div>

		</form>
	</div>
</body>
</html>