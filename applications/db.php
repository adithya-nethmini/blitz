<?php

// Step 2: Verify Email
function getUserByEmail($email)
{
    // Implement your database query to retrieve user by email
    // Assuming you have a table called "users" with columns "id", "email", "password", "reset_token", and "reset_token_expiry"
    // Adjust the database connection details accordingly
    $dbhost = 'localhost';
    $dbname = 'your_database_name';
    $dbuser = 'your_username';
    $dbpass = 'your_password';

    // Create a PDO connection
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the connection
    $conn = null;

    return $user;
}

// Step 3: Generate Password Reset Token
function generateToken()
{
    // Generate a unique and secure token
    $token = bin2hex(random_bytes(32));

    return $token;
}

// Step 4: Send Password Reset Email (mock implementation)
function sendPasswordResetEmail($email, $token)
{
    // Implement code to send an email to the provided email address
    // Include the password reset link containing the token
    // You can use PHP's built-in mail() function or a library like PHPMailer to send emails
    // Example:
    $resetLink = "http://example.com/reset_password.php?token=$token";
    $subject = "Password Reset";
    $message = "Dear user, you have requested to reset your password. Please click the following link to reset your password: $resetLink";
    mail($email, $subject, $message);
}

// Step 6: Validate Token
function getUserByToken($token)
{
    // Implement your database query to retrieve user by token
    // Assuming you have a table called "users" with columns "id", "email", "password", "reset_token", and "reset_token_expiry"
    // Adjust the database connection details accordingly
    $dbhost = 'localhost';
    $dbname = 'your_database_name';
    $dbuser = 'your_username';
    $dbpass = 'your_password';

    // Create a PDO connection
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the connection
    $conn = null;

    return $user;
}

// Step 7: Update Password
function updatePassword($userId, $password)
{
    // Implement your database query to update user's password
    // Assuming you have a table called "users" with columns "id", "email", "password", "reset_token", and "reset_token_expiry"
    // Adjust the database connection details accordingly
    $dbhost = 'localhost';
    $dbname = 'your_database_name';
    $dbuser = 'your_username';
    $dbpass = 'your_password';


    // Create a PDO connection
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

    // Prepare and execute the query
    $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    // Close the connection
    $conn = null;
}

function updateResetToken($userId, $token, $expiry)
{
    // Implement your database query to update user's reset token and expiry
    // Assuming you have a table called "users" with columns "id", "email", "password", "reset_token", and "reset_token_expiry"
    // Adjust the database connection details accordingly
    $dbhost = 'localhost';
    $dbname = 'your_database_name';
    $dbuser = 'your_username';
    $dbpass = 'your_password';

    // Create a PDO connection
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

    // Prepare and execute the query
    $stmt = $conn->prepare("UPDATE users SET reset_token = :token, reset_token_expiry = :expiry WHERE id = :id");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':expiry', $expiry);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    // Close the connection
    $conn = null;
}
