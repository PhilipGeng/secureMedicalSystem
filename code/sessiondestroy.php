<?php
	session_start();
	session_destroy();
	header("Location: login/doc_login.php");

?>