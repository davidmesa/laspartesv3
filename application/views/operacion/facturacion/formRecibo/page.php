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
    <h2 class="red-lp">Generar Recibo</h2>
    <hr>
  </div>
  <div class="container">
    <form class="form link" id="generarRecibo">
      <div class="form-group row">
        <label for="titulo">NOMBRES</label>
        <input type="text" name="nombres" placeholder="Nombres" class="form-control" id="nombres" value="<?php echo $usuario->nombres.' '.$usuario->apellidos;?>"> 
      </div>
      <div class="form-group row">
        <label for="precio">DOCUMENTO DE IDENTIDAD: (*OPCIONAL)</label>
        <div class="input-group">
          <span class="input-group-addon">CC/NIT</span>
          <input type="text" name="documento" placeholder="CC o Nit" class="form-control" id="documento" value="<?php echo $usuario->documento;?>"> 
        </div>
      </div>
      <div class="form-group row">
        <label for="iva">CORREO ELECTRÓNICO</label>
          <input type="text" name="correo" placeholder="Correo electrónico" class="form-control" id="correo" value="<?php echo $usuario->email;?>"> 
      </div>
      <div class="form-group row">
        <label for="categoria">LUGAR</label>
          <div class="control-group">
            <?php
              $option_ciudades = array();
              $selected = false;
              $ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
              foreach ($ciudades as $ciudad) {
                  if ($ciudad != 'default') {
                      $option_ciudades[$ciudad] = $ciudad;
                      if (!$selected) {
                          $selected = $ciudad;
                      }
                  }
              }
              echo form_dropdown('lugar', $option_ciudades, $usuario->lugar, 'id="lugar" class="span12"'); 
            ?>
        </div>
      </div>
      <div class="form-group row">
        <label for="descuento">DIRECCIÓN: (*OPCIONAL)</label>
        <input type="text" name="descuento" placeholder="Dirección" class="form-control" id="direccion"> 
      </div>
      <div class="form-group row">
        <label for="plazo">TELÉFONO: (*OPCIONAL)</label>
        <input type="text" name="plazo" placeholder="Teléfono" class="form-control" id="telefono" value="<?php echo $usuario->telefonos?>"> 
      </div>
      <div class="form-group row">
        <label for="carros">CARRO</label>
        <div class="control-group">
          <select id="carros" name="carros" class="span12">
            <option value=""></option>
            <?php foreach ($allvehiculos as $value):?>
              <option value="<?php echo $value->value;?>"><?php echo $value->label;?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="plazo">PLACAS DEL CARRO</label>
        <input type="text" name="placa" placeholder="Placas" class="form-control" id="placa"> 
      </div>      <input class="btn btn-success pull-right" id="guardar" type="submit" value="GENERAR RECIBO">
    </form>
    <button class="btn btn-default pull-right" id="cancelar" onclick="window.location = '<?php echo base_url()?>operacion/facturacion/mostrar_facturacion/<?php echo $id_pipeline.'/'.$id_usuario?>'">CANCELAR</button>
  </div>
  <?php $this->load->view($nombrevista.'scripts')?>
</body>
</html>