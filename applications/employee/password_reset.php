<?php
// Assuming you have a database connection established

// Step 5: Verify the token
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $query = "SELECT email, expiry_time FROM password_resets WHERE token = :token";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $email = $result['email'];
        $expiryTime = $result['expiry_time'];

        // Check if the token is expired
        if (strtotime($expiryTime) < time()) {
            echo "The password reset link has expired. Please request a new one.";
            exit;
        }
    } else {
        echo "Invalid password reset token.";
        exit;
    }
} else {
    echo "Missing password reset token.";
    exit;
}

// Step 7: Update the password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];
    // Validate and sanitize the new password as needed

    // Update the user's password in the database
    $query = "UPDATE users SET password = :password WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Delete the password reset token from the database
    $query = "DELETE FROM password_resets WHERE token = :token";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    echo "Password has been successfully reset.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
</head>

<body>
    <h2>Reset Your Password</h2>
    <form method="POST" action="">
        <label for="new_password">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <br>
            <input type="submit" value="Reset Password">
    </form>
</body>

</html>