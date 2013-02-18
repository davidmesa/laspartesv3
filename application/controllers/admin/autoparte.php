<?php

/**
 * Clase que maneja las autopartes, categorías y marcas de autopartes
 */
class Autoparte extends CI_Controller{

    /**
     * Constructor de la clase Autoparte
     * Valida si el usuario tiene una sesión activa
     */
    function __construct(){
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');
        if(!isset($esta_registrado)||!$esta_registrado||$this->session->userdata('tipo')!=10)
            redirect(base_url().'admin/inicio', 'refresh');
    }

    /**
     * Reindexa las autopartes asociadas a una categoría
     * @param int $id_autoparte_categoria
     */
    function _reindexar_categorias($id_autoparte_categoria){
        $this->load->model('indexacion_model');
        $this->load->model('autoparte_model');
        $autopartes = $this->autoparte_model->dar_autopartes_categoria($id_autoparte_categoria);

        if(sizeof($autopartes)!=0){
            foreach($autopartes as $autoparte){
                $vehiculos_indexacion = '';
                $vehiculos = $this->autoparte_model->dar_autoparte_vehiculos($autoparte->id_autoparte);
                foreach($vehiculos as $vehiculo)
                    $vehiculos_indexacion.= $vehiculo->marca.' '.$vehiculo->linea.'  ';
                $marca = $this->autoparte_model->dar_autoparte_marca($autoparte->id_autoparte_marca);
                $categoria = $this->autoparte_model->dar_autoparte_categoria($autoparte->id_autoparte_categoria);
                $indexacion = $autoparte->nombre.' '.$autoparte->descripcion.' '.$autoparte->origen.' '.$autoparte->referencia.' '.$vehiculos_indexacion.' '.$marca->nombre.' '.$categoria->nombre;
                $this->indexacion_model->actualizar_indexacion('autopartes', $autoparte->id_autoparte, $autoparte->nombre, $autoparte->descripcion, $indexacion, 'autopartes/ver_autoparte/'.$autoparte->id_autoparte.'/'.str_replace(' ', '-', convert_accented_characters($autoparte->nombre)), $autoparte->estado);
            }
        }
    }

    /**
     * Reindexa las autopartes asociadas a una marca
     * @param int $id_autoparte_marca
     */
    function _reindexar_marcas($id_autoparte_marca){
        $this->load->model('indexacion_model');
        $this->load->model('autoparte_model');
        $autopartes = $this->autoparte_model->dar_autopartes_marca($id_autoparte_marca);

        if(sizeof($autopartes)!=0){
            foreach($autopartes as $autoparte){
                $vehiculos_indexacion = '';
                $vehiculos = $this->autoparte_model->dar_autoparte_vehiculos($autoparte->id_autoparte);
                foreach($vehiculos as $vehiculo)
                    $vehiculos_indexacion.= $vehiculo->marca.' '.$vehiculo->linea.'  ';
                $marca = $this->autoparte_model->dar_autoparte_marca($autoparte->id_autoparte_marca);
                $categoria = $this->autoparte_model->dar_autoparte_categoria($autoparte->id_autoparte_categoria);
                $indexacion = $autoparte->nombre.' '.$autoparte->descripcion.' '.$autoparte->origen.' '.$autoparte->referencia.' '.$vehiculos_indexacion.' '.$marca->nombre.' '.$categoria->nombre;
                $this->indexacion_model->actualizar_indexacion('autopartes', $autoparte->id_autoparte, $autoparte->nombre, $autoparte->descripcion, $indexacion, 'autopartes/ver_autoparte/'.$autoparte->id_autoparte.'/'.str_replace(' ', '-', convert_accented_characters($autoparte->nombre)), $autoparte->estado);
            }
        }
    }

