<?php

  include "applications/function/function.php";
  include 'header.php';

// if(isset($_GET['logout'])){
//   unset($_SESSION['login']);
//   session_destroy();
//   /* $index = $_SERVER['REQUEST_URI']; */
//   header("location: landingpage.php");
//   exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/index.css">

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <style>
      ::placeholder{
        color: #ffffff94;
        font-size: 18px;
      }
    </style>
  </head>
<body>



 <!-- ?php endif ? -->

 <div class="div-feedback">
   <a href="applications/employee/feedback_form.php"><button class="feedback-button" title="Submit your feedbacks">Feedback</button></a>
 </div>
 
 <section id="section-landing-2">
  
 <!-- ?php if (isset($_SESSION['user'])) : ? -->
  <div class="div-loyalty">
    <h2>Best Performers of the Month</h2>
    <table>
      <tr>
        <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/jessica.jpg" alt=""></td><a href="applications/partner_company/images/"></a>
        <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/emp2.png" alt=""></td>
        <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/emp3.png" alt=""></td>
        <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/emp4.png" alt=""></td>
        <td><img style="border-radius: 50%;transform:scale(0.5)" src="applications/partner_company/images/emp6.jpg" alt=""></td>
      </tr>
      <tr class="rrr">
        <td>Anne Jessica Fernando</td>
        <td>Penelope Hartley F'do</td>
        <td>Tina Catalina Rose</td>
        <td>Francis Safwan Mcleod</td>
        <td>Todd Sebastian O'Brien</td>
      </tr>
    </table>
  </div>
 <!-- ?php endif ? -->
    
  </div>
</section>   
<section id="section-landing-1">
  <div style="padding: 40px 50px;">
    <div class="search-div">
      <a href=""><i class="fa fa-sliders" aria-hidden="true"></i></a>
      <input class="search-input" type="text" name="search" required placeholder="Search">
      <a href=""><i class='fa fa-search'></i></a>
    </div>
  </div>
</section>       
  
  <div class="promo-grid">
        <h2>Trending Offers</h2>
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
        '<a href="applications/employee/partner-feed.php"><div style="padding: 20px;">
        <div class="promo">
                <div class="image-container"> 
                    <img src=applications/partner_company/'.$offer_cover.' alt="cover photo">
                </div>
                    <ul>
                        <li><b>'.$offer_name.'</b></li>
                        <li>'.$offertype.' offer</li>
                        <li>Valid until: '.$offer_date.'</li>
                        <li>Save '.$amount.'/=</li>
                    </ul>
        
        </div></div></a>';
     
      
    }}
    

?>  
</div>  
</div>
 <br>
           

<div class="promo-grid">
<h2>Promotions</h2>
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


echo '<a href="applications/employee/partner-feed.php"><div style="padding:20px">
    <div class="promo">
        <div class="image-container"> 
            <img src=applications/partner_company/'.$promotion_cover.' alt="cover photo">
        </div>
            <ul>
                <li><b>'.$name.'</b></li>
                <li>Valid until:'.$date.'</li>
                <li>'.$type.'</li>
                <li>'.$description.'</li>
            </ul>

      </div>
      </div></a>';
    }
}
?>  
</div>    
<!-- <a href="applications/partner_company/partner-feed.php"></a>
 -->


</body>

<script src="views/js/main.js"></script>

</html>