<?php
include 'header.php';
/* include '../function/function.php'; */
include '../partner_company/function.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="partner-feed.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    
    <title>Blitz</title>
</head>
<body>
    <div class="page-content">
        <div class="cover-container">
            <img src="../partner_company/images/cover1.png" alt="Company cover photo">
        </div>
    <div class="profile-heading">
            <img src="../partner_company/images/keels.png" alt="partner company logo">
            <h3>Keels Super</h3>
        </div>
    </div>
    <div class="promo-grid">
        <h2>Published Offers</h2>
<div class="flex grid-container">
        <?php

        $mysqli = connect();

$sql="SELECT offer_cover,type, name, date, amount FROM offers";
$result=mysqli_query($mysqli,$sql);

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
                    <img src=../partner_company/'.$offer_cover.' alt="cover photo">
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

$mysqli = connect();

$sql="SELECT type,name, date, description, promotion_cover FROM promotions";
$result=mysqli_query($mysqli,$sql);

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
            <img src=../partner_company/'.$promotion_cover.' alt="cover photo">
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

 
    <div class="container">
    	<div class="card">
        <?php
                    
                    // $user = $_SESSION['padmin_user']; 
                    
                    $sql = ("SELECT * FROM partner_company ") ;
    
                    $result = mysqli_query($mysqli, $sql);
    
                    if($result==TRUE):
    
                        $count_rows = mysqli_num_rows($result);    
                        if($count_rows > 0):
                            while($row = mysqli_fetch_assoc($result)):                                
                                
                                $companyname = $row['companyname'];
    
               
                                ?>
    		
            
            <?php 
        endwhile;
            
    endif;
            
endif; 
?>
<section class="rate">
<span class="heading">We value your feedback</span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>

<hr style="border:3px solid #f1f1f1" >

<div class="row">
  <div class="side">
    <div>5 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-5"></div>
    </div>
  </div>
  <div class="side right">
    <div>150</div>
  </div>
  <div class="side">
    <div>4 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-4"></div>
    </div>
  </div>
  <div class="side right">
    <div>63</div>
  </div>
  <div class="side">
    <div>3 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-3"></div>
    </div>
  </div>
  <div class="side right">
    <div>15</div>
  </div>
  <div class="side">
    <div>2 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-2"></div>
    </div>
  </div>
  <div class="side right">
    <div>6</div>
  </div>
  <div class="side">
    <div>1 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-1"></div>
    </div>
  </div>
  <div class="side right">
    <div>20</div>
  </div>
</div>
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

