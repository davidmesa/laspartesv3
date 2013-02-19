<?php

/**
 * Clase que maneja el taller en línea
 */
class Taller_en_linea extends CI_Controller{

    /**
     * Constructor de la clase Taller_en_linea
     */
    function __construct(){
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');
        if(!isset($esta_registrado)||!$esta_registrado||$this->session->userdata('tipo')!=10)
            redirect(base_url().'admin/inicio', 'refresh');
    }

    /**
     * Reindexa las preguntas asociadas a una categoría
     * @param int $id_pregunta_categoria
     */
    function _reindexar_categorias($id_pregunta_categoria){
        $this->load->model('indexacion_model');
        $this->load->model('pregunta_model');
        $preguntas = $this->pregunta_model->dar_preguntas_categoria($id_pregunta_categoria);

        if(sizeof($preguntas)!=0){
            foreach($preguntas as $pregunta){
                $categoria = $this->pregunta_model->dar_pregunta_categoria($pregunta->id_pregunta_categoria);
                $respuestas = $this->pregunta_model->dar_respuestas($pregunta->id_pregunta);
                $respuestasIndexacion = '';
                foreach($respuestas as $respuesta){
                    $respuestasIndexacion.= $respuesta->respuesta.' ';
                }
                $indexacion = $pregunta->titulo_pregunta.' '.$pregunta->cuerpo_pregunta.' '.$categoria->nombre.' '.$pregunta->palabras_clave.' '.$respuestasIndexacion;
                $this->indexacion_model->actualizar_indexacion('taller en línea', $pregunta->id_pregunta, $pregunta->titulo_pregunta, $pregunta->cuerpo_pregunta, $indexacion, 'taller_en_linea/ver_pregunta/'.$pregunta->id_pregunta.'/'.str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)), $pregunta->estado);
            }
        }
    }

    /**
     * Muestra los detalle de una pregunta
     * @param int $id_pregunta
     * @return array con $pregunta, $preguntas_categorias y $respuestas
     */
    function _ver_pregunta($id_pregunta){
        $this->load->model('pregunta_model');
        $data['pregunta'] = $this->pregunta_model->dar_pregunta($id_pregunta);
        $data['preguntas_categorias'] = $this->pregunta_model->dar_preguntas_categorias();
        $data['respuestas'] = $this->pregunta_model->dar_respuestas($id_pregunta);
        return $data;
    }

    /**
     * Da la lista de preguntas
     * @return array con $preguntas
     */
    function _ver_preguntas(){
        $this->load->model('pregunta_model');
        $data['preguntas'] = $this->pregunta_model->dar_preguntas(); 
        return $data;
    }

    /**
     * Da la lista de categorias de preguntas
     * @return array con $preguntas_categorias
     */
    function _ver_preguntas_categorias(){
        $this->load->model('pregunta_model');
        $data['preguntas_categorias'] = $this->pregunta_model->dar_preguntas_categorias();
        return $data;
    }

        /**
     * Da detalles de una categoria
     * @param int $id_pregunta_categoria
     * @return object $categoria
     */
    function _ver_pregunta_categoria($id_pregunta_categoria){
        $this->load->model('pregunta_model');
        $data['pregunta_categoria'] = $this->pregunta_model->dar_pregunta_categoria($id_pregunta_categoria);
        return $data;
    }

    /**
     * Actualiza una pregunta
     */
    function actualizar_pregunta(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_pregunta',
                'label' => 'identificador de la pregunta',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'titulo_pregunta',
                'label' => 'pregunta',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'cuerpo_pregunta',
                'label' => 'detalles de la pregunta',
                'rules' => 'trim|required|xss_clean'
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
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_pregunta = $this->input->post('id_pregunta', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_pregunta($id_pregunta);
            $this->load->view('admin/taller_en_linea/pregunta_detalle_view', $data);
        }
        else{
            $this->load->model('pregunta_model');
            $titulo_pregunta = $this->input->post('titulo_pregunta', TRUE);
            $cuerpo_pregunta = $this->input->post('cuerpo_pregunta', TRUE);
            $id_pregunta_categoria = $this->input->post('id_pregunta_categoria', TRUE);
            $palabras_clave = $this->input->post('palabras_clave', TRUE);
            $estado = $this->input->post('estado', TRUE);
            $this->pregunta_model->actualizar_pregunta($id_pregunta, $titulo_pregunta, $cuerpo_pregunta, $id_pregunta_categoria, $palabras_clave, $estado);

            $this->load->model('indexacion_model');
            $categoria = $this->pregunta_model->dar_pregunta_categoria($id_pregunta_categoria);
            $respuestas = $this->pregunta_model->dar_respuestas($id_pregunta);
            $respuestasIndexacion = '';
            foreach($respuestas as $respuesta){
                $respuestasIndexacion.= $respuesta->respuesta.' ';
            }
            $indexacion = $titulo_pregunta.' '.$cuerpo_pregunta.' '.$categoria->nombre.' '.$palabras_clave.' '.$respuestasIndexacion;
            $this->indexacion_model->actualizar_indexacion('taller en línea', $id_pregunta, $titulo_pregunta, $cuerpo_pregunta, $indexacion, 'taller_en_linea/ver_pregunta/'.$id_pregunta.'/'.str_replace(' ', '-', convert_accented_characters($titulo_pregunta)), $estado);

            $data['confirmacion'] = 'La pregunta ha sido actualizada con éxito';
            $data = $this->_ver_preguntas();
            $this->load->view('admin/taller_en_linea/pregunta_lista_view', $data);
        }
    }

    /**
     * Actualiza una categoría
     */
    function actualizar_pregunta_categoria(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_pregunta_categoria',
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

        $id_pregunta_categoria = $this->input->post('id_pregunta_categoria', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_pregunta_categoria($id_pregunta_categoria);
            $this->load->view('admin/taller_en_linea/pregunta_categoria_detalle_view', $data);
        }
        else{
            $this->load->model('pregunta_model');
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $this->pregunta_model->actualizar_pregunta_categoria($id_pregunta_categoria, $nombre);
            $data = $this->_ver_preguntas_categorias();
            $data['confirmacion'] = 'La categoría ha sido actualizada con éxito.';
            $this->load->view('admin/taller_en_linea/pregunta_categoria_lista_view', $data);
        }
    }

    /**
     * Actualiza una respuesta
     */
    function actualizar_respuesta(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_pregunta',
                'label' => 'identificador de la pregunta',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_respuesta',
                'label' => 'identificador de la respuesta',
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
        if(!$this->form_validation->run()){
            $data = $this->_ver_pregunta($id_pregunta);
            $this->load->view('admin/taller_en_linea/pregunta_detalle_view', $data);
        }
        else{
            $this->load->model('pregunta_model');
            $id_respuesta = $this->input->post('id_respuesta', TRUE);
            $respuesta = $this->input->post('respuesta', TRUE);
            $this->pregunta_model->actualizar_respuesta($id_respuesta, $respuesta);

            $this->load->model('indexacion_model');
            $pregunta = $this->pregunta_model->dar_pregunta($id_pregunta);
            $categoria = $this->pregunta_model->dar_pregunta_categoria($pregunta->id_pregunta_categoria);
            $respuestas = $this->pregunta_model->dar_respuestas($pregunta->id_pregunta);
            $respuestasIndexacion = '';
            foreach($respuestas as $respuesta){
                $respuestasIndexacion.= $respuesta->respuesta.' ';
            }
            $indexacion = $pregunta->titulo_pregunta.' '.$pregunta->cuerpo_pregunta.' '.$categoria->nombre.' '.$pregunta->palabras_clave.' '.$respuestasIndexacion;
            $this->indexacion_model->actualizar_indexacion('taller en línea', $pregunta->id_pregunta, $pregunta->titulo_pregunta, $pregunta->cuerpo_pregunta, $indexacion, 'taller_en_linea/ver_pregunta/'.$pregunta->id_pregunta.'/'.str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)), $pregunta->estado);

            $data = $this->_ver_pregunta($id_pregunta);
            $data['confirmacion'] = 'La respuesta ha sido actualizada con éxito';
            $this->load->view('admin/taller_en_linea/pregunta_detalle_view', $data);
        }
    }

    /**
     * Agrega una nueva categoría
     */
    function agregar_pregunta_categoria(){
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
            $this->load->view('admin/taller_en_linea/pregunta_categoria_agregar_view');
        else{
            $this->load->model('pregunta_model');
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $this->pregunta_model->agregar_pregunta_categoria($nombre);
            $data = $this->_ver_preguntas_categorias();
            $data['confirmacion'] = 'La categoría ha sido agregada con éxito.';
            $this->load->view('admin/taller_en_linea/pregunta_categoria_lista_view', $data);
        }
    }

    /**
     * Elimina una categoría
     */
    function eliminar_pregunta_categoria(){
        $id_pregunta_categoria = $this->uri->segment(4);
        $this->load->model('pregunta_model');
        $existe_llaves_foraneas = $this->pregunta_model->existe_llaves_foraneas_categoria($id_pregunta_categoria);
        if(!$existe_llaves_foraneas)
            $this->pregunta_model->eliminar_pregunta_categoria($id_pregunta_categoria);

        $data = $this->_ver_preguntas_categorias();
        if(!$existe_llaves_foraneas)
            $data['confirmacion'] = 'La categoría ha sido eliminada con éxito.';
        else
            $data['error'] = 'La categoría NO ha sido eliminada con éxito. Existen preguntas asociadas a esta categoría. Elimine primera estas preguntas.';
        $this->load->view('admin/taller_en_linea/pregunta_categoria_lista_view', $data);
    }

    /**
     * Elimina una respuesta y sus "me gusta"
     */
    function eliminar_respuesta(){
        $id_pregunta = $this->uri->segment(4);
        $id_respuesta = $this->uri->segment(5);
        $this->load->model('pregunta_model');
        $this->pregunta_model->eliminar_respuesta($id_respuesta);

        $data = $this->_ver_pregunta($id_pregunta);
        $data['confirmacion'] = 'La respuesta ha sido eliminada con éxito';
        $this->load->view('admin/taller_en_linea/pregunta_detalle_view', $data);
    }

    /**
     * Muestra el formulario para agregar una nueva categoría
     */
    function formulario_pregunta_categoria(){
        $this->load->view('admin/taller_en_linea/pregunta_categoria_agregar_view');
    }

    /**
     * Muestra la lista de preguntas
     */
    function index(){
        $data = $this->_ver_preguntas();
        $this->load->view('admin/taller_en_linea/pregunta_lista_view', $data);
    }

    /**
     * Muestra los detalles de una pregunta y sus respuestas
     */
    function ver_pregunta(){
        $id_pregunta = $this->uri->segment(4);
        //caja de texto
        # Variables de sesion de KCFinder, deben declararse al hacer LogIn con un usuario
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        # Al hacer LogOut deberíamos cambiar disabled a true: $_SESSION['KCFINDER']['disabled'] = true;

        $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => base_url() . "ckeditor/", 'outPut' => true));
        $data = $this->_ver_pregunta($id_pregunta);
        $this->load->view('admin/taller_en_linea/pregunta_detalle_view', $data);
    }

    /**
     * Muestra la lista de categorías de preguntas
     */
    function ver_preguntas_categorias(){
        $data = $this->_ver_preguntas_categorias();
        $this->load->view('admin/taller_en_linea/pregunta_categoria_lista_view', $data);
    }

    /**
     * Da la información de una categoria
     */
    function ver_pregunta_categoria(){
        $id_pregunta_categoria = $this->uri->segment(4);
        $data = $this->_ver_pregunta_categoria($id_pregunta_categoria);
        $this->load->view('admin/taller_en_linea/pregunta_categoria_detalle_view', $data);
    }
}