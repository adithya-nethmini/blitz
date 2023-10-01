<?php

include("connection.php");
$employeeidErr= $emailErr = $subjectErr = $feedbackErr = "";  
$employeeid= $email = $subject = $feedback = "";  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  @$employeeid = $_POST['employeeid'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $feedback = $_POST['feedback'];

$sql = "INSERT INTO `feedback` (`employeeid`,`email`,`subject`,`feedback`) VALUES ( '$employeeid','$email','$subject','$feedback')";
$result = $conn->query($sql);
if($result){
    echo "<script>alert('Feedback submitted successfully!');</script>";
    echo "<script>window.location.href = 'feed.php';</script>";
           }
                               }
                                            

$sql2 = "SELECT * FROM feedback ORDER BY senton DESC";
$result2 = $conn->query($sql2);
if(!$result2) {
die("Invalid Query:" . $conn->error);
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
      <label for="employeeid">Employee ID:</label>
      <input type="text" id="employeeid" name="employeeid" required><br><br>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required><br><br>
      
      <label for="subject">Subject:</label>
      <input type="text" id="subject" name="subject" required><br><br>
      
      <label for="feedback">Feedback:</label><br>
      <textarea id="feedback" name="feedback" rows="5" cols="30" required></textarea><br><br>
      
      <input type="submit" value="Submit"><a href="feed.php">
      
    </form>
  </div>
</body>
</html>
