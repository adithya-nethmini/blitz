<?php

if (isset($_GET ["id"])) {
    $id = $_GET["id"];

$servername = "localhost";
$username = "root";
$password = "";
$database = "blitz";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);


    //read the row of the selected client from database table 
    $sql = "DELETE FROM c_admins WHERE id=$id";
    $connection->query($sql);
}

header ("location:listadmin.php");
exit;
?>