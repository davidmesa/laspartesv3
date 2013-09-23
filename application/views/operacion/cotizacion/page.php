<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php $this->load->view($nombrevista.'styles')?>
</head>

<body>


  <div class="alert alert-danger" id="danger-guardar"><button type="button" class="close" data-dismiss="alert">&times;</button>
    Ocurrió un error al guardar la cotización, favor intentar más tarde.</div>
  <div class="alert alert-success" id="success-guardar"><button type="button" class="close" data-dismiss="alert">&times;</button>
    La cotización ha sido guardada.</div>
  <div class="alert alert-success" id="success-cotizacion"><button type="button" class="close" data-dismiss="alert">&times;</button>
  La cotización ha sido enviada.</div>
  <div class="alert alert-danger" id="danger-cotizacion"><button type="button" class="close" data-dismiss="alert">&times;</button>
    <div class="alert-msg"></div>
  </div>
    <div class="row" id="header-ops" style="margin-left:0;">
      <div class="col-xs-12 col-md-8">
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
      </div>
      <div class="col-xs-6 col-md-4">
        <div class="contro-group">
          <a target="_blank" href="<?php echo base_url().'operacion/cotizaciones/mostrar_cotizaciones/'.$id_pipeline.'/'.$id_usuario?>" id="vista-completa" class="btn btn-default pull-right">Ver vista completa</a>
          <input type="button" id="actualizar" onclick="location.reload()" class="btn btn-default pull-right" value="Actualizar">  
        </div>  
      </div>
    </div>
    <span id="error-placement"></span>
  
  <div class="form-group">
    <div class="bs-callout bs-callout-info"><button type="button" class="close" data-dismiss="alert">&times;</button>
      <h4>Nota</h4>
      <p>1. Recuerda que debes ingresar todos los valores antes de iva.<br/>
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

 <div>
   <!-- <h3>Retenciones</h3>
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
  </form> -->
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
 <button name="dump" class="btn btn-success pull-right" id="guardarCotizacion" onclick="guardar()">Guardar</button>
 <button name="dump" id="cancelar" class="btn btn-default pull-right" onclick="cancelar()">Cancelar</button>
 <button name="dump" id="ordenCompra" class="btn btn-success pull-right" onclick="orden_compra()">Generar Orden de compra</button>
 <button name="dump" id="ordenCompra" class="btn btn-success pull-right" onclick="mostrar_modal_cotizacion(this)">Enviar cotización</button>
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
          <div class="form-group" style="margin-bottom: 0;">
            <label for="inputPassword" class="col-lg-2 control-label">Enviar el:</label>
            <div class="col-lg-10">
              <input data-placement="top" class="form-control input-sm date-picker oc-enviar" size="16" type="text" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd">
            </div>
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="inputObservaciones" class="col-lg-3 control-label">Observaciones:</label>
            <div class="col-lg-9">
              <textarea name="" class="form-control oc-observaciones" id="" cols="20" rows="7"></textarea>
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

<div class="modal fade modal-cotizacion-pdf" id="modal-cotizacion-pdf">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Generar cotización</h4>
      </div>

      <form class="form-horizontal form-cotizacion">
        <input type="hidden" class="c-id-proveedor" data-modificado="false">
        <div class="modal-body">
          <input type="hidden" class="oc-id-proveedores-cot">
          <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Nombres:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control input-sm c-nombres" placeholder="Nombres">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Email:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control input-sm c-email" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Documento:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control input-sm c-documento" placeholder="Nombres">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Teléfono:</label>
            <div class="col-lg-10">
              <input type="text" class="form-control input-sm c-telefono" placeholder="Nombres">
            </div>
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label for="inputObservaciones" class="col-lg-3 control-label">Observaciones:</label>
            <div class="col-lg-9">
              <textarea name="" class="form-control c-observaciones" id="" cols="20" rows="7"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
          <input type="submit" class="btn btn-primary submit-c" value="Enviar">
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <?php $this->load->view($nombrevista.'scripts')?>
</body>
</html>