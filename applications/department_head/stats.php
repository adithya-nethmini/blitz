<?php
include 'sidebar.php';
//include 'header.php';
$mysqli = connect();
$current_date = date('Y-m-d');
$current_month = date('F');
$current_year = date('Y');
$pdo = new PDO('mysql:host=localhost;dbname=blitz', 'root', '');

$dept_user = $_SESSION["dept_user"];
$sql = "SELECT * from dept_head WHERE employeeid = '$dept_user' ";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$dept_name = $row ['department'];


$query = "SELECT DATE_FORMAT(end_date, '%M') AS month, COUNT(*) AS num_projects FROM project_list WHERE dept_name = '$dept_name' AND (status = 5 ) GROUP BY MONTH(end_date)";

$result = mysqli_query($mysqli, $query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

$chartData = [];
foreach ($data as $row) {
    $chartData[] = [$row['month'], (int)$row['num_projects']];
}
?>

<!--<div class="col-lg-12">-->
<!--    <div class="card card-outline card-primary">-->
<!--        <div class="card-body">-->
<!--            <form action="" id="manage-project">-->
<!---->
<!--                <input type="hidden" name="id" value="--><?php //echo isset($id) ? $id : '' ?><!--">-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Name</label>-->
<!--                            <input type="text" class="form-control form-control-sm" name="name" value="--><?php //echo isset($name) ? $name : '' ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="">Status</label>-->

<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Start Date</label>-->
<!--                            <input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="--><?php //echo isset($start_date) ? date("Y-m-d",strtotime($start_date)) : '' ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">End Date</label>-->
<!--                            <input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" value="--><?php //echo isset($end_date) ? date("Y-m-d",strtotime($end_date)) : '' ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    --><?php //if($_SESSION['login_type'] == 1 ): ?>
<!--                        <div class="col-md-6">-->
<!--                            <div class="form-group">-->
<!--                                <label for="" class="control-label">Project Manager</label>-->
<!--                                <select class="form-control form-control-sm select2" name="manager_id">-->
<!--                                    <option></option>-->
<!--                                    --><?php
//                                    $managers = $mysqli->query("SELECT *,concat(name,' ',jobrole) as name FROM employee order by concat(name,' ',jobrole) asc ");
//                                    while($row= $managers->fetch_assoc()):
//                                        ?>
<!--                                        <option value="--><?php //echo $row['id'] ?><!--" --><?php //echo isset($manager_id) && $manager_id == $row['id'] ? "selected" : '' ?><!-->--><?php //echo ucwords($row['name']) ?><!--</option>-->
<!--                                    --><?php //endwhile; ?>
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //else: ?>
<!--                        <input type="hidden" name="manager_id" value="--><?php //echo $_SESSION['login_id'] ?><!--">-->
<!--                    --><?php //endif; ?>
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Project Team Members</label>-->
<!--                            <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">-->
<!--                                <option></option>-->
<!--                                --><?//php?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stats.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
<body>
<div class="page">
    <h3>Annual Done Projects - Year <?php echo $current_year ?></h3>
    <br>
    <div id="column_chart_div" style="width: 1000px; height: 500px;"></div>
    <h3>Employee Performance in <?php echo $current_month ?></h3>
    <br>
    <br>

<canvas id="myChart" ></canvas>

<script>
    var xValues = ["Silver", "Gold", "Platinum", "Not Applicable"];
    var yValues = [63, 49, 44, 31];
    var barColors = [
        "rgba(82, 84, 82, 0.48)",
        "rgba(255, 215, 0, 0.73)",
        "rgba(229, 228, 226, 0.87)",
        "rgba(248, 20, 35, 0.63)"
    ];

    new Chart("myChart", {
        type: "doughnut",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: "Employee Performance in May"
            }
        }
    });
</script>
    <br>
    <br>
    <h3>Marketing Department Performance Progress</h3>
    <br>
    <br>
    <br>

    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "Department Progress"
                },
                data: [{
                    type: "line",
                    indexLabelFontSize: 12,
                    dataPoints: [
                        { y: 450 },
                        { y: 414},
                        { y: 520, indexLabel: "\u2191 highest",markerColor: "red", markerType: "triangle" },
                        { y: 460 },
                        { y: 450 },
                        { y: 500 },
                        { y: 480 },
                        { y: 480 },
                        { y: 410 , indexLabel: "\u2193 lowest",markerColor: "DarkSlateGrey", markerType: "cross" },
                        { y: 500 },
                        { y: 480 },
                        { y: 510 }
                    ]
                }]
            });
            chart.render();

        }

    </script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawColumnChart);

        function drawColumnChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Label');
            data.addColumn('number', 'Done');
            data.addRows(<?php echo json_encode($chartData); ?>);

            var options = {
                title: 'Monthly Project Completion Analysis: A Breakdown of Completed Projects by Month',
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('column_chart_div'));
            chart.draw(data, options);
        }
    </script>

    </head>
    <body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>

    </body>
</div>
</div>
</body>
</html>
