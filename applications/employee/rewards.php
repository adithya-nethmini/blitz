<?php 
include '../function/function.php';
include 'sidebar.php'; 
include '../../header.php';
    
    if(isset($_GET['logout'])){
		unset($_SESSION['login']);
        session_destroy();
        header("location: ../../index.php");
        exit();
	}

    $mysqli = connect();
    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="../../views/css/rewards.css">
    <link rel="stylesheet" href="../../views/css/header.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://kit.fontawesome.com/ec92a4cabd.css" crossorigin="anonymous">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=63e48b94b2f3620019abbb23&product=sticky-share-buttons&source=platform" async="async"></script>
    <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
<script type="IN/Share"></script>
</head>
<body onload="autoClick();">
<!-- <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v16.0" nonce="uCl9kiN5"></script>
 -->
    <section>
        <div class="profile-container">
        <?php
                    
            $mysqli = connect();
            $user = $_SESSION['user'];
            $sql = ("SELECT loyalty_eligibility FROM employee WHERE username = '$user'") ;

            $result = mysqli_query($mysqli, $sql);

            if($result==TRUE):

                $count_rows = mysqli_num_rows($result);

                if($count_rows > 0):
                    while($row = mysqli_fetch_assoc($result)):
                        
                        $loyalty_eligibility = $row['loyalty_eligibility'];
                        
                ?>
                <?php if($loyalty_eligibility == 'Yes'): ?>
            <div class="page-content-left">
                   
                <?php
                    $mysqli = connect();
                    $user = $_SESSION['user'];
                    $sql = ("SELECT * FROM loyalty WHERE username = '$user'") ;
        
                    $result = mysqli_query($mysqli, $sql);
        
                    if($result==TRUE):
        
                        $count_rows = mysqli_num_rows($result);
        
                        if($count_rows > 0):
                            while($row = mysqli_fetch_assoc($result)):
                                
                                $id = $row['id'];
                                $unique_Id = $row['unique_Id'];
                                $loyalty_type = $row['loyalty_type'];
                                $username = $row['username'];
                                $month = $row['month'];
                                
                 ?>
                <div id="container" class="container">
                    <?php if($loyalty_type == 'Gold'): ?>
                        <img src="../../views/images/gold-trophy.png" alt="">
                    <?php elseif($loyalty_type == 'Silver'): ?>
                        <img src="../../views/images/silver-trophy.png" alt="">
                    <?php else: ?>
                        <img src="../../views/images/platinum-trophy.png" alt="">
                    <?php endif ?>
                    <h2>Congratulations <?php echo $user; ?>!</h2>
                    <h3>You are a <?php echo $loyalty_type; ?> Loyalty User of Month <?php echo date("F", strtotime($month)); ?></h3>
                    <h5>We appreciate your contribution</h5>
                </div>
                <br>
                <div class="card"><?php echo $unique_Id ?>
                    </h3>
                    <h5>Use this Id to redeem your offers</h5>
                </div>
                <br><br><br>
                <div class="bottom">
                    <div>
                        <a id="download" class="download-post-btn"><i class="fa-solid fa-download"></i>&nbsp;Download</a> 
                    </div>
                    <!-- <div class="popup" onclick="myFunction()"> -->
                    <!-- <a class="popup download-post-btn" onclick="myFunction()"><i class="fa-solid fa-share-from-square"></i>Share
                        <span class="popuptext" id="myPopup">Share
                        <button class="fab fa-whatsapp" 
                                            onclick="whatsapp()">
                                            Share on Whatsapp
                        </button>
                    </a> -->
                    <!-- <a id="download" class="download-post-btn" ><i class="fa-solid fa-share-from-square"></i>&nbsp;Share</a> -->
                    <!-- <a id="download" class="download-post-btn"><i class="fa-solid fa-share-from-square"></i>Share
                    <span class="popuptext" id="myPopup">
                    <button class="whatsapp" onclick="whatsapp()" title="Share on WhatsApp"><i class="fa fa-whatsapp" aria-hidden="true"></i></button>
                    <button class="facebook" onclick="facebook()" title="Share on Facebook"><i class="fa-brands fa-facebook"></i></button>
                    <button class="twitter" onclick="twitter()" title="Share on Twitter"><i class="fa-brands fa-twitter"></i></button>
                    <button class="email" onclick="email()" title="Send via mail"><i class="fa-solid fa-envelope"></i></button>
                    <button class="linkedin" onclick="linkedin()" title="Share on LinkedIn"><i class="fa-brands fa-linkedin"></i></button>
                    </span>
                    </a> 
                </div>-->
                </div>

            </div>
            <div class="page-content-right">
                <div>
                    <?php if($loyalty_type == 'Gold'): ?>
                        <a href="#">Gold&nbsp;User&nbsp;Offers&nbsp;<i class="fa-solid fa-angles-right"></i>&nbsp;</a> 
                    <?php elseif($loyalty_type == 'Silver'): ?>
                        <a href="#">Silver&nbsp;User&nbsp;Offers&nbsp;<i class="fa-solid fa-angles-right"></i>&nbsp;</a> 
                    <?php else: ?>
                        <a href="#">Platinum&nbsp;User&nbsp;Offers&nbsp;<i class="fa-solid fa-angles-right"></i>&nbsp;</a> 
                    <?php endif ?>
                </div>
            </div>
            <?php 
                endwhile;
            endif;
            endif;
            ?>
            <?php else: ?>
                <div class="page-content-left">
                
                
                <div class="container">
                    <img src="../../views/images/sorry.png" alt="">
                    <h2>Sorry!</h2>
                    <h3>You are not a Loyalty User of Month <?php /* echo date("jS F", strtotime($$month)); */ ?></h3>
                </div>
                    <?php endif ?>
                     <?php endwhile ?>
                    <?php endif ?>
                    <?php endif ?>
            </div>
        </div>    

    </section>
    
</body>
<script src="../../views/js/main.js"></script>
<script type="text/javascript">
      function autoClick(){
        $("#download").click();
      }

      $(document).ready(function(){
        var element = $("#container");

        $("#download").on('click', function(){

          html2canvas(element, {
            onrendered: function(canvas) {
              var imageData = canvas.toDataURL("image/jpg");
              var newData = imageData.replace(/^data:image\/jpg/, "data:application/octet-stream");
              $("#download").attr("download", "image.jpg").attr("href", newData);
            }
          });

        });
      });
    </script>
    <script type="text/javascript">
        function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
function whatsapp() {
        window.open
('whatsapp://send?text=Hello')
    }
    function facebook(){
        window.open("https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"
)
    }
    function twitter(){
        window.open("https://twitter.com/compose/tweet");
    }
    function email(){
        window.open("mailto:");
    }
    function linkedin(){
        window.open("https://www.linkedin.com/");
    }
</script>
</html>

<?php

