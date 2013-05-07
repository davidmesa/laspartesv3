<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en la tabla establecimientos
 */
class Establecimiento_model extends CI_Model{

    /**
     * Constructor de la clase Establecimiento_model
     */
    function __construct(){
        parent::__construct(); 
//        $this->db = $this->load->database('default', TRUE);
    }

    /**
     * Actualiza un establecimiento
     * @param int $id_establecimiento
     * @param int $id_zona
     * @param int $id_usuario
     * @param String $nombre
     * @param String $estado
     * @param String $email
     * @param String $direccion
     * @param String $web
     * @param String $telefonos
     * @param String $faxes
     * @param String $horario
     * @param double $lat
     * @param double $lng
     */
    function actualizar_establecimiento($id_establecimiento, $id_zona, $id_usuario, $nombre, $estado, $email, $direccion, $web, $telefonos, $faxes, $horario, $lat, $lng, $descripcion=""){
        $this->db->escape($id_establecimiento);
        $this->db->escape($id_zona);
        $this->db->escape($id_usuario);
        $this->db->escape($nombre);
        $this->db->escape($estado);
        $this->db->escape($email);
        $this->db->escape($descripcion);
        $this->db->escape($direccion);
        $this->db->escape($web);
        $this->db->escape($telefonos);
        $this->db->escape($horario);
        $this->db->escape($lat);
        $this->db->escape($lng);
        $this->db->escape($faxes);
        $this->db->set('id_zona', $id_zona);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('nombre', $nombre);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('estado', $estado);
        $this->db->set('email', $email);
        $this->db->set('direccion', $direccion);
        $this->db->set('web', $web);
        $this->db->set('telefonos', $telefonos);
        $this->db->set('faxes', $faxes);
        $this->db->set('horario', $horario);
        $this->db->set('lat', $lat);
        $this->db->set('lng', $lng);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->update('establecimientos');
    }

    /**
     * Actualiza un establecimiento desde un usuario
     * @param int $id_establecimiento
     * @param int $id_zona
     * @param String $nombre
     * @param String $email
     * @param String $direccion
     * @param String $web
     * @param String $telefonos
     * @param String $faxes
     * @param String $horario
     * @param double $lat
     * @param double $lng
     */
    function actualizar_establecimiento_usuario($id_establecimiento, $id_zona, $nombre, $email, $direccion, $web, $telefonos, $faxes, $horario, $lat, $lng, $descripcion=""){
        $this->db->escape($id_establecimiento);
        $this->db->escape($id_zona);
        $this->db->escape($nombre);
        $this->db->escape($email);
        $this->db->escape($descripcion);
        $this->db->escape($direccion);
        $this->db->escape($web);
        $this->db->escape($telefonos);
        $this->db->escape($horario);
        $this->db->escape($lat);
        $this->db->escape($lng);
        $this->db->escape($faxes);
        $this->db->set('id_zona', $id_zona);
        $this->db->set('nombre', $nombre);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('email', $email);
        $this->db->set('direccion', $direccion);
        $this->db->set('web', $web);
        $this->db->set('telefonos', $telefonos);
        $this->db->set('faxes', $faxes);
        $this->db->set('horario', $horario);
        $this->db->set('lat', $lat);
        $this->db->set('lng', $lng);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->update('establecimientos');
    }

    /**
     * Actualiza el logo de un establecimiento
     * @param int $id_establecimiento
     * @param String $logo_url
     * @param String $logo_thumb_url
     */
    function actualizar_establecimiento_logo_url($id_establecimiento, $logo_url, $logo_thumb_url){
        $this->db->escape($id_establecimiento);
        $this->db->escape($logo_url);
        $this->db->escape($logo_thumb_url);
        $this->db->set('logo_url', $logo_url);
        $this->db->set('logo_thumb_url', $logo_thumb_url);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->update('establecimientos');
    }

    /**
     * Actualiza en número de visitas de un establecimiento
     * @param int $id_establecimiento
     */
    function actualizar_numero_visitas($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->set('numero_visitas', 'numero_visitas+1', FALSE);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->limit(1);
        $this->db->update('establecimientos');
    }

    /**
     * Actualiza un servicio
     * @param int $id_servicio
     * @param String $nombre
     */
    function actualizar_servicio($id_servicio, $nombre){
        $this->db->escape($id_servicio);
        $this->db->escape($nombre);
        $this->db->set('nombre', $nombre);
        $this->db->where('id_servicio', $id_servicio);
        $this->db->update('servicios');
    }
    
    /**
     * Actualiza una oferta
     * @param type $titulo
     * @param type $precio
     * @param type $condiciones
     * @param type $incluye
     * @param type $id_establecimiento
     * @param type $categorias 
     */ 
    function actualizar_oferta($titulo, $precio, $condiciones, $incluye, $categorias, $id_oferta, $id_establecimiento, $vehiculos, $vigencia, $descripcion, $iva, $margen, $descuento, $plazo, $imagen = ''){
        $this->db->escape($titulo);
        $this->db->escape($precio);
        $this->db->escape($condiciones);
        $this->db->escape($incluye);
        $this->db->escape($categorias);
        $this->db->escape($id_establecimiento);
        $this->db->escape($vehiculos);
        $this->db->escape($vigencia);
        $this->db->escape($descripcion);
        $this->db->escape($iva);
        $this->db->escape($margen);
        $this->db->escape($descuento);
        $this->db->escape($plazo);
        $this->db->escape($imagen);
        $this->db->set('titulo', $titulo);
        $this->db->set('precio', $precio);
        $this->db->set('iva', $iva);
        $this->db->set('margenLP', $margen);
        $this->db->set('dco_feria', $descuento);
        $this->db->set('plazo_uso', $plazo);
        $this->db->set('condiciones', $condiciones);
        $this->db->set('incluye', $incluye);
        $this->db->set('vigencia', $vigencia);
        $this->db->set('descripcion', $descripcion);
        if($imagen != '')
            $this->db->set('foto', $imagen);
        $this->db->where('id_oferta', $id_oferta);
        $this->db->update('oferta');
       
        $this->db->where('id_oferta', $id_oferta);
        $this->db->delete('establecimientos_ofertas');
        
        foreach ($categorias as $key =>$id_categoria):
            foreach ($vehiculos as $id_vehiculo):
                $this->db->set('id_vehiculo',$id_vehiculo);
                $this->db->set('id_establecimiento',$id_establecimiento);
                $this->db->set('id_oferta', $id_oferta);
                $this->db->set('id_servicios_categoria', $id_categoria);
                $this->db->insert('establecimientos_ofertas');
            endforeach;
        endforeach;
        

    }

