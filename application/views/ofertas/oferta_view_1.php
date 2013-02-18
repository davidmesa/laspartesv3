<script> 
window.location = "http://www.laspartes.com/promociones/";
</script>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      <head>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-ui-1.8.23.custom.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Confirmaci&oacute;n del pago</title>
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
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script>
            $(document).ready(function(){
                $('#submit').click(function(){
                        var id_usuario = location.pathname.split("/")[3];
                        var telefonos = $('#telefono_comprador').val();
                        var direccion = $('#direccion_comprador').val();
                        var email = $('#email_comprador').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>ofertas/registrar_movimiento",
                        async: false,
                        data: "id_usuario=" + id_usuario + "&mensaje= click en comprar &telefono=" + telefonos + "&direccion=" +direccion+ "&email=" +email,
                        success: function(data){
                        }
                    }); 
                });
                
            $('#select-cantidad').change(function(){
                var oferta = location.pathname.split("/")[2];
                var cantidad = $(this).val();
                var valor = cantidad*<?php echo $valor;?>;
                var valorIva = cantidad*<?php echo $iva;?>;
                var devolucion = valor- valorIva;
                var reVenta = $('#ref-compra').val();
                $('#valor').text('Valor: $'+ valor);
                $('#valor-compra').val(valor);
                $('#iva-compra').val(valorIva);
                $('#devolucion-compra').val(devolucion);
                $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>ofertas/generar_firma",
                        async: false,
                        data: "cantidad=" + cantidad + "&oferta=" + oferta + "&reVenta=" + reVenta, 
                        success: function(data){
                            $('#firma-compra').val(data);
                        }
                    }); 
            });
            });
        </script>
    </head>
<body>
<div id="bg-top" ></div>
<div id="cont-container">
<div id="container">
<div id="cont-contenido">
<div align="center">


	<table width="500" border="0">
    <tr>
        <td colspan="2"><h1 align="center"><div style="float: left; width: 160px;"><img src="<?php echo base_url();?>resources/template/header/logo-laspartes.png" alt="logo de laspartes"/></div>
                <div style="float: right; width: 333px;"><?php echo $descripcion;?></div>
                <div style="clear: both;"></div></h1>
      </tr>
      <tr>
      <td colspan="2"><br/><br/></td>
      </tr>
    <tr>
      <td rowspan="3" width="250" align="center"><img src="http://www.pagosonline.com/desarrolladores/estilos/imagenes/tradicional.png" width="143" height="131" alt="Producto" /></td>
      <td width="250"><h2 >En este campo debes colocar la descripción del producto que deseas que vea el cliente.</h2></td>
    </tr>
    <tr>
      <td width="250"><h1 id="valor">Valor: $ <?php echo number_format($valor, 0, ',', '.'); ?></h1></td>
    </tr>
<tr><td width="250" >
<form method="post" action="https://gateway.pagosonline.net/apps/gateway/index.html" target="_self">
<label>
<h2>Cantidad: </h2>
<select id="select-cantidad">
    <?php for($i = 1; $i<= 10; $i++):?>
        <option><?php echo $i;?></option>
    <?php endfor; ?>
</select>
<label>
<label>
<h2>ingresa tu correo</h2>
<input name="emailComprador"  id ="email_comprador" type="text" label="Ingresa tu correo" ></label>
<label>
    <h2>ingresa tu direcci&oacute;n</h2>
<input name="direccionComprador" id ="direccion_comprador" type="text" label="Ingresa tu direccion" ></label>
<label>
    <h2>ingresa tu n&uacute;mero telef&oacute;nico:</h2>
<input name="telefonoComprador" id ="telefono_comprador" type="text" label="Ingresa tu telefono" ></label>    
    <input type="image" id="submit" border="0"  src="https://gateway.pagosonline.net/images/clientes/b_simplificado_1.png">
<input name="usuarioId" type="hidden" value="<?php echo $usuarioId;?>">
<input name="descripcion" type="hidden" value="<?php echo $descripcion; ?>" >
<input name="extra1" type="hidden" value="<?php echo $descripcion; ?>" >
<input name="refVenta" id="ref-compra" type="hidden" value="<?php echo $refVenta ?>">
<input name="valor" id="valor-compra" type="hidden" value="<?php echo $valor; ?>">
<input name="iva" id="iva-compra" type="hidden" value="<?php echo $iva;?>">
<input name="moneda" type="hidden" value="<?php echo $moneda;?>">
<input name="baseDevolucionIva" id="devolucion-compra" type="hidden" value="<?php echo $baseDevolucionIva;?>" >
<input name="firma" id="firma-compra" type="hidden" value="<?php echo $firma;?>">
<input name="url_respuesta" type="hidden" value="<?php echo $url_respuesta;?>">
<input name="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion;?>">
</form>
</td>
</tr>

<tr>
      <td colspan="2"><br/><br/></td>
      </tr>
    <tr>
      <td colspan="2"><a href="http://www.pagosonline.com/" target="_blank"><img src="http://www.pagosonline.com/logos/images/transgrande_03_460x60.png" alt="j" width="460" height="60" border="0" /></a></td>
      </tr>

  </table>
</div></div></div></div>
<div id="bg-buttom"></div>
</body>
</html>
-->
