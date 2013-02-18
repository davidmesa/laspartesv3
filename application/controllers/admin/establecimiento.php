<?php

/**
 * Clase que maneja los establecimientos
 */
class Establecimiento extends CI_Controller {

    /**
     * Constructor de la clase Establecimiento
     */
    function __construct() {
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');
        if (!isset($esta_registrado) || !$esta_registrado || $this->session->userdata('tipo') != 10)
            redirect(base_url() . 'admin/inicio', 'refresh');
    }

    /**
     * Información requerida para el formulario de establecimientos
     * @return array $data con $zonas y $usuarios
     */
    function _formulario_establecimiento() {
        $this->load->model('establecimiento_model');
        $this->load->model('usuario_model');
        $data['zonas'] = $this->establecimiento_model->dar_establecimientos_zonas();
        $data['usuarios'] = $this->usuario_model->dar_usuarios_tipo(20);
        $data['servicios'] = $this->establecimiento_model->dar_establecimientos_servicios();
        return $data;
    }

    /**
     * Reindexa los establecimientos asociadas a un servicio
     * @param int $id_zona
     */
    function _reindexar_servicios($id_servicio) {
        $this->load->model('indexacion_model');
        $this->load->model('establecimiento_model');
        $establecimientos = $this->establecimiento_model->dar_establecimientos_servicio($id_servicio);

        if (sizeof($establecimientos) != 0) {
            foreach ($establecimientos as $establecimiento) {
                $servicios_indexacion = '';
                $servicios = $this->establecimiento_model->dar_establecimiento_servicios($establecimiento->id_establecimiento);
                foreach ($servicios as $servicio)
                    $servicios_indexacion.= $servicio->nombre . ' ';
                $zona = $this->establecimiento_model->dar_zona($establecimiento->id_zona);
                $indexacion = $establecimiento->nombre . ' ' . $establecimiento->email . ' ' . $establecimiento->direccion . ' ' . $establecimiento->web . ' ' . $establecimiento->descripcion . ' ' . $establecimiento->horario . ' ' . $zona->nombre . ' ' . $servicios_indexacion;
                $this->indexacion_model->actualizar_indexacion('establecimientos', $establecimiento->id_establecimiento, $establecimiento->nombre, $establecimiento->descripcion, $indexacion, 'establecimientos/ver_establecimiento/' . $establecimiento->id_establecimiento . '/' . str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)), $establecimiento->estado);
            }
        }
    }

    /**
     * Reindexa los establecimientos asociadas a una zona
     * @param int $id_zona
     */
    function _reindexar_zonas($id_zona) {
        $this->load->model('indexacion_model');
        $this->load->model('establecimiento_model');
        $establecimientos = $this->establecimiento_model->dar_establecimientos_zona($id_zona);

        if (sizeof($establecimientos) != 0) {
            foreach ($establecimientos as $establecimiento) {
                $servicios_indexacion = '';
                $servicios = $this->establecimiento_model->dar_establecimiento_servicios($establecimiento->id_establecimiento);
                foreach ($servicios as $servicio)
                    $servicios_indexacion.= $servicio->nombre . ' ';
                $zona = $this->establecimiento_model->dar_zona($establecimiento->id_zona);
                $indexacion = $establecimiento->nombre . ' ' . $establecimiento->email . ' ' . $establecimiento->direccion . ' ' . $establecimiento->web . ' ' . $establecimiento->descripcion . ' ' . $establecimiento->horario . ' ' . $zona->nombre . ' ' . $servicios_indexacion;
                $this->indexacion_model->actualizar_indexacion('establecimientos', $establecimiento->id_establecimiento, $establecimiento->nombre, $establecimiento->descripcion, $indexacion, 'establecimientos/ver_establecimiento/' . $establecimiento->id_establecimiento . '/' . str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)), $establecimiento->estado);
            }
        }
    }

    /**
     * Da detalles de un establecimiento
     * @param int $id_establecimiento
     * @return array con $establecimiento y $zonas
     */
    function _ver_establecimiento($id_establecimiento) {
        $this->load->model('establecimiento_model');
        $this->load->model('usuario_model');
        $data['establecimiento'] = $this->establecimiento_model->dar_establecimiento($id_establecimiento);
        $data['usuarios'] = $this->usuario_model->dar_usuarios_tipo(20);
        $data['zonas'] = $this->establecimiento_model->dar_establecimientos_zonas();
        $data['establecimiento_servicios'] = $this->establecimiento_model->dar_establecimiento_servicios($id_establecimiento);
        $data['servicios'] = $this->establecimiento_model->dar_establecimientos_servicios();
        $data['establecimiento_imagenes'] = $this->establecimiento_model->dar_establecimiento_imagenes($id_establecimiento);
        return $data;
    }

    /**
     * Da la relación autopartes-establecimiento
     * @param int $id_establecimiento
     * @return array con $autopartes y $establecimiento_autopartes
     */
    function _ver_establecimiento_autopartes($id_establecimiento) {
        $this->load->model('autoparte_model');
        $this->load->model('establecimiento_model');
        $this->load->model('vehiculo_model');
        $data['autopartes'] = $this->autoparte_model->dar_autopartes();
        $data['autopartes_vehiculos'] = $this->autoparte_model->dar_autopartes_vehiculos();
        $data['establecimiento_autopartes'] = $this->establecimiento_model->dar_establecimiento_autopartes($id_establecimiento);
        $data['categorias'] = $this->autoparte_model->dar_autopartes_categorias();
        $data['marcas'] = $this->autoparte_model->dar_autopartes_marcas();
        $data['vehiculos'] = $this->vehiculo_model->dar_vehiculos();
        return $data;
    }

    /**
     * Da la relación oferta-establecimiento
     * @param int $id_establecimiento
     * @return array con $ofertas y $establecimiento_ofertas
     */
    function _ver_establecimiento_ofertas($id_establecimiento) {
        $this->load->model('establecimiento_model');
        $data['id_establecimineto'] = $id_establecimiento;
        $ofertas = $this->establecimiento_model->dar_establecimiento_ofertas($id_establecimiento);
        $data['establecimiento_ofertas'] = $ofertas;
        $index = 0;
        foreach ($ofertas as $oferta) {
            $data['tituloOferta'][$index]->label = $oferta->titulo;
            $data['tituloOferta'][$index]->value = $oferta->titulo;
            $data['tituloOferta'][$index]->id = $oferta->id_oferta;
            $index++;
        }
        return $data;
    }

    /**
     * Da la lista de establecimientos
     * @return array $establecimientos
     */
    function _ver_establecimientos() {
        $this->load->model('establecimiento_model');
        $data['establecimientos'] = $this->establecimiento_model->dar_establecimientos();
        $index = 0;
        foreach ($data['establecimientos'] as $establecimiento) {
            $data['nombreEstablecimiento'][$index]->label = $establecimiento->nombre;
            $data['nombreEstablecimiento'][$index]->value = $establecimiento->nombre;
            $data['nombreEstablecimiento'][$index]->id = $establecimiento->id_establecimiento;
            $index++;
            $data['nombreEstablecimiento'][$index]->label = $establecimiento->email;
            $data['nombreEstablecimiento'][$index]->value = $establecimiento->nombre;
            $data['nombreEstablecimiento'][$index]->id = $establecimiento->id_establecimiento;
            $index++;
        }
        return $data;
    }

    /**
     * Da detalles de un servicio
     * @param int $id_servicio
     * @return array $servicio
     */
    function _ver_servicio($id_servicio) {
        $this->load->model('establecimiento_model');
        $data['servicio'] = $this->establecimiento_model->dar_servicio($id_servicio);
        return $data;
    }

    /**
     * Da la lista de servicios
     * @return array $servicios
     */
    function _ver_servicios() {
        $this->load->model('establecimiento_model');
        $data['servicios'] = $this->establecimiento_model->dar_establecimientos_servicios();
        return $data;
    }

    /**
     * Da detalles de una oferta
     * @param int $id_zona
     * @return array $zona
     */
    function _ver_oferta($id_oferta, $id_establecimiento) {
        $this->load->helper('date');
        $this->load->model('establecimiento_model');
        $this->load->model('generico_model');
        $this->load->model('vehiculo_model');
        $data['id_establecimiento'] = $id_establecimiento;
        $data['oferta'] = $this->establecimiento_model->dar_oferta($id_oferta);
        $data['vehiculos'] = $this->vehiculo_model->dar_vehiculos();

        //ofertas por tarea MTO-------------------------------------------------------------------------------
        $temp_where[] = 'id_oferta';
        $temp_where[] = $id_oferta;
        $where[] = $temp_where;
        $select[] = 'id_servicios_categoria';
        $id_categorias = $this->generico_model->dar_registros_genericos('establecimientos_ofertas', $select, $where, null, 'id_servicios_categoria');
        $categorias = $this->generico_model->dar_registros('servicios_categoria');
        $temp_categorias = array();
        foreach ($categorias as $categoria):

            $var = $categoria->id_servicios_categoria;
            $var .= "-" . $categoria->nombre;
            $bool = '';
            foreach ($id_categorias as $id_categoria):
                if ($id_categoria->id_servicios_categoria == $categoria->id_servicios_categoria) {
                    $bool = '-checked';
                }
            endforeach;
            $var.=$bool;
            $temp_categorias[] = $var;
        endforeach;

        $temp_where[] = 'id_oferta';
        $temp_where[] = $id_oferta;
        $where[] = $temp_where;
        $temp_select1[] = 'distinct(id_vehiculo)';
        $select1[] = $temp_select1;
        $carros = $this->generico_model->dar_registros_genericos('establecimientos_ofertas', $select1, $where, null, null);

        foreach ($carros as $vehiculos) {
            $autos[] = $this->vehiculo_model->dar_vehiculo($vehiculos->id_vehiculo);
        }
        $data['autos'] = $autos;
        $data['categorias'] = $temp_categorias;

        //        despliega los vehículos        
        $data['autopartes_autocomplete'] = json_encode($data['autopartes_autocomplete']);
        $data['autopartes_vehiculos_json'] = json_encode($data['autopartes_vehiculos']);
        $index = 0;
        foreach ($data['autopartes_vehiculos'] as $vehiculo) {
            $data['autopartes_vehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
            $data['autopartes_vehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
            $index++;
        }

        $index = 0;
        foreach ($data['vehiculos'] as $vehiculo) {
            $data['vehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
            $data['vehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
            $index++;
        }
//            --------------------------------
        //ofertas por automovil--------------------------------------------------------
//        $select_automovil[] = 'id_vehiculo';
//        $id_vehiculos = $this->generico_model->dar_registros_genericos('establecimientos_ofertas', $select_automovil, $where);
//        $autos = $this->generico_model->dar_registros('vehiculos');
//        $temp_autos = array();
//        foreach ($autos as $auto):
//            $var = $auto->id_vehiculo;
//            $var .= "-".$auto->marca;
//            $var .= "-".$auto->linea;
//            $bool = '';
//            foreach ($id_vehiculos as $id_vehiculo):
//                if($id_vehiculo->id_vehiculo == $auto->id_vehiculo){
//                    $bool = '-checked';
//                }
//            endforeach;
//            $var.=$bool;
//            $temp_autos[] = $var;
//        endforeach;
//        $data['autos'] = $temp_autos;


        return $data;
    }

    /**
     * Da la lista de las ofertas
     * @return array $ofertas
     */
    function _ver_ofertas($establecimiento) {
        $this->load->model('establecimiento_model');
        $data['establecimiento_ofertas'] = $this->establecimiento_model->dar_establecimiento_ofertas($establecimiento);
        return $data;
    }

    /**
     * Da detalles de una zona
     * @param int $id_zona
     * @return array $zona
     */
    function _ver_zona($id_zona) {
        $this->load->model('establecimiento_model');
        $data['zona'] = $this->establecimiento_model->dar_zona($id_zona);
        return $data;
    }

    /**
     * Da la lista de zonas
     * @return array $zonas
     */
    function _ver_zonas() {
        $this->load->model('establecimiento_model');
        $data['zonas'] = $this->establecimiento_model->dar_establecimientos_zonas();
        return $data;
    }

    /**
     * Actualiza un establecimiento
     */
    function actualizar_establecimiento() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_establecimiento',
                'label' => 'identificador del establecimiento',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_zona',
                'label' => 'identificador de la zona',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_usuario',
                'label' => 'identificador del usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|valid_email|xss_clean'
            ),
            array(
                'field' => 'direccion',
                'label' => 'dirección',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'web',
                'label' => 'web',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'logo',
                'label' => 'logo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'telefonos',
                'label' => 'teléfonos',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'faxes',
                'label' => 'faxes',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'horario',
                'label' => 'horario',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'lat',
                'label' => 'latitud',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'lng',
                'label' => 'longitud',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_establecimiento = $this->input->post('id_establecimiento', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_establecimiento($id_establecimiento);
            $this->load->view('admin/establecimiento/establecimiento_detalle_view', $data);
        } else {
            $this->load->model('establecimiento_model');
            $id_zona = $this->input->post('id_zona', TRUE);
            $id_usuario = $this->input->post('id_usuario', TRUE);
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $descripcion = $this->input->post('descripcion', TRUE);
            $estado = $this->input->post('estado', TRUE);
            $email = strtolower($this->input->post('email', TRUE));
            $direccion = $this->input->post('direccion', TRUE);
            $web = strtolower($this->input->post('web', TRUE));
            $telefonos = $this->input->post('telefonos', TRUE);
            $faxes = $this->input->post('faxes', TRUE);
            $horario = $this->input->post('horario', TRUE);
            $lat = $this->input->post('lat', TRUE);
            if ($lat == '')
                $lat = NULL;
            $lng = $this->input->post('lng', TRUE);
            if ($lng == '')
                $lng = NULL;
            $this->establecimiento_model->actualizar_establecimiento($id_establecimiento, $id_zona, $id_usuario, $nombre, $estado, $email, $direccion, $web, $telefonos, $faxes, $horario, $lat, $lng, $descripcion);

            $this->load->library('upload');
            if (!is_dir('./resources/images/establecimientos/' . $id_establecimiento)) {
                mkdir('./resources/images/establecimientos/' . $id_establecimiento, 0777, TRUE);
                mkdir('./resources/images/establecimientos/' . $id_establecimiento . '/thumb', 0777, TRUE);
            }

            $config = array(
                'upload_path' => './resources/images/establecimientos/' . $id_establecimiento,
                'allowed_types' => '*',
                'file_name' => $nombre,
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo')) {

                $logo = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $logo['full_path'],
                    'quality' => '100%',
                    'new_image' => './resources/images/establecimientos/' . $id_establecimiento . '/thumb',
                    'width' => 190,
                    'height' => 125,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $logo_url = 'resources/images/establecimientos/' . $id_establecimiento . '/' . $logo['file_name'];
                $logo_thumb_url = 'resources/images/establecimientos/' . $id_establecimiento . '/thumb/' . $logo['file_name'];
                $this->establecimiento_model->actualizar_establecimiento_logo_url($id_establecimiento, $logo_url, $logo_thumb_url);
            }

            // Indexa para búsquedas
            $this->load->model('indexacion_model');
            $servicios_indexacion = '';
            $servicios = $this->establecimiento_model->dar_establecimiento_servicios($id_establecimiento);
            foreach ($servicios as $servicio)
                $servicios_indexacion.= $servicio->nombre . ' ';
            $zona = $this->establecimiento_model->dar_zona($id_zona);
            $indexacion = $nombre . ' ' . $email . ' ' . $direccion . ' ' . $web . ' ' . $descripcion . ' ' . $horario . ' ' . $zona->nombre . ' ' . $servicios_indexacion;
            $this->indexacion_model->actualizar_indexacion('establecimientos', $id_establecimiento, $nombre, $descripcion, $indexacion, 'establecimientos/ver_establecimiento/' . $id_establecimiento . '/' . str_replace(' ', '-', convert_accented_characters($nombre)), $estado);

            $data = $this->_ver_establecimientos();
            $data['confirmacion'] = 'El establecimiento ha sido actualizado con éxito';
            $this->load->view('admin/establecimiento/establecimiento_lista_view', $data);
        }
    }

    /**
     * Actualiza una relación establecimiento-autoparte.
     * Devuelve true si la operación se realizó con éxito, false de lo contrario.
     */
    function ajax_actualizar_establecimiento_autoparte() {
        $id_autoparte = $this->input->post('id_autoparte', TRUE);
        $id_establecimiento = $this->input->post('id_establecimiento', TRUE);
        $precio = $this->input->post('precio', TRUE);
        $agregar = $this->input->post('agregar', TRUE);

        if (!isset($precio) || !is_numeric($precio) || $precio < 0)
            $precio = 0;

        if (isset($id_autoparte) && isset($id_establecimiento) && isset($agregar) &&
                is_numeric($id_autoparte) && is_numeric($id_establecimiento) &&
                $id_autoparte > 0 && $id_establecimiento > 0) {
            $this->load->model('establecimiento_model');
            if ($agregar == "true")
                $this->establecimiento_model->agregar_establecimiento_autoparte($id_establecimiento, $id_autoparte, $precio);
            else
                $this->establecimiento_model->eliminar_establecimiento_autoparte($id_establecimiento, $id_autoparte);
            echo "true";
        }
        else {
            echo "false";
        }
    }

    /**
     * Actualiza el precio de una relacion establecimiento-autoparte.
     * Devuelve true si la operación se realizó con éxito, false de lo contrario.
     */
    function ajax_actualizar_precio_establecimiento_autoparte() {
        $id_autoparte = $this->input->post('id_autoparte', TRUE);
        $id_establecimiento = $this->input->post('id_establecimiento', TRUE);
        $precio = $this->input->post('precio', TRUE);

        if (isset($id_autoparte) && isset($id_establecimiento) && isset($precio) &&
                is_numeric($id_autoparte) && is_numeric($id_establecimiento) && is_numeric($precio) &&
                $id_autoparte > 0 && $id_establecimiento > 0 && $precio >= 0) {
            $this->load->model('establecimiento_model');
            $this->establecimiento_model->agregar_establecimiento_autoparte($id_establecimiento, $id_autoparte, $precio);
            echo "true";
        } else {
            echo "false";
        }
    }

    /**
     * Actualiza la relaciones establecimiento-autopartes
     */
    function actualizar_establecimiento_autopartes() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_autopartes[]',
                'label' => 'identificador de las autopartes',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'id_establecimiento',
                'label' => 'identificador del establecimiento',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $id_autopartes = $this->input->post('id_autopartes', TRUE);
        if (is_array($id_autopartes) && sizeof($id_autopartes) != 0) {
            foreach ($id_autopartes as $id_autoparte) {
                $precio = array(
                    'field' => 'precio_' . $id_autoparte,
                    'label' => 'precio',
                    'rules' => 'trim|numeric|required|xss_clean'
                );
                array_push($reglas, $precio);
            }
        }
        $this->form_validation->set_rules($reglas);

        $id_establecimiento = $this->input->post('id_establecimiento', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_establecimiento_autopartes($id_establecimiento);
            $data['id_establecimiento'] = $id_establecimiento;
            $this->load->view('admin/establecimiento/establecimiento_autopartes_view', $data);
        } else {
            $this->load->model('establecimiento_model');
            $this->establecimiento_model->eliminar_establecimiento_autopartes($id_establecimiento);
            if (is_array($id_autopartes) && sizeof($id_autopartes) != 0) {
                foreach ($id_autopartes as $id_autoparte) {
                    $precio = $this->input->post('precio_' . $id_autoparte, TRUE);
                    $this->establecimiento_model->agregar_establecimiento_autoparte($id_establecimiento, $id_autoparte, $precio);
                }
            }
            $data = $this->_ver_establecimientos();
            $data['confirmacion'] = 'Las relaciones establecimiento-autopartes ha sido actualizada con éxito.';
            $this->load->view('admin/establecimiento/establecimiento_lista_view', $data);
        }
    }

    /**
     * Actualiza la relaciones establecimiento-servicios
     */
    function actualizar_establecimiento_servicios() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_servicios[]',
                'label' => 'identificador de los servicios',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'id_establecimiento',
                'label' => 'identificador del establecimiento',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_establecimiento = $this->input->post('id_establecimiento', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_establecimiento($id_establecimiento);
            $this->load->view('admin/establecimiento/establecimiento_detalle_view', $data);
        } else {
            $this->load->model('establecimiento_model');
            $id_servicios = $this->input->post('id_servicios', TRUE);
            $this->establecimiento_model->eliminar_establecimiento_servicios($id_establecimiento);
            if (is_array($id_servicios) && sizeof($id_servicios) != 0) {
                foreach ($id_servicios as $id_servicio)
                    $this->establecimiento_model->agregar_establecimiento_servicio($id_establecimiento, $id_servicio);
            }

            // Indexa para búsquedas
            $this->load->model('indexacion_model');
            $establecimiento = $this->establecimiento_model->dar_establecimiento($id_establecimiento);
            $servicios_indexacion = '';
            $servicios = $this->establecimiento_model->dar_establecimiento_servicios($id_establecimiento);
            foreach ($servicios as $servicio)
                $servicios_indexacion.= $servicio->nombre . ' ';
            $zona = $this->establecimiento_model->dar_zona($establecimiento->id_zona);
            $indexacion = $establecimiento->nombre . ' ' . $establecimiento->email . ' ' . $establecimiento->direccion . ' ' . $establecimiento->web . ' ' . $establecimiento->descripcion . ' ' . $establecimiento->horario . ' ' . $zona->nombre . ' ' . $servicios_indexacion;
            $this->indexacion_model->actualizar_indexacion('establecimientos', $id_establecimiento, $establecimiento->nombre, $establecimiento->descripcion, $indexacion, 'establecimientos/ver_establecimiento/' . $id_establecimiento . '/' . str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)), $establecimiento->estado);

            $data = $this->_ver_establecimientos();
            $data['confirmacion'] = 'Las relaciones establecimiento-servicio ha sido actualizada con éxito.';
            $this->load->view('admin/establecimiento/establecimiento_lista_view', $data);
        }
    }

    /**
     * Actualiza un servicio
     */
    function actualizar_servicio() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_servicio',
                'label' => 'identificador del servicio',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_servicio = $this->input->post('id_servicio', TRUE);
        if (!$this->form_validation->run())
            $this->load->view('admin/establecimiento/servicio_detalle_view');
        else {
            $this->load->model('establecimiento_model');
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $this->establecimiento_model->actualizar_servicio($id_servicio, $nombre);
            $this->_reindexar_servicios($id_servicio);

            $data = $this->_ver_servicios();
            $data['confirmacion'] = 'El servicio ha sido actualizado con éxito';
            $this->load->view('admin/establecimiento/servicio_lista_view', $data);
        }
    }

    /**
     * Actualiza una zona
     */
    function actualizar_zona() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_zona',
                'label' => 'identificador de la zona',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'ciudad',
                'label' => 'ciudad',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_zona = $this->input->post('id_zona', TRUE);
        if (!$this->form_validation->run())
            $this->load->view('admin/establecimiento/zona_detalle_view');
        else {
            $this->load->model('establecimiento_model');
            $id_zona = $this->input->post('id_zona', TRUE);
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $ciudad = ucwords(strtolower($this->input->post('ciudad', TRUE)));
            $this->establecimiento_model->actualizar_zona($id_zona, $ciudad, $nombre);
            $this->_reindexar_zonas($id_zona);

            $data = $this->_ver_zonas();
            $data['confirmacion'] = 'La zona ha sido actualizado con éxito';
            $this->load->view('admin/establecimiento/zona_lista_view', $data);
        }
    }

    /**
     * Agregar un establecimiento
     */
    function agregar_establecimiento() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_usuario',
                'label' => 'identificador del usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_zona',
                'label' => 'identificador de la zona',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|valid_email|xss_clean'
            ),
            array(
                'field' => 'descripcion',
                'label' => 'descripcion',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'direccion',
                'label' => 'dirección',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'web',
                'label' => 'web',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'logo',
                'label' => 'logo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'telefonos',
                'label' => 'teléfonos',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'faxes',
                'label' => 'faxes',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'horario',
                'label' => 'horario',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'lat',
                'label' => 'latitud',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'lng',
                'label' => 'longitud',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'id_servicios[]',
                'label' => 'identificadores de los servicios',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $data = $this->_formulario_establecimiento();
            $this->load->view('admin/establecimiento/establecimiento_agregar_view', $data);
        } else {
            $this->load->model('establecimiento_model');

            // Agrega la información básica
            $id_usuario = $this->input->post('id_usuario', TRUE);
            $id_zona = $this->input->post('id_zona', TRUE);
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $descripcion = $this->input->post('descripcion', TRUE);
            $estado = $this->input->post('estado', TRUE);
            $email = strtolower($this->input->post('email', TRUE));
            $direccion = $this->input->post('direccion', TRUE);
            $web = strtolower($this->input->post('web', TRUE));
            $telefonos = $this->input->post('telefonos', TRUE);
            $faxes = $this->input->post('faxes', TRUE);
            $horario = ucwords(strtolower($this->input->post('horario', TRUE)));
            $lat = $this->input->post('lat', TRUE);
            if ($lat == '')
                $lat = NULL;
            $lng = $this->input->post('lng', TRUE);
            if ($lng == '')
                $lng = NULL;
            $id_establecimiento = $this->establecimiento_model->agregar_establecimiento($id_usuario, $id_zona, $nombre, $estado, $email, $descripcion, $direccion, $web, $telefonos, $faxes, $horario, $lat, $lng);

            // Registra los servicios ofrecidos
            $id_servicios = $this->input->post('id_servicios', TRUE);
            if (is_array($id_servicios) && sizeof($id_servicios) != 0) {
                foreach ($id_servicios as $id_servicio)
                    $this->establecimiento_model->agregar_establecimiento_servicio($id_establecimiento, $id_servicio);
            }

            // Sube el logo
            $this->load->library('upload');
            if (!is_dir('./resources/images/establecimientos/' . $id_establecimiento)) {
                mkdir('./resources/images/establecimientos/' . $id_establecimiento, 0777, TRUE);
                mkdir('./resources/images/establecimientos/' . $id_establecimiento . '/thumb', 0777, TRUE);
            }

            $config = array(
                'upload_path' => './resources/images/establecimientos/' . $id_establecimiento,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'file_name' => $nombre,
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload('logo')) {
                $logo = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $logo['full_path'],
                    'quality' => '100%',
                    'new_image' => './resources/images/establecimientos/' . $id_establecimiento . '/thumb',
                    'width' => 190,
                    'height' => 125,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $logo_url = 'resources/images/establecimientos/' . $id_establecimiento . '/' . $logo['file_name'];
                $logo_thumb_url = 'resources/images/establecimientos/' . $id_establecimiento . '/thumb/' . $logo['file_name'];
                $this->establecimiento_model->actualizar_establecimiento_logo_url($id_establecimiento, $logo_url, $logo_thumb_url);
            }

            // Agrega las imágenes
            for ($numero_imagen = 1; $numero_imagen < 4; $numero_imagen++) {
                $config = array(
                    'upload_path' => './resources/images/establecimientos/' . $id_establecimiento,
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'file_name' => 'imagen',
                    'max_size' => '10000'
                );
                $this->upload->initialize($config);

                if ($this->upload->do_upload('imagen_' . $numero_imagen)) {
                    $imagen = $this->upload->data();

                    $this->load->library('image_lib');
                    $config = array(
                        'source_image' => $imagen['full_path'],
                        'quality' => '100%',
                        'new_image' => './resources/images/establecimientos/' . $id_establecimiento . '/thumb',
                        'width' => 99,
                        'height' => 99,
                        'master_dim' => 'width'
                    );
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $imagen_url = 'resources/images/establecimientos/' . $id_establecimiento . '/' . $imagen['file_name'];
                    $imagen_thumb_url = 'resources/images/establecimientos/' . $id_establecimiento . '/thumb/' . $imagen['file_name'];
                    $this->establecimiento_model->agregar_establecimiento_imagen($id_establecimiento, $imagen_url, $imagen_thumb_url);
                }
            }

            //envía correo de bienvenida
            $this->load->helper('mail');
            $mensajeHTML = ('
                            Bienvenido a <a style="text-decoration: none; color: red;" href="' . base_url() . '">Laspartes.com</a>.
                            <br /> <br /> 
                            Es un gusto para nosotros contar con su presencia dentro de la única comunidad virtual de autopartes en Colombia.
                            <br />
                            Cualquier duda, queja o comentario, con gusto la atenderemos por medio de esta dirección de correo electrónico soporte@laspartes.com.co<br />
                            <br /> 
                            <br />
                            Cordialmente,<br />
                            -------------------------------------------------------<br />
                            Servicio al cliente<br />
                            <a style="text-decoration: none; color: red;" href="' . base_url() . '">Laspartes.com</a> - Todo para su vehículo
                    ');

            ob_start();
            $this->load->helper('date');
            $this->load->model('tip_model');
            $this->load->model('pregunta_model');
            $tips = $this->tip_model->dar_tips_ultimos(3);
            $preguntas = $this->pregunta_model->dar_preguntas_ultimas(3);
            $data1['tip'] = $tips;
            $data1['preguntas'] = $preguntas;
            $data1['fecha'] = strftime("%B %d de %Y");
            $data1['html'] = $mensajeHTML;
            $this->load->view('template/correo_generico_HTML', $data1);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();

            $destinatario = new stdClass();
            $destinatario->email = $email;
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = 'tallerenlinea@laspartes';
            $destinatarios[] = $destinatario;
            send_mail($destinatarios, "[LasPartes.com] Gracias por registrarse con nosotros", $contenidoHTML, "", $fileName);





            // Indexa para búsquedas
            $this->load->model('indexacion_model');
            $servicios_indexacion = '';
            $servicios = $this->establecimiento_model->dar_establecimiento_servicios($id_establecimiento);
            foreach ($servicios as $servicio)
                $servicios_indexacion.= $servicio->nombre . ' ';
            $zona = $this->establecimiento_model->dar_zona($id_zona);
            $indexacion = $nombre . ' ' . $email . ' ' . $direccion . ' ' . $web . ' ' . $descripcion . ' ' . $horario . ' ' . $zona->nombre . ' ' . $servicios_indexacion;
            $this->indexacion_model->agregar_indexacion('establecimientos', $id_establecimiento, $nombre, $descripcion, $indexacion, 'establecimientos/ver_establecimiento/' . $id_establecimiento . '/' . str_replace(' ', '-', convert_accented_characters($nombre)), $estado);

            $data = $this->_ver_establecimientos();
            $data['confirmacion'] = 'El establecimiento ha sido agregado con éxito';
            $this->load->view('admin/establecimiento/establecimiento_lista_view', $data);
        }
    }

    /**
     * Agrega una autoparte y la asocia a un establecimiento o
     * actualiza en precio de una autoparte y la asocia a un establecimiento
     */
    function agregar_establecimiento_autoparte() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_establecimiento',
                'label' => 'identificador del establecimiento',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|min_length[2]|max_length[256]|xss_clean'
            ),
            array(
                'field' => 'id_autoparte_marca',
                'label' => 'marca',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_autoparte_categoria',
                'label' => 'categoría',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'descripcion',
                'label' => 'descripción',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'imagen_url',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'origen',
                'label' => 'origen',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'referencia',
                'label' => 'referencia',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'id_vehiculos[]',
                'label' => 'vehículos de la autoparte',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'precio',
                'label' => 'precio',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $this->load->model('autoparte_model');
        $this->load->model('establecimiento_model');
        $this->load->model('vehiculo_model');
        $id_establecimiento = $this->input->post('id_establecimiento', TRUE);
        if (!$this->form_validation->run()) {
            
        } else {
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $id_autoparte_marca = $this->input->post('id_autoparte_marca', TRUE);
            $id_autoparte_categoria = $this->input->post('id_autoparte_categoria', TRUE);
            $descripcion = nl2br($this->input->post('descripcion', TRUE));
            $origen = ucwords(strtolower($this->input->post('origen', TRUE)));
            $referencia = ucwords(strtolower($this->input->post('referencia', TRUE)));
            $estado = $this->input->post('estado', TRUE);
            $precio = $this->input->post('precio', TRUE);
            $id_vehiculos = $this->input->post('id_vehiculos', TRUE);

            // Validación si existe una autoparte igual
            $autopartes = $this->autoparte_model->dar_autoparte_ids($nombre, $id_autoparte_marca, $id_autoparte_categoria, $descripcion, $origen, $referencia);
            if (sizeof($autopartes) != 0) {
                // Validación si existe la autoparte con los mismos vehículos
                foreach ($autopartes as $autoparte) {
                    $existe_vehiculo_seleccionado_y_BD = true;
                    $existe_vehiculo_BD_y_seleccionado = true;

                    $vehiculos = $this->autoparte_model->dar_autoparte_vehiculos($autoparte->id_autoparte);
                    if (is_array($vehiculos)) {
                        foreach ($vehiculos as $vehiculo) {
                            $vehiculo_actual_existe = false;
                            foreach ($id_vehiculos as $id_vehiculo) {
                                if ($id_vehiculo == $vehiculo->id_vehiculo)
                                    $vehiculo_actual_existe = true;
                            }
                            // Si no se encontró un vehículo en la BD, entonces es una autoparte nueva
                            if (!$vehiculo_actual_existe) {
                                $existe_vehiculo_BD_y_seleccionado = false;
                                break;
                            }
                        }
                    }

                    // Comprueba los vehículos seleccionados frente a los de la BD
                    // Es decir "del mismo modo, pero en sentido contrario"
                    if (is_array($id_vehiculos)) {
                        foreach ($id_vehiculos as $id_vehiculo) {
                            $vehiculo_actual_existe = false;
                            foreach ($vehiculos as $vehiculo) {
                                if ($id_vehiculo == $vehiculo->id_vehiculo)
                                    $vehiculo_actual_existe = true;
                            }

                            // Si no se encontró un vehículo seleccionado, entonces es una autoparte nueva
                            if (!$vehiculo_actual_existe) {
                                $existe_vehiculo_seleccionado_y_BD = false;
                                break;
                            }
                        }
                    }

                    // Como si fuera poco, verifiquemos que no existe una relación autoparte-establecimiento
                    $esta_asociado = $this->establecimiento_model->esta_asociado_establecimiento_autoparte($id_establecimiento, $autoparte->id_autoparte);
                    if ($esta_asociado) {
                        $this->establecimiento_model->agregar_establecimiento_autoparte($id_establecimiento, $autoparte->id_autoparte, $precio);
                        $data = $this->_ver_establecimientos();
                        $data['confirmacion'] = 'El precio de la autoparte ha sido actualizado con éxito';
                        $this->load->view('admin/establecimiento/establecimiento_lista_view', $data);
                    }

                    // Asociar la autoparte al establecimiento
                    else if ($existe_vehiculo_BD_y_seleccionado && $existe_vehiculo_seleccionado_y_BD) {
                        echo 'Caso autopartes descriptiva encontradas y asociada';
                        $this->establecimiento_model->agregar_establecimiento_autoparte($id_establecimiento, $autoparte->id_autoparte, $precio);
                        $data = $this->_ver_establecimientos();
                        $data['confirmacion'] = 'La autoparte ha sido asociada al establecimiento con éxito';
                        $this->load->view('admin/establecimiento/establecimiento_lista_view', $data);
                    }
                    // Agregar una nueva autoparte
                    else {
                        echo 'Caso autopartes descriptiva encontradas y vehículos diferentes';
                        $id_autoparte = $this->autoparte_model->agregar_autoparte($nombre, $id_autoparte_marca, $id_autoparte_categoria, $descripcion, $origen, $referencia, $estado);
                        if (is_array($id_vehiculos) && sizeof($id_vehiculos) != 0) {
                            foreach ($id_vehiculos as $id_vehiculo)
                                $this->autoparte_model->agregar_autoparte_vehiculo($id_autoparte, $id_vehiculo);
                        }
                        $this->establecimiento_model->agregar_establecimiento_autoparte($id_establecimiento, $id_autoparte, $precio);
                        $data = $this->_ver_establecimientos();
                        $data['confirmacion'] = 'Una nueva autoparte ha sido agregada y asociada al establecimiento con éxito';
                        $this->load->view('admin/establecimiento/establecimiento_lista_view', $data);
                    }
                }
            }

            // No existe ninguna autoparte, entonces en una autoparte nueva
            else {
                echo 'Caso no encontró autopartes descriptiva';
                $id_autoparte = $this->autoparte_model->agregar_autoparte($nombre, $id_autoparte_marca, $id_autoparte_categoria, $descripcion, $origen, $referencia, $estado);
                if (is_array($id_vehiculos) && sizeof($id_vehiculos) != 0) {
                    foreach ($id_vehiculos as $id_vehiculo)
                        $this->autoparte_model->agregar_autoparte_vehiculo($id_autoparte, $id_vehiculo);
                }
                $this->establecimiento_model->agregar_establecimiento_autoparte($id_establecimiento, $id_autoparte, $precio);
                $data = $this->_ver_establecimientos();
                $data['confirmacion'] = 'Una nueva autoparte ha sido agregada y asociada al establecimiento con éxito';
                $this->load->view('admin/establecimiento/establecimiento_lista_view', $data);
            }
        }
    }

    /**
     * actualiza la oferta de un establecimiento 
     */
    function actualizar_establecimiento_oferta() {
        $id_establecimiento = $this->uri->segment(4);
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'titulo',
                'label' => 'titulo',
                'rules' => 'trim|required|xss_clean'
            ), array(
                'field' => 'condiciones',
                'label' => 'condiciones',
                'rules' => 'trim|required|xss_clean'
            ), array(
                'field' => 'iva',
                'label' => 'iva',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'incluye',
                'label' => 'incluye',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'precio',
                'label' => 'precio',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'categoria_otra',
                'label' => 'otra categoria',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'imagen',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            $this->load->view('admin/establecimiento/oferta_agregar_view');
        else {
            $this->load->model('establecimiento_model');
            $this->load->model('generico_model');
            $categorias = array();
            $id_oferta = $this->input->post('id_oferta', TRUE);
            $titulo = $this->input->post('titulo', TRUE);
            $condiciones = $this->input->post('condiciones', TRUE);
            $precio = $this->input->post('precio', TRUE);
            $incluye = $this->input->post('incluye', TRUE);
            $vigencia = $this->input->post('vigencia', TRUE);
            $iva = $this->input->post('iva', TRUE);
            $margen = $this->input->post('margen', TRUE);
            $descuento = $this->input->post('descuento', TRUE);
            $plazo = $this->input->post('plazo', TRUE);
            $categorias = $this->input->post('categoria', TRUE);
            $vehiculos = $this->input->post('vehiculo_id', TRUE);
            $otra_categoria = $this->input->post('categoria_otra', TRUE);
            $imagen = $this->input->post('imagen', TRUE);
            if ($otra_categoria) { 
                $tempCat[] = 'nombre';
                $tempCat[] = $otra_categoria;
                $cat[] = $tempCat;
                $id_cat = $this->generico_model->agreagar_registros_genericos('servicios_categoria', $cat);
                $categorias[] = $id_cat;
            }

            $this->load->library('upload');
            $upload_path = 'resources/images/promociones/';
            $config = array(
                'upload_path' => $upload_path,
                'allowed_types' => 'gif|jpg|png',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload('imagen')) {
                $img = $this->upload->data();
                $this->establecimiento_model->actualizar_oferta($titulo, $precio, $condiciones, $incluye, $categorias, $id_oferta, $id_establecimiento, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo, $upload_path . $img['file_name']);
                $msj = 'La oferta ha sido actualizada';
            } else {
                if (!$imagen) {
                    $this->establecimiento_model->actualizar_oferta($titulo, $precio, $condiciones, $incluye, $categorias, $id_oferta, $id_establecimiento, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo);
                    $msj = 'La oferta ha sido actualizada';
                } else {
                    $this->establecimiento_model->actualizar_oferta($titulo, $precio, $condiciones, $incluye, $categorias, $id_oferta, $id_establecimiento, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo);
                    $msj = 'La oferta ha sido actualizada con éxito, sin foto y error: ' . $this->upload->display_errors('', '');
                }
            }



            $data = $this->_ver_establecimiento_ofertas($id_establecimiento);
            $data['confirmacion'] = $msj;
            $this->load->view('admin/establecimiento/oferta_lista_view', $data);
        }
    }

    /**
     * Agrega una imagen al establecimiento
     */
    function agregar_establecimiento_imagenes() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_establecimiento',
                'label' => 'identificador del establecimiento',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'imagen_1',
                'label' => 'identificador de la imagen 1',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'imagen_2',
                'label' => 'identificador de la imagen 2',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'imagen_3',
                'label' => 'identificador de la imagen 3',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_establecimiento = $this->input->post('id_establecimiento', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_establecimiento($id_establecimiento);
            $this->load->view('admin/establecimiento/establecimiento_detalle_view', $data);
        } else {
            $this->load->library('upload');
            $this->load->model('establecimiento_model');
            if (!is_dir('./resources/images/establecimientos/' . $id_establecimiento)) {
                mkdir('./resources/images/establecimientos/' . $id_establecimiento, 0777, TRUE);
                mkdir('./resources/images/establecimientos/' . $id_establecimiento . '/thumb', 0777, TRUE);
            }

            for ($numero_imagen = 1; $numero_imagen < 4; $numero_imagen++) {
                $config = array(
                    'upload_path' => './resources/images/establecimientos/' . $id_establecimiento,
                    'allowed_types' => '*',
                    'file_name' => 'imagen',
                    'max_size' => '10000'
                );
                $this->upload->initialize($config);

                if ($this->upload->do_upload('imagen_' . $numero_imagen)) {
                    $imagen = $this->upload->data();

                    $this->load->library('image_lib');
                    $config = array(
                        'source_image' => $imagen['full_path'],
                        'quality' => '100%',
                        'new_image' => './resources/images/establecimientos/' . $id_establecimiento . '/thumb',
                        'width' => 99,
                        'height' => 99,
                        'master_dim' => 'width'
                    );
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $imagen_url = 'resources/images/establecimientos/' . $id_establecimiento . '/' . $imagen['file_name'];
                    $imagen_thumb_url = 'resources/images/establecimientos/' . $id_establecimiento . '/thumb/' . $imagen['file_name'];
                    $this->establecimiento_model->agregar_establecimiento_imagen($id_establecimiento, $imagen_url, $imagen_thumb_url);
                }
            }
            $data = $this->_ver_establecimiento($id_establecimiento);
            $this->load->view('admin/establecimiento/establecimiento_detalle_view', $data);
        }
    }

    /**
     * Agrega un servicio
     */
    function agregar_servicio() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            $this->load->view('admin/establecimiento/servicio_agregar_view');
        else {
            $this->load->model('establecimiento_model');
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $this->establecimiento_model->agregar_servicio($nombre);

            $data = $this->_ver_servicios();
            $data['confirmacion'] = 'El servicio ha sido agregado con éxito';
            $this->load->view('admin/establecimiento/servicio_lista_view', $data);
        }
    }

    function _guardarLog($tipo, $log) {
        if ($tipo == "kilometraje") {
            $myFile = "resources/logs/kilometraje.txt";
        } else if ($tipo == "legales") {
            $myFile = "resources/logs/legales.txt";
        } else if ($tipo == "tareas") {
            $myFile = "resources/logs/tareas.txt";
        } else if ($tipo == "noticias") {
            $myFile = "resources/logs/noticias.txt";
        } else {
            $myFile = "resources/logs/" . $tipo . ".txt";
        }
        $fh = fopen($myFile, 'a') or die("can't open file");
        fwrite($fh, $log);
        fclose($fh);
    }

    /**
     * Agrega un servicio
     */
    function agregar_oferta() {
        $id_establecimiento = $this->uri->segment(4);
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'titulo',
                'label' => 'titulo',
                'rules' => 'trim|required|xss_clean'
            ), array(
                'field' => 'precio',
                'label' => 'precio',
                'rules' => 'trim|required|xss_clean'
            ), array(
                'field' => 'iva',
                'label' => 'iva',
                'rules' => 'trim|required|xss_clean'
            ), array(
                'field' => 'vigencia',
                'label' => 'vigencia',
                'rules' => 'trim|required|xss_clean'
            ), array(
                'field' => 'categoria[]',
                'label' => 'categoria',
                'rules' => 'trim|xss_clean'
            ), array(
                'field' => 'condiciones',
                'label' => 'condiciones',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'vehiculo_id[]',
                'label' => 'vehículos de la autoparte',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'categoria_otra',
                'label' => 'otra categoria',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'imagen',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            $this->load->view('admin/establecimiento/oferta_agregar_view');
        else {
            $categorias = array();
            $this->load->model('establecimiento_model');
            $this->load->model('generico_model');
            $vigencia = $this->input->post('vigencia', TRUE);
            $titulo = $this->input->post('titulo', TRUE);
            $condiciones = $this->input->post('condiciones', TRUE);
            $precio = $this->input->post('precio', TRUE);
            $iva = $this->input->post('iva', TRUE);
            $margen = $this->input->post('margen', TRUE);
            $descuento = $this->input->post('descuento', TRUE);
            $plazo = $this->input->post('plazo', TRUE);
            $incluye = $this->input->post('incluye', TRUE);
            $categorias = $this->input->post('categoria', TRUE);
            $vehiculos = $this->input->post('vehiculo_id', TRUE);
            $otra_categoria = $this->input->post('categoria_otra', TRUE);
            $imagen = $this->input->post('imagen', TRUE);
            if ($otra_categoria) {
                $tempCat[] = 'nombre';
                $tempCat[] = $otra_categoria;
                $cat[] = $tempCat;
                $id_cat = $this->generico_model->agreagar_registros_genericos('servicios_categoria', $cat);
                $categorias[] = $id_cat;
            }

            $this->load->library('upload');
            $upload_path = 'resources/images/promociones/';
            $config = array(
                'upload_path' => $upload_path,
                'allowed_types' => 'gif|jpg|png',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload('imagen')) {
                $img = $this->upload->data();
                $id = $this->establecimiento_model->agregar_oferta($titulo, $precio, $condiciones, $incluye, $id_establecimiento, $categorias, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo, $upload_path . $img['file_name']);
                $url= base_url().'promociones/'.$id.'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $titulo);
                $msj = 'La oferta ha sido agregada. La url de la oferta es: <a style="display:inline;" href="'.$url.'">'.$url.'</a>';
            } else {
                if (!$imagen) {
                    $id = $this->establecimiento_model->agregar_oferta($titulo, $precio, $condiciones, $incluye, $id_establecimiento, $categorias, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo);
                    $url= base_url().'promociones/'.$id.'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $titulo);
                    $msj = 'La oferta ha sido agregada. La url de la oferta es: <a style="display:inline;"  href="'.$url.'">'.$url.'</a>';
                } else {
                    $id = $this->establecimiento_model->agregar_oferta($titulo, $precio, $condiciones, $incluye, $id_establecimiento, $categorias, $vehiculos, $vigencia, '', $iva, $margen, $descuento, $plazo);
                    $url= base_url().'promociones/'.$id.'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $titulo);
                    $msj = 'La oferta ha sido actualizada con éxito, sin foto y error: ' . $this->upload->display_errors('', '').'. La url de la oferta es: <a style="display:inline;"  href="'.$url.'">'.$url.'</a>';
                }
            }

            $data = $this->_ver_establecimiento_ofertas($id_establecimiento);
            $data['confirmacion'] = $msj;
            $this->load->view('admin/establecimiento/oferta_lista_view', $data);
        }
    }

    /**
     * Agrega una zona
     */
    function agregar_zona() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'ciudad',
                'label' => 'ciudad',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            $this->load->view('admin/establecimiento/zona_agregar_view');
        else {
            $this->load->model('establecimiento_model');
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $ciudad = ucwords(strtolower($this->input->post('ciudad', TRUE)));
            $this->establecimiento_model->agregar_zona($ciudad, $nombre);

            $data = $this->_ver_zonas();
            $data['confirmacion'] = 'La zona ha sido agregada con éxito';
            $this->load->view('admin/establecimiento/zona_lista_view', $data);
        }
    }

    /**
     * Elimina la imagen de un establecimiento
     */
    function eliminar_establecimiento_imagen() {
        $id_establecimiento = $this->uri->segment(4);
        $id_establecimiento_imagen = $this->uri->segment(5);
        $this->load->model('establecimiento_model');
        $establecimiento_imagenes = $this->establecimiento_model->dar_establecimiento_imagenes($id_establecimiento);
        foreach ($establecimiento_imagenes as $establecimiento_imagen) {
            if ($establecimiento_imagen->id_establecimiento_imagen == $id_establecimiento_imagen) {
                $this->establecimiento_model->eliminar_establecimiento_imagen($id_establecimiento_imagen);
                unlink($establecimiento_imagen->imagen_url);
                unlink($establecimiento_imagen->imagen_thumb_url);
            }
        }

        $data = $this->_ver_establecimiento($id_establecimiento);
        $this->load->view('admin/establecimiento/establecimiento_detalle_view', $data);
    }

    /**
     * Elimina el logo de un establecimiento
     */
    function eliminar_establecimiento_logo() {
        $id_establecimiento = $this->uri->segment(4);
        $this->load->model('establecimiento_model');
        $establecimiento = $this->establecimiento_model->dar_establecimiento($id_establecimiento);
        $this->establecimiento_model->eliminar_establecimiento_logo($id_establecimiento);
        unlink($establecimiento->logo_url);
        unlink($establecimiento->logo_thumb_url);
        $data = $this->_ver_establecimiento($id_establecimiento);
        $this->load->view('admin/establecimiento/establecimiento_detalle_view', $data);
    }

    /**
     * Elimina un servicio
     */
    function eliminar_servicio() {
        $id_servicio = $this->uri->segment(4);
        $this->load->model('establecimiento_model');
        $existe_llaves_foraneas = $this->establecimiento_model->existe_llaves_foraneas_servicio($id_servicio);
        if (!$existe_llaves_foraneas)
            $this->establecimiento_model->eliminar_servicio($id_servicio);

        $data = $this->_ver_servicios();
        if (!$existe_llaves_foraneas)
            $data['confirmacion'] = 'El servicio ha sido eliminada con éxito.';
        else
            $data['error'] = 'El servicio NO ha sido eliminada con éxito. Existen establecimientos asociados al servicio.';
        $this->load->view('admin/establecimiento/servicio_lista_view', $data);
    }

    /**
     * Elimina una oferta
     */
    function eliminar_oferta() {
        $id_oferta = $this->uri->segment(5);
        $id_establecimiento = $this->uri->segment(4);
        $this->load->model('establecimiento_model');
        $this->establecimiento_model->eliminar_establecimiento_oferta($id_oferta);
        $data = $this->_ver_establecimiento_ofertas($id_establecimiento);
        $data['confirmacion'] = 'La oferta ha sido eliminada con éxito.';
        $this->load->view('admin/establecimiento/oferta_lista_view', $data);
    }

    /**
     * Elimina una zona
     */
    function eliminar_zona() {
        $id_zona = $this->uri->segment(4);
        $this->load->model('establecimiento_model');
        $existe_llaves_foraneas = $this->establecimiento_model->existe_llaves_foraneas_zona($id_zona);
        if (!$existe_llaves_foraneas)
            $this->establecimiento_model->eliminar_zona($id_zona);

        $data = $this->_ver_zonas();
        if (!$existe_llaves_foraneas)
            $data['confirmacion'] = 'La zona ha sido eliminada con éxito.';
        else
            $data['error'] = 'La zona NO ha sido eliminada con éxito. Existen establecimientos asociados a la zona.';
        $this->load->view('admin/establecimiento/zona_lista_view', $data);
    }

    /**
     * Muestra el formulario para agregar un establecimiento
     */
    function formulario_establecimiento() {
        $data = $this->_formulario_establecimiento();
        $this->load->view('admin/establecimiento/establecimiento_agregar_view', $data);
    }

    /**
     * Muestra el formulario para agregar un servicio
     */
    function formulario_servicio() {
        $this->load->view('admin/establecimiento/servicio_agregar_view');
    }

    /**
     * Muestra el formulario para agregar un servicio
     */
    function formulario_oferta() {
        $this->load->model('generico_model');
        $this->load->model('vehiculo_model');
        $this->load->helper('date');
        $id_establecimiento = $this->uri->segment(4);
        $data['id_establecimiento'] = $id_establecimiento;
        $tareas = $this->generico_model->dar_registros('servicios_categoria');
        $data['tareas'] = $tareas;
        $data['vehiculos'] = $this->vehiculo_model->dar_vehiculos();

        //caja de texto
        # Variables de sesion de KCFinder, deben declararse al hacer LogIn con un usuario
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        # Al hacer LogOut deberíamos cambiar disabled a true: $_SESSION['KCFINDER']['disabled'] = true;

        $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => base_url() . "ckeditor/", 'outPut' => true));

        //------------------------
