<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en las tablas
 * preguntas, respuestas, preguntas_categorias
 */
class Pregunta_model extends CI_Model{

    /**
     * Constructor de la clase Pregunta_model
     */
    function __construct(){
        parent::__construct();
    }

    /**
     * Actualiza una pregunta
     * @param int $id_pregunta
     * @param String $titulo_pregunta
     * @param String $cuerpo_pregunta
     * @param int $id_pregunta_categoria
     * @param String $palabras_clave
     * @param String $estado
     */
    function actualizar_pregunta($id_pregunta, $titulo_pregunta, $cuerpo_pregunta, $id_pregunta_categoria, $palabras_clave, $estado){
        $this->db->escape($id_pregunta);
        $this->db->escape($titulo_pregunta);
        $this->db->escape($cuerpo_pregunta);
        $this->db->escape($id_pregunta_categoria);
        $this->db->escape($palabras_clave);
        $this->db->escape($estado);
        $this->db->set('titulo_pregunta', $titulo_pregunta);
        $this->db->set('cuerpo_pregunta', $cuerpo_pregunta);
        $this->db->set('id_pregunta_categoria', $id_pregunta_categoria);
        $this->db->set('palabras_clave', $palabras_clave);
        $this->db->set('estado', $estado);
        $this->db->where('id_pregunta', $id_pregunta);
        $this->db->limit(1);
        $this->db->update('preguntas');
    }

    /**
     * Actualiza una categoria
     * @param int $id_pregunta_categoria
     * @param String $nombre
     */
    function actualizar_pregunta_categoria($id_pregunta_categoria, $nombre){
        $this->db->escape($id_pregunta_categoria);
        $this->db->escape($nombre);
        $this->db->set('nombre', $nombre);
        $this->db->where('id_pregunta_categoria', $id_pregunta_categoria);
        $this->db->limit(1);
        $this->db->update('preguntas_categorias');
    }

    /**
     * Actualiza una respuesta
     * @param int $id_respuesta
     * @param String $respuesta
     */
    function actualizar_respuesta($id_respuesta, $respuesta){
        $this->db->escape($id_respuesta);
        $this->db->escape($respuesta);
        $this->db->set('respuesta', $respuesta);
        $this->db->where('id_respuesta', $id_respuesta);
        $this->db->limit(1);
        $this->db->update('respuestas');
    }
    
    /**
     * Actualiza el campo me_gusta de una respuesta
     * @param int $id_respuesta
     */
    function actualizar_respuesta_me_gusta($id_respuesta){
        $this->db->escape($id_respuesta);
        $this->db->set('me_gusta', 'me_gusta+1', FALSE);
        $this->db->where('id_respuesta', $id_respuesta);
        $this->db->limit(1);
        $this->db->update('respuestas');
    }

    /**
     * Agrega un nuevo me gusta
     * @param int $id_usuario
     * @param int $id_respuesta
     * @param bool $me_gusta
     */
    function agregar_me_gusta($id_usuario, $id_respuesta, $me_gusta){
        $this->db->escape($id_usuario);
        $this->db->escape($id_respuesta);
        $this->db->escape($me_gusta);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('id_respuesta', $id_respuesta);
        $this->db->set('me_gusta', $me_gusta);
        $this->db->insert('respuestas_me_gustan');
    }

    /**
     * Agrega una nueva pregunta
     * @param int $id_usuario
     * @param String $titulo_pregunta
     * @param String $cuerpo_pregunta
     * @param int $id_categoria
     * @param String $palabras_clave
     * @return int $id_pregunta
     */
    function agregar_pregunta($id_usuario, $titulo_pregunta, $cuerpo_pregunta, $id_pregunta_categoria, $palabras_clave, $img, $estado = 'Activo'){
        $this->db->escape($id_usuario);
        $this->db->escape($titulo_pregunta);
        $this->db->escape($cuerpo_pregunta);
        $this->db->escape($id_pregunta_categoria);
        $this->db->escape($id_pregunta_categoria);
        $this->db->escape($img);
        $this->db->set('img_url', $img);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('titulo_pregunta', $titulo_pregunta);
        $this->db->set('cuerpo_pregunta', $cuerpo_pregunta);
        $this->db->set('id_pregunta_categoria', $id_pregunta_categoria);
        $this->db->set('palabras_clave', $palabras_clave);
        $this->db->set('fecha', 'now()', FALSE);
        $this->db->set('estado', $estado);
        $this->db->insert('preguntas');
        return mysql_insert_id();
    }

