<?php
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="list.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
</head>
<title>Blitz</title>
<section>
    <div class="profile-container">

        <div class="page">

            <div class="page-content">
                <div class="leave-container">

                    <div class="header">
                        <div class="topic"><h2>Employee List</h2></div>
                        <div class="div-search">
                            &nbsp;&nbsp;<i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="search" onkeyup="searchFunction()"  placeholder="Search" title="Search">
                        </div>

                    </div>

                    <div class="all-tasks">

                        <table id="table" class="task-tbl1">

                    </div>
                    <tr  class="table-header">
                        <th>Employee ID</th>
                        <th>Employee Name </th>
                        <th>Jobrole </th>
                        <th>Email </th>
                        <th>Contact number </th>
                        <th>Address </th>
                    </tr>
                    <?php
                    $dept_user = $_SESSION["dept_user"];
                    $sql = "SELECT * from dept_head WHERE employeeid = '$dept_user' ";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $dept_name = $row ['department'];

                            $qry = "SELECT username,employeeid,name,jobrole,email,contactno,address from employee WHERE department = '$dept_name'";
                            $result = $mysqli->query($qry);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $username = $row ['username'];
                                    echo '
                <tr>
                    <td>' . $row['employeeid'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['jobrole'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['contactno'] . '</td>
                    <td>' . $row['address'] . '</td>';

                                }
                            } else {
                                echo mysqli_error($mysqli);
                            }
                        }
                    }
                    else {
                    echo mysqli_error($mysqli);}
                    ?>

                    </tr>
                    </table>

                    <script>
                        function searchFunction() {
                            var input, filter, table, tr, td, i;
                            input = document.getElementById("search");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("table");
                            tr = table.getElementsByTagName("tr");
                            for (var i = 0; i < tr.length; i++) {
                                var tds = tr[i].getElementsByTagName("td");
                                var flag = false;
                                for(var j = 0; j < tds.length; j++){
                                    var td = tds[j];
                                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                        flag = true;
                                    }
                                }
                                if(flag){
                                    tr[i].style.display = "";
                                }
                                else {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    </script>

                </div>
            </div>
        </div>

    </div>


    </div>


</section>

</body>
<script src="../../views/js/main.js"></script>
</html>