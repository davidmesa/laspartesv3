<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja la sección de aprende: Noticias, tutoriales y tips y consejos
 */
class Aprende extends Laspartes_Controller{

    /**
     * Constructor de la clase Aprende
     */
    function __construct(){
        setlocale(LC_ALL, 'es_ES');
        parent::__construct();
    }

    /**
     * Da los datos necesarios para mostrar el home
     * @return array $data
     */
    function _home(){
        $this->load->model('noticia_model');
        $this->load->model('tip_model');
        $this->load->model('tutorial_model');
        $this->load->model('indicador_model');
        $data['noticias'] = $this->noticia_model->dar_noticias_ultimas(3);
        $data['numNoticias'] = $this->noticia_model->dar_numNoticias();
        $data['tips'] = $this->tip_model->dar_tips_ultimos(5);
        $data['numTips'] = $this->tip_model->dar_numTips();
        return $data;
    }

    /**
     * Da los datos de una noticia
     * @param int $id_noticia
     * @return array con $noticia, $noticias y $comentarios
     */
    function _ver_noticia($id_noticia){
        $this->load->model('noticia_model');
        $this->noticia_model->actualizar_numero_visitas($id_noticia);
        $data['noticia'] = $this->noticia_model->dar_noticia($id_noticia);
        $data['noticias'] = $this->noticia_model->dar_noticias_ultimas(5, $id_noticia);
        $data['comentarios'] = $this->noticia_model->dar_noticia_comentarios($id_noticia);
        $data['usuario_le_gusta'] = NULL;
        if($this->session->userdata('esta_registrado'))
            $data['usuario_le_gusta'] = $this->noticia_model->dar_noticia_le_gusta_usuario($id_noticia, $this->session->userdata('id_usuario'));
        return $data;
    }

    /**
     * Muestra las noticias de acuerdo a la paginación y filtros
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @return array $noticias
     */
    function _ver_noticias($limit, $offset, $orden){
        $this->load->model('noticia_model');
        $this->load->library('pagination');
        $numero_noticias = $this->noticia_model->contar_noticias();
        $config = array(
            'base_url' => base_url().'/aprende/noticias/'.$orden.'/'.$limit,
            'total_rows' => $numero_noticias,
            'per_page' => $limit,
            'num_links' => 1,
            'uri_segment' => 5,
            'first_link' => '[Primera]',
            'last_link' => '[Última]',
            'next_link' => '[Siguiente]',
            'prev_link' => '[Anterior]'
        );
        $this->pagination->initialize($config);
        $data['noticias'] = $this->noticia_model->dar_noticias_paginacion_filtros($limit, $offset, $orden);
        return $data;
    }

    /**
     * Da los datos de un tip
     * @param int $id_tip
     * @return array con $tip, $tips y $comentarios
     */
    function _ver_tip($id_tip){
        $this->load->model('tip_model');
        $this->tip_model->actualizar_numero_visitas($id_tip);
        $data['tip'] = $this->tip_model->dar_tip($id_tip);
        $data['tips'] = $this->tip_model->dar_tips_ultimos(5, $id_tip);
        $data['comentarios'] = $this->tip_model->dar_tip_comentarios($id_tip);
        $data['usuario_le_gusta'] = NULL;
        if($this->session->userdata('esta_registrado'))
            $data['usuario_le_gusta'] = $this->tip_model->dar_tip_le_gusta_usuario($id_tip, $this->session->userdata('id_usuario'));
        return $data;
    }

    /**
     * Muestra los tips de acuerdo a la paginación y filtros
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @return array $tips
     */
    function _ver_tips($limit, $offset, $orden){
        $this->load->model('tip_model');
        $this->load->library('pagination');
        $numero_tips = $this->tip_model->contar_tips();
        $config = array(
            'base_url' => base_url().'/aprende/tips/'.$orden.'/'.$limit,
            'total_rows' => $numero_tips,
            'per_page' => $limit,
            'num_links' => 1,
            'uri_segment' => 5,
            'first_link' => '[Primera]',
            'last_link' => '[Última]',
            'next_link' => '[Siguiente]',
            'prev_link' => '[Anterior]'
        );
        $this->pagination->initialize($config);
        $data['tips'] = $this->tip_model->dar_tips_paginacion_filtros($limit, $offset, $orden);
        return $data;
    }

    /**
     * Da los datos de un tutorial
     * @param int $id_tutorial
     * @return array con $tutorial, $tutorial_pasos, $comentarios y $tutoriales
     */
    function _ver_tutorial($id_tutorial){
        $this->load->model('tutorial_model');
        $this->tutorial_model->actualizar_numero_visitas($id_tutorial);
        $data['tutorial'] = $this->tutorial_model->dar_tutorial($id_tutorial);
        $data['tutorial_pasos'] = $this->tutorial_model->dar_tutorial_pasos($id_tutorial);
        $data['tutoriales'] = $this->tutorial_model->dar_tutoriales_ultimos(5);
        $data['comentarios'] = $this->tutorial_model->dar_tutorial_comentarios($id_tutorial);
        $data['usuario_le_gusta'] = NULL;
        if($this->session->userdata('esta_registrado'))
            $data['usuario_le_gusta'] = $this->tutorial_model->dar_tutorial_le_gusta_usuario($id_tutorial, $this->session->userdata('id_usuario'));
        return $data;
    }

