<?php
$errors = array();
	if($_POST) {
//		$username = $_POST['username'];
//		$password = $_POST['password'];
//		$fullName = $_POST['fullname'];
//		$email = $_POST['email'];
		$cuti = $_POST['cuti'];
		$id = 4;
		//validasi
		
		
//		if(strlen(trim($username))<3){
//			array_push($errors,"Username must be at least 3 characters");
//		}		
//		if(strlen(trim($password))<6){
//			array_push($errors,"Password must be at least 6 characters");
//		}
//		if(strlen(trim($fullName))==0){
//			array_push($errors,"FullName must not empty");
//		}
//		if(!filter_var($email,FILTER_VALIDATE_EMAIL))
//			array_push($errors,"Invalid Email");
	
		// validasi error_get_last
		if(count($errors) == 0){
			require_once "database.php";
			$db = new AbsensiDB();
			if($db->insert($id, $cuti)){
				echo"<script> alert('Success');</script>";

			}
            
		
	   }
	}

?>


<html>
	<head> 
		<title> Absensi </title>
	</head>
	
	<body>
		<h1> Absensi</h1>
<!--
		<?php
			if(count($errors)>0){
				echo "<fontcolor = 'red'>";
				echo "<ul>";
					foreach($errors as $e){
						echo "<li>$e</li>";
					}
				
				echo"</ul></font>";
			}
		
		?>
-->
		<form method="post" action ="Absensi.php">
<!--
			Username 
			<input type="text" name="username">
			<br>
			password
			<input type="password" name ="password">
			<br>
			Fullname
			<input type="text" name = "fullname">
			<br>
			Email
			<input type ="email" name = "email">
			<br>
-->
			Cuti
			<select name = "cuti">
				<option value = "1">Cuti</option>
				<option value = "0">No Cuti</option>
			</select>
			<br>
			<input type = "submit" name = "submit" value = "Absensi">
		
		</form>
	</body>
	

</html>