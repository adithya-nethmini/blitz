<?php require_once "user-data-control.php"; ?>
<?php 

include "config.php";

	function loginUser($username, $password) {

		

		$mysqli = connect();
		$username = trim($username);
		$password = trim($password);
	
		if ($username == "" || $password == "") {
			return "All fields are required";
		}
	
		$username = filter_var($username, FILTER_SANITIZE_STRING);
		$password = filter_var($password, FILTER_SANITIZE_STRING);
	
		$sql = "SELECT username, password, user_type FROM login WHERE username = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result->fetch_assoc();
	
		$userType = $data['user_type'];
	
		if ($data == NULL) {
			return "Wrong username or password";
		}
	
		if (password_verify($password, $data["password"]) == FALSE) {
			return "Wrong username or password";
		}
	
		switch ($userType) {
			case "employee":
				$_SESSION['user'] = $username;
				header('location: index.php');
				break;
			case "company_admin":
				$_SESSION['cadmin_user'] = $username;
				header('location: partner_profile.php');
				break;
			case "partner_company_admin":
				$_SESSION['company_id'] = $username;
				header('location: partner-feed.php');
				break;
			default:
				return "Invalid user type";
		}
	}
	
?>
