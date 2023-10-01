<?php 

require 'function.php';
$mysqli=connect();
$id = $_GET['id'];

// Form click or submit
if( isset($_POST['submit']) ) {
		// Fetch input $_POST
		$name = $mysqli->real_escape_string( $_POST['name'] );
		$type = $mysqli->real_escape_string( $_POST['type'] );
		$end_date= $mysqli->real_escape_string( $_POST['end_date'] );
		$amount = $mysqli->real_escape_string( $_POST['amount'] );
        $offer_code = $mysqli->real_escape_string( $_POST['offer_code'] );

		// Prepared statement
		$stmt = $mysqli->prepare("UPDATE `offers` SET `name`=?, `type`=?, `end_date`=?, `amount`=?, `offer_code`=? WHERE `username`=? AND id = '$id'");

		// Bind params
		$stmt->bind_param( "ssssis", $name, $type, $end_date, $amount, $offer_code, $_SESSION['pcompany_user']);

		// Execute query
		if( $stmt->execute() ) {
			/* $alert_message = "Task has been updated."; */
			header('location: company-feed.php');
		} else {
			$alert_message = "There was an error in saving the details. Please try again.";
		}

		// Close prepare statement
		$stmt->close();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="../../views/css/styles.css">
</head>
<body class="body-update">
		<div class="update-container">
			<div class="update-heading"> 
				<div>
					<h2><a href="update-profile.php">Update Offer</a><h2>
				</div>
				
			</div>
					<?php 
					if( isset( $alert_message ) AND !empty( $alert_message )) {
						echo "<div class='alert alert-success'>".$alert_message."</div>";
					}
					?>

					<?php 
                    $mysqli=connect();
					// Get employee details
					$stmt = $mysqli->prepare("SELECT 
                                                    `name`, 
                                                    `type`, 
                                                    `end_date`, 
                                                    `amount`,
                                                    `offer_code` FROM `offers` WHERE `username` = ? ");					
                    $stmt->bind_param("s", $_SESSION['pcompany_user']); 
					$stmt->execute();
					$stmt->store_result();
						if( $stmt->num_rows > 0) {
							$stmt->bind_result($name, $type, $end_date, $amount, $offer_code);
							$stmt->fetch();
						?>
						<div class="update-content">
						<div class="back">
						<a href="company-feed.php"><button class="btn-profile">Published Offers</button></a>
                        
						</div>
							<form action="" method="post">
								
                            <table>
                                <tr>
                                    <td class="update-input">Offer name<br><input required type="text" name="name" value="<?=$name?>"></td>
                                </tr>
                                <tr>
                                    <td class="update-input">Email<br>
										<select name="type" id="type" value="<?php echo @$_POST['type']; ?>">
											<option value="">Select an option</option>
											<option value="platinum">Platinum Offer</option>
											<option value="gold">Gold Offer</option>
											<option value="silver">Silver Offer</option>
										</select>
									</td>
                                </tr>
                                <tr>
                                    <td class="update-input">Offer expiry date<br><input required type="date" name="end_date" value="<?=$end_date?>"></td>
                                </tr>
                                <tr>
                                    <td class="update-input">Offer amout<br><input required type="number" name="amount" value="<?=$amount?>"></td>
                                </tr>
                                <tr>
                                    <td class="update-input">Offer code<input required type="number" name="offer_code" value="<?=$offer_code?>"></td>
                                </tr>
                            </table>

								<div style="display: flex;justify-content:right;align-items:center">
									<button type="submit" name="submit" class="btn-update">UPDATE</button>
								</div>
								
								<?php } else {
									echo "<p class='error' style='padding: 20px 0 20px 0;'> Error: " . $mysqli->error . "</p>";
								} 	
								?>
					</form>
					

				</div>	
		</div>
	</body>
</html>