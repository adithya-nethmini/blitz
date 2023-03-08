<?php
    include '../function/function.php';
    include 'sidebar.php';
    include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="notification.css">
</head>
<body>
    <div class="page-content">
        <h2><i class="far fa-bell"></i>&nbsp;Notifications</h2>

        <?php
            $mysqli = connect();
            
            $sql = ("SELECT id,notification_description,notification_type,username,date_time,status FROM notification WHERE status = 'unseen' AND notification_type = '3'");

            $result = mysqli_query($mysqli, $sql);

            if($result==TRUE):

                $count_rows = mysqli_num_rows($result);

                if($count_rows > 0):
                    $i = 1;
                    while($row = mysqli_fetch_assoc($result)):
                       
                        $id = $row['id'];
                        $notification_description = $row['notification_description'];
                        $notification_type = $row['notification_type'];
                        $username = $row['username'];
                        $date_time = $row['date_time'];
                        $status = $row['status'];
        ?>
        
            <?php if($notification_type == '1'){
                $notification_type = 'Employee';
            }elseif($notification_type == '2'){
                $notification_type = 'Partner Company';
            }elseif($notification_type == '3'){
                $notification_type = 'Department Head';
            }elseif($notification_type == '4'){
                $notification_type = 'Company Admin';
            }else{
                $notification_type = 'System';
            }
            ?>
            
            <div class="card">
                <div class="container">
                    <h3><?php $i;$i++; ?></h3>
                    <h4><?php echo $username .' ' . $notification_description; ?></h4>
                    <h5><?php echo $date_time ?></h5>     
                    <h5><a href="accept-leave?id=<?php echo $id; ?>"><button class="btn-task-accept">Accept</button></a></h5>               
                </div>
            </div>

            <?php endwhile ?>

            <?php else: ?>


                Caught up all notifications


            <?php endif ?>

            <?php endif ?>  

                            
    </div>
</body>
</html>