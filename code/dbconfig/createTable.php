<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
include("link.php");



$query = "CREATE TABLE salt(
	account_id VARCHAR(32) DEFAULT '' NOT NULL,
	salt VARCHAR(32) DEFAULT'' NOT NULL,
	PRIMARY KEY (account_id)
);";
$result = mysql_query($query);
if($result) echo "create salt table success";
else echo "create salt table fail";
echo "<br>";
?>
</html>	