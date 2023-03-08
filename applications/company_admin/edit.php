<?php

$id = "";
$employeeid = "";
$name = "";
$admin_type = "";
$email = "";
$contactno = "";
$username = "";
$password = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
    //GET method: Show thw data of the admin
  
    if( !isset($_GET["id"]) ) {
     header("localhost:add.php");
     exit;
    }
  
    $id = $_GET["id"];
  
    //read the row of the selected client from database table 
    $sql = "SELECT * FROM c_admins WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location:add.php");
        exit;
      }
      $id         = $row["id"];
      $employeeid = $row["employeeid"];
      $name       = $row["name"];
      $admin_type = $row["admin_type"];
      $email      = $row["email"];
      $contactno  = $row["contactno"];
      $username   = $row["username"];
      $password   = $row["password"];
    }
    else {
      //Post method: Update the data of the client
    
      $id         = $POST["id"];
      $employeeid = $POST["employeeid"];
      $name       = $POST["name"];
      $admin_type = $POST["admin_type"];
      $email      = $POST["email"];
      $contactno  = $POST["contactno"];
      $username   = $POST["username"];
      $password   = $POST["password"];
    
    
      do {
        if (empty($id) || empty($employeeid) || empty($name) || empty($admin_type) || empty($email) || empty($contactno) || empty($username) || empty($password))
      {
        $errorMessage = "All the fields are required!";
        break;
    }

    $sql = "UPDATE c_admins" .
    "SET employeeid = '$employeeid',name='$name', admin_type='$admin_type', email = '$email', contactno = '$contactno', username = '$username', password = '$password' " .
  "WHERE id = $id";

  $result = $connection->query($sql);

  if (!$result) {
    $errorMessage = "Invalid Query:" . $connection->error;
    break;
  }

  $successMessage ="Client Updated Successfully";
  header("location:add.php");
  exit;

}while(false);

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style2.css">
    <script src=https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js>
  </head>
<body>
<div class="container my-5">
<h2> New Admin </h2>
<?php 
    if (!empty($errorMessage)) {
      echo "
      <div class='alert alert-warning alert-dismissible fade show' role='alert'>
      <strong>$errorMessage</strong>
      <button type='button' class='btn-close'data-bs-dismiss='alert' aria-label='Close'></button>
      </div>
      ";
    }
    ?>
    <form method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">ID</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="id" value="">
</div>
</div>
<div class="row mb-3">
        <label class="col-sm-3 col-form-label">Employee ID</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="employeeid" value="<?php echo $employeeid;?>">
</div>
</div>
<div class="row mb-3">
        <label class="col-sm-3 col-form-label"> Name </label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="name" value="<?php echo $name;?>">
</div>
</div>

<div class="row mb-3">
        <label class="col-sm-3 col-form-label">Admin Type</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="admin_type" value="<?php echo $admin_type;?>">
</div>
</div>

<div class="row mb-3">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="email" value="<?php echo $email;?>">
</div>
</div>

<div class="row mb-3">
        <label class="col-sm-3 col-form-label">Contact Number</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="contactno" value="<?php echo $contactno;?>">
</div>
</div>
<div class="row mb-3">
        <label class="col-sm-3 col-form-label">User Name</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="username" value="<?php echo $username;?>">
</div>
</div>
<div class="row mb-3">
        <label class="col-sm-3 col-form-label">Password</label>
        <div class="col-sm-6">
        <input type="text" class="form-control" id="password" value="<?php echo $password;?>">
</div>
</div>

<?php
if(!empty($successMessage)) {
  echo"
  <div class='row mb-3'>
    <div class='offset-sm-3 col-sm-6'>
      <div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>$successMessage</strong>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>
    </div>
  </div>
    ";
}

?>

<div class="row mb-3">
  <div class="offset-sm-3 col-sm-3 d-grid">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
<div class="col-sm-3 d-grid">
  <a class="btn btn-outline-primary" href="add.php" role="button">Cancel</button>
</div>
</div>
</form>
</div>
</form>
</body>
</html>