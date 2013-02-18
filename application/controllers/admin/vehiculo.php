<?php

/**
 * Clase que maneja los usuarios
 */
class Vehiculo extends CI_Controller {

    /**
     * Constructor de la clase Usuario
     */
    function __construct() {
        parent::__construct();
        $this->load->model('vehiculo_model');
        $esta_registrado = $this->session->userdata('esta_registrado');
        if(!isset($esta_registrado)||!$esta_registrado||$this->session->userdata('tipo')!=10)
            redirect(base_url().'admin/inicio', 'refresh');
    }

    /**
     * Da la lista de vehículos
     * @return array $usuarios
     */
    function _ver_vehiculos() {
        $data['vehiculos'] = $this->vehiculo_model->dar_vehiculos();
        return $data;
    }

    function _ver_hoja_mantenimiento($id_vehiculo) { 
        $this->load->model('generico_model');
        $this->load->helper('date'); 
        $data['id_vehiculo'] = $id_vehiculo;
        $data['vehiculo'] = $this->vehiculo_model->dar_vehiculo($id_vehiculo);
        $data['hojas'] = $this->vehiculo_model->dar_hoja_mantenimiento($id_vehiculo);
        $tareas = $this->generico_model->dar_registros('tareas');
        $tareaArray = Array();
        $tareaArray['0'] = 'Otro';
        foreach ($tareas as $tarea) {
            $tareaArray[$tarea->id_servicio] = $tarea->nombre;
        }
        $data['tareas'] = $tareaArray;
        return $data;
    }

    /**
     * Muestra la lista de vehiculos
     */
    function index() {
        $data = $this->_ver_vehiculos();
        $this->load->view('admin/vehiculo/vehiculo_lista_view', $data);
    }

    /**
     * Da detalles del vehículo
     */
    function ver_vehiculo() {
        $id_vehiculo = $this->uri->segment(4);
        $data = $this->_ver_vehiculo($id_vehiculo);
        $this->load->view('admin/vehiculo/vehiculo_detalle_view', $data);
    }
    
    /**
     * Da detalles de un vehículo
     * @param int $id_vehiculo
     * @return object $vehiculo
     */
    function _ver_vehiculo($id_vehiculo){
        $data['vehiculo'] = $this->vehiculo_model->dar_vehiculo($id_vehiculo);
        return $data;
    }

    /**
     * Muestra la hoja de mantenimiento existente, sino no muestra nada
     * @param type $id_vehiculo
     */
    function ver_hoja_mantenimiento($id_vehiculo, $mensaje_error) {
        $data = $this->_ver_hoja_mantenimiento($id_vehiculo);
        $data['mensaje'] = $mensaje_error;
        $this->load->view('admin/vehiculo/vehiculo_hoja_mto_view', $data);
    }

    /**
     * devuelve una fila con la información para agregar una nueva tarea
     */
    function dar_nueva_tarea_ajax() {
        $this->load->model('generico_model');
        $tareas = $this->generico_model->dar_registros('tareas');
        $tareaArray = Array();
        $tareaArray['0'] = 'Otro';
        foreach ($tareas as $tarea) {
            $tareaArray[$tarea->id_servicio] = $tarea->nombre;
        }
        $data['tareas'] = $tareaArray;
        $this->load->view('admin/vehiculo/ajax/tarea_nueva_view', $data);
    }

