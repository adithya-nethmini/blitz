<?php 

require 'functions.php';
$mysqli=connect();

// Form click or submit
if( isset($_POST['submit']) ) {
		// Fetch input $_POST
		$name = $mysqli->real_escape_string( $_POST['name'] );
		$email = $mysqli->real_escape_string( $_POST['email'] );
		$contactno = $mysqli->real_escape_string( $_POST['contactno'] );
		$address = $mysqli->real_escape_string( $_POST['address'] );

		// Prepared statement
		$stmt = $mysqli->prepare("UPDATE `employee` SET `name`=?, `email`=?, `contactno`=?, `address`=? WHERE `username`=?");

		// Bind params
		$stmt->bind_param( "sssss", $name, $email, $contactno, $address, $_SESSION['user']);

		// Execute query
		if( $stmt->execute() ) {
			/* $alert_message = "Task has been updated."; */
			header('location: profile.php');
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
					<h2><a href="update-profile.php">Update Employee</a><h2>
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
                                                    `email`, 
                                                    `contactno`, 
                                                    `address` FROM `employee` WHERE `username` = ?");					
                    $stmt->bind_param("s", $_SESSION['user']); 
					$stmt->execute();
					$stmt->store_result();
						if( $stmt->num_rows == 1 ) {
							$stmt->bind_result($name, $email, $contactno, $address);
							$stmt->fetch();
						?>
						<div class="update-content">
						<div class="back">
						<a href="profile.php"><button class="btn-profile">Profile</button></a>
						</div>
							<form action="" method="post">
								
								<table>
									<tr>
										<!-- <td class="update-label"></td> -->
										<td class="update-input">Full Name<br><input required type="text" name="name" value="<?=$name?>"></td>
									</tr>
                                    <tr>
										<!-- <td class="update-label"></td> -->
										<td class="update-input">Email<br><input required type="email" name="email" value="<?=$email?>"></td>
									</tr>
                                    <tr>
										<!-- <td class="update-label"></td> -->
										<td class="update-input">Contact Number<br><input required type="text" name="contactno" value="<?=$contactno?>"></td>
									</tr>
                                    <tr>
										<!-- <td class="update-label"></td> -->
										<td class="update-input">Location<br><input required type="text" name="address" value="<?=$address?>"></td>
									</tr>
                                    <!-- <tr>
										<td class="update-label">Username:</td>
										<td class="update-input"><input required type="text" name="username" value="<? /* =$username */ ?>"></td>
									</tr> -->
								</table>

								<div style="display: flex;justify-content:right;align-items:center">
									<button type="submit" name="submit" class="btn-update">UPDATE</button>
								</div>
								
								<?php } else {
									echo "<p class='error' style='padding: 20px 0 20px 0;'>Invalid Employee</p>";
								} 	
								?>
					</form>
					

				</div>	
		</div>
	</body>
</html>