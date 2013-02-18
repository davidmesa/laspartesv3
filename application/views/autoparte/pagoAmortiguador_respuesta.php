<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Confirmación del pago</title>
<style type="text/css">
#cont-container {
background-image: url("http://www.pagosonline.com/desarrolladores/ejemplos/fullpack/cod/imagenes/bg-container.png");
background-repeat: repeat-y;
margin-left: auto;
margin-right: auto;
position: relative;
width: 994px;
}

#cont-container #container #cont-contenido {
background-image: url(http://www.pagosonline.com/desarrolladores/ejemplos/fullpack/cod/imagenes/bg-contenido.jpg);
background-repeat: no-repeat;
background-position: center top;
background-color: #FFF;
padding-top: 38px;
width: 952px;
margin-right: auto;
margin-left: auto;
padding-right: 14px;
padding-left: 14px;
}

#bg-buttom {
background-image: url(http://www.pagosonline.com/desarrolladores/ejemplos/fullpack/cod/imagenes/bg-buttom.png);
background-repeat: no-repeat;
display: block;
height: 39px;
width: 994px;
margin-right: auto;
margin-left: auto;
}

body {
background-color: #4A36AF;
background-repeat: repeat;
font-family: Arial;
font-size: 11px;
color: #747474;
}

h1 {
font-size:26px;
font-weight:bold;
color:#000;
}
h2 {
font-size:16px;
font-weight:bold;
}
h4{
font-size:15px;
font-weight:bold;
color:#4A36AF;
font-family: Arial;
}

#bg-top {
background-image: url(http://www.pagosonline.com/desarrolladores/ejemplos/fullpack/cod/imagenes/bg-top.png);
background-repeat: no-repeat;
display: block;
height: 28px;
width: 994px;
margin-right: auto;
margin-left: auto;
}

</style>
</head>
<body>
<div id="bg-top" ></div>
<div id="cont-container">
<div id="container">
<div id="cont-contenido">
<div align="center">

<?php
if($estado_pol == 6 && $codigo_respuesta == 5)
{$estadoTx = "Transacci&oacute;n fallida";}
else if($estado_pol == 6 && $codigo_respuesta == 4)
{$estadoTx = "Transacci&oacute;n rechazada";}
else if($estado_pol == 12 && $codigo_respuesta == 9994)
{$estadoTx = "Pendiente, Por favor revisar si el d&eacute;bito fue realizado en el Banco";}
else if($estado_pol == 4 && $codigo_respuesta == 1)
{$estadoTx = "Transacci&oacute;n aprobada";}
else
{$estadoTx=$mensaje;}
if(strtoupper($firma)==strtoupper($firmacreada)){//comparacion de las firmas para comprobar que los datos si vienen de Pagosonline
?>

<table width="500" border="0" cellspacing="0" cellpadding="0">
<tr>
<th width="100%" scope="col"><h1>Los datos de tu transacción son los siguientes</h1>
<br />
</tr>
<td>

<a href="http://www.pagosonline.com/" target="_blank"><img src="http://www.pagosonline.com/logos/images/transgrande_03_460x60.png" alt="j" width="460" height="60" border="0" /></a>
<br />
<table align="center"  width="%100" border="0">
<tr>
<td><h3>Fecha de procesamiento</h3></td>
<td><h2><?php echo $fecha_procesamiento; ?></h2></td>
</tr>
<tr>
<td><h3>Estado de la transacci&oacute;n</h3></td>
<td><h2><?php echo $estadoTx; ?> </h2></td>
</tr>
<tr>
<td><h3>referencia de la venta </h3></td>
<td><h2><?php echo $ref_venta; ?></h2> </td> </tr>
<tr>
<td><h3>Referencia de la transaccion </h3></td>
<td><h2><?php echo $ref_pol; ?> </h2></td>
</tr>
<tr>
<?php
if($banco_pse!=null){
?>
<tr>
<td><h3>cus </h3></td>
<td><h2><?php echo $cus; ?></h2> </td>
</tr>
<tr>
<td><h3>Banco</h3> </td>
<td><h2><?php echo $banco_pse; ?></h2> </td>
</tr>
<?php
}
?>
<tr>
<td><h3>Valor total</h3></td>
<td><h2><?php echo number_format($valor); ?> </h2></td>
</tr>
<tr>
<td><h3>moneda</h3> </td>
<td><h2><?php echo $moneda; ?></h2></td>
</tr>
</table>


<div align="center"><input  type="button" name="imprimir" value="Imprimir Recibo" onclick="window.print();"></div><br />
<br /> <br />

<h2 align="center">Si tiene alguna duda acerca de esta transacción por favor cumuníquese con nuestro departamento de servicio al cliente.</h2>
<div align="center">

<h1 align="center">Gracias por comprar con nosotros! </h1>
<div align="center">


<h4><br />
<span class="Estilo2"><a href="http://www.pagosonline.com">Ver otros productos</a></span></h4>
</div></td>

</tr>
</table>
</div></div></div></div>
<div id="bg-buttom"></div>
</body>
</html>
<?php
}else{
?>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<tr>
<th width="100%" scope="col"><h1>Error validando firma digital.</h1>
<br />
</tr>
</table>
<?php
}
?>

