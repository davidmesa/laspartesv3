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
    <h2 class="red-lp">Actualizar Oferta</h2>
    <hr>
  </div>
  <div class="container">
    <form class="form  link" id="actualizarLink">
      <input type="hidden" id="id_oferta" value="<?php echo $oferta->id_oferta?>">
      <div class="form-group row">
        <label for="titulo">TITULO</label>
        <input type="text" name="titulo" placeholder="Titulo" class="form-control" id="titulo" value="<?php echo $oferta->titulo;?>"> 
      </div>
      <div class="form-group row">
        <label for="precio">PRECIO</label>
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input type="text" name="precio" placeholder="Precio" onblur="format_number(this)" class="form-control" id="precio" value="<?php echo number_format($oferta->precio, 0, ',', '.');?>" disabled> 
        </div>
      </div>
      <div class="form-group row">
        <label for="iva">IVA</label>
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input type="text" name="iva" placeholder="iva" onblur="format_number(this)" class="form-control" id="iva" value="<?php echo number_format($oferta->iva, 0, ',', '.');;?>" disabled> 
        </div>
      </div>
      <div class="form-group row">
        <label for="margen">MARGEN DE LASPARTES</label>
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input type="text" name="margen" placeholder="Margen" onblur="format_number(this)" class="form-control" id="margen" value="<?php echo number_format($oferta->margenLP, 0, ',', '.');?>" disabled> 
        </div>
      </div>
      <div class="form-group row">
        <label for="descuento">DESCUENTO DE PROMOCIÓN (Haz click sobre el % ó $ para cambiar)</label>
        <div class="input-group">
          <input type="text" name="descuento" placeholder="Descuento"  onblur="format_number(this)" class="form-control" id="descuento" value="<?php echo  number_format($oferta->dco_feria, 5, ',', '.');?>"> 
          <span class="input-group-addon" onclick="fix_descuento(this)" style="cursor: pointer;">%</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="titulo">MOTIVO DEL DESCUENTO</label>
        <input type="text" name="motivo" placeholder="Motivo del descuento" class="form-control" id="motivo"  value="<?php echo $oferta->motivo_dco;?>"> 
      </div>
      <div class="form-group row">
        <label for="plazo">PLAZO DE USO (NÚMERO DE DÍAS PARA QUE EL USUARIO HAGA EFECTIVA LA COMPRA)</label>
        <div class="input-group">
          <input type="text" name="plazo" placeholder="Plazo de uso" class="form-control" id="plazo" value="<?php echo $oferta->plazo;?>"> 
          <span class="input-group-addon">Días</span>
        </div>
      </div>
      <div class="form-group row">
        <label for="titulo">FECHA DE VIGENCIA</label>
        <input data-placement="top" class="form-control date-picker oc-enviar" id="vigencia" size="16" type="text" placeholder="yyyy-mm-dd" data-date-format="yyyy-mm-dd" value="<?php echo $oferta->vigencia;?>">
      </div>
      <div class="form-group row">
        <label for="imagen">IMAGEN DE LA OFERTA</label>
        <input type="file" name="imagen" class="form-control" id="imagen"> 
        <p class="help-block">IMAGENES CON EXTENCIÓN JPG, PNG Y GIF</p>
      </div>
      <div class="form-group row">
        <label for="titulo">CONDICIONES</label>
        <textarea class="form-control" name="condiciones" placeholder="Condiciones..." id="condiciones" cols="30" rows="6">
          <?php echo $oferta->condiciones;?>
        </textarea>
      </div>
      <div class="form-group row">
        <label for="titulo">INCLUYE</label>
        <textarea class="form-control" name="incluye" placeholder="Incluye..." id="incluye" cols="30" rows="6">
          <?php echo $oferta->incluye;?>
        </textarea>
      </div>
      <div class="form-group row">
        <label for="categoria">CATEGORÍA DE LA OFERTA</label>
          <div class="control-group">
            <select id="categoria" name="categoria" class="span12" multiple style="width: 400px;">
              <?php foreach ($categorias as $servicio):?>
              <option value="<?php echo $servicio->id;?>" <?php if($servicio->encontrado){echo 'selected';}?> ><?php echo $servicio->nombre;?></option>
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
              <option value="<?php echo $value->value;?>" <?php if($autos[$value->value]){echo 'selected';}?>><?php echo $value->label;?></option>
            <?php endforeach; ?>
          </select>
        <p class="help-block">Seleccione los vehículos compatibles con esta oferta.</p>
        </div>
      </div>
      <input class="btn btn-success pull-right" id="guardar" type="submit" value="ACTUALIZAR OFERTA">
    </form>
    <button class="btn btn-default pull-right" id="cancelar" onclick="cancelar()">CANCELAR</button>
  </div>
  <?php $this->load->view($nombrevista.'scripts')?>
</body>
</html>