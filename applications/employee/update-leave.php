<?php
include '../function/function.php';
// include 'sidebar.php';
include 'header.php';

$mysqli = connect();

$id=$_GET['id'];

// Fetch data for autofilling fields

if (isset($_POST['submit'])) {
    // Fetch input $_POST
    $leave_type = $mysqli->real_escape_string($_POST['leave_type']);
    $reason = $mysqli->real_escape_string($_POST['reason']);
    $start_date = $mysqli->real_escape_string($_POST['start_date']);
    $last_date = $mysqli->real_escape_string($_POST['last_date']);
    $assigned_person = $mysqli->real_escape_string($_POST['assigned_person']);

    // Prepared statement
    $stmt = $mysqli->prepare("UPDATE `e_leave` SET `leave_type` = ?, `reason` = ?, `start_date` = ?, `last_date` = ?, `assigned_person` = ? WHERE `id`='$id'");

    // Bind params
    mysqli_free_result($result);
    if (!$stmt) {
        echo ("Failed to prepare statement: " . $mysqli->error);
    }

    // Bind the parameter to the statement and execute the update
    $stmt->bind_param("sssss", $leave_type, $reason, $start_date, $last_date, $assigned_person);
    if (!$stmt->execute()) {
        echo ("Failed to execute statement: " . $stmt->error);
    }

    echo '<script>window.location.href = "http://localhost/blitz/applications/employee/leave-status.php";</script>';
    mysqli_stmt_close($stmt);
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="../../views/css/update-leave.css">
    <!-- <link rel="stylesheet" href="../../views/css/header.css"> -->
</head>

<body>

    <section>

        <div class="page-content">
            <div class="topic">
                <h2>Update Leave</h2>
            </div>
            <div class="update-leave-container">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    $sql = "SELECT * FROM e_leave WHERE id = '$id'";
                    $result = $mysqli->query($sql);



                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $leave_type = $row['leave_type'];
                        $reason = $row['reason'];
                        $start_date = $row['start_date'];
                        $last_date = $row['last_date'];
                        $assigned_person = $row['assigned_person'];
                    }
                }
                ?>
                <form action="" method="POST" id="availability-form">

                    <!-- <div style="display: flex;flex-direction:row"> -->
                    <div name="first">
                        <label for="">Leave Type&nbsp;:</label>
                        <select name="leave_type" onchange="showSecondDiv()" id="leave-select" required>
                            <option value="none" selected disabled hidden>Select an Option</option>
                            <option value="Annual Leave" <?php if ($leave_type == "Annual Leave") echo "selected"; ?>>Annual Leave</option>
                            <option value="Sick Leave" <?php if ($leave_type == "Sick Leave") echo "selected"; ?>>Sick Leave</option>
                            <option value="Casual Leave" <?php if ($leave_type == "Casual Leave") echo "selected"; ?>>Casual Leave</option>
                            <option value="Maternity Leave" <?php if ($leave_type == "Maternity Leave") echo "selected"; ?>>Maternity Leave</option>
                            <option value="Personal Leave" <?php if ($leave_type == "Personal Leave") echo "selected"; ?>>Personal Leave</option>
                            <option value="Accident Leave" <?php if ($leave_type == "Accident Leave") echo "selected"; ?>>Accident Leave</option>
                            <option value="Study Leave" <?php if ($leave_type == "Study Leave") echo "selected"; ?>>Study Leave</option>
                        </select>
                    </div>

                    <div name="second">
                        <div>
                            <label for="">Reason&nbsp;:</label>
                            <textarea name="reason" maxlength="100" resize="none" rows="4" cols="63" required><?= $reason ?></textarea>
                        </div>

                        <div name="start">
                            <label for="start-date">Starting&nbsp;Date&nbsp;:</label>
                            <input type="date" id="start-date" name="start_date" value="<?= $start_date ?>" min="<?php date("m/d/y") ?>" required>
                        </div>

                        <div name="end">
                            <label for="">Last&nbsp;Date&nbsp;:</label>

                            <input type="date" id="last-date" name="last_date" value="<?= $last_date ?>" min="<?php echo date("Y-m-d") ?>" max="<?php echo date("Y-m-d", strtotime('+14 days')) ?>" required>

                        </div>

                        <div>
                            <label for="">Assigned&nbsp;Person&nbsp;:</label>
                            <select name="assigned_person" id="assigned_person">
                                <!-- <option value="none" selected disabled hidden>Select an Option</option> -->
                                <?php
                                $mysqli = connect();
                                $sql = "SELECT name FROM employee WHERE username NOT IN (SELECT name FROM e_leave WHERE status IN (?, ?))";

                                // prepare the statement
                                $stmt = $mysqli->prepare($sql);

                                // check for any errors when preparing the statement
                                if (!$stmt) {
                                    echo "Error preparing statement: " . $mysqli->error;
                                    exit();
                                }

                                // bind the parameter values to the statement
                                $status1 = "Accepted";
                                $status2 = "Pending";
                                $stmt->bind_param("ss", $status1, $status2);

                                // execute the statement
                                $stmt->execute();

                                // get the result set
                                $result = $stmt->get_result();

                                // loop through the rows and display the employee names
                                while ($row = $result->fetch_assoc()) {
                                    $emp_name = $row["name"]; ?>
                                    <option value="<?php echo $emp_name ?>" <?php echo isset($assigned_person) && $assigned_person == $emp_name ? 'selected' : '' ?>><?php echo $emp_name ?></option>
                                <?php }

                                // close the statement and database connection
                                $stmt->close();
                                $mysqli->close();
                                ?>
                            </select>
                            
                            <div class="div-availability">
                                <span id="availability"></span>
                            </div>


                        </div>

                        <div>
                            <button type="submit" name="submit" class="apply">Apply&nbsp;Now</button>
                        </div>
                    </div>
                    <!-- </div> -->


                </form>
            </div>
        </div>
    </section>

