<?php
if(isset($_POST['email']) && isset($_POST['response'])) {
	$to = $_POST['email'];
	$subject = "Feedback Response";
	$message = $_POST['response'];
	$headers = "From: yourname@example.com\r\n";
	$headers .= "Reply-To: yourname@example.com\r\n";
	$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
	if(mail($to, $subject, $message, $headers)) {
		echo "<p>Your response has been sent successfully!</p>";
	} else {
		echo "<p>There was an error sending your response. Please try again later.</p>";
	}
}
?>
