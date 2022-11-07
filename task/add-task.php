<?php

    require "../function/function.php";
    if(isset($_POST['submit'])){
        $response = addTask($_POST['name'],$_POST['description'],$_POST['priority'],$_POST['deadline'],$_POST['status']);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
</head>
<body>

    <form action="" method="post" autocomplete="off">

    <h2>Add Task</h2>

    <div class="grid">

        <div>
            <label>Task Name</label>
            <input type="text" name="name" value="<?php echo @$_POST['name']; ?>">
        </div>
        
        <div>
            <label>Task Desciption</label>
            <input type="text" name="description" value="<?php echo @$_POST['description']; ?>">
        </div>
        
        <div>
            <label>Priority</label>
            <select name="priority">
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select> 
        </div>        
                
        <div>
            <label>Deadline</label>
            <input type="date" name="deadline" value="<?php echo @$_POST['deadline']; ?>">
        </div>
        
        <div>
            <label>Status</label>
            <select name="status">
                    <option value="To do">To do</option>
                    <option value="Doing">Doing</option>
                    <option value="Doner">Done</option>
            </select> 
        </div>

    </div>

        <button type= "submit" name="submit">ADD</button>

        <p>
            <a href="task-manager.php">G0 back to task manager page</a>
        </p>

        <?php if(@$response == "success") { ?>

            <p class="success">Task added successful</p>

            <?php }else{ ?>
                <p class="error"><?php echo @$response; ?></p>
        
        <?php } ?>

    </form>

</body>
</html>