//        despliega los vehículos        
        $data['autopartes_autocomplete'] = json_encode($data['autopartes_autocomplete']);
        $data['autopartes_vehiculos_json'] = json_encode($data['autopartes_vehiculos']);
        $index = 0;
        foreach ($data['autopartes_vehiculos'] as $vehiculo) {
            $data['autopartes_vehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
            $data['autopartes_vehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
            $index++;
        }

        $index = 0;
        foreach ($data['vehiculos'] as $vehiculo) {
            $data['vehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
            $data['vehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
            $index++;
        }
//            --------------------------------
        $this->load->view('admin/establecimiento/oferta_agregar_view', $data);
    }

    /**
     * Muestra el formulario para agregar una zona
     */
    function formulario_zona() {
        $this->load->view('admin/establecimiento/zona_agregar_view');
    }

    /**
     * Muestra la lista de establecimientos
     */
    function index() {
        $data = $this->_ver_establecimientos();
        $this->load->view('admin/establecimiento/establecimiento_lista_view', $data);
    }

    /**
     * Muestra la información de un establecimiento
     */
    function ver_establecimiento() {
        $id_establecimiento = $this->uri->segment(4);
        $data = $this->_ver_establecimiento($id_establecimiento);
        $this->load->view('admin/establecimiento/establecimiento_detalle_view', $data);
    }

    /**
     * Muestra la relación autopartes-establecimiento
     */
    function ver_establecimiento_autopartes() {
        $id_establecimiento = $this->uri->segment(4);
        $this->load->model('autoparte_model');
        $data = $this->_ver_establecimiento_autopartes($id_establecimiento);
        $data['id_establecimiento'] = $id_establecimiento;
        $data['autopartes_autocomplete'] = $this->autoparte_model->dar_autopartes_autocomplete();
        $index = 0;
        foreach ($data['autopartes_autocomplete'] as $autoparte) {
            $data['autopartes_autocomplete'][$index]->descripcion = word_limiter(str_replace('<br />', '', $autoparte->descripcion), 25);
            $data['autopartes_autocomplete'][$index]->vehiculos = '';
            foreach ($data['autopartes_vehiculos'] as $autoparte_vehiculo) {
                if ($autoparte_vehiculo->id_autoparte == $autoparte->id_autoparte)
                    $data['autopartes_autocomplete'][$index]->vehiculos.= $autoparte_vehiculo->marca . ' ' . $autoparte_vehiculo->linea . '&nbsp; &nbsp;';
            }

            $precio = FALSE;
            foreach ($data['establecimiento_autopartes'] as $establecimiento_autoparte) {
                if ($establecimiento_autoparte->id_autoparte == $data['autopartes_autocomplete'][$index]->id_autoparte) {
                    $data['autopartes_autocomplete'][$index]->precio = $establecimiento_autoparte->precio;
                    $precio = TRUE;
                }
            }
            if (!$precio)
                $data['autopartes_autocomplete'][$index]->precio = 0;

            $index++;
        }
        $data['autopartes_autocomplete'] = json_encode($data['autopartes_autocomplete']);
        $data['autopartes_vehiculos_json'] = json_encode($data['autopartes_vehiculos']);
        $index = 0;
        foreach ($data['autopartes_vehiculos'] as $vehiculo) {
            $data['autopartes_vehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
            $data['autopartes_vehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
            $index++;
        }

        $index = 0;
        foreach ($data['vehiculos'] as $vehiculo) {
            $data['vehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
            $data['vehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
            $index++;
        }
        $this->load->view('admin/establecimiento/establecimiento_autopartes_view', $data);
    }

    /**
     * Muestra un servicio
     */
    function ver_servicio() {
        $id_servicio = $this->uri->segment(4);
        $data = $this->_ver_servicio($id_servicio);
        $this->load->view('admin/establecimiento/servicio_detalle_view', $data);
    }

    /**
     * Muestra la lista de servicios
     */
    function ver_servicios() {
        $data = $this->_ver_servicios();
        $this->load->view('admin/establecimiento/servicio_lista_view', $data);
    }

    /**
     * Muestra un servicio
     */
    function ver_oferta() {
        $id_oferta = $this->uri->segment(4);
        $id_establecimiento = $this->uri->segment(5);
        //caja de texto
        # Variables de sesion de KCFinder, deben declararse al hacer LogIn con un usuario
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        # Al hacer LogOut deberíamos cambiar disabled a true: $_SESSION['KCFINDER']['disabled'] = true;

        $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => base_url() . "ckeditor/", 'outPut' => true));

        //------------------------
        $data = $this->_ver_oferta($id_oferta, $id_establecimiento);
        $this->load->view('admin/establecimiento/oferta_detalle_view', $data);
    }

    /**
     * Muestra la lista de servicios
     */
    function ver_ofertas() {

        $id_establecimiento = $this->uri->segment(4);
        $data = $this->_ver_establecimiento_ofertas($id_establecimiento);
        $this->load->view('admin/establecimiento/oferta_lista_view', $data);
    }

    /**
     * Muestra una zona
     */
    function ver_zona() {
        $id_zona = $this->uri->segment(4);
        $data = $this->_ver_zona($id_zona);
        $this->load->view('admin/establecimiento/zona_detalle_view', $data);
    }

    /**
     * Muestra la lista de zonas
     */
    function ver_zonas() {
        $data = $this->_ver_zonas();
        $this->load->view('admin/establecimiento/zona_lista_view', $data);
    }

    /**
     * Da detalles de los comentarios de un establecimiento
     * @param int $id_establecimiento
     * @return array con $establecimiento y $zonas
     */
    function _ver_establecimiento_comentarios($id_establecimiento) {
        $this->load->model('establecimiento_model');
        $data['comentarios'] = $this->establecimiento_model->dar_establecimiento_comentarios($id_establecimiento);
        return $data;
    }

    /**
     * Muestra las ventas de un establecimiento
     */
    function ver_comentarios() {
        $id_establecimiento = $this->uri->segment(4);
        $data = $this->_ver_establecimiento_comentarios($id_establecimiento);
        $this->load->view('admin/establecimiento/mis_comentarios_detalle_view', $data);
    }

    /**
     * cambia el estado de un comentario de activo a inactivo
     */
    function cambiar_estado_ajax() {
        $id_comentario = $this->input->get_post('id_comentario', TRUE);
        $estado = $this->input->get_post('estado', TRUE);
        $this->load->model('establecimiento_model');
        $this->establecimiento_model->cambiar_estado_comentario_establecimiento($id_comentario, $estado);
    }

    /**
     * Da detalles de las ventas de un establecimiento
     * @param int $id_establecimiento
     * @return array con $establecimiento y $zonas
     */
    function _ver_establecimiento_ventas($id_establecimiento) {
        $this->load->model('establecimiento_model');
        $this->load->model('usuario_model');
        $data['carritos_compras'] = $this->establecimiento_model->dar_carritos_compras_establecimiento($id_establecimiento);
        $data['carritos_compras_autopartes'] = $this->establecimiento_model->dar_carritos_compras_establecimiento($id_establecimiento);
        $data['establecimiento'] = $this->establecimiento_model->dar_establecimiento($id_establecimiento);
        return $data;
    }

    /**
     * Muestra las ventas de un establecimiento
     */
    function ver_ventas() {
        $id_establecimiento = $this->uri->segment(4);
        $data = $this->_ver_establecimiento_ventas($id_establecimiento);
        $this->load->view('admin/establecimiento/mis_ventas_detalle_view', $data);
    }

    function carrito_realizado_ajax() {
        $id_carrito = $this->input->get_post('id_carrito', TRUE);
        $estado = $this->input->get_post('estado', TRUE);
        $this->load->model('usuario_model');
        $this->usuario_model->carrito_realizado($id_carrito, $estado);

        //envia el correo con la venta realizada a taller en linea
        $this->_enviar_correo_confirmacion($id_carrito);
    }

    /**
     * Envia un correo de comfirmación de que la venta se realizó
     * @param type $id_carrito 
     */
    function _enviar_correo_confirmacion($id_carrito) {
        $this->load->helper('mail');
        $this->load->helper('date');
        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");
        $this->load->model('establecimiento_model');
        $carrito = $this->establecimiento_model->dar_carrito_compras_info($id_carrito);
        if (strlen($carrito->nombre) > 0 && strlen($carrito->cantidad) > 0) {
            $mensajeHTML = '
                            Venta entregada y realizada
                            <br /><br />
                            Detalles de la venta: <br/>
                            <strong>Compra:  </strong> # ' . $carrito->carrito . '<br/>
                            <strong>Estado: </strong>' . $carrito->estado . '<br/>
                            <strong>No. Factura: </strong>' . $carrito->factura . '<br/>
                            <strong>Fecha de entrega: </strong>' . strftime("%B %d de %Y") . '<br/>
                            <strong>Cliente: </strong>' . $carrito->usuario . '<br/>
                            <strong>Total: </strong>' . $carrito->carritoTotal . '<br/>
                            Cordialmente,<br />
                            -------------------------------------------------------<br />
                            Servicio al cliente<br />
                            <a style="text-decoration: none; color: red;" href="' . base_url() . '">Laspartes.com</a> - Todo para su vehículo                
';
        } else {

            $mensajeHTML = '
                            Venta entregada y realizada
                            <br /><br />
                            Detalles de la venta: <br/>
                            <strong>Compra:  </strong> # ' . $carrito->carrito . '<br/>
                            <strong>Estado: </strong>' . $carrito->estado . '<br/>
                            <strong>No. Factura: </strong>' . $carrito->factura . '<br/>
                            <strong>Fecha de entrega: </strong>' . strftime("%B %d de %Y") . '<br/>
                            <strong>Cliente: </strong>' . $carrito->usuario . '<br/>
                            <strong>Total: </strong>$' . number_format($carrito->carritoTotal, 0, ',', '.') . '<br/>
                            Cordialmente,<br />
                            -------------------------------------------------------<br />
                            Servicio al cliente<br />
                            <a style="text-decoration: none; color: red;" href="' . base_url() . '">Laspartes.com</a> - Todo para su vehículo                
';
        }



        $destinatario = new stdClass();
        $destinatario->email = 'tallerenlinea@laspartes.com.co';
//        $destinatario->email = 'cabarique.luis@gmail.com';
        $destinatarios[] = $destinatario;
        send_mail($destinatarios, "[LasPartes.com] Compra entregada", $mensajeHTML, "", $fileName);
    }

}