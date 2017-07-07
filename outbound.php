<?php
	class outbound{
		
		public function getallinfo(){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM outbound_t";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		public function newoutbound($date, $from, $yard, $time, $noofcontainer, $vehicle, $to, $inboundid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			if($date == NULL OR $from == NULL OR $yard == NULL OR $time == NULL OR $noofcontainer == NULL OR $vehicle == NULL OR $to == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{
				$checktruck = "SELECT in_vehicle, in_date FROM inbound_t WHERE in_vehicle = '$vehicle' AND in_date = '$date'";
				$res1 = $conn->query($checktruck);
				if ($res1->num_rows > 0) {
					echo "<script type='text/javascript'>alert('This vehicle is busy inbound on ".$date." !');</script>";
				}
				else{
					$checkoutboundtruck = "SELECT out_vehicle, out_date FROM outbound_t WHERE out_vehicle = '$vehicle' AND out_date = '$date'";
					$res2 = $conn->query($checkoutboundtruck);
					if($res2->num_rows > 0){
						echo "<script type='text/javascript'>alert('This vehicle is busy with outbound on ".$date." !');</script>";
					}
					else{
						include_once 'yard.php';
						$yardc = new yard();
						$validate = $yardc->addspace($yard, $noofcontainer);

						$insert = "INSERT INTO outbound_t (out_date, out_from, out_fromyard, out_time, out_container, out_vehicle, out_to, out_status, out_inboundid) VALUES ('".$date."', '".$from."', '".$yard."', '".$time."', '".$noofcontainer."', '".$vehicle."', '".$to."', '0', '".$inboundid."')";
						$conn->query($insert);
						$inboundtstatus = "UPDATE inbound_t SET in_status = '2' WHERE in_id = '$inboundid'";
						$conn->query($inboundtstatus);
						echo "<script type='text/javascript'>alert('Outbound request successfully added!');window.location='inbound_list.php';</script>";
					}					
				}
			}	
		}
		
		public function getinfo($outboundid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM outbound_t WHERE out_id = '$outboundid'";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		public function updateoutbound($date, $time, $vehicle, $to, $outboundid, $inboundid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);
			
			if($date == NULL OR $time == NULL OR $vehicle == NULL OR $to == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{			
				$checktruck = "SELECT in_vehicle, in_date FROM inbound_t WHERE in_id != '$inboundid' AND in_vehicle = '$vehicle' AND in_date = '$date'";
				$res1 = $conn->query($checktruck);
				if ($res1->num_rows > 0) {
					echo "<script type='text/javascript'>alert('This vehicle is busy with inbound on ".$date." !');</script>";
				}
				else{
					$checkoutboundtruck = "SELECT out_vehicle, out_date FROM outbound_t WHERE out_id != '$outboundid' AND out_vehicle = '$vehicle' AND out_date = '$date'";
					$res2 = $conn->query($checkoutboundtruck);
					if($res2->num_rows > 0){
						echo "<script type='text/javascript'>alert('This vehicle is busy with outbound on ".$date." !');</script>";
					}
					else{
						$update = "UPDATE outbound_t SET out_date = '$date', out_time = '$time', out_vehicle = '$vehicle', out_to = '$to' WHERE out_id = '$outboundid'";
						$conn->query($update);
						echo "<script type='text/javascript'>alert('Outbound request successfully updated!');window.location='outbound_list.php';</script>";
					}
				}
			}
		}
		
		public function confirmoutbound($pickup, $outboundid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			if($pickup == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{
				$update = "UPDATE outbound_t SET out_status = '1', out_pickup = '$pickup' WHERE out_id = '$outboundid'";
				$conn->query($update);
				echo "<script type='text/javascript'>alert('Outbound request successfully confirmed ! This outbound cannot be updated or deleted anymore.');window.location='outbound_list.php';</script>";
			}
		}
	}
?>