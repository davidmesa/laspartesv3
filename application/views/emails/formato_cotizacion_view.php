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

  h4{
    margin: 0;
    font-size: 15px;
}

#page {
  width:800px;
  margin:0 auto;
  padding:15px;

}

#header-izq {
  margin:0;
  width: 75%;
}

#header-der{
    margin: 0;
    width: 20%;
}

.group{
    display: block;
    position: relative;
    clear: both;
}

.row{
    display: inline-block;
    vertical-align: top;
}

.pull-right{
    float: right;
}

.rojo{
    color: #FC0309;
}

.caja{
    border: 1px solid;
    margin-top: 5px;
    border-bottom-right-radius: 2px;
    border-bottom-left-radius: 2px;
}

.caja .contenido{
    text-align: center;
    margin-top: 5px;
    margin-bottom: 5px;
}
.caja.caja-gris .titulo{
    color: white;
    background-color: #bbbbbb;
    padding-left: 3px;
}

.caja.caja-gris{
    border-color: #bbbbbb;
}

#datos-lp{
    font-size: 14px;
}

#datos-cliente{
    margin-top: 20px;
    padding: 20px 15px 30px;
}

.caja-especial{
    border: 2px solid #bbbbbb;
    border-top: 10px solid #bbbbbb;
    border-bottom-right-radius: 7px;
    border-bottom-left-radius: 7px;
}

.center{
    text-align: center;
}

.right{
    text-align: right;
}

#tbl-datos{
    width: 100%;
    margin-top: 10px;
}

table{
    width: 100%;
    border: 2px solid #bbbbbb;
    border-collapse: collapse;
    border-spacing: 0;
}

table th{
    background-color: #bbbbbb;
    color: white;
    text-align: center;
    font-size: 12px;
    font-weight: normal;
}

td{
    border-left: 2px solid #bbbbbb;
    border-right: 2px solid #bbbbbb;
    font-size: 12px;
}

tr.odd{
    background-color: white;
}

tr.even{
    background-color: #ededed;
}

#totales table td{
    padding: 3px 8px 3px;
    border: 2px solid #bbbbbb;
}

.bg-gris{
    background-color: #bbbbbb;
    color: white;
}

#referencia{
    width: 70px
}

#cantidad{
    width: 30px;
}

#descripcion{
    width: 500px;
}

#p-unidad{
    width: 80px;
}

#p-total{
    width: 80px;
}

.btm-row{
    margin-top: 10px;
}

#clausulas.btm-row{
  margin-top: 60px;
}

