<?php
$conn = mysqli_connect("localhost","root","","seva_sangam_db");
if (isset($_POST['submit'])) {
	require("Classes/PHPExcel.php");
	require("Classes/PHPExcel/IOFactory.php");
	$files = $_FILES['doc']['tmp_name'];
	$obj = PHPExcel_IOFactory::load($files);
	foreach ($obj->getWorksheetIterator() as  $value) {
		$getHighestRow = $value->getHighestRow();
		for ($i=0; $i <=$getHighestRow ; $i++) { 
			$regNo =  $value->getCellByColumnAndRow(0,$i)->getValue();
			$operation =  $value->getCellByColumnAndRow(1,$i)->getValue();
			$president =  $value->getCellByColumnAndRow(2,$i)->getValue();
			$secretary =  $value->getCellByColumnAndRow(3,$i)->getValue();
			$member =  $value->getCellByColumnAndRow(4,$i)->getValue();
			$contact =  $value->getCellByColumnAndRow(5,$i)->getValue();
			$email =  $value->getCellByColumnAndRow(6,$i)->getValue();
			$address =  $value->getCellByColumnAndRow(7,$i)->getValue();
			$level =  $value->getCellByColumnAndRow(8,$i)->getValue();
			$ske =  $value->getCellByColumnAndRow(9,$i)->getValue();
			$others =  $value->getCellByColumnAndRow(10,$i)->getValue();
			$epd =  $value->getCellByColumnAndRow(11,$i)->getValue();
			$ss =  $value->getCellByColumnAndRow(12,$i)->getValue();
			$ps =  $value->getCellByColumnAndRow(13,$i)->getValue();
			$vt =  $value->getCellByColumnAndRow(14,$i)->getValue();
			$pt =  $value->getCellByColumnAndRow(15,$i)->getValue();
		   if($regNo !='')
		   {
		   	 mysqli_query($conn,"INSERT INTO `tbl_organisation`(`O_RegNo`, `O_OpArea`, `O_President`, `O_Secretary`, `O_member`, `O_Mobile`, `O_Email`, `O_Address`, `O_Level`, `O_SKE`, `O_Other`, `O_EPD`, `O_SS`, `O_PS`, `O_VT`, `O_PT`, `O_Flag`) VALUES ('$regNo','$operation','$president','$secretary','$member','$contact','$email','$address','$level','$ske','$others','$epd','$ss','$ps','$vt','$pt','0')");
		   }
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Excel File Import In Database</title>
</head>
<body>
	<h1>Import Excel file data in database</h1>
<form method="post" enctype="multipart/form-data">
	<input type="file" name="doc">
	<input type="submit" name="submit">
</form>
</body>
</html>