<!Doctype html>
<html>
<?php
	include 'outbound.php';
	$out = new outbound();
	$outboundid = $_GET['edit'];
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
			<td><input type="date" name="date" style="width:250px;" min="<?php date_default_timezone_set('Asia/Kuala_Lumpur'); echo date('Y-m-d') ?>" value="<?php if($outboundid == 0){ echo ""; } else{ echo $row['out_date']; } ?>"></td>
		</tr>
		<tr>
			<td>Time of outbound</td>
			<td>:</td>
			<td>
				<select name="time" style="width:255px;">
					<?php
						if ($row['out_time'] == "09:00"){
							echo "<option value=\"09:00\" selected>09:00</option>";
							echo "<option value=\"11:00\">11:00</option>";
							echo "<option value=\"13:00\">13:00</option>";
							echo "<option value=\"15:00\">15:00</option>";
							echo "<option value=\"17:00\">17:00</option>";
							echo "<option value=\"19:00\">19:00</option>";
							echo "<option value=\"21:00\">21:00</option>";
						}
						if ($row['out_time'] == "11:00"){
							echo "<option value=\"09:00\">09:00</option>";
							echo "<option value=\"11:00\" selected>11:00</option>";
							echo "<option value=\"13:00\">13:00</option>";
							echo "<option value=\"15:00\">15:00</option>";
							echo "<option value=\"17:00\">17:00</option>";
							echo "<option value=\"19:00\">19:00</option>";
							echo "<option value=\"21:00\">21:00</option>";
						}
						if ($row['out_time'] == "13:00"){
							echo "<option value=\"09:00\">09:00</option>";
							echo "<option value=\"11:00\">11:00</option>";
							echo "<option value=\"13:00\" selected>13:00</option>";
							echo "<option value=\"15:00\">15:00</option>";
							echo "<option value=\"17:00\">17:00</option>";
							echo "<option value=\"19:00\">19:00</option>";
							echo "<option value=\"21:00\">21:00</option>";
						}
						if ($row['out_time'] == "15:00"){
							echo "<option value=\"09:00\">09:00</option>";
							echo "<option value=\"11:00\">11:00</option>";
							echo "<option value=\"13:00\">13:00</option>";
							echo "<option value=\"15:00\" selected>15:00</option>";
							echo "<option value=\"17:00\">17:00</option>";
							echo "<option value=\"19:00\">19:00</option>";
							echo "<option value=\"21:00\">21:00</option>";
						}
						if ($row['out_time'] == "17:00"){
							echo "<option value=\"09:00\">09:00</option>";
							echo "<option value=\"11:00\">11:00</option>";
							echo "<option value=\"13:00\">13:00</option>";
							echo "<option value=\"15:00\">15:00</option>";
							echo "<option value=\"17:00\" selected>17:00</option>";
							echo "<option value=\"19:00\">19:00</option>";
							echo "<option value=\"21:00\">21:00</option>";
						}
						if ($row['out_time'] == "19:00"){
							echo "<option value=\"09:00\">09:00</option>";
							echo "<option value=\"11:00\">11:00</option>";
							echo "<option value=\"13:00\">13:00</option>";
							echo "<option value=\"15:00\">15:00</option>";
							echo "<option value=\"17:00\">17:00</option>";
							echo "<option value=\"19:00\" selected>19:00</option>";
							echo "<option value=\"21:00\">21:00</option>";
						}
						if ($row['out_time'] == "21:00"){
							echo "<option value=\"09:00\">09:00</option>";
							echo "<option value=\"11:00\">11:00</option>";
							echo "<option value=\"13:00\">13:00</option>";
							echo "<option value=\"15:00\">15:00</option>";
							echo "<option value=\"17:00\">17:00</option>";
							echo "<option value=\"19:00\">19:00</option>";
							echo "<option value=\"21:00\" selected>21:00</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Vehicle to export the containers</td>
			<td>:</td>
			<td>
				<select name="vehicle" style="width:255px;">
					<?php
						if($outboundid == 0){
							while($vrow = $vecinfo->fetch_assoc()){
								echo "<option value=\"".$vrow['ve_id']."\">".$vrow['ve_no']."</option>";
							}
						}
						else{
							echo "<option value=\"".$row['out_vehicle']."\" selected>".$singlevecrow['ve_no']."</option>";
							while($vrow = $vecinfo->fetch_assoc()){
								if($row['out_vehicle'] != $vrow['ve_id']){
									echo "<option value=\"".$vrow['ve_id']."\">".$vrow['ve_no']."</option>";
								}
							}
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
					<?php
						if ($row['out_to'] == "South East Asia"){
							echo "<option value=\"South East Asia\" selected>South East Asia</option>";
							echo "<option value=\"South Central\">South Central</option>";
							echo "<option value=\"Central India\">Central India</option>";
							echo "<option value=\"West Europe\">West Europe</option>";
						}
						else if ($row['out_to'] == "South Central"){
							echo "<option value=\"South East Asia\">South East Asia</option>";
							echo "<option value=\"South Central\" selected>South Central</option>";
							echo "<option value=\"Central India\">Central India</option>";
							echo "<option value=\"West Europe\">West Europe</option>";
						}
						else if ($row['out_to'] == "Central India"){
							echo "<option value=\"South East Asia\">South East Asia</option>";
							echo "<option value=\"South Central\">South Central</option>";
							echo "<option value=\"Central India\" selected>Central India</option>";
							echo "<option value=\"West Europe\">West Europe</option>";
						}
						else if ($row['out_to'] == "West Europe"){
							echo "<option value=\"South East Asia\">South East Asia</option>";
							echo "<option value=\"South Central\">South Central</option>";
							echo "<option value=\"Central India\">Central India</option>";
							echo "<option value=\"West Europe\" selected>West Europe</option>";
						}
					?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right"><input type="submit" value="Update" name="update"></td>
		</tr>
	</form>
	<tr>
		<td>
			<?php
				if(isset($_POST['update'])){
					$date = $_POST['date'];
					$time = $_POST['time'];
					$vehicle = $_POST['vehicle'];
					$to = $_POST['to'];
					$inboundid = $row['out_inboundid'];
					$out->updateoutbound($date, $time, $vehicle, $to, $outboundid, $inboundid);
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
