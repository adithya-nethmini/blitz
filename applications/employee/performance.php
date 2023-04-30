<?php
include '../function/function.php';
include 'sidebar.php';
include '../../header.php';

if (!isset($_SESSION["user"])) {
    header("location: login.php");

    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance</title>
    <link rel="stylesheet" href="../../views/css/performance.css">
    <link rel="stylesheet" href="../../views/css/header.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <section>

            <div class="page-content">
            <div class="topic">
                            <h2>Member Performance Evaluation</h2>
                        </div>
                <div class="leave-container2">

                    <div class="header">
                        


                        <div class="button_p">
                            <button style="background-color:transparent;border:none;color:white" id="PrintButton" onclick="PrintTable()"><i class='fa-solid fa-print'></i>Print</button>
                            <!-- <a href=""><i class='fa-solid fa-print'></i>Print</a> -->
                        </div>
                    </div>

                    <div class="all-tasks">

                        <table id="table" class="task-tbl">
                            <?php $current_date = date('F');?>
                            <caption style="padding-bottom:10px">Performance Result Report - Month <?php echo $current_date?></caption>

                    </div>
                    <tr class="table-header">
                        <th>Employee ID</th>
                        <th>Employee Name </th>
                        <th>No.of Tasks Assigned</th>
                        <th>Completed Tasks</th>
                        <th>Attendance</th>
                        <th>Performance</th>
                        <th>User Type</th>
                    </tr>
                    <?php
                    $mysqli = connect();
                    $user = $_SESSION['user'];
                    $qry = "SELECT employeeid,name from employee WHERE username = '$user'";
                    $result = $mysqli->query($qry);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
<tr>
    <td>' . $row['employeeid'] . '</td>
    <td>' . $row['name'] . '</td>
    <td>10</td>
    <td>7</td>
    <td>70%</td>
    <td>70%</td>
    <td><span id="user_t">Silver</span></td>';
                        }
                    } else {
                        echo mysqli_error($mysqli);
                    }
                    ?>

                    </tr>
                    </table>
                </div>
                <br><br>

            </div>
            <div class="leave-container2">

            </div>

    </section>



</body>
<script src="../../views/js/main.js"></script>
<script type="text/javascript">
    function PrintTable() {
        var printContents = document.getElementById('table').outerHTML;
        var originalContents = document.body.innerHTML;

        // Create a new style element and set its content to the CSS styles of the table
        var style = document.createElement('style');
        style.innerHTML = `
        .task-tbl{
    width: 100%;
    overflow-x: auto;
    overflow-y: auto;
    table-layout: fixed;
    display: inline-block;
    height: 250px;
    border-collapse: separate;
    border-spacing: 0px;
    color: #51619b;
    font-weight: 520;
    margin-top: 10px;
}

.task-tbl tr {
    border: 2px solid grey ;
}


.task-tbl tr th{
    border-bottom: 2px solid grey ;
    padding: 10px 5px;
    font-size: 17px;
    position: sticky;
    position: -webkit-sticky;
    top: 0;
    z-index: 2;
}

.task-tbl tr td{
    text-align: center;
    padding: 10px 5px;
    font-size: 14px;
    border-bottom: 1px solid grey ;
    z-index: -2;
}

        `;

        // Append the style element to the HTML content of the table
        printContents = style.outerHTML + printContents;

        document.body.innerHTML = printContents;
        window.print();

        document.body.innerHTML = originalContents;
    }
    window.addEventListener('DOMContentLoaded', (event) => {
        PrintPage()
        setTimeout(function() {
            window.close()
        }, 750)
    });
</script>

</html>