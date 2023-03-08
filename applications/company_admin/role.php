<link rel="stylesheet" href="newproject.css">
<title>Blitz</title>
<h2>New Department Head</h2>
<form class="form-inline" action="" method="post" autocomplete="off">
    <label for="name">Name:</label>
    <input type="text" id="name" placeholder="Enter Project Name" name="name" required>
    <label for="status">Status:</label>
    <select name="status" id="status" class="custom-select custom-select-sm">
        <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
        <option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>On-Hold</option>
        <option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Done</option>
    </select>
    <br>
    <br>
    <label for="strDate" class="control-label">Start Date:</label>
    <input required id="strDate" type="date" class="form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d",strtotime ($start_date)) : '' ?>">
    <script type="text/javascript">
        strDate = document.getElementById('strDate');
        strDate.min = new Date().toISOString().split("T")[0];
    </script>
    <label for="endDate" class="control-label">End Date:</label>
    <input required id="endDate" type="date" class="form-control-sm" autocomplete="off" name="end_date" value="<?php echo isset($end_date) ? date("Y-m-d",strtotime($end_date)) : '' ?>">
    <script type="text/javascript">
        endDate = document.getElementById('endDate');
        endDate.min = new Date().toISOString().split("T")[0];
    </script>
    <br>
    <br>
    <br>
    <label for="manager_id">Project Manager:</label>
    <select required name="manager_id" id="manager_id" class="custom-select custom-select-sm">
        <option></option>
        <?php
        $sql = ("SELECT username,name,jobrole FROM employee") ;
        $result = mysqli_query($mysqli, $sql);
        if($result){
            $count_rows = mysqli_num_rows($result);
            if($count_rows > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $username = $row['username'];
                    $name= $row['name'];
                    $jobrole = $row['jobrole'];
                    ?>
                    <option value="<?php echo $row['username'] ?>" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>><?php echo $name . " - " . $jobrole?></option>
                <?php
                }
            }
        }
        ?>
    </select>
    <br>
    <br>
    <label for="user_ids[]">Project Members:</label>
    <select required multiple="multiple" name="user_ids[]" id="user_ids[]">
        <option></option>
        <?php
        $employees = $mysqli->query("SELECT *,concat(name,' - ',jobrole) as name FROM employee ");
        while($row= $employees->fetch_assoc()){
            $username = $row['username'];
            $name = $row['name'];
            $jobrole = $row['jobrole'];
            ?>
            <option value="<?php echo $row['username'] ?>">

            <?php echo ucwords($row['name']) ?></option>
        <?php
        }
        ?>
    </select>
    <script>
        new MultiSelectTag('user_ids[]', {
            rounded: true
        })
    </script>
    <br>
    <label for="description">Description:</label>
    <textarea required id="description" name="description"></textarea>
    <div class="inline-block">
        <div class="bar">
            <button class="inner1" type="submit" name="submit"><b>Save</b></button>
            <button class="inner2" type="submit" name="submit1"><b>Cancel</b></button>
        </div>
    </div>
</form>
</body>