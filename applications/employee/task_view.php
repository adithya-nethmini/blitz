<?php if (!isset($mysqli)) {
    include '../function/function.php';
}
include 'sidebar.php';
include 'header.php';

$mysqli = connect();
$user = $_SESSION['user'];
$id = $_GET['id'];

if (isset($_POST['submit'])) {
    $proof_name = $_POST['proof_name'];
    $proof_name = $proof_name . '.pdf';
    $proofs = file_get_contents($_FILES['proofs']['tmp_name']);
    date_default_timezone_set('Asia/Kolkata');
    $proof_uploaded_date = date('Y-m-d H:i:s');

    $sql = "UPDATE task_list SET proofs = ?, proof_name = ?, proof_uploaded_date = '$proof_uploaded_date' WHERE id = '$id'";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        echo ("Failed to prepare statement: " . $mysqli->error);
    }

    // Bind the parameter to the statement and execute the update
    $stmt->bind_param("ss", $proofs, $proof_name);
    if (!$stmt->execute()) {
        echo ("Failed to execute statement: " . $stmt->error);
    }


    mysqli_stmt_close($stmt);
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blitz</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../views/css/view.css">
    <link rel="stylesheet" href="../../views/css/header.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://assets2.lottiefiles.com/packages/lf20_65DYreJ7ru.json">
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
</head>
<section>
    <div class="profile-container">

        <div class="page">
            <?php
            // establish a secure connection to the database
            $mysqli = connect();
            if ($mysqli->connect_error) {
                die('Connection failed: ' . $mysqli->connect_error);
            }

            // prepare and execute the SQL query to fetch task data
            $stmt = $mysqli->prepare("SELECT * FROM `task_list` WHERE id = ?");
            $stmt->bind_param("i", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            // check if there is any data to display
            if ($result->num_rows > 0) {
                $task = $result->fetch_assoc();
            ?>

                <div class="page-content">
                    <div class="heading">
                        <h1>View Task</h1>
                    </div>

                    <div class="container">
                        <div class="up-outer-container">
                            <div class="up-inner-left">
                                <div>
                                    <h3>Task Name</h3>
                                    <?php echo $task['task']; ?>
                                </div>
                                <div style="line-height: 1.5;">
                                    <h3>Description</h3>
                                    <?php echo $task['description']; ?>
                                </div>
                            </div>
                            <div class="up-inner-right">
                                <div>
                                    <h3>Start Date</h3>
                                    <?php echo $task['start_date'] ?>
                                </div>
                                <div>
                                    <h3>End Date</h3>
                                    <?php echo $task['end_date'] ?>
                                </div>
                                <div>
                                    <h3>Status</h3>
                                    <?php
                                    switch ($task['status']) {
                                        case 0:
                                            echo '<span class="started">Started</span>';
                                            break;
                                        case 3:
                                            echo '<span class="ongoing">On-Progress</span>';
                                            break;
                                        case 5:
                                            echo '<span class="done">Done</span>';
                                            break;
                                        default:
                                            echo '<span>No data</span>';
                                            break;
                                    }
                                    ?>
                                </div>
                                <div>
                                    <h3>Proof of Work</h3>
                                    <div class="tiny-container">

                                        <?php if (!empty($task['proofs']) && !empty($task['proof_name'])) {
                                            // display the proofs and proof_name
                                            $pdf_data = $task['proofs']; ?>
                                            <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_65DYreJ7ru.json" background="transparent" speed="1" style="width: 45px; height: 45px;" loop autoplay></lottie-player>
                                            <div class="div-pdf">
                                                <img src="proofs/pdf.png" class="pdf-icon" alt="Proof Pdf">
                                                <span><?php echo $task['proof_name']; ?></span>
                                                
                                            </div>
                                            <form method="POST" enctype="multipart/form-data" action="">
                                                <div class="div-upload">
                                                    <input type="file" name="proofs" title="Provide your proofs of work" required>
                                                    <input type="hidden" name="proof_name" value="<?php echo $task['task']; ?>">
                                                    <button class="upload" type="submit" name="submit">Upload</button>
                                                </div>
                                            </form>
                                        <?php
                                        } else { ?>
                                            <form method="POST" enctype="multipart/form-data" action="">
                                                <div class="div-upload">
                                                    <div style="display: flex;justify-content: center; align-items: center">
                                                        <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_0iuu9o.json" background="transparent" speed="1" style="width: 40px; height: 40px;text-align:center" loop autoplay></lottie-player>
                                                    </div>
                                                    <input type="file" name="proofs" title="Provide your proofs of work" required>
                                                    <input type="hidden" name="proof_name" value="<?php echo $task['task']; ?>">
                                                    <button class="upload" type="submit" name="submit">Upload</button>
                                                </div>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            <?php
            } else {
                echo 'No task found.';
            }

            // close the database connection and release resources
            $stmt->close();
            $mysqli->close();
            ?>
            <br>
        </div>
    </div>
    </div>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>