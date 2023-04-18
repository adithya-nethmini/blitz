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
    <title>QR Code</title>
    <link rel="stylesheet" href="../../views/css/qr.css">
    <link rel="stylesheet" href="../../views/css/header.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <section>
        <div class="profile-container">
            
        <div class="page-content">
            
        <?php
            $mysqli = connect();
            $user = $_SESSION['user'];
            $sql = ("SELECT employeeid,name,qr FROM employee WHERE username = '$user' ") ;

            $result = mysqli_query($mysqli, $sql);

            if($result==TRUE):

                $count_rows = mysqli_num_rows($result);

                if($count_rows > 0):
                    while($row = mysqli_fetch_assoc($result)):
                        $employeeid = $row['employeeid'];
                        $name = $row['name'];
                        $qr = $row['qr'];

        ?>
                        <table>
                        <tr>
                            <td>
                                <h2>QR Code</h2>
                            </td>
                        </tr>
                        <tr>                            
                            <td>
                                <img class="QR" src="<?php echo $qr ?>" alt="qr"> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $employeeid ?>
                                <?php echo $name ?>
                            </td>
                        </tr>
                        
                            <tr>
                                <td>
                                    <a download="<?php echo $qr; ?>" href="<?php echo $qr ?>" class="download-qr-btn"><i class="fa-solid fa-download"></i>&nbsp;Download</a>
                                </td>
                            </tr>
                        </table>
                        <?php endwhile ?>
                        
                        <?php else: ?>
                            <div>No data is found</div>
                            <?php endif ?>
                            
                            <?php endif ?>
        </div>

        </div>
    

    </section>
    
</body>
<script src="../../views/js/main.js"></script>
</html>