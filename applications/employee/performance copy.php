<?php 
include '../function/function.php';
include 'sidebar.php';
include 'header.php';
    
    if(!isset($_SESSION["user"])){
        header("location: login.php");

        exit();
    }

    if(isset($_GET['logout'])){
		unset($_SESSION['login']);
        session_destroy();
        header("location: ../../index.php");
        exit();
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance</title>
    <link rel="stylesheet" href="../../views/css/performance.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

    <section>
        <div class="profile-container">
            
            <div class="page-content">

                <div class="container">
                    
                    <div>
                        <div>
                            <h1>Performances Tracker</h1>
                        </div>
                        <div class="div-performance-tbl">
                            <table class="performance-tbl">
                                <tr class="performance-tr-heading">
                                    <th>Month</th>
                                    <th>Completed Projects</th>
                                    <th>Completed Tasks</th>
                                    <th>Progress</th>
                                </tr>
                                <tr>
                                    <td>February</td>
                                    <td>5</td>
                                    <td>10</td>
                                    <td>50%</td>
                                </tr>
                            </table>
                        </div>
                        <div style="padding-bottom: 50px;">
                            <button class="get-pdf-btn" onclick="QR()">Get pdf</button>
                        </div>
                        <div id="div-pdf" style="display: none;float:right">
                            <img style="width:auto;height:200px;padding-bottom:10px;float:right" src="../../views/images/pdf.png" alt="">
                            <br><button class="download-pdf-btn">Download</button>
                        </div>
                    </div>                     
                
                </div>

            </div>
        </div>

    </section>
    
</body>
<script src="../../views/js/main.js"></script>

</html>