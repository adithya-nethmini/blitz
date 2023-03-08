<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand" href="https://sourcecodester.com">Sourcecodester</a>
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">PHP - Drop Down Filter Selection</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<form method="POST" action="">
				<div class="form-inline">
					<label>Category:</label>
					<select class="form-control" name="category">
						<option value="Suzuki">Suzuki</option>
						<option value="Honda">Honda</option>
						<option value="Kawasaki">Kawasaki</option>
					</select>
					<button class="btn btn-primary" name="filter">Filter</button>
					<button class="btn btn-success" name="reset">Reset</button>
				</div>
			</form>
			<br /><br />
			<table class="table table-bordered">
				<thead class="alert-info">
					<th>Name</th>
					<th>Brand</th>
				</thead>
				<thead>
					<?php include'filter.php'?>
				</thead>
			</table>
		</div>
	</div>
</body>	
</html>