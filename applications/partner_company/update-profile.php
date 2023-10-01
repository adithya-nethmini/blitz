<?php 

require 'function.php';
$mysqli=connect();

// Form click or submit
if( isset($_POST['submit']) ) {
		// Fetch input $_POST
		$companyname = $mysqli->real_escape_string( $_POST['companyname'] );
		$companyemail = $mysqli->real_escape_string( $_POST['companyemail'] );
		$pcompanycon= $mysqli->real_escape_string( $_POST['pcompanycon'] );
		$companyaddress = $mysqli->real_escape_string( $_POST['companyaddress'] );
        $description = $mysqli->real_escape_string( $_POST['description'] );

		// Prepared statement
		$stmt = $mysqli->prepare("UPDATE `partner_company` SET `companyname`=?, `companyemail`=?, `pcompanycon`=?, `companyaddress`=?, `description`=? WHERE `username`=?");

		// Bind params
		$stmt->bind_param( "ssssss", $companyname, $companyemail, $pcompanycon, $companyaddress, $description, $_SESSION['pcompany_user']);

		// Execute query
		if( $stmt->execute() ) {
			/* $alert_message = "Task has been updated."; */
			header('location: partner-profile.php');
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
                                                    `companyname`, 
                                                    `companyemail`, 
                                                    `pcompanycon`, 
                                                    `companyaddress`,
                                                    `description` FROM `partner_company` WHERE `username` = ?");					
                    $stmt->bind_param("s", $_SESSION['pcompany_user']); 
					$stmt->execute();
					$stmt->store_result();
						if( $stmt->num_rows == 1 ) {
							$stmt->bind_result($companyname, $companyemail, $pcompanycon, $companyaddress, $description);
							$stmt->fetch();
						?>
						<div class="update-content">
						<div class="back">
						<a href="profile.php"><button class="btn-profile">Profile</button></a>
                        <?php
                                    echo $companyname;
                                ?>
						</div>
							<form action="" method="post">
								
                            <table>
                                <tr>
                                    <td class="update-input">Full Name<br><input required type="text" name="companyname" value="<?=$companyname?>"></td>
                                </tr>
                                <tr>
                                    <td class="update-input">Email<br><input required type="email" name="companyemail" value="<?=$companyemail?>"></td>
                                </tr>
                                <tr>
                                    <td class="update-input">Contact Number<br><input required type="text" name="pcompanycon" value="<?=$pcompanycon?>"></td>
                                </tr>
                                <tr>
                                    <td class="update-input">Location<br><input required type="text" name="companyaddress" value="<?=$companyaddress?>"></td>
                                </tr>
                                <tr>
                                    <td class="update-input">About<input required type="text" name="description" value="<?=$description?>"></td>
                                </tr>
                            </table>

								<div style="display: flex;justify-content:right;align-items:center">
									<button type="submit" name="submit" class="btn-update">UPDATE</button>
								</div>
								
								<?php } else {
									echo "<p class='error' style='padding: 20px 0 20px 0;'>Invalid Company</p>";
								} 	
								?>
					</form>
					

				</div>	
		</div>
	</body>
</html>