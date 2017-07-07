<!Doctype html>
<html>
<?php	
	include 'customer.php';
	$cus = new customer();
	
	include 'vehicle.php';
	$vec = new vehicle();
	
	include 'yard.php';
	$yard = new yard();
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

<table style="width:100%;" align="center">
	<tr>
		<td colspan="3" align="left"><h3>Inbound List:</h3></td>
		<td colspan="2" align="right"><a href="inbound_manage.php"><button type="button"><img src="logo/create.png" width="15px" height="15px"></img>New inbound</button></a></td>
	</tr>
</table>

<table style="width:100%;" class="table" align="center">
	<tr>
		<th>No.</th>
		<th>Date (yyyy-mm-dd)</th>
		<th>From</th>
		<th>To yard</th>
		<th>Number of containers</th>
		<th>Import Vehicle</th>
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
		$sql = "SELECT * FROM inbound_t ORDER BY in_date desc, in_vehicle";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$no = 0;
			$status = "";
			while($row = $result->fetch_assoc()) {
				$no++;
				if($row['in_status'] == 0){
					$status = "Pending";
				}
				else if($row['in_status'] == 1){
					$status = "Confirmed";
				}
				else{
					$status = "Outbounded";
				}
				$singlecus = $cus->getinfo($row['in_from']);
				$singlecusrow = $singlecus->fetch_assoc();
				$cusname = $singlecusrow['cus_name'];
				
				$singlevec = $vec->getinfo($row['in_vehicle']);
				$singlevecrow = $singlevec->fetch_assoc();
				$vecno = $singlevecrow['ve_no'];
				
				$singleyard = $yard->getinfo($row['in_yard']);
				$singleyardrow = $singleyard->fetch_assoc();
				$yardname = $singleyardrow['yard_name'];
				
				echo "<tr>";
				echo "<td>".$no."</td>";
				echo "<td>".$row['in_date']."</td>";
				echo "<td>".$cusname."</td>";
				echo "<td>".$yardname."</td>";
				echo "<td>".$row['in_container']."</td>";
				echo "<td>".$vecno."</td>";
				echo "<td>".$status."</td>";
				
				$date1=date_create(date('Y-m-d'));
				$date2=date_create($row['in_date']);
				$diff=date_diff($date1,$date2);
				$days = $diff->format("%R");
				
				if($row['in_status'] == 0){
					echo "<td><a href=\"inbound_list.php?confirm={$row['in_id']}\" onclick=\"return confirm('Are you sure? You may not edit it once you had confirmed it.')\" title=\"Confirm This Inbound\"><img src=\"logo/confirm.png\" width=\"15px\" height=\"15px\"></img></a><a href=\"inbound_manage.php?edit={$row['in_id']}\" target=\"_parent\"><img src=\"logo/edit.png\" width=\"15px\" height=\"15px\" title=\"Update This Inbound\"></img></a>&nbsp;<a href=\"inbound_list.php?remove={$row['in_id']}&yardid={$row['in_yard']}&noofcontainer={$row['in_container']}\" onclick=\"return confirm('Are you sure?')\" title=\"Delete This Inbound\"><img src=\"logo/remove.png\" width=\"15px\" height=\"15px\"></img></a></td>";
				}
				else if($row['in_status'] == 1){
					if($days == "-"){
						echo "<td><a href=\"inbound_outbound.php?outbound={$row['in_id']}\" onlick=\"return confirm('Are you sure to perform outbound on this record?')\"><img src=\"logo/send.png\" height=\"15px\" width=\"15px\" title=\"Perform outbound\"></img></a></td>";
					}
					else{
						echo "<td><img src=\"logo/not_send.png\" height=\"15px\" width=\"15px\" title=\"Cannot perform outbound as inbound is not completed\"></img></td>";
					}
				}
				else{
					echo "<td><img src=\"logo/minus.png\" height=\"15px\" width=\"15px\" title=\"Cannot edit or delete this data\"></img></td>";
				}
				echo "</tr>";
			}
		}
		else{
			echo "<tr><td colspan=\"8\">NO results yet.</td></tr>";
		}
		
		if(isset($_GET['confirm'])){
			$inboundid = $_GET['confirm'];
			$sql = "UPDATE inbound_t SET in_status = '1' WHERE in_id = '$inboundid'";
			$conn->query($sql);
			echo '<html><script>window.location="inbound_list.php"</script></html>';
		}
		
		if(isset($_GET['remove'])){
			$inboundid = $_GET['remove'];
			$yardid = $_GET['yardid'];
			$noofcontainer = $_GET['noofcontainer'];
			$yard->addspace($yardid, $noofcontainer);
			$sql = "DELETE FROM inbound_t WHERE in_id = '$inboundid'";
			$conn->query($sql);
			echo '<html><script>window.location="inbound_list.php"</script></html>';
		}
	?>
</table>
</div>
<div class="footer">
	<table style="width:100%; text-align:right;">
		<tr><td>©Maersk Line CMS Copyright 2017.</td></tr>
	</table>
</div>
</body>
</html>