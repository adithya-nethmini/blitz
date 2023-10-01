<?php
if (!isset($mysqli)) {
    include 'connection.php';
}
//include 'sidebar.php';
//include 'header.php';

// Retrieve the employee count for each department
$sql = "SELECT department, COUNT(*) AS employee_count FROM employee GROUP BY department";
$result = $conn->query($sql);
$employeeData = array();
while ($row = $result->fetch_assoc()) {
    $employeeData[] = $row;
}

// Retrieve the leave count for each type of leave
$sql = "SELECT reason, COUNT(*) AS leave_count FROM emp_leave GROUP BY reason";
$result = $conn->query($sql);
$leaveData = array();
while ($row = $result->fetch_assoc()) {
    $leaveData[] = $row;
}

// Retrieve the count of projects for each department
$sql = "SELECT $dept_name AS department, COUNT(*) AS project_count FROM project_list GROUP BY $dept_name";
$result = $conn->query($sql);
$projectData = array();
while ($row = $result->fetch_assoc()) {
    $projectData[] = $row;
}


// Retrieve the count for each type of offer
$sql = "SELECT type, COUNT(*) AS offer_count FROM offers GROUP BY type";
$result = $conn->query($sql);
$offerData = array();
while ($row = $result->fetch_assoc()) {
    $offerData[] = $row;
}
?>

<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="list_employee.css">
    <style>
        /* CSS for the chart containers */
        .chart-container {
            width: 600px;
            height: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <br> <br> <br> <br> <br> <br>
    <div class="analytics">
        <div class="card"  style="">
            <div class="analytics">
                <div class="group">
                    <div class="topic">
                        <h2>Company Entities</h2>
                    </div>
                    <br>
                    <div class="header-dash">
                        <div class="button1">
                            <a href="table.php"><i class="fa-solid fa-building"></i> &nbsp;&nbsp;4 Departments</a>
                        </div>

                        <div class="button1">
                            <a href="#"><i class="fa-solid fa-sheet-plastic"></i> &nbsp;&nbsp;28 Projects</a>
                        </div>

                        <div class="button1">
                            <a href="#"><i class="fa-solid fa-list-check"></i> &nbsp;&nbsp;49 Tasks</a>
                        </div>

                        <div class="button1">
                            <a href="partner.php"><i class="fa-solid fa-users"></i> &nbsp;&nbsp;11 Partners</a>
                        </div>
                    </div>
                </div>

                <!-- Chart containers -->
                <div class="chart-container">
                    <h2> Department wise Employee Count </h2>
                    <canvas id="employeeChart"></canvas>
                </div>
                <div class="chart-container">
                    <h2> Summary of Leaves </h2>
                    <canvas id="leaveChart"></canvas>
                </div>
                <div class="chart-container">
                    <h2> Overall Project Progress </h2>
                    <canvas id="projectChart"></canvas>
                </div>

                <div class="chart-container">
                <h2> Department-wise Project Count </h2>
                <canvas id="projectChart"></canvas>
                </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Retrieve the project count data from PHP
    var projectData = <?php echo json_encode($projectData); ?>;
    
    // Extract department names and project counts
    var departments = projectData.map(function (item) {
        return item.department;
    });
    var projectCounts = projectData.map(function (item) {
        return item.project_count;
    });

    // Create the project count chart using Chart.js
    var projectCtx = document.getElementById('projectChart').getContext('2d');
    new Chart(projectCtx, {
        type: 'bar',
        data: {
            labels: departments,
            datasets: [{
                label: 'Project Count',
                data: projectCounts,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    stepSize: 1
                }
            }
        }
    });
});

            // Retrieve the leave count data from PHP
            var leaveData = <?php echo json_encode($leaveData); ?>;
            
            // Extract leave reasons and leave counts
            var leaveReasons = leaveData.map(function (item) {
                return item.reason;
            });
            var leaveCounts = leaveData.map(function (item) {
                return item.leave_count;
            });

            // Create the leave count chart using Chart.js
            var leaveCtx = document.getElementById('leaveChart').getContext('2d');
            new Chart(leaveCtx, {
                type: 'doughnut',
                data: {
                    labels: leaveReasons,
                    datasets: [{
                        label: 'Leave Count',
                        data: leaveCounts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(153, 102, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
        

        document.addEventListener('DOMContentLoaded', function () {
            // Retrieve the project count data from PHP
            var projectData = <?php echo json_encode($projectData); ?>;
            
            // Extract status values and project counts
            var statuses = projectData.map(function (item) {
                var status = '';
                switch (item.status) {
                    case '0':
                        status = 'Started';
                        break;
                    case '3':
                        status = 'In Progress';
                        break;
                    case '5':
                        status = 'Done';
                        break;
                    default:
                        status = 'Unknown';
                        break;
                }
                return status;
            });
            var projectCounts = projectData.map(function (item) {
                return item.project_count;
            });

            // Create the project count chart using Chart.js
            var projectCtx = document.getElementById('projectChart').getContext('2d');
            new Chart(projectCtx, {
                type: 'bar',
                data: {
                    labels: statuses,
                    datasets: [{
                        label: 'Project Count',
                        data: projectCounts,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0,
                            stepSize: 1
                        }
                    }
                }
            });
        });

        
        
    </script>

</body>
</html>
</body>
</html>

