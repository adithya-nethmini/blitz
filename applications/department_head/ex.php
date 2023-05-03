<?php
if(!isset($mysqli)){include 'functions.php';}
//include 'sidebar.php';
//include 'header.php';
$mysqli = connect();
$current_month = date('m');
$query = "SELECT * FROM project_list WHERE MONTH(end_date) = $current_month";
$result = mysqli_query($mysqli, $query);

// Loop through the results and store them in an array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo '<script>var current_month_data = ' . json_encode($data) . ';</script>';?>

<script>
    // Define a function to update the UI with the filtered data
    function updateUI(data) {
// Update the UI with the filtered data
// For example, you could display it in a table
        var table = document.getElementById("project_list");
        for (var i = 0; i < data.length; i++) {
            var row = table.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            cell1.innerHTML = data[i].name;
            cell2.innerHTML = data[i].value;
        }
    }

    // Call the updateUI function with the current month data when the page loads
    window.onload = function() {
        updateUI(current_month_data);
    };

</script>

<!-- Add a dropdown menu for selecting the month -->
<select id="month_select">
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
</select>

<!-- Add a button to submit the form -->
<button onclick="submitForm()">Submit</button>

<script>
    // Define a function to submit the form with the selected month value
    function submitForm() {
        // Get the selected month value
        var selected_month = document.getElementById("month_select").value;

        // Redirect the page to a URL that includes the selected month as a query parameter
        window.location.href = "ex.php?month=" + selected_month;
    }
</script>


