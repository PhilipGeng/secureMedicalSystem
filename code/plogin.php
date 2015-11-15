<html>
    <head><title>doctor authen page</title></head>
    <body>
    <?php include 'dbconfig/link2.php';?>
    <?php
	$patient_id = $_POST['patient_id'];
	$password = $_POST['password'];
	echo $patient_id . " " . $password;


	echo "<p>testing for fetch data in patient table</p>";
	$sql = "SELECT patient_id, name, password FROM patient";
	$result = mysqli_query($connection, $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
		echo "id: " . $row["patient_id"]. " - Name: " . $row["name"]. " " . $row["password"]. "<br>";
	    }
	} else {
	    echo "0 results";
	}

	mysqli_close($connection);	
    ?>
    </body>
</html>