    /**
     * Actualiza o agrega una tarea vía ajax al vehículo dado
     */
    function actualizar_tarea_ajax() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_vehiculo',
                'label' => 'Vehículo',
                'rules' => 'trim|required|xss_clean|numeric'
            ),array(
                'field' => 'periodicidad',
                'label' => 'Periodicidad',
                'rules' => 'trim|required|xss_clean|numeric'
            ),array(
                'field' => 'rango',
                'label' => 'Rango de tolerancia',
                'rules' => 'trim|required|xss_clean|numeric'
            ),array(
                'field' => 'modelo',
                'label' => 'Modelo del vehículo',
                'rules' => 'trim|required|xss_clean|numeric'
            ),array(
                'field' => 'id_tarea',
                'label' => 'Tarea',
                'rules' => 'trim|required|xss_clean|numeric'
            ),array(
                'field' => 'hoja_mto_id_tarea_otros',
                'label' => 'ID del elemento',
                'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'otro',
                'label' => 'Nombre de la tarea',
                'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'textAreaOtro',
                'label' => 'Descripción de la tarea',
                'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'imagen',
                'label' => 'Imagen de la tarea',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);
        $id_vehiculo = $this->input->post('id_vehiculo');
        if (!$this->form_validation->run()) {
            
            $this->ver_hoja_mantenimiento($id_vehiculo, validation_errors('<div class="mensaje-error canhide">', '</div>'));
        } else {
            $periodicidad = $this->input->post('periodicidad');
            $rango = $this->input->post('rango');
            $modelo = $this->input->post('modelo');
            $id_servicio = $this->input->post('id_tarea');
            $id_tarea = $this->input->post('hoja_mto_id_tarea_otros');

            $otro = $this->input->post('otro');
            $textAreaOtro = $this->input->post('textAreaOtro');
            $this->load->library('upload');


            $config = array(
                'upload_path' => 'resources/images/servicios/',
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10240'
            );

            $this->upload->initialize($config);

            if ($this->upload->do_upload('imagen')) {
                $imagen = $this->upload->data();
                $imagen_url = 'resources/images/servicios/' . $imagen['file_name'];

                $this->vehiculo_model->agregar_tarea_hoja_mto($id_vehiculo, $id_servicio, $periodicidad, $rango, $modelo, $otro, $textAreaOtro, $imagen_url, $id_tarea);

                redirect('admin/vehiculo/ver_hoja_mantenimiento/' . $id_vehiculo);
            } else {
                $this->vehiculo_model->agregar_tarea_hoja_mto($id_vehiculo, $id_servicio, $periodicidad, $rango, $modelo, $otro, $textAreaOtro, '', $id_tarea);

                redirect(base_url().'admin/vehiculo/ver_hoja_mantenimiento/' . $id_vehiculo);
            }
        }
    }

    /**
     * Elimina una tarea por ajax
     */
    function eliminar_tarea_ajax() {
        $id_tarea = $this->input->post('id_tarea');
        if ($id_tarea != 0) {
            $this->vehiculo_model->eliminar_tarea_hoja_mto($id_tarea);
        }
    }
    
    /**
     * Elimina un vehiculo
     */
    function eliminar_vehiculo($id_vehiculo){
        $this->load->model('vehiculo_model');
        $existe_llaves_foraneas = $this->vehiculo_model->existe_llaves_foraneas_vehiculo($id_vehiculo);
        if(!$existe_llaves_foraneas)
            $this->vehiculo_model->eliminar_vehiculo($id_vehiculo);

        $data = $this->_ver_vehiculos();
        if(!$existe_llaves_foraneas)
            $data['mensaje'] = '<div class="mensaje-ok canhide">El vehículo ha sido eliminada con éxito.</div>';
        else
            $data['mensaje'] = '<div class="mensaje-error canhide">El vehículo NO ha sido eliminada con éxito. Existen relaciones asociadas a esta marca.</div>';
        $this->load->view('admin/vehiculo/vehiculo_lista_view', $data);
    }
    
    /**
     * Actualiza un vehículo
     */
    function actualizar_vehiculo(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_vehiculo',
                'label' => 'identificador del vehiculo',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'marca',
                'label' => 'marca',
                'rules' => 'trim|required|min_length[2]|max_length[128]|xss_clean'
            ),
            array(
                'field' => 'linea',
                'label' => 'linea',
                'rules' => 'trim|required|min_length[2]|max_length[128]|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_vehiculo = $this->input->post('id_vehiculo', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_vehiculo($id_vehiculo);
            $this->load->view('admin/vehiculo/vehiculo_detalle_view', $data);
        }
        else{
            $this->load->model('vehiculo_model');
            $marca = ucwords(strtolower($this->input->post('marca', TRUE)));
            $linea = ucwords(strtolower($this->input->post('linea', TRUE)));
            $this->vehiculo_model->actualizar_vehiculo($id_vehiculo, $marca, $linea);
            $this->_reindexar_vehiculos($id_vehiculo);
            $data = $this->_ver_vehiculos();
            $data['confirmacion'] = 'El vehículo ha sido actualizado con éxito.';
            $this->load->view('admin/vehiculo/vehiculo_lista_view', $data);
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
     * Muestra el formulario para agregar un vehículo
     */
    function formulario_vehiculo(){
        $this->load->view('admin/vehiculo/vehiculo_agregar_view');
    }
    
    /**
     * Agrega un nuevo vehiculo
     */
    function agregar_vehiculo(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'marca',
                'label' => 'marca',
                'rules' => 'trim|required|min_length[2]|max_length[128]|xss_clean'
            ),
            array(
                'field' => 'linea',
                'label' => 'linea',
                'rules' => 'trim|required|min_length[2]|max_length[128]|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if(!$this->form_validation->run())
            $this->load->view('admin/autoparte/autoparte_vehiculo_agregar_view');
        else{
            $this->load->model('vehiculo_model');
            $marca = ucwords(strtolower($this->input->post('marca', TRUE)));
            $linea = ucwords(strtolower($this->input->post('linea', TRUE)));
            $this->vehiculo_model->agregar_vehiculo($marca, $linea);
            $data = $this->_ver_vehiculos();
            $data['confirmacion'] = 'El vehículo ha sido agregada con éxito.';
            $this->load->view('admin/vehiculo/vehiculo_lista_view', $data);
        }
    }

}