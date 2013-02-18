<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
background-color: #FF0000;
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
color:#FF0000;
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

<table width="500" border="0" cellspacing="0" cellpadding="0">
<tr>
<th width="100%" scope="col"><h1><?php echo $respuesta;?></h1>
<br />
</tr>
<td>

<a href="http://www.pagosonline.com/" target="_blank"><img src="http://www.pagosonline.com/logos/images/transgrande_03_460x60.png" alt="j" width="460" height="60" border="0" /></a>
<br />
<h2 align="center"><?php echo $mensaje;?></h2>
<div align="center">

<h4><br />
<span class="Estilo2"><a href="<?php echo base_url();?>usuario" >Ver mi cuenta</a></span></h4>
</div></td>

</tr>
</table>
</div></div></div></div>
<div id="bg-buttom"></div>
</body>
</html>

