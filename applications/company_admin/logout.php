<?php
session_start();
session_destroy();
// echo "<script> </script>";
header("location:start.php"); 
//to redirect back to "start.php" after logging out
exit();
?>