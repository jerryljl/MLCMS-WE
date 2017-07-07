<?php
	class inbound{
		
		public function getallinfo(){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM inbound_t";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		public function newinbound($date, $from, $yard, $noofcontainer, $vehicle){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			if($date == NULL OR $from == NULL OR $yard == NULL OR $noofcontainer == NULL OR $vehicle == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{
				$checktruck = "SELECT in_vehicle, in_date FROM inbound_t WHERE in_vehicle = '$vehicle' AND in_date = '$date'";
				$res1 = $conn->query($checktruck);
				if ($res1->num_rows > 0) {
					echo "<script type='text/javascript'>alert('This vehicle is not free on ".$date." !');</script>";
				}
				else{
					include_once 'yard.php';
					$yardc = new yard();
					$validate = $yardc->minusspace($yard, $noofcontainer);
					
					if($validate == 1){
						echo "<script type='text/javascript'>alert('Inbound request rejected due to insufficient space in the selected yard !');</script>";
					}
					else if($validate == 2){
						$insert = "INSERT INTO inbound_t (in_date, in_from, in_yard, in_container, in_vehicle, in_status) VALUES ('".$date."', '".$from."', '".$yard."', '".$noofcontainer."', '".$vehicle."', '0')";
						$conn->query($insert);
						echo "<script type='text/javascript'>alert('Inbound request successfully added!');window.location='inbound_list.php';</script>";
					}				
				}
			}	
		}
		
		public function getinfo($inboundid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM inbound_t WHERE in_id = '$inboundid'";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		public function updateinbound($date, $from, $yard, $noofcontainer, $vehicle, $inboundid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";
			$current = 0;

			$conn = new mysqli($servername, $username, $password, $dbname);
			
			$getcurrent = "SELECT in_container FROM inbound_t WHERE in_id = '$inboundid'";
			$result = $conn->query($getcurrent);
			$row = $result->fetch_assoc();
			$current = $row['in_container'];
			
			if($date == NULL OR $from == NULL OR $yard == NULL OR $noofcontainer == NULL OR $vehicle == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{
				$getcurrent = "SELECT in_vehicle, in_date FROM inbound_t WHERE in_id = '$inboundid'";
				$getres1 = $conn->query($getcurrent);
				$getrow1 = $getres1->fetch_assoc();
				if($getrow1['in_vehicle'] == $vehicle AND $getrow1['in_date'] == $date){
					include_once 'yard.php';
					$yardc = new yard();
					$validate = $yardc->updatespace($yard, $noofcontainer, $current);
					
					if($validate == 1){
						echo "<script type='text/javascript'>alert('Inbound update request rejected due to insufficient space in the selected yard !');</script>";
					}
					else if($validate == 2){
						$update = "UPDATE inbound_t SET in_date = '$date', in_from = '$from', in_yard = '$yard', in_container ='$noofcontainer', in_vehicle = '$vehicle' WHERE in_id = '$inboundid'";
						$conn->query($update);
						echo "<script type='text/javascript'>alert('Inbound request successfully updated!');window.location='inbound_list.php';</script>";
					}
				}
				else{
					$checktruck = "SELECT in_vehicle, in_date FROM inbound_t WHERE in_vehicle = '$vehicle' AND in_date = '$date'";
					$res1 = $conn->query($checktruck);
					if ($res1->num_rows > 0) {
						echo "<script type='text/javascript'>alert('This vehicle is not free on ".$date." !');</script>";
					}
					else{
						include_once 'yard.php';
						$yardc = new yard();
						$validate = $yardc->updatespace($yard, $noofcontainer, $current);
						
						if($validate == 1){
							echo "<script type='text/javascript'>alert('Inbound update request rejected due to insufficient space in the selected yard !');</script>";
						}
						else if($validate == 2){
							$update = "UPDATE inbound_t SET in_date = '$date', in_from = '$from', in_yard = '$yard', in_container ='$noofcontainer', in_vehicle = '$vehicle' WHERE in_id = '$inboundid'";
							$conn->query($update);
							echo "<script type='text/javascript'>alert('Inbound request successfully updated!');window.location='inbound_list.php';</script>";
						}
					}					
				}
			}
		}
	}
?>