<?php

    /**
     *Clase que modela los numeros de referencia de facturas, asociados al carrito de compras del usuario. Modela la tabla en la DB de refVenta. 
     */
class RefVenta_model extends CI_Model{
        
     /**
     * Constructor de la clase RefVenta_model
     */
    function __construct(){
        parent::__construct();
    }
    
    /**
     *Le asigna el número de referencia de Pagos online al registro de refVenta
     * @param string $refVenta
     * @param int $refPol 
     */
    function actualizar_referencia_ventaPOL($refVenta, $refPol){
        $this->db->escape($refVenta);
        $this->db->escape($refPol);
        $this->db->set('refPOL', $refPol);
        $this->db->where('refVenta', $refVenta);
        $this->db->update('carritos_refVentas');
    }
    
    /**
     *Retorna una referencia de venta según su código de refVenta
     * @param string $refVenta
     * @return refVenta 
     */
    function dar_Venta($refVenta){
        $this->db->escape($refVenta);
        $this->db->select('carritos_refVentas.refVenta AS referencia, carritos_compras.total AS total, carritos_compras.nombres as nombre_apellido, carritos_compras.email, carritos_compras.direccion, carritos_compras.telefono, carritos_compras.ciudad, 
            carritos_compras.fecha, carritos_compras.fecha_pago, carritos_compras.id_carrito_compra, usuarios.usuario, carritos_compras.documento, carritos_compras.carro, carritos_compras.placa, carritos_compras.observaciones');
        $this->db->from('carritos_refVentas');
        $this->db->join('carritos_compras', 'carritos_refVentas.id_carritos_compras = carritos_compras.id_carrito_compra');
        $this->db->join('usuarios', 'carritos_compras.id_usuario = usuarios.id_usuario');
        $this->db->where('refVenta', $refVenta);
        $query = $this->db->get();
        return $query->row(0);
    }
    
    /**
     *Retorna una referencia de venta según su código de refVenta
     * @param string $refVenta
     * @return refVenta 
     */
    function dar_Venta_oferta($refVenta){
        $this->db->escape($refVenta);
        $this->db->select('carritos_compras_ofertas.ref_venta AS referencia, carritos_compras_ofertas.id_oferta as id_oferta, carritos_compras.total AS total, carritos_compras.fecha as fecha, carritos_compras.id_carrito_compra, usuarios.*');
        $this->db->from('carritos_compras_ofertas');
        $this->db->join('carritos_compras', 'carritos_compras_ofertas.id_carrito_compra = carritos_compras.id_carrito_compra');
        $this->db->join('usuarios', 'carritos_compras.id_usuario = usuarios.id_usuario');
        $this->db->where('ref_venta', $refVenta);
        $query = $this->db->get();
        return $query->row(0);
    }
    /**
     *Agrega un nuevo registro a la tabla de carritos_reVentas
     * @param type $refVenta
     * @param type $id_carrito 
     */
    function agregar_RefVenta($refVenta, $id_carrito){
        $this->db->escape($refVenta);
        $this->db->escape($id_carrito);
        $this->db->set('refVenta', $refVenta);
        $this->db->set('id_carritos_compras', $id_carrito);
        $this->db->insert('carritos_refVentas');
    }
    
    /**
     *Genera un número único de referencia de venta en la DB
     * @return string referencia de venta
     */
    function generar_RefVenta_Unico() { 
        $key = $this->getUniqueCode(10);
        $result = false;
        $value = "-1";
        while (!$result) {
                $this->db->where('refVenta', $key);
                $this->db->from('carritos_refVentas');
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
     *Función que genera un valor alfanumérico para el valor de la referencia de la factura
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
?>
