<?php

require_once('/hsphere/local/home/laspartes/laspartes.com/application/controllers/laspartes_controller.php');

/**
 * Clase que maneja los usuarios
 */
class Usuario extends Laspartes_Controller {

    /**
     * Constructor de la clase Usuario
     */
    function __construct() {
        parent::__construct();
    }

    function mi_cuenta() {
        if ($this->hay_sesion_activa()) {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->helper('date');
            $this->load->model('mobile/usuario_model');
            setlocale(LC_ALL, 'es_ES');
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $vehiculos = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
            echo json_encode(array('status' => true, 'usuario' => $usuario, 'vehiculos' => $vehiculos));
        }else
            echo json_encode(array('status' => false));
    }

    //da la información de un carro expesificado
    function car_info() {
        if ($this->hay_sesion_activa()) {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->helper('date');
            $this->load->model('mobile/usuario_model');
            setlocale(LC_ALL, 'es_ES');
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $vehiculos = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
            $kilometraje_ciudad = $this->usuario_model->dar_kilometraje_ciudad($usuario->lugar);
            $tareas = array();
            $tareas = $this->_dar_tareas_vehiculo($vehiculos[0], $kilometraje_ciudad);
            echo json_encode(array('status' => true, 'usuario' => $usuario, 'vehiculos' => $vehiculos, 'tareas' => $tareas));
        }else
            echo json_encode(array('status' => false));
    }

