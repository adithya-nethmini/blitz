<!DOCTYPE HTML>
<html>
<head>
<script>
var i = 0;
function move() {
  if (i == 0) {
    i = 1;
    var elem = document.getElementById("myBar");
    var width = 10;
    var id = setInterval(frame, 10);
    function frame() {
      if (width >= 100) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
        elem.innerHTML = width + "%";
      }
    }
  }
}
</script>
<link rel="stylesheet" href="check.css">
</head>
<body>

<div class="myProgress">
	<div class="dept-prog">
  		<div id="myBar">10%</div>

  			<div class="proj-prog">
</li><div id="myBar">10%</div></li>
</li><div id="myBar">10%</div></li>
</li><div id="myBar">10%</div></li>
  			</div>
	</div>

</div>
</body>
</html> 
