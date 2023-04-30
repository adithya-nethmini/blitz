<?php
include '../function/function.php';
include 'sidebar.php';
include 'header.php';

if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
    session_destroy();
    header("location: ../../index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $response = applyLeave($_POST['leave_type'], $_POST['reason'], $_POST['start_date'], $_POST['last_date'], @$_SESSION['user'], @$_POST['assigned_person']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blitz</title>
    <link rel="stylesheet" href="../../views/css/apply-for-leave.css">
    <link rel="stylesheet" href="../../views/css/header.css">
</head>

<body>
    <section>

        <div class="profile-container">

            <div class="page-content">

                <div class="leave-container">

                    <div>
                        <h3>Apply&nbsp;For&nbsp;Leave</h3>
                    </div>

                    

                    <form action="" method="POST">

                        <div name="first">
                            <label for="">Leave</label>
                            <select name="leave_type" onchange="showSecondDiv()" id="leave-select">
                                <option value="none" selected disabled hidden>Select an Option</option>
                                <option value="Annual Leave">Annual Leave</option>
                                <option value="Sick Leave">Sick Leave</option>
                                <option value="Casual Leave">Casual Leave</option>
                                <option value="Maternity Leave">Maternity Leave</option>
                                <option value="Personal Leave">Personal Leave</option>
                                <option value="Accident Leave">Accident Leave</option>
                                <option value="Study Leave">Study Leave</option>
                                <option value="cancel">Cancel</option>
                            </select>
                        </div>

                        <div name="second" style="display:none">
                            <div>
                                <label for="">Reason&nbsp;:</label>
                                <textarea name="reason" maxlength="100" resize="none" rows="4" cols="63" value="<?php echo @$_POST['reason']; ?>" required></textarea>
                                <?php /* echo $reasonErr; */ ?>
                            </div>

                            <div name="start">
                                <label for="start-date">Starting&nbsp;Date&nbsp;:</label>
                                <input type="date" id="start-date" name="start_date" min="<?php date("m/d/y") ?>" value="<?php echo @$_POST['start_date']; ?>" required>
                                <?php /* echo $start_dateErr; */ ?>
                            </div>

                            <div name="end">
                                <label for="">Last&nbsp;Date&nbsp;:</label>

                                <input type="date" id="last-date" name="last_date" min="<?php echo date("Y-m-d") ?>" max="<?php echo date("Y-m-d", strtotime('+14 days')) ?>" value="<?php echo @$_POST['last_date']; ?>" required>

                            </div>

                            <div>
                                <label for="">Assigned&nbsp;Person&nbsp;:</label>
                                <select name="assigned_person" id="assigned_person">
                                    <option value="none" selected disabled hidden>Select an Option</option>
                                    <?php
                                    $mysqli = connect();
                                    $sql = "SELECT * FROM employee";
                                    $result = mysqli_query($mysqli, $sql);

                                    if ($result == TRUE) :

                                        $count_rows = mysqli_num_rows($result);
                                    
                                        if ($count_rows > 0) :
                                            $assigned_values = array(); // Array to store already assigned values
                                            $existingRequests = array(); // Array to store existing leave requests
                                            while ($row = mysqli_fetch_assoc($result)) :
                                                $assigned_to_be = $row['name'];
                                    
                                                // Check if the value is already assigned
                                                if (in_array($assigned_to_be, $assigned_values)) :
                                                    continue; // Skip this iteration and move to the next value
                                                endif;
                                    
                                                $sql2 ="SELECT * FROM e_leave 
                                                        WHERE status='Accepted' 
                                                        AND MONTH(applied_date)=MONTH(CURRENT_TIMESTAMP) 
                                                        AND (assigned_person='$assigned_to_be' OR name='$assigned_to_be')  " ;
                                                $result2 = mysqli_query($mysqli, $sql2);
                                    
                                                if ($result2 == TRUE) :
                                                    $count_rows2 = mysqli_num_rows($result2);
                                    
                                                    if ($count_rows2 > 0) :
                                                        // The employee already has an approved leave request
                                                        $existingLeave = mysqli_fetch_assoc($result2);
                                                        $existingRequest = array(
                                                            'assigned_person' => $existingLeave['assigned_person'],
                                                        );
                                                        array_push($existingRequests, $existingRequest);
                                                        array_push($assigned_values, $assigned_to_be); // Add this value to the assigned_values array
                                                        ?>
                                                        <option value="<?php echo $assigned_to_be; ?>" disabled><?php echo $assigned_to_be; ?></option>
                                                        
                                                    <?php else : ?>
                                                        <option value="<?php echo $assigned_to_be; ?>"><?php echo $assigned_to_be; ?></option>
                                                    <?php
                                                    endif;
                                                endif;
                                            endwhile;
                                        endif;
                                    endif;
                                    ?>
                                </select>

                            </div>

                            <div>
                                <input type="submit" value="Apply&nbsp;Now" class="apply" name="submit">
                                <p id="demo"></p>
                            </div>
                        </div>

                    </form>
                </div>
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
                secondDiv.style.display = "block";
                startDateDiv.style.display = "block";
                lastDateDiv.style.display = "block";
                maxDays = 14;
                break;
            case "Maternity Leave":
                secondDiv.style.display = "block";
                startDateDiv.style.display = "block";
                lastDateDiv.style.display = "block";
                maxDays = 84;
                break;
            case "none" && "cancel":
                secondDiv.style.display = "none";
                break;
            default:
                secondDiv.style.display = "block";
                startDateDiv.style.display = "block";
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
</script>
<script>
   

    function getdata() {
        var txtOne = document.getElementById('assigned_person').value;
        <?php /* 

                                    $mysqli = connect();
                                    $user = $_SESSION['user'];
                                    $sql = ("SELECT * FROM emp_leave ") ;
                        
                                    $result = mysqli_query($mysqli, $sql);
                        
                                    if($result==TRUE):
                        
                                        $count_rows = mysqli_num_rows($result);
                        
                                        if($count_rows > 0):
                                            while($row = mysqli_fetch_assoc($result)):
                                                $id = $row['id'];
                                                $start_date = $row['start_date'];
                                                $last_date = $row['last_date'];
                                                $assigned_person = $row['assigned_person'];
                                                $username = $row['username'];
                                                
                                                if($assigned_person == $username && $username != $_SESSION['user']): 
                                                    echo "Success!";
                                                else:
                                                    echo "On a leave";
                                                endif;
                                            endwhile;
                                        endif;
                                    endif; */
        ?>
    }
</script>
</script>

</html>