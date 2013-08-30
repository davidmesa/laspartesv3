<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Clase que maneja la facturación
 */
class Facturacion extends CI_Controller {

    /**
     * Constructor de la clase cotizaciones
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('operacion/factura_model');
        $this->load->model('operacion/recibo_model');
        $this->load->model('operacion/link_pago_model');
        // error_reporting(E_ALL);
    }

    function index() {

    }

    /**
     * Muestra la facturación asociada al pipeline
     * @param  [type] $id_pipeline [description]
     * @param  [type] $id_usuario  [description]
     * @param  string $msj         [description]
     * @return [type]              [description]
     */
    function mostrar_facturacion($id_pipeline, $id_usuario, $msj = ''){
        if($this->hay_sesion_activa()){
            $this->load->model('promocion_model');
            $link_pago_model = $this->link_pago_model->dar_todos_filtros(array('id_pipeline' =>$id_pipeline)); 
            foreach ($link_pago_model as $key => $link) {
                $link_pago_model[$key]->oferta = $this->promocion_model->dar_oferta($link->id_oferta);
            }
            $data['facturas'] = $this->factura_model->dar_todos_filtros(array('id_pipeline' =>$id_pipeline)); 
            $data['recibos'] = $this->recibo_model->dar_todos_filtros(array('id_pipeline' =>$id_pipeline)); 
            $data['link_pago_model'] = $link_pago_model;
            $data['id_pipeline'] = $id_pipeline;
            $data['id_usuario'] = $id_usuario;
            $data['msj'] = $msj;
            $data['nombrevista'] = 'operacion/facturacion/mostrar/';
            $this->load->view('operacion/facturacion/mostrar/page', $data);
        }else{
            echo 'Debes iniciar sesion como administrador';
        }
    }

    /**
     * Muestra el formulario para generar la factura
     * @param  [type] $id_pipeline
     * @param  [type] $id_usuario 
     * @param  [type] $ids        
     * @return [type]             
     */
    function form_factura($id_pipeline, $id_usuario, $ids){
        if($this->hay_sesion_activa()){
            setlocale(LC_ALL, 'es_ES');
            $this->load->model('usuario_model');
            $this->load->model('vehiculo_model');
            $allvehiculos = $this->vehiculo_model->dar_vehiculos();
            foreach ($allvehiculos as $index => $vehiculo) {
                $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
                $data['allvehiculos'][$index]->value = $vehiculo->id_vehiculo;
            }
            $data['id_pipeline'] = $id_pipeline;
            $data['id_usuario'] = $id_usuario;
            $data['ids'] = $ids;
            $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
            $data['ids'] = $ids;
            $data['nombrevista'] = 'operacion/facturacion/form/';
            $this->load->view('operacion/facturacion/form/page', $data);
        }else{
            echo 'Debes iniciar sesion como administrador';
        }
    }

    /**
     * Muestra el formulario para generar el recibo
     * @param  [type] $id_pipeline
     * @param  [type] $id_usuario 
     * @param  [type] $ids        
     * @return [type]             
     */
    function form_recibo($id_pipeline, $id_usuario, $ids){
        if($this->hay_sesion_activa()){
            setlocale(LC_ALL, 'es_ES');
            $this->load->model('usuario_model');
            $this->load->model('vehiculo_model');
            $allvehiculos = $this->vehiculo_model->dar_vehiculos();
            foreach ($allvehiculos as $index => $vehiculo) {
                $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
                $data['allvehiculos'][$index]->value = $vehiculo->id_vehiculo;
            }
            $data['id_pipeline'] = $id_pipeline;
            $data['id_usuario'] = $id_usuario;
            $data['ids'] = $ids;
            $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
            $data['ids'] = $ids;
            $data['nombrevista'] = 'operacion/facturacion/formRecibo/';
            $this->load->view('operacion/facturacion/formRecibo/page', $data);
        }else{
            echo 'Debes iniciar sesion como administrador';
        }
    }

