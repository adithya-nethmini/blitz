<?php
// insert_login.php

// Retrieve the username and password from the AJAX request
$username = $_POST['username'];
$password = $_POST['password'];

// Validate and sanitize the input if needed
// Implement your own validation and sanitization logic here

// Perform any necessary checks or validations
// Implement your own checks or validations here

// Assuming you have a database connection already established
// Replace the database credentials with your own
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "blitz";

// Create a new PDO instance
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username_db, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Enable the login functionality for the provided username and password
    // Implement your own logic to enable the login based on the received data
    // This is just a placeholder implementation
    // Replace it with your own logic to enable the login functionality
    
    // Check if the username already exists in the database
    $stmt = $conn->prepare("SELECT username FROM login WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // Username already exists, return an error message
        echo "Username already exists, please choose a different username";
        exit();
    }
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO login (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();
    
    // Return a success message
    echo "Login enabled successfully";
} catch (PDOException $e) {
    // Handle any errors that occurred during the database operation
    echo "Error: " . $e->getMessage();
    exit();
}
?>
