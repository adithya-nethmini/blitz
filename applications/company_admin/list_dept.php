<?php
if(!isset($mysqli)){include 'connection.php';}
include 'sidebar.php';
include 'header.php';
/* $mysqli = connect(); */
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
<title>Department List</title>
<section>
    <div class="profile-container">

        <div class="page">

            <div class="page-content">
                <div class= "button">
                    <a href="createDept.php"><i class="fa-regular fa-square-plus"></i> Add a New Department</a>
                </div>
                <div class="leave-container">

                    <div class="header">
                        <div class="topic"><h2>The Departments</h2></div>
                        <div class="div-search">
                            &nbsp;&nbsp;<i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="search" onkeyup="searchFunction()"  placeholder="Search" title="Search">
                        </div>

                    </div>

                    <div class="all-tasks">

<table id="table" class="task-tbl">

        </div>
        <tr  class="table-header">
        <tr>
            <th> Department Name</th>
            <th> Description</th>
            <th> Action</th>
        </tr>
    <?php
     include("connection.php");
     $departmentname = "";
     $description = "";
     $errorMessage = "";
     $successMessage = "";

     if ($_SERVER ['REQUEST_METHOD'] == 'POST') {


        $departmentname = $_POST["departmentname"];
        $description      = $_POST["description"];
        $sql = "INSERT INTO `dept_head` (`employeeid`,`name`,`department`,`email`,`contactno`) VALUES ( '$employeeid','$name','$department','$email','$contactno')";
        $result = $conn->query($sql);
if($result){
    echo "<script>alert('added')</script>";
           }
                               }

        $sql2 = "SELECT * FROM department ORDER BY id ASC";
        $result2 = $conn->query($sql2);
        if(!$result2) {
        die("Invalid Query:" . $conn->error);
                      }
        
        //read data of each row
        while ($row = $result2->fetch_assoc()){
            $id = $row['id'];   

        ?>

                <tr>
                <td data-label><?=$row['departmentname']?></td>
                <td><?=$row['description']?></td>
     
                    <td><div class="dropdown">
                    <button class="dropbtn">Action</button>
                    <div class="dropdown-content">
                        <a href="dept_view.php?id=<?php echo $row['id'] ?>">View<?php echo $departmentname; ?></a>
                        <a href="dept_edit.php?id=<?php echo $id ?>">Update</a>
                        <a href="dept_dlt.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure you want to delete?')" class='delete_btn'>Delete</a>
                    </div>
                </div>
                </td>
                <?php
                                        }
?>

                               </table>
                               </div>
        </div>
    </div>

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



</body>
</html>