</body>
<script>
    // Get the current date
    var today = new Date().toISOString().split('T')[0];

    // Set the minimum date for the input field
    document.getElementById("start-date").setAttribute("min", today);


    var leaveSelect = document.getElementById("leave-select");
    var secondDiv = document.getElementsByName("second")[0];
    var startDateDiv = document.getElementsByName("start")[0];
    var lastDateDiv = document.getElementsByName("end")[0];
    var maxDays = 7; // default number of days

    leaveSelect.addEventListener("change", function() {
        var selectedOption = leaveSelect.value;

        switch (selectedOption) {
            case "Annual Leave":
                // secondDiv.style.display = "block";
                startDateDiv.style.display = "block";
                lastDateDiv.style.display = "block";
                maxDays = 14;
                break;
            case "Maternity Leave":
                // secondDiv.style.display = "block";
                startDateDiv.style.display = "block";
                lastDateDiv.style.display = "block";
                maxDays = 84;
                break;
            case "none":
                secondDiv.style.display = "none";
                break;
            default:
                // secondDiv.style.display = "block";
                // startDateDiv.style.display = "block";
                lastDateDiv.style.display = "block";
                maxDays = 7;
                break;
        }

        // Get the start date picker element
        var startDatePicker = document.getElementById("start-date");

        // Get the last date picker element
        var lastDatePicker = document.getElementById("last-date");

        // Set the minimum and maximum dates for the last date picker based on the start date picker
        startDatePicker.addEventListener("change", function() {
            // Get the selected start date
            var startDate = new Date(startDatePicker.value);

            // Set the minimum date for the last date picker to the selected start date
            var minDate = startDate.toISOString().slice(0, 10);
            lastDatePicker.setAttribute("min", minDate);

            // Set the maximum date for the last date picker to 14 days from the selected start date
            var maxDate = new Date(startDate.getTime() + maxDays * 24 * 60 * 60 * 1000).toISOString().slice(0, 10);
            lastDatePicker.setAttribute("max", maxDate);
        });
    });




    // Assigned Person validation

    const start_date_input = document.getElementById("start-date");
    const last_date_input = document.getElementById("last-date");
    const assigned_person_select = document.getElementById("assigned_person");
    const availability_span = document.getElementById("availability");

    // const assigned_person_select = document.getElementById("assigned_person");
    // const default_option = document.createElement("option");
    // default_option.value = "";
    // default_option.text = "Select an Option";
    // default_option.disabled = true;
    // default_option.hidden = true;
    // default_option.selected = true;
    // assigned_person_select.insertBefore(default_option, assigned_person_select.firstChild);


    start_date_input.addEventListener("change", checkAvailability);
    last_date_input.addEventListener("change", checkAvailability);
    assigned_person_select.addEventListener("change", checkAvailability);

    function checkAvailability() {
        const assigned_person = assigned_person_select.value;
        const start_date = start_date_input.value;
        const last_date = last_date_input.value;

        if (start_date === '' || last_date === '') {
            availability_span.innerHTML = "Please select both start date and last date";
            // } else if (assigned_person === '') {
            //     availability_span.innerHTML = "Please select an employee";
        } else {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    availability_span.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "check.php?assigned_person=" + assigned_person + "&start_date=" + start_date + "&last_date=" + last_date, true);
            xhttp.send();
        }
    }
</script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</html>