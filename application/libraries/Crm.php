<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Libreria encargada de manejar el ingreso, actualización y eliminación de registros
 */
class Crm {

    //maneja una instancia de CI
    private $_CI;
    //maneja una conexión a la base de datos de crm
    private $_db_crm;

    public function __construct() {
        $this->_CI = & get_instance();
    }

    /**
     * Agrega un usuario a la DB del CRM 
     * @param int $params[laspartes_id_usuario_c] id del usuario registrado en laspartes
     * @param string $params[first_name] nombres del usuario
     * @param string $params[last_name] apellidos del usuario
     * @param email $params[email] email del usuario
     * @param string $params[primary_address_city] ciudad done recide el usuario
     * @param string $params[primary_address_country] país donde recide el usuario
     * @param int $params[phone_home] teléfono de contacte del usuario
     * 
     */
    public function agregar_usuario($params) {
        $this->_db_crm = $this->_CI->load->database('CRM', TRUE);
        $uID = $this->create_guid();
        $this->_db_crm->set('id', $uID);
        foreach ($params as $key => $value) {
            if ($key != 'email' && $key != 'laspartes_id_usuario_c') {
                $this->_db_crm->set($key, $value);
            }
        }
        $this->_db_crm->insert('contacts');

        //inserta el id del usuario en laspartes
        $this->_db_crm->set('id_c', $uID);
        $this->_db_crm->set('laspartes_id_usuario_c', $params['laspartes_id_usuario_c']);
        $this->_db_crm->insert('contacts_cstm');

        //insertar el email
        $this->agregar_email_usuario($uID, $params['email']);

        //cambia la base de datos al default
        $this->_CI->load->database('default', TRUE);
    }

    /**
     * Agrega el email a un usuario dado según su uID
     * @param string $uID id del usuario en el crm
     * @param email $email email del usuario a agregar
     */
    private function agregar_email_usuario($uID, $email) {
        $email_addrs_uID = $this->create_guid();
        $this->_db_crm->set('id', $email_addrs_uID);
        $this->_db_crm->set('email_address', $email);
        $this->_db_crm->set('email_address_caps', strtoupper($email));
        $this->_db_crm->insert('email_addresses');

        $email_bean_uID = $this->create_guid();
        $this->_db_crm->set('id', $email_bean_uID);
        $this->_db_crm->set('email_address_id', $email_addrs_uID);
        $this->_db_crm->set('bean_id', $uID);
        $this->_db_crm->set('bean_module', 'Contacts');
        $this->_db_crm->set('primary_address', '1');
        $this->_db_crm->insert('email_addr_bean_rel');
    }

    /**
     * Actualiza un usuario a la DB del CRM 
     * @param int $params[laspartes_id_usuario_c] id del usuario registrado en laspartes
     * @param string $params[first_name] nombres del usuario
     * @param string $params[last_name] apellidos del usuario
     * @param email $params[email] email del usuario
     * @param string $params[primary_address_city] ciudad done recide el usuario
     * @param string $params[primary_address_country] país donde recide el usuario
     * @param int $params[phone_home] teléfono de contacte del usuario
     * 
     */
    public function actualizar_usuario($params) {
        $this->_db_crm = $this->_CI->load->database('CRM', TRUE);
        $uID = $this->dar_uID($params['laspartes_id_usuario_c']);
        foreach ($params as $key => $value) {
            if ($key != 'email' && $key != 'laspartes_id_usuario_c')
                $this->_db_crm->set($key, $value);
        }
        $this->_db_crm->where('id', $uID);
        $this->_db_crm->update('contacts');
        $this->actualizar_correo_usuario($uID, $params['email']);

        $this->_CI->load->database('default', TRUE);
    }

    /**
     * Da el uID según el id usuario vehiculo
     * @param int $id_usuario_vehiculo
     * @return string uID
     */
    private function dar_vehiculo_uID($id_usuario_vehiculo) {
        $this->_db_crm->select('id');
        $this->_db_crm->where('id_usuario_vehiculo', $id_usuario_vehiculo);
        $query = $this->_db_crm->get('ve111_vehiculos');
        return $query->row(0)->id;
    }

    /**
     * Da el uID según el id usuario
     * @param int $id_usuario
     * @return string uID
     */
    private function dar_uID($id_usuario) {
        $this->_db_crm->select('id_c');
        $this->_db_crm->where('laspartes_id_usuario_c', $id_usuario);
        $query = $this->_db_crm->get('contacts_cstm');
        return $query->row(0)->id_c;
    }

