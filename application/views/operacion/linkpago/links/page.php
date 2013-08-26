<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php $this->load->view($nombrevista.'styles')?>
</head>

<body>
<?php if($msg == 'ofertaScs'): ?>
<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La oferta se ha creado</div>
<?php endif;?>
<?php if($msg == 'ofertaElimSuccess'): ?>
<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La oferta se ha eliminado</div>
<?php endif;?>
<?php if($msg == 'ofertaActScs'): ?>
<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La oferta se ha actualizado</div>
<?php endif;?>
  <div>
    <h3>Cotización</h3>
    <table id="cotizacion" class="table table-hover">
      <thead>
       <th></th>
       <th>Item</th>
       <th>Cantidad</th>
       <th>Proveedor</th>
       <th>Base LP</th>
       <th>IVA LP</th>
       <th>Valor LP</th>
       <th>Base cliente</th>
       <th>Iva cliente</th>
       <th>Precio cliente</th>
       <th>Ganancia</th> 
     </thead>
     <tbody>
      <?php $TIvaCliente = 0;
            $TBaseCliente = 0;
            $TCosto = 0;
            $TIVALP = 0;
            $TValorLP = 0;
            $TPrecioCliente = 0;
            $TGanancia = 0;?>
      <?php foreach ($items as $item):?>
        <?php foreach ($item->proveedores as $proveedor_cotizacion): if($proveedor_cotizacion->elegido == true):?>
        <tr>
          <td>
            <input type="checkbox" value="<?php echo $proveedor_cotizacion->id;?>">
          </td>
          <td><?php echo $item->item;?></td>
          <td><?php echo $item->cantidad;?></td>
          <td><?php echo $proveedor_cotizacion->proveedor->proveedor;?></td>
          <td><?php  $costo = $proveedor_cotizacion->lp_valor/(1+($proveedor_cotizacion->iva/100)); echo '$'.number_format($costo*$item->cantidad, 2, ',', '.');?></td>
          <td><?php $ivaLP = $costo*($proveedor_cotizacion->iva/100); echo '$'.number_format($ivaLP*$item->cantidad, 2, ',', '.');?></td>
          <td><?php echo '$'.number_format($proveedor_cotizacion->lp_valor*$item->cantidad, 2, ',', '.');?></td>
          <td>
            <?php $valor_antes_iva = $costo*$item->cantidad*(1+($item->margen/100));
                  $ivaCliente = $valor_antes_iva*($proveedor_cotizacion->iva/100);
                  $precio_cliente = $valor_antes_iva + $ivaCliente; ?>
            <?php echo '$'.number_format($valor_antes_iva, 2, ',', '.'); ?>
          </td>
          <td><?php echo '$'.number_format($ivaCliente, 2, ',', '.');?></td>
          <td><?php echo '$'.number_format($precio_cliente, 2, ',', '.');?></td>
          <td><?php echo '$'.number_format($valor_antes_iva-($costo*$item->cantidad), 2, ',', '.');?></td>
          <?php $TIvaCliente += $ivaCliente;
                $TBaseCliente += ($precio_cliente-$ivaCliente);
                $TCosto += ($costo*$item->cantidad);
                $TIVALP += ($ivaLP*$item->cantidad);
                $TValorLP += ($proveedor_cotizacion->lp_valor*$item->cantidad);
                $TPrecioCliente += $precio_cliente;
                $TGanancia += $valor_antes_iva-($costo*$item->cantidad);?>
        </tr>
        <?php endif; endforeach;?>
      <?php endforeach;?>
      <tr>
        <td colspan="4" align="right"><strong>Total: </strong></td>
        <td><?php echo '$'.number_format($TCosto, 2, ',', '.');?></td>
        <td><?php echo '$'.number_format($TIVALP, 2, ',', '.');?></td>
        <td><?php echo '$'.number_format($TValorLP, 2, ',', '.');?></td>
        <td><?php echo '$'.number_format($TBaseCliente, 2, ',', '.');?></td>
        <td><?php echo '$'.number_format($TIvaCliente, 2, ',', '.');?></td>
        <td><?php echo '$'.number_format($TPrecioCliente, 2, ',', '.');?></td>
        <td><?php echo '$'.number_format($TGanancia, 2, ',', '.');?></td>
      </tr>
     </tbody>
   </table>
 </div>

 <div class="row">
  <fieldset id="fs-btns">
   <button name="dump" id="ordenCompra" class="btn btn-success pull-right" onclick="generar_link()">Generar Link de pago</button>
   <button name="dump" id="actualizar-vista" class="btn btn-success pull-right" onclick="actualizar_vista()">Actualizar datos</button>
 </fieldset>
</div>

<div class="span9">
  <h3>Ofertas</h3>
  <table class="table">
      <thead>
       <th>id</th>
       <th>link de pago</th>
       <th>Acciones</th>
     </thead>
     <tbody>
      <?php foreach ($link_pago_model as $link):?>
        <tr>
          <td><?php echo $link->id;?></td>
          <td><a href="<?php echo base_url().$link->url;?>" target="_blank"><?php echo base_url().$link->url;?></a></td>
          <td>
            <button class="btn btn-link" title="Ver link de pago" onclick="editar_oferta('<?php echo $link->id_oferta;?>', '<?php echo $link->id;?>')"><img src="<?php echo base_url();?>resources/admin/images/pencil.png" alt="Ver o Actualizar Link de pago"></button>
          </td>
        </tr>
      <?php endforeach;?>
     </tbody>
 </table>
</div>
  <?php $this->load->view($nombrevista.'scripts')?>
</body>
</html>