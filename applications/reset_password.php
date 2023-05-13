<?php
session_start();
require_once 'db.php';

$token = $_GET['token'];

// Step 6: Validate Token
$user = getUserByToken($token);

if (!$user || $user['reset_token_expiry'] < date('Y-m-d H:i:s')) {
    $_SESSION['error'] = 'Invalid or expired token.';
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        // Step 7: Update Password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        updatePassword($user['id'], $hashedPassword);
        updateResetToken($user['id'], null, null);

        $_SESSION['message'] = 'Your password has been successfully reset.';
        header('Location: index.php');


        exit();
    } else {
        $_SESSION['error'] = 'Passwords do not match. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="">
        <label>New Password:</label>
        <input type="password" name="new_password" required><br>
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required><br>
        <input type="submit" value="Reset Password">
    </form>
</body>

</html>