    /**
     * Actualiza el correo de un usuario según su uID
     * @param string $uID
     * @param email $correo
     */
    private function actualizar_correo_usuario($uID, $correo) {
        $this->_db_crm->select('email_address_id');
        $this->_db_crm->where('bean_id', $uID);
        $q = $this->_db_crm->get('email_addr_bean_rel');
        $email_addrs_uID = $q->row(0)->email_address_id;

        $this->_db_crm->where('id', $email_addrs_uID);
        $this->_db_crm->set('email_address', $correo);
        $this->_db_crm->set('email_address_caps', strtoupper($correo));
        $this->_db_crm->update('email_addresses');
    }

    /**
     * Agrega un vehículo
     * @param int $params[id_usuario] id del usuario registrado en laspartes
     * @param string $params[marca] marca del carro
     * @param string $params[linea] linea del carro
     * @param int $params[modelo] modelo del carro
     * @param int $params[kilometraje] kilometraje del carro
     * @param string $params[placa] placa del carro
     * @param string $params[id_usuario_vehiculo] id del carro
     */
    function agregar_vehiculo($params) {
        $this->_db_crm = $this->_CI->load->database('CRM', TRUE);
        $uID_usuario = $this->dar_uID($params['id_usuario']);
        $uID = $this->create_guid();
        $this->_db_crm->set('id', $uID);
        $this->_db_crm->set('name', $params['marca'] . ' ' . $params['linea']);
        foreach ($params as $key => $value) {
            if ($key != 'id_usuario' && $key != 'marca' && $key != 'linea' && $key != 'id_vehiculo')
                $this->_db_crm->set($key, $value);
        }
        $this->_db_crm->insert('ve111_vehiculos');

        $marcalinea_uID = $this->dar_marcalinea_uID($params['id_vehiculo']);
        $this->agregar_marcalinea_vehiculo($uID, $marcalinea_uID);
        $this->agregar_vehiculo_usuario($uID_usuario, $uID);
        $this->_CI->load->database('default', TRUE);
    }

    /**
     * Asocia un vehículo con un usuaro
     * @param string $uID_vehiculo
     * @param string $uID_marcalinea
     */
    private function agregar_marcalinea_vehiculo($uID_vehiculo, $uID_marcalinea) {
        $uID = $this->create_guid();
        $this->_db_crm->set('id', $uID);
        $this->_db_crm->set('ve111_marcalinea_ve111_vehiculosve111_marcalinea_ida', $uID_marcalinea);
        $this->_db_crm->set('ve111_marcalinea_ve111_vehiculosve111_vehiculos_idb', $uID_vehiculo);
        $this->_db_crm->insert('ve111_marcalinea_ve111_vehiculos_c');
    }

    /**
     * Da el uID del vehículo
     * @param type $id_vehiculo
     * @return int id
     */
    private function dar_marcalinea_uID($id_vehiculo) {
        $this->_db_crm->select('id');
        $this->_db_crm->where('id_vehiculo', $id_vehiculo);
        $q = $this->_db_crm->get('ve111_marcalinea');
        return $q->row(0)->id;
    }

    /**
     * Asocia un vehículo con un usuaro
     * @param string $uID_usuario
     * @param string $uID_vehiculo
     */
    private function agregar_vehiculo_usuario($uID_usuario, $uID_vehiculo) {
        $uID = $this->create_guid();
        $this->_db_crm->set('id', $uID);
        $this->_db_crm->set('ve111_vehiculos_contactsve111_vehiculos_idb', $uID_vehiculo);
        $this->_db_crm->set('ve111_vehiculos_contactscontacts_ida', $uID_usuario);
        $this->_db_crm->insert('ve111_vehiculos_contacts_c');
    }

    /**
     * Agrega la marca y línea de vehículo
     * @param int $id_vehiculo
     * @param string $marca
     * @param string $linea
     */
    function agregar_marcalinea($id_vehiculo, $marca, $linea) {
        $this->_db_crm = $this->_CI->load->database('CRM', TRUE);

        $uID = $this->create_guid();
        $this->_db_crm->set('id', $uID);
        $this->_db_crm->set('name', $marca . ' ' . $linea);
        $this->_db_crm->set('id_vehiculo', $id_vehiculo);
        $this->_db_crm->set('marca', $marca);
        $this->_db_crm->set('linea', $linea);
        $this->_db_crm->insert('ve111_marcalinea');

        $this->_CI->load->database('default', TRUE);
    }

