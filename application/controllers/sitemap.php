<?php

require_once 'laspartes_controller.php';

/**
 * Clase que genera el mapa del sitio
 */
class Sitemap extends Laspartes_Controller{

    /**
     * Constructor de la clase Sitemap
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Muestra el site map
     */
    function index(){
        $this->load->model('noticia_model');
        $this->load->model('tip_model');
        $this->load->model('tutorial_model');

        $urls = array();

        // Urls básicas
        $autopartes = $this->autoparte_model->dar_autopartes( );
        $establecimientos = $this->establecimiento_model->dar_establecimientos( );
        $preguntas = $this->pregunta_model->dar_preguntas( );
        $tips = $this->tip_model->dar_tips( );
        $tutoriales = $this->tutorial_model->dar_tutoriales( );
        $noticias = $this->noticia_model->dar_noticias( );

        foreach ( $autopartes as $autoparte ) {
            $url = array();
            $url['loc'] = base_url().'autopartes/ver_autoparte/'.$autoparte->id_autoparte.'/'.str_replace(' ', '-', convert_accented_characters($autoparte->nombre));
            $url['changefreq'] = 'weekly';
            $url['priority'] = '1';
            array_push( $urls, (object)$url );
        }

        foreach ( $establecimientos as $establecimiento ) {
            $url = array();
            $url['loc'] = base_url().'establecimientos/ver_establecimiento/'.$establecimiento->id_establecimiento.'/'.str_replace(' ', '-', convert_accented_characters($establecimiento->nombre));
            $url['changefreq'] = 'weekly';
            $url['priority'] = '1';
            array_push( $urls, (object)$url );
        }

        foreach ( $preguntas as $pregunta ) {
            $url = array();
            $url['loc'] = base_url().'taller_en_linea/ver_pregunta/'.$pregunta->id_pregunta.'/'.str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta));
            $url['changefreq'] = 'weekly';
            $url['priority'] = '1';
            array_push( $urls, (object)$url );
        }

        foreach ( $tips as $tip ) {
            $url = array();
            $url['loc'] = base_url().'aprende/tip/'.$tip->id_tip.'/'.str_replace(' ', '-', convert_accented_characters($tip->titulo));
            $url['changefreq'] = 'weekly';
            $url['priority'] = '1';
            array_push( $urls, (object)$url );
        }

        foreach ( $tutoriales as $tutorial ) {
            $url = array();
            $url['loc'] = base_url().'aprende/tutorial/'.$tutorial->id_tutorial.'/'.str_replace(' ', '-', convert_accented_characters($tutorial->titulo));
            $url['changefreq'] = 'weekly';
            $url['priority'] = '1';
            array_push( $urls, (object)$url );
        }

        foreach ( $noticias as $noticia ) {
            $url = array();
            $url['loc'] = base_url().'aprende/noticia/'.$noticia->id_noticia.'/'.str_replace(' ', '-', convert_accented_characters($noticia->titulo));
            $url['changefreq'] = 'weekly';
            $url['priority'] = '1';
            array_push( $urls, (object)$url );
        }

        // Urls sobre búsquedas
        $categoriasAutopartes = $this->autoparte_model->dar_autopartes_categorias();
        $zonasEstablecimientos = $this->establecimiento_model->dar_establecimientos_zonas();
        $serviciosEstablecimientos = $this->establecimiento_model->dar_establecimientos_servicios();
        $categoriasPreguntas = $this->pregunta_model->dar_preguntas_categorias();

        foreach ( $categoriasAutopartes as $catAut ) {
            $url = array();
            $url['loc'] = base_url().'autopartes/index/'.convert_accented_characters( $catAut->nombre ).'/todas-las-marcas/nombre/todas-las-marcas/todas-las-lineas/50/0';
            $url['changefreq'] = 'daily';
            $url['priority'] = '0.6';
            array_push( $urls, (object)$url );
        }

        foreach ( $zonasEstablecimientos as $zonaEst ) {
            $url = array();
            $url['loc'] = base_url().'establecimientos/index/todos-los-servicios/'.convert_accented_characters( $zonaEst->nombre ).'/nombre/50/0';
            $url['changefreq'] = 'weekly';
            $url['priority'] = '0.6';
            array_push( $urls, (object)$url );
        }

        foreach ( $serviciosEstablecimientos as $servicioEst ) {
            $url = array();
            $url['loc'] = base_url().'establecimientos/index/'.convert_accented_characters( $servicioEst->nombre ).'todas-las-zonas/nombre/50/0';
            $url['changefreq'] = 'weekly';
            $url['priority'] = '0.6';
            array_push( $urls, (object)$url );
        }

        foreach ( $categoriasPreguntas as $catPreg ) {
            $url = array();
            $url['loc'] = base_url().'taller_en_linea/ver_preguntas/'.convert_accented_characters( $catPreg->nombre ).'/recientes/50/0';
            $url['changefreq'] = 'daily';
            $url['priority'] = '0.6';
            array_push( $urls, (object)$url );
        }

        $data['urls'] = $urls;
        $this->load->view('sitemap/sitemap_view', $data);
    }
}