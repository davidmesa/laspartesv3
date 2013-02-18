<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
	<head>
		<title>Bolet&iacute;n de Noticias</title>
		<style type="text/css">
			body{
				font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
				font-size: 12px;
				text-align: justify;
			}
			
			p, div{
				text-align: justify;
			}
			
			a{
				text-align: right;
				color: #ED1C24;
			}
			
			h1{
				font-family: Impact;
				font-weight: normal;
				font-size: 24px;
			}
			
			h2{
				font-size: 18px;
			}
			
			h3{
				font-size: 15px;
			}
			
			h4{
				font-size: 12px;
			}
			
			td.header{
				border-bottom: #CCC 2px solid;
			}
			
			td.header img{
				float: right;
				border: 10px white solid;
			}
			
			td.noticias{
				width: 65%;
				border-bottom: #CCC 2px solid;
				padding: 5px 10px 5px 5px;
			}
			
			td.tips{
				width: 35%;
				border-bottom: #CCC 2px solid;
				padding: 5px 10px 5px 5px;
			}
			
			td.preguntas{
				border-bottom: #CCC 2px solid;
				padding: 5px 10px 5px 5px;
			}
		</style>
	</head>
	<body>
		<table width="800">
			<tr>
				<td colspan="2" class="header">
					<img src="http://www.laspartes.com/resources/images/template/logos/laspartes160x97.gif" />
					<h1><?php echo $titulo; ?> - Laspartes.com</h1>
					<h4><?php echo $introtext; ?></h4>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $contentHTML; ?>
				</td>
			</tr>
		</table>
	</body>
</html>
