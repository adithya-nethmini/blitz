<?php
include("connection.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style2.css">

<img src="logo.png" alt="">  
 <form method="POST" action="add.php" class="box">  
 <div class="header">  
  <p>Add Admin/KPI Manager</p>  
 </div>  
  
<div class="tbl">
<table>
  <div class="input-group">  
 <tr>
  <td> <label for="employeeid" class="text-info">Employee ID:</label> </td>
 <td><input type="text" name="employeeid" id="employeeid" class="form-control"> </td>
</tr>
      </div> 
      <div class="input-group">  
  <tr>
  <td> <label for="name" class="text-info">Name:</label> </td>
  <td><input type="text" name="name" id="name" class="form-control"> </td>
      
</tr>
</div> 
      <div class="input-group">  
<tr> <td>   <label>Admin type</label>  </td>
<td>   <select name="admin_type" id="admin_type" >  
    <option value=""></option>  
    <option value="admin">Admin</option>  
    <option value="KPI_Manager">KPI Manager</option>  
   </select>  
</td>
   <br />  
   <br /> 
</tr>
</div> 
   <div class="input-group">  
  <tr><td> <label for="name" class="text-info">Name:</label> </td>
  <td><input type="email" name="email" id="email" class="form-control"> </td>
</tr>
  </div>  
   
  <div class="input-group">  
  <tr><td><label for="lname" class="text-info">Contact Number:</label></td>
    <td>  <input type="text" name="contactno" id="contactno" class="form-control"> </td>
      </div> 

  <div class="input-group">  
  <tr><td> <label>Username</label>  </td>
  <td>  <input type="text" name="username">  </td>
</tr>
  </div>  
 
  
  </div>  
  <div class="input-group">  
  <tr><td>
   <label>Password</label>  </td>
  <td> <input type="password" name="password_1">  </td>
</tr>
  </div>  
  <div class="input-group">  
  <tr><td> <label>Confirm password</label>  </td>
  <td> <input type="password" name="password_2">  </td>
</tr>
  </div>  
  <div class="input-group">  
  <tr><td colspan=2> <button type="submit" class="btn" name="register_btn"> + Create Admin</button></td>  </tr>
  </div> 
</table>
</div>
 
 </form> 
    
</body>  
</html>



</body>

</html>

