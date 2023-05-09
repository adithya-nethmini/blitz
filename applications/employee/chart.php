<?php
// Step 1: Connect to the database
include '../function/function.php';

$mysqli = connect();

if (!$mysqli) {
    die('Database connection failed: ' . mysqli_connect_error());
}
$user = $_SESSION['user'];
// Step 2: Fetch data from the database
$query = "SELECT DATE_FORMAT(applied_date, '%M') AS month, COUNT(*) AS num_leaves FROM e_leave WHERE name = '$user' AND (status = 'Accepted' OR status = 'Taken') GROUP BY MONTH(applied_date)";

$result = mysqli_query($mysqli, $query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Step 3: Format the data for the chart (example assumes two columns: 'label' and 'value')
$chartData = [];
foreach ($data as $row) {
    $chartData[] = [$row['month'], (int)$row['num_leaves']];
}

// Step 4: Include the necessary charting library (Google Charts)

?>

<!-- Step 5: Generate the chart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawColumnChart);

    function drawColumnChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Label');
        data.addColumn('number', 'Value');
        data.addRows(<?php echo json_encode($chartData); ?>);

        var options = {
            title: 'Chart Title',
            // Set additional chart options here
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>

<!-- Step 6: Display the chart -->
<div id="chart_div" style="width: 100%; height: 400px;"></div>

<?php
// Step 7: Close the database connection
mysqli_close($mysqli);
?>
