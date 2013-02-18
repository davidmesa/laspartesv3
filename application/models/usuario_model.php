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
     * Actualiza la información básica de un usuario
     * @param int $id_usuario
     * @param String $usuario
     * @param String $nombres
     * @param String $apellidos 
     * @param String $email
     * @param String $lugar
     */
    function actualizar_usuario($id_usuario, $usuario, $nombres, $apellidos, $email, $lugar) {
        $this->db->escape($id_usuario);
        $this->db->escape($usuario);
        $this->db->escape($nombres);
        $this->db->escape($apellidos);
        $this->db->escape($email);
        $this->db->escape($lugar);
        $this->db->set('usuario', $usuario);
        $this->db->set('nombres', $nombres);
        $this->db->set('apellidos', $apellidos);
        $this->db->set('email', $email);
        $this->db->set('lugar', $lugar);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('usuarios');
    }

    /**
     * Actualiza la contraseña de un usuario
     * @param int $id_usuario
     * @param String $contrasena con sha1
     */
    function actualizar_usuario_contrasena($id_usuario, $contrasena) {
        $this->db->escape($id_usuario);
        $this->db->escape($contrasena);
        $this->db->set('contrasena', $contrasena);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('usuarios');
    }

    /**
     * Actualiza el estado de un usuario
     * @param int $id_usuario
     * @param String $estado
     */
    function actualizar_usuario_estado($id_usuario, $estado) {
        $this->db->escape($id_usuario);
        $this->db->escape($estado);
        $this->db->set('estado', $estado);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('usuarios');
    }

    /**
     * Actualiza el estado de un usuario
     * @param int $id_usuario
     * @param String $estado
     */
    function actualizar_usuario_codigo_activacion($id_usuario, $codigo) {
        $this->db->escape($id_usuario);
        $this->db->escape($codigo);
        $this->db->set('codigo', $codigo);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('usuarios');
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
     * Actualiza un carrito de compra
     * @param int $id_carrito_compra
     * @param String $estado
     */
    function actualizar_carrito_compra($id_carrito_compra, $estado) {
        $this->db->escape($id_carrito_compra);
        $this->db->escape($estado);
        $this->db->set('estado', $estado);
        $this->db->where('id_carrito_compra', $id_carrito_compra);
        $this->db->update('carritos_compras');
    }

    /**
     * Actualiza un vehículo de un usuario
     * @param int $id_usuario_vehiculo
     * @param int $id_vehiculo
     * @param String $nombre
     * @param int $modelo
     * @param int $kilometraje
     * @param int $serie
     */
    function actualizar_vehiculo_usuario($id_usuario_vehiculo, $id_vehiculo = -1, $nombre = -1, $modelo = -1, $kilometraje = -1, $serie = -1, $placa = -1) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->escape($id_vehiculo);
        $this->db->escape($serie);
        $this->db->escape($nombre);
        $this->db->escape($modelo);
        $this->db->escape($kilometraje);
        $this->db->escape($placa);
        if ($id_vehiculo != -1)
            $this->db->set('id_vehiculo', $id_vehiculo);
        if ($serie != -1)
            $this->db->set('serie', $serie);
        if ($nombre != -1)
            $this->db->set('nombre', $nombre);
        if ($modelo != -1)
            $this->db->set('modelo', $modelo);
        if ($kilometraje != -1)
            $this->db->set('kilometraje', $kilometraje);
        if ($placa != -1)
            $this->db->set('numero_placa', $placa);
        $this->db->set('fecha', 'curdate()', FALSE);
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->update('usuarios_vehiculos');
    }

    /**
     * Agrega un nuevo captcha
     * @param int $time
     * @param String $ip_address
     * @param String $palabra
     */
    function agregar_captcha($time, $ip_address, $palabra) {
        $this->db->escape($time);
        $this->db->escape($ip_address);
        $this->db->escape($palabra);
        $this->db->set('time', $time);
        $this->db->set('fecha', 'curdate()', FALSE);
        $this->db->set('ip_address', $ip_address);
        $this->db->set('palabra', $palabra);
        $this->db->insert('captcha');
    }

    /**
     * Agrega un nuevo carrito de compra
     * @param int $id_usuario
     * @param String $estado
     * @param int $total
     * @return int $id_carrito_compra
     */
    function agregar_carrito_compras($id_usuario, $estado, $total, $nombres = '', $ciudad = '', $telefono = '', $direccion = '', $email = '', $di = '', $carro = '', $placa = '') {
        $this->db->escape($id_usuario);
        $this->db->escape($estado);
        $this->db->escape($total);
        $this->db->escape($di);
        $this->db->escape($carro);
        $this->db->escape($placa);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('estado', $estado);
        $this->db->set('total', $total);
        $this->db->set('fecha', 'curdate()', FALSE);
        if ($nombres != '')
            $this->db->set('nombres', $nombres);
        if ($ciudad != '')
            $this->db->set('ciudad', $ciudad);
        if ($telefono != '')
            $this->db->set('telefono', $telefono);
        if ($direccion != '')
            $this->db->set('direccion', $direccion);
        if ($email != '')
            $this->db->set('email', $email);
        if($di != '')
            $this->db->set('documento', $di);
        if($carro != '')
            $this->db->set('carro', $carro);
        if($placa != '')
            $this->db->set('placa', $placa); 
        $this->db->insert('carritos_compras');
        return mysql_insert_id();
    }

    /**
     * Agrega un artículo a un carrito de compra
     * @param int $id_carrito_compra
     * @param int $id_establecimiento
     * @param int $id_autoparte
     * @param int $precio
     * @param int $cantidad
     * @param String $descripcion
     */
    function agregar_carrito_compras_articulo($id_carrito_compra, $id_establecimiento, $id_autoparte, $precio, $cantidad, $descripcion) {
        $this->db->escape($id_carrito_compra);
        $this->db->escape($id_establecimiento);
        $this->db->escape($id_autoparte);
        $this->db->escape($precio);
        $this->db->escape($cantidad);
        $this->db->escape($descripcion);
        $this->db->set('id_carrito_compra', $id_carrito_compra);
        $this->db->set('id_establecimiento', $id_establecimiento);
        $this->db->set('id_autoparte', $id_autoparte);
        $this->db->set('precio', $precio);
        $this->db->set('cantidad', $cantidad);
        $this->db->set('descripcion', $descripcion);
        $this->db->insert('carritos_compras_autopartes');
    }

    /**
     * Agrega las ofertas correspondientes al carrito de compra
     * @param type $id_carrito
     * @param type $id_oferta
     * @param type $cantidad 
     */
    function agregar_carrito_compras_ofertas($id_carrito, $id_oferta, $cantidad) {
        $this->db->escape($id_carrito);
        $this->db->escape($id_oferta);
        $this->db->escape($cantidad);
        $this->db->set('id_carrito_compra', $id_carrito);
        $this->db->set('id_oferta', $id_oferta);
        $this->db->set('cantidad', $cantidad);
        $this->db->insert('carritos_compras_ofertas');
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
     * Da los carritos de compras de un usuario
     * @param int $id_usuario
     * @return array $carritos_compras
     */
    function dar_carritos_compras_usuario($id_usuario, $offset = -1) {
        $this->db->escape($id_usuario);
        $this->db->select('carritos_compras.*, consecutivo_factura.id_consecutivo_factura, carritos_refVentas.*');
        $this->db->join('consecutivo_factura', 'consecutivo_factura.id_carritos_compras = carritos_compras.id_carrito_compra');
        $this->db->join('carritos_refVentas', 'carritos_refVentas.id_carritos_compras = carritos_compras.id_carrito_compra');
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('estado', 'Transacción aprobada');
        if ($offset != -1) {
            $this->db->limit(6, $offset);
        }
        $this->db->order_by('id_carrito_compra', 'desc');
        $query = $this->db->get('carritos_compras');
        return $query->result();
    }

    /**
     * Da un carrito de compra
     * @param int $id_carrito_compra
     * @return object $carrito_compra
     */
    function dar_carrito_compra($id_carrito_compra) { 
        $this->db->escape($id_carrito_compra);
        $this->db->select('id_carrito_compra, fecha, total, carritos_compras.estado, usuario, usuarios.id_usuario');
        $this->db->join('usuarios', 'usuarios.id_usuario = carritos_compras.id_usuario');
        $this->db->where('id_carrito_compra', $id_carrito_compra);
        $query = $this->db->get('carritos_compras');
        return $query->row(0);
    }

    /**
     * Da una oferta 
     * @param int $id_carrito_compra
     * @return array $oferta
     */
    function dar_oferta($id_oferta) {
        $this->db->escape($id_oferta);
        $this->db->select('oferta.id_oferta AS id_oferta, tareas.id_servicios_categoria AS categoria, oferta.titulo AS titulo, 
                oferta.precio AS precio, oferta.iva AS iva,oferta.condiciones AS condiciones, oferta.incluye AS incluye, oferta.descripcion AS descripcion, 
                oferta.vigencia AS vigencia, establecimientos_ofertas.id_establecimiento as id_establecimiento, establecimientos.telefonos AS telefonos,
                establecimientos.nombre as establecimientoNombre, establecimientos.descripcion as establecimientoDescripcion, 
                establecimientos.direccion as direccion, establecimientos.logo_thumb_url as logo, establecimientos.web AS web,
                count(distinct(establecimientos_comentarios.id_establecimiento_comentario)) as num_comentarios, tareas.imagen_thumb_url as logoTarea,
                avg(establecimientos_comentarios.calificacion) as calificacion, dco_feria');
        $this->db->join('establecimientos_ofertas', 'oferta.id_oferta = establecimientos_ofertas.id_oferta');
        $this->db->join('tareas', 'tareas.id_servicios_categoria = establecimientos_ofertas.id_servicios_categoria');
        $this->db->join('establecimientos', 'establecimientos_ofertas.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->join('establecimientos_comentarios', 'establecimientos_comentarios.id_establecimiento = establecimientos_ofertas.id_establecimiento', 'left');
        $this->db->where('oferta.id_oferta', $id_oferta);
        $this->db->where('oferta.vigencia >', 'curdate()', FALSE);
        $rs = $this->db->get('oferta');
        return $rs->row(0);
    }

    /**
     * Da una oferta 
     * @param int $id_carrito_compra
     * @return array $oferta
     */
    function dar_tarea_categoria($id_tarea) {
        $this->db->escape($id_tarea);
        $this->db->select('servicios_categoria.id_servicios_categoria');
        $this->db->join('servicios_categoria', 'tareas.id_servicios_categoria = servicios_categoria.id_servicios_categoria');
        $this->db->where('tareas.id_servicio', $id_tarea);
        $rs = $this->db->get('tareas');
        return $rs->row(0)->id_servicios_categoria;
    }

    /**
     * Da una oferta dado el id de la tarea
     * @param int $id_carrito_compra
     * @return array $oferta
     */
    function dar_oferta_por_tarea($id_tarea, $id_vehiculo, $limit = -1) {
        $this->db->escape($id_tarea);
        $this->db->escape($id_vehiculo);
        $id_servicio = $this->dar_tarea_categoria($id_tarea);
        $this->db->select('oferta.id_oferta AS id_oferta, oferta.titulo AS titulo, 
                oferta.precio AS precio, oferta.iva AS iva,oferta.condiciones AS condiciones, oferta.incluye AS incluye, oferta.descripcion AS descripcion, 
                oferta.vigencia AS vigencia, oferta.dco_feria, establecimientos_ofertas.id_establecimiento as id_establecimiento, establecimientos.telefonos AS telefonos,
                establecimientos.nombre as establecimientoNombre, establecimientos.descripcion as establecimientoDescripcion, 
                establecimientos.direccion as direccion, establecimientos.logo_thumb_url as logo, establecimientos.web AS web, oferta.foto, servicios_categoria.nombre as categoria_servicio');
        $this->db->join('establecimientos_ofertas', 'oferta.id_oferta = establecimientos_ofertas.id_oferta');
        $this->db->join('establecimientos', 'establecimientos_ofertas.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->join('servicios_categoria', 'servicios_categoria.id_servicios_categoria = establecimientos_ofertas.id_servicios_categoria');
        $this->db->where('establecimientos_ofertas.id_servicios_categoria', $id_servicio);
        $this->db->where('establecimientos_ofertas.id_vehiculo', $id_vehiculo);
//        $this->db->where('oferta.dco_feria', 0);
        $this->db->where('oferta.vigencia >', 'curdate()', FALSE);
        $this->db->group_by('oferta.id_oferta');
        if ($limit != -1)
            $this->db->limit($limit);
        $rs = $this->db->get('oferta');
        return $rs->result();
    }

    /**
     * Da todas las ofertas que esten vigentes para la fecha actual
     * @return array $ofertas
     */
    function dar_ofertas_vigentes() {
        $this->db->where('vigencia >', 'curdate()', FALSE);
        $this->db->order_by('vigencia', 'desc');
        $query = $this->db->get('oferta');
        return $query->result();
    }

    /**
     * Da todas las ofertas
     * @return array $ofertas
     */
    function dar_all_ofertas() {
        $query = $this->db->get('oferta');
        return $query->result();
    }

    /**
     * Da las autopartes de un carrito de compra
     * @param int $id_carrito_compra
     * @return array $carrito_compra_autopartes
     */
    function dar_carrito_compra_autopartes($id_carrito_compra) {
        $this->db->escape($id_carrito_compra);
        $this->db->select('cantidad, establecimientos_autopartes.precio, autopartes.nombre AS autoparte, autopartes.descripcion, establecimientos.nombre AS establecimiento,
            establecimientos.direccion, establecimientos.telefonos, establecimientos.email, establecimientos_autopartes.observacion');
        $this->db->join('autopartes', 'autopartes.id_autoparte = carritos_compras_autopartes.id_autoparte');
        $this->db->join('establecimientos', 'carritos_compras_autopartes.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->join('establecimientos_autopartes', 'establecimientos_autopartes.id_autoparte = autopartes.id_autoparte');
        $this->db->where('id_carrito_compra', $id_carrito_compra);
        $query = $this->db->get('carritos_compras_autopartes');
        return $query->result();
    }

    /**
     * Da las ofertas de un carrito de compra
     * @param int $id_carrito_compra
     * @return array $carritos_compras_ofertas
     */
    function dar_carrito_compra_ofertas($id_carrito_compra) {
        $this->db->escape($id_carrito_compra);
        $this->db->select('cantidad, precio, oferta.titulo , oferta.descripcion, oferta.incluye, oferta.plazo_uso, oferta.iva, oferta.dco_feria,
            oferta.condiciones, oferta.id_oferta, establecimientos.nombre AS establecimiento,
            establecimientos.direccion, establecimientos.telefonos, establecimientos.email');
        $this->db->join('oferta', 'oferta.id_oferta = carritos_compras_ofertas.id_oferta');
        $this->db->join('establecimientos_ofertas', 'oferta.id_oferta = establecimientos_ofertas.id_oferta');
        $this->db->join('establecimientos', 'establecimientos_ofertas.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->where('id_carrito_compra', $id_carrito_compra);
        $this->db->group_by('oferta.id_oferta');
        $query = $this->db->get('carritos_compras_ofertas');
        return $query->result();
    }

    /**
     * Da la lista de carritos de compras
     * @return array $carritos_compras
     */
    function dar_carritos_compras() {
        $this->db->select('id_carrito_compra, fecha, total, carritos_compras.estado, usuario');
        $this->db->join('usuarios', 'usuarios.id_usuario = carritos_compras.id_usuario');
        $this->db->order_by('id_carrito_compra', 'desc');
        $query = $this->db->get('carritos_compras');
        return $query->result();
    }

    /**
     * Da las autopartes de los carritos de compras de un usuario
     * @param int $id_usuario
     * @return array $carritos_compras_autopartes
     */
    function dar_carritos_compras_autopartes_usuario($id_usuario) {
        $this->db->escape($id_usuario);
        $query = $this->db->query('
            SELECT 
            distinct(carritos_compras.id_carrito_compra) AS carrito, carritos_compras.fecha as fecha, carritos_compras.estado as estado, oferta.precio as precioOferta,
            oferta.titulo, autopartes.nombre as nombre, carritos_compras_autopartes.cantidad as cantidad, carritos_compras_autopartes.precio as total, 
            carritos_compras_autopartes.id_establecimiento as id_establecimiento, es1.nombre AS establecimiento, es2.nombre AS establecimiento2,
             establecimientos_ofertas.id_establecimiento as IDestablecimientoOferta
            FROM carritos_compras
                left join (oferta join carritos_compras_ofertas on oferta.id_oferta = carritos_compras_ofertas.id_oferta
                           join (establecimientos_ofertas  join establecimientos as es2 on establecimientos_ofertas.id_establecimiento = es2.id_establecimiento)
                                on oferta.id_oferta = establecimientos_ofertas.id_oferta  ) 
                    on carritos_compras.id_carrito_compra = carritos_compras_ofertas.id_carrito_compra

                left join (carritos_compras_autopartes 
                    join autopartes on carritos_compras_autopartes.id_autoparte = autopartes.id_autoparte
                    join establecimientos as es1 on carritos_compras_autopartes.id_establecimiento = es1.id_establecimiento) 
                        on carritos_compras_autopartes.id_carrito_compra = carritos_compras.id_carrito_compra  
            WHERE carritos_compras.id_usuario = ' . $id_usuario . ' and carritos_compras.estado = "Transacción aprobada"
            order by fecha desc');

        return $query->result();
    }

    /**
     * Da los items de compra que el usuario dado ha comprado
     * @param type $id_usuario
     * @return type
     */
    function dar_items_compra_usuario($id_usuario) {
        $this->db->escape($id_usuario);
        $query = $this->db->query('
            select tbl1.*, cr.refVenta from
                (select cc.id_carrito_compra, fecha, cantidad, nombre as titulo, cc.id_usuario from carritos_compras cc
                    join carritos_compras_autopartes cca on cc.id_carrito_compra = cca.id_carrito_compra
                    join autopartes a on a.id_autoparte = cca.id_autoparte
                union
                select cc.id_carrito_compra, fecha, cantidad, titulo, cc.id_usuario from carritos_compras cc
                    join carritos_compras_ofertas cco on cc.id_carrito_compra = cco.id_carrito_compra
                    join oferta o on o.id_oferta = cco.id_oferta) as tbl1
            join carritos_refVentas cr on cr.id_carritos_compras = tbl1.id_carrito_compra
            where tbl1.id_usuario = '.$id_usuario.'
            order by fecha desc');
        return $query->result();
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
     * Da un usuario de acuerdo al email
     * @param String $email_usuario
     * @return object $usuario
     */
    function dar_usuario_segun_mail($email_usuario) {
        $this->db->escape($email_usuario);
        $this->db->where('email', $email_usuario);
        $this->db->limit(1);
        $query = $this->db->get('usuarios');
        return $query->row(0);
    }

    /**
     * Da un usuario de acuerdo al código de activación. Debe estar desactivado también
     * @param String $codigo
     * @return object $usuario
     */
    function dar_usuario_segun_codigo($codigo) {
        $this->db->escape($codigo);
        $this->db->where('codigo', $codigo);
        $this->db->where('estado', 'No Activo');
        $this->db->limit(1);
        $query = $this->db->get('usuarios');
        return $query->row(0);
    }

    /**
     * Da la lista de usuarios
     * @return array $usuarios
     */
    function dar_usuarios() {
        $query = $this->db->get('usuarios');
        return $query->result();
    }

    /**
     * Da la lista de usuarios registrados al newsletter de noticias
     * @return array $usuarios
     */
    function dar_usuarios_noticias() {
        $this->db->where('noticias', 1);
        $query = $this->db->get('usuarios');
        return $query->result();
    }

    /**
     * Da la lista de usuarios registrados al newsletter de tareas
     * @return array $usuarios
     */
    function dar_usuarios_tareas() {
        $this->db->where('tareas', 1);
        $query = $this->db->get('usuarios');
        return $query->result();
    }

    /**
     * Da la lista de usuarios segun el tipo
     * @param int $tipo
     * @return array $usuarios
     */
    function dar_usuarios_tipo($tipo) {
        $this->db->escape($tipo);
        $this->db->where('tipo', $tipo);
        $query = $this->db->get('usuarios');
        return $query->result();
    }

    /**
     * Da usuarios segun la marca del carro que tenga registrado el usuario
     * @param string $marca
     * @return array $usuarios
     */
    function dar_usuarios_marcaVehiculo($marca, $tipo = '') {
        $this->db->escape($marca);
        $this->db->select('usuarios.*, vehiculos.tipo as tipoVehiculo, usuarios_vehiculos.modelo, vehiculos.marca as marca');
        $this->db->from('usuarios');
        $this->db->join('usuarios_vehiculos', 'usuarios_vehiculos.id_usuario = usuarios.id_usuario');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = usuarios_vehiculos.id_vehiculo');
        $this->db->where('vehiculos.marca', $marca);
        if ($tipo != '')
            $this->db->where('vehiculos.tipo', $tipo);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Da la información de un vehículo
     * @param int $id_usuario_vehiculo
     * @return object $vehiculo
     */
    function dar_usuario_vehiculo($id_usuario_vehiculo) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = usuarios_vehiculos.id_vehiculo');
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $query = $this->db->get('usuarios_vehiculos');
        return $query->row(0);
    }

    /**
     * Da los usuarios que tengan la revisión proximas a vencer antes del
     * rango especificado
     * @param date fecha límite de vencimiento
     * @return usuarios
     */
    function dar_usuarios_tecnicomecanica($fechaFinal) {
        $this->db->escape($fechaFinal);
        $this->db->select('usuarios.*, tareas_servicio_por_usuario_vehiculo.ultima_fecha, usuarios_vehiculos.numero_placa as placa');
        $this->db->from('usuarios');
        $this->db->join('usuarios_vehiculos', 'usuarios.id_usuario = usuarios_vehiculos.id_usuario');
        $this->db->join('tareas_servicio_por_usuario_vehiculo', 'tareas_servicio_por_usuario_vehiculo.id_usuario_vehiculo = usuarios_vehiculos.id_usuario_vehiculo');
        $this->db->where('tareas_servicio_por_usuario_vehiculo.ultima_fecha <=', $fechaFinal);
        $this->db->where('tareas_servicio_por_usuario_vehiculo.ultima_fecha <>', '0000-00-00');
        $this->db->where('tareas_servicio_por_usuario_vehiculo.id_tarea', '10');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Da la lista de marcas de vehículos
     * @return array $vehiculos
     */
    function dar_vehiculos_marcas() {
        $this->db->select('marca');
        $this->db->distinct();
        $this->db->order_by('marca', 'asc');
        $query = $this->db->get('vehiculos');
        return $query->result();
    }

    /**
     * Da las líneas de una marca
     * @param String $marca
     * @return array $lineas
     */
    function dar_vehiculos_lineas($marca) {
        $this->db->escape($marca);
        $this->db->where('marca', $marca);
        $query = $this->db->get('vehiculos');
        return $query->result();
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
     * Da los vehículos de un usuario
     * @param int $id_usuario
     * @return array $vehiculos
     */
    function dar_vehiculo($id_usuario_vehiculo) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->select('id_usuario_vehiculo, serie, nombre, modelo, kilometraje, fecha, imagen_thumb_url, 
            marca, linea, numero_placa, ciudad_placa, soat, revision, usuarios_vehiculos.id_vehiculo AS id_vehiculo');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = usuarios_vehiculos.id_vehiculo');
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $query = $this->db->get('usuarios_vehiculos');
        return $query->row(0);
    }

    /**
     * Elimina los captchas que no sean del día de hoy y elimina la imagen
     */
    function eliminar_captchas() {
        $where = "fecha < curdate()";
        $this->db->where($where);
        $query = $this->db->get('captcha');
        foreach ($query->result() AS $captcha)
            unlink('resources/images/captcha/' . $captcha->time . '.jpg');

        $this->db->flush_cache();
        $this->db->where($where);
        $this->db->delete('captcha');
    }

    /**
     * Elimina el registro de los campos de la imagen del usuario
     * @param int $id_usuario
     */
    function eliminar_usuario_imagen($id_usuario) {
        $this->db->escape($id_usuario);
        $this->db->set('imagen_url', NULL);
        $this->db->set('imagen_thumb_url', NULL);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->update('usuarios');
    }

    /**
     * Elimina un vehículo de un usuario
     * @param int $id_usuario
     * @param int $id_usuario_vehiculo
     */
    function eliminar_usuario_vehiculo($id_usuario, $id_usuario_vehiculo) {
        $this->db->escape($id_usuario);
        $this->db->escape($id_usuario_vehiculo);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->delete('usuarios_vehiculos');
    }

    /**
     * Elimina el registro de los campos de la imagen del vehículo
     * @param int $id_usuario_vehiculo
     */
    function eliminar_usuario_vehiculo_imagen($id_usuario_vehiculo) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->set('imagen_url', NULL);
        $this->db->set('imagen_thumb_url', NULL);
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->update('usuarios_vehiculos');
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
     * Valida el usuario y contraseña y si el estado es Activo y crea sesiones de usuario
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
     * Valida el usuario  y si el estado es Activo y crea sesiones de usuario
     * @param String $email
     * @param String $contrasena
     * @return boolean $resultado true si es valido el usuario y contraseña y está activo
     */
    function validar_usuario_fb($email) {
        $this->db->escape($email);
        $this->db->where('email', $email);
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
            $this->db->set('origen', 2);
            $this->db->insert('inicio_sesion');
            return TRUE;
        }
    }

    /**
     * Verifica si la palabra del captcha es correcto
     * @param String $palabra
     * @return boolean $es_correcto true si es correcto
     */
    function verificar_captcha($palabra) {
        $this->db->escape($palabra);
        $this->db->select('id_captcha');
        $this->db->where('palabra', $palabra);
        $this->db->where('ip_address', $this->input->ip_address());
        $query = $this->db->get('captcha');
        if ($query->num_rows() != 0)
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Solicita la lista de tareas para un vehículo
     * @param String id del vehículo
     * @return array $tareas
     */
    function dar_tareas_vehiculo($id_vehiculo, $modelo = '') {
        $this->db->escape($id_vehiculo);
        $this->db->escape($modelo);
        $this->db->select('tareas_servicios.id_tarea AS id_tarea, tareas.nombre AS nombre, inicio, periodicidad, 
                    tareas.descripcion AS descripcion, tareas.imagen_thumb_url AS imagen_thumb_url, 
                    tareas.id_servicio as id_servicio');
        $this->db->join('tareas', 'tareas.id_servicio = tareas_servicios.id_servicio');
        $this->db->where('tareas_servicios.id_vehiculo', $id_vehiculo);
        if ($modelo != '')
            $this->db->where('tareas_servicios.modelo', $modelo);
        $query = $this->db->get('tareas_servicios');

        $tareas = array();
        if ($query->num_rows() != 0) {
            $tareas = $query->result();
        } else {
            $tareas = $this->dar_tareas_vehiculo($this->dar_id_vehiculo('default', 'default'));
        }
        return $tareas;
    }

    /**
     * Solicita la lista de tareas para un vehículo
     * @param String id del vehículo
     * @return array $tareas
     */
    function dar_tarea($id_tarea) {
        $this->db->escape($id_tarea);
        $this->db->select('tareas.nombre AS nombre, tareas.descripcion AS descripcion, tareas.imagen_thumb_url AS imagen_thumb_url, tareas.id_servicio as id_servicio');
        $this->db->where('tareas.id_servicio', $id_tarea);
        $query = $this->db->get('tareas');
        return $query->row(0);
    }

    /**
     * Solicita la lista de tareas para un vehículo
     * @param String id del vehículo
     * @return array $tareas
     */
    function dar_tareas_vehiculo_usuario($id_usuario_vehiculo) {
        $vehiculo = $this->dar_usuario_vehiculo($id_usuario_vehiculo);
        $tareas = array();
        if ($vehiculo) {
            $tareas = $this->dar_tareas_vehiculo($vehiculo->id_vehiculo);
        } else {
            $tareas = $this->dar_tareas_vehiculo('0');
        }
        return $tareas;
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
//        $this->db->where('id_usuario_vehiculo',$id_usuario_vehiculo);
//        $this->db->where('id_tarea',$id_tarea);
//        $query = $this->db->get('tareas_servicio_por_usuario_vehiculo');
//        
//        if($query->num_rows() == 0){
        $this->db->set('id_tarea', $id_tarea);
        if ($kilometraje != '' || !empty($kilometraje))
            $this->db->set('kilometraje', $kilometraje);
        if ($adjunto != '' || !empty($adjunto))
            $this->db->set('adjunto', $adjunto);
        $this->db->set('ultima_fecha', $fecha);
        $this->db->set('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->insert('tareas_servicio_por_usuario_vehiculo');
        return mysql_insert_id();
//        }else{
//            $id = $query->row(0)->id_tarea_realizada;
//            if($kilometraje != '' || !empty($kilometraje))
//                $this->db->set('kilometraje', $kilometraje);
//            $this->db->set('ultima_fecha', $fecha);
//            $this->db->where('id_tarea_realizada', $id);
//            $this->db->update('tareas_servicio_por_usuario_vehiculo');
//            return $id;
//        }
    }
    
    /**
     * Registra una tarea para un vehículo
     * @param id_usuario_vehiculo id del vehículo
     * @param id_tarea id de la tarea
     */
    function actualizar_tarea_realizada_vehiculo($id_usuario_vehiculo, $id_tarea, $fecha, $kilometraje = '', $adjunto = '') {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->escape($id_tarea);
        $this->db->escape($fecha);
        $this->db->escape($kilometraje);
        $this->db->escape($adjunto);
        $this->db->where('id_usuario_vehiculo',$id_usuario_vehiculo);
        $this->db->where('id_tarea',$id_tarea);
        $query = $this->db->get('tareas_servicio_por_usuario_vehiculo');
        
        if($query->num_rows() == 0){
        $this->db->set('id_tarea', $id_tarea);
        if ($kilometraje != '' || !empty($kilometraje))
            $this->db->set('kilometraje', $kilometraje);
        if ($adjunto != '' || !empty($adjunto))
            $this->db->set('adjunto', $adjunto);
        $this->db->set('ultima_fecha', $fecha);
        $this->db->set('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->insert('tareas_servicio_por_usuario_vehiculo');
        return mysql_insert_id();
        }else{
            $id = $query->row(0)->id_tarea_realizada;
            if($kilometraje != '' || !empty($kilometraje))
                $this->db->set('kilometraje', $kilometraje);
            $this->db->set('ultima_fecha', $fecha);
            $this->db->where('id_tarea_realizada', $id);
            $this->db->update('tareas_servicio_por_usuario_vehiculo');
            return $id;
        }
    }

    function registrar_tarea_no_realizada_vehiculo($id_tarea_realizada) {
        $this->db->escape($id_tarea_realizada);
        $this->db->where('id_tarea_realizada', $id_tarea_realizada);
        $this->db->delete('tareas_servicio_por_usuario_vehiculo');
    }

    function eliminar_tarea_realizada_vehiculo($id_registro) {
        $data = array(
            'ultima_fecha' => 'fecha_previa',
            'fecha_previa' => ''
        );
        $this->db->where('id_tarea_realizada', $id_registro);
        $this->db->update('tareas_servicio_por_usuario_vehiculo', $data);
        return true;
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
    function dar_ciudad($id_ciudad) {
        $this->db->select('ciudad, kilometraje');
        $this->db->where('id_ciudad', $id_ciudad);
        $query = $this->db->get('kilometraje_ciudades');
        return $query->row(0);
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
     * Modifica el kilometraje de un vehículo
     */
    function modificar_kilometraje_vehiculo($id_usuario_vehiculo, $kilometraje) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->escape($kilometraje);
        $this->db->set('kilometraje', $kilometraje);
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->update('usuarios_vehiculos');
    }

    /**
     * Modifica la placa de un vehículo
     */
    function modificar_placa_vehiculo($id_usuario_vehiculo, $placa) {
        $this->db->escape($id_usuario_vehiculo);
        $this->db->escape($placa);
        $this->db->set('numero_placa', $placa);
        $this->db->set('fecha', 'curdate()', FALSE);
        $this->db->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $this->db->update('usuarios_vehiculos');
    }

    /**
     * Metodo que retorna el último registro realizado por el cronjob según el tipo dado
     * @param stirng $tipo cronjob que se desea consultar
     * @return boolean si el tipo no se encuentra o un registro de la tabla cron_jobs
     */
    function dar_ultimo_cronjob_tipo($tipo) {
        $this->db->escape($tipo);
        if ($tipo == "kilometraje") {
            $this->db->where('tipo', 'kilometraje');
            $this->db->order_by('fecha', 'desc');
            return $this->db->get('cron_jobs', 1)->row(0);
        } else if ($tipo == "legales") {
            $this->db->where('tipo', 'legales');
            $this->db->order_by('fecha', 'desc');
            return $this->db->get('cron_jobs', 1)->row(0);
        } else if ($tipo == "newsletter") {
            $this->db->where('tipo', 'newsletter');
            $this->db->order_by('fecha', 'desc');
            return $this->db->get('cron_jobs', 1)->row(0);
        } else if ($tipo == "tareamto") {
            $this->db->where('tipo', 'tareamto');
            $this->db->order_by('fecha', 'desc');
            return $this->db->get('cron_jobs', 1)->row(0);
        } else if ($tipo == "oferta") {
            $this->db->where('tipo', 'oferta');
            $this->db->order_by('fecha', 'desc');
            return $this->db->get('cron_jobs', 1)->row(0);
        } else {
            $this->db->where('tipo', $tipo);
            $this->db->order_by('fecha', 'desc');
            return $this->db->get('cron_jobs', 1)->row(0);
        }
    }

    /**
     * Se agrega la fecha actual la tabla de cronjob
     * @param type $tipo
     * @return type insert_id
     */
    function agregar_cronjob($tipo) {
        $this->db->escape($tipo);
        if ($tipo == "kilometraje") {
            $this->db->set('fecha', 'curdate()', FALSE);
            $this->db->set('tipo', 'kilometraje');
            $this->db->insert('cron_jobs');
        } else if ($tipo == "legales") {
            $this->db->set('fecha', 'curdate()', FALSE);
            $this->db->set('tipo', 'legales');
            $this->db->insert('cron_jobs');
        } else if ($tipo == "newsletter") {
            $this->db->set('fecha', 'curdate()', FALSE);
            $this->db->set('tipo', 'newsletter');
            $this->db->insert('cron_jobs');
        } else if ($tipo == "tareamto") {
            $this->db->set('fecha', 'curdate()', FALSE);
            $this->db->set('tipo', 'tareamto');
            $this->db->insert('cron_jobs');
        }else{
            $this->db->set('fecha', 'curdate()', FALSE);
            $this->db->set('tipo', $tipo);
            $this->db->insert('cron_jobs');
        }
        return mysql_insert_id();
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
     * actualiza el carrito de compras 
     * dependiendo del estado de la compra, lo cambia de realizado a no realizado 
     * @param type $id_oferta
     * @param type $estado 
     */
    function carrito_realizado($id_carrito_compra, $estado) {
        $this->db->escape($id_carrito_compra);
        $this->db->escape($estado);
        $this->db->set('realizado', $estado);
        $this->db->where('id_carrito_compra', $id_carrito_compra);
        $this->db->update('carritos_compras');
    }

    /**
     * Devuelve el número de carritos de compras con "Transacción Aprobada" que tiene el usuario
     * @param int $id_usuario 
     */
    function dar_num_carritos_compras_usuario($id_usuario) {
        $this->db->escape($id_usuario);
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('estado', 'Transacción aprobada');
        $this->db->order_by('id_carrito_compra', 'desc');
        $query = $this->db->get('carritos_compras');
        return $query->num_rows();
    }

    function dar_num_ofertas_vigentes_vehiculo($id_vehiculo) {
        $this->db->escape($id_vehiculo);
        $this->db->join('establecimientos_ofertas', 'oferta.id_oferta = establecimientos_ofertas.id_oferta');
        $this->db->where('establecimientos_ofertas.id_vehiculo', $id_vehiculo);
        $this->db->where('vigencia >', 'curdate()', FALSE);
        $this->db->group_by('id_oferta');
        $rs = $this->db->get('oferta');
        return $rs->num_rows();
    }

    /**
     * Retorna el número de ofertas vigentes para el usuario
     * @param type $id_usuario
     * @return type 
     */
    function dar_num_ofertas_vigentes_usuario($id_usuario) {
        $this->db->escape($id_usuario);
        $this->db->join('establecimientos_ofertas', 'oferta.id_oferta = establecimientos_ofertas.id_oferta');
        $this->db->join('usuarios_vehiculos', 'usuarios_vehiculos.id_vehiculo = establecimientos_ofertas.id_vehiculo');
        $this->db->where('usuarios_vehiculos.id_usuario', $id_usuario);
        $this->db->where('vigencia >', 'curdate()', FALSE);
        $this->db->where('dco_feria', '0');
        $this->db->group_by('oferta.id_oferta');
        $rs = $this->db->get('oferta');
        return $rs->num_rows();
    }

    /**
     * Da todas las ofertas vigentes
     * @param type $id_tarea
     * @return type 
     */
    function dar_todas_ofertas($id_usuario, $offset = -1) {
        $this->db->escape($id_usuario);
        $this->db->select('oferta.id_oferta AS id_oferta, tareas.id_servicios_categoria AS categoria, oferta.titulo AS titulo, 
                oferta.precio AS precio, oferta.condiciones AS condiciones, oferta.incluye AS incluye, oferta.descripcion AS descripcion, 
                oferta.vigencia AS vigencia, oferta.dco_feria, establecimientos_ofertas.id_establecimiento as id_establecimiento, 
                establecimientos.nombre as establecimientoNombre, establecimientos.descripcion as establecimientoDescripcion, 
                establecimientos.direccion as direccion, establecimientos.logo_thumb_url as logo, 
                count(establecimientos_comentarios.id_establecimiento) as num_comentarios, 
                avg(establecimientos_comentarios.calificacion) as calificacion, dco_feria');
        $this->db->join('establecimientos_ofertas', 'oferta.id_oferta = establecimientos_ofertas.id_oferta');
        $this->db->join('tareas', 'tareas.id_servicios_categoria = establecimientos_ofertas.id_servicios_categoria');
        $this->db->join('establecimientos', 'establecimientos_ofertas.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->join('establecimientos_comentarios', 'establecimientos_comentarios.id_establecimiento = establecimientos_ofertas.id_establecimiento', 'left');
        $this->db->join('usuarios_vehiculos', 'usuarios_vehiculos.id_vehiculo = establecimientos_ofertas.id_vehiculo');
        $this->db->where('usuarios_vehiculos.id_usuario', $id_usuario);
        $this->db->where('vigencia >', 'curdate()', FALSE);
//        $this->db->where('dco_feria','0');
        if ($offset != -1) {
            $this->db->limit(4, $offset);
        }
        $this->db->group_by('id_oferta');
        $rs = $this->db->get('oferta');
        return $rs->result();
    }

    /**
     *  da todas las ofertas por usuario 
     */
    function dar_ofertas_usuarios() {
        $this->db->select('id_usuario');
        $this->db->distinct();
        $this->db->from('usuarios_ofertas');
        $rs = $this->db->get();
        return $rs->result();
    }

    /**
     *  da todas las ofertas por usuario 
     */
    function dar_ofertas_usuario($id_usuario) {
        $this->db->escape($id_usuario);
        $this->db->select('usuarios_ofertas.id_oferta, usuarios_ofertas.id_usuario, usuarios.nombres, usuarios.apellidos, oferta.precio, oferta.incluye, 
           oferta.condiciones, oferta.descripcion, oferta.titulo, usuarios_ofertas.ahorro,usuarios.email,
           establecimientos.id_establecimiento, establecimientos.nombre as nombre_establecimiento, establecimientos.email as email_establecimiento, establecimientos.web,
           establecimientos.logo_url as logo_establecimiento, establecimientos.telefonos as telefonos, establecimientos.descripcion as descripcion_establecimiento,
           establecimientos.direccion');
        $this->db->join('usuarios', 'usuarios.id_usuario = usuarios_ofertas.id_usuario');
        $this->db->join('oferta', 'oferta.id_oferta = usuarios_ofertas.id_oferta');
        $this->db->join('establecimientos_ofertas', 'establecimientos_ofertas.id_oferta = oferta.id_oferta');
        $this->db->join('establecimientos', 'establecimientos.id_establecimiento = establecimientos_ofertas.id_establecimiento');
        $this->db->where('usuarios_ofertas.id_usuario', $id_usuario);
        $this->db->from('usuarios_ofertas');
        $this->db->group_by('usuarios_ofertas.id_oferta');
        $rs = $this->db->get();
        return $rs->result();
    }

    /**
     * Da las ofertas relacionadas a un id tarea MTO
     * @param type $id_tarea
     * @return type 
     */
    function dar_ofertas($id_usuario, $id_vehiculo, $offset = -1) {
        $this->db->escape($id_usuario);
        $this->db->escape($id_vehiculo);
        $this->db->select('oferta.id_oferta AS id_oferta, tareas.id_servicios_categoria AS categoria, oferta.titulo AS titulo, 
                oferta.precio AS precio, oferta.condiciones AS condiciones, oferta.incluye AS incluye, oferta.descripcion AS descripcion, 
                oferta.vigencia AS vigencia, establecimientos_ofertas.id_establecimiento as id_establecimiento, 
                establecimientos.nombre as establecimientoNombre, establecimientos.descripcion as establecimientoDescripcion, 
                establecimientos.direccion as direccion, establecimientos.logo_thumb_url as logo, 
                count(establecimientos_comentarios.id_establecimiento) as num_comentarios, 
                avg(establecimientos_comentarios.calificacion) as calificacion');
        $this->db->join('establecimientos_ofertas', 'oferta.id_oferta = establecimientos_ofertas.id_oferta');
        $this->db->join('tareas', 'tareas.id_servicios_categoria = establecimientos_ofertas.id_servicios_categoria');
        $this->db->join('establecimientos', 'establecimientos_ofertas.id_establecimiento = establecimientos.id_establecimiento');
        $this->db->join('establecimientos_comentarios', 'establecimientos_comentarios.id_establecimiento = establecimientos_ofertas.id_establecimiento', 'left');
        $this->db->join('usuarios_vehiculos', 'usuarios_vehiculos.id_vehiculo = establecimientos_ofertas.id_vehiculo');
        $this->db->where('usuarios_vehiculos.id_usuario', $id_usuario);
        $this->db->where('establecimientos_ofertas.id_vehiculo', $id_vehiculo);
        $this->db->where('vigencia >', 'curdate()', FALSE);
        $this->db->where('dco_feria', '0');
        if ($offset != -1) {
            $this->db->limit(6, $offset);
        }
        $this->db->group_by('id_oferta');
        $rs = $this->db->get('oferta');
        return $rs->result();
    }

    /**
     * Valida que nombre de usuario no exista, en caso de que exista el usuario
     * retorna false, en caso de que no exista retorna true
     * @param string $usuario
     * @return boolean 
     */
    function validar_nombre_usuario($usuario) {
        $this->db->escape($usuario);
        $this->db->where('usuario', $usuario);
        $query = $this->db->get('usuarios');
        if ($query->num_rows() > 0) {
            return "false";
        } else {
            return "true";
        }
    }

    /**
     * Valida que email de usuario no exista, en caso de que exista el usuario
     * retorna false, en caso de que no exista retorna true
     * @param string $usuario
     * @return boolean 
     */
    function validar_email_existente_ajax($email) {
        $this->db->escape($email);
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        if ($query->num_rows() > 0) {
            return "false";
        } else {
            return "true";
        }
    }

    /**
     * Agrega el id del carrito de compra y retorna el consecutivo de compra 
     */
    function agregar_consecutivo_compra($id_carrito_compra) {
        $this->db->escape($id_carrito_compra);
        $this->db->set('id_carritos_compras', $id_carrito_compra);
        $this->db->insert('consecutivo_factura');
        return mysql_insert_id();
    }

    function dar_usuarios_registrados($fecha) {
        $this->db->where('fecha_creacion >=', $fecha);
        $query = $this->db->get('usuarios');
        return $query->num_rows();
    }

    /**
     * Da el número de de vehículos vinculados a los usuarios según la fecha
     * @param type $fecha
     * @return type 
     */
    function dar_carros_registrados($fecha) {
        $this->db->where('fecha >=', $fecha);
        $query = $this->db->get('usuarios_vehiculos');
        return $query->num_rows();
    }

    /**
     * Agrega un bono a un usuario dado 
     */
    function agregar_bono_usuario($id_usuario, $id_establecimiento, $id_vehiculo, $nombres, $email, $lugar, $direccion, $telefono, $descripcion) {
        $this->db->escape($id_usuario);
        $this->db->escape($id_establecimiento);
        $this->db->escape($id_vehiculo);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('id_establecimiento', $id_establecimiento);
        $this->db->set('id_vehiculo', $id_vehiculo);
        $this->db->set('nombres', $nombres);
        $this->db->set('email', $email);
        $this->db->set('lugar', $lugar);
        $this->db->set('direccion', $direccion);
        $this->db->set('telefono', $telefono);
        $this->db->set('descripcion', $descripcion);
        $this->db->set('fecha', 'curdate()', FALSE);
        $this->db->insert('bono');
        return mysql_insert_id();
    }

    /**
     * Da el bono según el consecutivo
     * @param type $consecutivo
     * @return type 
     */
    function dar_bono($consecutivo) {
        $this->db->escape($consecutivo);
        $this->db->select('bono.*, vehiculos.marca, vehiculos.linea, establecimientos.nombre as nombreEstablecimiento, establecimientos.direccion as direccionestablecimiento,
            establecimientos.telefonos as telefonosEstablecimientos, establecimientos.email as emailEstablecimientos');
        $this->db->join('establecimientos', 'establecimientos.id_establecimiento = bono.id_establecimiento');
        $this->db->join('vehiculos', 'vehiculos.id_vehiculo = bono.id_vehiculo');
        $this->db->where('id_bono', $consecutivo);
        $query = $this->db->get('bono');
        return $query->row(0);
    }

    /**
     * Inserta el html del correo que se enviará en el futuro
     * @param type $id_usuario
     * @param type $correo
     * @param type $html contenido del correo
     */
    function guardar_html_correo_usuario($id_usuario, $correo, $html, $titulo) {
        $this->db->escape($id_usuario);
        $this->db->escape($correo);
        $this->db->escape($html);
        $this->db->escape($titulo);
        $this->db->set('id_usuario', $id_usuario);
        $this->db->set('email', $correo);
        $this->db->set('contenido', $html);
        $this->db->set('titulo', $titulo);
        $this->db->insert('cola_correos');
    }

    /**
     * Da los usuarios destinatarios para enviar correos
     * @return type
     */
    function dar_cola_usuarios() {
        $this->db->select('id_usuario, email');
        $this->db->distinct();
        $query = $this->db->get('cola_correos');
        return $query->result();
    }

    /**
     * Da el primer html del correo que se va a enviar
     * @param type $id_usuario
     * @return type
     */
    function dar_cola_correos_enviar($id_usuario) {
        $this->db->escape($id_usuario);
        $this->db->select('id_cola_correos, contenido, titulo');
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('cola_correos');
        return $query->row(0);
    }

    /**
     * Elimina una fila de cola_correos según el id
     * @param type $id_cola_correo
     */
    function eliminar_correo_cola($id_cola_correo) {
        $this->db->escape($id_cola_correo);
        $this->db->where('id_cola_correos', $id_cola_correo);
        $this->db->delete('cola_correos');
    }
    
    /**
     * Da los usuarios que realizaron la compra hace 15 días
     * @return type
     */
    function dar_usuarios_califica_experiencia(){
        $query = $this->db->query('
            select cc.id_carrito_compra , u.nombres, u.apellidos, u.id_usuario, u.email, Tcco.id_establecimiento,  Tcco.nombre as taller, Tcco.email as emailTaller
            from carritos_compras cc
                join usuarios u on u.id_usuario = cc.id_usuario 
                left join 
                    (select cco.id_carrito_compra, e.id_establecimiento, e.nombre, e.email  from carritos_compras_ofertas cco join establecimientos_ofertas eo on eo.id_oferta = cco.id_oferta
                    join establecimientos e on e.id_establecimiento = eo.id_establecimiento
                    union
                    select cca.id_carrito_compra, e.id_establecimiento, e.nombre, e.email  from carritos_compras_autopartes cca join establecimientos_autopartes ea on ea.id_autoparte = cca.id_autoparte
                    join establecimientos e on e.id_establecimiento = ea.id_establecimiento
                    ) as Tcco
                on Tcco.id_carrito_compra = cc.id_carrito_compra 
            where  (cc.fecha + INTERVAL 15 DAY) = CURDATE()');
        return $query->result();
    }
    
     /**
     * Da los usuarios que realizaron la compra hace 15 días
     * @return type
     */
    function dar_carrito_califica_experiencia($llave){
        $this->db->escape($llave);
        $this->db->select('califica_experiencia.*');
        $this->db->from('califica_experiencia');
        $this->db->where('llave', $llave);
        $query = $this->db->get();
        return $query->row(0);
    }
    
    /**
     * elimina el registro de la llave
     * @param type $califica_experiencia
     */
    function eliminar_llave_califica_experiencia($id_califica_experiencia){
        $this->db->escape($id_califica_experiencia);
        $this->db->where('id_califica_experiencia', $id_califica_experiencia);
        $this->db->delete('califica_experiencia');
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
                $this->db->from('califica_experiencia');
                $q = $this->db->count_all_results();
                if ($q == 0 ) {
                    $value = $key;
                    $result = true;
                }else
                $key = $this->getUniqueCode(10);

        }
        return $value;
    }

        /**
     * Guarda el registro de la llave única de pregunta en la DB
     * @param type $llave
     * @param type $id_carrito
     */
    function guardar_codConfirmacion_Unico($llave, $id_carrito, $id_establecimiento){
        $this->db->escape($llave);
        $this->db->escape($id_carrito);
        $this->db->escape($id_establecimiento);
        $this->db->set('llave', $llave);
        $this->db->set('id_carrito', $id_carrito);
        $this->db->set('id_establecimiento', $id_establecimiento);
        $this->db->insert('califica_experiencia');
    }
    
     /*Función que genera un valor alfanumérico para el valor de la referencia de la confirmación de la pregunta
     * @param type $length
     * @return String código único 
     */
    function getUniqueCode($length = "")
    {	
            $code = md5(uniqid(rand(), true));
            if ($length != "") return substr($code, 0, $length);
            else return $code;
    }
}