    /**
     * Actualiza una zona
     * @param int $id_zona
     * @param String $ciudad
     * @param String $nombre
     */
    function actualizar_zona($id_zona, $ciudad, $nombre){
        $this->db->escape($id_zona);
        $this->db->escape($ciudad);
        $this->db->escape($nombre);
        $this->db->set('ciudad', $ciudad);
        $this->db->set('nombre', $nombre);
        $this->db->where('id_zona', $id_zona);
        $this->db->update('zonas');
    }

    /**
     * Agrega un establecimiento
     * @param int $id_usuario
     * @param int $id_zona
     * @param String $nombre
     * @param String $estado
     * @param String $email
     * @param String $descripcion
     * @param String $direccion
     * @param String $web
     * @param String $telefonos
     * @param String $faxes
     * @param String $horario
     * @param double $lat
     * @param double $lng
     * @return int $id_establecimiento
     */
    function agregar_establecimiento($id_usuario, $id_zona, $nombre, $estado, $email, $descripcion, $direccion, $web, $telefonos, $faxes, $horario, $lat, $lng){
        $this->db->escape($id_usuario);
        $this->db->escape($id_zona);
        $this->db->escape($nombre);
        $this->db->escape($estado);
        $this->db->escape($email);
        $this->db->escape($descripcion);
        $this->db->escape($direccion);
        $this->db->escape($web);
        $this->db->escape($telefonos);
        $this->db->escape($faxes);
        $this->db->escape($horario);
        $this->db->escape($lat);
        $this->db->escape($lng);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('id_zona', $id_zona);
        $this->db->set('nombre', $nombre);
        $this->db->set('estado', $estado);
        $this->db->set('email', $email);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('direccion', $direccion);
        $this->db->set('web', $web);
        $this->db->set('telefonos', $telefonos);
        $this->db->set('faxes', $faxes);
        $this->db->set('horario', $horario);
        $this->db->set('lat', $lat);
        $this->db->set('lng', $lng);
        $this->db->insert('establecimientos');
        return mysql_insert_id();
    }

    /**
     * Agrega una relación establecimiento-autoparte
     * @param int $id_establecimiento
     * @param int $id_servicio
     * @param int $precio
     */
    function agregar_establecimiento_autoparte($id_establecimiento, $id_autoparte, $precio){
        $this->db->escape($id_establecimiento);
        $this->db->escape($id_autoparte);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->from('establecimientos_autopartes');
        
        if( $this->db->count_all_results() == 0 )
        {
            $record = array('id_establecimiento'=>$id_establecimiento, 
                            'id_autoparte'=>$id_autoparte, 
                            'precio'=>$precio);

            $this->db->insert('establecimientos_autopartes', $record);
        }
        else
        {
            $this->db->escape($id_establecimiento);
            $this->db->escape($id_autoparte);
            $this->db->escape($precio);
            $this->db->where('id_establecimiento', $id_establecimiento);
            $this->db->where('id_autoparte', $id_autoparte);
            $this->db->set('precio', $precio);
            $this->db->update('establecimientos_autopartes');
        }
    }

    /**
     * Verifica si un usuario está asignado a un establecimiento
     * @param int $id_usuario
     * @param int $id_establecimiento
     * @return bool $esta_asignado
     */
    function esta_asignado_usuario_establecimiento($id_usuario, $id_establecimiento){
        $this->db->escape($id_usuario);
        $this->db->escape($id_establecimiento);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->limit(1);
        $query = $this->db->get('establecimientos');
        if($query->num_rows() == 0)
            return FALSE;
        else
            return TRUE;
    }
    
    /**
     * Verifica si una autoparte está asociada a un establecimiento
     * @param int $id_establecimiento
     * @param int $id_autoparte
     * @return bool $esta_asociado true si está asociado 
     */
    function esta_asociado_establecimiento_autoparte($id_establecimiento, $id_autoparte){
        $this->db->escape($id_establecimiento);
        $this->db->escape($id_autoparte);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->limit(1);
        $query = $this->db->get('establecimientos_autopartes');
        if($query->num_rows() == 0)
            return FALSE;
        else
            return TRUE;
    }

    /**
     * Eliminar una relación establecimiento-autoparte
     * @param int $id_establecimiento
     * @param int $id_servicio
     * @param int $precio
     */
    function eliminar_establecimiento_autoparte($id_establecimiento, $id_autoparte){
        $this->db->escape($id_establecimiento);
        $this->db->escape($id_autoparte);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->delete('establecimientos_autopartes');
    }
    
    /**
     * Eliminar una relación establecimiento-oferta
     * @param int $id_establecimiento
     * @param int $id_oferta
     */
    function eliminar_establecimiento_oferta($id_oferta){
        $this->db->escape($id_oferta);
        $this->db->where('id_oferta', $id_oferta);
        $this->db->delete('establecimientos_ofertas');
    }

