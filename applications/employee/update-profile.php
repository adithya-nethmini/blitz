<?php

require '../function/function.php';
$mysqli = connect();

// Form click or submit
if (isset($_POST['submit'])) {
	// Fetch input $_POST
	$name = $mysqli->real_escape_string($_POST['name']);
	$email = $mysqli->real_escape_string($_POST['email']);
	$contactno = $mysqli->real_escape_string($_POST['contactno']);
	$address = $mysqli->real_escape_string($_POST['address']);
	$profilepic_e = $mysqli->real_escape_string($_POST['profilepic_e']);

	// Fetch input $_FILES
	$profilepic_e = $_FILES['profilepic_e']['tmp_name'];

	if (!empty($profilepic_e)) {
		$profilepic_e = file_get_contents($profilepic_e);
	}

	// Prepared statement
	$stmt = $mysqli->prepare("UPDATE `employee` SET `name`=?, `email`=?, `contactno`=?, `address`=?, `profilepic_e`=? WHERE `username`=?");

	// Bind params
	$stmt->bind_param("ssssbs", $name, $email, $contactno, $address, $_SESSION['user'], $profilepic_e);

	// Execute query
	if ($stmt->execute()) {
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
				<h2><a href="update-profile.php">Update Employee</a></h2>
			</div>

		</div>
		<?php
		if (isset($alert_message) and !empty($alert_message)) {
			echo "<div class='alert alert-success'>" . $alert_message . "</div>";
		}
		?>

		<?php
		$mysqli = connect();
		// Get employee details
		$stmt = $mysqli->prepare("SELECT 
										`name`, 
										`email`, 
										`contactno`, 
										`address`,
										`profilepic_e` FROM `employee` WHERE `username` = ?");
		$stmt->bind_param("s", $_SESSION['user']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows == 1) {
			$stmt->bind_result($name, $email, $contactno, $address, $profilepic_e);
			$stmt->fetch();
		?>
			<div class="update-content">
				<div class="back">
					<a href="profile.php"><button class="btn-profile">Profile</button></a>
				</div>
				<form action="" method="post" enctype="multipart/form-data">

					<table>
						<tr>
							<!-- <td class="update-label"></td> -->
							<td class="update-input">Full Name<br><input required type="text" name="name" value="<?= $name ?>"></td>
						</tr>
						<tr>
							<!-- <td class="update-label"></td> -->
							<td class="update-input">Email<br><input required type="email" name="email" value="<?= $email ?>"></td>
						</tr>
						<tr>
							<!-- <td class="update-label"></td> -->
							<td class="update-input">Contact Number<br><input required type="text" name="contactno" value="<?= $contactno ?>"></td>
						</tr>
						<tr>
							<!-- <td class="update-label"></td> -->
							<td class="update-input">Location<br><input required type="text" name="address" value="<?= $address ?>"></td>
						</tr>
						<tr>
							<!-- <td class="update-label">Profile Picture:</td> -->
							<td class="update-input">Profile Picture</br><img src="data:image/jpeg;base64,<?php echo base64_encode($profilepic_e); ?>" alt="Profile Picture">
								<input type="file" id="profilepic_e" name="profilepic_e"><br>
						</tr>
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