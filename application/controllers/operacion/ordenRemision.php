<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once($_SERVER['BASEPATH'].'application/controllers/dropbox_controller.php');
/**
 * Clase que en link de pago
 */
class OrdenRemision extends Dropbox_Controller {

    /**
     * Constructor de la clase OrdenCompra
     */
    function __construct() {
        parent::__construct();
        $this->load->model('operacion/orden_remision_model');
        // error_reporting(E_ALL);
    }

    function index() {
    }

    /**
     * Mostrar ordenes de compra relacionadas con un pipeline
     * @param  [type] $id_pipeline [description]
     * @param  [type] $id_usuario  [description]
     * @param  [type] $msj         [description]
     * @return [type]              [description]
     */
    function mostrar_ordedes($id_pipeline, $id_usuario, $msj){
        if($this->hay_sesion_activa()){
            $this->load->model('usuario_model');
            $data['id_pipeline'] = $id_pipeline;
            $data['id_usuario'] = $id_usuario;

            $data['ordenes'] = $this->orden_remision_model->dar_todos_filtros(array('id_pipeline' => $id_pipeline));
            // foreach ($data['ordenes'] as $index => $orden) {
            //     $data['ordenes'][$index]->bono = $this->usuario_model->dar_bono($orden->id_bono);
            // }
            // var_dump($data['ordenes']);
            $data['nombrevista'] = 'operacion/ordenRemision/ordenes/';
            $this->load->view('operacion/ordenRemision/ordenes/page', $data);
        }else{
            echo 'Debes iniciar sesion como administrador';
        }
    }

    /**
     * Muestra el formulario de agregar una orden de compra
     * @param  [type] $id_pipeline [description]
     * @param  [type] $id_usuario  [description]
     * @return [type]              [description]
     */
    function form_orden($id_pipeline, $id_usuario){
        if($this->hay_sesion_activa()){
            $this->load->model('usuario_model');
            $this->load->model('establecimiento_model');
            $this->load->model('vehiculo_model');
            $data['id_pipeline'] = $id_pipeline;
            $data['id_usuario'] = $id_usuario;
            $allvehiculos = $this->vehiculo_model->dar_vehiculos();
            foreach ($allvehiculos as $index => $vehiculo) {
                $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
                $data['allvehiculos'][$index]->value = $vehiculo->id_vehiculo;
            }
            $data['talleres'] = $this->establecimiento_model->dar_establecimientos();
            $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
            $data['nombrevista'] = 'operacion/ordenRemision/guardar/';
            $this->load->view('operacion/ordenRemision/guardar/page', $data);
        }else{
            echo 'Debes iniciar sesion como administrador';
        }
    }