    /**
     * Agrega un comentario al establecimiento
     * @param int $id_establecimiento
     * @param int $id_usuario
     * @param Stirng $comentario
     * @param String $calificacion
     * @return int $id_establecimiento_comentario
     */
    function agregar_establecimiento_comentario($id_establecimiento, $id_usuario, $comentario, $calificacion){
        $this->db->escape($id_establecimiento);
        $this->db->escape($id_usuario);
        $this->db->escape($comentario);
        $this->db->escape($calificacion);
        $this->db->set('id_establecimiento', $id_establecimiento);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('comentario', $comentario);
        $this->db->set('calificacion', $calificacion);
        $this->db->set('fecha', 'now()', FALSE);
        $this->db->insert('establecimientos_comentarios');
        return mysql_insert_id();
    }

    /**
     * Agrega una nueva imagen al establecimiento
     * @param int $id_establecimiento
     * @param String $imagen_url
     * @param String $imagen_thumb_url
     */
    function agregar_establecimiento_imagen($id_establecimiento, $imagen_url, $imagen_thumb_url){
        $this->db->escape($id_establecimiento);
        $this->db->escape($imagen_url);
        $this->db->escape($imagen_thumb_url);
        $this->db->set('id_establecimiento', $id_establecimiento);
        $this->db->set('imagen_url', $imagen_url);
        $this->db->set('imagen_thumb_url', $imagen_thumb_url);
        $this->db->insert('establecimientos_imagenes');
    }

    /**
     * Agrega una relación establecimiento-servicio
     * @param int $id_establecimiento
     * @param int $id_servicio
     */
    function agregar_establecimiento_servicio($id_establecimiento, $id_servicio){
        $this->db->escape($id_establecimiento);
        $this->db->escape($id_servicio);
        $this->db->set('id_establecimiento', $id_establecimiento);
        $this->db->set('id_servicio', $id_servicio);
        $this->db->insert('establecimientos_servicios');
    }

    /**
     * Agrega una nuevo servicio
     * @param String $nombre
     */
    function agregar_servicio($nombre){
        $this->db->escape($nombre);
        $this->db->set('nombre', $nombre);
        $this->db->insert('servicios');
    }

    /**
     * Agrega una nueva zona
     * @param String $ciudad
     * @param String $nombre
     */
    function agregar_zona($ciudad, $nombre){
        $this->db->escape($ciudad);
        $this->db->escape($nombre);
        $this->db->set('ciudad', $ciudad);
        $this->db->set('nombre', $nombre);
        $this->db->insert('zonas');
    }
    
    /**
     * Agrega una nueva oferta
     * @param type $titulo
     * @param type $precio
     * @param type $condiciones
     * @param type $incluye 
     */
    function agregar_oferta($titulo, $precio, $condiciones, $incluye, $id_establecimiento, $categorias, $vehiculos, $vigencia, $descripcion, $iva, $margen, $descuento , $plazo, $imagen = ''){
        $this->db->escape($titulo);
        $this->db->escape($precio);
        $this->db->escape($condiciones);
        $this->db->escape($incluye);
        $this->db->escape($id_establecimiento);
        $this->db->escape($categorias);
        $this->db->escape($vehiculos);
        $this->db->escape($vigencia);
        $this->db->escape($iva);
        $this->db->escape($margen);
        $this->db->escape($descuento);
        $this->db->escape($plazo);
        $this->db->escape($descripcion);
        $this->db->escape($imagen);
        $this->db->set('titulo', $titulo);
        $this->db->set('iva', $iva);
        $this->db->set('margenLP', $margen);
        $this->db->set('dco_feria', $descuento);
        $this->db->set('plazo_uso', $plazo);
        $this->db->set('precio', $precio);
        $this->db->set('condiciones', $condiciones);
        $this->db->set('incluye', $incluye);
        $this->db->set('vigencia', $vigencia);
        $this->db->set('descripcion', $descripcion);
        if($imagen != '')
            $this->db->set('foto', $imagen);
        $this->db->insert('oferta');
        $id_oferta = mysql_insert_id();
        
        if($id_oferta):
            foreach ($categorias as $key =>$id_categoria):
                foreach ($vehiculos as $id_vehiculo):
                    $this->db->set('id_vehiculo',$id_vehiculo);
                    $this->db->set('id_establecimiento',$id_establecimiento);
                    $this->db->set('id_oferta', $id_oferta);
                    $this->db->set('id_servicios_categoria', $id_categoria);
                    $this->db->insert('establecimientos_ofertas');
                endforeach;
            endforeach;
        endif;
        return $id_oferta;
    }

    /**
     * Cuenta el número de establecimientos con los filtros deseados
     * @param String $servicio
     * @param String $zona
     * @return int $numero_establecimientos
     */
    function contar_establecimientos($servicio, $zona, $ciudad){
        $this->db->escape($servicio);
        $this->db->escape($zona);
        $this->db->select('establecimientos.id_establecimiento, establecimientos.nombre, direccion, establecimientos.descripcion, logo_thumb_url');
        $this->db->distinct();
        if($servicio!=''){
            $this->db->join('establecimientos_servicios', 'establecimientos_servicios.id_establecimiento = establecimientos.id_establecimiento');
            $this->db->join('servicios', 'servicios.id_servicio = establecimientos_servicios.id_servicio');
            $this->db->where('servicios.nombre', $servicio);
        }
        if($ciudad!=''){
            $this->db->join('zonas', 'zonas.id_zona = establecimientos.id_zona');
            $this->db->where('zonas.ciudad', $ciudad);
        }
        if($ciudad != '' &&$zona!=''){
            $this->db->where('zonas.nombre', $zona);
        }
        $this->db->where('estado', 'Activo');
        $query = $this->db->get('establecimientos');
        return $query->num_rows();
    }