    /**
     * Muestra los tutoriales de acuerdo a la paginación y filtros
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @return array $tutoriales
     */
    function _ver_tutoriales($limit, $offset, $orden){
        $this->load->model('tutorial_model');
        $this->load->library('pagination');
        $numero_tutoriales = $this->tutorial_model->contar_tutoriales();
        $config = array(
            'base_url' => base_url().'/aprende/tutoriales/'.$orden.'/'.$limit,
            'total_rows' => $numero_tutoriales,
            'per_page' => $limit,
            'num_links' => 1,
            'uri_segment' => 5,
            'first_link' => '[Primera]',
            'last_link' => '[Última]',
            'next_link' => '[Siguiente]',
            'prev_link' => '[Anterior]'
        );
        $this->pagination->initialize($config);
        $data['tutoriales'] = $this->tutorial_model->dar_tutoriales_paginacion_filtros($limit, $offset, $orden);
        return $data;
    }

    /**
     * Agrega un nuevo comentario a una noticia
     */
    function agregar_noticia_comentario(){
        if(!$this->session->userdata('esta_registrado'))
        {
            $id_noticia = $this->input->post('id_noticia', TRUE);

            $data = $this->_ver_noticia($id_noticia);
            $data['titulo'] = 'Noticias';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
            $data['header_view'] = 'aprende/header/noticia_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/noticia_detalle_view';
            $data['error'] = 'Lo sentimos, debe iniciar su sesión como usuario registrado para realizar esta acción';
            $this->load->view('template/template', $data);
        }
        else
        {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_noticia',
                    'label' => 'identificador de la noticia',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'comentario',
                    'label' => 'comentario',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            $id_noticia = $this->input->post('id_noticia', TRUE);
            if(!$this->form_validation->run()){
                $data = $this->_ver_noticia($id_noticia);
                $data['titulo'] = 'Noticias';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
                $data['header_view'] = 'aprende/header/noticia_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/noticia_detalle_view';
                echo validation_errors();
                $this->load->view('template/template', $data);
            }
            else{
                $this->load->model('noticia_model');
                $comentario = $this->input->post('comentario', TRUE);
                $id_noticia_comentario = $this->noticia_model->agregar_noticia_comentario($id_noticia, $id_usuario, $comentario);

                $data = $this->_ver_noticia($id_noticia);

                // Enviar mail
                $this->load->library('email');
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
                $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
                $this->email->subject('[Las Partes] Comentario a noticia');
                $this->email->message('
                    Un usuario ha comentado la noticia '.$data['noticia']->nombre.':
                    <br /><br />
                    Id noticia: '.$id_noticia_comentario.'<br />
                    Noticia: '.$data['noticia']->titulo.'<br />
                    Comentario: '.$comentario.'<br />
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $data['scrollTo'] = 'comentario-'.$id_noticia_comentario;
                $data['titulo'] = 'Noticias';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
                $data['header_view'] = 'aprende/header/noticia_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/noticia_detalle_view';
                $this->load->view('template/template', $data);
            }
        }
    }

    /**
     * Agrega un nuevo comentario a una noticia
     * Inicia sesión
     */
    function agregar_noticia_comentario_ingresar(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email_ingresar',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'contrasena_ingresar',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_noticia_ingresar',
                'label' => 'identificador de la noticia',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'comentario_ingresar',
                'label' => 'comentario',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_noticia = $this->input->post('id_noticia_ingresar', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_noticia($id_noticia);
            $data['titulo'] = 'Noticias';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
            $data['header_view'] = 'aprende/header/noticia_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/noticia_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        }
        else{
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email_ingresar', TRUE));
            $contrasena = sha1($this->input->post('contrasena_ingresar', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);
            if(!$resultado){
                $data = $this->_ver_noticia($id_noticia);
                $data['titulo'] = 'Noticias';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
                $data['header_view'] = 'aprende/header/noticia_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/noticia_detalle_view';
                echo validation_errors();
                $this->load->view('template/template', $data);
            }
            else{
                $this->load->model('noticia_model');
                $id_usuario = $this->session->userdata('id_usuario');
                $comentario = $this->input->post('comentario_ingresar', TRUE);
                $id_noticia_comentario = $this->noticia_model->agregar_noticia_comentario($id_noticia, $id_usuario, $comentario);

                $data = $this->_ver_noticia($id_noticia);

                // Enviar mail
                $this->load->library('email');
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
                $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
                $this->email->subject('[Las Partes] Comentario a noticia');
                $this->email->message('
                    Un usuario ha comentado la noticia '.$data['noticia']->nombre.':
                    <br /><br />
                    Id noticia: '.$id_noticia_comentario.'<br />
                    Noticia: '.$data['noticia']->titulo.'<br />
                    Comentario: '.$comentario.'<br />
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $data['scrollTo'] = 'comentario-'.$id_noticia_comentario;
                $data['titulo'] = 'Noticias';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
                $data['header_view'] = 'aprende/header/noticia_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/noticia_detalle_view';
                $this->load->view('template/template', $data);
            }
        }
    }

    /**
     * Agrega un nuevo comentario a una noticia
     * Registra a un usuario e inicia sesión
     */
    function agregar_noticia_comentario_registrarse(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'nombre_registrarse',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'apellidos_registrarse',
                'label' => 'apellidos',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'ciudad_registrarse',
                'label' => 'ciudad',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'usuario_registrarse',
                'label' => 'usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email_registrarse',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|callback__no_existe_email|xss_clean'
            ),
            array(
                'field' => 'contrasena_registrarse',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_noticia_registrarse',
                'label' => 'identificador de la noticia',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'comentario_registrarse',
                'label' => 'comentario',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_noticia = $this->input->post('id_noticia_registrarse', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_noticia($id_noticia);
            $data['titulo'] = 'Noticias';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
            $data['header_view'] = 'aprende/header/noticia_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/noticia_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        }
        else{
            $this->load->model('usuario_model');
            $nombre = strtolower($this->input->post('nombre_registrarse', TRUE));
            $apellidos = strtolower($this->input->post('apellidos_registrarse', TRUE));
            $ciudad = strtolower($this->input->post('ciudad_registrarse', TRUE));
            $usuario = strtolower($this->input->post('usuario_registrarse', TRUE));
            $email = strtolower($this->input->post('email_registrarse', TRUE));
            $contrasena = sha1($this->input->post('contrasena_registrarse', TRUE));
            $id_usuario = $this->usuario_model->agregar_usuario($nombre, $apellidos, $usuario, $email, $contrasena, $ciudad, 30);

            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $usuario_sesion = array(
                'id_usuario' => $usuario->id_usuario,
                'tipo' => $usuario->tipo,
                'esta_registrado' => TRUE
            );
            $this->session->set_userdata($usuario_sesion);

            $this->load->model('noticia_model');
            $comentario = $this->input->post('comentario_registrarse', TRUE);
            $id_noticia_comentario = $this->noticia_model->agregar_noticia_comentario($id_noticia, $id_usuario, $comentario);

            $data = $this->_ver_noticia($id_noticia);

            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
            $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
            $this->email->subject('[Las Partes] Comentario a noticia');
            $this->email->message('
                Un usuario ha comentado la noticia '.$data['noticia']->nombre.':
                <br /><br />
                Id noticia: '.$id_noticia_comentario.'<br />
                Noticia: '.$data['noticia']->titulo.'<br />
                Comentario: '.$comentario.'<br />
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
            ');
            $this->email->send();

            $data['scrollTo'] = 'comentario-'.$id_noticia_comentario;
            $data['titulo'] = 'Noticias';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
            $data['header_view'] = 'aprende/header/noticia_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/noticia_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Agrega un nuevo comentario a un tip
     */
    function agregar_tip_comentario(){
        if(!$this->session->userdata('esta_registrado'))
        {
            $id_tip = $this->input->post('id_tip', TRUE);

            $data = $this->_ver_tip($id_tip);
            $data['titulo'] = 'Tips';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
            $data['header_view'] = 'aprende/header/tip_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tip_detalle_view';
            $data['error'] = 'Lo sentimos, debe iniciar su sesión como usuario registrado para realizar esta acción';
            $this->load->view('template/template', $data);
        }
        else
        {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_tip',
                    'label' => 'identificador del tip',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'comentario',
                    'label' => 'comentario',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            $id_tip = $this->input->post('id_tip', TRUE);
            if(!$this->form_validation->run()){
                $data = $this->_ver_tip($id_tip);
                $data['titulo'] = 'Tips';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
                $data['header_view'] = 'aprende/header/tip_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/tip_detalle_view';
                echo validation_errors();
                $this->load->view('template/template', $data);
            }
            else{
                $this->load->model('tip_model');
                $comentario = $this->input->post('comentario', TRUE);
                $id_tip_comentario = $this->tip_model->agregar_tip_comentario($id_tip, $id_usuario, $comentario);

                $data = $this->_ver_tip($id_tip);

                // Enviar mail
                $this->load->library('email');
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
                $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
                $this->email->subject('[Las Partes] Comentario a tip');
                $this->email->message('
                    Un usuario ha comentado un tip '.$data['tip']->nombre.':
                    <br /><br />
                    Id tip: '.$id_tip_comentario.'<br />
                    Tip: '.$data['tip']->titulo.'<br />
                    Comentario: '.$comentario.'<br />
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $data['scrollTo'] = 'comentario-'.$id_tip_comentario;
                $data['titulo'] = 'Tips';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
                $data['header_view'] = 'aprende/header/tip_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/tip_detalle_view';
                $this->load->view('template/template', $data);
            }
        }
    }

    /**
     * Agrega un nuevo comentario a un tip
     * Inicia sesión
     */
    function agregar_tip_comentario_ingresar(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email_ingresar',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'contrasena_ingresar',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_tip_ingresar',
                'label' => 'identificador del tip',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'comentario_ingresar',
                'label' => 'comentario',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tip= $this->input->post('id_tip_ingresar', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_tip($id_tip);
            $data['titulo'] = 'Tips';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
            $data['header_view'] = 'aprende/header/tip_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tip_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        }
        else{
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email_ingresar', TRUE));
            $contrasena = sha1($this->input->post('contrasena_ingresar', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);
            if(!$resultado){
                $data = $this->_ver_tip($id_tip);
                $data['titulo'] = 'Tips';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
                $data['header_view'] = 'aprende/header/tip_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/tip_detalle_view';
                echo validation_errors();
                $this->load->view('template/template', $data);
            }
            else{
                $this->load->model('tip_model');
                $id_usuario = $this->session->userdata('id_usuario');
                $comentario = $this->input->post('comentario_ingresar', TRUE);
                $id_tip_comentario = $this->tip_model->agregar_tip_comentario($id_tip, $id_usuario, $comentario);

                $data = $this->_ver_tip($id_tip);

                // Enviar mail
                $this->load->library('email');
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
                $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
                $this->email->subject('[Las Partes] Comentario a tip');
                $this->email->message('
                    Un usuario ha comentado un tip '.$data['tip']->nombre.':
                    <br /><br />
                    Id tip: '.$id_tip_comentario.'<br />
                    Tip: '.$data['tip']->titulo.'<br />
                    Comentario: '.$comentario.'<br />
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $data['scrollTo'] = 'comentario-'.$id_tip_comentario;
                $data['titulo'] = 'Tips';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
                $data['header_view'] = 'aprende/header/tip_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/tip_detalle_view';
                $this->load->view('template/template', $data);
            }
        }
    }

    /**
     * Agrega un nuevo comentario a un tip
     * Registra a un usuario e inicia sesión
     */
    function agregar_tip_comentario_registrarse(){
        $this->load->library('form_validation');
        $reglas = array(
        	array(
                'field' => 'nombre_registrarse',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'apellidos_registrarse',
                'label' => 'apellidos',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'ciudad_registrarse',
                'label' => 'ciudad',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'usuario_registrarse',
                'label' => 'usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email_registrarse',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|callback__no_existe_email|xss_clean'
            ),
            array(
                'field' => 'contrasena_registrarse',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_tip_registrarse',
                'label' => 'identificador de la noticia',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'comentario_registrarse',
                'label' => 'comentario',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tip = $this->input->post('id_tip_registrarse', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_tip($id_tip);
            $data['titulo'] = 'Tips';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
            $data['header_view'] = 'aprende/header/tip_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tip_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        }
        else{
            $this->load->model('usuario_model');
            $nombre = strtolower($this->input->post('nombre_registrarse', TRUE));
            $apellidos = strtolower($this->input->post('apellidos_registrarse', TRUE));
            $ciudad = strtolower($this->input->post('ciudad_registrarse', TRUE));
            $usuario = strtolower($this->input->post('usuario_registrarse', TRUE));
            $email = strtolower($this->input->post('email_registrarse', TRUE));
            $contrasena = sha1($this->input->post('contrasena_registrarse', TRUE));
            $id_usuario = $this->usuario_model->agregar_usuario($nombre, $apellidos, $usuario, $email, $contrasena, $ciudad, 30);

            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $usuario_sesion = array(
                'id_usuario' => $usuario->id_usuario,
                'tipo' => $usuario->tipo,
                'esta_registrado' => TRUE
            );
            $this->session->set_userdata($usuario_sesion);

            $this->load->model('tip_model');
            $comentario = $this->input->post('comentario_registrarse', TRUE);
            $id_tip_comentario = $this->tip_model->agregar_tip_comentario($id_tip, $id_usuario, $comentario);

            $data = $this->_ver_tip($id_tip);

            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
            $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
            $this->email->subject('[Las Partes] Comentario a tip');
            $this->email->message('
                Un usuario ha comentado un tip '.$data['tip']->nombre.':
                <br /><br />
                Id tip: '.$id_tip_comentario.'<br />
                Tip: '.$data['tip']->titulo.'<br />
                Comentario: '.$comentario.'<br />
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
            ');
            $this->email->send();

            $data['scrollTo'] = 'comentario-'.$id_tip_comentario;
            $data['titulo'] = 'Tips';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
            $data['header_view'] = 'aprende/header/tip_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tip_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Agrega un nuevo comentario a un tutorial
     */
    function agregar_tutorial_comentario(){
        if(!$this->session->userdata('esta_registrado'))
        {
            $id_tutorial = $this->input->post('id_tutorial', TRUE);

            $data = $this->_ver_tutorial($id_tutorial);
            $data['titulo'] = 'Tutoriales';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tutoriales</a> :: '.$data['tutorial']->titulo;
            $data['header_view'] = 'aprende/header/tutorial_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tutorial_detalle_view';
            $data['error'] = 'Lo sentimos, debe iniciar su sesión como usuario registrado para realizar esta acción';
            $this->load->view('template/template', $data);
        }
        else
        {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_tutorial',
                    'label' => 'identificador del tutorial',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'comentario',
                    'label' => 'comentario',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            $id_tutorial = $this->input->post('id_tutorial', TRUE);
            if(!$this->form_validation->run()){
                $data = $this->_ver_tutorial($id_tutorial);
                $data['titulo'] = 'Tutoriales';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
                $data['header_view'] = 'aprende/header/tutorial_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/tutorial_detalle_view';
                echo validation_errors();
                $this->load->view('template/template', $data);
            }
            else{
                $this->load->model('tutorial_model');
                $comentario = $this->input->post('comentario', TRUE);
                $id_tutorial_comentario = $this->tutorial_model->agregar_tutorial_comentario($id_tutorial, $id_usuario, $comentario);

                $data = $this->_ver_tutorial($id_tutorial);

                // Enviar mail
                $this->load->library('email');
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
                $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
                $this->email->subject('[Las Partes] Comentario a tutorial');
                $this->email->message('
                    Un usuario ha comentado un tutorial '.$data['tutorial']->nombre.':
                    <br /><br />
                    Id tutorial: '.$id_tutorial_comentario.'<br />
                    Tutorial: '.$data['tutorial']->titulo.'<br />
                    Comentario: '.$comentario.'<br />
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $data['scrollTo'] = 'comentario-'.$id_tutorial_comentario;
                $data['titulo'] = 'Tutoriales';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
                $data['header_view'] = 'aprende/header/tutorial_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/tutorial_detalle_view';
                $this->load->view('template/template', $data);
            }
        }
    }

    /**
     * Agrega un nuevo comentario a un tutorial
     * Inicia sesión
     */
    function agregar_tutorial_comentario_ingresar(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email_ingresar',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'contrasena_ingresar',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_tutorial_ingresar',
                'label' => 'identificador del tutorial',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'comentario_ingresar',
                'label' => 'comentario',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tutorial = $this->input->post('id_tutorial_ingresar', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_tutorial($id_tutorial);
            $data['titulo'] = 'Tutoriales';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
            $data['header_view'] = 'aprende/header/tutorial_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tutorial_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        }
        else{
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email_ingresar', TRUE));
            $contrasena = sha1($this->input->post('contrasena_ingresar', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);
            if(!$resultado){
                $data = $this->_ver_tutorial($id_tutorial);
                $data['titulo'] = 'Tutoriales';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
                $data['header_view'] = 'aprende/header/tutorial_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/tutorial_detalle_view';
                echo validation_errors();
                $this->load->view('template/template', $data);
            }
            else{
                $this->load->model('tutorial_model');
                $id_usuario = $this->session->userdata('id_usuario');
                $comentario = $this->input->post('comentario_ingresar', TRUE);
                $id_tutorial_comentario = $this->tutorial_model->agregar_tutorial_comentario($id_tutorial, $id_usuario, $comentario);

                $data = $this->_ver_tutorial($id_tutorial);

                // Enviar mail
                $this->load->library('email');
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
                $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
                $this->email->subject('[Las Partes] Comentario a tutorial');
                $this->email->message('
                    Un usuario ha comentado un tutorial '.$data['tutorial']->nombre.':
                    <br /><br />
                    Id tutorial: '.$id_tutorial_comentario.'<br />
                    Tutorial: '.$data['tutorial']->titulo.'<br />
                    Comentario: '.$comentario.'<br />
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $data['scrollTo'] = 'comentario-'.$id_tutorial_comentario;
                $data['titulo'] = 'Tutoriales';
                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
                $data['header_view'] = 'aprende/header/tutorial_detalle_view';
                $data['navegacion_view'] = 'aprende';
                $data['contenido_view'] = 'aprende/tutorial_detalle_view';
                $this->load->view('template/template', $data);
            }
        }
    }

    /**
     * Agrega un nuevo comentario a un tutorial
     * Registra a un usuario e inicia sesión
     */
    function agregar_tutorial_comentario_registrarse(){
        $this->load->library('form_validation');
        $reglas = array(
        	array(
                'field' => 'nombre_registrarse',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'apellidos_registrarse',
                'label' => 'apellidos',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'ciudad_registrarse',
                'label' => 'ciudad',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'usuario_registrarse',
                'label' => 'usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email_registrarse',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|callback__no_existe_email|xss_clean'
            ),
            array(
                'field' => 'contrasena_registrarse',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_tutorial_registrarse',
                'label' => 'identificador del tutorial',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'comentario_registrarse',
                'label' => 'comentario',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tutorial = $this->input->post('id_tutorial_registrarse', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_tutorial($id_tutorial);
            $data['titulo'] = 'Tutoriales';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
            $data['header_view'] = 'aprende/header/tutorial_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tutorial_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        }
        else{
            $this->load->model('usuario_model');
            $nombre = strtolower($this->input->post('nombre_registrarse', TRUE));
            $apellidos = strtolower($this->input->post('apellidos_registrarse', TRUE));
            $ciudad = strtolower($this->input->post('ciudad_registrarse', TRUE));
            $usuario = strtolower($this->input->post('usuario_registrarse', TRUE));
            $email = strtolower($this->input->post('email_registrarse', TRUE));
            $contrasena = sha1($this->input->post('contrasena_registrarse', TRUE));
            $id_usuario = $this->usuario_model->agregar_usuario($nombre, $apellidos, $usuario, $email, $contrasena, $ciudad, 30);

            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $usuario_sesion = array(
                'id_usuario' => $usuario->id_usuario,
                'tipo' => $usuario->tipo,
                'esta_registrado' => TRUE
            );
            $this->session->set_userdata($usuario_sesion);

            $this->load->model('tutorial_model');
            $comentario = $this->input->post('comentario_registrarse', TRUE);
            $id_tutorial_comentario = $this->tutorial_model->agregar_tutorial_comentario($id_tutorial, $id_usuario, $comentario);

            $data = $this->_ver_tutorial($id_tutorial);

            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
            $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
            $this->email->subject('[Las Partes] Comentario a tutorial');
            $this->email->message('
                Un usuario ha comentado un tutorial '.$data['tutorial']->nombre.':
                <br /><br />
                Id tutorial: '.$id_tutorial_comentario.'<br />
                Tutorial: '.$data['tutorial']->titulo.'<br />
                Comentario: '.$comentario.'<br />
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
            ');
            $this->email->send();

            $data['scrollTo'] = 'comentario-'.$id_tutorial_comentario;
            $data['titulo'] = 'Tutoriales';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
            $data['header_view'] = 'aprende/header/tutorial_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tutorial_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Agrega un nuevo me gusta a una noticia
     */
    function agregar_noticia_me_gusta_ajax(){
        if($this->session->userdata('esta_registrado')) {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_noticia',
                    'label' => 'identificador de la noticia',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'me_gusta',
                    'label' => 'me gusta',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if($this->form_validation->run()){
                $this->load->model('noticia_model');
                $id_noticia = $this->input->post('id_noticia', TRUE);
                $me_gusta = $this->input->post('me_gusta', TRUE);
                $this->noticia_model->agregar_me_gusta($id_usuario, $id_noticia, $me_gusta);

                if($me_gusta==1)
                    $this->noticia_model->actualizar_noticia_me_gusta($id_noticia);
                else
                    $this->noticia_model->actualizar_noticia_no_me_gusta($id_noticia);
            }
        }
    }

    /**
     * Agrega un nuevo me gusta a un tip
     */
    function agregar_tip_me_gusta_ajax(){
        if($this->session->userdata('esta_registrado')) {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_tip',
                    'label' => 'identificador del tip',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'me_gusta',
                    'label' => 'me gusta',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if($this->form_validation->run()){
                $this->load->model('tip_model');
                $id_tip = $this->input->post('id_tip', TRUE);
                $me_gusta = $this->input->post('me_gusta', TRUE);
                $this->tip_model->agregar_me_gusta($id_usuario, $id_tip, $me_gusta);

                if($me_gusta==1)
                    $this->tip_model->actualizar_tip_me_gusta($id_tip);
                else
                    $this->tip_model->actualizar_tip_no_me_gusta($id_tip);
            }
        }
    }

    /**
     * Agrega un nuevo me gusta a un tutorial
     */
    function agregar_tutorial_me_gusta_ajax(){
        if($this->session->userdata('esta_registrado')) {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_tutorial',
                    'label' => 'identificador del tutorial',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'me_gusta',
                    'label' => 'me gusta',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if($this->form_validation->run()){
                $this->load->model('tutorial_model');
                $id_tutorial = $this->input->post('id_tutorial', TRUE);
                $me_gusta = $this->input->post('me_gusta', TRUE);
                $this->tutorial_model->agregar_me_gusta($id_usuario, $id_tutorial, $me_gusta);

                if($me_gusta==1)
                    $this->tutorial_model->actualizar_tutorial_me_gusta($id_tutorial);
                else
                    $this->tutorial_model->actualizar_tutorial_no_me_gusta($id_tutorial);
            }
        }
    }

    /**
     * Muestra la página de inicio
     */
    function index(){
        $data = $this->_home();
        $data['metaKeywords'] = 'autopartes,repuestos,noticias,novedades,actualidad,tips,consejos,tutoriales,mantenimiento,mundo automotriz';
        $data['metaDescripcion'] = 'Conoce más sobre tu carro! Las últimas tendencias y los mejores consejos para que estés al día';
        $data['metaImagen'] = 'resources/images/home/noticias/baner-novedades.png';
        $data['titulo'] = 'Laspartes.com :: Aprende sobre tu carro';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Aprende</div>';
        $data['header_view'] = 'aprende/header/aprende_home_view';
        $data['navegacion_view'] = 'aprende';
        $data['contenido_view'] = 'aprende/aprende_home_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Envia un mail al administrador para publicar un tip
     */
    function publicar_tip(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_tip_publicar_tip',
                'label' => 'identificador del tip',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email_publicar_tip',
                'label' => 'correo electrónico',
                'rules' => 'trim|email|required|xss_clean'
            ),
            array(
                'field' => 'tip_publicar_tip',
                'label' => 'tip',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tip = $this->input->post('id_tip_publicar_tip', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_tip($id_tip);
            $data['titulo'] = 'Tips';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
            $data['header_view'] = 'aprende/header/tip_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tip_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        }
        else{
            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co - Aprende');
            $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
            $this->email->bcc($this->input->post('email_publicar_tip', TRUE));
            $this->email->subject('[Las Partes] [Publicar Tip]');

            $this->email->message('
                Muchas gracias por participar en nuestra comunidad.<br />
                <br />
                A continuación su sugerencia para la sección Tips:
                <br />
                <br />
                '.$this->input->post('tip_publicar_tip', TRUE).'
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
            ');

            $this->email->send();

            $data = $this->_ver_tip($id_tip);
            $data['titulo'] = 'Tips';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tips">Tips</a> :: '.$data['tip']->titulo;
            $data['header_view'] = 'aprende/header/tip_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tip_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Envia un mail al administrador para publicar un tutorial
     */
    function publicar_tutorial(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_tutorial_publicar_tutorial',
                'label' => 'identificador del tutorial',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email_publicar_tutorial',
                'label' => 'correo electrónico',
                'rules' => 'trim|email|required|xss_clean'
            ),
            array(
                'field' => 'tutorial_publicar_tutorial',
                'label' => 'tutorial',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tutorial = $this->input->post('id_tutorial_publicar_tutorial', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_tutorial($id_tutorial);
            $data['titulo'] = 'Tutoriales';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
            $data['header_view'] = 'aprende/header/tutorial_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tutorial_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        }
        else{
            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co - Aprende');
            $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
            $this->email->bcc($this->input->post('email_publicar_tutorial', TRUE));
            $this->email->subject('[Las Partes] [Publicar Tip]');

            $this->email->message('
                Muchas gracias por participar en nuestra comunidad.<br />
                <br />
                A continuación su sugerencia para la sección Tips:
                <br />
                <br />
                '.$this->input->post('tutorial_publicar_tutorial', TRUE).'
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
            ');

            $this->email->send();

            $data = $this->_ver_tutorial($id_tutorial);
            $data['titulo'] = 'Tutoriales';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
            $data['header_view'] = 'aprende/header/tutorial_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tutorial_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Envia un mail al administrador para publicar una noticia
     */
    function publicar_noticia(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_noticia_publicar_noticia',
                'label' => 'identificador de la noticia',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email_publicar_noticia',
                'label' => 'correo electrónico',
                'rules' => 'trim|email|required|xss_clean'
            ),
            array(
                'field' => 'noticia_publicar_noticia',
                'label' => 'noticia',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_noticia = $this->input->post('id_noticia_publicar_noticia', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_noticia($id_noticia);
            $data['titulo'] = 'Noticias';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
            $data['header_view'] = 'aprende/header/noticia_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/noticia_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        }
        else{
            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co - Aprende');
            $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
            $this->email->bcc($this->input->post('email_publicar_noticia', TRUE));
            $this->email->subject('[Las Partes] [Publicar Tip]');

            $this->email->message('
                Muchas gracias por participar en nuestra comunidad.<br />
                <br />
                A continuación su sugerencia para la sección Tips:
                <br />
                <br />
                '.$this->input->post('noticia_publicar_noticia', TRUE).'
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="'.base_url().'">Laspartes.com.co</a> - Todo para su vehículo
            ');

            $this->email->send();

            $data = $this->_ver_noticia($id_noticia);
            $data['titulo'] = 'Noticias';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/noticias">Noticias</a> :: '.$data['noticia']->titulo;
            $data['header_view'] = 'aprende/header/noticia_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/noticia_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Muestra una noticia
     */
    function noticia($id_noticia){
//        $id_noticia = $this->uri->segment(3);
        $data = $this->_ver_noticia($id_noticia);
        if(sizeof($data['noticia'])==0 || $data['noticia']->estado=='No Activo'){
            $data['titulo'] = 'Página no Encontrada';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="' . base_url() . 'aprende">Aprende</a></div> <div class="div-breadcrumb-espaciador"></div><div>Página no encontrada - Lo sentimos</div>';
            $data['header_view'] = 'error/404/header/404_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'error/404/404_view';
            $this->load->view('template/template', $data);
        }
        else{
            $data['metaKeywords'] = 'autopartes,repuestos,noticias,novedades,actualidad,tips,consejos,tutoriales,mantenimiento,mundo automotriz';
            $data['metaDescripcion'] = strip_tags(character_limiter($data['noticia']->noticia, 150));
            $data['metaImagen'] = $data['noticia']->imagen_url;
            $data['titulo'] = $data['noticia']->titulo;
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="'.base_url().'aprende">Aprende</a></div><div class="div-breadcrumb-espaciador"></div><div>'.substr($data['titulo'],0,50).'...</div>';
            $data['header_view'] = 'aprende/header/noticia_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/noticia_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Muestra el listado de noticias de acuerdo a los filtros
     */
    function noticias(){
        $this->load->helper('text');
        $orden = $this->uri->segment(3, 'fecha');
        $limit = $this->uri->segment(4, 10);
        $offset = $this->uri->segment(5, 0);

        $data = $this->_ver_noticias($limit, $offset, $orden);
        $data['orden'] = $orden;
        $data['limit'] = $limit;
        $data['titulo'] = 'Listado de noticias';
        $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: Noticias';
        $data['header_view'] = 'aprende/header/aprende_lista_view';
        $data['navegacion_view'] = 'aprende';
        $data['tab'] = 'noticias';
        $data['contenido_view'] = 'aprende/aprende_lista_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra un tip
     */
    function tip($id_tip){
//        $id_tip = $this->uri->segment(3);
        $data = $this->_ver_tip($id_tip);
        if(sizeof($data['tip'])==0 || $data['tip']->estado=='No Activo'){
            $data['titulo'] = 'Página no Encontrada';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: Página no encontrada - Lo sentimos';
            $data['header_view'] = 'error/404/header/404_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'error/404/404_view';
            $this->load->view('template/template', $data);
        }
        else{
            $data['metaKeywords'] = 'autopartes,repuestos,noticias,novedades,actualidad,tips,consejos,tutoriales,mantenimiento,mundo automotriz';
            $data['metaDescripcion'] = strip_tags(character_limiter($data['tip']->tip, 150));
            $data['metaImagen'] = $data['tip']->imagen_url;
            $data['titulo'] = $data['tip']->titulo;
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="'.base_url().'aprende">Aprende</a></div><div class="div-breadcrumb-espaciador"></div><div>'.substr($data['tip']->titulo,0,50).'...</div>';
            $data['header_view'] = 'aprende/header/tip_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tip_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Muestra el listado de tips de acuerdo a los filtros
     */
    function tips(){
        $this->load->helper('text');
        $orden = $this->uri->segment(3, 'fecha');
        $limit = $this->uri->segment(4, 10);
        $offset = $this->uri->segment(5, 0);

        $data = $this->_ver_tips($limit, $offset, $orden);
        $data['orden'] = $orden;
        $data['limit'] = $limit;
        $data['titulo'] = 'Listado de tips y consejos';
        $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: Tips y Consejos';
        $data['header_view'] = 'aprende/header/aprende_lista_view';
        $data['navegacion_view'] = 'aprende';
        $data['tab'] = 'tips';
        $data['contenido_view'] = 'aprende/aprende_lista_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra un tutorial
     */
    function tutorial(){
        $id_tutorial = $this->uri->segment(3);
        $data = $this->_ver_tutorial($id_tutorial);
        if(sizeof($data['tutorial'])==0 || $data['tutorial']->estado=='No Activo'){
            $data['titulo'] = 'Página no Encontrada';
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: Página no encontrada - Lo sentimos';
            $data['header_view'] = 'error/404/header/404_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'error/404/404_view';
            $this->load->view('template/template', $data);
        }
        else{
            $data['titulo'] = $data['tutorial']->titulo;
            $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: <a href="'.base_url().'aprende/tutoriales">Tutoriales</a> :: '.$data['tutorial']->titulo;
            $data['header_view'] = 'aprende/header/tutorial_detalle_view';
            $data['navegacion_view'] = 'aprende';
            $data['contenido_view'] = 'aprende/tutorial_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Muestra el listado de tutoriales de acuerdo a los filtros
     */
    function tutoriales(){
        $this->load->helper('text');
        $orden = $this->uri->segment(3, 'fecha');
        $limit = $this->uri->segment(4, 10);
        $offset = $this->uri->segment(5, 0);

        $data = $this->_ver_tutoriales($limit, $offset, $orden);
        $data['orden'] = $orden;
        $data['limit'] = $limit;
        $data['titulo'] = 'Listado de tutoriales';
        $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'aprende">Aprende</a> :: Hágalo usted mismo';
        $data['header_view'] = 'aprende/header/aprende_lista_view';
        $data['navegacion_view'] = 'aprende';
        $data['tab'] = 'tutoriales';
        $data['contenido_view'] = 'aprende/aprende_lista_view';
        $this->load->view('template/template', $data);
    }
    
    /**
     * Este método devuelve el html correspondiente a las 3 noticias que ha hecho 
     * el usuario siguientes al offset que llega por  POST. 
     */
    function mostrar_mas_noticias_ajax() {
        $offset = $this->input->get_post('offset', TRUE);
        $this->load->model('noticia_model');
        $data['noticias'] = $this->noticia_model->dar_noticias_offset($offset);
        $this->load->view('aprende/ajax/noticias_listado_view', $data);
    }
    
    /**
     * Este método devuelve el html correspondiente a las 3 noticias que ha hecho 
     * el usuario siguientes al offset que llega por  POST. 
     */
    function mostrar_mas_tips_ajax() {
        $offset = $this->input->get_post('offset', TRUE);
        $this->load->model('tip_model');
        $data['tips'] = $this->tip_model->dar_tips_offset($offset);
        $this->load->view('aprende/ajax/tips_listado_view', $data);
    }
}