<?php
if (!isset($mysqli)) {
    include '../function/function.php';
}
//include 'sidebar.php';
include '../../header.php';

$mysqli = connect();
$user = $_SESSION['user'];
$id = $_GET['id'];
if (isset($_POST['submit'])) {

    // Update the profile picture from the database
    $image = $_FILES['proofs']['tmp_name']; // retrieve the temporary path of the uploaded image
    $imageData = file_get_contents($image); // read the image data from the temporary file

    $sql = "UPDATE task_list SET proofs = ? WHERE id = '$id'";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 's', $imageData);
    if (mysqli_stmt_execute($stmt)) {
        return "Profile picture updated successfully to the database.</div>";
    } else {
        echo "No profile picture found for user ID: $user";
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
    <script src="https://kit.fontawesome.com/21e5980a06.js" crossorigin="anonymous"></script>
</head>
<section>
    <div class="profile-container">

        <div class="page">

            <div class="page-content">
                <div class="heading">
                    <h1>View Task</h1>
                </div>



                <?php
                $id = $_GET['id'];
                $qry = "SELECT * from task_list WHERE id=$id";
                if (mysqli_query($mysqli, $qry)) :
                    $row = mysqli_fetch_assoc(mysqli_query($mysqli, $qry));
                    $project_id = $row['project_id'];
                    $task = $row['task'];
                    $description = $row['description'];
                    $status = $row['status'];
                    $emp_id = $row['emp_id'];
                    $proofs = $row['proofs'];
                    $start_date = $row['start_date'];
                    $end_date = $row['end_date'];
                ?>

                    <div class="container">
                        <div class="up-outer-container">
                            <div class="up-inner-left">
                                <div>
                                    <h3>Task Name</h3>
                                    <?php echo $task; ?>
                                </div>
                                <div>
                                    <h3>Description</h3>
                                    <?php echo $description; ?>
                                </div>
                            </div>
                            <div class="up-inner-right">
                                <div>
                                    <h3>Start Date</h3>
                                    <?php echo $start_date ?>
                                </div>
                                <div>
                                    <h3>End Date</h3>
                                    <?php echo $end_date ?>
                                </div>
                                <div>
                                    <h3>Status</h3>
                                    <?php
                                    if ($status == '0') :
                                        $status = 'started'; ?>
                                        <span id="started"><?php echo $status; ?></span>
                                    <?php
                                    elseif ($status == 3) :
                                        $status = 'On-Progress'; ?>
                                        <span id="ongoing"><?php echo $status; ?></span>
                                    <?php
                                    elseif ($status == 5) :
                                        $status = 'Done'; ?>
                                        <span id="done"><?php echo $status; ?></span>
                                    <?php
                                    else :
                                    ?>
                                        <span>No data</span>
                                    <?php endif; ?>

                                </div>
                                <div>
                                    <h3>Proof of Work</h3>
                                    <div class="tiny-container">
                                        <form method="POST" enctype="multipart/form-data" action="">
                                            <input type="file" name="proofs" title="Provide your proofs of work">
                                            <button class="upload" type="submit" name="submit">Upload</button>
                                        </form>
                                        <?php
                                            echo $proofs;
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <br>

            </div><br>
        </div>
    </div>
    </div>