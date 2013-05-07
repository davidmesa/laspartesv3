<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja las búsquedas
 */
class Buscar extends Laspartes_Controller{

    /**
     * Constructor de la clase Buscar
     */
    function __construct(){
        parent::__construct(); 
    }

    /**
     * Busca en la seccion aprende de acuerdo a las palabras
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function _buscar_aprende($busqueda, $limit, $offset){
        $this->load->model('indexacion_model');
        $this->load->library('pagination');
        $numero_resultados = $this->indexacion_model->contar_resultados_aprende($busqueda);
        $config = array(
            'base_url' => base_url().'/buscar/aprende/'.str_replace(' ', '-', convert_accented_characters($busqueda)).'/'.$limit,
            'total_rows' => $numero_resultados,
            'per_page' => $limit,
            'num_links' => 1,
            'uri_segment' => 5,
            'first_link' => '[Primera]',
            'last_link' => '[Última]',
            'next_link' => '[Siguiente]',
            'prev_link' => '[Anterior]'
        );
        $this->pagination->initialize($config);
        $data['resultados'] = $this->indexacion_model->dar_indexacion_aprende($busqueda, $limit, $offset);
        return $data;
    }

    /**
     * Busca las autopartes de acuerdo a las palabras
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function _buscar_autopartes($busqueda, $limit, $offset){
        $this->load->model('indexacion_model');
        $this->load->library('pagination');
        $numero_resultados = $this->indexacion_model->contar_resultados_autopartes($busqueda);
        $config = array(
            'base_url' => base_url().'/buscar/autopartes/'.str_replace(' ', '-', convert_accented_characters($busqueda)).'/'.$limit,
            'total_rows' => $numero_resultados,
            'per_page' => $limit,
            'num_links' => 1,
            'uri_segment' => 5,
            'first_link' => '[Primera]',
            'last_link' => '[Última]',
            'next_link' => '[Siguiente]',
            'prev_link' => '[Anterior]'
        );
        $this->pagination->initialize($config);
        $data['resultados'] = $this->indexacion_model->dar_indexacion_autopartes($busqueda, $limit, $offset);
        return $data;
    }

    /**
     * Busca los establecimientos de acuerdo a las palabras
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function _buscar_establecimientos($busqueda, $limit, $offset){
        $this->load->model('indexacion_model');
        $this->load->library('pagination');
        $numero_resultados = $this->indexacion_model->contar_resultados_establecimientos($busqueda);
        $config = array(
            'base_url' => base_url().'/buscar/establecimientos/'.str_replace(' ', '-', convert_accented_characters($busqueda)).'/'.$limit,
            'total_rows' => $numero_resultados,
            'per_page' => $limit,
            'num_links' => 1,
            'uri_segment' => 5,
            'first_link' => '[Primera]',
            'last_link' => '[Última]',
            'next_link' => '[Siguiente]',
            'prev_link' => '[Anterior]'
        );
        $this->pagination->initialize($config);
        $data['resultados'] = $this->indexacion_model->dar_indexacion_establecimientos($busqueda, $limit, $offset);
        return $data;
    }

    /**
     * Busca general de acuerdo a las palabras
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function _buscar_general($busqueda, $limit, $offset){
        $offset = $offset -1;
        $this->load->model('indexacion_model');
        $numero_resultados =  (int)($this->indexacion_model->contar_resultados_general($busqueda)/10) +1;
        $data['numero_resultados'] = $numero_resultados;
        $data['resultados'] = $this->indexacion_model->dar_indexacion_general($busqueda, $limit, $offset);
        return $data;
    }

    /**
     * Busca los resultados de la seccón taller en línea de acuerdo a las palabras
     * @param String $busqueda
     * @param int $limit
     * @param int $offset
     * @return array $resultados
     */
    function _buscar_taller_en_linea($busqueda, $limit, $offset){
        $this->load->model('indexacion_model');
        $this->load->library('pagination');
        $numero_resultados = $this->indexacion_model->contar_resultados_taller_en_linea($busqueda);
        $config = array(
            'base_url' => base_url().'/buscar/taller_en_linea/'.str_replace(' ', '-', convert_accented_characters($busqueda)).'/'.$limit,
            'total_rows' => $numero_resultados,
            'per_page' => $limit,
            'num_links' => 1,
            'uri_segment' => 5,
            'first_link' => '[Primera]',
            'last_link' => '[Última]',
            'next_link' => '[Siguiente]',
            'prev_link' => '[Anterior]'
        );
        $this->pagination->initialize($config);
        $data['resultados'] = $this->indexacion_model->dar_indexacion_taller_en_linea($busqueda, $limit, $offset);
        return $data;
    }

