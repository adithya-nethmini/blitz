
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sidebar.css">
    <script src="https://kit.fontawesome.com/b1cec324bd.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="sidebar">

        <img src="blitzw.png" alt="logo">
        <div class="sidebar-menu">
            <ul>
                <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i><b>&nbsp;Dashboard</b></a></li>
                <button class="dropdown-btn" ><i class="fa-solid fa-sheet-plastic"></i><b>&nbsp;Projects</b><i class="fa fa-caret-down"></i></button>
                <div class="dropdown-container">
                    <a href="newproject.php"><i class="fa-solid fa-greater-than"></i>&nbsp;&nbsp;Add New</a><br>
                    <a href="project_list.php"><i class="fa-solid fa-greater-than"></i>&nbsp;&nbsp;List</a>
                </div>
                <button class="dropdown-btn" ><i class="fa-solid fa-list-check"></i><b>&nbsp;Task</b><i class="fa fa-caret-down"></i></button>
                <div class="dropdown-container">
                    <a href="newtask.php"><i class="fa-solid fa-greater-than"></i>&nbsp;&nbsp;Add New</a><br>
                    <a href="task_list.php"><i class="fa-solid fa-greater-than"></i>&nbsp;&nbsp;List</a>
                </div>
                <li><a href="reports.php"><i class="fa-solid fa-square-poll-vertical"></i><b>&nbsp;Reports</b></a></li>
            </ul>
        </div>

        <div class="sidebar-bottom">
            <div class="company-deets">
                <img src="profile.png" alt="partner company logo">
                <h4>Dpt Head</h4>
            </div>
            <div class="logout">
                <a href="logout.php"><button type="submit" id="btn"><i class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;&nbsp;Logout</button></a></br>
            </div>

        </div>
    </div>
<script>
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>

</body>
</html>