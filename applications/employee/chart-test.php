<?php
include '../function/function.php';
include 'sidebar.php';
include 'header.php';

if (isset($_GET['logout'])) {
    logoutUser();
}

$mysqli = connect();
$user = $_SESSION['user'];

date_default_timezone_set('Asia/Kolkata');
$current_month = date('n');

$result = mysqli_query($mysqli, "SELECT name, status, COUNT(*) AS count FROM project_list WHERE MONTH(date_created) = '$current_month' AND manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0 GROUP BY status");

// Format data
$ppdata = array();
while ($row = mysqli_fetch_assoc($result)) {
    $ppdata[] = array($row['name'], $row['status'], (int)$row['count']);
}

// $data = json_encode($data);

// $pdo = new PDO('mysql:host=localhost;dbname=blitz', 'root', '');

// date_default_timezone_set('Asia/Kolkata');
// $current_month = date('n');
// $query = $pdo->query("SELECT name, status FROM project_list WHERE MONTH(date_created) = '$current_month' AND manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0 GROUP BY status");

// // Fetch the results as an associative array
// $data = $query->fetchAll(PDO::FETCH_ASSOC);

// // Format the data for charting
// $chart_data = array(
//     array('Project Name', 'Status')
// );

// foreach ($data as $row) {
//     $chart_data[] = array($row['name'], (int)$row['status']);
// }

// $chart_data = json_encode($chart_data);



$query = "SELECT DATE_FORMAT(month, '%M') AS month, COUNT(*) AS num_awards FROM loyalty WHERE username = '$user' GROUP BY MONTH(month)";

$result = mysqli_query($mysqli, $query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Step 3: Format the data for the chart (example assumes two columns: 'label' and 'value')
$chartData = [];
foreach ($data as $row) {
    $chartData[] = [$row['month'], (int)$row['num_awards']];
}



date_default_timezone_set('Asia/Kolkata');
$current_month = date('n');

$query = "SELECT name, status FROM project_list WHERE MONTH(date_created) = '$current_month' AND FIND_IN_SET('$user', user_ids) > 0";

$result = mysqli_query($mysqli, $query);

if (!$result) {
    die('Error: ' . mysqli_error($mysqli));
}

$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Step 3: Format the data for the chart (example assumes two columns: 'label' and 'value')
$chartProjectData = [];
foreach ($data as $row) {
    $chartProjectData[] = [$row['name'], (int)$row['status']];
}




// // Get the counts of awards by month for the user
// $query = "SELECT DATE_FORMAT(month, '%m') AS month, COUNT(*) AS num_awards FROM loyalty WHERE username = '$user' GROUP BY MONTH(month)";

// $result = mysqli_query($mysqli, $query);
// $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// // Initialize an array to hold the counts of awards for each month
// $countsByMonth = array_fill(1, 12, 0);

// // Store the counts of awards in the array by month
// foreach ($data as $row) {
//     $month = intval($row['month']);
//     $countsByMonth[$month] = intval($row['num_awards']);
// }

// // Generate the chart data
// $chartData = array();
// for ($month = 1; $month <= 12; $month++) {
//     $monthName = date("F", mktime(0, 0, 0, $month, 1));
//     $chartData[] = array($monthName, $countsByMonth[$month]);
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../views/css/leave-status.css">
    <link rel="stylesheet" href="../../views/css/header.css">
</head>

<body>
    <section>
        <div class="profile-container">

            <div class="page">
                <div class="page-content">

                    <div class="chart">
                        <div id="pie_chart_div" style="width: 500px; height: 200px;"></div>
                        <div id="award_column_chart_div" style="width: 100%; height: 400px"></div>
                        <div id="project_column_chart_div" style="width: 100%; height: 400px"></div>
                    </div>

                </div>

            </div>


        </div>


    </section>

</body>
<script src="../../views/js/main.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" >
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawColumnChart);

    function drawColumnChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Label');
        data.addColumn('number', 'Value');
        data.addRows(<?php echo json_encode($chartData); ?>);

        var options = {
            title: 'Monthly Leave Allocation and Consumption: A Comparative Analysis',
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('award_column_chart_div'));
        chart.draw(data, options);
    }
</script>

<script type="text/javascript" >
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawProjectColumnChart);

    function drawProjectColumnChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Label');
        data.addColumn('number', 'Value');
        data.addRows(<?php echo json_encode($chartProjectData); ?>);

        var options = {
            title: 'Monthly Project Status',
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('project_column_chart_div'));
        chart.draw(data, options);
    }
</script>

<script>
//     google.charts.load("current", {
//     packages: ["corechart"]
// });
// google.charts.setOnLoadCallback(drawColumnChart);

// function drawColumnChart() {
//     var data = google.visualization.arrayToDataTable(<?php echo $chart_data; ?>);

//     var options = {
//         title: 'Awards by Month',
//         legend: { position: 'bottom' },
//         tooltip: {
//             trigger: 'selection',
//             isHtml: true,
//             formatter: function (tooltipData) {
//                 var tooltipContent = '<div style="padding:10px 20px;">';
//                 tooltipContent += '<div>' + tooltipData.x + '</div>';
//                 tooltipContent += '<div style="font-size:14px;font-weight:bold;">' + tooltipData.y + '</div>';
//                 tooltipContent += '<div>' + tooltipData.row['2'] + '</div>';
//                 tooltipContent += '</div>';
//                 return tooltipContent;
//             }
//         },
//         hAxis: { title: 'Month' },
//         vAxis: { title: 'Number of Awards' }
//     };

//     var chart = new google.visualization.ColumnChart(document.getElementById('award_column_chart_div'));
//     chart.draw(data, options);
// }


</script>
<!-- <script type="text/javascript">
    google.charts.load("current", {
        packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php /*echo $chart_data;*/ ?>);

        var options = {
            title: 'Monthly Project Status',
            is3D: true,
            legend: {
                position: 'bottom'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));

        chart.draw(data, options);
    }
</script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawPPChart);

        function drawPPChart() {
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($ppdata); ?>);

            var options = {
                title: 'Project Status',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
            chart.draw(data, options);
        }
    </script>
</html>