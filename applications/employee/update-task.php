<?php 

require '../function/function.php';
$mysqli=connect();

// Form click or submit
if( isset($_POST['submit']) ) {
		// Fetch input $_POST
		$name = $mysqli->real_escape_string( $_POST['name'] );
		$description = $mysqli->real_escape_string( $_POST['description'] );
		$priority = $mysqli->real_escape_string( $_POST['priority'] );
		$deadline = $mysqli->real_escape_string( $_POST['deadline'] );
		@$status = $mysqli->real_escape_string( $_POST['status'] );

		// Prepared statement
		$stmt = $mysqli->prepare("UPDATE `task` SET `name`=?, `description`=?, `priority`=?, `deadline`=?, `status`=? WHERE `id`=? AND `username`=?");

		// Bind params
		$stmt->bind_param( "sssssi", $name, $description, $priority, $deadline, $status, $_GET['id']);

		// Execute query
		if( $stmt->execute() ) {
			/* $alert_message = "Task has been updated."; */
			header('location: task-manager.php');
		} else {
			$alert_message = "There was an error in saving the task. Please try again.";
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
		<div class="update-container" style="padding: 20px 50px;">
			<div class="update-heading" style="padding-bottom: 15px;"> 
				<div>
					<h2><a style="padding: 0 100px;" href="update-task.php">Update Task</a><h2>
				</div>
				
			</div>
					<?php 
					if( isset( $alert_message ) AND !empty( $alert_message )) {
						echo "<div class='alert alert-success'>".$alert_message."</div>";
					}
					?>

					<?php 
                    $mysqli=connect();
					// Get task details
					$stmt = $mysqli->prepare("SELECT `name`, `description`, `priority`, `deadline`, `status` FROM `task` WHERE `id` = ? AND `username` = ?");
					$stmt->bind_param("is", $_GET['id'], $_SESSION['user']);
					$stmt->execute();
					$stmt->store_result();
						if( $stmt->num_rows == 1 ) {
							$stmt->bind_result($name, $description, $priority, $deadline, $status);
							$stmt->fetch();
						?>
						<div class="update-content">
							<div class="back">
								<a href="task-manager.php"><button class="btn-task">Task Manager</button></a>
							</div>
							<form action="" method="post">
								<table>
									<tr>
										<!-- <td class="update-label">:</td> -->
										<td class="update-input">Task Name<br><input required class="form-control" type="text" name="name" value="<?=$name?>"></td>
									</tr>
									<tr>
										<!-- <td class="update-label">:</td> -->
										<td class="update-input">Description<br>
											<textarea name="description" maxlength="100" class="task-textarea" resize="none" rows="4" cols="63">
											<?=$description?>
											</textarea>
										</td>
									</tr>
									<tr>
										<!-- <td class="update-label">:</td> -->
										<td class="update-input">Priority<br>
											<select name="priority">
												<option <?php if($priority=="High"){echo "selected";} ?> value="High">High</option>
												<option <?php if($priority=="Medium"){echo "selected";} ?> value="Medium">Medium</option>
												<option <?php if($priority=="Low"){echo "selected";} ?> value="Low">Low</option>
											</select> 
										</td>
									</tr>
									<tr>
										<!-- <td class="update-label">:</td> -->
										<td class="update-input">Deadline<br><input required class="form-control" type="date" name="deadline" value="<?=$deadline?>"></td>
									</tr>
									<tr>
										<!-- <td class="update-label">:</td> -->
										<td class="update-input">Status<br>
											<select name="status">
												<option <?php if($priority=="To Do"){echo "selected";} ?> value="<To Do>">To Do</option>
												<option <?php if($priority=="Doing"){echo "selected";} ?> value="Doing">Doing</option>
												<option <?php if($priority=="Done"){echo "selected";} ?> value="Done">Done</option>
											</select> 
										</td>
									</tr>
								</table>
		
								<div class="div-update">
									<button type="submit" name="submit" class="btn-update">UPDATE</button>
								</div>
								<?php } else {
									echo "<p class='error' style='padding: 20px 0 20px 0;'>Invalid task</p>";
								} 	
								?>
					</form>
					

				</div>	
		</div>
	</body>
</html>