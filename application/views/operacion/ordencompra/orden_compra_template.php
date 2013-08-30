<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset='utf-8'>
<style type="text/css">
<!--
body {
  font-family:Tahoma;
}

img {
  border:0;
}

#page {
  width:800px;
  margin:0 auto;
  padding:15px;

}

#logo {
  float:left;
  margin:0;
}

#address {
  height:181px;
  float: right;
}

#tbl-content {
  width:100%;
  border-collapse:collapse;
}


#tbl-content td {
padding:5px;
font-size: 12px;
}

#tbl-content tr.odd {
  background:#DA7878;
  border: 1px solid black;
}

.clear{
  clear: both;
}

h2{
  color: gray;
}

#tbl-top{
  border-collapse:collapse;
  width: 130px;
  float: right;
}

#tbl-top, #tbl-top th, #tbl-top td{
border: 1px solid black;
font-size: 10px;
}

.block{
  display: block;
}

#info-LP{
  font-size: 10px;
}

.bordered{
  border: 1px solid black;
}

#firma{
  width: 400px;
  text-align: left;
}

#firma-tfecha{
  margin-left: 200px;
}

#firma-fecha{
  margin-left: 100px;
}

.span-firma{
  font-size: 12px;
}
-->
</style>
</head>
<body>
<div id="page">
  <div id="logo">
    <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>resources/template/header/logo-laspartes.png"></a>
    <div id="info-LP">
      <p>
        <span class="block">Carrera 16 # 80 - 11 Oficina 602</span>
        <span class="block">Edificio El Escorial</span>
        <span class="block">Bogotá, Cundinamarca, Colombia</span>
        <span class="block">381 9790 - 6007737</span>
      </p>
      <p>
        <span class="block">Emitido para:</span>
        <span class="block"><?php echo $orden_compra_model->proveedor?></span>
        <span class="block"><?php echo $orden_compra_model->tel_proveedor?></span>
        <span class="block"><?php echo $orden_compra_model->dir_proveedor?></span>
      </p>
    </div>
  </div><!--end logo-->
  
  <div id="address">
    <h2>ORDEN DE COMPRA <?php echo str_pad($orden_compra_model->id, 4, '0', STR_PAD_LEFT)?></h2>
    <table id="tbl-top">
      <tbody>
        <tr><td><strong>Fecha:</strong><br/><span><?php echo strftime("%B %d de %Y", strtotime($orden_compra_model->fecha))?></span></td></tr>
        <tr><td><strong>Autorizado por:</strong><br/><span>Felipe Pacheco</span></td></tr>
        <tr><td><strong>Enviar el:</strong><br/><span><?php echo strftime("%B %d de %Y", strtotime($orden_compra_model->fecha_envio))?></span></td></tr>
      </tbody>
    </table>

  </div><!--end address-->

  <div id="content" class="clear">

    <hr>
    <table id="tbl-content">
      <thead>
        <th>
          <tr class="bordered"><td  style="width:400px;"><strong>DESCRIPCIÓN</strong></td><td><strong>CANTIDAD</strong></td><td><strong>PRECIO UNI</strong></td><td><strong>PRECIO TOTAL</strong></td></tr>
        </th>
      </thead>
      <tbody>
      <?php foreach ($item_orden_compra_model as $key => $obj):?>
        <tr class="<?php if($key%2 == 0) echo 'even'; else echo 'odd';?>">
          <td><?php echo $obj->item?></td>
          <td><?php echo $obj->cantidad?></td>
          <td><?php echo '$'.number_format($obj->precio_unidad, 2, ',', '.'); ?></td>
          <td><?php echo '$'.number_format($obj->precio_total, 2, ',', '.');?></td>
        </tr>
      <?php endforeach;?>           
        <tr><td>&nbsp;</td><td>&nbsp;</td><td class="bordered"><strong>Subtotal</strong></td><td class="bordered"><strong><?php echo '$'.number_format($orden_compra_model->subtotal, 2, ',', '.')?></strong></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td class="bordered"><strong>Descuento</strong></td><td class="bordered"><strong>$0,00</strong></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td class="bordered"><strong>Impuesto ventas</strong></td><td class="bordered"><strong><?php echo '$'.number_format($orden_compra_model->impuestos_ventas, 2, ',', '.')?></strong></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td class="bordered"><strong>Otros</strong></td><td class="bordered"><strong><?php echo '$'.number_format($orden_compra_model->otros, 2, ',', '.')?></strong></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td class="bordered"><strong>Total</strong></td><td class="bordered"><strong><?php echo '$'.number_format($orden_compra_model->total, 2, ',', '.')?></strong></td></tr>
      </tbody>
    </table>
    <br/>
    <p>
      <h4>Obserservaciones</h4><br/>
      <?php echo $orden_compra_model->observacion; ?>
    </p>
    <br/><br/><br/><br/>
    <span><img src="<?php echo base_url();?>resources/images/correos/operaciones/cotizacion/firma_pacheco.jpg"><span><span class="span-firma" id="firma-fecha"><?php echo strftime("%B %d de %Y", strtotime($orden_compra_model->fecha))?></span>
    <hr align="left" id="firma">
    <span class="span-firma">Firma del empleado</span><span class="span-firma" id="firma-tfecha">Fecha</span>
    
  </div><!--end content-->
</div><!--end page-->
</body>

</html>