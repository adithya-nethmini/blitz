<!DOCTYPE html>
<html>
  <head>
    <title>Offer_Redeem</title>
    <link rel="stylesheet" href="done.css">
</head>

<body>
<!-- <bg "logowhite.png" alt="" align="right"> -->
<img src="logo.png" alt="" >
    <button class="btn" onclick="openPopup()">Redeem</button>
    <button class="btn" onclick="history.back()">Verification</button>
    <button class="btn" href="" >Back to POS</button>
    <div class="popup" id="popup">
        
 <!--            <img src="logo.png" align="center"> -->
            <form method="post" action="">
            <h2>Authentication Required</h2>
            <p> Please Enter the PIN</p>
			<input type="text" name="aUsername" >
            <button type="" href="redeem.php">OK</button>
            <button type="" href="redeem">Cancel</button>
    </div>
    <!-- <button class="btn" onclick="closePopup()">Redeem</button>
    <div class="popup" id="popup">
        
        <img src="logo.png" align="center">
        <form method="post" action="">
        <h2>Successfully</h2>
        <p> Please Enter the PIN</p>
        <input type="text" name="aUsername" >
        <button type="button"><a href=success.php>OK</button>
</div> -->

<script>
let popup = document.getElementById("popup");
function openPopup(){
    /* popup.classList.add("open-popup"); */
    popup.style.opacity=1;
    popup.style.zIndex=4;
}
/* function closePopup(){
    popup.classList.remove("open-popup");
} */
</script>


<table class="table">
        <thead>
        
        <tr>
            <th> Unique ID</th>
            <th> Name</th>
            <th> Offer</th>
            <th> Status</th>
        </tr>

         </thead>
    <tbody>
    <tr>
            <td> 12345ABC</td>
            <td> Adithya</td>
            <td> 10%</td>
            <td> Available</td>
        </tr>
</tbody>

    <?php
    include("connection.php");
//read the row of the selected client from database table 


$unique_id = "";
$name = "";
$offer = "";
$action = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {


$unique_id = $_POST["unique_id"];
$name       = $_POST["name"];
$offer      = $_POST["offer"];
$action = $_POST["action"];
$sql = "INSERT INTO `redeem` (`unique_id`,`name`,`offer`,`action`) VALUES ( '$unique_id','$name','$offer','$action')";
$result = $conn->query($sql);
}


$sql2 = "SELECT * FROM redeem ORDER BY id ASC";
$result2 = $conn->query($sql2);
if(!$result2) {
die("Invalid Query:" . $conn->error);
}

//read data of each row
while ($row = $result2->fetch_assoc()){
echo "
<tr>

<td data-label>$row[unique_id]</td>
<td>$row[name]</td>
<td>$row[offer]</td>
<td>$row[status]</td>

<td>
    <a class='btn btn-primary btn-sm' href='listadmin.php?id=$row[unique_id]'>Edit</a>
    <a class='btn btn-danger btn-sm' href='delete.php?id=$row[unique_id]'>Delete</a>
</td>
<tr>
";
}
?>

    </tbody>
</table>

</body>
</html>