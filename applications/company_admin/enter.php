<?php
if(!isset($mysqli)){include 'connection.php';}
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
if(isset($_POST['submit'])) {
    $employeeid = $_POST['employeeid'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $profilepic_m = $_POST['profilepic_m'];
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2= $_POST['password2'];


    $qry = "INSERT INTO `dept_head`(`employeeid`,`name`, `department`, `email`, `contactno`, `profilepic_m`,`username`,`password1`,`password2`) VALUES ('$task_assigned','$name','$department','$email','$contactno','$profilepic_m','$username','$password1','$password2')";
    if(mysqli_query($mysqli,$qry)){
        header('location:login.php');
    }
    else{
        echo mysqli_error($mysqli);
    }
}

?>

<!--<div class="col-lg-12">-->
<!--    <div class="card card-outline card-primary">-->
<!--        <div class="card-body">-->
<!--            <form action="" id="manage-project">-->
<!---->
<!--                <input type="hidden" name="id" value="--><?php //echo isset($id) ? $id : '' ?><!--">-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Name</label>-->
<!--                            <input type="text" class="form-control form-control-sm" name="name" value="--><?php //echo isset($name) ? $name : '' ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="">Status</label>-->
<!--                            <select name="status" id="status" class="custom-select custom-select-sm">-->
<!--                                <option value="0" --><?php //echo isset($status) && $status == 0 ? 'selected' : '' ?><!-->Pending</option>-->
<!--                                <option value="3" --><?php //echo isset($status) && $status == 3 ? 'selected' : '' ?><!-->On-Hold</option>-->
<!--                                <option value="5" --><?php //echo isset($status) && $status == 5 ? 'selected' : '' ?><!-->Done</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Start Date</label>-->
<!--                            <input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="--><?php //echo isset($start_date) ? date("Y-m-d",strtotime($start_date)) : '' ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">End Date</label>-->
<!--                            <input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" value="--><?php //echo isset($end_date) ? date("Y-m-d",strtotime($end_date)) : '' ?><!--">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    --><?php //if($_SESSION['login_type'] == 1 ): ?>
<!--                        <div class="col-md-6">-->
<!--                            <div class="form-group">-->
<!--                                <label for="" class="control-label">Project Manager</label>-->
<!--                                <select class="form-control form-control-sm select2" name="manager_id">-->
<!--                                    <option></option>-->
<!--                                    --><?php
//                                    $managers = $mysqli->query("SELECT *,concat(name,' ',jobrole) as name FROM employee order by concat(name,' ',jobrole) asc ");
//                                    while($row= $managers->fetch_assoc()):
//                                        ?>
<!--                                        <option value="--><?php //echo $row['id'] ?><!--" --><?php //echo isset($manager_id) && $manager_id == $row['id'] ? "selected" : '' ?><!-->--><?php //echo ucwords($row['name']) ?><!--</option>-->
<!--                                    --><?php //endwhile; ?>
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //else: ?>
<!--                        <input type="hidden" name="manager_id" value="--><?php //echo $_SESSION['login_id'] ?><!--">-->
<!--                    --><?php //endif; ?>
<!--                    <div class="col-md-6">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Project Team Members</label>-->
<!--                            <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">-->
<!--                                <option></option>-->
<!--                                --><?php
//                                $employees = $mysqli->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
//                                while($row= $employees->fetch_assoc()):
//                                    ?>
<!--                                    <option value="--><?php //echo $row['id'] ?><!--" --><?php //echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?><!-->--><?php //echo ucwords($row['name']) ?><!--</option>-->
<!--                                --><?php //endwhile; ?>
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                    <div class="col-md-10">-->
<!--                        <div class="form-group">-->
<!--                            <label for="" class="control-label">Description</label>-->
<!--                            <textarea name="description" id="" cols="30" rows="10" class="summernote form-control">-->
<!--						--><?php //echo isset($description) ? $description : '' ?>
<!--					</textarea>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--        <div class="card-footer border-top border-info">-->
<!--            <div class="d-flex w-100 justify-content-center align-items-center">-->
<!--                <button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-project">Save</button>-->
<!--                <button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=project_list'">Cancel</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<script>-->
<!--    $('#manage-project').submit(function(e){-->
<!--        e.preventDefault()-->
<!--        start_load()-->
<!--        $.ajax({-->
<!--            url:'ajax.php?action=save_project',-->
<!--            data: new FormData($(this)[0]),-->
<!--            cache: false,-->
<!--            contentType: false,-->
<!--            processData: false,-->
<!--            method: 'POST',-->
<!--            type: 'POST',-->
<!--            success:function(resp){-->
<!--                if(resp == 1){-->
<!--                    alert_toast('Data successfully saved',"success");-->
<!--                    setTimeout(function(){-->
<!--                        location.href = 'index.php?page=project_list'-->
<!--                    },2000)-->
<!--                }-->
<!--            }-->
<!--        })-->
<!--    })-->
<!--</script>-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project List</title>
    <link rel="stylesheet" href="newproject.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
</head>
<title>Blitz</title>
<body>
<h2>New Department Head</h2>
<form class="form-inline" action="" method="post" autocomplete="off">
    <label for="employeeid">Employee ID:</label>
    <input type="text" id="employeeid" placeholder="Enter Task Name" name="employeeid" required>
    <label for="name">Name:</label>
    <input type="text" id="name" placeholder="Enter Task Name" name="name" required>
    <label for="email">E mail:</label>
    <input type="email" id="email" placeholder="Enter Task Name" name="email" required>
    <label for="contactno">Contact Number:</label>
    <input type="text" id="contactno" placeholder="Enter Task Name" name="contactno" required>
    <label for="profile_m">Profile Picture:</label>
    <input type="" id="contactno" placeholder="Enter Task Name" name="profile_m" required>

   <div class="input-row">
    <label for="username">Username: </label>   
    <div class="inputerr">
    <div class="flexrow"> 
    <input type="text" name="username">  
    <span class="error">*  </span>  
    </div>
<div class="error">  <?php echo $usernameErr; ?> </div>  
</div>
   <br><br>
</div>
<div class="input-row">
    <label>Enter Password: </label> 
    <div class="inputerr">
    <div class="flexrow"> 
    <input type="password" name="password_1">
    <div class="error">* </div>
</div>
<div class="error"> <?php echo $pwderr; ?></div> 
</div> 
<br /> <br />
</div>
<div class="input-row">
    <label>Confirm Password: </label> 
    <div class="inputerr">
    <div class="flexrow"> 
    <input type="password" name="password_2">
    <div class="error">* </div>
</div>
<div class="error"> <?php echo $confirmpwd;?> </div>
    </div> 
    <br /> 
 </div>  
                    
 <?php
    include("connection.php");
//read the row of the selected client from database table 


$employeeid = "";
$name = "";
$admin_type = "";
$email = "";
$contactno = "";
$username = "";
$password = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {


$employeeid = $_POST["employeeid"];
$name       = $_POST["name"];
$admin_type = $_POST["admin_type"];
$email      = $_POST["email"];
$contactno  = $_POST["contactno"];
$username   = $_POST["username"];
$password_1   = $_POST["password_1"];
$password_2   = $_POST["password_2"];
if($password_1 == $password_2){
$sql = "INSERT INTO `c_admins` (`employeeid`,`name`,`admin_type`,`email`,`contactno`,`username`,`password`) VALUES ( '$employeeid','$name','$admin_type','$email','$contactno','$username','$password_1')";
$result = $conn->query($sql);
}

}

$sql2 = "SELECT * FROM dept_head ORDER BY id ASC";
$result2 = $conn->query($sql2);
if(!$result2) {
die("Invalid Query:" . $conn->error);
}

//read data of each row
while ($row = $result2->fetch_assoc()){
echo "
<tr>

<td data-label>$row[employeeid]</td>
<td>$row[name]</td>
<td>$row[admin_type]</td>
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
    <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><b>Save</b></button>
            <button class="inner2" type="submit" name="submit1"><b>Cancel</b></button>
        </div>
    </div>
</form>
</body>
