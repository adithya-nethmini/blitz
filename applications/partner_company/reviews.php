

<?php 
include '../function/partner_companyf/reviews-f.php';
include 'submit_rating.php';

// Retrieve reviews from the database
$reviews = get_reviews();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div class="overall_rating">
    <span class="num"><?=number_format(@$reviews_info['overall_rating'], 1)?></span>
    <span class="stars"><?=str_repeat('&#9733;', round(@$reviews_info['overall_rating']))?></span>
    <span class="total"><?=@$reviews_info['total_reviews']?> reviews</span>
</div>
<a href="#" class="write_review_btn">Write Review</a>
<div class="write_review">
    <form>
        <input name="name" type="text" placeholder="Your Name" required>
        <input name="rating" type="number" min="1" max="5" placeholder="Rating (1-5)" required>
        <textarea name="content" placeholder="Write your review here..." required></textarea>
        <button type="submit">Submit Review</button>
    </form>
</div>

<?php 
    foreach ($reviews as $review): 
?>
<div class="review">
    <h3 class="name"><?=htmlspecialchars($review['employee'], ENT_QUOTES)?></h3>
    <div>
        <span class="rating"><?=str_repeat('&#9733;', $review['rating'])?></span>
        <span class="date"><?=time_elapsed_string($review['submit_date'])?></span>
    </div>
    <p class="content"><?=htmlspecialchars($review['content'], ENT_QUOTES)?></p>
</div>
<?php endforeach ?>

<div class="reviews"></div>
<script>
const review_company_name = 1;
fetch("review.php?companyname=" + review_company_name).then(response => response.text()).then(data => {
	document.querySelector(".reviews").innerHTML = data;
	document.querySelector(".write_review_btn").onclick = event => {
		event.preventDefault();
		document.querySelector(".write_review").style.display = 'block';
		document.querySelector(".write_review input[name='employee']").focus();
	};
	document.querySelector(".write_review form").onsubmit = event => {
		event.preventDefault();
		fetch("review.php?companyname=" + review_company_name, {
			method: 'POST',
			body: new FormData(document.querySelector(".write_review form"))
		}).then(response => response.text()).then(data => {
			document.querySelector(".write_review").innerHTML = data;
		});
	};
});

</script>

</body>
</html>
