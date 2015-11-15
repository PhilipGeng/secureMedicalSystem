<?php
	include_once 'functions.php';
	sec_session_start();
	
	if(isset($_POST['doctor_id'], $_POST['password'])) {
		$doctor_id = $_POST['doctor_id'];
		$password = $_POST['password'];
		if(($status = doctor_login($doctor_id, $password, $mysqli)) == 1) {
			header('Location: ../doc_homepage.php');
		} else {
			if($status == 0){
				header('Location: bfdetect.php');
			}
			else{
				header('Location: error.php');
			}
		}
	} else {
		echo 'invalid request';
	}
?>