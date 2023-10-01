<?php
if(!isset($mysqli)){include 'connection.php';}
include 'sidebar.php';
include 'header.php';
/* $mysqli = connect(); */
?>

<html>
<head>
	<title>Upload CSV file</title>
	<link rel="stylesheet" href="list_employee.css">
</head>
<body>
<br />
	<div class="container">
		<h4>Upload CSV file</h4>
        <p><i>Here you can upload your employees' details as a bulk file.</i></p>
		<form action="upload_csv.php" method="post" enctype="multipart/form-data">
			<input type="file" name="csv_file" required>
			<input type="submit" value="Upload">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
		<div class= "button">
		<a href="createEmployee.php" data-role="button" data-inline="true" data-theme="b"><i class="fa-regular fa-square-plus"></i> Add a New Employee</a>
        </div>
		</form>

	<div class="leave-container">

<div class="header">
	<div class="topic"><h2>Employee List</h2></div>
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
<th> Employee ID</th>
<th> Name</th>
<th> Department</th>
<th> Job Role</th>
<th> Email </th>
<th> Contact Number</th>
<!--         <th> Profile Picture</th> -->
<th> Job Start Date</th>
<th> Action</th>
</tr>

<?php
include("connection.php");
//read the row of the selected client from database table 


$employeeid = "";
$name = "";
$department = "";
$jobrole = "";
$email = "";
$contactno = "";
$jobstartdate = "";
/* $profilepic_m =""; */


if ($_SERVER ['REQUEST_METHOD'] == 'POST') {


$employeeid = $_POST["employeeid"];
$name       = $_POST["name"];
$department = $_POST["department"];
$jobrole    = $_POST["jobrole"];
$email      = $_POST["email"];
$contactno  = $_POST["contactno"];
$jobstartdate  = $_POST["jobstartdate"];
/* $profilepic_m = $_POST["profilepic_m"]; */

$sql = "INSERT INTO `employee` (`employeeid`,`name`,`department`, `jobrole`,`email`,`contactno`,`jobstartdate`) VALUES ( '$employeeid','$name','$department', '$jobrole','$email','$contactno','$jobstartdate')";
$sql = "INSERT INTO `login` (`employeeid`,`password`) VALUES ( '$employeeid','$password')";
$result = $conn->query($sql);
if($result){
echo "<script>alert('added')</script>";
}
}



$sql2 = "SELECT * FROM `employee` ORDER BY employeeid ASC";
$result2 = $conn->query($sql2);
if(!$result2) {
die("Invalid Query:" . $conn->error);
}

//read data of each row //<td>$row[profilepic_m]</td>(144)
while ($row = $result2->fetch_assoc()){
   $eid= $row['employeeid'];?>


<tr>

<td data-label><?=$row['employeeid']?></td>
<td><?=$row['name']?></td>
<td><?=$row['department']?></td>
<td><?=$row['jobrole']?></td>
<td><?=$row['email']?></td> 
<td><?=$row['contactno']?></td>
<td><?=$row['jobstartdate']?></td>

<td>
    <a class="edit_btn" href="em_edit.php?id=<?php echo $eid ?>">Edit</a>
    <a href="em_dlt.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are you sure you want to delete?')" class='delete_btn'>Delete</a>
</td>
<tr>
<?php
}
?>
</tbody>
</table>

<!--</form>-->
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
