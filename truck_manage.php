<!Doctype html>
<html>
<?php
	include 'vehicle.php';
	$truck = new vehicle();
	if(isset($_GET['edit'])){
		$truckid = $_GET['edit'];
		$info = $truck->getinfo($truckid);
		$row = $info->fetch_assoc();
	}
	else{
		$truckid = 0;
	}
?>
<body>
<title>Vehicle List</title>
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
			<td colspan="3"><h3>Vehicle Information:</h3></td>
		</tr>
		<tr>
			<td>Vehicle Plate Number</td>
			<td>:</td>
			<td><input type="text" name="no" style="width:250px;" value="<?php if($truckid == 0){ echo ""; } else{ echo $row['ve_no']; } ?>"></td>
			<td><input type="submit" value="<?php if($truckid == 0){ echo "Submit"; } else{ echo "Update"; } ?>" name="<?php if($truckid == 0){ echo "submit"; } else{ echo "update"; } ?>"></td>
		</tr>
	</form>
	<tr>
		<td>
			<?php
				if(isset($_POST['submit'])){
					$no = $_POST['no'];				
					$truck->register($no);
				}
			?>
			
			<?php
				if(isset($_POST['update'])){
					$no = $_POST['no'];
					$truck->update($no, $truckid);
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