    /**
     * Agrega una nueva categoría
     * @param String $nombre
     */
    function agregar_pregunta_categoria($nombre){
        $this->db->escape($nombre);
        $this->db->set('nombre', $nombre);
        $this->db->insert('preguntas_categorias');
    }

    /**
     * Agrega una respuesta
     * @param int $id_pregunta
     * @param int $id_usuario
     * @param String $respuesta
     * @return int $id_respuesta
     */
    function agregar_respuesta($id_pregunta, $id_usuario, $respuesta){
        $this->db->escape($id_pregunta);
        $this->db->set('numero_respuestas', 'numero_respuestas+1', FALSE);
        $this->db->where('id_pregunta', $id_pregunta);
        $this->db->update('preguntas');

        $this->db->flush_cache();
        $this->db->escape($id_pregunta);
        $this->db->escape($id_usuario);
        $this->db->escape($respuesta);
        $this->db->set('id_pregunta', $id_pregunta);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('respuesta', $respuesta);
        $this->db->set('fecha', 'now()', FALSE);
        $this->db->insert('respuestas');
        return mysql_insert_id();
    }

    /**
     * Cuenta el número de preguntas existentes según la categoriía
     * @param String $categoria
     * @return int $numero_preguntas
     */
    function contar_preguntas($categoria){
        $this->db->escape($categoria);
        $this->db->select('preguntas.id_pregunta');
        $this->db->distinct();
        if($categoria!=''){
            $this->db->join('preguntas_categorias', 'preguntas_categorias.id_pregunta_categoria = preguntas.id_pregunta_categoria');
            $this->db->where('preguntas_categorias.nombre', $categoria);
        }
        $this->db->where('preguntas.estado', 'Activo');
        $query = $this->db->get('preguntas');
        return $query->num_rows();
    }

    /**
     * Da la información de me gusta de un usuario y pregunta
     * @param int $id_usuario
     * @param int $id_pregunta
     * @return array $me_gustan
     */
    function dar_respuestas_me_gustan($id_usuario, $id_pregunta){
        $this->db->escape($id_usuario);
        $this->db->escape($id_pregunta);
        $this->db->select('respuestas_me_gustan.id_respuesta, respuestas_me_gustan.id_usuario, respuestas_me_gustan.me_gusta');
        $this->db->distinct();
        $this->db->join('respuestas', 'respuestas.id_respuesta = respuestas_me_gustan.id_respuesta');
        $this->db->where('respuestas_me_gustan.id_usuario', $id_usuario);
        $this->db->where('id_pregunta', $id_pregunta);
        $query = $this->db->get('respuestas_me_gustan');
        return $query->result();
    }

