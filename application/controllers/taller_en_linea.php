<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja el taller en línea
 */
class Taller_en_linea extends Laspartes_Controller {

    /**
     * Constructor de la clase Taller_en_linea
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Da la información requerida para el formulario de agregar pregunta
     * @return array con $preguntas_categorias
     */
    function _agregar_pregunta() {
        $this->load->model('pregunta_model');
        $data['preguntas_categorias'] = $this->pregunta_model->dar_preguntas_categorias();
        $data['preguntas_recientes'] = $this->pregunta_model->dar_preguntas_paginacion_filtros(10, 0);
        return $data;
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
     * Da la información requerida de una pregunta
     * @param int $id_pregunta
     * @return array con $pregunta, $respuestas, $me_gusta (si tiene sesión iniciada)
     */
    function _ver_pregunta($id_pregunta) {
        $this->load->model('pregunta_model');
        $data['pregunta'] = $this->pregunta_model->dar_pregunta($id_pregunta);
        $data['respuestas'] = $this->pregunta_model->dar_respuestas($id_pregunta);
        if ($data['pregunta'] != NULL) {
            $data['preguntas_relacionadas'] = $this->pregunta_model->dar_preguntas_categoria_relacionadas($id_pregunta, $data['pregunta']->id_pregunta_categoria);
            if ($this->session->userdata('esta_registrado')) {
                $data['respuestas_me_gustan'] = $this->pregunta_model->dar_respuestas_me_gustan($this->session->userdata('id_usuario'), $id_pregunta);
            }
            $id_usuario = $data['pregunta']->id_usuario;
            $this->load->model('usuario_model');
            $data['vehiculos_usuario'] = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
        }
        return $data;
    }

    /**
     * Da los datos necesarios para la lista de preguntas
     * @param String $url
     * @param int $limit
     * @param int $offset
     * @param String $categoria
     * @return array con $preguntas y $preguntas_categorias
     */
    function _ver_preguntas($limit, $offset, $categoria) {
        $offset = $offset - 1;
        $this->load->model('pregunta_model');
        $numero_preguntas = $this->pregunta_model->contar_preguntas(str_replace('-', ' ', convert_accented_characters($categoria)));
        $data['numero_preguntas'] = (int) ($numero_preguntas / 10) + 1;
        $data['preguntas'] = $this->pregunta_model->dar_preguntas_paginacion_filtros($limit, $offset, str_replace('-', ' ', convert_accented_characters($categoria)));
        $data['preguntas_categorias'] = $this->pregunta_model->dar_preguntas_categorias_cantidad();
        return $data;
    }

    /**
     * Agrega un nuevo me gusta a una pregunta
     */
    function agregar_me_gusta_ajax() {
        if ($this->session->userdata('esta_registrado')) {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_respuesta',
                    'label' => 'identificador de la respuesta',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'me_gusta',
                    'label' => 'me gusta',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if ($this->form_validation->run()) {
                $this->load->model('pregunta_model');
                $id_respuesta = $this->input->post('id_respuesta', TRUE);
                $me_gusta = $this->input->post('me_gusta', TRUE);
                $this->pregunta_model->agregar_me_gusta($id_usuario, $id_respuesta, $me_gusta);

                if ($me_gusta == 1)
                    $this->pregunta_model->actualizar_respuesta_me_gusta($id_respuesta);
            }
        }
    }

    /**
     * Agrega un nueva pregunta
     */
    function agregar_pregunta() {
        if ($this->session->userdata('esta_registrado')) {
            $id_usuario = $this->session->userdata('id_usuario');
            $titulo_pregunta_defecto = 'Escribe aquí tu pregunta...';
            $cuerpo_pregunta_defecto = 'Escribe aquí los detalles de tu pregunta...';
            $palabras_clave_defecto = 'Por ejemplo: Llantas, Renault, Twingo';
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'titulo_pregunta',
                    'label' => 'pregunta',
                    'rules' => 'trim|callback__es_diferente_string[' . $titulo_pregunta_defecto . ']|required|xss_clean'
                ),
                array(
                    'field' => 'cuerpo_pregunta',
                    'label' => 'detalles de la pregunta',
                    'rules' => 'trim|callback__es_diferente_string[' . $cuerpo_pregunta_defecto . ']|required|xss_clean'
                ),
                array(
                    'field' => 'id_pregunta_categoria',
                    'label' => 'categoria',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'palabras_clave',
                    'label' => 'palabras clave',
                    'rules' => 'trim|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()) {
                $url = base_url() . 'preguntas';
                redirect($url);
            } else {
                $this->load->model('pregunta_model');
                $titulo_pregunta = (strtolower($this->input->post('titulo_pregunta', TRUE)));
                $cuerpo_pregunta = $this->input->post('cuerpo_pregunta', TRUE);
                $id_pregunta_categoria = $this->input->post('id_pregunta_categoria', TRUE);
                $palabras_clave = $this->input->post('palabras_clave', TRUE);
                if ($palabras_clave == $palabras_clave_defecto)
                    $palabras_clave = NULL;


                // Sube el logo
                $this->load->library('upload');

                $config = array(
                    'upload_path' => './resources/images/tallerenlinea/preguntas/',
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'file_name' => $titulo_pregunta,
                    'max_size' => '10000'
                );
                $this->upload->initialize($config);

                if ($this->upload->do_upload('pregunta_input_imagen')) {
                    $logo = $this->upload->data();

                    $this->load->library('image_lib');
                    $config = array(
                        'source_image' => $logo['full_path'],
                        'quality' => '100%',
                        'new_image' => './resources/images/tallerenlinea/preguntas/thumb',
                        'width' => 190,
                        'height' => 125,
                        'master_dim' => 'width'
                    );
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $logo_url = 'resources/images/tallerenlinea/preguntas/' . $logo['file_name'];
                    $logo_thumb_url = 'resources/images/tallerenlinea/preguntas/thumb/' . $logo['file_name'];
                }


                $id_pregunta = $this->pregunta_model->agregar_pregunta($id_usuario, $titulo_pregunta, $cuerpo_pregunta, $id_pregunta_categoria, $palabras_clave, $logo_thumb_url, 'No Activo');

                $this->load->model('indexacion_model');
                $categoria = $this->pregunta_model->dar_pregunta_categoria($id_pregunta_categoria);
                $indexacion = $titulo_pregunta . ' ' . $cuerpo_pregunta . ' ' . $categoria->nombre . ' ' . $palabras_clave;
                $this->indexacion_model->agregar_indexacion('taller en línea', $id_pregunta, $titulo_pregunta, $cuerpo_pregunta, $indexacion, 'taller_en_linea/ver_pregunta/' . $id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($titulo_pregunta)), 'Activo');
                $url = base_url() . 'preguntas';
                $data1['url'] = $url;
//               
                $this->load->model('usuario_model');
                $data1['pregunta'] = $this->pregunta_model->dar_pregunta($id_pregunta);
                $usuario = $this->usuario_model->dar_usuario($id_usuario);

                // Enviar mail

                $destinatarios = array();

                $destinatario = new stdClass();
                $destinatario->email = 'tallerenlinea@laspartes.com.co';
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = 'ventas@laspartes.com.co';
                $destinatarios[] = $destinatario;

                ob_start();
                $llave = $this->pregunta_model->generar_codConfirmacion_Unico();
                $this->pregunta_model->guardar_codConfirmacion_Unico($llave, $id_pregunta);
                $data1['usuario'] = $usuario;
                $data1['aprobado'] = false;
                $data1['url_no_activar'] = base_url() . 'preguntas/no_activar_pregunta/' . $llave;
                $data1['url_activar'] = base_url() . 'preguntas/activar_pregunta/' . $llave;
                $data1['vehiculos'] = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
                $this->load->view('emails/pregunta_correo_view', $data1);
                $contenidoHTML = ob_get_contents();
                ob_end_clean();
                ob_flush();

                $this->load->helper('mail');

                send_mail($destinatarios, "[Las Partes] [Nueva pregunta]", $contenidoHTML, "", $fileName);
                echo "<script type='text/javascript'>top.location = '" . $url . "';</script>";
            }
        }
    }

    /**
     * Activa la pregunta del usuario y envía un correo al destinatario y a los talleres
     * @param type $llave
     */
    function activar_pregunta($llave) {
        $this->load->model('pregunta_model');
        $this->load->model('usuario_model');
        $data1['pregunta'] = $this->pregunta_model->dar_pregunta_confirmacion($llave);
        $url = base_url() . 'preguntas';
        if (sizeof($data1['pregunta']) >= 1 || !empty($data1['pregunta'])) {
            $this->pregunta_model->activar_pregunta($data1['pregunta']->id_pregunta);
            $url = base_url() . 'preguntas/' . $data1['pregunta']->id_pregunta . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $data1['pregunta']->titulo_pregunta);
            $data1['url'] = $url;
            $data1['usuario'] = $this->usuario_model->dar_usuario($data1['pregunta']->id_usuario);
            $destinatarios = array();

            $destinatario = new stdClass();
            $destinatario->email = $data1['usuario']->email;
            $destinatarios[] = $destinatario;
            //        
            // Enviar mails a establecimientos afiliados
            $usuariosEstablecimientos = $this->usuario_model->dar_usuarios_tipo(20);

            foreach ($usuariosEstablecimientos as $usuariosEstablecimiento) {
                $destinatario = new stdClass();
                $destinatario->email = $usuariosEstablecimiento->email;
                $destinatarios[] = $destinatario;
            }
            ob_start();
            $data1['aprobado'] = true;
            $data1['vehiculos'] = $this->usuario_model->dar_vehiculos_usuario($data1['pregunta']->id_usuario);
            $this->load->view('emails/pregunta_correo_view', $data1);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();

            $this->load->helper('mail');

            send_mail($destinatarios, "[Las Partes] [Nueva pregunta]", $contenidoHTML, "", $fileName);
            $this->pregunta_model->eliminar_llave($data1['pregunta']->id_confirmar_pregunta);
        }
        echo "<script type='text/javascript'>top.location = '" . $url . "';</script>";
    }

    function no_activar_pregunta($llave) {
        $this->load->model('pregunta_model');
        $this->load->model('usuario_model');
        $data1['pregunta'] = $this->pregunta_model->dar_pregunta_confirmacion($llave);
        $url = base_url() . 'preguntas';

        if (sizeof($data1['pregunta']) >= 1 || !empty($data1['pregunta'])) {
            $data1['usuario'] = $this->usuario_model->dar_usuario($data1['pregunta']->id_usuario);

            $destinatarios = array();

            $destinatario = new stdClass();
            $destinatario->email = $data1['usuario']->email;
            $destinatarios[] = $destinatario;

            ob_start();
            //            $data1['vehiculos'] = $this->usuario_model->dar_vehiculos_usuario($data1['pregunta']->id_usuario);
            $this->load->view('emails/pregunta_asesor_view', $data1);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();

            $this->load->helper('mail');

            send_mail($destinatarios, "[Las Partes] [Asesor asignado]", $contenidoHTML, "", "");
            $this->pregunta_model->eliminar_llave($data1['pregunta']->id_confirmar_pregunta);
        }

        echo "<script type='text/javascript'>top.location = '" . $url . "';</script>";
    }

    /**
     * Agrega un nueva pregunta
     * Ingresa e inicia sesión
     */
    function agregar_pregunta_ingresar() {
        $id_usuario = $this->session->userdata('id_usuario');
        $titulo_pregunta_defecto = 'Escribe aquí tu pregunta...';
        $cuerpo_pregunta_defecto = 'Escribe aquí los detalles de tu pregunta...';
        $palabras_clave_defecto = 'Por ejemplo: Llantas, Renault, Twingo';
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
                'field' => 'titulo_pregunta_ingresar',
                'label' => 'pregunta',
                'rules' => 'trim|callback__es_diferente_string[' . $titulo_pregunta_defecto . ']|required|xss_clean'
            ),
            array(
                'field' => 'cuerpo_pregunta_ingresar',
                'label' => 'detalles de la pregunta',
                'rules' => 'trim|callback__es_diferente_string[' . $cuerpo_pregunta_defecto . ']|required|xss_clean'
            ),
            array(
                'field' => 'id_pregunta_categoria_ingresar',
                'label' => 'categoria',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'palabras_clave_ingresar',
                'label' => 'palabras clave',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $data = $this->_agregar_pregunta();
            $data['titulo'] = 'Preguntar';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: Preguntar';
            $data['header_view'] = 'taller_en_linea/header/pregunta_agregar_view';
            $data['navegacion_view'] = 'tallerenlinea';
            $data['contenido_view'] = 'taller_en_linea/pregunta_agregar_view';
            $this->load->view('template/template', $data);
        } else {
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email_ingresar', TRUE));
            $contrasena = sha1($this->input->post('contrasena_ingresar', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);
            if (!$resultado) {
                $data = $this->_ver_pregunta($id_pregunta);
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $data['titulo'] = 'Preguntas y Respuestas';
                $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: ' . $data['pregunta']->titulo_pregunta;
                $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
                $data['navegacion_view'] = 'tallerenlinea';
                $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
                $this->load->view('template/template', $data);
                $this->load->view('template/template', $data);
            } else {
                $this->load->model('pregunta_model');
                $titulo_pregunta = ucwords(strtolower($this->input->post('titulo_pregunta_ingresar', TRUE)));
                $cuerpo_pregunta = $this->input->post('cuerpo_pregunta_ingresar', TRUE);
                $id_pregunta_categoria = $this->input->post('id_pregunta_categoria_ingresar', TRUE);
                $palabras_clave = $this->input->post('palabras_clave_ingresar', TRUE);
                if ($palabras_clave == $palabras_clave_defecto)
                    $palabras_clave = NULL;
                $id_pregunta = $this->pregunta_model->agregar_pregunta($id_usuario, $titulo_pregunta, $cuerpo_pregunta, $id_pregunta_categoria, $palabras_clave);

                $data = $this->_ver_pregunta($id_pregunta);

                // Enviar mail
                $this->load->library('email');
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co - Taller en línea');
                $this->email->to($data['pregunta']->email);

                $destinatarios = array();
                array_push($destinatarios, 'tallerenlinea@laspartes.com.co');

                // Enviar mails a establecimientos afiliados
                $this->load->model('usuario_model');
                $usuariosEstablecimientos = $this->usuario_model->dar_usuarios_tipo(20);

                foreach ($usuariosEstablecimientos as $usuariosEstablecimiento) {
                    array_push($destinatarios, $usuariosEstablecimiento->email);
                }

                $this->email->bcc($destinatarios);

                $this->email->subject('[Las Partes] [Nueva pregunta]');
                $this->email->message('
                    Muchas gracias por preguntar en nuestro <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a><br />
                    <br />
                    En cualquier momento puede darle seguimiento a su pregunta haciendo click
                    <a href="' . base_url() . 'taller_en_linea/ver_pregunta/' . $data['pregunta']->id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($data['pregunta']->titulo_pregunta)) . '">aquí</a>.
                    <br />
                    <br />
                    En caso de no poder hacer click, copie y pegue la siguiente dirección en su navegador: <br />
                    ' . base_url() . 'taller_en_linea/ver_pregunta/' . $data['pregunta']->id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($data['pregunta']->titulo_pregunta)) . '
                    <br />
                    Usted preguntó:
                    <br />
                    ' . $data['pregunta']->cuerpo_pregunta . '
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $data['titulo'] = 'Preguntas y Respuestas';
                $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: ' . $data['pregunta']->titulo_pregunta;
                $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
                $data['navegacion_view'] = 'tallerenlinea';
                $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
                $this->load->view('template/template', $data);
            }
        }
    }

    /**
     * Agrega un nueva pregunta
     * Registra un usuario e inicia sesión
     */
    function agregar_pregunta_registrarse() {
        $id_usuario = $this->session->userdata('id_usuario');
        $titulo_pregunta_defecto = 'Escribe aquí tu pregunta...';
        $cuerpo_pregunta_defecto = 'Escribe aquí los detalles de tu pregunta...';
        $palabras_clave_defecto = 'Por ejemplo: Llantas, Renault, Twingo';
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'nombre_registrarse',
                'label' => 'nombre_usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'apellidos_registrarse',
                'label' => 'apellidos_usuario',
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
                'field' => 'linea_registrarse',
                'label' => 'linea_registrarse',
                'rules' => 'trim|numeric|xss_clean'
            ),
            array(
                'field' => 'kilometraje_registrarse',
                'label' => 'kilometraje_registrarse',
                'rules' => 'trim|numeric|xss_clean'
            ),
            array(
                'field' => 'titulo_pregunta_registrarse',
                'label' => 'pregunta',
                'rules' => 'trim|callback__es_diferente_string[' . $titulo_pregunta_defecto . ']|required|xss_clean'
            ),
            array(
                'field' => 'cuerpo_pregunta_registrarse',
                'label' => 'detalles de la pregunta',
                'rules' => 'trim|callback__es_diferente_string[' . $cuerpo_pregunta_defecto . ']|required|xss_clean'
            ),
            array(
                'field' => 'id_pregunta_categoria_registrarse',
                'label' => 'categoria',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'palabras_clave_registrarse',
                'label' => 'palabras clave',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $data = $this->_agregar_pregunta();
            $data['titulo'] = 'Preguntar';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: Preguntar';
            $data['header_view'] = 'taller_en_linea/header/pregunta_agregar_view';
            $data['navegacion_view'] = 'tallerenlinea';
            $data['contenido_view'] = 'taller_en_linea/pregunta_agregar_view';
            $this->load->view('template/template', $data);
        } else {
            $this->load->model('usuario_model');
            $nombre = strtolower($this->input->post('nombre_registrarse', TRUE));
            $apellidos = strtolower($this->input->post('apellidos_registrarse', TRUE));
            $usuario = strtolower($this->input->post('usuario_registrarse', TRUE));
            $email = strtolower($this->input->post('email_registrarse', TRUE));
            $ciudad = $this->input->post('ciudad_registrarse', TRUE);
            $contrasena_simple = $this->input->post('contrasena_registrarse', TRUE);
            $contrasena = sha1($this->input->post('contrasena_registrarse', TRUE));
            $id_usuario = $this->usuario_model->agregar_usuario($nombre, $apellidos, $usuario, $email, $contrasena, $ciudad, 30);
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $usuario_sesion = array(
                'id_usuario' => $usuario->id_usuario,
                'tipo' => $usuario->tipo,
                'esta_registrado' => TRUE
            );
            $this->session->set_userdata($usuario_sesion);

            //Registra un nuevo vehículos
            $tiene_vehiculo = $this->input->post('tiene_carro_registrarse', TRUE);
            if ($tiene_vehiculo) {
                $this->_agregar_vehiculo_registro();
            }

            $this->load->model('pregunta_model');
            $titulo_pregunta = ucwords(strtolower($this->input->post('titulo_pregunta_registrarse', TRUE)));
            $cuerpo_pregunta = $this->input->post('cuerpo_pregunta_registrarse', TRUE);
            $id_pregunta_categoria = $this->input->post('id_pregunta_categoria_registrarse', TRUE);
            $palabras_clave = $this->input->post('palabras_clave_registrarse', TRUE);
            if ($palabras_clave == $palabras_clave_defecto)
                $palabras_clave = NULL;
            $id_pregunta = $this->pregunta_model->agregar_pregunta($id_usuario, $titulo_pregunta, $cuerpo_pregunta, $id_pregunta_categoria, $palabras_clave);

            $data = $this->_ver_pregunta($id_pregunta);

            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co - Taller en línea');
            $this->email->to($data['pregunta']->email);

            $destinatarios = array();
            array_push($destinatarios, 'tallerenlinea@laspartes.com.co');

            // Enviar mails a establecimientos afiliados
            $this->load->model('usuario_model');
            $usuariosEstablecimientos = $this->usuario_model->dar_usuarios_tipo(20);

            foreach ($usuariosEstablecimientos as $usuariosEstablecimiento) {
                array_push($destinatarios, $usuariosEstablecimiento->email);
            }

            $this->email->bcc($destinatarios);

            $this->email->subject('[Las Partes] [Nueva pregunta]');
            $this->email->message('
                Muchas gracias por preguntar en nuestro <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a><br />
                <br />
                En cualquier momento puede darle seguimiento a su pregunta haciendo click
                <a href="' . base_url() . 'taller_en_linea/ver_pregunta/' . $data['pregunta']->id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($data['pregunta']->titulo_pregunta)) . '">aquí</a>.
                <br />
                <br />
                En caso de no poder hacer click, copie y pegue la siguiente dirección en su navegador: <br />
                ' . base_url() . 'taller_en_linea/ver_pregunta/' . $data['pregunta']->id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($data['pregunta']->titulo_pregunta)) . '
                <br />
                Usted preguntó:
                <br />
                ' . $data['pregunta']->cuerpo_pregunta . '
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
            ');
            $this->email->send();

            $data['titulo'] = 'Preguntas y Respuestas';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: ' . $data['pregunta']->titulo_pregunta;
            $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
            $data['navegacion_view'] = 'tallerenlinea';
            $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Agrega un vehículo simple al usuario
     */
    function _agregar_vehiculo_registro() {
        $this->load->model('usuario_model');

        $id_usuario = $this->session->userdata('id_usuario');
        $id_vehiculo = $this->input->post('linea_registrarse', TRUE);
        $modelo = $this->input->post('modelo_registrarse', TRUE);

        $kilometraje = $this->input->post('kilometraje_registrarse', TRUE);
        if ($kilometraje < 0) {
            $ciudad = $this->input->post('ciudad_registrarse', TRUE);
            $tasa_ciudad = $this->usuario_model->dar_kilometraje_ciudad($ciudad);

            $ano_actual = date('Y');
            $diferencia = $ano_actual - $modelo;
            $kilometraje = $diferencia * $tasa_ciudad;
        }

        $id_usuario_vehiculo = $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $id_vehiculo, '', $modelo, $kilometraje, '', '');
    }

    /**
     * Agrega una respuesta a una pregunta
     */
    function agregar_respuesta() {
        if ($this->session->userdata('esta_registrado')) {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_pregunta',
                    'label' => 'identificador de la pregunta',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'respuesta',
                    'label' => 'respuesta',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            $id_pregunta = $this->input->post('id_pregunta', TRUE);
            if (!$this->form_validation->run()) {
//                $data = $this->_ver_pregunta($id_pregunta);
//                $data['titulo'] = 'Preguntas y Respuestas';
//                $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: <a href="'.base_url().'taller_en_linea">Taller en Línea</a> :: '.$data['pregunta']->titulo_pregunta;
//                $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
//                $data['navegacion_view'] = 'tallerenlinea';
//                $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
                echo 'false|' . validation_errors();
//                $this->load->view('template/template', $data);
            } else {
                $this->load->model('pregunta_model');
                $respuesta = nl2br($this->input->post('respuesta', TRUE));
                $id_respuesta = $this->pregunta_model->agregar_respuesta($id_pregunta, $id_usuario, $respuesta);

                $this->load->model('indexacion_model');
                $this->load->model('usuario_model');
                $pregunta = $this->pregunta_model->dar_pregunta($id_pregunta);
                $categoria = $this->pregunta_model->dar_pregunta_categoria($pregunta->id_pregunta_categoria);
                $respuestas = $this->pregunta_model->dar_respuestas($id_pregunta);
                $respuestasDestinatarios = $this->pregunta_model->dar_respuestas_destinatarios($id_pregunta);
                $respuestas_indexacion = '';
                $emails_usuarios = "";
                foreach ($respuestas as $respuesta) {
                    $respuestas_indexacion = $respuesta->respuesta . ' ';
                    $emails_usuarios .= $respuesta->email . ",";
                }
                foreach ($respuestasDestinatarios as $resDestin) {
                    $destinatario = new stdClass();
                    $destinatario->email = $resDestin->email;
                    $destinatarios[] = $destinatario;
                }



                $indexacion = $pregunta->titulo_pregunta . ' ' . $pregunta->cuerpo_pregunta . ' ' . $categoria->nombre . ' ' . $pregunta->palabras_clave . ' ' . $respuestas_indexacion;
                $this->indexacion_model->actualizar_indexacion('taller en línea', $id_pregunta, $pregunta->titulo_pregunta, $pregunta->cuerpo_pregunta, $indexacion, 'taller_en_linea/ver_pregunta/' . $id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)), $pregunta->estado);

                $data = $this->_ver_pregunta($id_pregunta);
                $data1['respuesta'] = $this->pregunta_model->dar_respuesta($id_respuesta);
                $data1['pregunta'] = $data['pregunta'];
                $url = base_url() . 'preguntas/' . $data1['pregunta']->id_pregunta . '-' . str_replace(' ', '-', convert_accented_characters($data1['pregunta']->titulo_pregunta));
                $data1['url'] = $url;
                // Enviar mail 
                $this->load->library('email');

                $destinatario = new stdClass();
                $destinatario->email = $data['pregunta']->email;
                $destinatarios[] = $destinatario; 
                $destinatario = new stdClass();
                $destinatario->email = 'tallerenlinea@laspartes.com.co';
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = 'ventas@laspartes.com.co';
                $destinatarios[] = $destinatario;

                ob_start();
                $this->load->view('emails/repuesta_correo_view', $data1);
                $contenidoHTML = ob_get_contents();
                ob_end_clean();
                ob_flush();
                $this->load->helper('mail');
                send_mail($destinatarios, "[Las Partes] [Nueva respuesta]", $contenidoHTML, "", $fileName);


                $this->load->view('taller_en_linea/ajax/respuesta_view_ajax', $data1);
            }
        }
    }

    /**
     * Agrega una respuesta a una pregunta
     * Inicia sesión el usuario
     */
    function agregar_respuesta_ingresar() {
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
                'field' => 'id_pregunta_ingresar',
                'label' => 'identificador de la pregunta',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'respuesta_ingresar',
                'label' => 'respuesta',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_pregunta = $this->input->post('id_pregunta_ingresar', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_pregunta($id_pregunta);
            $data['titulo'] = 'Preguntas y Respuestas';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: ' . $data['pregunta']->titulo_pregunta;
            $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
            $data['navegacion_view'] = 'tallerenlinea';
            $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        } else {
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email_ingresar', TRUE));
            $contrasena = sha1($this->input->post('contrasena_ingresar', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);
            if (!$resultado) {

                $data = $this->_ver_pregunta($id_pregunta);
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $data['titulo'] = 'Preguntas y Respuestas';
                $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: ' . $data['pregunta']->titulo_pregunta;
                $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
                $data['navegacion_view'] = 'tallerenlinea';
                $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
                echo validation_errors();
                $this->load->view('template/template', $data);
            } else {
                $id_usuario = $this->session->userdata('id_usuario');

                $this->load->model('pregunta_model');
                $respuesta = $this->input->post('respuesta_ingresar', TRUE);
                $id_respuesta = $this->pregunta_model->agregar_respuesta($id_pregunta, $id_usuario, $respuesta);

                $this->load->model('indexacion_model');
                $pregunta = $this->pregunta_model->dar_pregunta($id_pregunta);
                $categoria = $this->pregunta_model->dar_pregunta_categoria($pregunta->id_pregunta_categoria);
                $respuestas = $this->pregunta_model->dar_respuestas($id_pregunta);

                $respuestas_indexacion = '';
                $emails_usuarios = "";
                foreach ($respuestas as $respuesta) {
                    $respuestas_indexacion = $respuesta->respuesta . ' ';
                    $emails_usuarios .= $respuesta->email . ",";
                }

                $indexacion = $pregunta->titulo_pregunta . ' ' . $pregunta->cuerpo_pregunta . ' ' . $categoria->nombre . ' ' . $pregunta->palabras_clave . ' ' . $respuestas_indexacion;
                $this->indexacion_model->actualizar_indexacion('taller en línea', $id_pregunta, $pregunta->titulo_pregunta, $pregunta->cuerpo_pregunta, $indexacion, 'taller_en_linea/ver_pregunta/' . $id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)), $pregunta->estado);

                $data = $this->_ver_pregunta($id_pregunta);

                // Enviar mail
                $this->load->library('email');
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co - Taller en línea');
                $tam = strlen($emails_usuarios);
                if ($tam > 0) {
                    $emails_usuarios = substr($emails_usuarios, 0, $tam - 1);
                    $this->email->bcc('tallerenlinea@laspartes.com.co,' . $data['pregunta']->email . ',' . $emails_usuarios);
                } else {
                    $this->email->bcc('tallerenlinea@laspartes.com.co,' . $data['pregunta']->email);
                }
                $this->email->subject('[Las Partes] [Nueva respuesta]');
                $this->email->message('
                    Alguien ha respondido a su pregunta. Para ver la respuesta, haga click
                    <a href="' . base_url() . 'taller_en_linea/ver_pregunta/' . $data['pregunta']->id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($data['pregunta']->titulo_pregunta)) . '">aquí</a>.
                    <br />
                    <br />
                    En caso de no poder hacer click, copie y pegue la siguiente dirección en su navegador: <br />
                    ' . base_url() . 'taller_en_linea/ver_pregunta/' . $data['pregunta']->id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($data['pregunta']->titulo_pregunta)) . '
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $data['scrollTo'] = 'respuesta-' . $id_respuesta;
                $data['titulo'] = 'Preguntas y Respuestas';
                $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: ' . $data['pregunta']->titulo_pregunta;
                $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
                $data['navegacion_view'] = 'tallerenlinea';
                $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
                $this->load->view('template/template', $data);
            }
        }
    }

    /**
     * Agrega una respuesta a una pregunta
     * Registra un nuevo usuario e inicia sesión
     */
    function agregar_respuesta_registrarse() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'nombre_registrarse',
                'label' => 'nombre_usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'apellidos_registrarse',
                'label' => 'apellidos_usuario',
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
                'field' => 'linea_registrarse',
                'label' => 'linea_registrarse',
                'rules' => 'trim|numeric|xss_clean'
            ),
            array(
                'field' => 'kilometraje_registrarse',
                'label' => 'kilometraje_registrarse',
                'rules' => 'trim|numeric|xss_clean'
            ),
            array(
                'field' => 'titulo_pregunta_registrarse',
                'label' => 'pregunta',
                'rules' => 'trim|callback__es_diferente_string[' . $titulo_pregunta_defecto . ']|required|xss_clean'
            ),
            array(
                'field' => 'cuerpo_pregunta_registrarse',
                'label' => 'detalles de la pregunta',
                'rules' => 'trim|callback__es_diferente_string[' . $cuerpo_pregunta_defecto . ']|required|xss_clean'
            ),
            array(
                'field' => 'id_pregunta_categoria_registrarse',
                'label' => 'categoria',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'palabras_clave_registrarse',
                'label' => 'palabras clave',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_pregunta = $this->input->post('id_pregunta_registrarse', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_pregunta($id_pregunta);
            $data['titulo'] = 'Preguntas y Respuestas';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: ' . $data['pregunta']->titulo_pregunta;
            $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
            $data['navegacion_view'] = 'tallerenlinea';
            $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
            echo validation_errors();
            $this->load->view('template/template', $data);
        } else {
            $this->load->model('usuario_model');
            $nombre = strtolower($this->input->post('nombre_registrarse', TRUE));
            $apellidos = strtolower($this->input->post('apellidos_registrarse', TRUE));
            $usuario = strtolower($this->input->post('usuario_registrarse', TRUE));
            $email = strtolower($this->input->post('email_registrarse', TRUE));
            $ciudad = $this->input->post('ciudad_registrarse', TRUE);
            $contrasena_simple = $this->input->post('contrasena_registrarse', TRUE);
            $contrasena = sha1($this->input->post('contrasena_registrarse', TRUE));
            $id_usuario = $this->usuario_model->agregar_usuario($nombre, $apellidos, $usuario, $email, $contrasena, $ciudad, 30);
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $usuario_sesion = array(
                'id_usuario' => $usuario->id_usuario,
                'tipo' => $usuario->tipo,
                'esta_registrado' => TRUE
            );
            $this->session->set_userdata($usuario_sesion);

            //Registra un nuevo vehículos
            $tiene_vehiculo = $this->input->post('tiene_carro_registrarse', TRUE);
            if ($tiene_vehiculo) {
                $this->_agregar_vehiculo_registro();
            }

            $this->load->model('pregunta_model');
            $id_usuario = $this->session->userdata('id_usuario');
            $respuesta = $this->input->post('respuesta_registrarse', TRUE);
            $id_respuesta = $this->pregunta_model->agregar_respuesta($id_pregunta, $id_usuario, $respuesta);

            $this->load->model('indexacion_model');
            $pregunta = $this->pregunta_model->dar_pregunta($id_pregunta);
            $categoria = $this->pregunta_model->dar_pregunta_categoria($pregunta->id_pregunta_categoria);
            $respuestas = $this->pregunta_model->dar_respuestas($id_pregunta);

            $respuestas_indexacion = '';
            $emails_usuarios = "";
            foreach ($respuestas as $respuesta) {
                $respuestas_indexacion = $respuesta->respuesta . ' ';
                $emails_usuarios .= $respuesta->email . ",";
            }

            $indexacion = $pregunta->titulo_pregunta . ' ' . $pregunta->cuerpo_pregunta . ' ' . $categoria->nombre . ' ' . $pregunta->palabras_clave . ' ' . $respuestas_indexacion;
            $this->indexacion_model->actualizar_indexacion('taller en línea', $id_pregunta, $pregunta->titulo_pregunta, $pregunta->cuerpo_pregunta, $indexacion, 'taller_en_linea/ver_pregunta/' . $id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)), $pregunta->estado);

            $data = $this->_ver_pregunta($id_pregunta);

            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co - Taller en línea');
            $tam = strlen($emails_usuarios);
            if ($tam > 0) {
                $emails_usuarios = substr($emails_usuarios, 0, $tam - 1);
                $this->email->bcc('tallerenlinea@laspartes.com.co,' . $data['pregunta']->email . ',' . $emails_usuarios);
            } else {
                $this->email->bcc('tallerenlinea@laspartes.com.co,' . $data['pregunta']->email);
            }
            $this->email->subject('[Las Partes] [Nueva respuesta]');
            $this->email->message('
                Alguien ha respondido a su pregunta. Para ver la respuesta, haga click
                <a href="' . base_url() . 'taller_en_linea/ver_pregunta/' . $data['pregunta']->id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($data['pregunta']->titulo_pregunta)) . '">aquí</a>.
                <br />
                <br />
                En caso de no poder hacer click, copie y pegue la siguiente dirección en su navegador: <br />
                ' . base_url() . 'taller_en_linea/ver_pregunta/' . $data['pregunta']->id_pregunta . '/' . str_replace(' ', '-', convert_accented_characters($data['pregunta']->titulo_pregunta)) . '
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
            ');
            $this->email->send();

            $data['scrollTo'] = 'respuesta-' . $id_respuesta;
            $data['titulo'] = 'Preguntas y Respuestas';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: ' . $data['pregunta']->titulo_pregunta;
            $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
            $data['navegacion_view'] = 'tallerenlinea';
            $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Muestra la lista de preguntas
     */
    function index() {
        $this->load->helper('text');

        $categoria;
        $pagina;
        $pagina = 1;
        if ($this->uri->segment(2)) {
            $url = uri_string();
            $urlArray = split("/", $url);
            for ($i = 2; $i < sizeof($urlArray); $i++) {
                if ($urlArray[$i] == 'categoria') {
                    $i++;
                    $categoria = $urlArray[$i];
                } elseif ($urlArray[$i] == 'pagina') {
                    $i++;
                    $pagina = $urlArray[$i] + 0;
                }
            }
        }

        $data = $this->_ver_preguntas(10, $pagina, $categoria);

        $this->load->model('generico_model');
        $data['categoriaBuscar'] = $categoria;
        if ($categoria != '') {
            $categoriaObj = $this->generico_model->dar_tildes('preguntas_categorias', 'nombre', str_replace('-', ' ', $categoria));
            $data['categoriaBuscar'] = $categoriaObj->nombre;
        }
        $this->load->model('establecimiento_model');
        $data['numero_establecimientos'] = $this->establecimiento_model->dar_num_talleres();
        $data['pagina'] = $pagina;
        $data['limit'] = 10;

        $data['metaDescripcion'] = 'Pregúntale a los talleres. Una comunidad de más de <número de talleres> aliados dispuestos a resolver tus dudas';
        $data['metaImagen'] = 'resources/images/home/preguntas.png';
        $data['titulo'] = 'Laspartes.com :: Pregúntale a los talleres';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Preguntas</div>';
        $data['header_view'] = 'taller_en_linea/header/pregunta_inicio_view';
        $data['navegacion_view'] = 'tallerenlinea';
        $data['contenido_view'] = 'taller_en_linea/pregunta_inicio_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra el formulario para hacer una pregunta
     */
    function preguntar() {
        $this->load->model('usuario_model');
        $marcas = $this->usuario_model->dar_vehiculos_marcas();

        $data = $this->_agregar_pregunta();
        $data['marcas'] = $marcas;
        $data['titulo'] = 'Preguntar';
        $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: Preguntar';
        $data['header_view'] = 'taller_en_linea/header/pregunta_agregar_view';
        $data['navegacion_view'] = 'tallerenlinea';
        $data['contenido_view'] = 'taller_en_linea/pregunta_agregar_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra los detalles de una pregunta
     */
    function ver_pregunta($id_pregunta) {
        $data = $this->_ver_pregunta($id_pregunta);
        if (sizeof($data['pregunta']) == 0 || $data['pregunta']->estado == 'No Activo') {
            $data['titulo'] = 'Página no Encontrada';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="' . base_url() . 'preguntas">Preguntas</a></div><div class="div-breadcrumb-espaciador"></div><div>Página no encontrada - Lo sentimos</div>';
            $data['header_view'] = 'error/404/header/404_view';
            $data['navegacion_view'] = 'tallerenlinea';
            $data['contenido_view'] = 'error/404/404_view';
            $this->load->view('template/template', $data);
        } else {
            $this->load->helper('captcha');

            $config = array(
                'img_path' => 'resources/images/captcha/',
                'img_url' => base_url() . 'resources/images/captcha/'
            );
            $data['captcha'] = create_captcha($config);
            $this->usuario_model->agregar_captcha(round($data['captcha']['time']), $this->input->ip_address(), $data['captcha']['word']);
            $this->load->model('establecimiento_model');
            $data['numero_establecimientos'] = $this->establecimiento_model->dar_num_talleres();
            $data['titulo'] = $data['pregunta']->titulo_pregunta;

            $data['metaKeywords'] = $data['pregunta']->palabras_clave;
            $data['metaDescripcion'] = character_limiter($data['pregunta']->cuerpo_pregunta, 150);
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="' . base_url() . 'preguntas">Preguntas</a></div><div class="div-breadcrumb-espaciador"></div><div>' . substr($data['pregunta']->titulo_pregunta, 0, 100) . '...</div>';
            $data['header_view'] = 'taller_en_linea/header/pregunta_detalle_view';
            $data['navegacion_view'] = 'tallerenlinea';
            $data['contenido_view'] = 'taller_en_linea/pregunta_detalle_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Muestra la lista de preguntas
     */
    function ver_preguntas() {
        $this->load->helper('text');
        $categoria = $this->uri->segment(3, 'todas-las-categorias');
        $orden = $this->uri->segment(4, 'recientes');
        $limit = $this->uri->segment(5, 10);
        $offset = $this->uri->segment(6, 0);
        $url = base_url() . '/taller_en_linea/ver_preguntas/' . str_replace(' ', '-', convert_accented_characters($categoria)) . '/' . str_replace(' ', '-', convert_accented_characters($orden)) . '/' . $limit;
        $data = $this->_ver_preguntas($url, $limit, $offset, $categoria, $orden);

        $this->load->model('generico_model');
        $data['categoria'] = $categoria;
        if ($categoria != 'todas-las-categorias') {
            $categoriaObj = $this->generico_model->dar_tildes('preguntas_categorias', 'nombre', str_replace('-', ' ', $categoria));
            $data['categoria'] = $categoriaObj->nombre;
        }
        $data['orden'] = $orden;
        $data['limit'] = $limit;

        $data['titulo'] = 'Preguntas';
        $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'taller_en_linea">Taller en Línea</a> :: Preguntas';
        $data['header_view'] = 'taller_en_linea/header/pregunta_lista_view';
        $data['navegacion_view'] = 'tallerenlinea';
        $data['contenido_view'] = 'taller_en_linea/pregunta_lista_view';
        $this->load->view('template/template', $data);
    }

}