    /**
     * Da un establecimiento
     * @param int $id_establecimiento
     * @return object $establecimiento
     */
    function dar_establecimiento($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->limit(1);
        $query = $this->db->get('establecimientos');
        return $query->row(0);
    }

    /**
     * Da un establecimiento siempre y cuando esté activo
     * Función para visualización en la página web
     * @param int $id_establecimiento
     * @return object $establecimiento
     */
    function dar_establecimiento_activo($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->select('establecimientos.*, zonas.nombre as zona, zonas.ciudad');
        $this->db->join('zonas', 'establecimientos.id_zona = zonas.id_zona'); 
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->where('estado', 'Activo');
        $this->db->limit(1);
        $query = $this->db->get('establecimientos');
        return $query->row(0);
    }

    /**
     * Da el promedio de calificación de un establecimiento
     * @param int $id_establecimiento
     * @return double $promedio
     */
    function dar_establecimiento_calificacion_promedio($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->select('AVG(calificacion) AS promedio, count(*) as count');
        $this->db->where('id_establecimiento', $id_establecimiento);
        $query = $this->db->get('establecimientos_comentarios');
        return $query->row(0);
    }
    
    
    function dar_top_establecimientos($offset = 5){
        $this->db->escape($offset);
        $this->db->select('AVG(calificacion) AS promedio, establecimientos.nombre, establecimientos.web, establecimientos.descripcion
            , establecimientos.direccion, establecimientos.telefonos, establecimientos.logo_thumb_url, establecimientos.logo_url, zonas.nombre as zona, zonas.ciudad
            , establecimientos.id_establecimiento idestablecimiento');
        $this->db->join('establecimientos', 'establecimientos_comentarios.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->join('zonas', 'establecimientos.id_zona = zonas.id_zona');
         $this->db->where('establecimientos.estado', 'activo');
        $this->db->order_by('promedio', 'desc');
        $this->db->group_by('establecimientos.id_establecimiento');
        $this->db->limit($offset, 0);
        $query = $this->db->get('establecimientos_comentarios');
        return $query->result();
    }


    /**
     * Da los comentarios de un establecimiento que estan activos
     * @param int $id_establecimiento
     * @return array $establecimiento_comentarios
     */
    function dar_establecimiento_comentarios_activos($id_establecimiento){  
        $this->db->escape($id_establecimiento);
        $this->db->select('usuarios.*, establecimientos_comentarios.estado as est, establecimientos_comentarios.*');
        $this->db->join('usuarios', 'usuarios.id_usuario = establecimientos_comentarios.id_usuario');
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->where('establecimientos_comentarios.estado', '1');
        $this->db->order_by('establecimientos_comentarios.id_establecimiento_comentario', 'desc');
        $query = $this->db->get('establecimientos_comentarios');
        return $query->result();
    }
    
    /**
     * Da los comentarios de un establecimiento
     * @param int $id_establecimiento
     * @return array $establecimiento_comentarios
     */
    function dar_establecimiento_comentarios($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->select('usuarios.*, establecimientos_comentarios.estado as est, establecimientos_comentarios.*');
        $this->db->join('usuarios', 'usuarios.id_usuario = establecimientos_comentarios.id_usuario');
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->order_by('establecimientos_comentarios.id_establecimiento_comentario', 'desc');
        $query = $this->db->get('establecimientos_comentarios');
        return $query->result();
    }
    
    /**
     * cambia el estado del comentario realizado a un establecimiento
     * @param type $id_comentario
     * @param type $estado 
     */
    function cambiar_estado_comentario_establecimiento($id_comentario, $estado){
        $this->db->escape($id_comentario);
        $this->db->escape($estado);
        $this->db->set('estado',$estado);
        $this->db->where('id_establecimiento_comentario',$id_comentario);
        $this->db->update('establecimientos_comentarios');
    }

    /**
     * Da la relación establecimiento-autopartes
     * @param int $id_establecimiento
     * @return array $establecimiento_autopartes
     */
    function dar_establecimiento_autopartes($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->select('establecimientos_autopartes.id_autoparte, establecimientos_autopartes.precio, autopartes.nombre, , autopartes_marcas.nombre as marca');
        $this->db->join('establecimientos_autopartes', 'establecimientos_autopartes.id_autoparte = autopartes.id_autoparte');
        $this->db->join('autopartes_marcas', 'autopartes_marcas.id_autoparte_marca = autopartes.id_autoparte_marca');
        $this->db->where('establecimientos_autopartes.id_establecimiento', $id_establecimiento);
        $query = $this->db->get('autopartes');
        return $query->result();
    }

    /**
     * Da las imágenes de un establecimiento
     * @param int $id_establecimiento
     * @return array $establecimiento_imagenes
     */
    function dar_establecimiento_imagenes($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $query = $this->db->get('establecimientos_imagenes');
        return $query->result();
    }

    /**
     * Da los establecimientos asociados a un servicio
     * @param int $id_servicio
     * @return array $establecimientos
     */
    function dar_establecimientos_servicio($id_servicio){
        $this->db->escape($id_servicio);
        $this->db->join('establecimientos_servicios', 'establecimientos_servicios.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->where('id_servicio', $id_servicio);
        $query = $this->db->get('establecimientos');
        return $query->result();
    }

    /**
     * Da la lista de servicios
     * @return array $servicios
     */
    function dar_establecimientos_servicios(){
        $this->db->select('servicios.*');
        $this->db->join('establecimientos_servicios', 'establecimientos_servicios.id_servicio = servicios.id_servicio');
        $this->db->join('establecimientos', 'establecimientos_servicios.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->order_by('servicios.nombre', 'asc');
        $this->db->group_by('servicios.nombre');
        $query = $this->db->get('servicios');
        return $query->result();
    }
    
        /**
     * Da los establecimientos asociados a una oferta
     * @param int $id_oferta
     * @return array $establecimientos
     */
    function dar_establecimientos_oferta($id_oferta){
        $this->db->escape($id_oferta);
        $this->db->join('establecimientos_ofertas', 'establecimientos_ofertas.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->where('id_oferta', $id_oferta);
        $query = $this->db->get('establecimientos');
        return $query->result();
    }

    /**
     * Da la lista de ofertas
     * @return array $ofertas
     */
    function dar_establecimientos_ofertas(){
        $this->db->select('oferta.*');
        $this->db->join('establecimientos_ofertas', 'establecimientos_ofertas.id_oferta = oferta.id_oferta');
        $this->db->join('establecimientos', 'establecimientos_ofertas.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->order_by('oferta.titulo', 'asc');
        $this->db->group_by('oferta.titulo');
        $query = $this->db->get('oferta');
        return $query->result();
    }
    
    /**
     * Da la lista de ofertas según id del establecimiento
     * @return array $ofertas
     */
    function dar_establecimiento_ofertas($id_establecimiento){
        $this->db->select('oferta.*');
        $this->db->join('establecimientos_ofertas', 'establecimientos_ofertas.id_oferta = oferta.id_oferta');
        $this->db->join('establecimientos', 'establecimientos_ofertas.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->where('establecimientos.id_establecimiento',$id_establecimiento);
        $this->db->order_by('oferta.id_oferta', 'desc');
        $this->db->group_by('oferta.id_oferta');
        $query = $this->db->get('oferta');
        return $query->result();
    }
    
    /**
     * Da el correo de un establecimiento según el id de la oferta
     * @return array $ofertas
     */
    function dar_ofertas_idestablecimiento($id_oferta){
        $this->db->join('establecimientos_ofertas', 'establecimientos.id_establecimiento = establecimientos_ofertas.id_establecimiento');
        $this->db->where('establecimientos_ofertas.id_oferta',$id_oferta);
        $this->db->group_by('establecimientos_ofertas.id_oferta');
        $query = $this->db->get('establecimientos');
        return $query->row(0)->email;
    }

    /**
     * Da los establecimientos asociados a una zona
     * @param int $id_zona
     * @return array $establecimientos
     */
    function dar_establecimientos_zona($id_zona){
        $this->db->escape($id_zona);
        $this->db->where('id_zona', $id_zona);
        $query = $this->db->get('establecimientos');
        return $query->result();
    }

    /**
     * Da la lista de zonas
     * @return array $zonas
     */
    function dar_establecimientos_zonas(){
        $query = $this->db->get('zonas');
        return $query->result();
    }

    
    /**
     * Da los establecimientos de acuerdo a los parámetros
     * @param int $limit
     * @param int $offset
     * @param String $orden
     * @param String $servicio
     * @param String $zona
     */
    function dar_establecimientos_paginacion_filtros($limit, $offset, $orden, $servicio, $zona, $ciudad){
        $this->db->escape($limit);
        $this->db->escape($offset);
        $this->db->escape($orden);
        $this->db->escape($servicio);
        $this->db->escape($zona); 
        $this->db->select('establecimientos.id_establecimiento, establecimientos.nombre, direccion, establecimientos.descripcion
            , logo_thumb_url, AVG(establecimientos_comentarios.calificacion) as avg, count(establecimientos_comentarios.id_establecimiento_comentario) as num_comentarios');
        $this->db->join('zonas', 'zonas.id_zona = establecimientos.id_zona');
        $this->db->join('establecimientos_comentarios', 'establecimientos_comentarios.id_establecimiento = establecimientos.id_establecimiento', 'left');
        if($servicio!=''){
            $this->db->join('establecimientos_servicios', 'establecimientos_servicios.id_establecimiento = establecimientos.id_establecimiento');
            $this->db->join('servicios', 'establecimientos_servicios.id_servicio = servicios.id_servicio');
            $this->db->where('servicios.nombre', $servicio);
        }
        if($ciudad!='' )
            $this->db->where('zonas.ciudad', $ciudad);
        if($zona!=''&& $ciudad!= '')
            $this->db->where('zonas.nombre', $zona);
        if($orden == 'rating'){
            $this->db->join('respuestas','establecimientos.id_usuario = respuestas.id_usuario AND respuestas.fecha >= DATE_SUB( NOW( ) , INTERVAL 1 MONTH )', 'left');
            $this->db->order_by('COUNT(distinct(respuestas.id_respuesta))', 'desc');  
            $this->db->order_by('AVG(establecimientos_comentarios.calificacion)', 'desc');
            $this->db->order_by('count(establecimientos_comentarios.id_establecimiento_comentario)', 'desc');
        }
        else if($orden == 'nombre'){
            $this->db->order_by('establecimientos.nombre', 'asc');
        }
        else if($orden == 'calificacion'){
            $this->db->order_by('AVG(establecimientos_comentarios.calificacion)', 'desc');
            $this->db->order_by('count(establecimientos_comentarios.id_establecimiento_comentario)', 'desc');
        }
        $this->db->where('establecimientos.estado', 'Activo');
        $this->db->limit($limit, $offset*10);
        $this->db->group_by('establecimientos.id_establecimiento');
        $query = $this->db->get('establecimientos'); 
        return $query->result();
    }

    /**
     * Da los establecimientos con mayor número de visitas
     * @return array $establecimientos
     */
    function dar_establecimientos_mayor_numero_visitas(){
        $this->db->select('establecimientos.id_establecimiento, establecimientos.nombre, email, direccion, telefonos, zonas.nombre AS zona, estado');
        $this->db->join('zonas', 'establecimientos.id_zona=zonas.id_zona');
        $this->db->order_by('numero_visitas', 'desc');
        $this->db->limit(10);
        $query = $this->db->get('establecimientos');
        return $query->result();
    }

    /**
     * Da los servicios asociados a un establecimiento
     * @param int $id_establecimiento
     * @return array $establecimiento_servicios
     */
    function dar_establecimiento_servicios($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->join('establecimientos_servicios', 'establecimientos_servicios.id_servicio=servicios.id_servicio');
        $this->db->where('id_establecimiento', $id_establecimiento);
        $query = $this->db->get('servicios');
        return $query->result();
    }

    /**
     * Da la lista de establecimientos
     * @return array $establecimientos
     */
    function dar_establecimientos(){
        $this->db->select('establecimientos.id_establecimiento, establecimientos.nombre, email, direccion, telefonos, zonas.nombre AS zona, estado, establecimientos.id_zona, web, horario, descripcion, lng, lat, logo_thumb_url');
        $this->db->join('zonas', 'establecimientos.id_zona=zonas.id_zona');
        $query = $this->db->get('establecimientos');
        return $query->result();
    }

    /**
     * Da la lista de establecimientos
     * @param int $id_usuario
     * @return array $establecimientos
     */
    function dar_establecimientos_usuario($id_usuario){
        $this->db->select('establecimientos.id_establecimiento, establecimientos.nombre, email, direccion, telefonos, zonas.nombre AS zona, estado, establecimientos.id_zona, web, horario, descripcion, lng, lat, logo_thumb_url');
        $this->db->where('id_usuario', $id_usuario);
        $this->db->join('zonas', 'establecimientos.id_zona=zonas.id_zona');
        $query = $this->db->get('establecimientos');
        return $query->result();
    }

    /**
     * Muestra los establecimientos de una autoparte dada
     * @param int $id_autoparte
     * @param String $orden
     * @return array $establecimientos
     */
    function dar_establecimientos_autoparte($id_autoparte, $orden){
        $this->db->escape($id_autoparte);
        $this->db->select('establecimientos.id_establecimiento, establecimientos.nombre, descripcion, email, direccion, web, logo_url, telefonos, faxes, zonas.nombre AS zona, precio');
        $this->db->join('establecimientos_autopartes', 'establecimientos_autopartes.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->join('zonas', 'zonas.id_zona = establecimientos.id_zona');
        $this->db->where('id_autoparte', $id_autoparte);
        $this->db->where('estado', 'Activo');
        $this->db->order_by($orden);
        $query = $this->db->get('establecimientos');
        return $query->result();
    }

    /**
     * Da la lista de las relaciones establecimientos_servicios
     * @return array $establecimientos_servicios
     */
    function dar_relacion_establecimientos_servicios(){
        $this->db->select('establecimientos_servicios.id_establecimiento, nombre');
        $this->db->join('establecimientos_servicios', 'establecimientos_servicios.id_servicio = servicios.id_servicio');
        $query = $this->db->get('servicios');
        return $query->result();
    }

    /**
     * Da un servicio
     * @param int $id_servicio
     * @return object $servicio
     */
    function dar_servicio($id_servicio){
        $this->db->escape($id_servicio);
        $this->db->where('id_servicio', $id_servicio);
        $this->db->limit(1);
        $query = $this->db->get('servicios');
        return $query->row(0);
    }

    /**
     * Da los servicios de una zona
     * @param String $zona
     * @return array $servicios
     */
    function dar_servicios_filtros($zona){
        $this->db->escape($zona);
        $this->db->select('servicios.nombre, COUNT(*) AS cantidad');
        $this->db->distinct();
        $this->db->join('establecimientos_servicios', 'establecimientos_servicios.id_servicio = servicios.id_servicio');
        $this->db->join('establecimientos', 'establecimientos.id_establecimiento = establecimientos_servicios.id_establecimiento');
        if($zona!=''){
            $this->db->join('zonas', 'establecimientos.id_zona = zonas.id_zona');
            $this->db->where('zonas.nombre', $zona);
        }
        $this->db->where('establecimientos.estado', 'Activo');
        $this->db->order_by('servicios.nombre', 'asc');
        $this->db->group_by('servicios.nombre');
        $query = $this->db->get('servicios');
        return $query->result();
    }

    /**
     * Da una zona
     * @param int $id_zona
     * @return object $zona
     */
    function dar_zona($id_zona){
        $this->db->escape($id_zona);
        $this->db->where('id_zona', $id_zona);
        $this->db->limit(1);
        $query = $this->db->get('zonas');
        return $query->row(0);
    }

    /**
     * Da las zonas de un servicio
     * @param String $servicio
     * @return array $zonas
     */
    function dar_zonas_filtros($servicios, $ciudad, $zona){
        $this->db->escape($servicios);
        $this->db->select('zonas.nombre, COUNT(*) AS cantidad');
        $this->db->distinct();
        $this->db->join('establecimientos', 'establecimientos.id_zona = zonas.id_zona');


        if($servicios!= ''){
            $this->db->join('establecimientos_servicios', 'establecimientos_servicios.id_establecimiento = establecimientos.id_establecimiento');
            $this->db->join('servicios', 'establecimientos_servicios.id_servicio = servicios.id_servicio');
            $this->db->where('servicios.nombre', $servicios);
        }
        if($ciudad!= '' )
            $this->db->where('ciudad', $ciudad);
        if($zona!= '' )
            $this->db->where('zonas.nombre', $zona);

        $this->db->where('establecimientos.estado', 'Activo');
        $this->db->order_by('zonas.nombre', 'asc');
        $this->db->group_by('zonas.nombre');
        $query = $this->db->get('zonas');
        return $query->result();
    }

    /**
     * Elimina todas las relaciones establecimientos_autopartes de un establecimiento
     * @param int $id_establecimiento
     */
    function eliminar_establecimiento_autopartes($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->delete('establecimientos_autopartes');
    }

    /**
     * Elimina el registro de la imagen del establecimiento
     * @param int $id_establecimiento_imagen
     */
    function eliminar_establecimiento_imagen($id_establecimiento_imagen){
        $this->db->escape($id_establecimiento_imagen);
        $this->db->where('id_establecimiento_imagen', $id_establecimiento_imagen);
        $this->db->delete('establecimientos_imagenes');
    }

    /**
     * Elimina el registro del logo del establecimiento
     * @param int $id_establecimiento
     */
    function eliminar_establecimiento_logo($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->set('logo_url', NULL);
        $this->db->set('logo_thumb_url', NULL);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->update('establecimientos');
    }

    /**
     * Elimina todas las relaciones establecimientos_servicios de un establecimiento
     * @param int $id_establecimiento
     */
    function eliminar_establecimiento_servicios($id_establecimiento){
        $this->db->escape($id_establecimiento);
        $this->db->where('id_establecimiento', $id_establecimiento);
        $this->db->delete('establecimientos_servicios');
    }

    /**
     * Elimina un servicio
     * @param int $id_servicio
     */
    function eliminar_servicio($id_servicio){
        $this->db->escape($id_servicio);
        $this->db->where('id_servicio', $id_servicio);
        $this->db->delete('servicios');
    }
    
    /**
     * Elimina una oferta
     * @param int $id_oferta
     */
    function eliminar_oferta($id_oferta){
        $this->db->escape($id_oferta);
        $this->db->where('id_oferta', $id_oferta);
        $this->db->delete('oferta');
    }

    /**
     * Elimina una zona
     * @param int $id_zona
     */
    function eliminar_zona($id_zona){
        $this->db->escape($id_zona);
        $this->db->where('id_zona', $id_zona);
        $this->db->delete('zonas');
    }

    /**
     * Verifica si hay llaves foraneas de un servicio
     * @param int $id_servicio
     * @return bool TRUE si existen fk, FALSE en caso contrario
     */
    function existe_llaves_foraneas_servicio($id_servicio){
        $this->db->escape($id_servicio);
        $this->db->where('id_servicio', $id_servicio);
        $query = $this->db->get('establecimientos_servicios');
        if($query->num_rows()==0)
            return FALSE;
        return TRUE;
    }
    
    /**
     * Verifica si hay llaves foraneas de una oferta
     * @param int $id_oferta
     * @return bool TRUE si existen fk, FALSE en caso contrario
     */
    function existe_llaves_foraneas_oferta($id_oferta){
        $this->db->escape($id_oferta);
        $this->db->where('id_oferta', $id_oferta);
        $query = $this->db->get('establecimientos_ofertas');
        if($query->num_rows()==0)
            return FALSE;
        return TRUE;
    }

    /**
     * Verifica si hay llaves foraneas de una zona
     * @param int $id_zona
     * @return bool TRUE si existen fk, FALSE en caso contrario
     */
    function existe_llaves_foraneas_zona($id_zona){
        $this->db->escape($id_zona);
        $this->db->where('id_zona', $id_zona);
        $query = $this->db->get('establecimientos');
        if($query->num_rows()==0)
            return FALSE;
        return TRUE;
    }
    
    
    /**
     * Da una oferta
     * @param int $id_oferta
     * @return object $id_oferta
     */
    function dar_oferta($id_oferta){
        $this->db->escape($id_oferta);
        $this->db->where('id_oferta', $id_oferta);
        $this->db->limit(1);
        $query = $this->db->get('oferta');
        return $query->row(0);
    }
    
    /**
     * Da un id_establecimiento según el id de la oferta
     * @param int $id_oferta
     * @return object $id_oferta
     */
    function dar_establecimiento_segun_oferta($id_oferta){
        $this->db->escape($id_oferta);
        $this->db->where('id_oferta', $id_oferta);
        $this->db->limit(1);
        $query = $this->db->get('establecimientos_ofertas');
        return $query->row(0);
    }
    
    /**
     * Da los carritos de compras de un usuario
     * @param int $id_establecimiento
     * @return array $carritos_compras
     */
    function dar_carritos_compras_establecimiento($id_establecimiento){
       $this->db->escape($id_establecimiento);
        $query = $this->db->query('
            SELECT 
            distinct(carritos_compras.id_carrito_compra) AS carrito, carritos_compras.fecha as fecha, carritos_compras.estado as estado, oferta.precio as precioOferta,
            oferta.titulo, autopartes.nombre as nombre, carritos_compras_autopartes.cantidad as cantidad, carritos_compras_autopartes.precio as total, consecutivo_factura.id_consecutivo_factura as consecutivo,
            carritos_compras_autopartes.id_establecimiento as id_establecimiento, carritos_compras.realizado as realizado, carritos_refVentas.refVenta as recibo,
             establecimientos_ofertas.id_establecimiento as IDestablecimientoOferta, carritos_compras.total AS carritoTotal, usuarios.usuario as usuario
            FROM carritos_compras
                left join (oferta join carritos_compras_ofertas on oferta.id_oferta = carritos_compras_ofertas.id_oferta
                           join (establecimientos_ofertas  join establecimientos as es2 on establecimientos_ofertas.id_establecimiento = es2.id_establecimiento)
                                on oferta.id_oferta = establecimientos_ofertas.id_oferta  ) 
                    on carritos_compras.id_carrito_compra = carritos_compras_ofertas.id_carrito_compra

                left join (carritos_compras_autopartes 
                    join autopartes on carritos_compras_autopartes.id_autoparte = autopartes.id_autoparte) 
                        on carritos_compras_autopartes.id_carrito_compra = carritos_compras.id_carrito_compra  
                        
                left join usuarios on carritos_compras.id_usuario = usuarios.id_usuario
                left join carritos_refVentas on carritos_refVentas.id_carritos_compras = carritos_compras.id_carrito_compra
                left join consecutivo_factura on consecutivo_factura.id_carritos_compras = carritos_compras.id_carrito_compra
            WHERE es2.id_establecimiento = '. $id_establecimiento.' and
                carritos_compras.estado = "Transacción aprobada" 
            order by fecha desc');
        
        return $query->result();
    }
    
    /**
     * Da las autopartes de los carritos de compras de un usuario
     * @param int $id_carrito
     * @return array $carritos_compras_autopartes
     */
    function dar_carrito_compras_info($id_carrito){
        $this->db->escape($id_carrito);
        $query = $this->db->query('
             SELECT 
            distinct(carritos_compras.id_carrito_compra) AS carrito, carritos_compras.fecha as fecha, carritos_compras.estado as estado, oferta.precio as precioOferta,
            oferta.titulo, autopartes.nombre as nombre, carritos_compras_autopartes.cantidad as cantidad, carritos_compras_autopartes.precio as total, 
            carritos_compras_autopartes.id_establecimiento as id_establecimiento, carritos_compras.realizado as realizado, carritos_compras_ofertas.ref_venta as factura,
             establecimientos_ofertas.id_establecimiento as IDestablecimientoOferta, carritos_compras.total AS carritoTotal, usuarios.usuario as usuario
            FROM carritos_compras
                left join (oferta join carritos_compras_ofertas on oferta.id_oferta = carritos_compras_ofertas.id_oferta
                           join (establecimientos_ofertas  join establecimientos as es2 on establecimientos_ofertas.id_establecimiento = es2.id_establecimiento)
                                on oferta.id_oferta = establecimientos_ofertas.id_oferta  ) 
                    on carritos_compras.id_carrito_compra = carritos_compras_ofertas.id_carrito_compra

                left join (carritos_compras_autopartes 
                    join autopartes on carritos_compras_autopartes.id_autoparte = autopartes.id_autoparte) 
                        on carritos_compras_autopartes.id_carrito_compra = carritos_compras.id_carrito_compra  
                        
                left join usuarios on carritos_compras.id_usuario = usuarios.id_usuario
            WHERE carritos_compras.id_carrito_compra ='.$id_carrito);
        
        return $query->row(0);
        
    }
    
    /**
     * Este método devuelve los talleres que ha calificado un usuario dado. 
     * Agregar un parámetro opcional que represente el offset. 
     * El valor por defecto de este parámetro es -1. 
     * En dado caso que $offset sea -1, es decir, no hayan especificado el parámetro, 
     * el método retorna TODOS los talleres que ha calificado el usuario. 
     * En caso contrario, es decir se especifica un offset, 
     * debe retornar los siguientes 5 talleres a partir del offset. 
     * Para un offset en 0, devuelve los 5 primeros talleres.
     * @param type $id_usuario
     * @param type $offset 
     */
    function dar_talleres_he_calificado($id_usuario, $offset = -1){
        $this->db->escape($id_usuario);
        $this->db->escape($offset);
        $this->db->select('establecimientos.id_establecimiento, establecimientos.nombre, establecimientos.email, establecimientos.descripcion,
            establecimientos.direccion, establecimientos_comentarios.comentario, establecimientos_comentarios.fecha as fecha,
            establecimientos.telefonos, zonas.ciudad, zonas.nombre as nombreZona, establecimientos.estado, web, horario, descripcion, establecimientos.lng, establecimientos.lat, 
            logo_thumb_url, calificacion, comentario');
        $this->db->from('usuarios');
        $this->db->join('establecimientos_comentarios','establecimientos_comentarios.id_usuario = usuarios.id_usuario');
        $this->db->join('establecimientos','establecimientos.id_establecimiento = establecimientos_comentarios.id_establecimiento');
        $this->db->join('zonas', 'zonas.id_zona = establecimientos.id_zona');
        $this->db->where('usuarios.id_usuario', $id_usuario);
        if($offset != -1){
            $this->db->limit(5, $offset);
        }
        $this->db->order_by('establecimientos_comentarios.fecha desc'); 
        $query =$this->db->get();
        return $query->result();
    }
    
    /**
     * Devuelve el número de talleres que ha calificado el usuario
     * @param type $id_usuario 
     */
    function dar_num_talleres_he_calificado($id_usuario){
        $this->db->escape($id_usuario);
        $this->db->join('establecimientos_comentarios','usuarios.id_usuario = establecimientos_comentarios.id_usuario');
        $this->db->join('establecimientos','establecimientos.id_establecimiento = establecimientos_comentarios.id_establecimiento');
        $this->db->where('establecimientos_comentarios.id_usuario', $id_usuario);
        $query = $this->db->get('usuarios');
        return $query->num_rows(); 
    }
    
    /**
     * Devuelve el número de talleres que ha calificado el usuario
     * @param type $id_usuario 
     */
    function dar_num_talleres(){
        $query = $this->db->get('establecimientos');
        return $query->num_rows(); 
    }
    
    /**
     * Da la lista de ciudades
     * @return array $vehiculos
     */
    function dar_ciudades(){
        $this->db->select('distinct(ciudad)');
        $query = $this->db->get('zonas');
        return $query->result();
    }
}