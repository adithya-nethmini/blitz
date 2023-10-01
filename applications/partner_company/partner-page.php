<?php
//include 'header.php';
include 'function.php'; 
$mysqli = connect();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/partner-page.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    
    <title>Blitz</title>
</head>
<body>
<section>
        <div class="cover-container">
            <img src="../partner_company/images/cover1.png" alt="Company cover photo">
        </div>
        <div class="profile-heading">
        <?php
                $mysqli = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);
                $user = $_SESSION['pcompany_user'];
                $sql = ("SELECT pcompany_pic FROM partner_company WHERE username = '$user'");
                    //$mysqli=connect();
                    $username = $_SESSION['pcompany_user'];
                    $details = getPartnerCompanyDetails($mysqli, $username);
                    $pcompany_pic = $details['pcompany_pic'];
                    $companyName = $details['companyname'];
                    
                    if ($pcompany_pic) {
                        echo '<a href="partner-profile"><img src=' . $pcompany_pic . ' alt="Profile Picture">';
                    } else {
                        echo '<a href="partner-profile.php"><img src="../../views/images/pro-icon-partner.png" alt="Profile Picture"></a>';
                    }
                    echo '<h3>' . $companyName . '</h3>';
                ?>
                
        </div>
<div class="promo-grid">
    <h2>Published Offers</h2>
    <div class="flex grid-container">
      <?php
      $pcompany_user = $_SESSION['pcompany_user'];
      $sql = "SELECT * from partner_company WHERE partner_company.username ='{$pcompany_user}'";
      $result = $mysqli->query($sql);
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
                <div class="offer-actions" style="margin-left=10px">
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
</div>      
    </div>        
            
    </div>
    </section>

    <section>
      <<section>
    <h2>Rating and Feedback</h2>
    <form action="submit_feedback.php" method="POST">
        <label for="rating">Rating:</label>
        <select name="rating" id="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>

        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" rows="5" cols="30"></textarea>

        <input type="submit" value="Submit Feedback">
    </form>
</section>

<section>
    <h2>Existing Ratings and Feedbacks</h2>

    <?php
    $partnerCompanyId = getPartnerCompanyID($mysqli, $_SESSION['pcompany_user']);
    $feedbacks = getFeedbacksByPartnerCompanyId($mysqli, $partnerCompanyId);

    if ($feedbacks && mysqli_num_rows($feedbacks) > 0) {
        while ($row = mysqli_fetch_assoc($feedbacks)) {
            $feedbackId = $row['id'];
            $rating = $row['rating'];
            $comment = $row['comment'];
            $reply = $row['reply'];

            echo '<div class="feedback">';
            echo '<p>Rating: ' . $rating . '</p>';
            echo '<p>Comment: ' . $comment . '</p>';

            if ($reply) {
                echo '<p>Reply: ' . $reply . '</p>';
            } else {
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
        echo '<p>No ratings and feedbacks available.</p>';
    }
    ?>
</section>


    
 
    

























           <!--  <div class="card-header">We value your feedback</div>    
    		<div class="card-body">
    			<div class="row">
    				<div class="col-sm-4 text-center">
    					<h1 class="text-warning mt-4 mb-4">
    						<b><span id="average_rating">0.0</span> / 5</b>
    					</h1>
    					<div class="mb-3">
    						<i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
	    				</div>
    					<h3><span id="total_review">0</span> Review</h3>
    				</div>
    				<div class="col-sm-4">
    					<p>
                            <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>

                            <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                            </div>
                        </p>
    					<p>
                            <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                            </div>               
                        </p>
    					<p>
                            <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                            </div>               
                        </p>
    					<p>
                            <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                            </div>               
                        </p>
    					<p>
                            <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                            </div>               
                        </p>
    				</div>
    				<div class="col-sm-4 text-center">
    					<h3 class="mt-4 mb-3">Write Review Here</h3>
    					<button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>
    				</div>
    			</div>
    		</div>
    	</div>
    	<div class="mt-5" id="review_content"></div>
    </div> -->

 <!--    <div id="review_modal" class="modal" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title">Submit Review</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body">
	      		<h4 class="text-center mt-2 mb-4">
	        		<i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
	        	</h4>
	        	<div class="form-group">
	        		<input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Your Name" />
	        	</div>
	        	<div class="form-group">
	        		<textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
	        	</div>
	        	<div class="form-group text-center mt-4">
	        		<button type="button" class="btn btn-primary" id="save_review">Submit</button>
	        	</div>
	      	</div>
    	</div>
  	</div>
</div>  -->

