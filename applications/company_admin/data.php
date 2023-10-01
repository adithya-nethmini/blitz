<?php
 include 'connection.php';

try {
  $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Fetch the data from emp_leave table
  $stmt = $conn->query("SELECT reason, COUNT(*) AS count FROM emp_leave GROUP BY reason");
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Prepare the data in the required format
  $reasons = array();
  $counts = array();
  foreach ($data as $row) {
    $reasons[] = $row['reason'];
    $counts[] = (int) $row['count'];
  }

  // Prepare the response
  $response = array(
    'reasons' => $reasons,
    'counts' => $counts
  );

  // Send the JSON response
  header('Content-Type: application/json');
  echo json_encode($response);
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;
?>
