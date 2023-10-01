<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the form data
    if ($newPassword !== $confirmPassword) {
        $error = "Password and Confirm Password do not match.";
    } else {
        // Generate a verification token
        $verificationToken = generateVerificationToken();

        // Perform password reset
        $sql = "UPDATE login SET password = ?, verification_token = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $hashedPassword, $verificationToken, $username);

        if ($stmt->execute()) {
            // Send the verification email
            $to = $_POST['email'];
            $subject = "Password Reset Verification";
            $message = "Dear user, your password has been reset. Please click the following link to verify your email and complete the password reset process:\n\n";
            $message .= "Verification Link: verify.php" . $verificationToken;

            $headers = "From: blitz.emp.mgt.sys@gmail.com\r\n";
            $headers .= "Reply-To: $email.com\r\n";
            $headers .= "Content-type: text/plain\r\n";

            if (mail($to, $subject, $message, $headers)) {
                $success = "Password reset successfully. Please check your email for the verification link.";
            } else {
                $error = "Error sending verification email.";
            }
        } else {
            $error = "Error resetting password.";
        }
    }
}

// Function to generate a random verification token
function generateVerificationToken()
{
    $length = 32;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h2>Password Reset</h2>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } elseif (isset($success)) { ?>
        <p><?php echo $success; ?></p>
    <?php } ?>

    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br><br>
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br><br>
        
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
