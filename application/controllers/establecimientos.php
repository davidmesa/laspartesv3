<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja los establecimientos, zonas y servicios
 */
class Establecimientos extends Laspartes_Controller {

    /**
     * Constructor de la clase Establecimientos
     */
    function __construct() {
        parent::__construct();
//        $this->output->enable_profiler(TRUE);
    }

    /**
     * Retorna si una palabra es diferente a la otra
     * @param String $palabra1
     * @param String $palabra2
     * @return boolean $es_diferente
     */
    function _es_diferente_string($palabra1, $palabra2) {
        if ($palabra1 != $palabra2)
            return TRUE;
        $this->form_validation->set_message('_es_diferente_string', 'Por favor escriba un comentario válido.');
        return FALSE; 
    }

    /**
     * Verifica si existe un mail dado
     * @param String $email
     * @return boolean $no_existe_email true si no existe
     */
    function _no_existe_email($email) {
        $this->load->model('usuario_model');
        $existe = $this->usuario_model->existe_email($email);
        if (!$existe)
            return TRUE;
        else {
            $this->form_validation->set_message('_no_existe_email', 'El correo electrónico dado ya se encuentra registrado.');
            return FALSE;
        }
    }

    /**
     * Verifica si existe un usuario dado
     * @param String $usuario
     * @return boolean $no_existe_usuario true si no existe
     */
    function _no_existe_usuario($usuario) {
        $this->load->model('usuario_model');
        $existe = $this->usuario_model->existe_usuario($usuario);
        if (!$existe)
            return TRUE;
        else {
            $this->form_validation->set_message('_no_existe_usuario', 'El usuario dado ya se encuentra registrado.');
            return FALSE;
        }
    }

    /**
     * Da la información de un establecimiento
     * @param int $id_establecimiento
     * @return array con $establecimiento y $establecimiento_imagenes
     */
    function _ver_establecimiento($id_establecimiento) {
        $this->load->model('establecimiento_model');
        $this->establecimiento_model->actualizar_numero_visitas($id_establecimiento);
        $data['establecimientos'] = $this->establecimiento_model->dar_establecimientos();
        $data['establecimiento'] = $this->establecimiento_model->dar_establecimiento_activo($id_establecimiento);
        $data['establecimiento_servicios'] = $this->establecimiento_model->dar_establecimiento_servicios($id_establecimiento);
        $data['establecimiento_imagenes'] = $this->establecimiento_model->dar_establecimiento_imagenes($id_establecimiento);
        $data['establecimiento_comentarios'] = $this->establecimiento_model->dar_establecimiento_comentarios_activos($id_establecimiento);
        $data['establecimiento_calificacion'] = $this->establecimiento_model->dar_establecimiento_calificacion_promedio($id_establecimiento);

        //---------------
        $this->load->model('establecimiento_model');
        $this->load->model('generico_model');
        $this->load->library('pagination');
        $data['numero_establecimientos'] = (int) ($this->establecimiento_model->contar_establecimientos(str_replace('-', ' ', convert_accented_characters($servicio)), str_replace('-', ' ', convert_accented_characters($zona))) / 10);

        $data['allciudades'] = $this->establecimiento_model->dar_ciudades();
        $index = 0;
        foreach ($data['allciudades'] as $ciudad) {
            $data['allciudades'][$index]->label = $ciudad->ciudad;
            $data['allciudades'][$index]->value = $ciudad->ciudad;
            $index++;
        }
        $data['servicios'] = $this->establecimiento_model->dar_servicios_filtros(str_replace('-', ' ', convert_accented_characters($zona)));
        $data['zonas'] = $this->establecimiento_model->dar_zonas_filtros(str_replace('-', ' ', convert_accented_characters($servicio)));

        //--------

        return $data;
    }

