<?php 
include "config.php";
include 'submit_rating.php';

if (isset($_GET['company_id'])) {
    $company_id = $_GET['company_id'];
    
    function get_reviews($company_id) {
        $mysqli = new mysqli("localhost", "root", "", "blitz");

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit();
        }

        // Prepare the SQL statement
        $stmt = $mysqli->prepare("SELECT * FROM reviews WHERE company_id = ?");
        $stmt->bind_param("i", $company_id);
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Create an array to store the reviews
        $reviews = array();

        // Loop through the result set and add each review to the array
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }

        // Close the statement and database connection
        $stmt->close();
        $mysqli->close();

        // Return the reviews array
        return $reviews;
    }

    // Call the get_reviews function with the company_id parameter
    $reviews = get_reviews($company_id);
}
else {
    echo "Error: Company ID is not set";
    exit();
}

?>


