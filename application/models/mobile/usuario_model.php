<?php

/**
 * Clase que maneja la BD en donde las consultas se concentra en la tabla usuarios
 */
class Usuario_model extends CI_Model {

    /**
     * Constructor de la clase Usuario_model
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Valida el usuario y contraseña y si el estado es Activo 
     * @param String $email
     * @param String $contrasena
     * @return boolean $resultado true si es valido el usuario y contraseña y está activo
     */
    function validar_usuario($email, $contrasena, $origen = 1) {
        $this->db->escape($email);
        $this->db->escape($contrasena);
        $this->db->where('email', $email);
        $this->db->where('contrasena', $contrasena);
        $this->db->where('estado', 'Activo');
        $this->db->limit(1);
        $query = $this->db->get('usuarios');
        if ($query->num_rows() == 0)
            return FALSE;
        else {
            $usuario = $query->row(0);
            $usuario_sesion = array(
                'id_usuario' => $usuario->id_usuario,
                'tipo' => $usuario->tipo,
                'esta_registrado' => TRUE,
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'correo' => $usuario->email,
                'ciudad' => $usuario->lugar,
                'usuario' => $usuario->usuario
            );
            $this->session->set_userdata($usuario_sesion);

            //Registra el inicio de sesión en la tabla inicion_sesion
            $this->db->set('id_usuario', $usuario->id_usuario);
            $this->db->set('fecha', 'curdate()', FALSE);
            $this->db->set('origen', $origen);
            $this->db->insert('inicio_sesion');
            return TRUE;
        }
    }
    
    /**
     * Da un usuario de acuerdo al identificador
     * @param int $id_usuario
     * @return object $usuario
     */
    function dar_usuario($id_usuario) {
        $this->db->escape($id_usuario);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->limit(1);
        $query = $this->db->get('usuarios');
        return $query->row(0);
    }
    
     /**
     * Da los vehículos de un usuario
     * @param int $id_usuario
     * @return array $vehiculos
     */
    function dar_vehiculos_usuario($id_usuario) {
        $this->db->escape($id_usuario);
        $this->db->select('id_usuario_vehiculo, serie, nombre, modelo, kilometraje, fecha, imagen_thumb_url, imagen_url,
            marca, linea, numero_placa, ciudad_placa, soat, revision, usuarios_vehiculos.id_vehiculo AS id_vehiculo');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = usuarios_vehiculos.id_vehiculo');
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('usuarios_vehiculos');
        return $query->result();
    }
    
    /**
     * Verifica si existe un email
     * @param String $email
     * @return boolean $existe true si existe
     */
    function existe_email($email) {
        $this->db->escape($email);
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        if ($query->num_rows() != 0)
            return TRUE;
        else
            return FALSE;
    }
    
    /**
     *
     * @param <type> $nombre
     * @param <type> $marca
     * @return <type>
     */
    function dar_id_vehiculo($marca, $linea) {
        $this->db->escape($marca);
        $this->db->escape($linea);
        $this->db->select('id_vehiculo');
        $this->db->where('marca', $marca);
        $this->db->where('linea', $linea);
        $query = $this->db->get('vehiculos');
        return $query->row(0)->id_vehiculo;
    }
    
     /**
     * Solicita la lista de tareas para un vehículo
     * @param String id del vehículo
     * @return array $tareas
     */
    function dar_tareas_vehiculo($marca, $linea, $modelo = '') {
        $this->db->escape($marca);
        $this->db->escape($linea);
        $this->db->escape($modelo);
        $this->db->select('tareas_servicios.id_tarea AS id_tarea, tareas.nombre AS nombre, inicio, periodicidad, 
                    tareas.descripcion AS descripcion, tareas.imagen_thumb_url AS imagen_thumb_url, 
                    tareas.id_servicio as id_servicio');
        $this->db->join('tareas', 'tareas.id_servicio = tareas_servicios.id_servicio');
        $this->db->join('vehiculos', 'tareas_servicios.id_vehiculo = vehiculos.id_vehiculo');
        $this->db->where('vehiculos.marca', $marca);
        $this->db->where('vehiculos.linea', $linea);
        if ($modelo != '')
            $this->db->where('tareas_servicios.modelo', $modelo);
        $query = $this->db->get('tareas_servicios');

        $tareas = array();
        if ($query->num_rows() != 0) {
            $tareas = $query->result();
        } else {
            $tareas = $this->dar_tareas_vehiculo('default', 'default');
        }
        return $tareas;
    }
    
    /**
     * Da laa fecha de vigencia del SOAT según el id del vehiculo
     * @param type $id_vehiculo
     * @return type 
     */
    function dar_legales_SOAT($id_usuario_vehiculo) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->select('ultima_fecha, id_tarea_realizada');
        $this->db->where('id_tarea', '9');
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $rs = $this->db->get('tareas_servicio_por_usuario_vehiculo', 1);
        if ($this->db->affected_rows() == 0) {
            return NULL;
        } else {
            return $rs->row(0);
        }
    }

