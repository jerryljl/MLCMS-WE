<!Doctype html>
<html>

<body>
<title>Customer List</title>
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
		<td colspan="3" align="left"><h3>Customer List:</h3></td>
		<td colspan="2" align="right"><a href="customer_manage.php"><button type="button"><img src="logo/create.png" width="15px" height="15px"></img> Add new customer</button></a></td>
	</tr>
</table>

<table style="width:100%;" class="table" align="center">
	<tr>
		<th>No.</th>
		<th>Name</th>
		<th>Contact Number</th>
		<th>Fax Number</th>
		<th>E-mail address</th>
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
		$sql = "SELECT * FROM customer_t";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$no = 0;	
			while($row = $result->fetch_assoc()) {
				$no++;
				echo "<tr>";
				echo "<td>".$no."</td>";
				echo "<td>".$row['cus_name']."</td>";
				echo "<td>".$row['cus_contact']."</td>.";
				echo "<td>".$row['cus_fax']."</td>.";
				echo "<td>".$row['cus_email']."</td>";
				echo "<td><a href=\"customer_manage.php?edit={$row['cus_id']}\" target=\"_parent\"><img src=\"logo/edit.png\" width=\"15px\" height=\"15px\" title=\"Update This Customer\"></img></a>&nbsp;<a href=\"customer_list.php?remove={$row['cus_id']}\" onclick=\"return confirm('Are you sure?')\" title=\"Delete This Customer\"><img src=\"logo/remove.png\" width=\"15px\" height=\"15px\"></img></a></td>";
				echo "</tr>";
			}
		}
		else{
			echo "<tr><td colspan=\"6\">NO results yet.</td></tr>";
		}
			
		if(isset($_GET['remove'])){
			$cusid = $_GET['remove'];
			$sql = "DELETE FROM customer_t WHERE cus_id = '$cusid'";
			$conn->query($sql);
			echo '<html><script>window.location="customer_list.php"</script></html>';
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