    /**
     * Actualiza un vehículo
     * @param int $params[id_usuario] id del usuario registrado en laspartes
     * @param string $params[marca] marca del carro
     * @param string $params[linea] linea del carro
     * @param int $params[modelo] modelo del carro
     * @param int $params[kilometraje] kilometraje del carro
     * @param string $params[placa] placa del carro
     * @param string $params[id_usuario_vehiculo] id del carro
     */
    function actualizar_vehiculo($params) {
        $this->_db_crm = $this->_CI->load->database('CRM', TRUE);

        $this->_db_crm->set('name', $params['marca'] . ' ' . $params['linea']);
        foreach ($params as $key => $value) {
            if ($key != 'id_usuario' && $key != 'id_usuario_vehiculo' && $key != 'marca' && $key != 'linea' && $key != 'id_vehiculo')
                $this->_db_crm->set($key, $value);
        }
        $this->_db_crm->where('id_usuario_vehiculo', $params['id_usuario_vehiculo']);
        $this->_db_crm->update('ve111_vehiculos');

        $usuariovehiculo_uID = $this->dar_vehiculo_uID($params['id_usuario_vehiculo']);
        $marcalinea_uID = $this->dar_marcalinea_uID($params['id_vehiculo']);
        $this->actualizar_marcalinea_vehiculo($usuariovehiculo_uID, $marcalinea_uID);

        $this->_CI->load->database('default', TRUE);
    }

    /**
     * Actualiza la relación de marcalinea y vehiculo
     * @param string $uID_vehiculo
     * @param string $uID_marcalinea
     */
    private function actualizar_marcalinea_vehiculo($uID_vehiculo, $uID_marcalinea) {
        $this->_db_crm->set('ve111_marcalinea_ve111_vehiculosve111_marcalinea_ida', $uID_marcalinea);
        $this->_db_crm->where('ve111_marcalinea_ve111_vehiculosve111_vehiculos_idb', $uID_vehiculo);
        $this->_db_crm->update('ve111_marcalinea_ve111_vehiculos_c');
    }

    /**
     * Agrega compras al CRM
     * @param int $params[id_usuario] id del usuario registrado en laspartes que ha comprado
     * @param int $params[id_carrito] id del carrito de compras
     * @param string $params[name] titulo del item
     * @param int $params[amount] valor del item
     * @param string $params[tipo] el tipo del item (Autoparte u Oferta)
     * @param string $params[titulo] titulo del item
     * @param int $params[cantidad] cantidad el item comprado
     * @param date $params[fecha_compra] fecha de compra del item
     * @param string $params[recibo] url donde se encuentra el recibo de compra
     */
    function agregar_carrito_compras($params) {
        $this->_db_crm = $this->_CI->load->database('CRM', TRUE);
        $uID_usuario = $this->dar_uID($params['id_usuario']);
        $uID = $this->create_guid();
        $this->_db_crm->set('id', $uID);
        foreach ($params as $key => $value) {
            if ($key != 'id_usuario')
                $this->_db_crm->set($key, $value);
        }
        $this->_db_crm->insert('venta_compra');
        $this->agregar_carrito_compras_usuario($uID_usuario, $uID);

        $this->_CI->load->database('default', TRUE);
    }

    /**
     * Asocia una compra con un usuaro
     * @param string $uID_usuario
     * @param string $uID_compra
     */
    private function agregar_carrito_compras_usuario($uID_usuario, $uID_compra) {
        $uID = $this->create_guid();
        $this->_db_crm->set('id', $uID);
        $this->_db_crm->set('venta_compra_contactsventa_compra_idb', $uID_compra);
        $this->_db_crm->set('venta_compra_contactscontacts_ida', $uID_usuario);
        $this->_db_crm->insert('venta_compra_contacts_c');
    }

    /**
     * A temporary method of generating GUIDs of the correct format for our DB.
     * @return String contianing a GUID in the format: aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
     *
     * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
     * All Rights Reserved.
     * Contributor(s): ______________________________________..
     */
    public function create_guid() {
        $microTime = microtime();
        list($a_dec, $a_sec) = explode(" ", $microTime);

        $dec_hex = dechex($a_dec * 1000000);
        $sec_hex = dechex($a_sec);

        $this->ensure_length($dec_hex, 5);
        $this->ensure_length($sec_hex, 6);

        $guid = "";
        $guid .= $dec_hex;
        $guid .= $this->create_guid_section(3);
        $guid .= '-';
        $guid .= $this->create_guid_section(4);
        $guid .= '-';
        $guid .= $this->create_guid_section(4);
        $guid .= '-';
        $guid .= $this->create_guid_section(4);
        $guid .= '-';
        $guid .= $sec_hex;
        $guid .= $this->create_guid_section(6);

        return $guid;
    }

    public function create_guid_section($characters) {
        $return = "";
        for ($i = 0; $i < $characters; $i++) {
            $return .= dechex(mt_rand(0, 15));
        }
        return $return;
    }

