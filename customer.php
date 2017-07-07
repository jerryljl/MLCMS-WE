<?php
	class customer{
		
		public function getallinfo(){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM customer_t";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		public function register($name, $contact, $fax, $email){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";
			$finalfax = "";

			$conn = new mysqli($servername, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			if($name == NULL OR $contact == NULL OR $email == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{
				$checkdupname = "SELECT cus_name FROM customer_t WHERE cus_name = '$name'";
				$res1 = $conn->query($checkdupname);
				if ($res1->num_rows > 0) {
					echo "<script type='text/javascript'>alert('This customer name had been registered before!');</script>";
				}
				else{
					$checkdupemail = "SELECT cus_email FROM customer_t WHERE cus_email = '$email'";
					$res2 = $conn->query($checkdupemail);
					if ($res2->num_rows > 0) {
						echo "<script type='text/javascript'>alert('This E-mail had been registered before!');</script>";
					}
					else{
						if($fax == NULL){
							$finalfax = "-";
						}
						else{
							$finalfax = $fax;
						}
						$insert = "INSERT INTO customer_t (cus_name, cus_contact, cus_fax, cus_email) VALUES ('".$name."', '".$contact."', '".$fax."', '".$email."')";
						$conn->query($insert);
						echo "<script type='text/javascript'>alert('Customer successfully registered!');window.location='customer_list.php';</script>";
					}
				}
			}		
		}
		
		public function getinfo($cusid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";

			$conn = new mysqli($servername, $username, $password, $dbname);

			$getinfo = "SELECT * FROM customer_t WHERE cus_id = '$cusid'";
			$result = $conn->query($getinfo);
			
			return $result;
		}
		
		public function update($name, $contact, $fax, $email, $cusid){
			$servername = "mlcms-sea-mysqldbserver.mysql.database.azure.com";
			$username = "mlcmsmysqldbuser@mlcms-sea-mysqldbserver";
			$password = "demo@pass123";
			$dbname = "ddac";
			$finalfax = "";

			$conn = new mysqli($servername, $username, $password, $dbname);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			
			if($name == NULL OR $contact == NULL OR $email == NULL){
				echo "<script type='text/javascript'>alert('Please fill in all the information!');</script>";
			}
			else{
				$getname = "SELECT cus_name, cus_email FROM customer_t WHERE cus_id = '$cusid'";
				$getres1 = $conn->query($getname);
				$getrow1 = $getres1->fetch_assoc();
				if($getrow1['cus_name'] == $name AND $getrow1['cus_email'] == $email){
					if($fax == NULL){
						$finalfax = "-";
					}
					else{
						$finalfax = $fax;
					}
					$update1 = "UPDATE customer_t SET cus_name = '$name', cus_contact = '$contact', cus_fax = '$finalfax', cus_email = '$email' WHERE cus_id = '$cusid'";
					$conn->query($update1);
					echo "<script type='text/javascript'>alert('Customer successfully updated!');window.location='customer_list.php';</script>";
				}
				
				else if($getrow1['cus_name'] != $name AND $getrow1['cus_email'] == $email){
					$checkdupname = "SELECT cus_name FROM customer_t WHERE cus_name = '$name'";
					$res1 = $conn->query($checkdupname);
					if ($res1->num_rows > 0) {
						echo "<script type='text/javascript'>alert('This customer name had been registered before!');</script>";
					}
					else{						
						if($fax == NULL){
							$finalfax = "-";
						}
						else{
							$finalfax = $fax;
						}
						$update2 = "UPDATE customer_t SET cus_name = '$name', cus_contact = '$contact', cus_fax = '$finalfax', cus_email = '$email' WHERE cus_id = '$cusid'";
						$conn->query($update2);
						echo "<script type='text/javascript'>alert('Customer successfully updated!');window.location='customer_list.php';</script>";
					}
				}
				
				else if($getrow1['cus_name'] == $name AND $getrow1['cus_email'] != $email){
					$checkdupemail = "SELECT cus_email FROM customer_t WHERE cus_email = '$email'";
					$res2 = $conn->query($checkdupemail);
					if ($res2->num_rows > 1) {
						echo "<script type='text/javascript'>alert('This E-mail had been registered before!');</script>";
					}
					else{						
						if($fax == NULL){
							$finalfax = "-";
						}
						else{
							$finalfax = $fax;
						}
						$update2 = "UPDATE customer_t SET cus_name = '$name', cus_contact = '$contact', cus_fax = '$finalfax', cus_email = '$email' WHERE cus_id = '$cusid'";
						$conn->query($update2);
						echo "<script type='text/javascript'>alert('Customer successfully updated!');window.location='customer_list.php';</script>";
					}
				}

				else if($getrow1['cus_name'] != $name AND $getrow1['cus_email'] != $email){
					$checkdupname2 = "SELECT cus_name FROM customer_t WHERE cus_name = '$name'";
					$res3 = $conn->query($checkdupname2);
					if ($res3->num_rows > 0) {
						echo "<script type='text/javascript'>alert('This customer name had been registered before!');</script>";
					}
					else{
						$checkdupemail2 = "SELECT cus_email FROM customer_t WHERE cus_email = '$email'";
						$res4 = $conn->query($checkdupemail2);
						if ($res4->num_rows > 1) {
							echo "<script type='text/javascript'>alert('This E-mail had been registered before!');</script>";
						}
						else{						
							if($fax == NULL){
								$finalfax = "-";
							}
							else{
								$finalfax = $fax;
							}
							$update2 = "UPDATE customer_t SET cus_name = '$name', cus_contact = '$contact', cus_fax = '$finalfax', cus_email = '$email' WHERE cus_id = '$cusid'";
							$conn->query($update2);
							echo "<script type='text/javascript'>alert('Customer successfully updated!');window.location='customer_list.php';</script>";
						}
					}
				}
			}		
		}
	}
?>