    /**
     * Reindexa las autopartes asociadas a un vehiculo
     * @param int $id_vehiculo
     */
    function _reindexar_vehiculos($id_vehiculo){
        $this->load->model('indexacion_model');
        $this->load->model('autoparte_model');
        $autopartes = $this->autoparte_model->dar_autopartes_vehiculo($id_vehiculo);

        if(sizeof($autopartes)!=0){
            foreach($autopartes as $autoparte){
                $vehiculos_indexacion = '';
                $vehiculos = $this->autoparte_model->dar_autoparte_vehiculos($autoparte->id_autoparte);
                foreach($vehiculos as $vehiculo)
                    $vehiculos_indexacion.= $vehiculo->marca.' '.$vehiculo->linea.'  ';
                $marca = $this->autoparte_model->dar_autoparte_marca($autoparte->id_autoparte_marca);
                $categoria = $this->autoparte_model->dar_autoparte_categoria($autoparte->id_autoparte_categoria);
                $indexacion = $autoparte->nombre.' '.$autoparte->descripcion.' '.$autoparte->origen.' '.$autoparte->referencia.' '.$vehiculos_indexacion.' '.$marca->nombre.' '.$categoria->nombre;
                $this->indexacion_model->actualizar_indexacion('autopartes', $autoparte->id_autoparte, $autoparte->nombre, $autoparte->descripcion, $indexacion, 'autopartes/ver_autoparte/'.$autoparte->id_autoparte.'/'.str_replace(' ', '-', convert_accented_characters($autoparte->nombre)), $autoparte->estado);
            }
        }
    }

    /**
     * Da detalles de una autoparte
     * @param int $id_autoparte
     * @return array con $autoparte, $autoparte_vehiculos, $categorias, $marcas y $vehiculos
     */
    function _ver_autoparte($id_autoparte){
        $this->load->model('autoparte_model');
        $this->load->model('vehiculo_model');
        $data['autoparte'] = $this->autoparte_model->dar_autoparte($id_autoparte);
        $data['autoparte_vehiculos'] = $this->autoparte_model->dar_autoparte_vehiculos($id_autoparte);
        $data['categorias'] = $this->autoparte_model->dar_autopartes_categorias();
        $data['marcas'] = $this->autoparte_model->dar_autopartes_marcas();
        $data['vehiculos'] = $this->vehiculo_model->dar_vehiculos();
        return $data;
    }

    /**
     * Da detalles de una categoria
     * @param int $id_autoparte_categoria
     * @return object $categoria
     */
    function _ver_autoparte_categoria($id_autoparte_categoria){
        $this->load->model('autoparte_model');
        $data['autoparte_categoria'] = $this->autoparte_model->dar_autoparte_categoria($id_autoparte_categoria);
        return $data;
    }

    /**
     * Da detalles de una marca
     * @param int $id_autoparte_categoria
     * @return object $marca
     */
    function _ver_autoparte_marca($id_autoparte_marca){
        $this->load->model('autoparte_model');
        $data['autoparte_marca'] = $this->autoparte_model->dar_autoparte_marca($id_autoparte_marca);
        return $data;
    }

    /**
     * Da la lista de las autopartes
     * @return array con $autopartes y $vehiculos
     */
    function _ver_autopartes(){
        $this->load->model('autoparte_model');
        $data['autopartes'] = $this->autoparte_model->dar_autopartes();
        $data['autopartes_vehiculos'] = $this->autoparte_model->dar_autopartes_vehiculos();
        return $data;
    }

    /**
     * Da la lista de las categorias
     * @return array $categorias
     */
    function _ver_autopartes_categorias(){
        $this->load->model('autoparte_model');
        $data['autopartes_categorias'] = $this->autoparte_model->dar_autopartes_categorias();
        return $data;
    }

    /**
     * Da la lista de las marcas
     * @return array $marcas
     */
    function _ver_autopartes_marcas(){
        $this->load->model('autoparte_model');
        $data['autopartes_marcas'] = $this->autoparte_model->dar_autopartes_marcas();
        return $data;
    }


