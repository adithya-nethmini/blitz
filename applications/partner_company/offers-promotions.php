<?php

include 'connect.php';
include 'header.php';
include 'sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Offers & Promotions</title>
</head>
<body>
    
<section>

    <div class="page-content">
        <div class="addbuttons">
            <a href ="add-offer.php"><button type="button" >Add Offers</button></a>
            <a href ="add-promo.php"><button type="button">Add Promotions</button></a>
        </div>
        
 
        <div class="promo-grid">
        <h2>Published Offers</h2>
<div class="flex grid-container">
        <?php

$sql="SELECT offer_cover,type, name, date, amount FROM offers";
$result=mysqli_query($con,$sql);

if($result){
    while($row=mysqli_fetch_assoc($result))
    
{
        $offer_cover=$row['offer_cover'];
        $offertype=$row['type'];
        $offer_name=$row['name'];
        $offer_date=$row['date'];
        $amount=$row['amount'];

        echo 
        '<div style="padding: 20px;">
        <div class="promo">
                <div class="image-container"> 
                    <img src='.$offer_cover.' alt="cover photo">
                </div>
                    <ul>
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
            
    </div>
    </section>
</body>
</html>