    /**
     * Da laa fecha de vigencia del SOAT según el id del vehiculo
     * @param type $id_vehiculo
     * @return type 
     */
    function dar_fecha_legales_SOAT($id_usuario_vehiculo) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->select('ultima_fecha');
        $this->db->where('id_tarea', '9');
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $rs = $this->db->get('tareas_servicio_por_usuario_vehiculo', 1);
        if ($this->db->affected_rows() == 0) {
            return NULL;
        } else {
            return $rs->row(0)->ultima_fecha;
        }
    }
    
     /**
     * Solicita la última realización de una tarea para un vehículo
     * @param String id del vehículo
     * @param String id de la tarea
     * @return array $tareas
     */
    function dar_tarea_realizada_vehiculo($id_usuario_vehiculo, $id_tarea) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->escape($id_tarea);
        $this->db->select('id_tarea_realizada, ultima_fecha, id_usuario_vehiculo, id_tarea, kilometraje, adjunto');
        $this->db->where('id_tarea', $id_tarea);
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->order_by('ultima_fecha', 'desc');
        $query = $this->db->get('tareas_servicio_por_usuario_vehiculo');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Da laa fecha de vigencia de una revision tecnomecánica según el id del vehiculo
     * @param type $id_vehiculo
     * @return type 
     */
    function dar_legales_Tecnomecanica($id_vehiculo) {
        $this->db->escape($id_vehiculo);
        $this->db->select('ultima_fecha, id_tarea_realizada');
        $this->db->where('id_tarea', '10');
        $this->db->where('id_usuario_vehiculo', $id_vehiculo);
        $rs = $this->db->get('tareas_servicio_por_usuario_vehiculo', 1);
        if ($this->db->affected_rows() == 0) {
            return NULL;
        } else {
            return $rs->row(0);
        }
    }

    /**
     * Da laa fecha de vigencia de una revision tecnomecánica según el id del vehiculo
     * @param type $id_vehiculo
     * @return type 
     */
    function dar_fecha_legales_Tecnomecanica($id_vehiculo) {
        $this->db->escape($id_vehiculo);
        $this->db->select('ultima_fecha');
        $this->db->where('id_tarea', '10');
        $this->db->where('id_usuario_vehiculo', $id_vehiculo);
        $rs = $this->db->get('tareas_servicio_por_usuario_vehiculo', 1);
        if ($this->db->affected_rows() == 0) {
            return NULL;
        } else {
            return $rs->row(0)->ultima_fecha;
        }
    }
    
    /**
     * Agrega un nuevo usuario
     * @param String $usuario
     * @param String $email
     * @param String $contrasena
     * @param int $tipo
     * @return int $id_usuario
     */
    function agregar_usuario($nombre, $apellidos, $usuario, $email, $contrasena, $lugar, $tipo, $referenciado = "", $pais = "Colombia", $telefono = "") {
        $this->db->escape($nombre);
        $this->db->escape($apellidos);
        $this->db->escape($usuario);
        $this->db->escape($email);
        $this->db->escape($contrasena);
        $this->db->escape($lugar);
        $this->db->escape($telefono);
        $this->db->escape($referenciado);

        $existeUser = $this->existe_usuario($usuario);
        $this->db->set('nombres', $nombre);
        $this->db->set('apellidos', $apellidos);
        if (!empty($usuario))
            $this->db->set('usuario', $usuario);
        else if ($existeUser)
            $this->db->set('usuario', $email);
        else
            $this->db->set('usuario', $email);
        if ($telefono != "" || !empty($telefono))
            $this->db->set('telefonos', $telefono);
        $this->db->set('email', $email);
        $this->db->set('contrasena', $contrasena);
        $this->db->set('lugar', $lugar);
        $this->db->set('tipo', $tipo);
        $this->db->set('referenciado', $referenciado);
        $this->db->set('pais', $pais);
        $this->db->set('fecha_creacion', 'curdate()', FALSE);
        $this->db->insert('usuarios');
        return mysql_insert_id();
    }
    
    /**
     * Verifica si existe un usuario
     * @param String $usuario
     * @return boolean $existe true si existe
     */
    function existe_usuario($usuario) {
        $this->db->escape($usuario);
        $this->db->where('usuario', $usuario);
        $query = $this->db->get('usuarios');
        if ($query->num_rows() != 0)
            return TRUE;
        else
            return FALSE;
    }
    
    /**
     * Agrega un nuevo vehículo al usuario
     * @param int $id_usuario
     * @param int $id_vehiculo
     * @param String $nombre
     * @param int $modelo
     * @param int $kilometraje
     * * @param int $serie
     * @return int $id_usuario_vehiculo
     */
    function agregar_vehiculo_usuario($id_usuario, $id_vehiculo = -1, $nombre = -1, $modelo = -1, $kilometraje = -1, $serie = -1, $placa = -1) {
        $this->db->escape($id_vehiculo);
        $this->db->escape($serie);
        $this->db->escape($nombre);
        $this->db->escape($modelo);
        $this->db->escape($kilometraje);
        $this->db->escape($placa);
        $this->db->escape($id_usuario);
        $this->db->set('id_usuario', $id_usuario);
        if ($id_vehiculo != -1) {
            $this->db->set('id_vehiculo', $id_vehiculo);
        }
        if ($serie != -1) {
            $this->db->set('serie', $serie);
        }
        if ($nombre != -1) {
            $this->db->set('nombre', $nombre);
        }
        if ($modelo != -1) {
            $this->db->set('modelo', $modelo);
        }
        if ($kilometraje != -1) {
            $this->db->set('kilometraje', $kilometraje);
        }
        if ($placa != -1) {
            $this->db->set('numero_placa', $placa);
        }
        $this->db->set('fecha', 'curdate()', FALSE);
        $this->db->insert('usuarios_vehiculos');
        return mysql_insert_id();
    }
    
    /**
     * Registra una tarea para un vehículo
     * @param id_usuario_vehiculo id del vehículo
     * @param id_tarea id de la tarea
     */
    function registrar_tarea_realizada_vehiculo($id_usuario_vehiculo, $id_tarea, $fecha, $kilometraje = '', $adjunto = '') {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->escape($id_tarea);
        $this->db->escape($fecha);
        $this->db->escape($kilometraje);
        $this->db->escape($adjunto);
        $this->db->set('id_tarea', $id_tarea);
        if ($kilometraje != '' || !empty($kilometraje))
            $this->db->set('kilometraje', $kilometraje);
        if ($adjunto != '' || !empty($adjunto))
            $this->db->set('adjunto', $adjunto);
        $this->db->set('ultima_fecha', $fecha);
        $this->db->set('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->insert('tareas_servicio_por_usuario_vehiculo');
        return mysql_insert_id();
    }
    
     /**
     * Solicita la lista de ciudades con su respectivo kilometraje
     * @return array ciudades
     */
    function dar_kilometraje_ciudades() {
        $this->db->select('id_ciudad, ciudad, kilometraje');
        $query = $this->db->get('kilometraje_ciudades');
        return $query->result();
    }
    
     /**
     * Solicita la información de kilometraje de una ciudad
     * @return int kilometraje
     */
    function dar_kilometraje_ciudad($ciudad) {
        $this->db->select('kilometraje');
        $this->db->where('ciudad', $ciudad);
        $query = $this->db->get('kilometraje_ciudades');
        $r = $query->row(0);
        $k = 0;
        if ($r) {
            $k = $r->kilometraje;
        } else {
            $k = $this->dar_kilometraje_ciudad('default');
        }
        return $k;
    }
    
    /**
     * Actualiza la imagen del perfil
     * @param int $id_usuario
     * @param String $imagen_url
     * @param String $imagen_thumb_url
     */
    function actualizar_usuario_imagen_url($id_usuario, $imagen_url, $imagen_thumb_url = -1) {
        $this->db->escape($id_usuario);
        $this->db->escape($imagen_url);
        $this->db->escape($imagen_thumb_url);
        $this->db->set('imagen_url', $imagen_url);
        if ($imagen_thumb_url != -1) {
            $this->db->set('imagen_thumb_url', $imagen_thumb_url);
        }
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('usuarios');
    }
    
     /**
     * Actualiza la imagen de un vehículo
     * @param int $id_usuario_vehiculo
     * @param String $imagen_url
     * @param String $imagen_thumb_url
     */
    function actualizar_usuario_vehiculo_imagen_url($id_usuario_vehiculo, $imagen_url, $imagen_thumb_url = -1) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->escape($imagen_url);
        $this->db->escape($imagen_thumb_url);
        $this->db->set('imagen_url', $imagen_url);
        if ($imagen_thumb_url != -1) {
            $this->db->set('imagen_thumb_url', $imagen_thumb_url);
        }
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->update('usuarios_vehiculos');
    }
    
    /**
     * Crea un nuevo chat
     * @param type $id_usuario
     * @return type
     */
    function crear_chat($id_usuario){
        $this->db->escape($id_usuario);
        $this->db->where('id_usuario', $id_usuario);
        $query= $this->db->get('chats');
        if($query->num_rows() != 0)
            return $query->row(0)->id_chat;
        else{
            $this->db->set('id_usuario', $id_usuario);
            $this->db->insert('chats');
            return mysql_insert_id();
        }
    }
    
    /**
     * muestra los usuarios que están conectados en este momento al chat
     * @return type
     */
    function ver_usuarios_conectados(){
        $this->db->select('usuarios.*, id_chat');
        $this->db->where('chats.estado', 1);
        $this->db->join('usuarios', 'usuarios.id_usuario= chats.id_usuario');
        $q= $this->db->get('chats');
        return $q->result();
    }
    
    /**
     * muestra los usuarios que están conectados en este momento al chat
     * @return type
     */
    function ver_chats_activos($id_usuario){
        $this->db->select('usuarios.*, chats.id_chat, chats_comentario.*');
        $this->db->where('chats.estado', 1);
        if($id_usuario != '')
            $this->db->where('chats.id_usuario', $id_usuario);        
        $this->db->join('chats_comentario', 'chats_comentario.id_chat = chats.id_chat');
        $this->db->join('usuarios', 'usuarios.id_usuario= chats_comentario.id_usuario');
        $this->db->order_by('chats_comentario.fecha desc');
        $this->db->limit('20');
        $q= $this->db->get('chats');
        return array_reverse($q->result());
    }
    
    /**
     * Guarda en la BD los mensajes del chat
     * @param type $id_chat
     * @param type $mensaje
     * @param type $id_usuario
     */
    function guardar_mensaje($id_chat, $mensaje, $id_usuario){
        $this->db->escape($id_chat);
        $this->db->escape($mensaje);
        $this->db->escape($id_usuario);
        $this->db->set('id_chat', $id_chat);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('comentario', $mensaje);
        $this->db->insert('chats_comentario');
        $this->cambiar_estado_chat($id_chat, 1);
    }
    
    /**
     * Da nuevos chats en el sistema
     * @param type $id_usuarios
     * @return type
     */
    function dar_nuevos_chats($id_usuarios){
        $this->db->escape($id_usuarios);
        $this->db->select('id_usuario');
        $this->db->where('estado', 1);
        foreach ($id_usuarios as $id_usuario):
           $this->db->where('id_usuario !=', $id_usuario); 
        endforeach;
        $querys = $this->db->get('chats')->result();
        $chats = Array();
        foreach ($querys as $query) {
            $chats = array_merge($this->ver_chats_activos($query->id_usuario), $chats);
        }
        return $chats;
    }
    
    /**
     * Cambia el estado de un chat
     * @param type $id_chat
     * @param type $estado
     */
    function cambiar_estado_chat($id_chat, $estado){
        $this->db->escape($estado);
        $this->db->escape($id_chat);
        $this->db->set('estado', $estado);
        $this->db->where('id_chat', $id_chat);
        $this->db->update('chats');
    }
}