    /**
     * Actualiza una autoparte
     */
    function actualizar_autoparte(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_autoparte',
                'label' => 'identificador de la autoparte',
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
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_autoparte = $this->input->post('id_autoparte', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_autoparte($id_autoparte);
            $this->load->view('admin/autoparte/autoparte_detalle_view', $data);
        }
        else{
            $this->load->model('autoparte_model');
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $id_autoparte_marca = $this->input->post('id_autoparte_marca', TRUE);
            $id_autoparte_categoria = $this->input->post('id_autoparte_categoria', TRUE);
            $descripcion = $this->input->post('descripcion', TRUE);
            $origen = ucwords(strtolower($this->input->post('origen', TRUE)));
            $referencia = ucwords(strtolower($this->input->post('referencia', TRUE)));
            $estado = $this->input->post('estado', TRUE);
            $this->autoparte_model->actualizar_autoparte($id_autoparte, $nombre, $id_autoparte_marca, $id_autoparte_categoria, $descripcion, $origen, $referencia, $estado);

            $this->load->library('upload');
            $config = array(
                'upload_path' => './resources/images/autopartes/'.$id_autoparte,
                'allowed_types' => '*',
                'file_name' => $nombre,
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'width' => 660,
                    'height' => 400,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'new_image' => './resources/images/autopartes/'.$id_autoparte.'/thumb',
                    'width' => 190,
                    'height' => 125,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $imagen_url = base_url().'resources/images/autopartes/'.$id_autoparte.'/'.$imagen['file_name'];
                $imagen_thumb_url = base_url().'resources/images/autopartes/'.$id_autoparte.'/thumb/'.$imagen['file_name'];
                $this->autoparte_model->actualizar_autoparte_imagen_url($id_autoparte, $imagen_url, $imagen_thumb_url);
            }

            $this->load->model('indexacion_model');
            $vehiculos_indexacion = '';
            $vehiculos = $this->autoparte_model->dar_autoparte_vehiculos($id_autoparte);
            foreach($vehiculos as $vehiculo)
                $vehiculos_indexacion.= $vehiculo->marca.' '.$vehiculo->linea.'  ';
            $marca = $this->autoparte_model->dar_autoparte_marca($id_autoparte_marca);
            $categoria = $this->autoparte_model->dar_autoparte_categoria($id_autoparte_categoria);
            $indexacion = $nombre.' '.$descripcion.' '.$origen.' '.$referencia.' '.$vehiculos_indexacion.' '.$marca->nombre.' '.$categoria->nombre;
            $this->indexacion_model->actualizar_indexacion('autopartes', $id_autoparte, $nombre, $descripcion, $indexacion, 'autopartes/ver_autoparte/'.$id_autoparte.'/'.str_replace(' ', '-', convert_accented_characters($nombre)), $estado);

            $data = $this->_ver_autopartes();
            $data['confirmacion'] = 'La autoparte ha sido actualizada con éxito.';
            $this->load->view('admin/autoparte/autoparte_lista_view', $data);
        }
    }

    /**
     * Actualiza la relaciones autoparte-vehiculo
     */
    function actualizar_autoparte_vehiculos(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_vehiculos[]',
                'label' => 'identificador del vehículo',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'id_autoparte',
                'label' => 'identificador de la autoparte',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_autoparte = $this->input->post('id_autoparte', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_autoparte($id_autoparte);
            $this->load->view('admin/autoparte/autoparte_detalle_view', $data);
        }
        else{
            $this->load->model('autoparte_model');
            $id_vehiculos = $this->input->post('id_vehiculos', TRUE);
            $this->autoparte_model->eliminar_autoparte_vehiculos($id_autoparte);
            if(is_array($id_vehiculos) && sizeof($id_vehiculos)!=0){
                foreach($id_vehiculos as $id_vehiculo)
                    $this->autoparte_model->agregar_autoparte_vehiculo($id_autoparte, $id_vehiculo);
            }

            $this->load->model('indexacion_model');
            $autoparte = $this->autoparte_model->dar_autoparte($id_autoparte);
            $vehiculos_indexacion = '';
            $vehiculos = $this->autoparte_model->dar_autoparte_vehiculos($id_autoparte);
            foreach($vehiculos as $vehiculo)
                $vehiculos_indexacion.= $vehiculo->marca.' '.$vehiculo->linea.'  ';
            $marca = $this->autoparte_model->dar_autoparte_marca($autoparte->id_autoparte_marca);
            $categoria = $this->autoparte_model->dar_autoparte_categoria($autoparte->id_autoparte_categoria);
            $indexacion = $autoparte->nombre.' '.$autoparte->descripcion.' '.$autoparte->origen.' '.$autoparte->referencia.' '.$vehiculos_indexacion.' '.$marca->nombre.' '.$categoria->nombre;
            $this->indexacion_model->actualizar_indexacion('autopartes', $id_autoparte, $autoparte->nombre, $autoparte->descripcion, $indexacion, 'autopartes/ver_autoparte/'.$id_autoparte.'/'.str_replace(' ', '-', convert_accented_characters($autoparte->nombre)), 'Activo');

            $data = $this->_ver_autopartes();
            $data['confirmacion'] = 'Las relaciones autoparte-vehículo ha sido actualizada con éxito.';
            $this->load->view('admin/autoparte/autoparte_lista_view', $data);
        }
    }

