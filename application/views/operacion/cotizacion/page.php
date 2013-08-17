<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php $this->load->view($nombrevista.'styles')?>
</head>

<body>


  <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>
    Ocurrió un error al guardar la cotización, favor intentar más tarde.</div>
  <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
    La cotización ha sido guardada.</div>
  <form class="form-inline  proveedor"  role="form" id="agregarProveedor">
    <div class="form-group">
      <input type="text" name="proveedor" placeholder="Proveedor" class="form-control" id="input-proveedor"> 
    </div>
    <div class="form-group">
      <input type="text" name="email" placeholder="E-mail" class="form-control" id="input-eproveedor"> 
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-default" value="agregar proveedor">
    </div>
  </form>
  <span id="error-placement"></span>
  
  <div class="form-group">
    <div class="bs-callout bs-callout-info"><button type="button" class="close" data-dismiss="alert">&times;</button>
      <h4>Nota</h4>
      <p>1. Recuerda que debes ingresar el Valor después de iva para los proveedores.<br/>
      2. Para ingresar el iva de un proveedor, seleccionar un item o agregar una nota debes dar click derecho.</p>
    </div>
    <div id="example1" style="overflow: auto;" class="handsontable"></div>
  </div>
  <!-- <div class="form-group">
    <p>
     <button name="dump" data-dump="#example1" title="Prints current data source to Firebug/Chrome Dev Tools">Dump
       data to console
     </button>

     <button name="dump" onclick="dar_mejor_cotizacion()">dar mejor cotización</button>

     <button name="dump" onclick="motrar_cotizacion()">mostrar cotización</button>
   </p>

 </div> -->

 <div id="cotizacion row">
   <h3>Retenciones</h3>
   <form action="" id="reten">
      <table id="retenciones" class="table">
        <thead>
         <th>CREE(%)</th>
         <th>ICA(%)</th>
         <th>Retefuente(%)</th>
       </thead>
       <tbody>
        <tr>
          <td><input name="cree" type="text" class="form-control input-small retenciones" id="rete-cree" placeholder="CREE"></td>
          <td><input name="ica" type="text" class="form-control input-small retenciones" id="rete-ica" placeholder="ICA"></td>
          <td><input name="retefuente" type="text" class="form-control input-small retenciones" id="rete-retefuente" placeholder="Retefuente"></td>
        </tr>
      </tbody>
    </table>
  </form>
   <h3>Cotización</h3>
   <table id="cotizacion" class="table table-hover">
    <thead>
     <th></th>
     <th>Item</th>
     <th>Proveedor</th>
     <th>Cantidad</th>
     <th>Base LP</th>
     <th>IVA LP</th>
     <th>Valor LP</th>
     <th>Base cliente</th>
     <th>Iva cliente</th>
     <th>Precio cliente</th>
     <th>Ganancia</th> 
   </thead>
   <tbody>
   </tbody>
 </table>
</div>


<div id="row">
<fieldset id="fs-btns">
 <button name="dump" class="btn btn-success pull-right" onclick="guardar()">Guardar</button>
 <button name="dump" id="cancelar" class="btn btn-default pull-right" onclick="cancelar()">Cancelar</button>
 <button name="dump" id="ordenCompra" class="btn btn-success pull-right" onclick="orden_compra()">Generar Orden de compra</button>
</fieldset>
</div>

<div id="ordenes-compra" class="container-fluid">
  <h3>Ordenes de compra</h3>
  <div class="span6">
    <table id="tbl-ordenes-compra" class="table">
      <thead>
        <th>No. Orden</th>
       <th>Archivo</th>
       <th>Estado</th>
     </thead>
     <tbody>
      <?php foreach ($ordenes_compras as $oc):?>
        <tr>
          <td><?php echo str_pad($oc->id, 4, '0', STR_PAD_LEFT);?></td>
          <td><a href="<?php echo base_url().'resources/ordenCompra/'.$oc->url?>" target="_blank"><?php echo $oc->url?></a></td>
          <td><?php if($oc->anulado): ?><span>Anulada</span><?php else: ?><button class="btn btn-link" onclick="anular(<?php echo $oc->id ?>, this)">Anular</button><?php endif;?></td>
        </tr>
      <?php endforeach;?>
     </tbody>
   </table>
  </div>
   
</div>

<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Agregar nota</h4>
      </div>
      <div class="modal-body">
        <textarea class="form-control" id="nota" rows="5"></textarea>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
        <a href="#" class="btn btn-primary" id="agregar-nota">Guardar Cambios</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<div class="modal fade modal-orden-compra" id="modal-orden-compra">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Generar orden de compra</h4>
      </div>

      <form class="form-horizontal form-orden-compra">
        <input type="hidden" class="oc-id-proveedor" data-modificado="false">
        <div class="modal-body">
          <input type="hidden" class="oc-id-proveedores-cot">
          <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Proveedor:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control input-sm oc-proveedor" onchange="proveedor_modificado(this)" placeholder="Proveedor">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Email:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control input-sm oc-email" onchange="proveedor_modificado(this)" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="col-lg-2 control-label">Ciudad:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control input-sm oc-ciudad" onchange="proveedor_modificado(this)" placeholder="Ciudad">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="col-lg-2 control-label">Dirección:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control input-sm oc-direccion" onchange="proveedor_modificado(this)" placeholder="Dirección">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="col-lg-2 control-label">Teléfono:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control input-sm oc-telefono" onchange="proveedor_modificado(this)" placeholder="Teléfono">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="col-lg-2 control-label">Enviar el:</label>
            <div class="col-lg-10">
              <input class="form-control input-sm date-picker oc-enviar" size="16" type="text" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
          <input type="submit" class="btn btn-primary submit-oc" value="Generar">
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="mialerta" class="modal hide fade">
    <!-- dialog contents -->
    <div class="modal-body">Hello world!</div>
    <!-- dialog buttons -->
    <div class="modal-footer"><a href="#" class="btn primary">OK</a></div>
</div>

  <?php $this->load->view($nombrevista.'scripts')?>
</body>
</html>