<?php
	$mysqli = new mysqli("localhost", "polyu", "comp3334", "medical");
	if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		exit();
	}else{
		echo "connected";
	}
?>
