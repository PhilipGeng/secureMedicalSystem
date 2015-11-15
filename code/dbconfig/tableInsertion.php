<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
include("link.php");

$query = "INSERT INTO doctor VALUES
('D001','12345','Dr. Peter','0'),
('D002','12345','Dr. Henry','0'),
('D003','12345','Dr. Jerry','0'),
('D004','12345','Dr. Grace','0');
";
$result = mysql_query($query);
if($result) echo "insert doctor value success";
else echo "insert doctor value fail".mysql_error();
echo "<br>";

$query = "INSERT INTO patient VALUES
('P001','12345','P. Tom','M',15,'0'),
('P002','12345','P. Joe','M',25,'0'),
('P003','12345','P. Amy','F',35,'0'),
('P004','12345','P. Ben','M',45,'0'),
('P005','12345','P. Jay','M',55,'0'),
('P006','12345','P. Kay','F',65,'0'),
('P007','12345','P. Lee','F',75,'0');
";
$result = mysql_query($query);
if($result) echo "insert patient success";
else echo "insert patient fail".mysql_error();
echo "<br>";

$query = "INSERT INTO diagnosis VALUES
('DN001','sore throat','2015-1-1','D001','P001'),
('DN002','sneeze','2015-1-15','D002','P002'),
('DN003','high temperature','2015-1-30','D003','P003'),
('DN004','powerless','2015-2-1','D004','P004'),
('DN005','diarrhoea','2015-2-15','D001','P005'),
('DN006','need rest','2015-2-30','D001','P006'),
('DN007','flu','2015-3-1','D002','P007'),
('DN008','need exercise','2015-3-15','D003','P008'),
('DN009','headache','2015-3-15','D001','P002'),
('DN010','surgery recovery','2015-3-15','D003','P004');
";
$result = mysql_query($query);
if($result) echo "insert success";
else echo "insert fail";
echo "<br>";

$query = "INSERT INTO prescription VALUES
('DN001','M001','1'),
('DN001','M002','5'),
('DN002','M003','1'),
('DN003','M004','3'),
('DN005','M005','5'),
('DN007','M002','3'),
('DN009','M001','10'),
('DN0010','M004','2');
";
$result = mysql_query($query);
if($result) echo "insert success";
else echo "insert fail";
echo "<br>";

$query = "INSERT INTO medicine VALUES
('M001','Aspirin','relieve minor aches and pains'),
('M002','Vitamin C','essential nutrient'),
('M003','Paracetamol ','reduce fever'),
('M004','amylaceum','supply energy'),
('M005','Berberine Hydrochloride ','cure diarrhoea')
;
";
$result = mysql_query($query);
if($result) echo "insert success";
else echo "insert fail";
echo "<br>";

$query = "INSERT INTO salt VALUES
('D001','0'),
('D002','0'),
('D003','0'),
('D004','0'),
('P001','0'),
('P002','0'),
('P003','0'),
('P004','0'),
('P005','0'),
('P006','0'),
('P007','0');
";
$result = mysql_query($query);
if($result) echo "insert success";
else echo "insert fail";
echo "<br>";
?>
</html>	