    public function ensure_length(&$string, $length) {
        $strlen = strlen($string);
        if ($strlen < $length) {
            $string = str_pad($string, $length, "0");
        } else if ($strlen > $length) {
            $string = substr($string, 0, $length);
        }
    }

    public function microtime_diff($a, $b) {
        list($a_dec, $a_sec) = explode(" ", $a);
        list($b_dec, $b_sec) = explode(" ", $b);
        return $b_sec - $a_sec + $b_dec - $a_dec;
    }

    /* Metodos de popular la DB */

    /**
     * Migra todo los usuaros en la DB del CRM
     * @param int $params[id_usuario] id del usuario registrado en laspartes
     * @param string $params[marca] marca del carro
     * @param string $params[linea] linea del carro
     * @param int $params[modelo] modelo del carro
     * @param int $params[kilometraje] kilometraje del carro
     * @param string $params[placa] placa del carro
     * @param string $params[id_usuario_vehiculo] id del carro
     */
    public function migrar_usuarios($params) {
        $this->_db_crm = $this->_CI->load->database('CRM', TRUE);
        foreach ($params as $usuario) {
            $params = array();
            $params['laspartes_id_usuario_c'] = $usuario->id_usuario;
            $params['first_name'] = $usuario->nombres;
            $params['last_name'] = $usuario->apellidos;
            $params['email'] = $usuario->email;
            $params['primary_address_city'] = $usuario->lugar;
            $params['primary_address_country'] = $usuario->pais;
            $params['phone_home'] = $usuario->telefonos;
            $this->agregar_usuario($params);
        }
        $this->_CI->load->database('default', TRUE);
    }

    /**
     * Migra todo los vehiculos en la DB del CRM
     * @param int $params[id_usuario] id del usuario registrado en laspartes
     * @param string $params[marca] marca del carro
     * @param string $params[linea] linea del carro
     * @param int $params[modelo] modelo del carro
     * @param int $params[kilometraje] kilometraje del carro
     * @param string $params[placa] placa del carro
     * @param string $params[id_usuario_vehiculo] id del carro
     */
    public function migrar_usuarios_vehiculos($params) {
        $this->_db_crm = $this->_CI->load->database('CRM', TRUE);
        foreach ($params as $vehiculo) {
            $params = array();
            $params['id_usuario_vehiculo'] = $vehiculo->id_usuario_vehiculo;
            $params['id_vehiculo'] = $vehiculo->id_vehiculo;
            $params['id_usuario'] = $vehiculo->id_usuario;
            $params['modelo'] = $vehiculo->modelo;
            $params['kilometraje'] = $vehiculo->kilometraje;
            $params['marca'] = $vehiculo->marca;
            $params['linea'] = $vehiculo->linea;
            $params['placa'] = $vehiculo->numero_placa;
            $this->agregar_vehiculo($params);
        }
        $this->_CI->load->database('default', TRUE);
    }

    /**
     * Migra todas las compras den la DB del CRM
     * @param int $params[id_usuario] id del usuario registrado en laspartes que ha comprado
     * @param int $params[id_carrito] id del carrito de compras
     * @param string $params[name] titulo del item
     * @param int $params[amount] valor del item
     * @param string $params[tipo] el tipo del item (Autoparte u Oferta)
     * @param string $params[titulo] titulo del item
     * @param int $params[cantidad] cantidad el item comprado
     * @param date $params[fecha_compra] fecha de compra del item
     * @param string $params[recibo] url donde se encuentra el recibo de compra
     */
    public function migrar_usuarios_compras($params) {
        $this->_db_crm = $this->_CI->load->database('CRM', TRUE);
        foreach ($params as $carrito) {
            $params = array();
            $params['id_carrito'] = $carrito->id_carrito_compra;
            $params['id_usuario'] = $carrito->id_usuario;
            $params['name'] = $carrito->titulo;
            $params['amount'] = $carrito->precio;
            $params['tipo'] = $carrito->tipo;
            $params['titulo'] = $carrito->titulo;
            $params['cantidad'] = $carrito->cantidad;
            $params['fecha_compra'] = $carrito->fecha;
            $params['recibo'] = base_url() . 'usuario/recibo/' . $carrito->refVenta;
            $this->agregar_carrito_compras($params);
        }
        $this->_CI->load->database('default', TRUE);
    }

    /**
     * Migra todos los vehiculos a la DBCRM de marcalinea
     * @param type $params
     */
    public function migrar_marcalinea($params) {
        foreach ($params as $marcalinea) {
            $this->agregar_marcalinea($marcalinea->id_vehiculo, $marcalinea->marca, $marcalinea->linea);
        }
    }

    /* fin de Metodos de popular la DB */
}

/* End of file crm.php */