    /**
     * Genera el bono del usuario 
     */
    function generar_orden_remision() {
        if($this->hay_sesion_activa()){
            $respuestaRequest = $this->request_dropbox();
            $jsonrespuestaRequest = json_decode($respuestaRequest);
            if($jsonrespuestaRequest->status == true){
                $this->load->library('form_validation');
                $reglas = array(
                    array(
                        'field' => 'nombres',
                        'label' => 'nombres',
                        'rules' => 'trim|required|xss_clean'
                    ), array(
                        'field' => 'email',
                        'label' => 'email',
                        'rules' => 'trim|required|xss_clean'
                    ), array(
                        'field' => 'ciudadEnvio',
                        'label' => 'ciudad',
                        'rules' => 'trim|required|xss_clean'
                    ), array(
                        'field' => 'direccionEnvio',
                        'label' => 'dirección',
                        'rules' => 'trim|required|xss_clean'
                    ), array(
                        'field' => 'telefonoMovil',
                        'label' => 'telefono',
                        'rules' => 'trim|required|xss_clean'
                    ), array(
                        'field' => 'vehiculo_id',
                        'label' => 'carro',
                        'rules' => 'trim|required|xss_clean'
                    ), array(
                        'field' => 'id_talleres',
                        'label' => 'taller',
                        'rules' => 'trim|required|xss_clean'
                    ), array(
                        'field' => 'descripcion',
                        'label' => 'descripción',
                        'rules' => 'trim|required|xss_clean'
                    ),
                    array(
                        'field' => 'id_pipeline',
                        'label' => 'id pipeline',
                        'rules' => 'trim|xss_clean'
                    ),
                    array(
                        'field' => 'id_usuario',
                        'label' => 'id usuario',
                        'rules' => 'trim|xss_clean'
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
                    $id_usuario = $this->input->post('id_usuario');
                    $id_pipeline = $this->input->post('id_pipeline');
                    $nombres = $this->input->post('nombres');
                    $email = $this->input->post('email');
                    $ciudadEnvio = $this->input->post('ciudadEnvio');
                    $direccionEnvio = $this->input->post('direccionEnvio');
                    $telefonoMovil = $this->input->post('telefonoMovil');
                    $id_vehiculo = $this->input->post('vehiculo_id');
                    $id_taller = $this->input->post('id_talleres');
                    $bono = $this->input->post('descripcion');
                    $consecutivo = $this->usuario_model->agregar_bono_usuario($id_usuario, $id_taller, $id_vehiculo, $nombres, $email, $ciudadEnvio, $direccionEnvio, $telefonoMovil, $bono);
                    $this->_generar_orden_remision($consecutivo);
                    $orden_remision_model = new orden_remision_model();
                    $orden_remision_model->id_pipeline = $id_pipeline;
                    $orden_remision_model->id_bono = $consecutivo;
                    $orden_remision_model->insertar();

                    echo json_encode(array('status' => true));
                }
            }else{
                echo $respuestaRequest;
            } 
        }else{
            echo json_encode(array('status' => false, 'msg' => 'Debes iniciar sesión como administrador'));
        }
    }

    /**
     * Genera el el pdf del bono y se lo envía a la persona y taller en línea
     * @param type $consecutivo 
     */
    function _generar_orden_remision($consecutivo) {
        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");
        $this->load->library('pdf');
        $this->load->model('usuario_model');
        $this->load->helper('mail');
        $destinatarios = array();
        $venta = $this->usuario_model->dar_bono($consecutivo);
        // set document information
        $this->pdf->SetSubject('Orden de remisión de laspartes.com');

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
                        Carrera 16 # 80 - 11 Oficina 602 Edificio El Escorial<br/>
                        Tel: 1-6014826 | 1-3819790<br/>
                        e-mail: contactenos@laspartes.com.co<br/>
                        Bogotá, Colombia
                    </td>
                    <td width="3%">
                    </td>
                    <td width="17%" valign="top">
                        <span style="color:#c60200;">ORDEN DE REMISIÓN</span>
                        <div style="color:white; background-color:#c60200; ">No.</div>
                        <span style="border:1px solid #c60200; ">' . str_pad($consecutivo, 4, '0', STR_PAD_LEFT) . '</span><br/>
                        <div style="color:white; background-color:#c60200; ">FECHA</div>
                        <span style="border:1px solid #c60200; ">' . $venta->fecha . '</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="border:5px solid #c60200;">
                            <br/>&nbsp;&nbsp;CLIENTE: ' . $venta->nombres . ' <br/>
                            &nbsp;&nbsp;CIUDAD: ' . $venta->lugar . '<br/>
                            &nbsp;&nbsp;DIRECCIÓN: ' . $venta->direccion . '<br/>
                            &nbsp;&nbsp;TELEFONO: ' . $venta->telefono . '<br/>
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
                    <th  width="20%" bgcolor="#c60200" style="color:white;">ITEM</th>
                    <th  width="9%" bgcolor="#c60200" style="color:white;">CANT.</th>
                    <th  width="60%" bgcolor="#c60200" style="color:white;">DESCRIPCIÓN</th>
                </tr>';
        $html .= '<tr style="font-size:90px;"><td> Orden de remisión <br/><br/>Taller responsable: ' . $venta->nombreEstablecimiento . '<br/>' . $venta->direccionestablecimiento . '<br/>' . $venta->telefonosEstablecimientos . '</td><td style="text-align:center;">1</td><td>' . $venta->descripcion . '</td></tr>';
        $html .='
                </table>';
        $this->pdf->writeHTML($html, true, false, true, false, '');



        $html = '<table cellpadding="0" cellspacing="0"border="0">
                    <tr>
                        <td width="70%">
                            <div style="border:5px solid #c60200;">
                                OBSERVACIONES<br/>
                                <br/>Esta orden de remisión aplica para el vehículo: ' . $venta->marca . ' ' . $venta->linea . '
                            </div>
                        </td>
                        <td width="3%">
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
        $destinatario->email = $venta->emailEstablecimientos;
        $destinatarios[] = $destinatario;
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

        $mensajeCorreo = 'A continuación puedes ver el resumen de tu orden de remisión:<br/><br/>
            Nombres: ' . $venta->nombres . '<br/>
            Email: ' . $venta->email . ' <br/>   
            Ciudad: ' . $venta->lugar . ' <br/>  
            Direccion: ' . $venta->direccion . ' <br/>  
            Telefono: ' . $venta->telefono . '<br/>
            Orden de remisión: ' . $venta->descripcion . ' <br/>';

        $filePath = 'resources/remisiones';
        $fileName = 'orden-de-remision-' . $consecutivo . '.pdf';
        $this->pdf->Output($filePath . '/' . $fileName, 'F');
        send_mail($destinatarios, "Orden de remisión a través de LasPartes.com", $mensajeCorreo, "", $fileName, $filePath . '/');

        //METODOS DE DROPBOX
        $DropboxPath = '/CARPETA MAESTRA/REMISIONES/'.date('Y').'/';
        $metadata = $this->dropbox->metadata($DropboxPath);
        if(!$metadata->is_dir)
            $this->dropbox->create_folder($DropboxPath);
        $addResponse = $this->dropbox->add($DropboxPath, $filePath.'/'.$fileName);
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