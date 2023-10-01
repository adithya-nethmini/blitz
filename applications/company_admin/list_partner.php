<?php
if(!isset($mysqli)){include 'connection.php';}
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
        <br /> <br /><br /> <br /><br /> <br />
                <div class="leave-container">

                    <div class="header">
                        <div class="topic"><h2>Partner Companies</h2></div>
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
            <th> Company Name</th>
            <th> Company Email</th>
            <th> Contact Number</th>
            <th> Address</th>
            <th> Industry</th>
            <th> Description</th>
            <th> Package Type</th>
            <!-- <th> Verification</th> -->
        </tr>
        <?php
$qry = "SELECT companyname,companyemail,pcompanycon,companyaddress,industry,description,package from partner_company";
$result = $mysqli->query($qry);

if (@$result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
            <tr>
                <td>' . $row['companyname'] . '</td>
                <td>' . $row['companyemail'] . '</td>
                <td>' . $row['pcompanycon'] . '</td>
                <td>' . $row['companyaddress'] . '</td>
                <td>' . $row['industry'] . '</td>
                <td>' . $row['description'] . '</td> 
                <td>' . $row['package'] . '</td> ';
               /*  echo ' <td><div class="checkbox">
                    /* <input type="checkbox" name="" onclick="handleCheckboxClick(this)"> */
                   /*  <div class="dropdown-content">
                        <a href="#">View</a>
                        <a href="#">Update</a>
                        <a href="#">Delete</a>
                    </div> 
                </div>
                </td>'; */

    }
}
else{
    echo mysqli_error($mysqli);
}
?>

<script>
function handleCheckboxClick(checkbox) {
  if (checkbox.checked) {
    if (!confirm("Are you sure you want to authenticate this company?")) {
      checkbox.checked = false;
      return;
    }

    // Retrieve the username and password from the partner_table.sql
    var username = ""; // Add code to retrieve the username
    var password = ""; // Add code to retrieve the password

    // Create an XMLHttpRequest object
    var xhttp = new XMLHttpRequest();

    // Define the AJAX request
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        // Request completed successfully
        console.log("Data inserted into login.sql");
      }
    };

    // Send the AJAX request to enable login
    xhttp.open("POST", "insert_login.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username=" + username + "&password=" + password);
  } else {
    if (!confirm("Are you sure you want to decline the access of this company?")) {
      checkbox.checked = true;
      return;
    }

    // Create an XMLHttpRequest object
    var xhttp = new XMLHttpRequest();

    // Define the AJAX request
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        // Request completed successfully
        console.log("Login disabled for this company");
      }
    };

    // Send the AJAX request to disable login
    xhttp.open("POST", "disable_login.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
  }
}

</script>

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
