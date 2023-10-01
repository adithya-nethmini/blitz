<?php
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
$current_month = date('m');
$statusOptions = array(
    "All" => "",
    "Started" => "0",
    "On-Progress" => "3",
    "Done" => "5"
);

// Get the selected status from the dropdown
if (isset($_POST['status'])) {
    $selected_status = $_POST['status'];
} else {
    $selected_status = 'all';
}
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
                <div class= "button">
                    <a href="newproject.php"><i class="fa-regular fa-square-plus"></i> Add a New Project</a>
                </div>
                <div class="leave-container">

                    <div class="header">
                        <div class="topic"><h2>Project List</h2></div>
                        <form method="post">
                            <label for="status">Filter by Status:</label>
                            <select name="status" id="status" onchange="this.form.submit()">
                                <option value="all" <?php if ($selected_status == 'all') echo 'selected'; ?>>All</option>
                                <option value="0" <?php if ($selected_status == '0') echo 'selected'; ?>>Started</option>
                                <option value="3" <?php if ($selected_status == '3') echo 'selected'; ?>>On-Progress</option>
                                <option value="5" <?php if ($selected_status == '5') echo 'selected'; ?>>Done</option>
                            </select>
                        </form>
                        <div class="div-search">
                            &nbsp;&nbsp;<i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="search" onkeyup="searchFunction()"  placeholder="Search" title="Search">
                        </div>


                    </div>

                    <div class="all-tasks">

<table id="table" class="task-tbl">

        </div>
        <tr  class="table-header">
        <th>Project</th>
        <th>Date Started </th>
        <th>Due Date</th>
        <th>Status</th>
        <th>Action</th>
        </tr>
    <?php
    $dept_user = $_SESSION["dept_user"];
    $sql = "SELECT * from dept_head WHERE employeeid = '$dept_user'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dept_name = $row ['department'];
            $qry = "SELECT id,name,start_date,end_date,status from project_list WHERE dept_name = '$dept_name' AND MONTH(end_date) = $current_month ";
            if ($selected_status != 'all') {
                $qry .= " AND status = $selected_status";
            }
            $result = $mysqli->query($qry);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row ['id'];
                    echo '
                <tr>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['start_date'] . '</td>
                    <td>' . $row['end_date'] . '</td> ';
                    if ($row['status'] == 0) {
                        echo '<td><span id="started"> Started</span></td>';
                    } elseif ($row['status'] == 3) {
                        echo '<td><span id="ongoing"> On-Progress</span></td>';
                    } elseif ($row['status'] == 5) {
                        echo '<td><span id="done"> Done</span></td>';
                    }
                    echo ' <td><div class="dropdown">
                        <button class="dropbtn">Action</button>
                        <div class="dropdown-content">
                            <a href="project_view.php?id=' . $id . '">View</a>
                            <a href="update.php?id=' . $id . '">Update</a>
                            <a href="delete.php?id=' . $id . '" onclick="return deleteItem()" >Delete</a>
                        </div>
                    </div>
                    </td>';

                }
            } else {
                echo mysqli_error($mysqli);
            }
        }
    }else {
        echo mysqli_error($mysqli);
    }
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
                    <script>
                        function deleteItem() {
                            if (confirm("Are you sure you want to permanently delete the details?")) {
                                return true;
                            }  else {
                                return false;
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