    /**
     * Muestra los resultado de aprende relacionadas con las palabras dadas
     */
    function aprende(){
        $busqueda = strtolower($this->input->post('busqueda', TRUE));
        $limit = 10;
        $offset = 0;
        if(!$busqueda){
            $busqueda = str_replace('-', ' ', convert_accented_characters($this->uri->segment(3, '')));
            $limit = $this->uri->segment(4, 10);
            $offset = $this->uri->segment(5, 0);
        }

        $data = $this->_buscar_aprende($busqueda, $limit, $offset);
        $data['seccion'] = 'aprende';
        $data['busqueda'] = $busqueda;
        $data['limit'] = $limit;
        $data['offset'] = $offset;

        $data['titulo'] = 'Búsqueda en Aprende';
        $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: Búsqueda';
        $data['navegacion_view'] = 'aprende';
        
        $data['header_view'] = 'busqueda/header/resultado_view';
        $data['contenido_view'] = 'busqueda/resultado_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra las autopartes relacionadas con las palabras dadas
     */
    function autopartes(){
        $busqueda = strtolower($this->input->post('busqueda', TRUE));
        $limit = 10;
        $offset = 0;
        if(!$busqueda){
            $busqueda = str_replace('-', ' ', convert_accented_characters($this->uri->segment(3, '')));
            $limit = $this->uri->segment(4, 10);
            $offset = $this->uri->segment(5, 0);
        }

        $data = $this->_buscar_autopartes($busqueda, $limit, $offset);
        $data['seccion'] = 'autopartes';
        $data['busqueda'] = $busqueda;
        $data['limit'] = $limit;
        $data['offset'] = $offset;

        $data['titulo'] = 'Búsqueda en Autopartes';
        $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: Búsqueda';
        $data['header_view'] = 'busqueda/header/resultado_view';
        $data['navegacion_view'] = 'autopartes';
        $data['contenido_view'] = 'busqueda/resultado_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra una búsqueda en todas las secciones
     */
    function general($busqueda = '', $op, $offset = 1){
        $limit = 10;

        $data = $this->_buscar_general($busqueda, $limit, $offset);
        $data['seccion'] = 'general';
        $data['busqueda'] = $busqueda;
        $data['limit'] = $limit;
        $data['offset'] = $offset;

        $data['titulo'] = 'Búsqueda';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Búsqueda</div>';
        $data['header_view'] = 'busqueda/header/resultado_view';
        $data['navegacion_view'] = 'inicio';
        $data['contenido_view'] = 'busqueda/resultado_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra los establecimientos relacionadas con las palabras dadas
     */
    function establecimientos(){
        $busqueda = strtolower($this->input->post('busqueda', TRUE));
        $limit = 10;
        $offset = 0;
        if(!$busqueda){
            $busqueda = str_replace('-', ' ', convert_accented_characters($this->uri->segment(3, '')));
            $limit = $this->uri->segment(4, 10);
            $offset = $this->uri->segment(5, 0);
        }
        
        $data = $this->_buscar_establecimientos($busqueda, $limit, $offset);
        $data['seccion'] = 'establecimientos';
        $data['busqueda'] = $busqueda;
        $data['limit'] = $limit;
        $data['offset'] = $offset;

        $data['titulo'] = 'Búsqueda en Establecimientos';
        $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: Búsqueda';
        $data['header_view'] = 'busqueda/header/resultado_view';
        $data['navegacion_view'] = 'establecimientos';
        $data['contenido_view'] = 'busqueda/resultado_view';
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra las preguntas relacionadas con las palabras dadas
     */
    function taller_en_linea(){
        $busqueda = strtolower($this->input->post('busqueda', TRUE));
        $limit = 10;
        $offset = 0;
        if(!$busqueda){
            $busqueda = str_replace('-', ' ', convert_accented_characters($this->uri->segment(3, '')));
            $limit = $this->uri->segment(4, 10);
            $offset = $this->uri->segment(5, 0);
        }

        $data = $this->_buscar_taller_en_linea($busqueda, $limit, $offset);
        $data['seccion'] = 'taller_en_linea';
        $data['busqueda'] = $busqueda;
        $data['limit'] = $limit;
        $data['offset'] = $offset;

        $data['titulo'] = 'Búsqueda en Taller en Línea';
        $data['breadcrumb'] = '<a href="'.base_url().'">Inicio</a> :: Búsqueda';
        $data['header_view'] = 'busqueda/header/resultado_view';
        $data['navegacion_view'] = 'tallerenlinea';
        $data['tab'] = 'noticias';
        $data['contenido_view'] = 'busqueda/resultado_view';
        $this->load->view('template/template', $data);
    }
}