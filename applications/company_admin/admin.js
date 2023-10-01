var responseButton = document.querySelector(".response-button");

responseButton.addEventListener("click", function() {
    var response = prompt("Enter Response:");
    if (response !== null) {
        // submit response using AJAX or form submission
        // for example:
        // var xhr = new XMLHttpRequest();
        // xhr.open("POST", "admin.php");
        // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // xhr.send("response=" + response);
    }
});
