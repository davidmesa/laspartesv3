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
    <h2 class="red-lp">Agregar Orden de Remisión</h2>
    <hr>
  </div>
  <div class="container">
    <form class="form  link" id="agregarOR">
      <div class="form-group row">
        <label for="titulo">NOMBRES</label>
        <input type="text" name="nombres" placeholder="Nombres" class="form-control" id="nombres" value="<?php echo $usuario->nombres.' '.$usuario->apellidos;?>"> 
      </div>
      <div class="form-group row">
        <label for="precio">CORREO ELECTRÓNICO</label>
        <input type="text" name="correo" placeholder="Correo Electrónico" class="form-control" id="correo" value="<?php echo $usuario->email;?>"> 
      </div>
      <div class="form-group row">
        <label for="iva">LUGAR</label>
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
          echo form_dropdown('lugar', $option_ciudades, $usuario->lugar, 'id="lugar" class="span4"'); //, 'id="marca_registrarse"');
          ?>
        </div>
      </div>
      <div class="form-group row">
        <label for="iva">DIRECCIÓN DE ENVÍO</label>
        <input type="text" name="direccion" placeholder="Dirección" class="form-control" id="direccion" value=""> 
      </div>
      <div class="form-group row">
        <label for="margen">TELÉFONO DE CONTACTO</label>
          <input type="text" name="telefono" placeholder="Teléfono" class="form-control" id="telefono" value="<?php echo $usuario->telefonos;?>"> 
      </div>
      <div class="form-group row">
        <label for="carros">CARRO</label>
        <div class="control-group">
          <select id="carros" name="carros" class="span4">
            <option value="na">Selecciona un carro</option>
            <?php foreach ($allvehiculos as $value):?>
              <option value="<?php echo $value->value;?>"><?php echo $value->label;?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="carros">TALLER</label>
        <div class="control-group">
          <select id="taller" name="taller" class="span4">
            <option value="na">Selecciona un taller</option>
            <?php foreach ($talleres as $value):?>
              <option value="<?php echo $value->id_establecimiento;?>"><?php echo $value->nombre;?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="titulo">DESCRIPCIÓN DE LA ORDEN DE REMISIÓN</label>
        <textarea class="form-control" name="descripcion" placeholder="Descripción..." id="descripcion" cols="30" rows="6"></textarea>
      </div>
      <input class="btn btn-success pull-right" id="guardar" type="submit" value="GENERAR ORDEN DE REMISIÓN">
    </form>
    <button class="btn btn-default pull-right" id="cancelar" onclick="cancelar()">CANCELAR</button>
  </div>
  <?php $this->load->view($nombrevista.'scripts')?>
</body>
</html>