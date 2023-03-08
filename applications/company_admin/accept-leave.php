<?php 
    
   echo $id = $_GET["id"];

   include 'function.php';
   $mysqli = connect();
   $sql = "UPDATE e_leave SET status = 'Accepted' WHERE id = '$id' ";
   $result = mysqli_query($mysqli , $sql);
   if($result){
       header("Location: manage-leave.php?accept-successfuly");
   }

?>