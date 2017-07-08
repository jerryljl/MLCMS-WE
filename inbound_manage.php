<!Doctype html>
<html>
<?php
	include 'inbound.php';
	$in = new inbound();
	if(isset($_GET['edit'])){
		$inboundid = $_GET['edit'];
		$info = $in->getinfo($inboundid);
		$row = $info->fetch_assoc();
	}
	else{
		$inboundid = 0;
	}
	
	include 'customer.php';
	$cus = new customer();
	$cusinfo = $cus->getallinfo();
	if($inboundid != 0){
		$singlecus = $cus->getinfo($row['in_from']);
		$singlecusrow = $singlecus->fetch_assoc();
	}
	
	include 'vehicle.php';
	$vec = new vehicle();
	$vecinfo = $vec->getallinfo();
	if($inboundid != 0){
		$singlevec = $vec->getinfo($row['in_vehicle']);
		$singlevecrow = $singlevec->fetch_assoc();
	}
	
	include 'yard.php';
	$yard = new yard();
	$yardinfo = $yard->getallinfo();
	if($inboundid != 0){
		$singleyard = $yard->getinfo($row['in_yard']);
		$singleyardrow = $singleyard->fetch_assoc();
	}
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
			<td>Date (mm-dd-yyyy)</td>
			<td>:</td>
			<td><input type="date" name="date" style="width:250px;" min="<?php date_default_timezone_set('Asia/Kuala_Lumpur'); echo date('Y-m-d') ?>" value="<?php if($inboundid == 0){ echo ""; } else{ echo $row['in_date']; } ?>"></td>
		</tr>
		<tr>
			<td>From</td>
			<td>:</td>
			<td>
				<select name="from" style="width:255px;">
					<?php
						if($inboundid == 0){
							while($crow = $cusinfo->fetch_assoc()){
								echo "<option value=\"".$crow['cus_id']."\">".$crow['cus_name']."</option>";
							}
						}
						else{
							echo "<option value=\"".$row['in_from']."\" selected>".$singlecusrow['cus_name']."</option>";
							while($crow = $cusinfo->fetch_assoc()){
								if($row['in_from'] != $crow['cus_id']){
									echo "<option value=\"".$crow['cus_id']."\">".$crow['cus_name']."</option>";
								}
							}
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Store in yard (current space left)</td>
			<td>:</td>
			<td>
				<select name="yard" style="width:255px;">
					<?php
						if($inboundid == 0){
							while($yrow = $yardinfo->fetch_assoc()){
								echo "<option value=\"".$yrow['yard_id']."\">".$yrow['yard_name']." (".$yrow['yard_current'].")</option>";
							}
						}
						else{
							echo "<option value=\"".$row['in_yard']."\" selected>".$singleyardrow['yard_name']." (".$singleyardrow['yard_current'].")</option>";
							while($yrow = $yardinfo->fetch_assoc()){
								if($row['in_yard'] != $yrow['yard_id']){
									echo "<option value=\"".$yrow['yard_id']."\">".$yrow['yard_name']." (".$yrow['yard_current'].")</option>";
								}
							}
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Number of containers to be imported</td>
			<td>:</td>
			<td><input type="number" name="noofcontainer" style="width:250px;" min="0" value="<?php if($inboundid == 0){ echo ""; } else{ echo $row['in_container']; } ?>"></td>
		</tr>
		<tr>
			<td>Vehicle to import containers to yard</td>
			<td>:</td>
			<td>
				<select name="vehicle" style="width:255px;">
					<?php
						if($inboundid == 0){
							while($vrow = $vecinfo->fetch_assoc()){
								echo "<option value=\"".$vrow['ve_id']."\">".$vrow['ve_no']."</option>";
							}
						}
						else{
							echo "<option value=\"".$row['in_vehicle']."\" selected>".$singlevecrow['ve_no']."</option>";
							while($vrow = $vecinfo->fetch_assoc()){
								if($row['in_vehicle'] != $vrow['ve_id']){
									echo "<option value=\"".$vrow['ve_id']."\">".$vrow['ve_no']."</option>";
								}
							}
						}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right"><input type="submit" value="<?php if($inboundid == 0){ echo "Submit"; } else{ echo "Update"; } ?>" name="<?php if($inboundid == 0){ echo "submit"; } else{ echo "update"; } ?>"></td>
		</tr>
	</form>
	<tr>
		<td>
			<?php
				if(isset($_POST['submit'])){
					$date = $_POST['date'];
					$from = $_POST['from'];
					$yard = $_POST['yard'];
					$noofcontainer = $_POST['noofcontainer'];
					$vehicle = $_POST['vehicle'];					
					$in->newinbound($date, $from, $yard, $noofcontainer, $vehicle);
				}
			?>
			
			<?php
				if(isset($_POST['update'])){
					$date = $_POST['date'];
					$from = $_POST['from'];
					$yard = $_POST['yard'];
					$noofcontainer = $_POST['noofcontainer'];
					$vehicle = $_POST['vehicle'];					
					$in->updateinbound($date, $from, $yard, $noofcontainer, $vehicle, $inboundid);
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
