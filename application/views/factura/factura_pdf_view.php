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
.caja.caja-roja .titulo{
    color: white;
    background-color: #FC0309;
    padding-left: 3px;
}

.caja.caja-roja{
    border-color: #FC0309;
}

#datos-lp{
    font-size: 14px;
}

#datos-cliente{
    margin-top: 20px;
    padding: 20px 15px 30px;
}

.caja-especial{
    border: 2px solid #FC0309;
    border-top: 10px solid #FC0309;
    border-bottom-right-radius: 7px;
    border-bottom-left-radius: 7px;
}

.center{
    text-align: center;
}

.right{
    text-align: right;
}

#resoluciones{
    margin-top: 10px;
}

.resolucion{
    font-size: 12px;
}

#tbl-datos{
    width: 100%;
    margin-top: 10px;
}

table{
    width: 100%;
    border: 2px solid #FC0309;
    border-collapse: collapse;
    border-spacing: 0;
}

table th{
    background-color: #FC0309;
    color: white;
    text-align: center;
    font-size: 12px;
    font-weight: normal;
}

td{
    border-left: 2px solid #FC0309;
    border-right: 2px solid #FC0309;
    font-size: 12px;
}

tr.odd{
    background-color: white;
}

tr.even{
    background-color: #FEF6F4;
}

#totales table td{
    padding: 3px 8px 3px;
    border: 2px solid #FC0309;
}

.bg-rojo{
    background-color: #FC0309;
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

#observaciones{
    width: 600px;
}

#aceptado, #vendedor{
    width: 380px;
}

