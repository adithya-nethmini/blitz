<?php

include 'connect.php';
include 'header.php';
include 'function.php';
$mysqli = connect();

// Get the submitted reply data
$feedbackId = $_POST['feedback_id'];
$reply = $_POST['reply'];

// Update the feedback with the reply in the database
$result = updateFeedbackReply($mysqli, $feedbackId, $reply);

if ($result) {
    echo "Reply submitted successfully!";
} else {
    echo "Error submitting reply.";
}

// Close the database connection
$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/partner-feed.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    
    <title>Blitz</title>
</head>
<body>
    <div class="page-content">
        <div class="cover-container">
            <img src="images/cover1.png" alt="Company cover photo">
        </div>
    <div class="profile-heading">
            <img src="images/keels.png" alt="partner company logo">
            <h3>Keels Super</h3>
        </div>
    </div>
    <div class="promo-grid">
        <h2>Published Offers</h2>
<div class="flex grid-container">
        <?php

$sql="SELECT partner_company.companyname, partner_company.pcompany_pic, offers.offer_cover, offers.type, offers.name, offers.end_date, offers.amount FROM offers JOIN partner_company ON offers.username = partner_company.username";
// $stmt->bind_param("s", $pcompany_user);
$result=mysqli_query($con,$sql);
print_r($result);
die();


if($result){
  while($row=mysqli_fetch_assoc($result))
  
{
      $offer_cover=$row['offer_cover'];
      $name=$row['name'];
      $date=$row['date'];
      $description=$row['description'];
      $promotion_cover=$row['promotion_cover'];

        echo 
        '<div style="padding: 20px;">
        <div class="promo">
                <div class="image-container"> 
                    <img src='.$offer_cover.' alt="cover photo">
                </div>
                    <ul>
                    <li><b>'.$companyname.'</b></li>
                        <li>'.$pcompany_pic.' offer</li>
                        <li><b>'.$offer_name.'</b></li>
                        <li>'.$offertype.' offer</li>
                        <li>Valid until: '.$offer_date.'</li>
                        <li>Save '.$amount.'/=</li>
                    </ul>
        
        </div></div>';
     
      
    }}
    

?>  
</div>  
</div>
 <br><br>
           

<div class="promo-grid">
<h2>Published Promotions</h2>
<div class="flex grid-container">
<?php

$sql="SELECT type,name, date, description, promotion_cover FROM promotions";
$result=mysqli_query($con,$sql);

if($result){
    while($row=mysqli_fetch_assoc($result))
    
{
        $type=$row['type'];
        $name=$row['name'];
        $date=$row['date'];
        $description=$row['description'];
        $promotion_cover=$row['promotion_cover'];


echo '<div style="padding:20px">
    <div class="promo">
        <div class="image-container"> 
            <img src='.$promotion_cover.' alt="cover photo">
        </div>
            <ul>
                <li><b>'.$name.'</b></li>
                <li>Valid until:'.$date.'</li>
                <li>'.$type.'</li>
                <li>'.$description.'</li>
            </ul>

      </div>
      </div>';
    }
}
?>  

</div>      
</div>        

 
<section>
    <h2>Feedbacks</h2>
    <?php
    // Retrieve feedbacks for the partner company
    $partnerCompanyId = $_SESSION['pcompany_user'];
    $feedbacks = getFeedbacksByPartnerCompanyId($mysqli, $partnerCompanyId);

    if (!empty($feedbacks)) {
        foreach ($feedbacks as $feedback) {
            $feedbackId = $feedback['id'];
            $employeeName = $feedback['name'];
            $rating = $feedback['rating'];
            $comment = $feedback['comment'];
            $reply = $feedback['reply'];

            echo '<div class="feedback">';
            echo '<p><b>' . $employeeName . '</b></p>';
            echo '<p>Rating: ' . $rating . '/5</p>';
            echo '<p>Comment: ' . $comment . '</p>';
            echo '<p>Reply: ' . $reply . '</p>';

            // Display reply form only if there is no existing reply
            if (empty($reply)) {
                echo '<form action="submit_reply.php" method="POST">';         
                echo '<input type="hidden" name="feedback_id" value="' . $feedbackId . '">';
                echo '<label for="reply">Reply:</label>';
                echo '<textarea name="reply" id="reply" rows="3" cols="30"></textarea>';
                echo '<input type="submit" value="Submit Reply">';
                echo '</form>';
            }

            echo '</div>';
        }
    } else {
        echo '<p>No feedbacks available.</p>';
    }
    ?>
</section>

