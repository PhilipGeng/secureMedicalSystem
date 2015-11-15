<html>
<head>
</head>
<body>
<?php
    include 'dbconfig/link.php';
    include 'login/functions.php';

    sec_session_start();
    $ret = "login/doc_login.php";

    if(empty($_SESSION))
		header('Location: '.$ret);

    $uid = $_SESSION['doctor_id']; // change here to the session variable
    $sql = "SELECT distinct patient.name,patient.patient_id,patient.gender,patient.age,diagnosis.description,diagnosis.time,medicine.name,prescription.quantity,medicine.description FROM diagnosis,medicine,patient,prescription WHERE diagnosis.doctor_id = '$uid' and diagnosis.patient_id = patient.patient_id and prescription.diag_id = diagnosis.diag_id and prescription.medicine_id = medicine.medicine_id ORDER BY `patient`.`patient_id` ASC";
    $result = mysqli_query($mysqli, $sql);

?>
hi, dear <?php echo $uid; ?>  <a href = "sessiondestroy.php"><span style="float:right">quit</span></a>
<hr>  
<?php
	echo "<div>";
	while($row = mysqli_fetch_row($result)){
		echo "patient name: ".$row[0]."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp id: ".$row[1]."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp gender: ".$row[2]."age: ".$row[3]."<br>";
		echo "time: ".$row[5]." &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspdiagnosis: ".$row[4]."<br>";
		echo "medicine: ".$row[6]."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp quantity: ".$row[7]." &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspdescription: ".$row[8]."<br><hr>";
	}
	echo "</div>";
?>
</body>
</html>