    /**
     * Genera la factura
     * @return [type] [description]
     */
    function generar_factura(){
        if($this->hay_sesion_activa()){
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'nombres',
                    'label' => 'nombres',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'documento',
                    'label' => 'documento',
                    'rules' => 'trim|xss_clean'
                ), array(
                    'field' => 'correo',
                    'label' => 'correo electrónico',
                    'rules' => 'trim|required|valid_email|xss_clean'
                ), array(
                    'field' => 'fechapago',
                    'label' => 'fecha de pago',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'lugar',
                    'label' => 'lugar',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'direccion',
                    'label' => 'dirección',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'telefono',
                    'label' => 'teléfono',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'carro',
                    'label' => 'carro',
                    'rules' => 'trim|numeric|xss_clean'
                ),
                array(
                    'field' => 'placa',
                    'label' => 'placa',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'ids',
                    'label' => 'ids de ofertas',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'id_pipeline',
                    'label' => 'id pipeline',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'id_usuario',
                    'label' => 'id usuario',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()){
                echo json_encode(array('status' => false, 'msg' => validation_errors()), JSON_HEX_QUOT | JSON_HEX_TAG);
            }else {
                $this->load->model('usuario_model');
                $this->load->model('refventa_model');
                $this->load->model('autoparte_model');
                $this->load->model('refventa_model');
                $this->load->model('promocion_model');
                $this->load->model('vehiculo_model');
                $refVenta = $this->refventa_model->generar_RefVenta_Unico();

                $id_pipeline = $this->input->post('id_pipeline');
                $id_usuario = $this->input->post('id_usuario');
                $id_ofertas = explode('-', $this->input->post('ids'));
                $nombres = $this->input->post('nombres');
                $documento = $this->input->post('documento');
                $correo = $this->input->post('correo');
                $lugar = $this->input->post('lugar');
                $direccion = $this->input->post('direccion');
                $telefono = $this->input->post('telefono');
                $carroModel = $this->vehiculo_model->dar_vehiculo($this->input->post('carro'));
                $carro = $carroModel->marca.' '.$carroModel->linea;
                $placa = $this->input->post('placa');
                $fecha_pago = $this->input->post('fechapago');

                $usuario = $this->usuario_model->dar_usuario($id_usuario);
                $total = 0;
                foreach ($id_ofertas as $index => $id_oferta):
                    if ($id_oferta != 0) {
                        $ofertamodel = $this->promocion_model->dar_oferta($id_oferta);
                        if ($ofertamodel->dco_feria != 0):
                            $precio = $ofertamodel->precio;
                            $iva = round($ofertamodel->iva);
                            $dco = $ofertamodel->dco_feria;
                            $base = $precio - $iva;
                            $ivaPorce = $iva / $base;
                            $valorDco = $base * ((100 - $dco) / 100);
                            $precionConDco = ($valorDco * (1 + $ivaPorce));
                            $total += $precionConDco;
                        else:
                            $total += $ofertamodel->precio;
                        endif;
                    }
                endforeach;

                $id_carrito = $this->usuario_model->agregar_carrito_compras($usuario->id_usuario, 'Transacción aprobada', round($total), $nombres, $lugar, $telefono, $direccion, $correo, $documento, $carro, $placa, $fecha_pago);
                foreach ($id_ofertas as $index => $id_oferta):
                    if ($id_oferta != 0)
                        $this->usuario_model->agregar_carrito_compras_ofertas($id_carrito, $id_oferta, 1);
                endforeach;

                $this->refventa_model->agregar_RefVenta($refVenta, $id_carrito);
                $facturaTemp = $this->_generar_factura($refVenta);

                $factura_model = new factura_model();
                $factura_model->id_consecutivo_factura = $facturaTemp['consecutivo'];
                $factura_model->id_pipeline = $id_pipeline;
                $factura_model->url = $facturaTemp['url'];
                $factura_model->insertar();
                echo json_encode(array('status' => true));
            }
        }else{
        echo json_encode(array('status' => false, 'msg' => 'Debes iniciar sesión como administrador'));
        }
    }

    /**
     * Genera la factura en pdf
     * @param  [type] $refVenta [description]
     * @param  string $mensaje  [description]
     * @return [type]           [description]
     */
    function _generar_factura($refVenta) {
        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");
        $this->load->library('phptopdf');
        $this->load->model('refventa_model');
        $this->load->model('usuario_model');
        $this->load->helper('mail');
        $destinatarios = array();
        $venta = $this->refventa_model->dar_venta($refVenta);
        $autopartes = $this->usuario_model->dar_carrito_compra_autopartes($venta->id_carrito_compra);
        $ofertas = $this->usuario_model->dar_carrito_compra_ofertas($venta->id_carrito_compra);
        $consecutivo = $this->usuario_model->agregar_consecutivo_compra($venta->id_carrito_compra);
        $valorSum = 0;
        $ivaSum = 0;
        $data1['venta'] = $venta;
        $data1['autopartes'] = $autopartes;
        $data1['ofertas'] = $ofertas;
        $data1['consecutivo'] = $consecutivo;

        
        $html = $this->load->view('factura/factura_pdf_view', $data1, true);

        $destinatario = new stdClass();
        $destinatario->email = $venta->email;
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = "tallerenlinea@laspartes.com.co";
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = "ventas@laspartes.com.co";
        $destinatarios[] = $destinatario;
        // $destinatario = new stdClass();
        // $destinatario->email = "direcciondesarrollo@laspartes.com.co";
        // $destinatarios[] = $destinatario;
        
        ob_start();
        
        
        $this->load->view('emails/recibo_compra_view', $data1);
        $contenidoHTML = ob_get_contents();
        ob_end_clean();
        
        $filePath = 'resources/facturas/';
        $fileName = 'factura-' . $refVenta . '.pdf';
        $this->phptopdf->phptopdf_html($html, $filePath, $fileName);
        send_mail($destinatarios, "Factura de compra LasPartes.com - " . strftime("%B %d de %Y"), $contenidoHTML, "", $fileName);
        return array('consecutivo' => $consecutivo, 'url' =>$filePath.$fileName, 'refventa' => $refVenta);
    }

    /**
     * Genera la factura
     * @return [type] [description]
     */
    function generar_recibo(){
        if($this->hay_sesion_activa()){
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'nombres',
                    'label' => 'nombres',
                    'rules' => 'trim|required|xss_clean'
                ), array(
                    'field' => 'documento',
                    'label' => 'documento',
                    'rules' => 'trim|xss_clean'
                ), array(
                    'field' => 'correo',
                    'label' => 'correo electrónico',
                    'rules' => 'trim|required|valid_email|xss_clean'
                ), array(
                    'field' => 'lugar',
                    'label' => 'lugar',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'direccion',
                    'label' => 'dirección',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'telefono',
                    'label' => 'teléfono',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'carro',
                    'label' => 'carro',
                    'rules' => 'trim|numeric|xss_clean'
                ),
                array(
                    'field' => 'placa',
                    'label' => 'placa',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'ids',
                    'label' => 'ids de ofertas',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'id_pipeline',
                    'label' => 'id pipeline',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'id_usuario',
                    'label' => 'id usuario',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()){
                echo json_encode(array('status' => false, 'msg' => validation_errors()), JSON_HEX_QUOT | JSON_HEX_TAG);
            }else {
                $this->load->model('usuario_model');
                $this->load->model('refventa_model');
                $this->load->model('autoparte_model');
                $this->load->model('refventa_model');
                $this->load->model('promocion_model');
                $this->load->model('vehiculo_model');
                $refVenta = $this->refventa_model->generar_RefVenta_Unico();

                $id_pipeline = $this->input->post('id_pipeline');
                $id_usuario = $this->input->post('id_usuario');
                $id_ofertas = explode('-', $this->input->post('ids'));
                $nombres = $this->input->post('nombres');
                $documento = $this->input->post('documento');
                $correo = $this->input->post('correo');
                $lugar = $this->input->post('lugar');
                $direccion = $this->input->post('direccion');
                $telefono = $this->input->post('telefono');
                $carroModel = $this->vehiculo_model->dar_vehiculo($this->input->post('carro'));
                $carro = $carroModel->marca.' '.$carroModel->linea;
                $placa = $this->input->post('placa');
                $fecha_pago = $this->input->post('fechapago');

                $usuario = $this->usuario_model->dar_usuario($id_usuario);
                $total = 0;
                foreach ($id_ofertas as $index => $id_oferta):
                    if ($id_oferta != 0) {
                        $ofertamodel = $this->promocion_model->dar_oferta($id_oferta);
                        if ($ofertamodel->dco_feria != 0):
                            $precio = $ofertamodel->precio;
                            $iva = round($ofertamodel->iva);
                            $dco = $ofertamodel->dco_feria;
                            $base = $precio - $iva;
                            $ivaPorce = $iva / $base;
                            $valorDco = $base * ((100 - $dco) / 100);
                            $precionConDco = ($valorDco * (1 + $ivaPorce));
                            $total += $precionConDco;
                        else:
                            $total += $ofertamodel->precio;
                        endif;
                    }
                endforeach;

                $id_carrito = $this->usuario_model->agregar_carrito_compras($usuario->id_usuario, 'Transacción aprobada', round($total), $nombres, $lugar, $telefono, $direccion, $correo, $documento, $carro, $placa, $fecha_pago);
                foreach ($id_ofertas as $index => $id_oferta):
                    if ($id_oferta != 0)
                        $this->usuario_model->agregar_carrito_compras_ofertas($id_carrito, $id_oferta, 1);
                endforeach;

                $this->refventa_model->agregar_RefVenta($refVenta, $id_carrito);
                $reciboTemp = $this->_generar_recibo($refVenta);

                $recibo_model = new recibo_model();
                $recibo_model->id_consecutivo_recibo = $reciboTemp['consecutivo'];
                $recibo_model->id_pipeline = $id_pipeline;
                $recibo_model->url = $reciboTemp['url'];
                $recibo_model->insertar();
                echo json_encode(array('status' => true));
            }
        }else{
        echo json_encode(array('status' => false, 'msg' => 'Debes iniciar sesión como administrador'));
        }
    }

    function _generar_recibo($refVenta) {
        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");
        $this->load->library('pdf');
        $this->load->model('refventa_model');
        $this->load->model('usuario_model');
        $this->load->helper('mail');
        $destinatarios = array();
        $venta = $this->refventa_model->dar_venta($refVenta);
        $autopartes = $this->usuario_model->dar_carrito_compra_autopartes($venta->id_carrito_compra);
        $ofertas = $this->usuario_model->dar_carrito_compra_ofertas($venta->id_carrito_compra);
        $consecutivo = $this->usuario_model->agregar_consecutivo_recibo($venta->id_carrito_compra);
        $valorSum = 0;
        $ivaSum = 0;
        // set document information
        $this->pdf->SetSubject('Recibo de caja de laspartes.com');

        // set font
        $this->pdf->SetFont("helveticaBI", "", 11);

        // add a page
        $this->pdf->AddPage();

        $html = '<table>
                <tr>
                    <td width="30%">
                        <img width="500" height="350" src="http://www.laspartes.com/resources/template/header/logo-laspartes.png" alt="laspartes.com" />
                    </td>
                    <td width="50%">
                        LASPARTES.COM.CO SAS.<br/>
                        NIT 900216983-8<br/>
                        Carrera 16 # 80 - 11 Oficina 602<br/>
                        Edificio El Escorial<br/>
                        Tel: 1-6007737 | 1-3819790<br/>
                        e-mail: contactenos@laspartes.com.co<br/>
                        Bogotá, Colombia
                    </td>
                    <td width="3%">
                    </td>
                    <td width="17%" valign="top">
                        <span style="color:#c60200;">RECIBO DE CAJA</span>
                        <div style="color:white; background-color:#c60200; ">No.</div>
                        <span style="border:1px solid #c60200; ">' . str_pad($consecutivo, 4, '0', STR_PAD_LEFT) . '</span><br/>
                        <div style="color:white; background-color:#c60200; ">FECHA</div>
                        <span style="border:1px solid #c60200; ">' . $venta->fecha . '</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="border:5px solid #c60200;">
                            <br/>&nbsp;&nbsp;CLIENTE: ' . $venta->nombre_apellido . ' <br/>
                            &nbsp;&nbsp;DOCUMENTO: ' . $venta->documento . '<br/>
                            &nbsp;&nbsp;CIUDAD: ' . $venta->ciudad . '<br/>
                            &nbsp;&nbsp;DIRECCIÓN: ' . $venta->direccion . '<br/>
                            &nbsp;&nbsp;TELEFONO: ' . $venta->telefono . '<br/>
                            &nbsp;&nbsp;CARRO: ' . $venta->carro . '<br/>
                            &nbsp;&nbsp;PLACA DEL CARRO: ' . $venta->placa . '<br/>
                        </div>
                    </td>
                    <td>
                    </td>
                    <td>
                        <div style="color:white; background-color:#c60200; ">FECHA DE PAGO</div>
                        <span style="border:1px solid #c60200; ">' . $venta->fecha . '</span><br/>
                        <div style="text-align:center;  font-size:100px;">
                        </div>
                    </td>
                </tr>
            </table>';

        // output the HTML content
        $this->pdf->writeHTML($html, true, false, true, false, '');


        $html = '<table border="5" style="border-color:#c60200;">
                <tr align="center" style="font-size:100px;">
                    <th  width="20%" bgcolor="#c60200" style="color:white;">OFERTA</th>
                    <th  width="9%" bgcolor="#c60200" style="color:white;">CANT.</th>
                    <th  width="45%" bgcolor="#c60200" style="color:white;">INCLUYE</th>
                    <th  width="13%" bgcolor="#c60200" style="color:white;">PRECIO UNIT.</th>
                    <th  width="13%" bgcolor="#c60200" style="color:white;">PRECIO TOTAL</th>
                </tr>';
        foreach ($ofertas as $row1):
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
                $html .= '<tr style="font-size:90px;"><td> ' . $row1->titulo . '</td><td style="text-align:center;">' . $row1->cantidad . '</td><td>' . $row1->incluye . '</td><td style="text-align:center;">$ ' . number_format($valorDco, 0, ',', '.') . '</td><td style="text-align:center;">$ ' . number_format($valorDco * $row1->cantidad, 0, ',', '.') . '</td></tr>';
            else:
                $ivaSum += round($row1->iva) * $row1->cantidad;
                $valorSum += $row1->precio * $row1->cantidad;
                $html .= '<tr style="font-size:90px;"><td> ' . $row1->titulo . '</td><td style="text-align:center;">' . $row1->cantidad . '</td><td>' . $row1->incluye . '</td><td style="text-align:center;">$ ' . number_format($row1->precio-round($row1->iva), 0, ',', '.') . '</td><td style="text-align:center;">$ ' . number_format(($row1->precio-round($row1->iva)) * $row1->cantidad, 0, ',', '.') . '</td></tr>';
            endif;

        endforeach;
        $html .='
                </table>';
        $this->pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table cellpadding="0" cellspacing="0"border="0">
                    <tr>
                        <td width="70%">
                            <div style="border:5px solid #c60200;">
                                OBSERVACIONES<br/>
                                La referencia de su pedido es: ' . $venta->referencia . '<br/>
                                Costos de envío no están incluídos, dependen del peso y destino de la autoparte.<br/>
                                Precios sujetos a disponibilidad.    
                            </div>
                        </td>
                        <td width="3%">
                        </td>
                        <td width="15%" style="font-size:100px;">
                           <div style="color:white; background-color:#c60200; ">
                                SUBTOTAL
                            </div> 
                            <div style="color:white; background-color:#c60200; ">
                                I.V.A
                            </div> 
                            <div style="color:white; background-color:#c60200; ">
                                TOTAL
                            </div> 
                        </td>
                        <td width="12%" style="font-size:100px;">
                           <div style="border:1px solid #c60200; ">
                                $' . number_format($valorSum - $ivaSum, 0, ',', '.') . '
                            </div> 
                            <div style="border:1px solid #c60200; ">
                                $' . number_format($ivaSum, 0, ',', '.') . '
                            </div> 
                            <div style="border:1px solid #c60200; ">
                                $' . number_format($valorSum, 0, ',', '.') . '
                            </div> 
                        </td>
                    </tr>
                </table';
        $this->pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table>
                    <tr>
                        <td width="45%">
                            <div style="border:5px solid #c60200;">
                                ACEPTADO<br/>
                            </div>
                        </td>
                        <td width="10%">
                        </td>
                        <td width="45%">
                            <div style="border:5px solid #c60200;">
                                VENDEDOR<br/>
                            </div>
                        </td>
                    </tr>
                </table';
        $this->pdf->writeHTML($html, true, false, true, false, '');


        $destinatario = new stdClass();
        $destinatario->email = $venta->email;
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = "tallerenlinea@laspartes.com.co";
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = "ventas@laspartes.com.co";
        $destinatarios[] = $destinatario;
        // $destinatario = new stdClass();
        // $destinatario->email = "direcciondesarrollo@laspartes.com.co";
        // $destinatarios[] = $destinatario;

        ob_start();
        $data1['mensaje'] = $mensaje;
        $data1['venta'] = $venta;
        $data1['autopartes'] = $autopartes;
        $data1['ofertas'] = $ofertas; 


        $this->load->view('emails/recibo_compra_view', $data1);
        $contenidoHTML = ob_get_contents();
        ob_end_clean();
        ob_flush();
        $filePath = 'resources/recibos/';
        $fileName = 'recibo-' . $refVenta . '.pdf';
        $this->pdf->Output($filePath . $fileName, 'F');
        send_mail($destinatarios, "Recibo de compra LasPartes.com - " . strftime("%B %d de %Y"), $contenidoHTML, "", $fileName, $filePath);
        return array('consecutivo' => $consecutivo, 'url' =>$filePath.$fileName, 'refventa' => $refVenta);
    }

     //Valida si existe una sesion activa
    //en caso de que la sesión este activa, retorna true, de lo contrario false
    function hay_sesion_activa(){
        $sesion = $this->session->userdata('esta_registrado');
        $tipo = $this->session->userdata('tipo');
        if( $sesion == true && $tipo == 10) {
            return true;
        }else {
            return false;
        }
    }

}