    /**
     * Da la lista de establecimientos
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @param String $servicio
     * @param String $zona
     * @return array con $establecimientos, $servicios, $zonas
     */
    function _ver_establecimientos($limit, $offset, $orden, $servicio, $zona, $ciudad) {
        $offset = $offset -1;
        $this->load->model('establecimiento_model');
        $this->load->model('generico_model');
        $this->load->library('pagination');
        $data['numero_establecimientos'] = (int) ($this->establecimiento_model->contar_establecimientos(str_replace('-', ' ', convert_accented_characters($servicio)), str_replace('-', ' ', convert_accented_characters($zona)),str_replace('-', ' ', convert_accented_characters($ciudad))) / 10) +1;

        $data['allciudades'] = $this->establecimiento_model->dar_ciudades();
        $index = 0;
        foreach ($data['allciudades'] as $ciudades) {
            $data['allciudades'][$index]->label = $ciudades->ciudad;
            $data['allciudades'][$index]->value = $ciudades->ciudad;
            $index++;
        }
        $servicios = str_replace('-', ' ', convert_accented_characters($servicio));
        $ciudad = str_replace('-', ' ', convert_accented_characters($ciudad));
        $zona = str_replace('-', ' ', convert_accented_characters($zona));
        $data['establecimientos'] = $this->establecimiento_model->dar_establecimientos_paginacion_filtros($limit, $offset, $orden,$servicios, $zona, $ciudad);
        $data['establecimientos_servicios'] = $this->establecimiento_model->dar_relacion_establecimientos_servicios();
        $data['servicios'] = $this->establecimiento_model->dar_servicios_filtros($zona);
        $data['zonas'] = $this->establecimiento_model->dar_zonas_filtros($servicios, $ciudad, $zona);
        return $data;
    }

    /**
     * Agrega un nuevo comentario al establecimiento
     */
    function agregar_establecimiento_comentario() {
        if (!$this->session->userdata('esta_registrado')) {
            $id_establecimiento = $this->input->post('id_establecimiento', TRUE);

            $data = $this->_ver_establecimiento($id_establecimiento);
            $data['titulo'] = 'Detalle del establecimiento';
            $data['header_view'] = 'establecimiento/header/establecimiento_detalle_view';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'establecimientos">Establecimientos</a> :: ' . $data['establecimiento']->nombre;
            $data['navegacion_view'] = 'establecimientos';
            $data['contenido_view'] = 'establecimiento/establecimiento_detalle_view';
            $data['error'] = 'Lo sentimos, debe iniciar su sesión como usuario registrado para realizar esta acción';
            $this->load->view('template/template', $data);
        } else {
            $this->load->model('usuario_model');
            $id_usuario = $this->session->userdata('id_usuario');
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $comentario_defecto = 'Cuéntenos su experiencia con el establecimiento...';
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_establecimiento',
                    'label' => 'identificador del establecimiento',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'comentario',
                    'label' => 'comentario',
                    'rules' => 'trim|callback__es_diferente_string[' . $comentario_defecto . ']|required|xss_clean'
                ),
                array(
                    'field' => 'calificacion',
                    'label' => 'calificación',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            $id_establecimiento = $this->input->post('id_establecimiento', TRUE);
            if (!$this->form_validation->run()) {
                echo validation_errors();
            } else {
                $this->load->model('establecimiento_model');
                $calificacion = $this->input->post('calificacion', TRUE);
                $comentario = ucwords(strtolower($this->input->post('comentario', TRUE)));
                $id_establecimiento_comentario = $this->establecimiento_model->agregar_establecimiento_comentario($id_establecimiento, $id_usuario, $comentario, $calificacion);

                $data = $this->_ver_establecimiento($id_establecimiento);
                $data['usuario'] = $usuario;
                $data['comentario'] = $comentario;
                $data['calificacion'] = $calificacion;
                // Enviar mail
                $this->load->helper('mail');

                ob_start();
                $this->load->view('emails/opinion_correo_view', $data);
                $contenidoHTML = ob_get_contents();
                ob_end_clean();
                ob_flush();

//                $destinatario = new stdClass();
//                $destinatario->email = $data['establecimiento']->email;  
//                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = $usuario->email; 
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = 'tallerenlinea@laspartes.com.co';
                $destinatarios[] = $destinatario;
                send_mail($destinatarios, "[Las Partes] Comentario a establecimiento", $contenidoHTML, "", $fileName);

                $data1['calificacion'] = $calificacion;
                $data1['comentario'] = $comentario;
                $data1['usuario'] = $usuario->nombres;
                $json = json_encode($data1);
                echo 'true|' . $json;
            }
        }
    }

