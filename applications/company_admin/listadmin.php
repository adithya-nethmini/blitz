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
<title>Project List</title>
<section>
    <div class="profile-container">

        <div class="page">

            <div class="page-content">
                <div class= "button">
                    <a href="create2.php"><i class="fa-regular fa-square-plus"></i> Add a New Department Head</a>
                </div>
                <div class="leave-container">

                    <div class="header">
                        <div class="topic"><h2>The Department Heads</h2></div>
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
            <th> Email </th>
            <th> Contact Number</th>
    <!--         <th> Profile Picture</th> -->
            <th> User Name</th>
            <th> Action</th>
        </tr>

    <?php
    include("connection.php");
//read the row of the selected client from database table 


$employeeid = "";
$name = "";
$department = "";
$email = "";
$contactno = "";
/* $profilepic_m =""; */
$username = "";
$password = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {


$employeeid = $_POST["employeeid"];
$name       = $_POST["name"];
$department = $_POST["department"];
$email      = $_POST["email"];
$contactno  = $_POST["contactno"];
/* $profilepic_m = $_POST["profilepic_m"]; */
$username   = $_POST["username"];
$password_1   = $_POST["password_1"];
$password_2   = $_POST["password_2"];
if($password_1 == $password_2){
$sql = "INSERT INTO `dept_head` (`employeeid`,`name`,`department`,`email`,`contactno`,`username`,`password`) VALUES ( '$employeeid','$name','$department','$email','$contactno','$username','$password_1')";
$result = $conn->query($sql);
if($result){
    echo "<script>alert('added')</script>";
}
}
/*$name       = $_POST["name"];
//$admin_type = $_POST["admin_type"];
$email      = $_POST["email"];
$contactno  = $_POST["contactno"];
$username   = $_POST["username"];
$password_1   = $_POST["password_1"];
$password_2   = $_POST["password_2"];


if (empty($id) || empty($employeeid) || empty($name) || empty($email) || empty($contactno) || empty($username) || empty($password_1) || empty($password_2))
{
$errorMessage = "All the fields are required!";


}
else{
$sql = "INSERT INTO `c_admins` (`employeeid`, `name`, `email`,`admin_type`, `contactno`, `username`, `password`) VALUES ( '$employeeid', '$name', '$email', 'admin','$contactno', '$username','$password_1')";

  $result = $conn->query($sql);


  if (!$result) {
    $errorMessage = "Invalid Query:" . $conn->error;
    
  }


  $successMessage = "Admin added correctly";

  header("location:/index.php");
  exit;
  


}*/

//add new client to database

}

$sql2 = "SELECT * FROM dept_head ORDER BY id ASC";
$result2 = $conn->query($sql2);
if(!$result2) {
die("Invalid Query:" . $conn->error);
}

//read data of each row //<td>$row[profilepic_m]</td>(144)
while ($row = $result2->fetch_assoc()){
echo "
<tr>

<td data-label>$row[employeeid]</td>
<td>$row[name]</td>
<td>$row[department]</td>
<td>$row[email]</td> 
<td>$row[contactno]</td>

<td>$row[username]</td>

<td>
    <a class='btn btn-primary btn-sm' href='listadmin.php?id=$row[id]'>Edit</a>
    <a class='btn btn-danger btn-sm' href='delete.php?id=$row[id]'>Delete</a>
</td>
<tr>
";
}
?>
</tbody>
</table>

<!--</form>-->
</div>

</div>

</div>


</body>
</html>