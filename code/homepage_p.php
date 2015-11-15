<html>
<head>
</head>
<body>
<?php
    include 'dbconfig/link2.php';
    include 'functions.php';

    sec_session_start();
     $ret = "patient_login.html";

/*  uncomment this
     if(empty($_SESSION))
	header('Location: '.$ret);
*/

     $name = "P. Tom"; // change here to the session variable
    $uid = 'P001'; // change here to the session variable
    $sql = "SELECT distinct doctor.name,doctor.doctor_id,diagnosis.description,diagnosis.time,medicine.name,prescription.quantity,medicine.description FROM diagnosis,medicine,doctor,patient,prescription WHERE diagnosis.patient_id = '$uid' and diagnosis.doctor_id = doctor.doctor_id and diagnosis.patient_id = patient.patient_id and prescription.diag_id = diagnosis.diag_id and prescription.medicine_id = medicine.medicine_id ORDER BY `patient`.`patient_id` ASC";
    $result = mysqli_query($connection, $sql);

?>
hi, dear <?php echo $name; ?>  <a href = "sessiondestroy.php"><span style="float:right">quit</span></a>
<hr>  
<?php
	echo "<div>";
	while($row = mysqli_fetch_row($result)){
		echo "doctor name: ".$row[0]."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp id: ".$row[1]."<br>";
		echo "time: ".$row[3]." &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspdiagnosis: ".$row[2]."<br>";
		echo "medicine: ".$row[4]."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp quantity: ".$row[5]." &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspdescription: ".$row[6]."<br><hr>";
	}
	echo "</div>";
?>
</body>
</html>