<!Doctype html>
<html>
<?php
	include 'vehicle.php';
	$vec = new vehicle();
	
	include 'yard.php';
	$yard = new yard();
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

<table style="width:100%;" align="center">
	<tr>
		<td colspan="3" align="left"><h3>Outbound List:</h3></td>
	</tr>
</table>

<table style="width:100%;" class="table" align="center">
	<tr>
		<th>No.</th>
		<th>Date (yyyy-mm-dd)</th>
		<th>Time</th>
		<th>To</th>
		<th>Export vehicle</th>
		<th>Number of containers</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	<?php
		$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
		$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
		$password = "demo@pass123";
		$dbname = "ddac";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT * FROM outbound_t ORDER BY out_date desc, out_time desc, out_vehicle";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$no = 0;
			$status = "";
			while($row = $result->fetch_assoc()) {
				$no++;
				if($row['out_status'] == 0){
					$status = "Booked";
				}
				else if($row['out_status'] == 1){
					$status = "Confirmed";
				}
				$singlevec = $vec->getinfo($row['out_vehicle']);
				$singlevecrow = $singlevec->fetch_assoc();
				$vecno = $singlevecrow['ve_no'];
				
				echo "<tr>";
				echo "<td>".$no."</td>";
				echo "<td>".$row['out_date']."</td>";
				echo "<td>".$row['out_time']."</td>";
				echo "<td>".$row['out_to']."</td>";
				echo "<td>".$vecno."</td>";
				echo "<td>".$row['out_container']."</td>";
				echo "<td>".$status."</td>";
				
				if($row['out_status'] == 0){
					echo "<td><a href=\"outbound_confirm.php?confirm={$row['out_id']}\" title=\"Confirm This Outbound\"><img src=\"logo/confirm.png\" width=\"15px\" height=\"15px\"></img></a><a href=\"outbound_manage.php?edit={$row['out_id']}\" target=\"_parent\"><img src=\"logo/edit.png\" width=\"15px\" height=\"15px\" title=\"Update This Outbound\"></img></a>&nbsp;<a href=\"outbound_list.php?remove={$row['out_id']}&inboundid={$row['out_inboundid']}&yardid={$row['out_fromyard']}&noofcontainer={$row['out_container']}\" onclick=\"return confirm('Are you sure?')\" title=\"Delete This Outbound\"><img src=\"logo/remove.png\" width=\"15px\" height=\"15px\"></img></a></td>";
				}
				else{
					echo "<td><a href=\"outbound_detail.php?outboundid={$row['out_id']}\" title=\"View This Outbound\"><img src=\"logo/view.png\" width=\"15px\" height=\"15px\"></img></a></td>";
				}
				echo "</tr>";
			}
		}
		else{
			echo "<tr><td colspan=\"7\">NO results yet.</td></tr>";
		}
		
		if(isset($_GET['remove'])){
			$outboundid = $_GET['remove'];
			$yardid = $_GET['yardid'];
			$noofcontainer = $_GET['noofcontainer'];
			$inboundid = $_GET['inboundid'];
			$validate = $yard->minusspace($yardid, $noofcontainer);
			
			if($validate == 1){
				echo "<script type='text/javascript'>alert('Outbound delete request rejected due to insufficient space in the selected yard !');</script>";
			}
			else if($validate == 2){
				$changestatus = "UPDATE inbound_t SET in_status = '1' WHERE in_id = '$inboundid'";
				$conn->query($changestatus);
				$sql = "DELETE FROM outbound_t WHERE out_id = '$outboundid'";
				$conn->query($sql);
				echo '<html><script>window.location="outbound_list.php"</script></html>';
			}			
		}
	?>
</table>
</div>
<div class="footer">
	<table style="width:100%; text-align:right;">
		<tr><td>?Maersk Line CMS Copyright 2017.</td></tr>
	</table>
</div>
</body>
</html>