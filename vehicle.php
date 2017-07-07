<?php
	class vehicle{
		
		public function getallinfo(){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM vehicle_t";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		public function register($no){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			if($no == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{
				$checkdupno = "SELECT ve_no FROM vehicle_t WHERE ve_no = '$no'";
				$res1 = $conn->query($checkdupno);
				if ($res1->num_rows > 0) {
					echo "<script type='text/javascript'>alert('This plate number had been registered before!');</script>";
				}
				else{
					$insert = "INSERT INTO vehicle_t (ve_no) VALUES ('".$no."')";
					$conn->query($insert);
					echo "<script type='text/javascript'>alert('Vehicle successfully registered!');window.location='truck_list.php';</script>";
				}
			}	
		}
		
		public function getinfo($truckid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM vehicle_t WHERE ve_id = '$truckid'";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		public function update($no, $truckid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			if($no == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{
				$getno = "SELECT ve_no FROM vehicle_t WHERE ve_id = '$truckid'";
				$res1 = $conn->query($getno);
				$row1 = $res1->fetch_assoc();
				if ($row1['ve_no'] == $no) {
					echo "<script type='text/javascript'>alert('This plate number had been registered before!');</script>";
				}
				else{
					$checkdupno = "SELECT ve_no FROM vehicle_t WHERE ve_no = '$no'";
					$res2 = $conn->query($checkdupno);
					if($res2->num_rows > 0){
						echo "<script type='text/javascript'>alert('This plate number had been registered before!');</script>";
					}
					else{
						$insert = "UPDATE vehicle_t SET ve_no = '$no' WHERE ve_id = '$truckid'";
						$conn->query($insert);
						echo "<script type='text/javascript'>alert('Vehicle successfully updated!');window.location='truck_list.php';</script>";
					}
				}
			}		
		}
	}
?>