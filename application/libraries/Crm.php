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

    private $session_id;

    private $url = "http://crm.laspartes.com/service/v4/rest.php";

    private $username = "admin";

    private $password = "4dminCRM111";

    public function __construct() {
        $this->_CI = & get_instance();
        if(!isset($this->session_id) && ENVIRONMENT == 'production'){ //se verifica que la id sesion alla sido solo 1 ves inicializada
            $login_parameters = array(
                 "user_auth"=>array(
                      "user_name"=>'admin',
                      "password"=>md5('4dminCRM111'),
                      "version"=>"1"
                 ),
                 "application_name"=>"RestTest",
                 "name_value_list"=>array(),
            );
            $dir = $this->url;
            $login_result = $this->call("login", $login_parameters, $dir);

            //get session id
            $this->session_id = $login_result->id;
        }
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
        if(ENVIRONMENT == 'production'):
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
        endif;
    }

    /**
     * Agrega un usuario a la DB del CRM via REST
     * @param int $params[laspartes_id_usuario_c] id del usuario registrado en laspartes
     * @param string $params[first_name] nombres del usuario
     * @param string $params[last_name] apellidos del usuario
     * @param email $params[email] email del usuario
     * @param string $params[primary_address_city] ciudad done recide el usuario
     * @param string $params[primary_address_country] país donde recide el usuario
     * @param int $params[phone_home] teléfono de contacte del usuario
     * 
     */
    public function agregar_usuario_REST($params){
        if(ENVIRONMENT == 'production'):
            $name_value_list = array();
            array_push($name_value_list, array("name" => "estadoHook", "value" => true));
            foreach($params as $key => $value) {
                   array_push($name_value_list, array("name" => $key, "value" => $value));
            }
            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "Contacts",

                 //Record attributes
                 "name_value_list" => $name_value_list,
            );
            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $this->url);
            $this->crear_cuenta_REST($params);
        endif;
    }

    /**
     * Crea una cuenta al usuario
     * @param int $params[laspartes_id_usuario_c] id del usuario registrado en laspartes
     * @param string $params[first_name] nombres del usuario
     * @param string $params[last_name] apellidos del usuario
     * @param email $params[email] email del usuario
     * @param string $params[primary_address_city] ciudad done recide el usuario
     * @param string $params[primary_address_country] país donde recide el usuario
     * @param int $params[phone_home] teléfono de contacte del usuario
     * 
     */
    private function crear_cuenta_REST($params){
        if(ENVIRONMENT == 'production'):
            $name_value_list = array();
            // if(!empty($params['first_name']) ){
            array_push($name_value_list, array("name" => "estadoHook", "value" => true));
            $name = $params['first_name']. ' '. $params['last_name'];
            array_push($name_value_list, array("name" => "name", "value" => $name));

            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "Accounts",

                 //Record attributes
                 "name_value_list" => $name_value_list,
            );
            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $this->url);
            // }
        endif;
    }

    /**
     * Agrega varios usuario a la DB del CRM via REST
     * @param int $params[laspartes_id_usuario_c] id del usuario registrado en laspartes
     * @param string $params[first_name] nombres del usuario
     * @param string $params[last_name] apellidos del usuario
     * @param email $params[email] email del usuario
     * @param string $params[primary_address_city] ciudad done recide el usuario
     * @param string $params[primary_address_country] país donde recide el usuario
     * @param int $params[phone_home] teléfono de contacte del usuario
     * 
     */
    public function agregar_usuarios_REST($params){
        if(ENVIRONMENT == 'production'):
            $name_values_list = array();
            foreach ($params as $array) {
                $name_value_list = array();
                array_push($name_value_list, array("name" => "estadoHook", "value" => true));
                foreach($array as $key => $value) {
                       array_push($name_value_list, array("name" => $key, "value" => $value));
                }
                array_push($name_values_list, $name_value_list);
            }
            
            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "Contacts",

                 //Record attributes
                 "name_value_list" => $name_values_list,
            );
            $set_entry_result = $this->call("set_entries", $set_entry_parameters, $this->url);
            $this->crear_cuentas_REST($params);
        endif;
    }

    /**
     * Crea una cuenta por cada usuario existente
     * @param int $params[laspartes_id_usuario_c] id del usuario registrado en laspartes
     * @param string $params[first_name] nombres del usuario
     * @param string $params[last_name] apellidos del usuario
     * @param email $params[email] email del usuario
     * @param string $params[primary_address_city] ciudad done recide el usuario
     * @param string $params[primary_address_country] país donde recide el usuario
     * @param int $params[phone_home] teléfono de contacte del usuario
     */
    private function crear_cuentas_REST($params){
        if(ENVIRONMENT == 'production'):
            $name_values_list = array();
            foreach ($params as $array) {
                if(!empty($array['first_name']) ){
                $name_value_list = array();
                array_push($name_value_list, array("name" => "estadoHook", "value" => true));
                array_push($name_value_list, array("name" => "name", "value" => $array['first_name']. ' '. $array['last_name']) );
                array_push($name_values_list, $name_value_list);
               } 
            } 

            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "Accounts",

                 //Record attributes
                 "name_value_list" => $name_values_list,
            );
            $set_entry_result = $this->call("set_entries", $set_entry_parameters, $this->url);
        endif;
    }

    /**
     * Agrega el email a un usuario dado según su uID
     * @param string $uID id del usuario en el crm
     * @param email $email email del usuario a agregar
     */
    private function agregar_email_usuario($uID, $email) {
        if(ENVIRONMENT == 'production'):
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
        endif;
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
        if(ENVIRONMENT == 'production'):
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
        endif;
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
    public function actualizar_usuario_REST($params) {
        if(ENVIRONMENT == 'production'):
            $name_value_list = array();
            $uID = $this->dar_uID_REST($params['laspartes_id_usuario_c']);
            array_push($name_value_list, array("name" => "estadoHook", "value" => true));
            array_push($name_value_list, array("name" => 'id', "value" => $uID));
            foreach($params as $key => $value) {
                if ($key != 'laspartes_id_usuario_c')
                   array_push($name_value_list, array("name" => $key, "value" => $value));
            }
            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "Contacts",

                 //Record attributes
                 "name_value_list" => $name_value_list,
            );
            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $this->url);
        endif;
    }

    /**
     * Da el uID según el id usuario vehiculo
     * @param int $id_usuario_vehiculo
     * @return string uID
     */
    private function dar_vehiculo_uID($id_usuario_vehiculo) {
        if(ENVIRONMENT == 'production'):
            $this->_db_crm->select('id');
            $this->_db_crm->where('id_usuario_vehiculo', $id_usuario_vehiculo);
            $query = $this->_db_crm->get('ve111_vehiculos');
            return $query->row(0)->id;
        endif;
    }

    /**
     * Da el uID según el id usuario
     * @param int $id_usuario
     * @return string uID
     */
    private function dar_uID($id_usuario) {
        if(ENVIRONMENT == 'production'):
            $this->_db_crm->select('id_c');
            $this->_db_crm->where('laspartes_id_usuario_c', $id_usuario);
            $query = $this->_db_crm->get('contacts_cstm');
            return $query->row(0)->id_c;
        endif;
    }

    /**
     * Da el uID según el id usuario vía REST
     * @param int $id_usuario
     * @return string uID
     */
    public function dar_uID_REST($id_usuario) {
        if(ENVIRONMENT == 'production'):
            $user_id = $this->session_id;
       

            //get list of records --------------------------------
           
            $get_entry_list_parameters = array(

                 //session id
                 'session' => $user_id,

                 //The name of the module from which to retrieve records
                 'module_name' => 'Contacts',

                 //The SQL WHERE clause without the word "where".
                 'query' => "laspartes_id_usuario_c = ".$id_usuario,

                 //The SQL ORDER BY clause without the phrase "order by".
                 'order_by' => "",

                 //The record offset from which to start.
                 'offset' => '0',

                 //Optional. A list of fields to include in the results.
                 'select_fields' => array(
                      'id',
                 ),

                 //The maximum number of results to return.
                 'max_results' => '1',
            );

            $get_entry_list_result = $this->call('get_entry_list', $get_entry_list_parameters, $this->url);

            $entry_list = $get_entry_list_result->entry_list;

            return $entry_list[0]->id;
        endif;
    }

    /**
     * Da los uID según los id usuario vía REST
     * @param int $id_usuario
     * @return string uID
     */
    private function dar_uIDs_REST($id_usuarios) {
        if(ENVIRONMENT == 'production'):
            $user_id = $this->session_id;

            $query  = '';
            foreach ($id_usuarios as $id_usuario) {
                $query .= " laspartes_id_usuario_c = ".$id_usuario.'  ||';
            }
            $query = substr($query, 0, -2);
       

            //get list of records --------------------------------
           
            $get_entry_list_parameters = array(

                 //session id
                 'session' => $user_id,

                 //The name of the module from which to retrieve records
                 'module_name' => 'Contacts',

                 //The SQL WHERE clause without the word "where".
                 'query' => $query,

                 //The SQL ORDER BY clause without the phrase "order by".
                 'order_by' => "",

                 //The record offset from which to start.
                 'offset' => '0',

                 'link_name_to_fields_array' => array(),

                 //Optional. A list of fields to include in the results.
                 'select_fields' => array(
                      'id', 'laspartes_id_usuario_c',
                 )
                 ,'max_results' => '100000',
                 'deleted' => '0',
                 'Favorites' => false,

            );

            $get_entry_list_result = $this->call('get_entry_list', $get_entry_list_parameters, $this->url);
            echo "<pre>";

            print_r(sizeof($id_usuarios));
            echo "</pre>";
            $entry_list = $get_entry_list_result->entry_list;

            return $entry_list;
        endif;
    }

    /**
     * Actualiza el correo de un usuario según su uID
     * @param string $uID
     * @param email $correo
     */
    private function actualizar_correo_usuario($uID, $correo) {
        if(ENVIRONMENT == 'production'):
            $this->_db_crm->select('email_address_id');
            $this->_db_crm->where('bean_id', $uID);
            $q = $this->_db_crm->get('email_addr_bean_rel');
            $email_addrs_uID = $q->row(0)->email_address_id;

            $this->_db_crm->where('id', $email_addrs_uID);
            $this->_db_crm->set('email_address', $correo);
            $this->_db_crm->set('email_address_caps', strtoupper($correo));
            $this->_db_crm->update('email_addresses');
        endif;
    }

    /**
     * Agrega un vehículo vía REST
     * @param int $params[id_usuario] id del usuario registrado en laspartes
     * @param string $params[marca] marca del carro
     * @param string $params[linea] linea del carro
     * @param int $params[modelo] modelo del carro
     * @param int $params[kilometraje] kilometraje del carro
     * @param string $params[placa] placa del carro
     * @param string $params[id_usuario_vehiculo] id del carro
     */
    function agregar_vehiculo_REST($params) {
        if(ENVIRONMENT == 'production'):
            $name_value_list = array();

            array_push($name_value_list, array("name" => "estadoHook", "value" => true));
            $nombreCarro = $params['marca'].' '.$params['linea'];
            array_push($name_value_list, array("name" => "ve111_marcalinea_ve111_vehiculos_name", "value" => $nombreCarro));
            $uID_usuario = $this->dar_uID_REST($params['id_usuario']);//retorna el uID del usuario al que se le va a agregar el vehículo
            array_push($name_value_list, array("name" => 've111_vehiculos_contactscontacts_ida', "value" => $uID_usuario)); 
            $uID_vehiculo = $this->dar_marcalinea_uID_REST($params['id_vehiculo']);//retorna el uID del vehiculo que se va a agregar
            array_push($name_value_list, array("name" => 've111_marcalinea_ve111_vehiculosve111_marcalinea_ida', "value" => $uID_vehiculo));
            
            foreach($params as $key => $value) {
                if($key != 'id_usuario' && $key != 'marca' && $key != 'linea' && $key != 'id_vehiculo')
                   array_push($name_value_list, array("name" => $key, "value" => $value));
            }
            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "ve111_vehiculos",

                 //Record attributes
                 "name_value_list" => $name_value_list,
            );
            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $this->url);
        endif;
    }

    /**
     * Agrega un vehículo vía REST
     * @param int $params[id_usuario] id del usuario registrado en laspartes
     * @param string $params[marca] marca del carro
     * @param string $params[linea] linea del carro
     * @param int $params[modelo] modelo del carro
     * @param int $params[kilometraje] kilometraje del carro
     * @param string $params[placa] placa del carro
     * @param string $params[id_usuario_vehiculo] id del carro
     */
    function agregar_vehiculos_REST($params) {
        if(ENVIRONMENT == 'production'):
            $name_values_list = array();
            $marcalineas = array();
            $contactos = array();
            foreach ($params as $array) {
                $name_value_list = array();
                array_push($name_value_list, array("name" => "estadoHook", "value" => true));
                $nombreCarro = $array['marca'].' '.$array['linea'];
                array_push($name_value_list, array("name" => "ve111_marcalinea_ve111_vehiculos_name", "value" => $nombreCarro));
                $marcalineas[] = $array['id_vehiculo'];
                $contactos[] = $array['id_usuario'];
                // $uID_usuario = $this->dar_uID_REST($array['id_usuario']);//retorna el uID del usuario al que se le va a agregar el vehículo
                // array_push($name_value_list, array("name" => 've111_vehiculos_contactscontacts_ida', "value" => $uID_usuario)); 
                // $uID_vehiculo = $this->dar_marcalinea_uID_REST($array['id_vehiculo']);//retorna el uID del vehiculo que se va a agregar
                // array_push($name_value_list, array("name" => 've111_marcalinea_ve111_vehiculosve111_marcalinea_ida', "value" => $uID_vehiculo));
                foreach($array as $key => $value) {
                    if($key != 'id_usuario' && $key != 'marca' && $key != 'linea' && $key != 'id_vehiculo')
                    array_push($name_value_list, array("name" => $key, "value" => $value));
                }
                array_push($name_values_list, $name_value_list);
            }

            // echo "<pre>";

            // print_r($marcalineas);
            // echo "</pre>";
            $ids_usuarios = $this->dar_uIDs_REST($contactos);
            $ids_marcalineas = $this->dar_marcalinea_uIDs_REST($marcalineas);

            echo sizeof($name_values_list).'<br/>';
            echo sizeof($ids_usuarios).'<br/>';
            echo sizeof($ids_marcalineas).'<br/>';

            // echo "<pre>";

            // print_r($ids_marcalineas);
            // echo "</pre>";

            for ($i=0; $i < sizeof($name_values_list); $i++) { 
                $name_values_list[$i][] = array('name' => 've111_vehiculos_contactscontacts_ida', 'value'=>$ids_usuarios[$i]->id);
                $name_values_list[$i][] = array('name' => 've111_marcalinea_ve111_vehiculosve111_marcalinea_ida', 'value'=>$ids_marcalineas[$i]->id);
            }

            // echo "<pre>";

            // print_r($name_values_list);
            // echo "</pre>";

            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "ve111_vehiculos",

                 //Record attributes
                 "name_value_list" => $name_values_list,
            );
            // $set_entries_result = $this->call("set_entries", $set_entry_parameters, $this->url);
        endif;
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
        if(ENVIRONMENT == 'production'):
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
        endif;
    }

    /**
     * Asocia un vehículo con un usuaro
     * @param string $uID_vehiculo
     * @param string $uID_marcalinea
     */
    private function agregar_marcalinea_vehiculo($uID_vehiculo, $uID_marcalinea) {
        if(ENVIRONMENT == 'production'):
            $uID = $this->create_guid();
            $this->_db_crm->set('id', $uID);
            $this->_db_crm->set('ve111_marcalinea_ve111_vehiculosve111_marcalinea_ida', $uID_marcalinea);
            $this->_db_crm->set('ve111_marcalinea_ve111_vehiculosve111_vehiculos_idb', $uID_vehiculo);
            $this->_db_crm->insert('ve111_marcalinea_ve111_vehiculos_c');
        endif;
    }

    /**
     * Da el uID del vehículo
     * @param type $id_vehiculo
     * @return int id
     */
    private function dar_marcalinea_uID($id_vehiculo) {
        if(ENVIRONMENT == 'production'):
            $this->_db_crm->select('id');
            $this->_db_crm->where('id_vehiculo', $id_vehiculo);
            $q = $this->_db_crm->get('ve111_marcalinea');
            return $q->row(0)->id;
        endif;
    }

    /**
     * Da el uID del vehículo
     * @param type $id_vehiculo
     * @return int id
     */
    private function dar_marcalinea_uID_REST($id_vehiculo) {
        if(ENVIRONMENT == 'production'):

            $user_id = $this->session_id;
            //get list of records --------------------------------
       
            $get_entry_list_parameters = array(

                 //session id
                 'session' => $user_id,

                 //The name of the module from which to retrieve records
                 'module_name' => 've111_MarcaLinea',

                 //The SQL WHERE clause without the word "where".
                 'query' => "id_vehiculo = ".$id_vehiculo ,

                 //The SQL ORDER BY clause without the phrase "order by".
                 'order_by' => "",

                 //The record offset from which to start.
                 'offset' => '0',

                 //Optional. A list of fields to include in the results.
                 'select_fields' => array(
                      '*',
                 ),

                 //The maximum number of results to return.
                 'max_results' => '1',
            );

            $get_entry_list_result = $this->call('get_entry_list', $get_entry_list_parameters, $this->url);


            $entry_list = $get_entry_list_result->entry_list;

            return $entry_list[0]->id;
        endif;
    }

    /**
     * Da los uIDs del vehículos
     * @param  string $id_vehiculos
     * @return array uids
     */
    private function dar_marcalinea_uIDs_REST($id_vehiculos) {
        if(ENVIRONMENT == 'production'):

            $user_id = $this->session_id;
            $query  = '';
            foreach ($id_vehiculos as $id_vehiculo) {
                $query .= " id_vehiculo = ".$id_vehiculo.'  ||';
            }
            $query = substr($query, 0, -2);
            //get list of records --------------------------------
       
            $get_entry_list_parameters = array(

                 //session id
                 'session' => $user_id,

                 //The name of the module from which to retrieve records
                 'module_name' => 've111_MarcaLinea',

                 //The SQL WHERE clause without the word "where".
                 'query' => $query ,

                 //The SQL ORDER BY clause without the phrase "order by".
                 'order_by' => "",

                 //The record offset from which to start.
                 'offset' => '0',

                 'link_name_to_fields_array' => array(),

                 //Optional. A list of fields to include in the results.
                 'select_fields' => array(
                      'id',
                 )
                 ,'max_results' => '100000',
                 'deleted' => '0',
                 'Favorites' => false,
            );

            $get_entry_list_result = $this->call('get_entry_list', $get_entry_list_parameters, $this->url);


            $entry_list = $get_entry_list_result->entry_list;

            return $entry_list;
        endif;
    }

    /**
     * Asocia un vehículo con un usuaro
     * @param string $uID_usuario
     * @param string $uID_vehiculo
     */
    private function agregar_vehiculo_usuario($uID_usuario, $uID_vehiculo) {
        if(ENVIRONMENT == 'production'):
            $uID = $this->create_guid();
            $this->_db_crm->set('id', $uID);
            $this->_db_crm->set('ve111_vehiculos_contactsve111_vehiculos_idb', $uID_vehiculo);
            $this->_db_crm->set('ve111_vehiculos_contactscontacts_ida', $uID_usuario);
            $this->_db_crm->insert('ve111_vehiculos_contacts_c');
        endif;
    }

    /**
     * Agrega la marca y línea de vehículo
     * @param int $id_vehiculo
     * @param string $marca
     * @param string $linea
     */
    function agregar_marcalinea($id_vehiculo, $marca, $linea) {
        if(ENVIRONMENT == 'production'):
            $this->_db_crm = $this->_CI->load->database('CRM', TRUE);

            $uID = $this->create_guid();
            $this->_db_crm->set('id', $uID);
            $this->_db_crm->set('name', $marca . ' ' . $linea);
            $this->_db_crm->set('id_vehiculo', $id_vehiculo);
            $this->_db_crm->set('marca', $marca);
            $this->_db_crm->set('linea', $linea);
            $this->_db_crm->insert('ve111_marcalinea');

            $this->_CI->load->database('default', TRUE);
        endif;
    }

    /**
     * Agrega la marca y línea de vehículo
     * @param int $id_vehiculo
     * @param string $marca
     * @param string $linea
     */
    function agregar_marcalineas_REST($params) {
        if(ENVIRONMENT == 'production'):
            $name_values_list = array();

            foreach ($params as $array) {
                $name_value_list = array();
                array_push($name_value_list, array("name" => "estadoHook", "value" => true));
                foreach($array as $key => $value) {
                       array_push($name_value_list, array("name" => $key, "value" => $value));
                }
                array_push($name_values_list, $name_value_list);
            }

            echo "<pre>";

            print_r($name_values_list);
            echo "</pre>";

            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "ve111_MarcaLinea",

                 //Record attributes
                 "name_value_list" => $name_values_list,
            );
            $set_entry_result = $this->call("set_entries", $set_entry_parameters, $this->url);
        endif;
    }

    /**
     * Agrega la marca y línea de vehículo
     * @param int $id_vehiculo
     * @param string $marca
     * @param string $linea
     */
    function agregar_marcalinea_REST($id_vehiculo, $marca, $linea) {
        if(ENVIRONMENT == 'production'):
            $name_value_list = array();

            array_push($name_value_list, array("name" => "estadoHook", "value" => true));
            $nombreCarro = $marca . ' ' . $linea;
            array_push($name_value_list, array("name" => "id", "value" => $id_vehiculo));
            array_push($name_value_list, array("name" => "name", "value" => $nombreCarro));
            array_push($name_value_list, array("name" => 'id_vehiculo', "value" => $id_vehiculo));
            array_push($name_value_list, array("name" => 'marca', "value" => $marca)); 
            array_push($name_value_list, array("name" => 'linea', "value" => $linea));

            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "ve111_MarcaLinea",

                 //Record attributes
                 "name_value_list" => $name_value_list,
            );
            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $this->url);
        endif;
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
        if(ENVIRONMENT == 'production'):
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
        endif;
    }

    /**
     * Actualiza la relación de marcalinea y vehiculo
     * @param string $uID_vehiculo
     * @param string $uID_marcalinea
     */
    private function actualizar_marcalinea_vehiculo($uID_vehiculo, $uID_marcalinea) {
        if(ENVIRONMENT == 'production'):
            $this->_db_crm->set('ve111_marcalinea_ve111_vehiculosve111_marcalinea_ida', $uID_marcalinea);
            $this->_db_crm->where('ve111_marcalinea_ve111_vehiculosve111_vehiculos_idb', $uID_vehiculo);
            $this->_db_crm->update('ve111_marcalinea_ve111_vehiculos_c');
        endif;
    }

    /**
     * Agrega compras al CRM vía REST
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
    public function agregar_carrito_compras_REST($params){
        if(ENVIRONMENT == 'production'):
            $name_value_list = array();
            $uID_usuario = $this->dar_uID_REST($params['id_usuario']);
            array_push($name_value_list, array("name" => 'venta_compra_contactscontacts_ida', "value" => $uID_usuario)); 
            array_push($name_value_list, array("name" => "estadoHook", "value" => true));
            foreach($params as $key => $value) {
                   array_push($name_value_list, array("name" => $key, "value" => $value));
            }
            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "venta_Compra",

                 //Record attributes
                 "name_value_list" => $name_value_list,
            );
            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $this->url);
            $this->agregar_llamada_venta_REST($params);
        endif;
    }

    /**
     * Agrega una llamada por motivo de venta vía REST
     * Agrega compras al CRM vía REST
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
    public function agregar_llamada_venta_REST($params){
        if(ENVIRONMENT == 'production'):
            $name_value_list = array();
            array_push($name_value_list, array("name" => "estadoHook", "value" => true));
            array_push($name_value_list, array("name" => "name", "value" => 'Llamada postventa'));
            array_push($name_value_list, array("name" => "direction", "value" => 'Outbound'));
            array_push($name_value_list, array("name" => "status", "value" => 'Planned'));
            array_push($name_value_list, array("name" => "date_start", "value" => date("Y-m-d H:i:s", mktime(22, 0, 0, date("m")  , date("d")+8, date("Y")))));
            array_push($name_value_list, array("name" => "duration_hours", "value" => '0'));
            array_push($name_value_list, array("name" => "duration_minutes", "value" => '15'));
            array_push($name_value_list, array("name" => "reminder_checked", "value" => '1'));
            array_push($name_value_list, array("name" => "reminder_time", "value" => '300'));
            array_push($name_value_list, array("name" => "email_reminder_checked", "value" => '1'));
            array_push($name_value_list, array("name" => "email_reminder_time", "value" => '300'));
            array_push($name_value_list, array("name" => "description", "value" => 'Llamar a '.$params['usuario']->nombres.' para preguntar cómo le fue en el taller por haber realizado la compra de '.$params['name']. '. ver recibo adjunto en: '.$params['recibo']));
            array_push($name_value_list, array("name" => "assigned_user_name", "value" => 'Alexander Guerra'));
            array_push($name_value_list, array("name" => "assigned_user_id", "value" => 'ea5a2345-453d-fe9d-161f-5176e26e52f2'));

            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "Calls",

                 //Record attributes
                 "name_value_list" => $name_value_list,
            );
            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $this->url);
        endif;
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
        if(ENVIRONMENT == 'production'):
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
        endif;
    }

    /**
     * Asocia una compra con un usuaro
     * @param string $uID_usuario
     * @param string $uID_compra
     */
    private function agregar_carrito_compras_usuario($uID_usuario, $uID_compra) {
        if(ENVIRONMENT == 'production'):
            $uID = $this->create_guid();
            $this->_db_crm->set('id', $uID);
            $this->_db_crm->set('venta_compra_contactsventa_compra_idb', $uID_compra);
            $this->_db_crm->set('venta_compra_contactscontacts_ida', $uID_usuario);
            $this->_db_crm->insert('venta_compra_contacts_c');
        endif;
    }

    /**
     * Agrega una remision
     * @param int $params[id_usuario] id del usuario registrado en laspartes que ha comprado
     * @param int $params[id_vehiculo] id del vehiculo
     * @param string $params[name] nombre de la remision el caul es el mismo del consecutivo
     * @param string $params[first_name] nombre de la persona que va a hacer la remisión
     * @param string $params[primary_address_city] ciudad de donde se hace la remisión
     * @param string $params[primary_address_street] dirección de envió o donde reside la persona
     * @param int $params[phone_home] número telefónico de la persona de la remisión
     * @param string $params[description] Descripción de la remision
     * @param int $params[consecutivo] consecutivo de la remisión
     * @param string $params[remisionurl] url donde se encuentra la remisión en pdf
     */
    public function agregar_remision_REST($params){
        if(ENVIRONMENT == 'production'):
            $name_value_list = array();
            $uID_usuario = $this->dar_uID_REST($params['id_usuario']);
            array_push($name_value_list, array("name" => "venta_remision_contactscontacts_ida", "value" => $uID_usuario));
            $uID_marcalinea = $this->dar_marcalinea_uID_REST($params['id_vehiculo']);
            array_push($name_value_list, array("name" => "venta_remision_ve111_marcalineave111_marcalinea_idb", "value" => $uID_marcalinea));

            array_push($name_value_list, array("name" => "estadoHook", "value" => true));
            foreach($params as $key => $value) {
                if($key != 'id_vehiculo' || $key != 'id_usuario')
                   array_push($name_value_list, array("name" => $key, "value" => $value));
            }
            $user_id = $this->session_id;
            $set_entry_parameters = array(
                 //session id
                 "session" => $user_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "venta_Remision",

                 //Record attributes
                 "name_value_list" => $name_value_list,
            );
            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $this->url);
        endif;
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
        if(ENVIRONMENT == 'production'):
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
        endif;
    }

    public function create_guid_section($characters) {
        if(ENVIRONMENT == 'production'):
            $return = "";
            for ($i = 0; $i < $characters; $i++) {
                $return .= dechex(mt_rand(0, 15));
            }
            return $return;
        endif;
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
        if(ENVIRONMENT == 'production'):
            // $this->_db_crm = $this->_CI->load->database('CRM', TRUE);
            $arrayParams = array();
            foreach ($params as $usuario) {
                $temp = array();
                $temp['laspartes_id_usuario_c'] = $usuario->id_usuario;
                $temp['first_name'] = $usuario->nombres;
                $temp['last_name'] = $usuario->apellidos;
                $temp['email1'] = $usuario->email;
                $temp['primary_address_city'] = $usuario->lugar;
                $temp['primary_address_country'] = $usuario->pais;
                $temp['phone_home'] = $usuario->telefonos;
                array_push($arrayParams, $temp);
                // echo 'usuario '.$usuario->id_usuario.': '.$usuario->nombres.' '. $usuario->apellidos.' email: '.$usuario->email.' Ciudad: '.$usuario->lugar.' Pais: '.$usuario->pais.' telefono: '.$usuario->telefonos.'<br/>';
            }
            $this->agregar_usuarios_REST($arrayParams);
            // $this->_CI->load->database('default', TRUE);
         endif;
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
        if(ENVIRONMENT == 'production'):
            $this->_db_crm = $this->_CI->load->database('CRM', TRUE);
            $arrayParams = array();
            foreach ($params as $vehiculo) {
                $temp = array();
                $temp['id_usuario_vehiculo'] = $vehiculo->id_usuario_vehiculo;
                $temp['id_vehiculo'] = $vehiculo->id_vehiculo;
                $temp['id_usuario'] = $vehiculo->id_usuario;
                $temp['modelo'] = $vehiculo->modelo;
                $temp['kilometraje'] = $vehiculo->kilometraje;
                $temp['marca'] = $vehiculo->marca;
                $temp['linea'] = $vehiculo->linea;
                $temp['placa'] = $vehiculo->numero_placa;
                // array_push($arrayParams, $temp);
                $this->agregar_vehiculo($temp);
            }
            // echo "<pre>";
            // print_r($arrayParams);
            // echo "</pre>";

            // $this->agregar_vehiculos_REST($arrayParams);
            $this->_CI->load->database('default', TRUE);
        endif;
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
        if(ENVIRONMENT == 'production'):
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
                echo '';
            }
            $this->_CI->load->database('default', TRUE);
        endif;
    }

    /**
     * Migra todos los vehiculos a la DBCRM de marcalinea
     * @param type $params
     */
    public function migrar_marcalinea($params) {
        if(ENVIRONMENT == 'production'):
            $arrayParams = array();
            foreach ($params as $vehiculo) {
                $temp = array();
                $temp['id_vehiculo'] = $vehiculo->id_vehiculo;
                $temp['name'] = $vehiculo->marca. ' '.$vehiculo->linea;
                $temp['marca'] = $vehiculo->marca;
                $temp['linea'] = $vehiculo->linea;
                array_push($arrayParams, $temp);
            }
            $this->agregar_marcalineas_REST($arrayParams);
        endif;
    }

    /* fin de Metodos de popular la DB */

    //function to make cURL request
    private function call($method, $parameters, $url)
    {
        if(ENVIRONMENT == 'production'):
            ob_start();
            $curl_request = curl_init();

            curl_setopt($curl_request, CURLOPT_URL, $url);
            curl_setopt($curl_request, CURLOPT_POST, 1);
            curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            curl_setopt($curl_request, CURLOPT_HEADER, 1);
            curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);

            $jsonEncodedData = json_encode($parameters);

            $post = array(
                 "method" => $method,
                 "input_type" => "JSON",
                 "response_type" => "JSON",
                 "rest_data" => $jsonEncodedData
            );

            curl_setopt($curl_request, CURLOPT_POSTFIELDS, $post);
            $result = curl_exec($curl_request);
            curl_close($curl_request);

            $result = explode("\r\n\r\n", $result, 2);
            $response = json_decode($result[1]);
            ob_end_flush();

            return $response;
        endif;
    }

}

/* End of file crm.php */

