<?php
include("connection.php");
include 'sidebar.php';
include 'header.php';

if (isset($_GET['id'])) {
  $feedbackId = $_GET['id'];

  $sql = "SELECT * FROM feedback WHERE id = '$feedbackId'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Display the response form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="feedResponse.css">
        <title>Document</title>
    </head>
    <body>
        
    <form>
      <label for="employeeid">Employee ID:</label>
      <input type="text" id="employeeid" name="employeeid" value="<?php echo $row['employeeid']; ?>" readonly><br><br>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" readonly><br><br>

      <label for="subject">Subject:</label>
      <input type="text" id="subject" name="subject" value="<?php echo $row['subject']; ?>" readonly><br><br>

      <label for="feedback">Feedback:</label><br>
      <textarea id="feedback" name="feedback" rows="5" cols="30" readonly><?php echo $row['feedback']; ?></textarea><br><br>

      <label for="response">Response:</label><br>
      <textarea id="response" name="response" rows="5" cols="30"></textarea><br><br>

      <input type="button" value="Submit Response" onclick="submitResponse(<?php echo $row['id']; ?>)">
    </form>
    <?php
  } else {
    echo "Feedback not found.";
  }
} else {
  echo "Invalid request.";
}
?>

</body>
</html>