    /**
     * función que retorna las tareas a realizar para un vehiculo dado
     * @param vehiculo $vehiculo
     * @param int $kilometraje_mensual
     * @return array tareas a realizar 
     */
    function _dar_tareas_vehiculo($vehiculo, $kilometraje_ciudad) {
        $this->load->helper('date');
        $tareas = array();
        $tareas_asignadas = array();
        $kilometraje_mensual = $kilometraje_ciudad / 12;
        $kilometraje_diario = $kilometraje_ciudad / 365;
        $kilometraje_actual = $vehiculo->kilometraje;
        if ($kilometraje_actual > 3000) {
            $tareas = $this->usuario_model->dar_tareas_vehiculo($vehiculo->id_vehiculo, $vehiculo->modelo);
            $fecha_actual = mdate("%Y-%m-%d");
            foreach ($tareas as $tarea) {
//                echo $tarea->nombre.'<br/>';
                $tarea->realizado = false;
                if ($tarea->id_servicio == 9) {
                    $fecha_SOAT = $this->usuario_model->dar_legales_SOAT($vehiculo->id_usuario_vehiculo)->ultima_fecha;
                    $id_tarea_realizada = $this->usuario_model->dar_legales_SOAT($vehiculo->id_usuario_vehiculo)->id_tarea_realizada;
                    if (isset($fecha_SOAT) && $fecha_SOAT != "" && $fecha_SOAT != null) {
                        $diff_fecha_SOAT = round((strtotime($fecha_actual) - strtotime($fecha_SOAT)) / (60 * 60 * 24));
                        if ($diff_fecha_SOAT < 0 && $diff_fecha_SOAT > -60) {
                            $porcentaje = ($diff_fecha_SOAT * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->dias_restantes = abs($diff_fecha_SOAT);
                            $tarea->mensaje_dias_restantes = "TE QUEDAN: ";
                            $tarea->mensaje_dias_restantes2 = " DÍAS";
                            $tareas_asignadas[] = $tarea;
                        } else if ($diff_fecha_SOAT < 60 && $diff_fecha_SOAT >= 0) {
                            $porcentaje = ($diff_fecha_SOAT * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                            $tareas_asignadas[] = $tarea;
                        } else if ($diff_fecha_SOAT > 60) {
                            $tarea->due = strftime("%B %d de %Y", strtotime($fecha_SOAT));
                            $tarea->realizado = true;
                            $tarea->id_tarea_realizada = $id_tarea_realizada;
                            $tareas_asignadas[] = $tarea;
                        }
                    }
                } else if ($tarea->id_servicio == 10) {
                    $fecha_Tecnomecanica = $this->usuario_model->dar_legales_Tecnomecanica($vehiculo->id_usuario_vehiculo)->ultima_fecha;
                    $id_tarea_realizada = $this->usuario_model->dar_legales_Tecnomecanica($vehiculo->id_usuario_vehiculo)->id_tarea_realizada;
                    if (isset($fecha_Tecnomecanica) && $fecha_Tecnomecanica != '' && $fecha_Tecnomecanica != null && $fecha_Tecnomecanica != '0000-00-00' && strrpos($fecha_Tecnomecanica, '0000') == false) {
                        $tarea->realizado = false;
                        $diff_fecha_tecnomecanica = round((strtotime($fecha_actual) - strtotime($fecha_Tecnomecanica)) / (60 * 60 * 24));

                        if ($diff_fecha_tecnomecanica < 0 && $diff_fecha_tecnomecanica > -60) {
                            $porcentaje = ($diff_fecha_tecnomecanica * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->dias_restantes = abs($diff_fecha_tecnomecanica);
                            $tarea->mensaje_dias_restantes = "TE QUEDAN: ";
                            $tarea->mensaje_dias_restantes2 = " DÍAS";
                            $tareas_asignadas[] = $tarea;
                        } else if ($diff_fecha_tecnomecanica < 60 && $diff_fecha_tecnomecanica >= 0) {
                            $porcentaje = ($diff_fecha_tecnomecanica * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                            $tareas_asignadas[] = $tarea;
                        } else if ($diff_fecha_tecnomecanica > 60) {
                            $tarea->due = strftime("%B %d de %Y", strtotime($fecha_Tecnomecanica));
                            $tarea->realizado = true;
                            $tarea->id_tarea_realizada = $id_tarea_realizada;
                            $tareas_asignadas[] = $tarea;
                        }
                    }
                } else {
                    $realizados = $this->usuario_model->dar_tarea_realizada_vehiculo($vehiculo->id_usuario_vehiculo, $tarea->id_servicio);
                    if (!is_bool($realizados)) {
                        $validarFecha = true;
                        foreach ($realizados as $realizado):
                            $barra_progreso = 0;
                            $periodicidad = $tarea->periodicidad;
                            $ultima_fecha = $realizado->ultima_fecha;
                            $diff = abs(strtotime($fecha_actual) - strtotime($ultima_fecha));
                            $diff_en_dias = ($diff / (60 * 60 * 24));

                            //Ajusta el mantenimiento desde la fecha que se realizo el mantenimiento 
                            if (empty($realizado->kilometraje) || $realizado->kilometraje == '')
                                $kilometros_del_mantenimiento = $kilometraje_actual - ($diff_en_dias * $kilometraje_diario); //En caso de que se tenga el kilometraje en el cual se realizó el mantenimiento hay que cambiar el $diff_en_dias*$kilometraje_diario por el kilometraje efectivo en el que se hiso
                            else
                                $kilometros_del_mantenimiento = $kilometraje_actual - ($realizado->kilometraje);

                            $kilometraje_real_ajustado = $kilometraje_actual - $kilometros_del_mantenimiento;

                            $rango_inferior = $kilometraje_real_ajustado % $periodicidad;
//                            echo $tarea->nombre.'kilometraje actual: '.$kilometraje_actual .' diferencia en dias: '.$diff_en_dias.' kilometraje en que se realizó el mantenimiento: '.round($kilometros_del_mantenimiento).' kilometraje ajustado:'.round($kilometraje_real_ajustado).'<br/>';

                            $tareaTemp = new stdClass();
                            $tareaTemp->nombre = $tarea->nombre;
                            $tareaTemp->adjunto = $realizado->adjunto;
                            $tareaTemp->id_tarea_realizada = $tarea->id_tarea_realizada;
                            $tareaTemp->due = strftime("%B %d de %Y", strtotime($realizado->ultima_fecha));
                            $tareaTemp->realizado = true;
                            $tareaTemp->id_tarea_realizada = $realizado->id_tarea_realizada;
                            $tareas_asignadas[] = $tareaTemp;

                            if ($diff_en_dias > 60 && $validarFecha) {
                                if (($kilometraje_mensual * 2) > $rango_inferior || (($periodicidad - $rango_inferior) <= $kilometraje_diario && $rango_inferior >= 0)) {
                                    $porcentaje = ($rango_inferior * 100) / (2 * $kilometraje_mensual);
                                    $barra_progreso = $porcentaje;
                                    $dias_restantes = round(($rango_inferior * 60) / ($kilometraje_mensual * 2));
                                    $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                                    $tarea->barra_progreso = $barra_progreso;
                                    $tareas_asignadas[] = $tarea;
                                } else if ($kilometraje_actual - ($periodicidad - $rango_inferior) > ($kilometraje_actual - ($kilometraje_mensual * 2))) {
                                    $porcentaje = 100 - (($periodicidad - $rango_inferior) * 100) / (2 * $kilometraje_mensual);
                                    $barra_progreso = $porcentaje;
                                    $tarea->barra_progreso = $barra_progreso;
                                    $dias_restantes = round((($periodicidad - $rango_inferior) * 60) / ($kilometraje_mensual * 2));
                                    $tarea->dias_restantes = $dias_restantes;
                                    $tarea->mensaje_dias_restantes = "TE QUEDAN: ";
                                    $tarea->mensaje_dias_restantes2 = " DÍAS";
                                    $tareas_asignadas[] = $tarea;
                                }
                            }
                            $validarFecha = false;
                        endforeach;
                    } else {
                        $barra_progreso = 0;
                        $periodicidad = $tarea->periodicidad;
                        $rango_inferior = $kilometraje_actual % $periodicidad;
                        if (($kilometraje_mensual * 2) >= $rango_inferior || (($periodicidad - $rango_inferior) <= $kilometraje_diario && $rango_inferior >= 0)) {
                            $porcentaje = ($rango_inferior * 100) / (2 * $kilometraje_mensual);
                            $barra_progreso = $porcentaje;
                            $dias_restantes = round(($rango_inferior * 60) / ($kilometraje_mensual * 2));
                            $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                            $tarea->barra_progreso = $barra_progreso;
                            $tareas_asignadas[] = $tarea;
                        } else if ($kilometraje_actual - ($periodicidad - $rango_inferior) > ($kilometraje_actual - ($kilometraje_mensual * 2))) {
                            $porcentaje = 100 - (($periodicidad - $rango_inferior) * 100) / (2 * $kilometraje_mensual);
                            $barra_progreso = $porcentaje;
                            $tarea->barra_progreso = $barra_progreso;
                            $dias_restantes = round((($periodicidad - $rango_inferior) * 60) / ($kilometraje_mensual * 2));
                            $tarea->dias_restantes = $dias_restantes;
                            $tarea->mensaje_dias_restantes = "TE QUEDAN: ";
                            $tarea->mensaje_dias_restantes2 = " DÍAS";
                            $tareas_asignadas[] = $tarea;
                        }
                    }
                }
            }
            return $tareas_asignadas;
        }
    }

    /**
     * Valida el correo electrónico y contraseña para iniciar sesión
     * @return String-bool true si es correcto el correo electrónico y contraseña
     */
    function validar_usuario_ajax() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'contrasena',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => false, 'msg' => validation_errors()));
        } else {
            $this->load->model('mobile/usuario_model');
            $email = strtolower($this->input->post('email', TRUE));
            $contrasena = sha1($this->input->post('contrasena', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena, 3);

            if (!$resultado)
                echo json_encode(array('status' => false));
            else {
                echo json_encode(array('status' => true, 'msg' => $this->session->userdata('id_usuario')));
            }
        }
    }

    /**
     * Destruye la sesión y redirecciona a la página principal
     */
    function cerrar_sesion() {
        try {
            $this->session->sess_destroy();
            echo json_encode(array('status' => true));
        } catch (Exception $e) {
            echo json_encode(array('status' => false));
        }
    }

    /**
     * Verifica si no existe un mail dado
     * @param String $email
     * @return boolean $no_existe_email true si no existe
     */
    function no_existe_email() {
        $this->load->model('mobile/usuario_model');
        $email = $this->input->post('input_login_email', TRUE);
        $existe = $this->usuario_model->existe_email($email);
        if (!$existe)
            echo json_encode(array('status' => true));
        else {
            echo json_encode(array('status' => false, 'msg' => 'El correo electrónico dado ya se encuentra registrado.'));
        }
    }

    /**
     * Carga la hoja de mto correspondiente al vehículo creado
     */
    function dar_hojamto_ajax() {
        $this->load->model('mobile/usuario_model');
        $marca = $this->input->post('marca', TRUE);
        $linea = $this->input->post('linea', TRUE);
        $modelo = $this->input->post('modelo', TRUE);
        $ciudad = $this->input->post('ciudad', TRUE);
        $kilometraje_mensual = $this->usuario_model->dar_kilometraje_ciudad($ciudad) / 12;

        $hojaMto = $this->usuario_model->dar_tareas_vehiculo($marca, $linea, $modelo);
        echo json_encode((array('hoja' => $hojaMto, 'kilometraje' => $kilometraje_mensual)));
    }

    /**
     * registra el usuario carro y hoja de mantenimiento de usuario mobil
     */
    function registrar_usuario_carro_hmto() {
        $this->load->model('mobile/usuario_model');
        $this->load->model('mobile/vehiculo_model');
        $imagen = $this->input->post('imagen', TRUE);
        $nombres = $this->input->post('nombres', TRUE);
        $apellidos = $this->input->post('apellidos', TRUE);
        $telefono = $this->input->post('telefono', TRUE);
        $ciudad = $this->input->post('ciudad', TRUE);
        $email = $this->input->post('email', TRUE);
        list($usuario, $dominio) = split('@', $email);
        $contrasena_simple = $this->input->post('contrasena', TRUE);
        $contrasena = sha1($this->input->post('contrasena', TRUE));
        $imagenCarro = $this->input->post('imagenCarro', TRUE);
        $marca = $this->input->post('marca', TRUE);
        $linea = $this->input->post('linea', TRUE);
        $modelo = $this->input->post('modelo', TRUE);
        $kilometraje = $this->input->post('kilometraje', TRUE);
        $placa = $this->input->post('placa', TRUE);
        //echo json_encode(array('status' => true, 'nombres' => $nombres, 'email' => $email, 'marca' => $marca, 'tareas_mes' => $tareas_mes));
        $usuario = $this->_generar_usuario($usuario);
        $id_usuario = $this->usuario_model->agregar_usuario($nombres, $apellidos, $usuario, $email, $contrasena, $ciudad, 30, "", "Colombia", $telefono);

        $this->load->helper('mail');
        $usuario = $this->usuario_model->dar_usuario($id_usuario);
        $resultado = $this->usuario_model->validar_usuario($usuario->email, $usuario->contrasena, 3);

        // Enviar mail
        ob_start();
        $data1['usuario'] = $usuario;
        $this->load->view('emails/registro_correo_view', $data1);
        $contenidoHTML = ob_get_contents();
        ob_end_clean();
        ob_flush();

        $destinatario = new stdClass();
        $destinatario->email = $email;
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = 'tallerenlinea@laspartes.com.co';
        $destinatarios[] = $destinatario;
        send_mail($destinatarios, "[LasPartes.com] Gracias por registrarte con nosotros", $contenidoHTML, "", $fileName);

        //creación del carro
        $vehiculo = $this->vehiculo_model->existe_vehiculo_marca_linea($marca, $linea);
        if ($vehiculo != false)
            $id_usuario_vehiculo = $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $vehiculo->id_vehiculo, '', $modelo, $kilometraje, '', $placa);
        else {
            $nuevoVehiculo = $this->vehiculo_model->agregar_vehiculo($marca, $linea);
            $id_usuario_vehiculo = $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $nuevoVehiculo, '', $modelo, $kilometraje, '', $placa);

            $destinatario = new stdClass();
            $destinatario->email = 'tallerenlinea@laspartes.com.co';
            $destinatarios[] = $destinatario;
            send_mail($destinatarios, "[LasPartes.com] Nuevo Carro", "", 'El vehiculo: ' . $marca . ' ' . $linea . ' con id_vehiculo: ' . $nuevoVehiculo . ' fue ingresada al sistema por el id_usuario: ' . $id_usuario);
        }