#clausulas{
    font-size: 10px;
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
              <span class="rojo">CLIENTE:</span> <span><?php echo $venta->nombre_apellido;?></span>
          </div>
          <div class="group">
              <span class="rojo">NIT/CC:</span> <span><?php echo $venta->documento;?></span>
          </div>
          <div class="group">
              <span class="rojo">DIRECCIÓN:</span> <span><?php echo $venta->direccion;?></span>
          </div>
          <div class="group">
              <span class="rojo">TELÉFONO:</span> <span><?php echo $venta->telefono;?></span>
          </div>
      </div>
  </div><!--end logo-->
  <div id="header-der" class="row pull-right">
      <h4 class="rojo">FACTURA DE VENTA</h4>
      <div class="caja caja-roja">
          <div class="titulo">No.</div>
          <div class="contenido rojo">N. <?php echo str_pad($consecutivo, 4, '0', STR_PAD_LEFT)?></div>
      </div>
      <div class="caja caja-roja">
          <div class="titulo">FECHA</div>
          <div class="contenido"><?php  echo strftime('%d/%B/%Y' ,strtotime($venta->fecha));?></div>
      </div>
      <div class="caja caja-roja">
          <div class="titulo">FECHA DE PAGO</div>
          <div class="contenido"><?php if($venta->fecha_pago != null || $venta->fecha_pago !='') echo strftime('%d/%B/%Y' ,strtotime($venta->fecha_pago)); else echo strftime('%d/%B/%Y' ,strtotime($venta->fecha));?></div>
      </div>
      <div id="resoluciones">
          <div class="group center resolucion">
              Resolución DIAN No.
          </div>
          <div class="group center resolucion">
              320001027921
          </div>
          <div class="group center resolucion">
              19/06/2013
          </div>
          <div class="group center resolucion">
              Del No. 1.001 al No. 4.000
          </div>
          <div class="group center resolucion">
              Autoriza
          </div>   
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
                $valorSum = 0;
                foreach ($ofertas as $row1):
                $destinatario = new stdClass();
                $destinatario->email = $row1->email;
                $destinatarios[] = $destinatario;
                if ($row1->dco_feria != 0):
                    $precio = $row1->precio;
                    $iva = $row1->iva;
                    $dco = $row1->dco_feria;
                    $base = $precio - $iva;
                    $ivaPorce = $iva / $base;
                    $valorDco = $base * ((100 - $dco) / 100);
                    $precionConDco = ($valorDco * (1 + $ivaPorce));
                    $valorSum += $precionConDco * $row1->cantidad;
                    $ivaSum += round($precionConDco - $valorDco) * $row1->cantidad;
                    $html .= '<tr class="'; if($odd){ $html .="odd"; $odd = false;} else{ $html .= "even"; $odd = true;}  $html .='" >
                        <td class="center"></td>
                        <td class="center"> ' . $row1->cantidad . '</td>
                        <td>' . $row1->titulo . '</td>
                        <td class="right">$ ' . number_format($valorDco, 0, ',', '.') . '</td>
                        <td class="right">$ ' . number_format($valorDco * $row1->cantidad, 0, ',', '.') . '</td>
                        </tr>';
                else:
                    $ivaSum += round($row1->iva) * $row1->cantidad;
                    $valorSum += $row1->precio * $row1->cantidad;
                    $html .= '<tr class="'; if($odd){ $html .="odd"; $odd = false;} else{ $html .= "even"; $odd = true;}  $html .='" >
                        <td class="center"></td>
                        <td class="center"> ' . $row1->cantidad . '</td>
                        <td>' . $row1->titulo . '</td>
                        <td class="right">$ ' . number_format($row1->precio-round($row1->iva), 0, ',', '.') . '</td>
                        <td class="right">$ ' . number_format(($row1->precio-round($row1->iva)) * $row1->cantidad, 0, ',', '.') . '</td>
                    </tr>';
                endif;
            endforeach;

            foreach ($autopartes as $row):
                $destinatario = new stdClass();
                $destinatario->email = $row->email;
                $destinatarios[] = $destinatario;
                $valorSum += $row->precio * $row->cantidad;
                $ivaSum += round($row->precio - ($row->precio / 1.16)) * $row->cantidad;
                $html .= '<tr class="'; if($odd){ $html .="odd"; $odd = false;} else{ $html .= "even"; $odd = true;}  $html .='" >
                    <td class="center"></td>
                    <td class="center"> ' . $row->cantidad . '</td>
                    <td>' . $row->autoparte . '</td>
                    <td class="right">$ ' . number_format($row->precio/1.16, 0, ',', '.') . '</td>
                    <td class="right">$ ' . number_format(($row->precio * $row->cantidad) /1.16, 0, ',', '.') . '</td>
                </tr>';
            endforeach;

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
      <div class="row" id="observaciones">
          <div class="caja-especial">
              <div>OBSERVACIONES</div> 
              <?php 
                  echo '<strong>Vehículo: </strong> '.$venta->carro.'<br/><strong>Placa del vehículo:</strong> '.$venta->placa;
              ?>
              <br><br>
          </div>
      </div>
      <div class="row pull-right" id="totales">
          <table>
              <tr>
                  <td class="bg-rojo">SUBTOTAL</td>
                  <td class="right">$<?php echo number_format($valorSum-$ivaSum, 0, ',', '.')?></td>
              </tr>
              <tr>
                  <td class="bg-rojo">I.V.A</td>
                  <td class="right">$<?php echo number_format($ivaSum, 0, ',', '.')?></td>
              </tr>
              <tr>
                  <td class="bg-rojo">TOTAL</td>
                  <td class="right">$<?php echo number_format($valorSum, 0, ',', '.')?></td>
              </tr>
          </table>
      </div>
  </div>
  <div class="group btm-row" id=""> 
      <div class="row" id="aceptado">
          <div class="caja-especial">
              <div>ACEPTADO</div>
              <br><br><br>
          </div>
      </div>
      <div class="row pull-right" id="vendedor">
          <div class="caja-especial">
              <div>VENDEDOR</div>
              <br><br><br>
          </div>
      </div>
  </div>
  <div class="group btm-row" id="clausulas">
      <div class="group">
            La presente factura cambiaria de venta, es un título valor según Ley 1231 de 2008 del A.C."
      </div>
      <div class="group">
            Causará interes de mora a la tasa máxima permitida por la ley a partir de su fecha de vencimiento
      </div>
      <div class="group">
            IVA Regimen común.
      </div>
      <div class="group">
            Actividad ICA 304 Tarifa 9.66 x 1000.
      </div>
  </div>
</div>
</body>

</html>