    /**
     * Actualiza una categoría
     */
    function actualizar_autoparte_categoria(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_autoparte_categoria',
                'label' => 'identificador de la categoría',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|min_length[2]|max_length[128]|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_autoparte_categoria = $this->input->post('id_autoparte_categoria', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_autoparte_categoria($id_autoparte_categoria);
            $this->load->view('admin/autoparte/autoparte_categoria_detalle_view', $data);
        }
        else{
            $this->load->model('autoparte_model');
            $nombre = $this->input->post('nombre', TRUE);
            $this->autoparte_model->actualizar_autoparte_categoria($id_autoparte_categoria, $nombre);
            $this->_reindexar_categorias($id_autoparte_categoria);
            $data = $this->_ver_autopartes_categorias();
            $data['confirmacion'] = 'La categoría ha sido actualizada con éxito.';
            $this->load->view('admin/autoparte/autoparte_categoria_lista_view', $data);
        }
    }

    /**
     * Actualiza una marca
     */
    function actualizar_autoparte_marca(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_autoparte_marca',
                'label' => 'identificador de la marca',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|min_length[2]|max_length[128]|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_autoparte_marca = $this->input->post('id_autoparte_marca', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_autoparte_marca($id_autoparte_marca);
            $this->load->view('admin/autoparte/autoparte_marca_detalle_view', $data);
        }
        else{
            $this->load->model('autoparte_model');
            $nombre = $this->input->post('nombre', TRUE);
            $this->autoparte_model->actualizar_autoparte_marca($id_autoparte_marca, $nombre);
            $data = $this->_ver_autopartes_marcas();
            $this->_reindexar_marcas($id_autoparte_marca);
            $data['confirmacion'] = 'La marca ha sido actualizada con éxito.';
            $this->load->view('admin/autoparte/autoparte_marca_lista_view', $data);
        }
    }

    