    /**
     * Agrega un nuevo comentario al establecimiento ingresando a la cuenta
     */
    function agregar_establecimiento_comentario_ingresar() {
        $comentario_defecto = 'Cuéntenos su experiencia con el establecimiento...';
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
                'field' => 'id_establecimiento_ingresar',
                'label' => 'identificador del establecimiento',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'comentario_ingresar',
                'label' => 'comentario',
                'rules' => 'trim|callback__es_diferente_string[' . $comentario_defecto . ']|required|xss_clean'
            ),
            array(
                'field' => 'calificacion_ingresar',
                'label' => 'calificación',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_establecimiento = $this->input->post('id_establecimiento_ingresar', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_establecimiento($id_establecimiento);
            $data['titulo'] = 'Detalle del establecimiento';
            $data['header_view'] = 'establecimiento/header/establecimiento_detalle_view';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'establecimientos">Establecimientos</a> :: ' . $data['establecimiento']->nombre;
            $data['navegacion_view'] = 'establecimientos';
            $data['contenido_view'] = 'establecimiento/establecimiento_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        } else {
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email_ingresar', TRUE));
            $contrasena = sha1($this->input->post('contrasena_ingresar', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);
            if (!$resultado) {
                $data = $this->_ver_establecimiento($id_establecimiento);
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $data['titulo'] = 'Detalle del establecimiento';
                $data['header_view'] = 'establecimiento/header/establecimiento_detalle_view';
                $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'establecimientos">Establecimientos</a> :: ' . $data['establecimiento']->nombre;
                $data['navegacion_view'] = 'establecimientos';
                $data['contenido_view'] = 'establecimiento/establecimiento_detalle_view';
                echo validation_errors();
                $this->load->view('template/template', $data);
            } else {
                $this->load->model('establecimiento_model');
                $id_usuario = $this->session->userdata('id_usuario');
                $calificacion = $this->input->post('calificacion_ingresar', TRUE);
                $comentario = ucwords(strtolower($this->input->post('comentario_ingresar', TRUE)));
                $id_establecimiento_comentario = $this->establecimiento_model->agregar_establecimiento_comentario($id_establecimiento, $id_usuario, $comentario, $calificacion);
                $data = $this->_ver_establecimiento($id_establecimiento);

                // Enviar mail
                $this->load->library('email');
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
                $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
                $this->email->subject('[Las Partes] Comentario a establecimiento');
                $this->email->message('
                    Un usuario ha comentado y calificado el establecimiento ' . $data['establecimiento']->nombre . ':
                    <br /><br />
                    Calificación: ' . $calificacion . '<br />
                    Comentario: ' . $comentario . '<br />
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $data['scrollTo'] = 'comentario-' . $id_establecimiento_comentario;
                $data['titulo'] = 'Detalle del establecimiento';
                $data['header_view'] = 'establecimiento/header/establecimiento_detalle_view';
                $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'establecimientos">Establecimientos</a> :: ' . $data['establecimiento']->nombre;
                $data['navegacion_view'] = 'establecimientos';
                $data['contenido_view'] = 'establecimiento/establecimiento_detalle_view';
                $this->load->view('template/template', $data);
            }
        }
    }

    /**
     * Agrega un nuevo comentario al establecimiento y se registra en el sistema
     */
    function agregar_establecimiento_comentario_registrarse() {
        $comentario_defecto = 'Cuéntenos su experiencia con el establecimiento...';
        $contrasena = $this->input->post('contrasena_registrarse', TRUE);
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
                'rules' => 'trim|required|callback__no_existe_usuario|xss_clean'
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
                'field' => 'id_establecimiento_registrarse',
                'label' => 'identificador del establecimiento',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'comentario_registrarse',
                'label' => 'comentario',
                'rules' => 'trim|callback__es_diferente_string[' . $comentario_defecto . ']|required|xss_clean'
            ),
            array(
                'field' => 'calificacion_registrarse',
                'label' => 'calificación',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_establecimiento = $this->input->post('id_establecimiento_registrarse', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_establecimiento($id_establecimiento);
            $data['titulo'] = 'Detalle del establecimiento';
            $data['header_view'] = 'establecimiento/header/establecimiento_detalle_view';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'establecimientos">Establecimientos</a> :: ' . $data['establecimiento']->nombre;
            $data['navegacion_view'] = 'establecimientos';
            $data['contenido_view'] = 'establecimiento/establecimiento_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        } else {
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

            $this->load->model('establecimiento_model');
            $calificacion = $this->input->post('calificacion_registrarse', TRUE);
            $comentario = ucwords(strtolower($this->input->post('comentario_registrarse', TRUE)));
            $id_establecimiento_comentario = $this->establecimiento_model->agregar_establecimiento_comentario($id_establecimiento, $id_usuario, $comentario, $calificacion);
            $data = $this->_ver_establecimiento($id_establecimiento);

            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
            $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
            $this->email->subject('[Las Partes] Comentario a establecimiento');
            $this->email->message('
                Un usuario ha comentado y calificado el establecimiento ' . $data['establecimiento']->nombre . ':
                <br /><br />
                Calificación: ' . $calificacion . '<br />
                Comentario: ' . $comentario . '<br />
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
            ');
            $this->email->send();

            $data['scrollTo'] = 'comentario-' . $id_establecimiento_comentario;
            $data['titulo'] = 'Detalle del establecimiento';
            $data['header_view'] = 'establecimiento/header/establecimiento_detalle_view';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'establecimientos">Establecimientos</a> :: ' . $data['establecimiento']->nombre;
            $data['navegacion_view'] = 'establecimientos';
            $data['contenido_view'] = 'establecimiento/establecimiento_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Manda un mail al establecimiento y al administrador del sistema
     */
    function contactar_establecimiento() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_establecimiento_contactar',
                'label' => 'identificador del establecimiento',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'asunto_contactar',
                'label' => 'asunto',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'mensaje_contactar',
                'label' => 'mensaje a enviar',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);
        if (!$this->form_validation->run()) {
            echo validation_errors();
        } else {
            $id_establecimiento = $this->input->post('id_establecimiento_contactar', TRUE);
            $data = $this->_ver_establecimiento($id_establecimiento);
            $data['asunto'] = $this->input->post('asunto_contactar', TRUE);
            $data['mensaje'] = $this->input->post('mensaje_contactar', TRUE);
            $this->load->model('usuario_model');
            $id_usuario = $this->session->userdata('id_usuario');
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $data['usuario'] = $usuario;
            $this->load->helper('mail');

            ob_start();
            $this->load->view('emails/contacto_correo_view', $data);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();

            $destinatario = new stdClass();
            $destinatario->email = $data['establecimiento']->email;  
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = $usuario->email; 
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = 'tallerenlinea@laspartes.com.co';
            $destinatarios[] = $destinatario;
            send_mail($destinatarios, '[LasPartes.com.co] '.$data['establecimiento']->nombre.', te han enviado un mensaje', $contenidoHTML, "", $fileName);
            echo true;
        }
    }

    /**
     * Muestra la lista de establecimientos
     */
    function index() {
        $this->load->helper('text');
        $servicio;
        $zona;
        $pagina;
        $ciudad;
        $pagina = 1; 
        $order = 'rating';
        if ($this->uri->segment(2)) {
            $url = uri_string();
            $urlArray = split("/", $url);
            for ($i = 2; $i < sizeof($urlArray); $i++) {
                if ($urlArray[$i] == 'servicio') {
                    $i++;
                    $servicio = $urlArray[$i];
                } elseif ($urlArray[$i] == 'zona') {
                    $i++;
                    $zona = $urlArray[$i];
                } elseif ($urlArray[$i] == 'pagina') {
                    $i++;
                    $pagina = $urlArray[$i] + 0;
                } elseif ($urlArray[$i] == 'ciudad') {
                    $i++;
                    $ciudad = $urlArray[$i];
                } elseif ($urlArray[$i] == 'ordenarpor') {
                    $i++;
                    $order = $urlArray[$i];
                }
            }
        }
        $data = $this->_ver_establecimientos(10, $pagina, $order, $servicio, $zona, $ciudad);
        $this->load->model('generico_model');
        $data['servicioBusqueda'] = $servicio;
        if ($servicio != '') {
            $servicioObj = $this->generico_model->dar_tildes('servicios', 'nombre', str_replace('-', ' ', $servicio));
            $data['servicioBusqueda'] = $servicioObj->nombre;
        }
        $data['zonaBusqueda'] = $zona;
        if ($zona != '') {
            $zonaObj = $this->generico_model->dar_tildes('zonas', 'nombre', str_replace('-', ' ', $zona));
            $data['zonaBusqueda'] = $zonaObj->nombre;
        }

        $data['zonaCiudad'] = $ciudad;
        if ($ciudad != '') {
            $ciudadObj = $this->generico_model->dar_tildes('zonas', 'ciudad', str_replace('-', ' ', $ciudad));
            if(count($ciudadObj)>0)
                $data['zonaCiudad'] = $ciudadObj->ciudad;
            else
                $data['zonaCiudad'] = str_replace('-', ' ', $ciudad);
        }
        $data['orden'] = $orden;
        $data['limit'] = $pagina;
        $keywords = '';
        foreach ($data['servicios'] as $servi):
            $keywords .= ','.$servi->nombre;
        endforeach;
        $data['metaKeywords'] = 'talleres,bogota'.$keywords;
        $data['metaDescripcion'] = 'Encuentra los mejores talleres de carros en tu ciudad';
        $data['metaImagen'] = 'resources/images/home/noticias/baner-talleres.png';
        $data['titulo'] = 'Laspartes.com :: Talleres aliados';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Talleres</div>';
        $data['header_view'] = 'establecimiento/header/establecimiento_lista_view';
        $data['navegacion_view'] = 'establecimientos';
        $data['contenido_view'] = 'establecimiento/establecimiento_lista_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra un establecimiento
     */
    function ver_establecimiento($id_establecimiento, $nombre_establecimiento) {

        $servicio;
        $zona;
        $pagina;
        $ciudad;
        $pagina = 0;
        $order = 'calificacion';
        if ($this->uri->segment(2)) {
            $url = uri_string();
            $urlArray = split("/", $url);
            for ($i = 2; $i < sizeof($urlArray); $i++) {
                if ($urlArray[$i] == 'servicio') {
                    $i++;
                    $servicio = $urlArray[$i];
                } elseif ($urlArray[$i] == 'zona') {
                    $i++;
                    $zona = $urlArray[$i];
                } elseif ($urlArray[$i] == 'pagina') {
                    $i++;
                    $pagina = $urlArray[$i] + 0;
                } elseif ($urlArray[$i] == 'ciudad') {
                    $i++;
                    $ciudad = $urlArray[$i];
                } elseif ($urlArray[$i] == 'ordenarpor') {
                    $i++;
                    $order = $urlArray[$i];
                }
            }
        }
        $data = $this->_ver_establecimiento($id_establecimiento, 10, $pagina, $order, $servicio, $zona, $ciudad);
        $this->load->model('generico_model');
        $data['servicioBusqueda'] = $servicio;
        if ($servicio != '') {
            $servicioObj = $this->generico_model->dar_tildes('servicios', 'nombre', str_replace('-', ' ', $servicio));
            $data['servicioBusqueda'] = $servicioObj->nombre;
        }
        $data['zonaBusqueda'] = $zona;
        if ($zona != '') {
            $zonaObj = $this->generico_model->dar_tildes('zonas', 'nombre', str_replace('-', ' ', $zona));
            $data['zonaBusqueda'] = $zonaObj->nombre;
        }

        $data['zonaCiudad'] = $ciudad;
        if ($ciudad != '') {
            $ciudadObj = $this->generico_model->dar_tildes('zonas', 'ciudad', str_replace('-', ' ', $ciudad));
            $data['zonaCiudad'] = $ciudadObj->ciudad;
        }

        if (sizeof($data['establecimiento']) == 0) {
            $data['titulo'] = 'Página no Encontrada';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="' . base_url() . 'talleres">Talleres</a></div> <div class="div-breadcrumb-espaciador"></div><div>Página no encontrada - Lo sentimos</div>';
            $data['header_view'] = 'error/404/header/404_view';
            $data['navegacion_view'] = 'establecimientos';
            $data['contenido_view'] = 'error/404/404_view';
            $this->load->view('template/template', $data);
        } else {
            $data['metaImagen'] = $data['establecimiento']->logo_url;
            $keywords = '';
            foreach ($data['establecimiento_servicios'] as $servi):
                $keywords .= ','.$servi->nombre;
            endforeach;
            
            $data['metaKeywords'] = $data['establecimiento']->nombre.$keywords;
            $data['metaDescripcion'] = character_limiter($data['establecimiento']->descripcion, 150);
            $data['titulo'] = $data['establecimiento']->nombre;
            $data['header_view'] = 'establecimiento/header/establecimiento_detalle_view';
            $data['contenido_view'] = 'establecimiento/establecimiento_detalle_view';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="' . base_url() . 'talleres">Talleres Aliados</a></div> <div class="div-breadcrumb-espaciador"></div>'. $data['establecimiento']->nombre;
            $data['navegacion_view'] = 'establecimientos';
            $this->load->view('template/template', $data);
        }
    }

    function mostrar_comentario() {
        $usuario = $this->input->get_post('usuario', TRUE);
        $comentario = $this->input->get_post('comentario', TRUE);
        $calificacion = $this->input->get_post('calificacion', TRUE);
        $data['usuario'] = $usuario;
        $data['comentario'] = $comentario;
        $data['calificacion'] = $calificacion;
        $data['fecha'] = '2012-10-10';
        $this->load->view('establecimiento/ajax/comentario_view_ajax', $data);
    }

    /**
     * muesta un comentario 
     */
    function mostrar_comentario_ajax() {
        $usuario = $this->input->get_post('usuario', TRUE);
        $comentario = $this->input->get_post('comentario', TRUE);
        $calificacion = $this->input->get_post('calificacion', TRUE);
        $data2['usuario'] = $usuario;
        $data2['comentario'] = $comentario;
        $data2['calificacion'] = $calificacion;
        $this->load->view('establecimiento/ajax/comentario_view_ajax', $data2);
    }

}