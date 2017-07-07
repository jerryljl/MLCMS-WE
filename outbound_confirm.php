<!Doctype html>
<html>
<?php
	include 'outbound.php';
	$out = new outbound();
	$outboundid = $_GET['confirm'];
	$info = $out->getinfo($outboundid);
	$row = $info->fetch_assoc();
	
	include 'vehicle.php';
	$vec = new vehicle();
	$vecinfo = $vec->getallinfo();
	$singlevec = $vec->getinfo($row['out_vehicle']);
	$singlevecrow = $singlevec->fetch_assoc();
?>
<body>
<title>Outbound List</title>
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
			<td colspan="3"><h3>Outbound Information:</h3></td>
		</tr>
		<tr>
			<td>Date of outbound (mm-dd-yyyy)</td>
			<td>:</td>
			<td><?php echo $row['out_date']; ?></td>
		</tr>
		<tr>
			<td>Time of outbound</td>
			<td>:</td>
			<td><?php echo $row['out_time']; ?></td>
		</tr>
		<tr>
			<td>Vehicle to export the containers</td>
			<td>:</td>
			<td><?php echo $singlevecrow['ve_no']; ?></td>
		</tr>
		<tr>
			<td>To location</td>
			<td>:</td>
			<td><?php echo $row['out_to']; ?></td>
		</tr>
		
		<tr>
			<td colspan="3"><h3>Pick up Information:</h3></td>
		</tr>
		<tr>
			<td>Vehicle plate number to pick up the containers</td>
			<td>:</td>
			<td><input type="text" name="pickup" style="width:255px;"></td>
		</tr>
		<tr><td colspan="3">Once confirmed, This outbound cannot be updated or deleted.</td></tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right"><input type="submit" value="Confirm" name="submit"></td>
		</tr>
	</form>
	<tr>
		<td>
			<?php
				if(isset($_POST['submit'])){
					$pickup = $_POST['pickup'];			
					$out->confirmoutbound($pickup, $outboundid);
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