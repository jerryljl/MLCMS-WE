<?php
	class yard{
		
		public function getallinfo(){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM yard_t";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		/*public function newyard($name, $limit, $current){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			if($name == NULL OR $limit == NULL OR $current == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{
				$checkdupname = "SELECT yard_name FROM yard_t WHERE yard_name = '$name'";
				$res1 = $conn->query($checkdupname);
				if ($res1->num_rows > 0) {
					echo "<script type='text/javascript'>alert('This yard had been added before!');</script>";
				}
				else{
					$insert = "INSERT INTO yard_t (yard_name, yard_limit, yard_current) VALUES ('".$name."', '".$limit."', '".$current."')";
					$conn->query($insert);
					echo "<script type='text/javascript'>alert('Yard successfully added!');window.location='yard_list.php';</script>";
				}
			}	
		}*/
		
		public function getinfo($yardid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM yard_t WHERE yard_id = '$yardid'";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		public function minusspace($yardid, $noofcontainer){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";
			$current = 0;
			$newcurrent = 0;
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			$getcurrentspace = "SELECT yard_current FROM yard_t WHERE yard_id = '$yardid'";
			$result = $conn->query($getcurrentspace);
			$row = $result->fetch_assoc();
			
			$current = $row['yard_current'];
			$newcurrent = $current - $noofcontainer;
			
			if($newcurrent < 0){
				return 1;
			}
			else if($newcurrent >= 0){
				$updatecurrent = "UPDATE yard_t SET yard_current = '$newcurrent' WHERE yard_id = '$yardid'";
				$conn->query($updatecurrent);
				return 2;
			}
		}
		
		public function addspace($yardid, $noofcontainer){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";
			$current = 0;
			$newcurrent = 0;
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			$getcurrentspace = "SELECT yard_current FROM yard_t WHERE yard_id = '$yardid'";
			$result = $conn->query($getcurrentspace);
			$row = $result->fetch_assoc();
			
			$current = $row['yard_current'];
			$newcurrent = $current + $noofcontainer;

			$updatecurrent = "UPDATE yard_t SET yard_current = '$newcurrent' WHERE yard_id = '$yardid'";
			$conn->query($updatecurrent);
		}
		
		public function updatespace($yardid, $noofcontainer, $current){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";
			$newcurrent = 0;
			$newspace = 0;
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			$getcurrentspace = "SELECT yard_current FROM yard_t WHERE yard_id = '$yardid'";
			$result = $conn->query($getcurrentspace);
			$row = $result->fetch_assoc();
			
			$currentspace = $row['yard_current'];
			$newcurrent = $currentspace + $current;
			$newspace = $newcurrent - $noofcontainer;
			
			if($newspace < 0){
				return 1;
			}
			else if($newspace >= 0){
				$updatecurrent = "UPDATE yard_t SET yard_current = '$newspace' WHERE yard_id = '$yardid'";
				$conn->query($updatecurrent);
				return 2;
			}
		}
	}
?>