    /**
     * Da los datos de una pregunta
     * @param int $id_pregunta
     * @return object $pregunta
     */
    function dar_pregunta($id_pregunta){
        $this->db->escape($id_pregunta);    
        $this->db->select('id_pregunta, preguntas.id_usuario, id_pregunta_categoria, titulo_pregunta, cuerpo_pregunta, 
            numero_respuestas, palabras_clave, fecha, preguntas.estado, usuario, usuarios.imagen_thumb_url, usuarios.email, usuarios.imagen_url, usuarios.nombres, usuarios.apellidos,
            establecimientos.logo_url as thumb, establecimientos.id_establecimiento as idEstablecimiento, establecimientos.nombre as nombreEstablecimiento');
        $this->db->join('usuarios', 'usuarios.id_usuario = preguntas.id_usuario');
        $this->db->join('establecimientos','establecimientos.id_usuario = usuarios.id_usuario', 'left');
        $this->db->where('id_pregunta', $id_pregunta);
        $this->db->limit(1);
        $query = $this->db->get('preguntas');
        return $query->row(0);
    }

    /**
     * Da los datos de una categoria
     * @param int $id_pregunta_categoria
     * @return object $categoria
     */
    function dar_pregunta_categoria($id_pregunta_categoria){
        $this->db->escape($id_pregunta_categoria);
        $this->db->where('id_pregunta_categoria', $id_pregunta_categoria);
        $this->db->limit(1);
        $query = $this->db->get('preguntas_categorias');
        return $query->row(0);
    }

    /**
     * Da la lista de preguntas
     * @return array $preguntas
     */
    function dar_preguntas(){
        $this->db->select('id_pregunta, id_pregunta_categoria, titulo_pregunta, cuerpo_pregunta, numero_respuestas, preguntas.estado, usuario, palabras_clave');
        $this->db->join('usuarios', 'usuarios.id_usuario = preguntas.id_usuario');
        $this->db->order_by('preguntas.id_pregunta', 'desc'); 
        $query = $this->db->get('preguntas');
        return $query->result();
    }

    /**
     * Da la lista de preguntas asociadas a una categoria
     * @return int $id_pregunta_categoria
     * @return array $preguntas
     */
    function dar_preguntas_categoria($id_pregunta_categoria){
        $this->db->escape($id_pregunta_categoria);
        $this->db->where('id_pregunta_categoria', $id_pregunta_categoria);
        $query = $this->db->get('preguntas');
        return $query->result();
    }

    /**
     * Da la lista de preguntas que se han hecho últimamente
     * @return array $preguntas
     */
    function dar_preguntas_ultimas($numero_preguntas = 5){
        $this->db->select('id_pregunta, preguntas.id_pregunta_categoria, titulo_pregunta, cuerpo_pregunta, 
            numero_respuestas, preguntas.estado, palabras_clave, preguntas.fecha, usuarios.nombres as nombres, usuarios.apellidos as apellidos');
        $this->db->join('preguntas_categorias', 'preguntas_categorias.id_pregunta_categoria = preguntas.id_pregunta_categoria');
        $this->db->join('usuarios', 'preguntas.id_usuario = usuarios.id_usuario');
        $this->db->order_by('preguntas.fecha', 'desc');
        $this->db->limit($numero_preguntas, 0);
        $query = $this->db->get('preguntas');
        return $query->result();
    }


    /**
     * Da la lista de categorías de preguntas
     * @return array $preguntas_categorias
     */
    function dar_preguntas_categorias(){
        $this->db->order_by('nombre', 'asc');
        $query = $this->db->get('preguntas_categorias');
        return $query->result();
    }

    /**
     * Da la lista de categorías de preguntas con la cantidad de preguntas relacionadas
     * @return array $preguntas_categorias
     */
    function dar_preguntas_categorias_cantidad(){
        $this->db->select('nombre, COUNT(*) AS cantidad, preguntas_categorias.id_pregunta_categoria');
        $this->db->distinct();
        $this->db->join('preguntas_categorias', 'preguntas_categorias.id_pregunta_categoria = preguntas.id_pregunta_categoria');
        $this->db->where('estado', 'Activo');
        $this->db->group_by('nombre');
        $query = $this->db->get('preguntas');
        return $query->result();
    }

    /**
     * Da la lista de preguntas de acuerdo a los parámetros
     * @param int $limit
     * @param int $offset
     * @param String $categoria
     * @param String $orden
     * @return array $preguntas
     */
    function dar_preguntas_paginacion_filtros($limit, $offset, $categoria){
        $this->db->select('preguntas.id_pregunta, preguntas.id_pregunta_categoria, 
            preguntas.titulo_pregunta, preguntas.cuerpo_pregunta, preguntas.fecha, preguntas_categorias.nombre AS pregunta_categoria, 
            usuarios.imagen_url, usuarios.usuario, usuarios.nombres, usuarios.apellidos, establecimientos.logo_thumb_url as thumb, 
            establecimientos.id_establecimiento as idEstablecimiento, establecimientos.nombre as nombreEstablecimiento, 
            count(respuestas.id_respuesta) as numeroRespuestas');
        $this->db->join('preguntas_categorias', 'preguntas_categorias.id_pregunta_categoria = preguntas.id_pregunta_categoria');
        $this->db->join('usuarios', 'usuarios.id_usuario = preguntas.id_usuario');
        $this->db->join('establecimientos','establecimientos.id_usuario = usuarios.id_usuario', 'left');
        $this->db->join('respuestas','preguntas.id_pregunta = respuestas.id_pregunta', 'left');
        if($categoria!='')
            $this->db->where('preguntas_categorias.nombre', $categoria);
        $this->db->where('preguntas.estado', 'Activo');
        $this->db->order_by('preguntas.id_pregunta', 'desc');
        $this->db->group_by('preguntas.id_pregunta');
        $this->db->limit($limit, $offset*10);
        $query = $this->db->get('preguntas');
        return $query->result();
    }

    /**
     * Da las preguntas de la misma categoría, excluyendo la pregunta base
     * @param int $id_pregunta
     * @param int $id_pregunta_categoria
     * @return array $preguntas
     */
    function dar_preguntas_categoria_relacionadas($id_pregunta, $id_pregunta_categoria){
        $this->db->escape($id_pregunta);
        $this->db->escape($id_pregunta_categoria);
        $this->db->select('id_pregunta, titulo_pregunta, fecha, cuerpo_pregunta');
        $this->db->where('id_pregunta_categoria', $id_pregunta_categoria);
        $this->db->where_not_in('id_pregunta', $id_pregunta);
        $this->db->limit(5);
        $this->db->order_by('preguntas.id_pregunta', 'desc');
        $query = $this->db->get('preguntas');
        return $query->result();
    }

    /**
     * Da la lista de preguntas de un usuario
     * @param int $id_usuario
     * @return array $preguntas
     */
    function dar_preguntas_usuario($id_usuario, $offset = -1){ 
        $this->db->escape($id_usuario);
        $this->db->escape($offset);
        $this->db->select('preguntas.id_pregunta, preguntas.id_pregunta_categoria, preguntas.titulo_pregunta, preguntas.cuerpo_pregunta, preguntas.fecha, preguntas.numero_respuestas, preguntas.estado, preguntas_categorias.nombre AS pregunta_categoria');
        $this->db->join('preguntas_categorias', 'preguntas_categorias.id_pregunta_categoria = preguntas.id_pregunta_categoria');
        $this->db->where('estado', 'Activo');
        $this->db->where('id_usuario', $id_usuario);
        if($offset != -1){
          $this->db->limit(5, $offset);  
        }
        $this->db->order_by('preguntas.fecha', 'desc');
        $query = $this->db->get('preguntas');
        return $query->result();
    }

    /**
     * Da las respuestas de una pregunta
     * @param int $id_pregunta
     * @return array $respuestas
     */
    function dar_respuestas($id_pregunta){
        $this->db->escape($id_pregunta);
        $this->db->select('id_respuesta, respuestas.id_usuario, fecha, respuesta, me_gusta, no_me_gusta, usuario, 
            usuarios.imagen_thumb_url, usuarios.imagen_url, usuarios.email, establecimientos.logo_url as thumb, 
            establecimientos.id_establecimiento as idEstablecimiento, establecimientos.nombre as nombreEstablecimiento ');
        $this->db->join('usuarios', 'usuarios.id_usuario = respuestas.id_usuario');
         $this->db->join('establecimientos','establecimientos.id_usuario = usuarios.id_usuario', 'left');
        $this->db->where('id_pregunta', $id_pregunta);
        $query = $this->db->get('respuestas');
        return $query->result();
    }
    
    /**
     * Da las respuestas de una pregunta
     * @param int $id_pregunta
     * @return array $respuestas
     */
    function dar_respuestas_destinatarios($id_pregunta){
        $this->db->escape($id_pregunta);
        $this->db->select('usuarios.* ');  
        $this->db->distinct();
        $this->db->join('usuarios', 'usuarios.id_usuario = respuestas.id_usuario');
        $this->db->where('id_pregunta', $id_pregunta);
        $query = $this->db->get('respuestas');
        return $query->result();
    }
    
    /**
     * Da las respuestas de una pregunta
     * @param int $id_pregunta
     * @return array $respuestas
     */
    function dar_respuesta($id_respuesta){
        $this->db->escape($id_respuesta);
        $this->db->select('id_respuesta, respuestas.id_usuario, fecha, respuesta, me_gusta, no_me_gusta, usuario, usuarios.nombres, usuarios.apellidos,
            imagen_thumb_url, imagen_url, usuarios.email, establecimientos.logo_thumb_url as thumb, 
            establecimientos.id_establecimiento as idEstablecimiento, establecimientos.nombre as nombreEstablecimiento ');
        $this->db->join('usuarios', 'usuarios.id_usuario = respuestas.id_usuario');
         $this->db->join('establecimientos','establecimientos.id_usuario = usuarios.id_usuario', 'left');
        $this->db->where('id_respuesta', $id_respuesta);
        $query = $this->db->get('respuestas');
        return $query->row(0);
    }

    /**
     * Da las preguntas que ha respondido un usuario
     * @param int $id_usuario
     * @return array $preguntas
     */
    function dar_preguntas_respuestas_usuario($id_usuario){
        $this->db->escape($id_usuario);
        $this->db->select('preguntas.id_pregunta, preguntas.id_pregunta_categoria, preguntas.titulo_pregunta, preguntas.cuerpo_pregunta, preguntas.fecha, preguntas.numero_respuestas, preguntas_categorias.nombre AS pregunta_categoria, imagen_thumb_url, id_respuesta, respuesta');
        $this->db->distinct();
        $this->db->join('preguntas_categorias', 'preguntas_categorias.id_pregunta_categoria = preguntas.id_pregunta_categoria');
        $this->db->join('respuestas', 'respuestas.id_pregunta = preguntas.id_pregunta');
        $this->db->join('usuarios', 'usuarios.id_usuario = preguntas.id_usuario');
        $this->db->where('preguntas.estado', 'Activo');
        $this->db->where('respuestas.id_usuario', $id_usuario);
        $this->db->order_by('preguntas.id_pregunta', 'asc');
        $query = $this->db->get('preguntas');
        return $query->result();
    }

    /**
     * Elimina una categoria
     * @param int $id_pregunta_categoria
     */
    function eliminar_pregunta_categoria($id_pregunta_categoria){
        $this->db->escape($id_pregunta_categoria);
        $this->db->where('id_pregunta_categoria', $id_pregunta_categoria);
        $this->db->delete('preguntas_categorias');
    }

    /**
     * Elimina los "me_gusta" de la respuesta
     * Actualiza el número de me_gusta de la respuesta
     * Elimina la respuesta
     * @param int $id_respuesta
     */
    function eliminar_respuesta($id_respuesta){
        $this->db->escape($id_respuesta);
        $this->db->where('id_respuesta', $id_respuesta);
        $this->db->delete('respuestas_me_gustan');
        
        $this->db->flush_cache();
        $this->db->escape($id_respuesta);
        $this->db->where('id_respuesta', $id_respuesta);
        $query = $this->db->get('respuestas');
        $respuesta = $query->row(0);
        
        $this->db->flush_cache();
        $this->db->set('numero_respuestas', 'numero_respuestas-1', FALSE);
        $this->db->where('id_pregunta', $respuesta->id_pregunta);
        $this->db->update('preguntas');

        $this->db->flush_cache();
        $this->db->escape($id_respuesta);
        $this->db->where('id_respuesta', $id_respuesta);
        $this->db->delete('respuestas');
    }

    /**
     * Retorna si existen llaves foráneas respecto a una categoría
     * @param int $id_pregunta_categoria
     * @return boolean $existe true si sí existen llaves foráneas (fk)
     */
    function existe_llaves_foraneas_categoria($id_pregunta_categoria){
        $this->db->escape($id_pregunta_categoria);
        $this->db->where('id_pregunta_categoria', $id_pregunta_categoria);
        $query = $this->db->get('preguntas');
        if($query->num_rows()==0)
            return FALSE;
        return TRUE;
    }
    
    /**
     * Este método devuelve las preguntas que ha respondido un usuario dado. 
     * Agregar un parámetro opcional que represente el offset. 
     * El valor por defecto de este parámetro es -1. 
     * En dado caso que $offset sea -1, es decir no hayan especificado el parámetro, 
     * el método retorna TODAS las preguntas que ha respondido el usuario. 
     * En caso contrario, es decir, se especifica un offset, debe retornar las siguientes 5 preguntas a partir del offset. 
     * Para un offset en 0, devuelve las 5 primeras preguntas. 
     * @param int $id_usuario
     * @param int $offset
     * @return resultset  
     */
    function dar_preguntas_he_respondido($id_usuario, $offset=-1){
        $this->db->escape($id_usuario);
        $this->db->escape($offset);
        $this->db->select('preguntas.id_pregunta, preguntas.id_pregunta_categoria, titulo_pregunta, cuerpo_pregunta, respuestas.fecha as fecha , numero_respuestas, 
            preguntas.estado, preguntas_categorias.nombre as categoria, preguntas_categorias.id_pregunta_categoria as idCategoria,
            id_respuesta, respuesta, usuarios.nombres, usuarios.apellidos');
        $this->db->from('preguntas');
        $this->db->join('preguntas_categorias','preguntas_categorias.id_pregunta_categoria = preguntas.id_pregunta_categoria');
        $this->db->join('respuestas', 'preguntas.id_pregunta = respuestas.id_pregunta');
        $this->db->join('usuarios', 'usuarios.id_usuario = preguntas.id_usuario');
        $this->db->where('respuestas.id_usuario',$id_usuario);
        if($offset != -1){
            $this->db->limit(5, $offset);
        }
        $this->db->order_by('respuestas.fecha desc'); 
        $query = $this->db->get();
        return $query->result();  
    }
    
    
    /**
     * Da el número de preguntas que ha hecho el usuario
     * @param int $id_usuario
     * @return int numero de preguntas 
     */
    function dar_num_preguntas_usuario($id_usuario){
        $this->db->escape($id_usuario);
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('preguntas');
        return $query->num_rows();
    }
    
    /**
     * Da el número de preguntas que ha respondido el usuario
     * @param int $id_usuario
     * @return int numero de preguntas 
     */
    function dar_num_preguntas_he_respondido($id_usuario){
        $this->db->escape($id_usuario);
        $this->db->from('preguntas');
        $this->db->join('respuestas', 'preguntas.id_pregunta = respuestas.id_pregunta');
        $this->db->where('respuestas.id_usuario',$id_usuario);
        $query = $this->db->get();
        return $query->num_rows(); 
    }
    
        /**
     *Genera un número único de confirmación de pregunta en la DB
     * @return string referencia de venta
     */
    function generar_codConfirmacion_Unico() { 
        $key = $this->getUniqueCode(20);
        $result = false;
        $value = "-1";
        while (!$result) {
                $this->db->where('llave', $key);
                $this->db->from('confirmar_pregunta');
                $q = $this->db->count_all_results();
                
//                $this->db->where('ref_venta', $key);
//                $this->db->from('carritos_compras_ofertas');
//                $rf = $this->db->count_all_results();
                if ($q == 0 ) {
                    $value = $key;
                    $result = true;
                }else
                $key = $this->getUniqueCode(10);

        }
        return $value;
    }
    
        /**
     *Función que genera un valor alfanumérico para el valor de la referencia de la confirmación de la pregunta
     * @param type $length
     * @return String código único 
     */
    function getUniqueCode($length = "")
    {	
            $code = md5(uniqid(rand(), true));
            if ($length != "") return substr($code, 0, $length);
            else return $code;
    }
    
    /**
     * Guarda el registro de la llave única de pregunta en la DB
     * @param type $llave
     * @param type $id_pregunta
     */
    function guardar_codConfirmacion_Unico($llave, $id_pregunta){
        $this->db->escape($llave);
        $this->db->set('llave', $llave);
        $this->db->set('id_pregunta', $id_pregunta);
        $this->db->insert('confirmar_pregunta');
    }
    
    /**
     * Activa una pregunta
     * @param int $id_pregunta
     */
    function activar_pregunta($id_pregunta){
        $this->db->escape($id_pregunta);
        $this->db->set('estado', 'Activo');
        $this->db->where('id_pregunta', $id_pregunta);
        $this->db->update('preguntas');
    }
    
    /**
     * Da la pregunta asociada a la llave de confirmación
     * @param type $llave
     * @return type
     */
    function dar_pregunta_confirmacion($llave){
        $this->db->escape($llave);
        $this->db->select('preguntas.*, id_confirmar_pregunta');
        $this->db->from('confirmar_pregunta');
        $this->db->join('preguntas', 'preguntas.id_pregunta = confirmar_pregunta.id_pregunta');
        $this->db->where('llave', $llave);
        $q =$this->db->get();
        return $q->row(0);
    }
    
    /**
     * Elimina de la DB la el registro de confirmar pregunta
     * @param type $id_confirmar_pregunta
     */
    function eliminar_llave($id_confirmar_pregunta){
        $this->db->escape($id_confirmar_pregunta);
        $this->db->where('id_confirmar_pregunta', $id_confirmar_pregunta);
        $this->db->delete('confirmar_pregunta');
    }
}