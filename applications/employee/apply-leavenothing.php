<?php
include '../function/function.php';
include 'sidebar.php';
include '../../header.php';

if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
    session_destroy();
    header("location: ../../index.php");
    exit();
}

$mysqli = connect();

if (isset($_POST['submit'])) {
    $response = applyLeave($_POST['leave_type'], $_POST['reason'], $_POST['start_date'], $_POST['last_date'], @$_SESSION['user'], @$_POST['assigned_person']);
}

?>

<html>

<head>
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

                    <?php if (@$response == "success") : ?>

                        <p class="success">Task added successfully</p>

                    <?php else : ?>

                        <p class="error"><?php echo @$response;
                                            echo $mysqli->error; ?></p>

                    <?php endif ?>

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

                        <!-- <div name="second" style="display:none"> -->
                        <div name="second">
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
                                    $sql = "SELECT name FROM employee";
                                    $result = mysqli_query($mysqli, $sql);
                                    if ($result == TRUE) {
                                        $count_rows = mysqli_num_rows($result);
                                        if ($count_rows > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $assigned_to_be = $row['name'];
                                    ?>
                                                <option value="<?php echo $assigned_to_be ?>"><?php echo $assigned_to_be ?></option>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div>
                                <input type="submit" value="Apply&nbsp;Now" class="apply" name="submit">
                                <p id="demo"></p>
                            </div>

                        </div>
                </div>
            </div>
    </section>
</body>

</html>