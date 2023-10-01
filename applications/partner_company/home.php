<?php
   // include 'header.php'; 
    include 'function.php';
    $mysqli = connect();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Blitz</title>
</head>
<body>
<section>



  <br><br>

  <div class="promo-grid" style="margin-left:-125px">
    <h2>Published Promotions</h2>
    <div class="flex grid-container">
      <?php
      $sql = "SELECT partner_company.companyname, partner_company.pcompany_pic, promotions.type, promotions.name, promotions.end_date, promotions.description, promotions.promotion_cover 
      FROM promotions 
      JOIN partner_company ON promotions.username = partner_company.username";
    $result = mysqli_query($mysqli, $sql);

    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        $type = $row['type'];
        $name = $row['name'];
        $end_date = $row['end_date'];
        $description = $row['description'];
        $promotion_cover = $row['promotion_cover'];
        $companyname = $row['companyname'];
        $pcompany_pic = $row['pcompany_pic'];

        echo '
          <div style="padding: 20px;">
            <div class="promo">
              <div class="image-container"> 
                <img src="'.$promotion_cover.'" alt="cover photo">
              </div>
              <ul>
                <li><b>'.$name.'</b></li>
                <li style="font-size:8px"><a href="../partner_company/partner-page.php">by <b>'.$companyname.'</b></a></li>
                <li>Valid until: '.$end_date.'</li>
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
</div>      
    </div>        
            
    </div>
    </section>
</body>
</html>