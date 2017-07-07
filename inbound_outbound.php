<!Doctype html>
<html>
<?php
	include 'inbound.php';
	$in = new inbound();
	$inboundid = $_GET['outbound'];
	$info = $in->getinfo($inboundid);
	$row = $info->fetch_assoc();
	
	include 'customer.php';
	$cus = new customer();
	$singlecus = $cus->getinfo($row['in_from']);
	$singlecusrow = $singlecus->fetch_assoc();
	
	include 'vehicle.php';
	$vec = new vehicle();
	$vecinfo = $vec->getallinfo();
	$singlevec = $vec->getinfo($row['in_vehicle']);
	$singlevecrow = $singlevec->fetch_assoc();
	
	include 'yard.php';
	$yard = new yard();
	$singleyard = $yard->getinfo($row['in_yard']);
	$singleyardrow = $singleyard->fetch_assoc();
	
	include 'outbound.php';
	$out = new outbound();
?>
<body>
<title>Inbound List</title>
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
			<td colspan="3"><h3>Inbound Information:</h3></td>
		</tr>
		<tr>
			<td>Date of inbound (mm-dd-yyyy)</td>
			<td>:</td>
			<td><?php echo $row['in_date']; ?></td>
		</tr>
		<tr>
			<td>From</td>
			<td>:</td>
			<td><?php echo $singlecusrow['cus_name']; ?></td>
		</tr>
		<tr>
			<td>From yard</td>
			<td>:</td>
			<td><?php echo $singleyardrow['yard_name']; ?></td>
		</tr>
		<tr>
			<td>Number of containers to be exported</td>
			<td>:</td>
			<td><?php echo $row['in_container']; ?></td>
		</tr>
		
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		
		<tr>
			<td colspan="3"><h3>Outbound Information:</h3></td>
		</tr>
		<tr>
			<td>Date of outbound (mm-dd-yyyy)</td>
			<td>:</td>
			<td><input type="date" name="date" style="width:250px;" min="<?php echo date('Y-m-d') ?>"></td>
		</tr>
		<tr>
			<td>Time of outbound</td>
			<td>:</td>
			<td>
				<select name="time" style="width:255px;">
					<option value="09:00">09:00</option>
					<option value="11:00">11:00</option>
					<option value="13:00">13:00</option>
					<option value="15:00">15:00</option>
					<option value="17:00">17:00</option>
					<option value="19:00">19:00</option>
					<option value="21:00">21:00</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Vehicle to export the containers</td>
			<td>:</td>
			<td>
				<select name="vehicle" style="width:255px;">
					<?php
						while($vrow = $vecinfo->fetch_assoc()){
							echo "<option value=\"".$vrow['ve_id']."\">".$vrow['ve_no']."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>To location</td>
			<td>:</td>
			<td>
				<select name="to" style="width:255px;">
					<option value="South East Asia">South East Asia</option>
					<option value="South Central">South Central</option>
					<option value="Central India">Central India</option>
					<option value="West Europe">West Europe</option>
				</select>
			</td>
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
					$date = $_POST['date'];
					$from = $singlecusrow['cus_id'];
					$yard = $singleyardrow['yard_id'];
					$time = $_POST['time'];
					$noofcontainer = $row['in_container'];
					$vehicle = $_POST['vehicle'];
					$to = $_POST['to'];				
					$out->newoutbound($date, $from, $yard, $time, $noofcontainer, $vehicle, $to, $inboundid);
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