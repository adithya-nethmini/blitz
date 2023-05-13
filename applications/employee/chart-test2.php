<?php
include '../function/function.php';
// Connect to the database
$pdo = new PDO('mysql:host=localhost;dbname=blitz', 'root', '');

$user = $_SESSION['user'];

// Query the data
$query = $pdo->query("SELECT leave_type, SUM(1) AS total_leaves FROM e_leave WHERE name='$user' AND (status = 'Accepted' OR status = 'Taken') GROUP BY leave_type");

// Fetch the results as an associative array
$data = $query->fetchAll(PDO::FETCH_ASSOC);

// Format the data for charting
$chart_data = array(
    array('Leave Type', 'Total Leaves')
);

foreach ($data as $row) {
    $chart_data[] = array($row['leave_type'], (int)$row['total_leaves']);
}

$chart_data = json_encode($chart_data);



$query = $pdo->query("SELECT name, status FROM project_list WHERE manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0 GROUP BY name");

// Fetch the results as an associative array
$data = $query->fetchAll(PDO::FETCH_ASSOC);

// Format the data for charting
$chart_data = array(
    array('Project Name', 'Status')
);

foreach ($data as $row) {
    $chart_data[] = array($row['name'], (int)$row['status']);
}

$chart_data = json_encode($chart_data);
?>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo $chart_data; ?>);

            var options = {
                title: 'Leaves by Type',
                is3D: true,
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));

            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawProjectChart);

        function drawProjectChart() {
            var data = google.visualization.arrayToDataTable(<?php echo $chart_data; ?>);

            var options = {
                title: 'Project Status',
                is3D: true,
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('pie_chart_project_div'));

            chart.draw(data, options);
        }
    </script>
    <style>
        .project-tbl {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        .project-tbl th,
        .project-tbl td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 16px;
            font-weight: normal;
        }

        .project-tbl th {
            background-color: #f8f8f8;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .project-tbl tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .started,
        .ongoing,
        .done {
            color: #f8f8f8;
            border-radius: 5px;
            padding: 8px 10px;
            height: 30px;
            width: 60px;
            font-size: 12px;
        }

        .started {

            background-color: #0264A2;
            border: 1px solid #0264A2;
        }

        .ongoing {
            background-color: #027da284;
            border: 1px solid #027da284;
        }

        .done {
            background-color: rgba(26, 191, 10, 0.73);
            border: 1px solid rgba(26, 191, 10, 0.73);
        }
    </style>
</head>

<body>
    <div id="pie_chart_div" style="width: 400px; height: 400px;"></div>
    <div id="pie_chart_project_div" style="width: 400px; height: 400px;"></div>
    <table class="project-tbl">
        <thead>
            <tr>
                <th>Project</th>
                <th>Status</th>
            </tr>

        </thead>
        <tbody>
            <?php
            $mysqli = connect();
            $stmt = $mysqli->prepare("SELECT name, status FROM project_list WHERE manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0");
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($name, $status);
                while ($stmt->fetch()) { ?>
                    <tr>
                        <td><?= $name ?></td>
                        <?php if ($status == 0) {
                            $status = 'Started'; ?>
                            <td><span class="started"><?= $status ?></span></td>
                        <?php } elseif ($status == 3) {
                            $status = 'On-Progress'; ?>
                            <td><span class="ongoing"><?= $status ?></span></td>
                        <?php } else {
                            $status = 'Done'; ?>
                            <td><span class="done"><?= $status ?></span></td>
                        <?php } ?>

                    </tr>

            <?php }
            } ?>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>Project Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Project A</td>
                <td><span class="status status--in-progress">In Progress</span></td>
            </tr>
            <tr>
                <td>Project B</td>
                <td><span class="status status--planned">Planned</span></td>
            </tr>
            <tr>
                <td>Project C</td>
                <td><span class="status status--complete">Complete</span></td>
            </tr>
            <tr>
                <td>Project D</td>
                <td><span class="status status--in-progress">In Progress</span></td>
            </tr>
            <tr>
                <td>Project E</td>
                <td><span class="status status--planned">Planned</span></td>
            </tr>
        </tbody>
    </table>
    <?php

    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT name, status FROM project_list WHERE manager_id = '$user' OR FIND_IN_SET('$user', user_ids) > 0");
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $status);
        while ($stmt->fetch()) {
            echo $name . ': ' . $status . '<br>';
        }
    }
    ?>
</body>

</html>