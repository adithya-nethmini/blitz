<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])) {
    $verificationToken = $_GET['token'];

    // Check if the verification token exists in the database
    // Assuming you have a table called "users" with columns "username", "password", and "verification_token"
    $sql = "SELECT username login users WHERE verification_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $verificationToken);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Verification token is valid
        $stmt->bind_result($username);
        @$stmt->fetch();
        $stmt->close();

        // Update the user's account status or perform any other necessary operations
        // For example, you can set a flag to indicate that the user has successfully verified their email

        // Display a success message
        $success = "Email verification successful. You can now login with your new password.";
    } else {
        // Verification token is invalid or expired
        $error = "Invalid verification token.";
    }
} else {
    // No token provided
    $error = "Invalid request.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <h2>Email Verification</h2>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } elseif (isset($success)) { ?>
        <p><?php echo $success; ?></p>
    <?php } ?>
</body>
</html>
