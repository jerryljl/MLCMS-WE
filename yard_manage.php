<!Doctype html>
<html>
<?php
	include 'yard.php';
	$yard = new yard();
?>
<body>
<title>Yard List</title>
<head>
	<link rel="stylesheet" href="design.css">
</head>

<body class="body">
<div class="wrapper">
<table style="width:100%">
	<tr style="height:15px"><td colspan="2"></td></tr>
	<tr>
		<td style="width:50%; text-align:left;"><a href="customer_list.php"><img src="logo/maersk.png" height="80px" width="360px"></img></a></td>
		<td style="width:50%; text-align:right; vertical-align:bottom;" class="nav">
			<ul>
				<li style="float:right; vertical-align:center;"><img src="logo/setting.png" width="18px" height="18px"></img>&nbsp;Settings &nbsp;&nbsp;
					<ul>
						<li style="z-index: 1;float:right; border-bottom:2px solid #000000; border-top:2px solid #000000;"><a href="/.auth/logout">Sign Out</a></li> 
					</ul>
				</li>
			</ul>
		</td>
	</tr>
	<tr>
		<td colspan="2"><b>Current Region : West Europe</b></td>
	</tr>
</table>
<table style="width:100%;">
	</tr>
		<td colspan="2" style="text-align:center;">
			<table style="width:100%;border-collapse:collapse;" class="nav">
				<tr>
					<ul>
						<td style="width:20%;float:center;"><li style="height:30px; padding:10px 0 0 0;"><a href="customer_list.php" style="text-decoration:none;">Customers</a></li></td>
						<td style="width:20%;float:center;"><li style="height:30px; padding:10px 0 0 0;"><a href="truck_list.php" style="text-decoration:none;">Trucks</a></li></td>
						<td style="width:20%;float:center;"><li style="height:30px; padding:10px 0 0 0;"><a href="yard_list.php" style="text-decoration:none;">Yard</a></li></td>
						<td style="width:20%;float:center;"><li style="height:30px; padding:10px 0 0 0;"><a href="inbound_list.php" style="text-decoration:none;">Inbound</a></li></td>
						<td style="width:20%;float:center;"><li style="height:30px; padding:10px 0 0 0;"><a href="outbound_list.php" style="text-decoration:none;">Outbound</a></li></td>
					</ul>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table align="center" class="com">
	<form method="POST">
		<tr>
			<td colspan="3"><h3>Yard Information:</h3></td>
		</tr>
		<tr>
			<td>Yard Name</td>
			<td>:</td>
			<td><input type="text" name="name" style="width:250px;"></td>
		</tr>
		<tr>
			<td>Yard Container Limit</td>
			<td>:</td>
			<td><input type="text" name="limit" style="width:250px;"></td>
		</tr>
		<tr>
			<td>Yard Current Space</td>
			<td>:</td>
			<td><input type="text" name="current" style="width:250px;"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right"><input type="submit" value="Submit" name="submit"></td>
		</tr>
	</form>
	<tr>
		<td>
			<?php
				if(isset($_POST['submit'])){
					$name = $_POST['name'];
					$limit = $_POST['limit'];
					$current = $_POST['current'];					
					$yard->newyard($name, $limit, $current);
				}
			?>
		</td>
	</tr>
</table>
</div>
<div class="footer">
	<table style="width:100%; text-align:right;">
		<tr><td>©Maersk Line CMS Copyright 2017.</td></tr>
	</table>
</div>
</body>
</html>