<?php
include 'function/function.php';
$mysqli = connect();
// Step 2: Validate user input
if (isset($_POST['email'])) {
  $email = $_POST['email'];

  // Validate the email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address");
  }

  // Check if the email or username exists in the database
//   $stmt = $mysqli->prepare("SELECT * FROM employee WHERE email = ?");
//   $stmt->bind_param("s", $email);
//   $stmt->execute();
//   $stmt->store_result();
//   if ($stmt->num_rows > 0) {
//       $stmt->bind_result($name, $email, $contactno, $address);
//       $stmt->fetch();

$query = "SELECT * FROM employee WHERE email = :email OR username = :username";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    // Handle the error if the prepare statement fails
    die('Error: ' . $mysqli->error);
}

// Bind the parameters and execute the query
$stmt->bind_param('ss', $email, $email);
$result = $stmt->execute();

if (!$result) {
    // Handle the error if the execution fails
    die('Error: ' . $stmt->error);
}

// Fetch the user data
$user = $stmt->fetch();

// Continue with the rest of your code


  if (!$user) {
    die("No user found with that email address or username");
  }

  // Step 3: Generate a random password reset token
  $token = bin2hex(random_bytes(32));

  // Step 4: Store the token in the database
  $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // token expires in 1 hour

  $query = "UPDATE login SET reset_token = :token, reset_expiry = :expiry WHERE username = :username";
  $stmt = $mysqli->prepare($query);
  $stmt->execute(['token' => $token, 'expiry' => $expiry, 'username' => $user['username']]);

  // Step 5: Send a password reset email
  $reset_link = "http://localhost/blitz/applications/reset_password.php?token=$token";

  $subject = "Password reset request";
  $message = "Hi " . $user['username'] . ",\n\n"
           . "You've requested to reset your password. To reset your password, click on the link below:\n\n"
           . $reset_link . "\n\n"
           . "This link will expire in 1 hour.\n\n"
           . "If you didn't request to reset your password, please ignore this message.\n\n"
           . "Thanks,\n"
           . "Blitz";

  mail($user['email'], $subject, $message);

  echo "Password reset instructions sent to your email address.";
}
?>

<!-- Step 1: Create a "forgot password" form -->
<form action="forgot_password.php" method="post">
  <label for="email">Enter your email address or username:</label>
  <input type="text" id="email" name="email" required>
  <button type="submit">Submit</button>
</form>
