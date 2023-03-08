<?php 
    include '../function/function.php';
    /* include 'sidebar.php'; */
    include 'header.php';
    
    if(isset($_GET['logout'])){
		unset($_SESSION['login']);
        session_destroy();
        header("location: ../../index.php");
        exit();
	}
    
    /* if(isset($_POST['submit'])){
        $response = applyLeave($_POST['reason'],$_POST['start_date'],$_POST['last_date'],@$_SESSION['user'],@$_POST['assigned_person']);
    } */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="../../views/css/view-project.css">
</head>
<body>
    <section>
        
        <div class="profile-container">
            
            <div class="page-content">
                <?php 
                    $mysqli = connect();
                    $user = $_SESSION['user'];
                 /*    $test = explode(',', $user_id['user_ids']); */
                    $sql = "SELECT * FROM project_list WHERE `id` = ?";
                                
                    $result = mysqli_query($mysqli, $sql);

                    if($result==TRUE):

                        $count_rows = mysqli_num_rows($result);

                        if($count_rows > 0):
                            
                            while($row = mysqli_fetch_assoc($result)):
                                
                                $id = $row['id'];
                                $name = $row['name'];
                                $description = $row['description'];
                                $status = $row['status'];
                                $start_date = $row['start_date'];
                                $end_date = $row['end_date'];
                                $manager_id = $row['manager_id'];
                                $user_id = $row['user_ids'];

                ?>
                <div class="heading">
                    <h1><?php echo $name; ?></h1>
                </div>
                <div class="container">
                    <div class="up-outer-container">
                        <div class="up-inner-left">
                            <h3>Description</h3>
                            <?php echo $description; ?>
                        </div>
                        <div class="up-inner-right">
                            <div>
                                <h3>Start Date</h3>
                                <?php echo $start_date ?>
                            </div>
                            <div>
                                <h3>End Date</h3>
                                <?php echo $end_date ?>
                            </div>
                            <div>
                                <h3>Status</h3>
                                <?php 
                                    if($status == '0'){
                                        $status = 'pending';
                                        echo $status;
                                    }elseif($status == '3'){
                                        $status == 'on hold';
                                        echo $status;
                                    }else{
                                        $status = 'Done';
                                        echo $status;
                                    }
                                ?>
                                <?php  ?>
                            </div>
                            <div>
                                <h3>Project Manager</h3>
                                <?php echo $manager_id ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile;
                endif;
            endif;
            ?>
            </div>
        </div>
    </section>
</body>