-->
</style>
</head>
<body>
    <div id="page">
      <div id="header-izq" class="row">
        <div class="row">
            <a href="http://www.laspartes.com/"><img src="http://www.laspartes.com/resources/template/header/logo-laspartes.png"></a>
        </div>
        <div class="row pull-right" id="datos-lp">
          <div class="group">
              <span>LASPARTES.COM.CO SAS.</span>
          </div>
          <div class="group">
              <span>NIT 900216983-8</span>
          </div>
          <div class="group">
              <span>Carrera 16 # 80 - 11 Oficina 602. Edificio El Escorial</span>
          </div>
          <div class="group">
              <span>Tel: 1 - 3819790</span>
          </div>
          <div class="group">
              <span>e-mail: contactenos@laspartes.com.co</span>
          </div>
          <div class="group">
              <span>Bogotá, Colombia</span>
          </div>
      </div>
      <div id="datos-cliente" class="caja-especial">
          <div class="group">
              <span class="rojo">CLIENTE:</span> <span><?php echo $usuario->nombres.' '.$usuario->apellidos;?></span>
          </div>
          <div class="group">
              <span class="rojo">NIT/CC:</span> <span><?php echo $usuario->documento;?></span>
          </div>
          <div class="group">
              <span class="rojo">TELÉFONO:</span> <span><?php echo $usuario->telefonos;?></span>
          </div>
      </div>
  </div><!--end logo-->
  <div id="header-der" class="row pull-right">
      <h4 class="rojo">COTIZACION</h4>
      <div class="caja caja-gris">
          <div class="titulo">No.</div>
          <div class="contenido rojo">N. <?php echo str_pad($cotizacion_model->id, 4, '0', STR_PAD_LEFT)?></div>
      </div>
      <div class="caja caja-gris">
          <div class="titulo">FECHA</div>
          <div class="contenido"><?php  echo strftime('%d/%B/%Y');?></div>
      </div>
  </div>
  <div id="tbl-datos">
      <table>
          <thead>
              <th id="referencia">REFERENCIA</th>
              <th id="cantidad">CANT.</th>
              <th id="descripcion">DESCRIPCIÓN</th>
              <th id="p-unidad">PRECIO UNIT.</th>
              <th id="p-total">PRECIO TOTAL</th>
          </thead>
          <tbody>
            <?php 
                $odd = true;
                $html = '';
                $base = 0;
                $ivaSum = 0;
                $precioSum = 0;
                foreach ($itemsCot as $key => $item) {
                  foreach ($item->proveedores_cotizacion as $key => $pc) {
                      if($item->valido && $pc->elegido){ 
                          $precioTemp = $item->precio * $item->cantidad;
                          $baseTemp = $precioTemp / (1+($pc->iva/100));
                          $ivaTemp = $precioTemp - $baseTemp;

                          $precioSum += $precioTemp;
                          $base += $baseTemp;
                          $ivaSum += $ivaTemp;

                          $html .= '<tr class="'; if($odd){ $html .="odd"; $odd = false;} else{ $html .= "even"; $odd = true;}  
                          $html .='" >
                          <td class="center"></td>
                          <td class="center"> ' . $item->cantidad . '</td>
                          <td>' . $item->item . '</td>
                          <td class="right">$ ' . number_format($baseTemp, 0, ',', '.') . '</td>
                          <td class="right">$ ' . number_format($baseTemp, 0, ',', '.') . '</td>
                          </tr>';
                      }
                  }
                 
                }

                $html .= '<tr class="'; if($odd){ $html .="odd"; $odd = false;} else{ $html .= "even"; $odd = true;}  $html .='" >
                <td class="center"></td>
                    <td class="center">&nbsp;</td>
                    <td></td>
                    <td class="right"></td>
                    <td class="right"></td>
                </tr>';

                $html .= '<tr class="'; if($odd){ $html .="odd"; $odd = false;} else{ $html .= "even"; $odd = true;}  $html .='" >
                <td class="center"></td>
                    <td class="center">&nbsp;</td>
                    <td></td>
                    <td class="right"></td>
                    <td class="right"></td>
                </tr>';

                $html .= '<tr class="'; if($odd){ $html .="odd"; $odd = false;} else{ $html .= "even"; $odd = true;}  $html .='" >
                <td class="center"></td>
                    <td class="center">&nbsp;</td>
                    <td></td>
                    <td class="right"></td>
                    <td class="right"></td>
                </tr>';

                echo $html;
            ?>

          </tbody>
      </table>
  </div>
  <div class="group btm-row" id=""> 
      <div class="row pull-right" id="totales">
          <table>
              <tr>
                  <td class="bg-gris">SUBTOTAL</td>
                  <td class="right">$<?php echo number_format($base, 0, ',', '.')?></td>
              </tr>
              <tr>
                  <td class="bg-gris">I.V.A</td>
                  <td class="right">$<?php echo number_format($ivaSum, 0, ',', '.')?></td>
              </tr>
              <tr>
                  <td class="bg-gris">TOTAL</td>
                  <td class="right">$<?php echo number_format($precioSum, 0, ',', '.')?></td>
              </tr>
          </table>
      </div>
  </div><br/><br/>
  <div class="group btm-row" id="clausulas">
      <div class="group">
            *La presente cotización tiene una validez de 15 días calendario.
      </div>
  </div>
</div>
</body>

</html>