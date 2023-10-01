<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $employeeId = $_POST['employeeId'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $feedback = $_POST['feedback'];

  // Database connection parameters
  $servername = 'localhost';
  $username = 'your_username';
  $password = 'your_password';
  $dbname = 'feedback';

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare and execute SQL query to insert feedback into table
  $stmt = $conn->prepare("INSERT INTO feedback_table (employeeId, email, subject, feedback) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $employeeId, $email, $subject, $feedback);
  $stmt->execute();

  // Close statement and connection
  $stmt->close();
  $conn->close();

  // Display success message
  echo "<script>alert('Feedback submitted successfully!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Employee Feedback Form</title>
  <link rel="stylesheet" href="feedback.css">
</head>
<body>
  <div class="container">
    <h2>Employee Feedback Form</h2>
    <form method="POST" action="feedback.php">
      <label for="employeeId">Employee ID:</label>
      <input type="text" id="employeeId" name="employeeId" required><br><br>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required><br><br>
      
      <label for="subject">Subject:</label>
      <input type="text" id="subject" name="subject" required><br><br>
      
      <label for="feedback">Feedback:</label><br>
      <textarea id="feedback" name="feedback" rows="5" cols="30" required></textarea><br><br>
      
      <input type="submit" value="Submit">
    </form>
  </div>
</body>
</html>
