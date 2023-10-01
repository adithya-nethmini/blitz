<?php
include '../partner_company/function.php';
include '../partner_company/header.php';
include '../partner_company/sidebar.php';
$mysqli = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission and update the offer
    $offer_id = $_POST['offer_id'];
    $offer_name = $_POST['offer_name'];
    // Handle other fields as needed

    // Perform the update query using the provided data
    $sql = "UPDATE offers SET name = '$offer_name' WHERE id = '$offer_id'";
    $result = $mysqli->query($sql);

    if ($result) {
        // Offer updated successfully
        // Redirect to the offer listing page
        header("Location: company-feed.php");
        exit();
    } else {
        // Error occurred during the update
        echo "Error updating offer: " . $mysqli->error;
    }
} else {
    // Display the form to edit the offer
    $offer_id = $_GET['id'];
    $sql = "SELECT * FROM offers WHERE id = '$offer_id'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $offer_name = $row['name'];
        // Retrieve other offer details as needed

        // Display the edit form
        echo '
            <h2>Edit Offer</h2>
            <form method="post" action="edit-offer.php">
                <input type="hidden" name="offer_id" value="'.$offer_id.'">
                <label for="offer_name">Offer Name:</label>
                <input type="text" name="offer_name" value="'.$offer_name.'">
                <!-- Include other fields here as needed -->
                <button type="submit">Update</button>
            </form>
        ';
    } else {
        echo "Offer not found";
    }
}

include 'footer.php';
?>
