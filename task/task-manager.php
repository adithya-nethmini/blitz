<?php include("../config/config.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
</head>
<body>

    <div>
        <h1>Task Manager</h1>
    </div>

    <!-- Navigation Bar -->

    <nav>

        <div>
            
            <a href="task-manager.php"><button type="button"><strong>Home</strong></button></a>

            <?php

                $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE) or die;
                $sql = "SELECT * FROM list";
                @$result = mysqli_query($con, $result);

                if($result==TRUE):
                    while($row=mysqli_fetch_assoc($result)):
                        $name = $row['name']; ?>

                        <a href="list-task.php"><button type="button"><strong><?php echo $name; ?></strong></button></a>
                    <?php endwhile ?>

                <?php endif ?>

        </div>

    </nav>

    <p>

        

    </p>

    <div>

        <a href="add-task.php"><button>Add Task</button></a>

        <table>

            <thead>

                <tr>
                    <th>#</th>  <!--number-->
                    <th>name</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php

                    $con = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);

                    $sql = "SELECT * FROM task";

                    $result = mysqli_query($con, $sql);

                    if($result==TRUE):

                        $count_rows = mysqli_num_rows($result);

                        $number=1; /* # */

                        if($count_rows > 0):
                            while($row = mysqli_fetch_assoc($result)):
                                
                                $id = $row['id'];
                                $name = $row['name'];
                                $description = $row['description'];
                                $priority = $row['priority'];
                                $deadline = $row['deadline'];
                                $status = $row['status'];

                ?>
            </thead>
                            
            <tbody>         
                <tr>        
                    <td><?php echo $id ?></td>
                    <td><?php echo $name ?></td>
                    <td><?php echo $description ?></td>
                    <td><?php echo $priority ?></td>
                    <td><?php echo $deadline ?></td>
                    <td><?php echo $status ?></td>
                    <td>
                        <a href="update-task?id=<?php echo $id; ?>"><button>Update</button></a>
                        <a href="delete-task?id=<?php echo $id; ?>"><button>Delete</button></a>
                    </td>
                </tr>
            </tbody>
                            
                            <?php endwhile ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="5">No task added yet</td>
                            </tr>

                        <?php endif ?>

                    <?php endif ?>            

        </table>

    </div>

</body>
</html>