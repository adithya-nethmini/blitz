<html lang="en">
	<head>
		<style>	
		.table {
			width: 100%;
			margin-bottom: 20px;
		}	
 
		.table-striped tbody > tr:nth-child(odd) > td,
		.table-striped tbody > tr:nth-child(odd) > th {
			background-color: #f9f9f9;
		}
 
		@media print{
			#print {
				display:none;
			}
		}
		@media print {
			#PrintButton {
				display: none;
			}
		}
 
		@page {
			size: auto;   /* auto is the initial value */
			margin: 0;  /* this affects the margin in the printer settings */
		}
	</style>
	</head>
<body>
<h2>Sourcecodester</h2>
	<br /> <br /> <br /> <br />
	<b style="color:blue;">Date Prepared:</b>
	<?php
		$date = date("Y-m-d", strtotime("+6 HOURS"));
		echo $date;
	?>
	<br /><br />
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Product Name</th>
				<th>Price</th>
				<th>Qty</th>
				<th>Data Added</th>
			</tr>
		</thead>
		<tbody>
			<?php
				require '../function/function.php';
                $mysqli = connect();
 
                $user = $_SESSION['user'];
				$query = $mysqli->query("SELECT * FROM `employee` WHERE username = '$user'");
				while($fetch = $query->fetch_array()){
 
			?>
            <tr>
				<td style="text-align:center;"><?php echo $fetch['name']?></td>
				<td style="text-align:center;"><?php echo $fetch['employeeid']?></td>
				<td style="text-align:center;"><?php echo $fetch['department']?></td>
				<td style="text-align:center;"><?php echo $fetch['jobrole']?></td>
			</tr>
 
			<?php
				}
			?>
		</tbody>
	</table>
	<center><button id="PrintButton" onclick="PrintPage()">Print</button></center>
</body>
<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
    window.addEventListener('DOMContentLoaded', (event) => {
   		PrintPage()
		setTimeout(function(){ window.close() },750)
	});
</script>
</html>