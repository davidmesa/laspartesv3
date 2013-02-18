<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja la sección de acerca: ¿Quiénes somos?, Ayuda, Términos y Condiciones, Contáctenos
 */
class Acerca extends Laspartes_Controller{

    /**
     * Constructor de la clase Acerca
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Muestra la sección de Ayuda
     */
    function ayuda(){
        $data['titulo'] = 'Ayuda';
        $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'acerca/ayuda">Ayuda</a>';
        $data['header_view'] = 'acerca/header/ayuda_view';
        $data['contenido_view'] = 'acerca/ayuda_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra la sección de Contáctenos
     */
    function contactenos($mensaje = ''){
        // Mostrar captcha
        $this->load->helper('captcha');
        $this->load->model('usuario_model');
 
        $config = array(
            'img_path' => 'resources/images/captcha/',
            'img_url' => base_url().'resources/images/captcha/'
            );
        $data['captcha'] = create_captcha($config);
        $this->usuario_model->agregar_captcha($data['captcha']['time'], $this->input->ip_address(), $data['captcha']['word']);

        $data['titulo'] = 'Contáctanos';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Contáctanos</div>';
        $data['header_view'] = 'acerca/header/contactenos_view';
        $data['contenido_view'] = 'acerca/contactenos_view';
        $data['navegacion_view'] = 'ninguno';
        if($mensaje != '')
            $data['confirmacion'] = $mensaje;
        $this->load->view('template/template', $data);
    }
    
    /**
     * Muestra la sección de Contáctenos
     */
    function contactenos_taller($mensaje = ''){
        // Mostrar captcha
        $this->load->helper('captcha');
        $this->load->model('usuario_model');
 
        $config = array(
            'img_path' => 'resources/images/captcha/',
            'img_url' => base_url().'resources/images/captcha/'
            );
        $data['captcha'] = create_captcha($config);
        $this->usuario_model->agregar_captcha($data['captcha']['time'], $this->input->ip_address(), $data['captcha']['word']);

        $data['titulo'] = 'Contáctenos';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Contáctenos</div>';
        $data['header_view'] = 'acerca/header/contactenos_view';
        $data['contenido_view'] = 'acerca/contactenos_taller_view';
        $data['navegacion_view'] = 'ninguno';
        if($mensaje != '')
            $data['confirmacion'] = $mensaje;
        $this->load->view('template/template', $data);
    }

    /**
     * Verifica la palabra del captcha
     * @param String $palabra
     * @return boolean $es_correcto true si está bien la palabra
     */
    function _verificar_captcha($palabra){
        $this->load->model('usuario_model');
        $this->usuario_model->eliminar_captchas();
        $es_correcto = $this->usuario_model->verificar_captcha($palabra);
        if($es_correcto)
            return TRUE;
        else{
            $this->form_validation->set_message('_verificar_captcha', 'El código de verificación es inválido.');
            return FALSE;
        }
    }

    /**
     * Recibe los datos de contacto y construye el correo correspondiente
     */
    function contacto() {
        $this->load->library('form_validation');

        $reglas = array(
            array(
                'field' => 'email_contactenos',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'captcha_contactenos',
                'label' => 'captcha',
                'rules' => 'trim|required|callback__verificar_captcha|xss_clean'
            ),
            array(
                'field' => 'nombre_contactenos',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'comentarios_contactenos',
                'label' => 'comentarios',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if(!$this->form_validation->run()){
            $this->form_validation->set_error_delimiters('', '');
                $err[] = form_error('email_contactenos', '', '');
                $err[] = form_error('nombre_contactenos', '', '');
                $err[] = form_error('comentarios_contactenos', '', '');
                $err[] = form_error('captcha_contactenos', '', '');
                $mensaje = '';
                foreach ($err as $value) {
                    if($value != '')
                        $mensaje .= '<div class="mensaje-error">'.$value.'</div>'; 
                }
                $this->contactenos($mensaje);
        }
                
        else{
            $email = strtolower($this->input->post('email_contactenos', TRUE));
            $nombre = $this->input->post('nombre_contactenos', TRUE);
            $razon = $this->input->post('razon_contactenos', TRUE);
            $comentarios = $this->input->post('comentarios_contactenos', TRUE);

            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
            $this->email->to($email);
            $this->email->bcc('contactenos@laspartes.com.co');
            $this->email->bcc('tallerenlinea@laspartes.com.co');
            $this->email->subject('[LasPartes.com.co] Contacto desde la página');
            $this->email->message('
                Gracias por contactarnos. A continuación los datos de contacto que usted proporcionó:<br />
                <br />
                Nombre: '.$nombre.'<br />
                Email: '.$email.'<br />
                Razón de contacto: '.$razon.'<br />
                Comentarios: '.$comentarios.'<br />
                <br />
                Según sea el caso, en breve nos comunicaremos con usted.<br /><br />
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
            ');
            $this->email->send();

            // Mostrar que se envió el mail satisfactoriamente
            $this->contactenos ('<div class="mensaje-ok">Gracias por tu mensaje. Esperamos poder responderte a la brevedad.</div>');
        }
    }
    
    

    /**
     * Muestra la sección de ¿Quiénes somos?
     */
    function index(){
        $this->quienes_somos();
    }

    
    /**
     * Muestra la sección de ¿Quiénes somos?
     */
    function prensa(){
        $this->load->model('noticia_model');
        $data['noticias'] = $this->noticia_model->dar_noticias_ultimas(5);
        
        $data['metaDescripcion'] = "Por otro lado, laspartes.com presentará una web diseñada para ayudar a los usuarios en el mantenimiento y reparación de vehículos. Es un site que funciona como taller en línea, en donde...";
        $data['metaImagen'] = 'resources/images/acerca/portafolio.png';
        $data['titulo'] = 'Laspartes.com :: Prensa';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>PRENSA</div>';
        $data['header_view'] = 'acerca/header/prensa_view';
        $data['navegacion_view'] = 'ninguno';
        $data['contenido_view'] = 'acerca/prensa_view';
        $this->load->view('template/template', $data);
    }
    
    /**
     * Muestra la sección de ¿Quiénes somos?
     */
    function que_es_laspartes(){
        $data['titulo'] = '¿Qué es laspartes.com?';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>¿Qué es laspartes.com?</div>';
        $data['header_view'] = 'acerca/header/quienes_somos_view';
        $data['navegacion_view'] = 'ninguno';
        $data['contenido_view'] = 'acerca/quienes_somos_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra la sección de Términos y Condiciones
     */
    function terminos_condiciones(){
        $data['titulo'] = 'Términos y Condiciones';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Términos y Condiciones</div>';
        $data['header_view'] = 'acerca/header/terminos_condiciones_view';
        $data['navegacion_view'] = 'ninguno';
        $data['contenido_view'] = 'acerca/terminos_condiciones_view';

        $this->load->view('template/template', $data);
    }
}