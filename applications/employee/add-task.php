<?php

    require "../function/function.php";
    if(isset($_POST['submit'])){
        $response = addTask(@$_SESSION['user'], $_POST['name'],$_POST['description'],$_POST['priority'],$_POST['deadline'],$_POST['status']);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="../../views/css/task.css">
</head>
<body>

    <div class="container">
        <form action="" method="post" autocomplete="off">
        <div class="heading"> 
            <div>
                <h2>Add Task</h2>
            </div>
        
            <div class="back">
                    <p>
                        <a href="task-manager.php"><span class="btn-task">Task Manager</span></a>
                    </p>
            </div>
        
        </div>

        <?php if(@$response == "success") : ?>

            <p class="success">Task added successfully</p>

            <?php else: ?>

                <p class="error"><?php echo @$response; ?></p>

        <?php endif ?>

        <div class="content">
            
            <div class="input-box">
                <label>Task Name</label>
                <input type="text" name="name" value="<?php echo @$_POST['name']; ?>">
            </div>         

            <div class="input-box">
                <label>Task Desciption</label>
                <textarea name="description" maxlength="100"class="task-textarea" resize="none" rows="5" cols="63" value="<?php echo @$_POST['description']; ?>"></textarea>
            </div>
            
            <div class="input-box">
                <label>Priority</label>
                <select name="priority">
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select> 
            </div>        
                    
            <div class="input-box">
                <label>Deadline</label>
                <input type="date" name="deadline" value="<?php echo @$_POST['deadline']; ?>">
            </div>
            
            <div class="input-box">
                <label>Status</label>
                <select name="status">
                        <option value="To do">To do</option>
                        <option value="Doing">Doing</option>
                        <option value="Doner">Done</option>
                </select> 
            </div>

            

        </div>
            <div>
                <button class="btn-add" type= "submit" name="submit">ADD</button>
            </div>
            
        </form>
    </div>

</body>
</html>