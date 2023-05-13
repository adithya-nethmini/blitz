<?php include '../function/function.php'; ?><!DOCTYPE html>
<html>
<head>
  <title>Awards Chart</title>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      <?php
      // Connect to the database
      $mysqli = connect();
      $user = $_SESSION['user'];

      date_default_timezone_set('Asia/Kolkata');
      $current_month = date('n');

      // Retrieve the data from the database
      $query = "SELECT MONTH(month), loyalty_type FROM loyalty WHERE username = '$user' AND MONTH(month) = '$current_month'";
      $result = $db->query($query);

      // Format the data for the chart
      $data = array();
      $data[] = array('Month', 'Awards');
      while ($row = $result->fetch_assoc()) {
          $data[] = array($row['month'], (int) $row['loyalty_type']);
      }
      ?>

      // Define the chart data
      var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

      // Define the chart options
      var options = {
        title: 'Awards by Month',
        legend: { position: 'none' },
        vAxis: { title: 'Number of Awards' },
        hAxis: { title: 'Month' },
        colors: ['#4285F4'],
        chartArea: { width: '70%', height: '80%' }
      };

      // Instantiate and draw the chart
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
  </script>
</head>
<body>
  <div id="chart_div" style="width: 900px; height: 500px;"></div>
</body>
</html>
