<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>

<?php echo form_open_multipart('excelPromociones/cargar');

$option_establecimientos = array();
$selected = false;
foreach($establecimientos as $establecimiento){
	$option_establecimientos[$establecimiento->id_establecimiento] = $establecimiento->nombre;
	if(!$selected){
		$selected = $establecimiento->nombre;
	}
}
echo form_dropdown('establecimiento', $option_establecimientos, $selected);

?>

<br/>
<input type="file" name="userfile" size="20" />
<br />
<input type="submit" value="upload" />

</form>

</body>
</html>