        //crear la hojamto del vehículo dado
        $this->load->helper('date');
        $meses = Array();
        $kilometrajes = Array();
        $id_tareas = Array();
        $inputTarea = str_replace(';', '', $this->input->post('idTarea', TRUE));
        $inputKilo = str_replace(';', '', $this->input->post('mes', TRUE));
        $inputMes = str_replace(';', '', $this->input->post('kilometrajes', TRUE));
        parse_str($inputTarea, $id_tareas);
        parse_str($inputKilo, $meses);
        parse_str($inputMes, $kilometrajes);
        $size = sizeof($id_tareas['inputHistorialIdTarea']);
        for ($i = 0; $i < $size; $i++) {
            $id_tarea = $id_tareas['inputHistorialIdTarea'][$i];
            $mes = $meses['inputHistorialMes'][$i];
            $kilometraje = $kilometrajes['inputHistorialKilometraje'][$i];
            if (!empty($kilometraje) || !empty($mes)) {
                $date = mdate("%Y-%m-%d", now());
                $newdate = strtotime('-' . $mes . ' month', strtotime($date));
                $fecha_realizado = mdate("%Y-%m-%d", $newdate);
                $this->usuario_model->registrar_tarea_realizada_vehiculo($id_usuario_vehiculo, $id_tarea, $fecha_realizado, $kilometraje);
            }
        }
        echo json_encode(array('idUsuario' => $id_usuario));
    }

    /**
     * Genera un usuario aleatorio a partir del usuario dado
     * @param type $usuario
     */
    function _generar_usuario($usuario) {
        $this->load->model('mobile/usuario_model');
        $code = md5(uniqid(rand(), true));
        $code = substr($code, 0, 5);

        $existe = $this->usuario_model->existe_usuario($usuario);
        if (!$existe)
            return $usuario;
        else
            return $this->_generar_usuario($usuario . $code);
    }

    /**
     * Sube la imagen del perfil por ajax
     */
    function subir_imagen_perfil_ajax() {
        $this->load->library('upload');
        $this->load->model('mobile/usuario_model');
        $id_usuario = $this->input->post('idUsuario');
        $upload_path = 'resources/images/usuarios/' . $id_usuario . '/';
        if (!is_dir('resources/images/usuarios/' . $id_usuario)) {
            mkdir('resources/images/usuarios/' . $id_usuario, 0777, TRUE);
        }
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size' => '10000'
        );
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $imagen = $this->upload->data();

            $img_path = 'resources/images/usuarios/' . $id_usuario . '/' . $imagen['file_name'];
            $img_thumb = 'resources/images/usuarios/' . $id_usuario . '/' . $imagen['file_name'];
            $config['image_library'] = 'gd2';
            $config['source_image'] = $img_path;
            $config['maintain_ratio'] = FALSE;
            $img = imagecreatefromjpeg($img_path);
            $_width = imagesx($img);
            $_height = imagesy($img);
            $img_type = '';
            $thumb_size = 104;

            if ($_width > $_height) {
                // wide image
                $config['width'] = intval(($_width / $_height) * $thumb_size);
                if ($config['width'] % 2 != 0) {
                    $config['width']++;
                }
                $config['height'] = $thumb_size;
                $img_type = 'wide';
            } else if ($_width < $_height) {

                // landscape image

                $config['width'] = $thumb_size;
                $config['height'] = intval(($_height / $_width) * $thumb_size);

                if ($config['height'] % 2 != 0) {
                    $config['height']++;
                }

                $img_type = 'landscape';
            } else {

                // square image
                $config['width'] = $thumb_size;
                $config['height'] = $thumb_size;
                $img_type = 'square';
            }



            $this->load->library('image_lib');

            $this->image_lib->initialize($config);

            $this->image_lib->resize();

            // reconfigure the image lib for cropping

            $conf_new = array(
                'image_library' => 'gd2',
                'source_image' => $img_thumb,
                'create_thumb' => FALSE,
                'maintain_ratio' => FALSE,
                'width' => $thumb_size,
                'height' => $thumb_size
            );

            if ($img_type == 'wide') {

                $conf_new['x_axis'] = ($config['width'] - $thumb_size) / 2;

                $conf_new['y_axis'] = 0;
            } else if ($img_type == 'landscape') {

                $conf_new['x_axis'] = 0;

                $conf_new['y_axis'] = ($config['height'] - $thumb_size) / 2;
            } else {

                $conf_new['x_axis'] = 0;

                $conf_new['y_axis'] = 0;
            }



            $this->image_lib->initialize($conf_new);

            $this->image_lib->crop();

            $this->usuario_model->actualizar_usuario_imagen_url($id_usuario, $img_path);

            echo $img_path;
        } else {
            echo $this->upload->display_errors();
        }
    }

    /**
     * Sube la la imagen al primer vehículo del usuario que tiene sesión abierta
     */
    function subir_imagen_vehiculo_ajax() {
        $this->load->library('upload');
        $this->load->model('usuario_model');
        $id_usuario = $this->input->post('idUsuario');
        $vehiculos = ($this->usuario_model->dar_vehiculos_usuario($id_usuario));
        $id_usuario_vehiculo = $vehiculos[0]->id_usuario_vehiculo;
        $upload_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/';
        if (!is_dir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo)) {
            mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo, 0777, TRUE);
        }
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size' => '10000'
        );
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $imagen = $this->upload->data();

            $img_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
            $img_thumb = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
            $config['image_library'] = 'gd2';
            $config['source_image'] = $img_path;
            $config['maintain_ratio'] = FALSE;
            $img = imagecreatefromjpeg($img_path);
            $_width = imagesx($img);
            $_height = imagesy($img);
            $img_type = '';
            $thumb_size = 177;

            if ($_width > $_height) {
                // wide image
                $config['width'] = intval(($_width / $_height) * $thumb_size);
                if ($config['width'] % 2 != 0) {
                    $config['width']++;
                }
                $config['height'] = $thumb_size;
                $img_type = 'wide';
            } else if ($_width < $_height) {
                // landscape image

                $config['width'] = $thumb_size;
                $config['height'] = intval(($_height / $_width) * $thumb_size);

                if ($config['height'] % 2 != 0) {
                    $config['height']++;
                }
                $img_type = 'landscape';
            } else {
                // square image
                $config['width'] = $thumb_size;
                $config['height'] = $thumb_size;
                $img_type = 'square';
            }



            $this->load->library('image_lib');

            $this->image_lib->initialize($config);

            $this->image_lib->resize();

            // reconfigure the image lib for cropping

            $conf_new = array(
                'image_library' => 'gd2',
                'source_image' => $img_thumb,
                'create_thumb' => FALSE,
                'maintain_ratio' => FALSE,
                'width' => $thumb_size,
                'height' => $thumb_size
            );

            if ($img_type == 'wide') {

                $conf_new['x_axis'] = ($config['width'] - $thumb_size) / 2;

                $conf_new['y_axis'] = 0;
            } else if ($img_type == 'landscape') {

                $conf_new['x_axis'] = 0;

                $conf_new['y_axis'] = ($config['height'] - $thumb_size) / 2;
            } else {

                $conf_new['x_axis'] = 0;

                $conf_new['y_axis'] = 0;
            }

            $this->image_lib->initialize($conf_new);

            $this->image_lib->crop();

            $this->usuario_model->actualizar_usuario_vehiculo_imagen_url($id_usuario_vehiculo, $img_path);

            echo $img_path;
        } else {
            echo $this->upload->display_errors();
        }
    }

    /**
     * Crea un chat en la DB
     */
    function conectar() {
        if ($this->hay_sesion_activa()) {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->model('mobile/usuario_model');
            $id_chat = $this->usuario_model->crear_chat($id_usuario);
            echo json_encode(array('status' => true, 'id_chat' => $id_chat));
        }else
            echo json_encode(array('status' => false));
    }

    /**
     * Guarda los mensajes que se generan en el chat de la app movil en la db
     */
    function guardar_mensaje(){
        $this->load->model('mobile/usuario_model');
        $id_chat = $this->input->post('id_chat', TRUE);
        $mensaje = $this->input->post('mensaje', TRUE);
        $id_usuario = $this->input->post('id_usuario', TRUE);
        $this->usuario_model->guardar_mensaje($id_chat, $mensaje, $id_usuario);
        echo json_encode(array('status' => true));
    } 
    
    /**
     * Cambia el estado de un chat
     */
    function cambiar_estado_chat(){
        $this->load->model('mobile/usuario_model');
        $id_chat = $this->input->post('id_chat', TRUE); 
        $estado = $this->input->post('estado', TRUE); 
        $this->usuario_model->cambiar_estado_chat($id_chat, $estado);
    }
    
    /**
     * Envía un correo a taller en línea pidiendo que llamen a un usuario
     */
    function llamame(){
        $this->load->model('mobile/usuario_model');
        $this->load->helper('mail');
        $id_usuario = $this->input->post('id_usuario', TRUE); 
        $numero = $this->input->post('numero', TRUE); 
        $usuario = $this->usuario_model->dar_usuario($id_usuario);
        $destinatario = new stdClass();
        $destinatario->email = "tallerenlinea@laspartes.com.co";
        $destinatarios[] = $destinatario;
        $contenidoHTML = 'El usuario <strong>'. $usuario->nombres.'</strong> requiere que lo llamen al número: <strong>'.$numero.'</strong> para recibir atención especializada.<br/>Petición solicitada vía app móvil';
        try{
            send_mail($destinatarios, '[LasPartes.com] '.$usuario->nombres." quiere que lo llamen", $contenidoHTML, "");
            echo json_encode(array('status' => true));
        }  catch (Exception $e){
            echo json_encode(array('status' => false));
        }
    }
}