<?php
if (!isset($mysqli)) {
    include '../function/function.php';
}
include 'sidebar.php';
include 'header.php';
$mysqli = connect();
$user = $_SESSION['user'];


?>
<html>

<head>
    <link rel="stylesheet" href="../partner_company/css/style.css">
</head>
<style>
    .page-content{
    display: flex;
    flex-direction: column;
    margin-left: 300px;
}
</style>

<body>
<div class="promo-grid">
    <h2>Loyalty Offers</h2>

    <div class="page-content">
    <div class="flex grid-container">
      <?php
      $sql = "SELECT partner_company.companyname, partner_company.pcompany_pic, offers.offer_cover, offers.type, offers.name, offers.end_date, offers.amount, offers.offer_code, offers.id
        FROM offers 
        JOIN partner_company ON offers.username = partner_company.username ";
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
        <img src="../partner_company/'.$offer_cover.'" alt="cover photo">
      </div>
      <ul>
        <li><b>'.$offer_name.'</b></li>
        <li style="font-size:8px"><a href="../employee/partner-page.php">by <b>'.$companyname.'</b></a></li>
        <li>Valid until: '.$offer_date.'</li>
        <li>Use code '.$offer_code.'</li>
        <li>Save '.$amount.'/=</li>
      </ul>
    </div>
  </div>';
// select all users from employee

        }        }?>
    </div>
</body>
<?php
/*add data offer table*/

?>
</html>