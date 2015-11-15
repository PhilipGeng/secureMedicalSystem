<html>
    <head><title>doctor authen page</title></head>
    <body>
    <?php include 'dbconfig/link2.php';?>
    <?php
	include 'functions.php';
	sec_session_start();

	$error = "doctor_login_error.html";
	$doctor_id = $_POST['doctor_id'];
	$password = $_POST['password'];
	if(!empty($doctor_id)&&!empty($password)){
		$sql = "SELECT doctor_id,name FROM doctor WHERE doctor_id='$doctor_id' and password ='$password'  ";
		$result = mysqli_query($connection, $sql);
		$row = mysqli_fetch_array($result);
		if(!empty($row)){
			$_SESSION['ID'] = $row[0];
			$_SESSION['NAME'] = $row[1];
			echo "ID: ".$row[0];
			echo "<br>name: ".$row[1];
		}
		else{//fail
			header('Location: '.$error);
		}
	}
	else{//fail
		header('Location: '.$error);
	}
	
	$sql = "SELECT doctor_id,name FROM doctor WHERE doctor_id='$doctor_id' and password ='$password'  ";
	$result = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($result);
	
	
/*
	echo $doctor_id . " " . $password;

	echo "<p>testing for fetch data in patient table</p>";
	$sql = "SELECT doctor_id, name FROM doctor";
	$result = mysqli_query($connection, $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
		echo "id: " . $row["patient_id"]. " - Name: " . $row["name"]. " " . $row["password"]. "<br>";
	    }
	} else {
	    echo "0 results";
	}
*/
	mysqli_close($connection);	

    ?>
    </body>
</html>
