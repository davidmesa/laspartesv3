<?php

/**
 * Clase que maneja la reindexacion de autopartes, establecimientos, y preguntas
 */
class Reindexacion extends CI_Controller{

    /**
     * Constructor de la clase Reindexacion
     * Valida si el usuario tiene una sesión activa
     */
    function __construct(){
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');
        if(!isset($esta_registrado)||!$esta_registrado||$this->session->userdata('tipo')!=10)
            redirect(base_url().'admin/inicio', 'refresh');
    }

    function index(){
        $this->load->model('indexacion_model');
        $this->load->model('autoparte_model');
        $autopartes = $this->autoparte_model->dar_autopartes();

        if(sizeof($autopartes)!=0){
            foreach($autopartes as $autoparte){
                $vehiculos_indexacion = '';
                $vehiculos = $this->autoparte_model->dar_autoparte_vehiculos($autoparte->id_autoparte);
                foreach($vehiculos as $vehiculo)
                    $vehiculos_indexacion.= $vehiculo->marca.' '.$vehiculo->linea.'  ';
                $marca = $this->autoparte_model->dar_autoparte_marca($autoparte->id_autoparte_marca);
                $categoria = $this->autoparte_model->dar_autoparte_categoria($autoparte->id_autoparte_categoria);
                if($autoparte->descripcion == NULL)
                    $autoparte->descripcion = "";
                $indexacion = $autoparte->nombre.' '.$autoparte->descripcion.' '.$autoparte->origen.' '.$autoparte->referencia.' '.$vehiculos_indexacion.' '.$marca->nombre.' '.$categoria->nombre;
                $this->indexacion_model->agregar_indexacion('autopartes', $autoparte->id_autoparte, $autoparte->nombre, $autoparte->descripcion, $indexacion, 'autopartes/'.$autoparte->id_autoparte.'-'.str_replace(' ', '-', convert_accented_characters($autoparte->nombre)), $autoparte->estado);
            }
        }

        $this->load->model('establecimiento_model');
        $establecimientos = $this->establecimiento_model->dar_establecimientos();

        if(sizeof($establecimientos)!=0){
            foreach($establecimientos as $establecimiento){
                $servicios_indexacion = '';
            $servicios = $this->establecimiento_model->dar_establecimiento_servicios($establecimiento->id_establecimiento);
            foreach($servicios as $servicio)
                $servicios_indexacion.= $servicio->nombre.' ';
            $zona = $this->establecimiento_model->dar_zona($establecimiento->id_zona);
            $indexacion = $establecimiento->nombre.' '.$establecimiento->email.' '.$establecimiento->direccion.' '.$establecimiento->web.' '.$establecimiento->descripcion.' '.$establecimiento->horario.' '.$zona->nombre.' '.$servicios_indexacion;
            $this->indexacion_model->agregar_indexacion('talleres', $establecimiento->id_establecimiento, $establecimiento->nombre, $establecimiento->descripcion, $indexacion, 'talleres/'.$establecimiento->id_establecimiento.'-'.str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)), $establecimiento->estado);

            }
        }

        $this->load->model('pregunta_model');
        $preguntas = $this->pregunta_model->dar_preguntas();
        if(sizeof($preguntas)!=0){
            foreach($preguntas as $pregunta){
                $categoria = $this->pregunta_model->dar_pregunta_categoria($pregunta->id_pregunta_categoria);
                $respuestas = $this->pregunta_model->dar_respuestas($pregunta->id_pregunta);
                $respuestasIndexacion = '';
                foreach($respuestas as $respuesta){
                    $respuestasIndexacion.= $respuesta->respuesta.' ';
                }
                $indexacion = $pregunta->titulo_pregunta.' '.$pregunta->cuerpo_pregunta.' '.$categoria->nombre.' '.$pregunta->palabras_clave.' '.$respuestasIndexacion;
                $this->indexacion_model->agregar_indexacion('preguntas', $pregunta->id_pregunta, $pregunta->titulo_pregunta, $pregunta->cuerpo_pregunta, $indexacion, 'preguntas/'.$pregunta->id_pregunta.'-'.str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)), $pregunta->estado);
            }
        }

        $this->load->model('noticia_model');
        $noticias = $this->noticia_model->dar_noticias();
        if(sizeof($noticias)!=0){
            foreach($noticias as $noticia){
                $indexacion = $noticia->titulo.' '.$noticia->noticia;
                $this->indexacion_model->agregar_indexacion('noticias', $noticia->id_noticia, $noticia->titulo, $noticia->noticia, $indexacion, 'noticias/'.$noticia->id_noticia.'-'.str_replace(' ', '-', convert_accented_characters($noticia->titulo)), $noticia->estado);
            }
        }

        $this->load->model('tip_model');
        $tips = $this->tip_model->dar_tips();
        if(sizeof($tips)!=0){
            foreach($tips as $tip){
                $indexacion = $tip->titulo.' '.$tip->tip;
                $this->indexacion_model->agregar_indexacion('tips', $tip->id_tip, $tip->titulo, $tip->tip, $indexacion, 'tips/'.$tip->id_tip.'-'.str_replace(' ', '-', convert_accented_characters($tip->titulo)), $tip->estado);
            }
        }

        $this->load->model('tutorial_model');
        $tutoriales = $this->tutorial_model->dar_tutoriales();
        if(sizeof($tutoriales)!=0){
            foreach($tutoriales as $tutorial){
                $tutorial_pasos = $this->tutorial_model->dar_tutorial_pasos($tutorial->id_tutorial);

                $pasos_indexacion = '';
                foreach($tutorial_pasos as $tutorial_paso)
                    $pasos_indexacion .= $tutorial_paso->paso.' ';

                $indexacion = $tutorial->titulo.' '.$tutorial->resumen.' '.$pasos_indexacion;
                $this->indexacion_model->agregar_indexacion('tutoriales', $tutorial->id_tutorial, $tutorial->titulo, $tutorial->resumen, $indexacion, 'aprende/tutorial/'.$tutorial->id_tutorial.'/'.str_replace(' ', '-', convert_accented_characters($tutorial->titulo)), $tutorial->estado);
            }
        }
    }

}