    /**
     * Agrega una nueva autoparte
     */
    function agregar_autoparte(){
        $this->load->library('form_validation');
        $reglas = array(
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
                'label' => 'identificador de los vehículos',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $this->load->model('autoparte_model');
        $this->load->model('vehiculo_model');
        if(!$this->form_validation->run()){
            $data['categorias'] = $this->autoparte_model->dar_autopartes_categorias();
            $data['marcas'] = $this->autoparte_model->dar_autopartes_marcas();
            $data['vehiculos'] = $this->vehiculo_model->dar_vehiculos();
            $this->load->view('admin/autoparte/autoparte_agregar_view', $data);
        }
        else{   
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $id_autoparte_marca = $this->input->post('id_autoparte_marca', TRUE);
            $id_autoparte_categoria = $this->input->post('id_autoparte_categoria', TRUE);
            $descripcion = $this->input->post('descripcion', TRUE);
            $origen = ucwords(strtolower($this->input->post('origen', TRUE)));
            $referencia = ucwords(strtolower($this->input->post('referencia', TRUE)));
            $estado = $this->input->post('estado', TRUE);
            $id_autoparte = $this->autoparte_model->agregar_autoparte($nombre, $id_autoparte_marca, $id_autoparte_categoria, $descripcion, $origen, $referencia, $estado);

            $id_vehiculos = $this->input->post('id_vehiculos', TRUE);
            if(is_array($id_vehiculos) && sizeof($id_vehiculos)!=0){
                foreach($id_vehiculos as $id_vehiculo)
                    $this->autoparte_model->agregar_autoparte_vehiculo($id_autoparte, $id_vehiculo);
            }

            $this->load->library('upload');
            if(!is_dir('./resources/images/autopartes/'.$id_autoparte)){
                mkdir('./resources/images/autopartes/'.$id_autoparte,0777,TRUE);
                mkdir('./resources/images/autopartes/'.$id_autoparte.'/thumb',0777,TRUE);
            }

            $config = array(
                'upload_path' => './resources/images/autopartes/'.$id_autoparte,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'file_name' => $nombre,
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'width' => 660,
                    'height' => 400,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'new_image' => './resources/images/autopartes/'.$id_autoparte.'/thumb',
                    'width' => 190,
                    'height' => 125,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $imagen_url = base_url().'resources/images/autopartes/'.$id_autoparte.'/'.$imagen['file_name'];
                $imagen_thumb_url = base_url().'resources/images/autopartes/'.$id_autoparte.'/thumb/'.$imagen['file_name'];
                $this->autoparte_model->actualizar_autoparte_imagen_url($id_autoparte, $imagen_url, $imagen_thumb_url);
            }

            $this->load->model('indexacion_model');
            $vehiculos_indexacion = '';
            $vehiculos = $this->autoparte_model->dar_autoparte_vehiculos($id_autoparte);
            foreach($vehiculos as $vehiculo)
                $vehiculos_indexacion.= $vehiculo->marca.' '.$vehiculo->linea.'  ';
            $marca = $this->autoparte_model->dar_autoparte_marca($id_autoparte_marca);
            $categoria = $this->autoparte_model->dar_autoparte_categoria($id_autoparte_categoria);
            $indexacion = $nombre.' '.$descripcion.' '.$origen.' '.$referencia.' '.$vehiculos_indexacion.' '.$marca->nombre.' '.$categoria->nombre;
            $this->indexacion_model->agregar_indexacion('autopartes', $id_autoparte, $nombre, $descripcion, $indexacion, 'autopartes/ver_autoparte/'.$id_autoparte.'/'.str_replace(' ', '-', convert_accented_characters($nombre)), $estado);

            $data = $this->_ver_autopartes();
            $data['confirmacion'] = 'La autoparte ha sido agregada con éxito.';
            $this->load->view('admin/autoparte/autoparte_lista_view', $data);
        }
    }

    /**
     * Agrega una nueva categoría
     */
    function agregar_autoparte_categoria(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|min_length[2]|max_length[128]|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if(!$this->form_validation->run())
            $this->load->view('admin/autoparte/autoparte_categoria_agregar_view');
        else{
            $this->load->model('autoparte_model');
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $this->autoparte_model->agregar_autoparte_categoria($nombre);
            $data = $this->_ver_autopartes_categorias();
            $data['confirmacion'] = 'La categoría ha sido agregada con éxito.';
            $this->load->view('admin/autoparte/autoparte_categoria_lista_view', $data);
        }
    }

    /**
     * Agrega una nueva marca
     */
    function agregar_autoparte_marca(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|min_length[2]|max_length[128]|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if(!$this->form_validation->run())
            $this->load->view('admin/autoparte/autoparte_marca_agregar_view');
        else{
            $this->load->model('autoparte_model');
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $this->autoparte_model->agregar_autoparte_marca($nombre);
            $data = $this->_ver_autopartes_marcas();
            $data['confirmacion'] = 'La marca ha sido agregada con éxito.';
            $this->load->view('admin/autoparte/autoparte_marca_lista_view', $data);
        }
    }

    

    /**
     * Muestra el formulario para agregar una autoparte
     */
    function formulario_autoparte(){
        $this->load->model('autoparte_model');
        $this->load->model('vehiculo_model');
        $data['categorias'] = $this->autoparte_model->dar_autopartes_categorias();
        $data['marcas'] = $this->autoparte_model->dar_autopartes_marcas();
        $data['vehiculos'] = $this->vehiculo_model->dar_vehiculos();
        $this->load->view('admin/autoparte/autoparte_agregar_view', $data);
    }

    /**
     * Muestra el formulario para agregar una categoría
     */
    function formulario_autoparte_categoria(){
        $this->load->view('admin/autoparte/autoparte_categoria_agregar_view');
    }

    /**
     * Muestra el formulario para agregar una marca
     */
    function formulario_autoparte_marca(){
        $this->load->view('admin/autoparte/autoparte_marca_agregar_view');
    }

    

    /**
     * Muestra la lista de autopartes
     */
    function index(){
        $data = $this->_ver_autopartes();
        $this->load->view('admin/autoparte/autoparte_lista_view', $data);
    }

    /**
     * Elimina una autoparte con sus relaciones autopartes_vehiculos
     */
    function eliminar_autoparte(){
        $id_autoparte = $this->uri->segment(4);
        $this->load->model('autoparte_model');
        $this->autoparte_model->eliminar_autoparte_vehiculos($id_autoparte);
        $this->autoparte_model->eliminar_autoparte($id_autoparte);
        $data = $this->_ver_autopartes();
        $data['confirmacion'] = 'La autoparte ha sido eliminada con éxito.';
        $this->load->view('admin/autoparte/autoparte_lista_view', $data);
    }

    /**
     * Elimina una categoría
     */
    function eliminar_autoparte_categoria(){
        $id_autoparte_categoria = $this->uri->segment(4);
        $this->load->model('autoparte_model');
        $existe_llaves_foraneas = $this->autoparte_model->existe_llaves_foraneas_categoria($id_autoparte_categoria);
        if(!$existe_llaves_foraneas)
            $this->autoparte_model->eliminar_autoparte_categoria($id_autoparte_categoria);
        
        $data = $this->_ver_autopartes_categorias();
        if(!$existe_llaves_foraneas)
            $data['confirmacion'] = 'La categoría ha sido eliminada con éxito.';
        else
            $data['error'] = 'La categoría NO ha sido eliminada con éxito. Existen autopartes asociadas a esta categoría. Elimine primera estas autopartes.';
        $this->load->view('admin/autoparte/autoparte_categoria_lista_view', $data);
    }

    /**
     * Elimina la imagen de la autoparte
     */
    function eliminar_autoparte_imagen(){
        $id_autoparte = $this->uri->segment(4);
        $this->load->model('autoparte_model');
        $autoparte = $this->autoparte_model->dar_autoparte($id_autoparte);
        $this->autoparte_model->eliminar_autoparte_imagen($id_autoparte); 
        unlink($autoparte->imagen_url);
        unlink($autoparte->imagen_thumb_url);

        $data = $this->_ver_autoparte($id_autoparte);
        $data['conforimacion'] = 'La imagen ha sido eliminada con éxito';
        $this->load->view('admin/autoparte/autoparte_detalle_view', $data);
    }

    /**
     * Elimina una marca
     */
    function eliminar_autoparte_marca(){
        $id_autoparte_marca = $this->uri->segment(4);
        $this->load->model('autoparte_model');
        $existe_llaves_foraneas = $this->autoparte_model->existe_llaves_foraneas_marca($id_autoparte_marca);
        if(!$existe_llaves_foraneas)
            $this->autoparte_model->eliminar_autoparte_marca($id_autoparte_marca);

        $data = $this->_ver_autopartes_marcas();
        if(!$existe_llaves_foraneas)
            $data['confirmacion'] = 'La marca ha sido eliminada con éxito.';
        else
            $data['error'] = 'La marca NO ha sido eliminada con éxito. Existen autopartes asociadas a esta marca. Elimine primera estas autopartes.';
        $this->load->view('admin/autoparte/autoparte_marca_lista_view', $data);
    }

    /**
     * Da la información de una autoparte
     */
    function ver_autoparte(){
        $id_autoparte = $this->uri->segment(4);
        $data = $this->_ver_autoparte($id_autoparte);
        $this->load->view('admin/autoparte/autoparte_detalle_view', $data);
    }

    /**
     * Da la información de una categoria
     */
    function ver_autoparte_categoria(){
        $id_autoparte_categoria = $this->uri->segment(4);
        $data = $this->_ver_autoparte_categoria($id_autoparte_categoria);
        $this->load->view('admin/autoparte/autoparte_categoria_detalle_view', $data);
    }

    /**
     * Da la información de marca
     */
    function ver_autoparte_marca(){
        $id_autoparte_marca = $this->uri->segment(4);
        $data = $this->_ver_autoparte_marca($id_autoparte_marca);
        $this->load->view('admin/autoparte/autoparte_marca_detalle_view', $data);
    }

    /**
     * Da los vehículos de una autoparte
     */
    function ver_autoparte_vehiculos_ajax(){
        $id_autoparte = $this->input->post('id_autoparte', TRUE);
        $this->load->model('autoparte_model');
        $index = 0;
        $data['vehiculos'] = $this->autoparte_model->dar_autoparte_vehiculos($id_autoparte);
        foreach($data['vehiculos'] as $vehiculo){
            $data['vehiculos'][$index]->label = $vehiculo->marca.' '.$vehiculo->linea;
            $data['vehiculos'][$index]->value = $vehiculo->marca.' '.$vehiculo->linea;
            $index++;
        }
        echo json_encode($data['vehiculos']);
        
    }

    /**
     * Da la lista de categorías de autopartes
     */
    function ver_autopartes_categorias(){
        $data = $this->_ver_autopartes_categorias();
        $this->load->view('admin/autoparte/autoparte_categoria_lista_view', $data);
    }

    /**
     * Da la lista de marcas de autopartes
     */
    function ver_autopartes_marcas(){
        $data = $this->_ver_autopartes_marcas();
        $this->load->view('admin/autoparte/autoparte_marca_lista_view', $data);
    }
}