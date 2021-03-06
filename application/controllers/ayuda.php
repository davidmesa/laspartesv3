<?php

require_once 'laspartes_controller.php';

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/**
 * Clase que maneja la página principal
 */
class Ayuda extends Laspartes_Controller {

    /**
     * Constructor de la clase Inicio
     */
    function __construct() {
        parent::__construct(); 
    }

    /**
     * Muestra la página principal
     */
    function index($mensaje ='') {
        $this->load->helper('date');
        $this->load->model('usuario_model');
        setlocale(LC_ALL, 'es_ES');
        $sesion = $this->session->userdata('esta_registrado');
        if($sesion){
           $data['usuario'] = $this->usuario_model->dar_usuario($this->session->userdata('id_usuario'));
           $data['vehiculo'] = ($this->usuario_model->dar_vehiculos_usuario($this->session->userdata('id_usuario')));
        }
        
        $this->load->model('establecimiento_model');
        $data['numero_establecimientos'] = $this->establecimiento_model->dar_num_talleres();
        
        $this->load->model('vehiculo_model');
        $data['allvehiculos'] = $this->vehiculo_model->dar_vehiculos();
        $index = 0;
        foreach ($data['allvehiculos'] as $vehiculo) {
            $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
            $data['allvehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
            $index++;
        }
        if($mensaje != '')
                $data['confirmacion'] = $mensaje;
        $data['metaKeywords'] = 'asesoría mecánica,preguntas,talleres,autopartes,repuestos,cotizaciones,promociones,descuentos';
        $data['metaDescripcion'] = 'No pagues más por arreglar tu carro ¡Cotizamos lo que necesitas en nuestra red de más de 50 talleres aliados. Al final, tú escoges la mejor alternativa!';
        $data['titulo'] = 'Laspartes.com :: Ayuda para tu vehículo';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Ayuda</div>';
        $data['header_view'] = 'ayuda/header/ayuda_view';
        $data['navegacion_view'] = 'ninguno';
        $data['contenido_view'] = 'ayuda/ayuda_view';
        $this->load->view('template/template', $data);
    }
    
    
    /**
     * Envía la solicitud a tallerenlinea y al usuario 
     */
    function enviar_solicitud(){
       
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'solicitud_nombres',
                'label' => 'Nombres',
                'rules' => 'trim|required|xss_clean'
            )
            ,
            array(
                'field' => 'ciudad_registrarse',
                'label' => 'ciudad',
                'rules' => 'trim|required|xss_clean'
            )
            ,
            array(
                'field' => 'solicitud_email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|callback__no_existe_email|xss_clean'
            )
            ,
            array(
                'field' => 'vehiculo_id',
                'label' => 'marca y linea',
                'rules' => 'trim|xss_clean'
            )
            ,
            array(
                'field' => 'id_vehiculos',
                'label' => 'marca y linea',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'kilometraje',
                'label' => 'kilometraje',
                'rules' => 'trim|required|xss_clean|numeric'
            ),
            array(
                'field' => 'solicitud_mensaje',
                'label' => 'mensaje',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'modelo',
                'label' => 'modelo',
                'rules' => 'trim||required|xss_clean|numeric'
            ),
            array(
                'field' => 'ckbox_registrate_chkbox',
                'label' => 'de aceptar los términos y condiciones',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'telefono',
                'label' => 'teléfono de contacto',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
//            $this->load->helper('captcha');
            $this->load->model('vehiculo_model');
            $data['allvehiculos'] = $this->vehiculo_model->dar_vehiculos();
            $index = 0;
            foreach ($data['allvehiculos'] as $vehiculo) {
                $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
                $data['allvehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
                $index++;
            }
//            $config = array(
//                'img_path' => 'resources/images/captcha/',
//                'img_url' => base_url() . 'resources/images/captcha/',
//                'length' => 4
//            );
//            $data['captcha'] = create_captcha($config);
//            $this->usuario_model->agregar_captcha(round($data['captcha']['time']), $this->input->ip_address(), $data['captcha']['word']);
            $this->index(validation_errors('<div class="mensaje-error">', '</div>')); 
//            $this->formulario_olvido_contrasena('<div class="mensaje-error">Los datos ingresados son incorrectos.</div>'); 
        } else {

            $this->load->model('usuario_model');
            $this->load->model('vehiculo_model');
            $data['nombre'] = $this->input->post('solicitud_nombres', TRUE);
            $data['ciudad'] = $this->input->post('ciudad_registrarse', TRUE);
            $data['email'] = $this->input->post('solicitud_email', TRUE);
            $data['vehiculo_id'] = $this->input->post('vehiculo_id', TRUE);
            $data['kilometraje'] = $this->input->post('kilometraje', TRUE);
            $data['solicitud_mensaje'] = $this->input->post('solicitud_mensaje', TRUE);
            $data['modelo'] = $this->input->post('modelo', TRUE);
            $data['telefono'] = $this->input->post('telefono', TRUE);

            $this->load->helper('mail');
            if($this->vehiculo_model->existe_vehiculo($data['vehiculo_id'])){
                $data['vehiculo'] = $this->vehiculo_model->dar_vehiculo($data['vehiculo_id']);
            }else{
                $vehiculo->marca = $this->input->post('id_vehiculos', TRUE);
                $data['vehiculo'] = $vehiculo;
            }
            
                ob_start();
                $this->load->view('emails/solicitud_correo_view', $data);
                $contenidoHTML = ob_get_contents();
                ob_end_clean();
                ob_flush(); 
                $destinatario = new stdClass();
                $destinatario->email = $data['email']; 
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = 'tallerenlinea@laspartes.com.co';
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = 'ventas@laspartes.com.co';
                $destinatarios[] = $destinatario;
                send_mail($destinatarios, "[LasPartes.com] Gracias por enviar tu solicitud", $contenidoHTML, "", $fileName);


                //-----------CREAR PIPELINE-------------------
                $this->load->model('usuario_model');
                $usuarioOBJ = $this->usuario_model->dar_usuario_segun_mail($data['email']);
                if($usuarioOBJ)
                    $id_usuario = $usuarioOBJ->id_usuario;
                else{
                    list($usuario, $dominio) = split('@', $data['email']);
                    $existe = $this->usuario_model->existe_usuario($usuario);
                    if ($existe === true)
                        $usuario = $this->_generar_usuario($usuario);
                    $id_usuario = $this->usuario_model->agregar_usuario($data['nombre'], '', $usuario, $data['email'], '', $data['ciudad'], '30', 'CRM', 'Colombia', $data['telefono'], 'precreado');
                }
                 
                $params['name'] = 'Cotizacion de '.$data['nombre'].' para '.$data['vehiculo']->marca.' '.$data['vehiculo']->linea.' modelo: '.$data['modelo'];
                $params['description'] = 'Número de contacto: '.$data['telefono'].' --- Necesidad: '.$data['solicitud_mensaje'];
                $params['lead_source'] = 'ContactUS';
                $params['sales_stage'] = 'Proposal/Price Quote';
                $params['probability'] = '25';
                $params['vehiculo_c'] = $data['vehiculo']->marca.' '.$data['vehiculo']->linea.' modelo: '.$data['modelo'].' kilometraje: '.$data['kilometraje'];
                $params['assigned_user_id'] = '221ae831-3e81-7963-a8db-5194020c679b';
                $params['assigned_user_name'] = 'Felipe Pacheco';
                $params['next_step'] = 'Clasificarlo';
                $params['ciudad_origen_c'] = $data['ciudad'];
                // $params['fechallamada_c'] = '2013-05-25 22:00:00';
                // $params['date_closed'] = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+5, date("Y")));
                $params['contact_name_c'] = $data['nombre'];
                $this->crearPipeLineAyuda($params, $id_usuario);




                //---------------------
                $this->index('<div class="mensaje-informativo">Tu solicitud ha sido enviada</div>');
        } 
    }

    /**
     * Crea un pipeline basado en el formulario de pedir cotizacion
     * @param  array $params  
     * @param  int $id_usuario id del usuario precreado o existente
     */
    private function crearPipeLineAyuda($params, $id_usuario){
        
        $uID = $this->crm->dar_uID_REST($id_usuario);
        $params['contact_id_c'] = $uID;
        $params['contact_id'] = $uID;
        $this->crm->agregar_pipeline_REST($params);
    }

    /**
     * Genera un usuario aleatorio a partir del usuario dado
     * @param type $usuario
     */
    private function _generar_usuario($usuario) {
        $code = md5(uniqid(rand(), true));
        $code = substr($code, 0, 5);
        $this->load->model('usuario_model');
        $existe = $this->usuario_model->existe_usuario($usuario);
        if (!$existe)
            return $usuario;
        else
            return $this->_generar_usuario($usuario . $code);
    }

}