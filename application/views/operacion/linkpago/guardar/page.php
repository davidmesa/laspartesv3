<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php $this->load->view($nombrevista.'styles')?>
</head>

<body>
  <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>
    <div class="alert-msg"></div>
  </div>
  <div>
    <h2 class="red-lp">Agregar Oferta</h2>
    <hr>
  </div>
  <div class="container">
    <form class="form  link" id="agregarLink">
      <div class="form-group row">
        <label for="titulo">TITULO</label>
        <input type="text" name="titulo" placeholder="Titulo" class="form-control" id="titulo" value="<?php echo $titulo;?>"> 
      </div>
      <div class="form-group row">
        <label for="precio">PRECIO</label>
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input type="text" name="precio" placeholder="Precio" onblur="format_number(this)" class="form-control" id="precio" value="<?php echo $precio;?>"> 
        </div>
      </div>
      <div class="form-group row">
        <label for="iva">IVA</label>
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input type="text" name="iva" placeholder="iva" onblur="format_number(this)" class="form-control" id="iva" value="<?php echo $iva;?>"> 
        </div>
      </div>
      <div class="form-group row">
        <label for="margen">MARGEN DE LASPARTES</label>
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input type="text" name="margen" placeholder="Margen" onblur="format_number(this)" class="form-control" id="margen" value="<?php echo $margen;?>"> 
        </div>
      </div>
      <div class="form-group row">
        <label for="descuento">DESCUENTO DE PROMOCIÓN (PORCENTAJE DE DESCUENTO SOBRE EL VALOR TOTAL)</label>
        <div class="input-group">
          <input type="text" name="descuento" placeholder="Descuento" class="form-control" id="descuento" value="0"> 
          <span class="input-group-addon">%</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="plazo">PLAZO DE USO (NÚMERO DE DÍAS PARA QUE EL USUARIO HAGA EFECTIVA LA COMPRA)</label>
        <div class="input-group">
          <input type="text" name="plazo" placeholder="Plazo de uso" class="form-control" id="plazo" value="15"> 
          <span class="input-group-addon">Días</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="titulo">FECHA DE VIGENCIA</label>
        <input data-placement="top" class="form-control date-picker oc-enviar" id="vigencia" size="16" type="text" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d', mktime(0, 0, 0, date('m')  , date('d')+15, date('Y')));?>">
      </div>
      <div class="form-group row">
        <label for="imagen">IMAGEN DE LA OFERTA</label>
        <input type="file" name="imagen" class="form-control" id="imagen"> 
        <p class="help-block">IMAGENES CON EXTENCIÓN JPG, PNG Y GIF</p>
      </div>
      <div class="form-group row">
        <label for="titulo">CONDICIONES</label>
        <textarea class="form-control" name="condiciones" placeholder="Condiciones..." id="condiciones" cols="30" rows="6"></textarea>
      </div>
      <div class="form-group row">
        <label for="titulo">INCLUYE</label>
        <textarea class="form-control" name="incluye" placeholder="Incluye..." id="incluye" cols="30" rows="6">
          <ul>
          <?php foreach ($proveedores_cotizacion as $key => $pc): ?>
              <li><?php echo $pc->item->cantidad.' Un. de '.$pc->item->item; ?></li>
          <?php endforeach?>
          </ul>
        </textarea>
      </div>
      <div class="form-group row">
        <label for="categoria">CATEGORÍA DE LA OFERTA</label>
          <div class="control-group">
            <select id="categoria" name="categoria" class="span12" multiple style="width: 400px;">
              <?php foreach ($servicios as $servicio):?>
              <option value="<?php echo $servicio->id_servicios_categoria;?>"><?php echo $servicio->nombre;?></option>
            <?php endforeach; ?>
            </select>
        </div>
      </div>
      <div class="form-group row">
          <div class="control-group">
            <p class="help-block">Si otro, cuál?</p>
            <input type="text" name="otro" placeholder="Otro" class="form-control" id="otro">
        </div>
      </div>
      <div class="form-group row">
        <label for="carros">CARROS</label>
        <div class="control-group">
          <select id="carros" name="carros" class="span12" multiple style="width: 400px;">
            <?php foreach ($allvehiculos as $value):?>
              <option value="<?php echo $value->value;?>"><?php echo $value->label;?></option>
            <?php endforeach; ?>
          </select>
        <p class="help-block">Seleccione los vehículos compatibles con esta oferta.</p>
        </div>
      </div>
      <input class="btn btn-success pull-right" id="guardar" type="submit" value="GUARDAR OFERTA">
    </form>
    <button class="btn btn-default pull-right" id="cancelar" onclick="cancelar()">CANCELAR</button>
  </div>
  <?php $this->load->view($nombrevista.'scripts')?>
</body>
</html>