<!DOCTYPE html>
<html>
<head>
  <title>Blitz</title>
  <link rel="stylesheet" href="css/add-style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#offer_count").on('input', function() {
        var offer_count = parseInt($(this).val());
        var ads_space = offer_count * 3; // Assuming each offer requires 3 ad spaces

        $("#ads_space").val(ads_space);
      });

      $("#adSpace").on('input', function() {
        var ads_space = parseInt($(this).val());
        var offer_count = Math.ceil(ads_space / 3); // Assuming each offer requires 3 ad spaces

        $("#offer_count").val(offer_count);
      });

      $("#customPackageForm").submit(function(event) {
        event.preventDefault();

        var offer_count = parseInt($("#offer_count").val());
        var ads_space = parseInt($("#ads_space").val());

        if (isNaN(offer_count) || isNaN(ads_space) || offer_count < 1 || ads_space < 3) {
          alert("Please enter valid numbers for offers and ad space.");
          return;
        }

        // Perform the AJAX request to process the form submission
        $.ajax({
          url: "process_custom_package.php",
          method: "POST",
          data: {
            offer_count: offer_count,
            ads_space: ads_space
          },
          success: function(response) {
            $("#customPackageForm").hide();
            $("#confirmationMessage").show();
          },
          error: function(xhr, status, error) {
            console.error(error);
            alert("An error occurred. Please try again.");
          }
        });
      });
    });
  </script>
</head>
<body>
  <h2>Custom Package Form</h2>
  <form id="customPackageForm" method="POST">
    <label for="offerCount">Number of Offers:</label>
    <input type="text" name="offerCount" id="offerCount" required>

    <label for="ads_space">Number of Ad Spaces:</label>
    <input type="text" name="ads_space" id="ads_space" required>

    <button type="submit">Submit</button>
  </form>

  <div id="confirmationMessage" style="display: none;">
    <h3>Custom Package Submitted Successfully!</h3>
    <p>Thank you for submitting your custom package request.</p>
    <!-- You can add any additional details or next steps here -->
  </div>
</body>
</html>
