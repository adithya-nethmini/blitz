<?php
include 'function.php';
include 'header.php';
include 'sidebar.php';
$mysqli = connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Blitzs</title>
</head>
<body>
<section>
  <?php
  $pcompany_user = $_SESSION['pcompany_user'];
  $sql = "SELECT * from partner_company WHERE partner_company.username ='{$pcompany_user}'";
  $result = $mysqli->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $username = $row['username'];
      echo '<div class="page-content">
                <div class="addbuttons">
                    <a href="add-offer.php"><button type="button">Add Offers</button></a>
                    <a href="add-promo.php"><button type="button">Add Promotions</button></a>
                </div>';
    }
  }
  ?>

  <div class="promo-grid">
    <h2>Published Offers</h2>
    <div class="flex grid-container">
      <?php
      $sql = "SELECT partner_company.companyname, partner_company.pcompany_pic, offers.offer_cover, offers.type, offers.name, offers.end_date, offers.amount, offers.offer_code, offers.id
        FROM offers 
        JOIN partner_company ON offers.username = partner_company.username
        WHERE partner_company.username = '{$pcompany_user}'";
      $result = mysqli_query($mysqli, $sql);

      if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
          $offer_id = $row['id'];
          $offer_cover = $row['offer_cover'];
          $offer_name = $row['name'];
          $offertype = $row['type'];
          $companyname = $row['companyname'];
          $offer_date = $row['end_date'];
          $amount = $row['amount'];
          $offer_code = $row['offer_code'];
          $pcompany_pic = $row['pcompany_pic'];

          echo '
            <div style="padding: 20px;">
              <div class="promo">
                <div class="image-container"> 
                  <img src="'.$offer_cover.'" alt="cover photo">
                </div>
                <ul>
                  <li><b>'.$offer_name.'</b></li>
                  <li style="font-size:8px"><a href="../employee/partner-page.php">by <b>'.$companyname.'</b></a></li>
                  <li>Valid until: '.$offer_date.'</li>
                  <li>Use code '.$offer_code.'</li>
                  <li>Save '.$amount.'/=</li>
                </ul>
                <div class="offer-actions">
                  <a href="update-offer.php?id='.$offer_id.'"><button type="button">Edit</button></a>
                  <a href="delete-offer.php?id='.$offer_id.'"><button type="button">Delete</button></a>
                </div>
                
              </div>
            </div>';
        }
      }
      ?>
    </div>
  </div>

  <br><br>

  <div class="promo-grid">
    <h2>Published Promotions</h2>
    <div class="flex grid-container">
      <?php
      $sql = "SELECT partner_company.companyname, partner_company.pcompany_pic, promotions.type, promotions.name, promotions.end_date, promotions.description, promotions.promotion_cover 
      FROM promotions 
      JOIN partner_company ON promotions.username = partner_company.username
      WHERE partner_company.username = '{$pcompany_user}'";
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
                <li style="font-size:8px"><a href="../employee/partner-page.php">by <b>'.$companyname.'</b></a></li>
                <li>Valid until: '.$end_date.'</li>
                <li>Use code '.$description.'</li>
              </ul>
            </div>
          </div>';
      }
    }
    ?>
  </div>
</div>
</div>
<script>
    function showDeletePopup(offerId) {
      const deletePopup = document.getElementById('deletePopup');
      deletePopup.style.display = 'flex';
      deletePopup.dataset.offerId = offerId;
    }

    function hideDeletePopup() {
      const deletePopup = document.getElementById('deletePopup');
      deletePopup.style.display = 'none';
      deletePopup.dataset.offerId = '';
    }

    function deleteOffer() {
      const offerId = document.getElementById('deletePopup').dataset.offerId;
      if (offerId) {
        window.location.href = 'delete-offer.php?id=' + offerId;
      }
    }
  </script>
</section>
</body>
</html>


