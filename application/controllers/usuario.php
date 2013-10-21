<?php

require_once 'laspartes_controller.php';

/**
 * Clase que maneja los usuarios
 */
class Usuario extends Laspartes_Controller {

    /**
     * Constructor de la clase Usuario
     */
    function __construct() {
        parent::__construct();
        setlocale(LC_ALL, 'es_ES');
        $this->load->model('fb_model');
    }

   // function mifactura(){
   //     $this->_generar_factura('8b644258cb', 'email');
   // }
    /**
     * Genera la factura de la compra en formato PDF
     * @param string $refVenta 
     */
    function _generar_factura($refVenta, $estado = "", $mensaje = "") { 


        if ($estado == "email") {
            setlocale(LC_ALL, 'es_ES');
            define("CHARSET", "iso-8859-1");
            $this->load->library('phptopdf');
            $this->load->model('refventa_model');
            $this->load->model('usuario_model');
            $this->load->helper('mail');
            $destinatarios = array();
            $venta = $this->refventa_model->dar_venta($refVenta);
            $autopartes = $this->usuario_model->dar_carrito_compra_autopartes($venta->id_carrito_compra);
            $ofertas = $this->usuario_model->dar_carrito_compra_ofertas($venta->id_carrito_compra);
            $consecutivo = $this->usuario_model->agregar_consecutivo_compra($venta->id_carrito_compra);
            $valorSum = 0;
            $ivaSum = 0;

            $data1['mensaje'] = $mensaje;
            $data1['venta'] = $venta;
            $data1['autopartes'] = $autopartes;
            $data1['ofertas'] = $ofertas;
            $data1['consecutivo'] = $consecutivo;
            
            $html = $this->load->view('factura/factura_pdf_view', $data1, true);

            $destinatario = new stdClass();
            $destinatario->email = $venta->email;
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = "tallerenlinea@laspartes.com.co";
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = "ventas@laspartes.com.co";
            $destinatarios[] = $destinatario;
            
            ob_start();
            
            
            $this->load->view('emails/recibo_compra_view', $data1);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();
            
            $filePath = 'resources/facturas/';
            $fileName = 'factura-' . $refVenta . '.pdf';
            $this->phptopdf->phptopdf_html($html, $filePath, $fileName);
            send_mail($destinatarios, "Factura de compra LasPartes.com - " . strftime("%B %d de %Y"), $contenidoHTML, "", $fileName);

            //METODOS DE DROPBOX
            if(ENVIRONMENT == 'production'){
                $this->load->model('usuarios_dropbox_model');
                $usuarios_dropbox_model = new usuarios_dropbox_model();
                $usuarios_dropbox_model->dar_por_filtros(array('id_usuario' => '54'));
                $respuestaRequest = $this->request_dropbox($usuarios_dropbox_model->oauth_token, $usuarios_dropbox_model->oauth_token_secret);
                $DropboxPath = '/CARPETA MAESTRA/FACTURAS LP/'.date('Y').'/';
                $metadata = $this->dropbox->metadata($DropboxPath);
                if(!$metadata->is_dir)
                    $this->dropbox->create_folder($DropboxPath);
                $addResponse = $this->dropbox->add($DropboxPath, $filePath.$fileName);
            }
        } else if ($estado == "error") {
            $destinatarios = array();
            $destinatario = new stdClass();
            $destinatario->email = "tallerenlinea@laspartes.com.co";
            $destinatarios[] = $destinatario;
            send_mail($destinatarios, "Error en la compra LasPartes.com - " . strftime("%B %d de %Y"), "", $mensaje);
        }
    }

    /**
     * nuestra el recibo
     * @param  [type] $refVenta [description]
     * @return [type]           [description]
     */
    function recibo($refVenta) {
        if ($this->hay_sesion_activa()) {
            $filePath = 'resources/facturas';
            $fileName = 'recibo-' . $refVenta . '.pdf';
            $enlace = $filePath . '/' . $fileName;
            header("Content-Disposition: inline; filename=" . $fileName . "\n\n");
            header("Content-Type: application/pdf");
            header("Content-Length: " . filesize($enlace));
            readfile($enlace);
        } else {
            redirect('usuario');
        }
    }

    /**
     * Código que genera QR con el API de Google
     * @param type $url
     * @param type $widthHeight
     * @param type $EC_level
     * @param type $margin
     * @return imagen con el codigo QR 
     */
    function _generateQRwithGoogle($url, $widthHeight = '400', $EC_level = 'L', $margin = '0') {
        $url = urlencode($url);
        return '<img src="http://chart.apis.google.com/chart?chs=' . $widthHeight .
                'x' . $widthHeight . '&cht=qr&chld=' . $EC_level . '|' . $margin .
                '&chl=' . $url . '" alt="QR code" widthHeight="' . $widthHeight .
                '" widthHeight="' . $widthHeight . '"/>';
    }

    /**
     * Da la información de un vehículo
     * @param int $id_usuario_vehiculo
     * @return array con $vehiculo, $marcas y $linea
     */
    function _formulario_modificar_vehiculo($id_usuario_vehiculo) {
        $this->load->model('usuario_model');
        $this->load->model('vehiculo_model');
        $data['vehiculo'] = $this->usuario_model->dar_usuario_vehiculo($id_usuario_vehiculo);
        $data['marcas'] = $this->usuario_model->dar_vehiculos_marcas();
        $data['lineas'] = $this->usuario_model->dar_vehiculos_lineas($data['vehiculo']->marca);
        return $data;
    }

    /**
     * Página que muestra el formulario de ingreso o registro
     * @param String $dataP (errores)
     */
    function _login($dataP) {
        if ($this->hay_sesion_activa()) {
            $this->_mi_cuenta('vehiculos');
        } else {
            $this->load->helper('date');
            $data = $dataP;
            $this->load->model('autoparte_model');
            $this->load->model('establecimiento_model');
            $this->load->model('usuario_model');
            $this->load->model('vehiculo_model');
            $this->load->helper('captcha');
            $data['fb_data'] = $this->session->userdata('fb_data');
            $config = array(
                'img_path' => 'resources/images/captcha/',
                'img_url' => base_url() . 'resources/images/captcha/'
            );
            $data['titulo'] = 'Laspartes.com.co :: Todo para su vehículo :: Inicio de Sesión y Registro de Usuarios';
            $data['captcha'] = create_captcha($config);

            $ciudades = $this->usuario_model->dar_kilometraje_ciudades();
            $marcas = $this->usuario_model->dar_vehiculos_marcas();

            $data['ciudades'] = $ciudades;
            $data['marcas'] = $marcas;
            $this->usuario_model->agregar_captcha(round($data['captcha']['time']), $this->input->ip_address(), $data['captcha']['word']);

            $data['allmarcas'] = $this->vehiculo_model->dar_vehiculos_marca();
            $index = 0;
            foreach ($data['allmarcas'] as $marca) {
                $data['allmarcas'][$index]->label = $marca->marca;
                $data['allmarcas'][$index]->value = $marca->marca;
                $index++;
            }

            $data['header_view'] = 'login/header/formulario_view';
            $data['navegacion_view'] = 'micuenta';
            $data['contenido_view'] = 'login/formulario_view';
            //$data['hide_search'] = true;
            $data['show_login'] = true;
            $this->load->view('template/template', $data);
        }
    }

    function generar_firmaPol_ajax() {
        $this->load->model('refventa_model');
        $this->load->model('generico_model');
        $refVenta = 0;
        $id_oferta = $this->input->get_post('id_oferta', TRUE);
        $oferta = $this->generico_model->dar_tildes('oferta', 'id_oferta', $id_oferta);
        $valor = $oferta->precio;
        $descripcion = $this->fix_caracteres($oferta->titulo);
        $iva = $oferta->iva;
        $baseDevolucionIva = $valor - $iva;
        $refVenta = $this->refventa_model->generar_RefVenta_Unico();
        $llave_encripcion = "13733cb5a73";
        $usuarioId = 84442;
        $moneda = "COP";
        $firma_cadena = "$llave_encripcion~$usuarioId~$refVenta~$valor~$moneda"; //concatenación para realizar la firma
        $firma = md5($firma_cadena);

        $data = '{"valor":"' . $valor . '","iva":"' . $iva . '","baseDevolucionIva":"' . $baseDevolucionIva . '","refVenta":"' . $refVenta . '","firma":"' . $firma . '","usuarioId":"' . $usuarioId . '","descripcion":"' . $descripcion . '"}';

        //------------------------------------------guarda el registro de compra no pago en la DB-------------------------------------------------------------------
        $this->load->helper('date');
        $idUsuario = $this->session->userdata('id_usuario');
        $set_id_usuario[] = 'id_usuario';
        $set_id_usuario[] = $idUsuario;
        $set[] = $set_id_usuario;
        $set_fecha[] = 'fecha';
        $set_fecha[] = mdate('%Y-%m-%d');
        $set[] = $set_fecha;
        $set_estado[] = 'estado';
        $set_estado[] = 'No pago';
        $set[] = $set_estado;
        $set_total[] = 'total';
        $set_total[] = $valor;
        $set[] = $set_total;
        $id_carrito = $this->generico_model->agreagar_registros_genericos('carritos_compras', $set);

        $set_id_carrito[] = 'id_carrito_compra';
        $set_id_carrito[] = $id_carrito;
        $set1[] = $set_id_carrito;
        $set_id_oferta[] = 'id_oferta';
        $set_id_oferta[] = $id_oferta;
        $set1[] = $set_id_oferta;
        $set_ref_venta[] = 'ref_venta';
        $set_ref_venta[] = $refVenta;
        $set1[] = $set_ref_venta;
        $this->generico_model->agreagar_registros_genericos('carritos_compras_ofertas', $set1);
        //----------------------------------------------------

        echo $data;
    }

    /**
     * Muestra la información y datos de un usuario
     * @param String $tab por a mostrar
     */
    function _mi_cuenta($tab, $confirmacion = '') {
        $tipo_usuario = $this->session->userdata('tipo');
        if($tipo_usuario != 40){
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->helper('date');
            $this->load->model('usuario_model');
            $this->load->model('generico_model');
            $this->load->model('pregunta_model');
            $this->load->model('noticia_model');
            $this->load->model('tip_model');
            $this->load->model('tutorial_model');
            $this->load->model('establecimiento_model');
            $this->load->model('vehiculo_model');
            $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);

            setlocale(LC_ALL, 'es_ES');


            if ($confirmacion != '')
                $data['confirmacion'] = $confirmacion;

            $data['preguntas'] = $this->pregunta_model->dar_preguntas_usuario($id_usuario, 0);
            $data['numPreguntas'] = $this->pregunta_model->dar_num_preguntas_usuario($id_usuario);
            $data['respuestas'] = $this->pregunta_model->dar_preguntas_he_respondido($id_usuario, 0);
            $data['numRespuestas'] = $this->pregunta_model->dar_num_preguntas_he_respondido($id_usuario);
            $data['establecimientos'] = $this->establecimiento_model->dar_talleres_he_calificado($id_usuario, 0);
            $data['numEstablecimientos'] = $this->establecimiento_model->dar_num_talleres_he_calificado($id_usuario);
            $data['comentarios_noticias'] = $this->noticia_model->dar_noticias_comentarios_usuario($id_usuario);
            $data['comentarios_tips'] = $this->tip_model->dar_tips_comentarios_usuario($id_usuario);
            $data['comentarios_tutoriales'] = $this->tutorial_model->dar_tutoriales_comentarios_usuario($id_usuario);
            $data['carritos_compras'] = $this->usuario_model->dar_carritos_compras_usuario($id_usuario, 0);
            $data['items_compras'] = $this->usuario_model->dar_items_compra_usuario($id_usuario);
            $data['numCarrito'] = $this->usuario_model->dar_num_carritos_compras_usuario($id_usuario);
            $kilometraje_ciudad = $this->usuario_model->dar_kilometraje_ciudad($data['usuario']->lugar);
            $data['kilometraje_ciudad'] = $kilometraje_ciudad;
            $vehiculos = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
            $data['vehiculos'] = $vehiculos;
            $data['numVehiculos'] = sizeof($vehiculos);
            $data['allofertas'] = $this->usuario_model->dar_todas_ofertas($id_usuario, 0);
            $data['numOfertas'] = $this->usuario_model->dar_num_ofertas_vigentes_usuario($id_usuario);
            $tareas = array();
            $tareas_vehiculo = $this->_dar_tareas_vehiculo($vehiculos[0], $kilometraje_ciudad);
            $tareas = $tareas_vehiculo;
            $data['tareas'] = $tareas;

            $data['allvehiculos'] = $this->vehiculo_model->dar_vehiculos();
            $index = 0;
            foreach ($data['allvehiculos'] as $vehiculo) {
                $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
                $data['allvehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
                $index++;
            }


            $data['tab'] = $tab;
            $data['titulo'] = 'Laspartes.com: Taller en línea';
            $data['header_view'] = 'usuario/header/mi_cuenta_view';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="usuario-div-breadcrumb-espaciador"></div> <div>Mis Veh&iacute;culos</div>';
            $data['navegacion_view'] = 'micuenta';
            $data['contenido_view'] = 'usuario/mi_cuenta_view';
            $this->load->view('template/template', $data);
        }else
            $this->_mi_flota();
    }

    /**
     * Muestra la información de la flota de el usuario logueado
     * @return vista vista del usuario flota
     */
    function _mi_flota(){ //phpinfo();
        $id_usuario = $this->session->userdata('id_usuario');
        $this->load->helper('date');
        $this->load->model('usuario_model');
        $this->load->model('flota_model');
        $this->load->model('vehiculo_model');

        $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
        $data['flotas'] = $this->flota_model->dar_flotas_usuario($id_usuario);
        foreach ($data['flotas'] as $flota) {
            $vehiculos = $this->flota_model->dar_vehiculos_flota($flota->id_flota);
            $sort = array();
            foreach ($vehiculos as $key => $vehiculo) {
                $sort[$key] = $this->_dar_notificaciones_flota($vehiculo, '32000');
            }
            arsort($sort, SORT_NUMERIC); 
            $vehiculos_sorted = array();
            foreach ($sort as $key => $value) {
                $vehiculo_temp = $vehiculos[$key];
                $vehiculo_temp->notificacion = $value;
                $vehiculos_sorted[] = $vehiculo_temp;
            }
            
            $data['vehiculos'][$flota->id_flota] = $vehiculos_sorted;
        }

        $data['allmarcas'] = $this->vehiculo_model->dar_vehiculos_marca();
        $index = 0;
        foreach ($data['allmarcas'] as $marca) {
            $data['allmarcas'][$index]->label = $marca->marca;
            $data['allmarcas'][$index]->value = $marca->marca;
            $index++;
        }
        setlocale(LC_ALL, 'es_ES');

        $data['titulo'] = 'Laspartes.com: Taller en línea';
        $data['header_view'] = 'flota/header/mi_cuenta_view';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="usuario-div-breadcrumb-espaciador"></div> <div>Mi Flota</div>';
        $data['navegacion_view'] = 'micuenta';
        $data['contenido_view'] = 'flota/mi_cuenta_view';
        $this->load->view('template/template', $data);
    }

    /**
     * función que retorna las tareas a realizar para un vehiculo dado
     * @param vehiculo $vehiculo
     * @param int $kilometraje_mensual
     * @return array tareas a realizar 
     */
    function _dar_tareas_vehiculo($vehiculo, $kilometraje_ciudad, $opciones) {
        $this->load->helper('date');
        $this->load->model('flota_model');
        $tareas = array();
        $tareas_asignadas = array();
        $kilometraje_mensual = $kilometraje_ciudad / 12;
        $kilometraje_diario = $kilometraje_ciudad / 365;
        $kilometraje_actual = $vehiculo->kilometraje;
        if($opciones['trabajos']){
            $trabajos_realizados  = $this->_dar_trabajos_realizados($vehiculo->id_usuario_vehiculo);
            $tareas_asignadas = array_merge($trabajos_realizados, $tareas_asignadas);
        }
        if ($kilometraje_actual > 3000) {
            $tareas = $this->flota_model->dar_tareas_vehiculo_personalizado($vehiculo->id_usuario_vehiculo);
            if(count($tareas)  == 0)
                $tareas = $this->usuario_model->dar_tareas_vehiculo($vehiculo->id_vehiculo, $vehiculo->modelo);
            $fecha_actual = mdate("%Y-%m-%d");
            foreach ($tareas as $tarea) {
                $tarea->realizado = false;
                if ($tarea->id_servicio == 9) {
                    $fecha_SOAT = $this->usuario_model->dar_legales_SOAT($vehiculo->id_usuario_vehiculo)->ultima_fecha;
                    $id_tarea_realizada = $this->usuario_model->dar_legales_SOAT($vehiculo->id_usuario_vehiculo)->id_tarea_realizada;
                    if (isset($fecha_SOAT) && $fecha_SOAT != "" && $fecha_SOAT != null) {
                        $diff_fecha_SOAT = round((strtotime($fecha_actual) - strtotime($fecha_SOAT)) / (60 * 60 * 24));
                        if ($diff_fecha_SOAT < 0 && $diff_fecha_SOAT > -60) {
                            $porcentaje = ($diff_fecha_SOAT * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->dias_restantes = abs($diff_fecha_SOAT);
                            $tarea->mensaje_dias_restantes = "TE QUEDAN: ";
                            $tarea->mensaje_dias_restantes2 = " DÍAS";
                            $tareas_asignadas[] = $tarea;
                        } else if ($diff_fecha_SOAT < 60 && $diff_fecha_SOAT >= 0) {
                            $porcentaje = ($diff_fecha_SOAT * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                            $tareas_asignadas[] = $tarea;
                        } else if ($diff_fecha_SOAT > 60) {
                            $tarea->due = strftime("%B %d de %Y", strtotime($fecha_SOAT));
                            $tarea->fecha = $fecha_SOAT;
                            $tarea->realizado = true;
                            $tarea->id_tarea_realizada = $id_tarea_realizada;
                            $tareas_asignadas[] = $tarea;
                        }
                    }
                } else if ($tarea->id_servicio == 10) {
                    $fecha_Tecnomecanica = $this->usuario_model->dar_legales_Tecnomecanica($vehiculo->id_usuario_vehiculo)->ultima_fecha;
                    $id_tarea_realizada = $this->usuario_model->dar_legales_Tecnomecanica($vehiculo->id_usuario_vehiculo)->id_tarea_realizada;
                    if (isset($fecha_Tecnomecanica) && $fecha_Tecnomecanica != '' && $fecha_Tecnomecanica != null && $fecha_Tecnomecanica != '0000-00-00' && strrpos($fecha_Tecnomecanica, '0000') == false) {
                        $tarea->realizado = false;
                        $diff_fecha_tecnomecanica = round((strtotime($fecha_actual) - strtotime($fecha_Tecnomecanica)) / (60 * 60 * 24));
                        if ($diff_fecha_tecnomecanica < 0 && $diff_fecha_tecnomecanica > -60) {
                            $porcentaje = ($diff_fecha_tecnomecanica * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->dias_restantes = abs($diff_fecha_tecnomecanica);
                            $tarea->mensaje_dias_restantes = "TE QUEDAN: ";
                            $tarea->mensaje_dias_restantes2 = " DÍAS";
                            $tareas_asignadas[] = $tarea;
                        } else if ($diff_fecha_tecnomecanica < 60 && $diff_fecha_tecnomecanica >= 0) {
                            $porcentaje = ($diff_fecha_tecnomecanica * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                            $tareas_asignadas[] = $tarea;
                        } else if ($diff_fecha_tecnomecanica > 60) {
                            $tarea->due = strftime("%B %d de %Y", strtotime($fecha_Tecnomecanica));
                            $tarea->fecha = $fecha_Tecnomecanica;
                            $tarea->realizado = true;
                            $tarea->id_tarea_realizada = $id_tarea_realizada;
                            $tareas_asignadas[] = $tarea;
                        }
                    }
                } else {
                    $realizados = $this->usuario_model->dar_tarea_realizada_vehiculo($vehiculo->id_usuario_vehiculo, $tarea->id_servicio);
                    if (!is_bool($realizados)) {
                        $validarFecha = true;
                        foreach ($realizados as $realizado):
                            $barra_progreso = 0;
                            $periodicidad = $tarea->periodicidad;
                            $ultima_fecha = $realizado->ultima_fecha;
                            $diff = abs(strtotime($fecha_actual) - strtotime($ultima_fecha));
                            $diff_en_dias = ($diff / (60 * 60 * 24));

                            //Ajusta el mantenimiento desde la fecha que se realizo el mantenimiento 
                            if (empty($realizado->kilometraje) || $realizado->kilometraje == '')
                                $kilometros_del_mantenimiento = $kilometraje_actual - ($diff_en_dias * $kilometraje_diario); //En caso de que se tenga el kilometraje en el cual se realizó el mantenimiento hay que cambiar el $diff_en_dias*$kilometraje_diario por el kilometraje efectivo en el que se hiso
                            else
                                $kilometros_del_mantenimiento = $kilometraje_actual - ($realizado->kilometraje);

                            $kilometraje_real_ajustado = $kilometraje_actual - $kilometros_del_mantenimiento;

                            $rango_inferior = $kilometraje_real_ajustado % $periodicidad;
//                            echo $tarea->nombre.'kilometraje actual: '.$kilometraje_actual .' diferencia en dias: '.$diff_en_dias.' kilometraje en que se realizó el mantenimiento: '.round($kilometros_del_mantenimiento).' kilometraje ajustado:'.round($kilometraje_real_ajustado).'<br/>';

                            $tareaTemp = new stdClass();
                            $tareaTemp->nombre = $tarea->nombre;
                            $tareaTemp->adjunto = $realizado->adjunto;
                            $tareaTemp->id_tarea_realizada = $tarea->id_tarea_realizada;
                            $tareaTemp->due = strftime("%B %d de %Y", strtotime($realizado->ultima_fecha));
                            $tareaTemp->fecha = $realizado->ultima_fecha;
                            $tareaTemp->realizado = true;
                            $tareaTemp->id_tarea_realizada = $realizado->id_tarea_realizada;
                            $tareas_asignadas[] = $tareaTemp;

                            if ($diff_en_dias > 60 && $validarFecha) {
                                if (($kilometraje_mensual * 2) > $rango_inferior || (($periodicidad - $rango_inferior) <= $kilometraje_diario && $rango_inferior >= 0)) {
                                    $porcentaje = ($rango_inferior * 100) / (2 * $kilometraje_mensual);
                                    $barra_progreso = $porcentaje;
                                    $dias_restantes = round(($rango_inferior * 60) / ($kilometraje_mensual * 2));
                                    $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                                    $tarea->barra_progreso = $barra_progreso;
                                    $tareas_asignadas[] = $tarea;
                                } else if ($kilometraje_actual - ($periodicidad - $rango_inferior) > ($kilometraje_actual - ($kilometraje_mensual * 2))) {
                                    $porcentaje = 100 - (($periodicidad - $rango_inferior) * 100) / (2 * $kilometraje_mensual);
                                    $barra_progreso = $porcentaje;
                                    $tarea->barra_progreso = $barra_progreso;
                                    $dias_restantes = round((($periodicidad - $rango_inferior) * 60) / ($kilometraje_mensual * 2));
                                    $tarea->dias_restantes = $dias_restantes;
                                    $tarea->mensaje_dias_restantes = "TE QUEDAN: ";
                                    $tarea->mensaje_dias_restantes2 = " DÍAS";
                                    $tareas_asignadas[] = $tarea;
                                }
                            }
                            $validarFecha = false;
                        endforeach;
                    } else {
                        $barra_progreso = 0;
                        $periodicidad = $tarea->periodicidad;
                        $rango_inferior = $kilometraje_actual % $periodicidad;
                        if (($kilometraje_mensual * 2) >= $rango_inferior || (($periodicidad - $rango_inferior) <= $kilometraje_diario && $rango_inferior >= 0)) {
                            $porcentaje = ($rango_inferior * 100) / (2 * $kilometraje_mensual);
                            $barra_progreso = $porcentaje;
                            $dias_restantes = round(($rango_inferior * 60) / ($kilometraje_mensual * 2));
                            $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                            $tarea->barra_progreso = $barra_progreso;
                            $tareas_asignadas[] = $tarea;
                        } else if ($kilometraje_actual - ($periodicidad - $rango_inferior) > ($kilometraje_actual - ($kilometraje_mensual * 2))) {
                            $porcentaje = 100 - (($periodicidad - $rango_inferior) * 100) / (2 * $kilometraje_mensual);
                            $barra_progreso = $porcentaje;
                            $tarea->barra_progreso = $barra_progreso;
                            $dias_restantes = round((($periodicidad - $rango_inferior) * 60) / ($kilometraje_mensual * 2));
                            $tarea->dias_restantes = $dias_restantes;
                            $tarea->mensaje_dias_restantes = "TE QUEDAN: ";
                            $tarea->mensaje_dias_restantes2 = " DÍAS";
                            $tareas_asignadas[] = $tarea;
                        }
                    }
                }
            }
            return $tareas_asignadas;
        }
    }

    /**
     * función que retorna las notificaciones de tareas que tiene pendiente un vehículo
     * @param vehiculo $vehiculo
     * @param int $kilometraje_mensual
     * @return array tareas a realizar 
     */
    function _dar_notificaciones_flota($vehiculo, $kilometraje_ciudad) {
        $this->load->helper('date');
        $tareas = array();
        $notificaciones = 0;
        $tareas_asignadas = array();
        $kilometraje_mensual = $kilometraje_ciudad / 12;
        $kilometraje_diario = $kilometraje_ciudad / 365;
        $kilometraje_actual = $vehiculo->kilometraje;
        if ($kilometraje_actual > 3000) {
            $tareas = $this->flota_model->dar_tareas_vehiculo_personalizado($vehiculo->id_usuario_vehiculo);
            if(count($tareas)  == 0)
                $tareas = $this->usuario_model->dar_tareas_vehiculo($vehiculo->id_vehiculo, $vehiculo->modelo);
            $fecha_actual = mdate("%Y-%m-%d");
            foreach ($tareas as $tarea) {
                $tarea->realizado = false;
                if ($tarea->id_servicio == 9) {
                    $fecha_SOAT = $this->usuario_model->dar_legales_SOAT($vehiculo->id_usuario_vehiculo)->ultima_fecha;
                    if (isset($fecha_SOAT) && $fecha_SOAT != "" && $fecha_SOAT != null) {
                        $diff_fecha_SOAT = round((strtotime($fecha_actual) - strtotime($fecha_SOAT)) / (60 * 60 * 24));
                        if ($diff_fecha_SOAT < 60 && $diff_fecha_SOAT >= -15) {
                            $porcentaje = ($diff_fecha_SOAT * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                            $notificaciones ++;
                        }
                    }
                } else if ($tarea->id_servicio == 10) {
                    $fecha_Tecnomecanica = $this->usuario_model->dar_legales_Tecnomecanica($vehiculo->id_usuario_vehiculo)->ultima_fecha;
                    if (isset($fecha_Tecnomecanica) && $fecha_Tecnomecanica != '' && $fecha_Tecnomecanica != null && $fecha_Tecnomecanica != '0000-00-00' && strrpos($fecha_Tecnomecanica, '0000') == false) {
                        $tarea->realizado = false;
                        $diff_fecha_tecnomecanica = round((strtotime($fecha_actual) - strtotime($fecha_Tecnomecanica)) / (60 * 60 * 24));

                        if ($diff_fecha_tecnomecanica < 60 && $diff_fecha_tecnomecanica >= -15) {
                            $porcentaje = ($diff_fecha_tecnomecanica * 100) / (60);
                            $tarea->barra_progreso = $porcentaje;
                            $tarea->mensaje_dias_restantes = "DEBES HACERLO";
                            $notificaciones ++;
                        } 
                    }
                } else {
                    $realizados = $this->usuario_model->dar_tarea_realizada_vehiculo($vehiculo->id_usuario_vehiculo, $tarea->id_servicio);
                    if (!is_bool($realizados)) {
                        $validarFecha = true;
                        foreach ($realizados as $realizado):
                            $periodicidad = $tarea->periodicidad;
                            $ultima_fecha = $realizado->ultima_fecha;
                            $diff = abs(strtotime($fecha_actual) - strtotime($ultima_fecha));
                            $diff_en_dias = ($diff / (60 * 60 * 24));

                            //Ajusta el mantenimiento desde la fecha que se realizo el mantenimiento 
                            if (empty($realizado->kilometraje) || $realizado->kilometraje == '')
                                $kilometros_del_mantenimiento = $kilometraje_actual - ($diff_en_dias * $kilometraje_diario); //En caso de que se tenga el kilometraje en el cual se realizó el mantenimiento hay que cambiar el $diff_en_dias*$kilometraje_diario por el kilometraje efectivo en el que se hiso
                            else
                                $kilometros_del_mantenimiento = $kilometraje_actual - ($realizado->kilometraje);

                            $kilometraje_real_ajustado = $kilometraje_actual - $kilometros_del_mantenimiento;

                            $rango_inferior = $kilometraje_real_ajustado % $periodicidad;

                            if ($diff_en_dias > 60 && $validarFecha) {
                                if (($kilometraje_mensual * 2) > $rango_inferior || (($periodicidad - $rango_inferior) <= $kilometraje_diario && $rango_inferior >= 0)) {
                                    $dias_restantes = round(($rango_inferior * 60) / ($kilometraje_mensual * 2));
                                    $notificaciones ++;
                                } else if ($kilometraje_actual - ($periodicidad - $rango_inferior) > ($kilometraje_actual - ($kilometraje_mensual * 2))) {
                                    $dias_restantes = round((($periodicidad - $rango_inferior) * 60) / ($kilometraje_mensual * 2));
                                    if($dias_restantes <= 15)
                                        $notificaciones ++;
                                }
                            }
                            $validarFecha = false;
                        endforeach;
                    } else {
                        $barra_progreso = 0;
                        $periodicidad = $tarea->periodicidad;
                        $rango_inferior = $kilometraje_actual % $periodicidad;
                        if (($kilometraje_mensual * 2) >= $rango_inferior || (($periodicidad - $rango_inferior) <= $kilometraje_diario && $rango_inferior >= 0)) {
                            $notificaciones ++;
                        } else if ($kilometraje_actual - ($periodicidad - $rango_inferior) > ($kilometraje_actual - ($kilometraje_mensual * 2))) {
                            $dias_restantes = round((($periodicidad - $rango_inferior) * 60) / ($kilometraje_mensual * 2));
                            if($dias_restantes <= 15)
                                        $notificaciones ++;
                        }
                    }
                }
            }
            return $notificaciones;
        }
    }

    /**
     * Valida si NO existe un email, excluyendo el mail de la sesión
     * @return bool $existe_email true si no existe
     */
    function _no_existe_email_sesion_iniciada($email) {
        $this->load->model('usuario_model');
        $usuario = $this->usuario_model->dar_usuario($this->session->userdata('id_usuario'));
        if ($usuario->email == $email)
            return TRUE;
        else {
            $resultado = $this->_no_existe_email($email);
            if ($resultado)
                return TRUE;
            else
                $this->form_validation->set_message('_no_existe_email_sesion_iniciada', 'El correo electrónico dado ya se encuentra registrado.');
            return FALSE;
        }
    }

    /**
     * Verifica si existe un usuario dado
     * @param String $usuario
     * @return boolean $no_existe_usuario true si no existe
     */
    function _no_existe_usuario($usuario) {
        $this->load->model('usuario_model');
        $existe = $this->usuario_model->existe_usuario($usuario);
        if (!$existe)
            return TRUE;
        else {
            $this->form_validation->set_message('_no_existe_usuario', 'El usuario dado ya se encuentra registrado.');
            return FALSE;
        }
    }

    /**
     * Valida si NO existe un usuario y que el usuario es diferente al de la sesión iniciada
     * @param String $usuario
     * @return bool $existe_usuario true si no existe
     */
    function _no_existe_usuario_sesion_iniciada($usuario) {
        $this->load->model('usuario_model');
        $usuarioObj = $this->usuario_model->dar_usuario($this->session->userdata('id_usuario'));
        if ($usuarioObj->usuario == $usuario)
            return TRUE;
        else {
            $resultado = $this->_no_existe_usuario($usuario);
            if ($resultado)
                return TRUE;
            else {
                $this->form_validation->set_message('_no_existe_usuario_sesion_iniciada', 'El usuario dado ya se encuentra registrado.');
                return FALSE;
            }
        }
    }

    /**
     * Verifica si no existe un mail dado
     * @param String $email
     * @return boolean $no_existe_email true si no existe
     */
    function _no_existe_email($email) {
        $this->load->model('usuario_model');
        $existe = $this->usuario_model->existe_email($email);
        if (!$existe)
            return TRUE;
        else if($existe){
            $this->form_validation->set_message('_no_existe_email', 'El correo electrónico dado ya se encuentra registrado.');
            return FALSE;
        }
    }

    /**
     * Verifica si no existe un mail dado
     * @param String $email
     * @return boolean $no_existe_email true si no existe
     */
    function _no_existe_email_CRM($email) {
        $this->load->model('usuario_model');
        $existe = $this->usuario_model->existe_email_CRM($email);
        if (!$existe)
            return TRUE;
        else if($existe){
            $this->form_validation->set_message('_no_existe_email', 'El correo electrónico dado ya se encuentra registrado.');
            return FALSE;
        }
    }

    /**
     * Da el usuario y carro asociado
     * @param String $email
     * @return boolean $no_existe_email true si no existe
     */
    function _dar_usuario_CRM($email) {
        $this->load->model('usuario_model');
        $existe = $this->usuario_model->existe_usuario_CRM($email);
        if ($existe === false)
            return TRUE;
        else if($existe === true){
            return FALSE;
        }
        else
            return $existe;
    }

    /**
     * Verifica si existe un mail dado
     * @param String $email
     * @return boolean $no_existe_email true si no existe
     */
    function _existe_email($email) {
        $this->load->model('usuario_model');
        $existe = $this->usuario_model->existe_email($email);
        if (!$existe)
            return FALSE;
        else {
            $this->form_validation->set_message('_existe_email', 'El correo electrónico dado no se encuentra registrado.');
            return TRUE;
        }
    }

    /**
     * Verifica la palabra del captcha
     * @param String $palabra
     * @return boolean $es_correcto true si está bien la palabra
     */
    function _verificar_captcha($palabra) {
        $this->load->model('usuario_model');
        $this->usuario_model->eliminar_captchas();
        $es_correcto = $this->usuario_model->verificar_captcha($palabra);
        if ($es_correcto)
            return TRUE;
        else {
            $this->form_validation->set_message('_verificar_captcha', 'El código de verificación es inválido.');
            return FALSE;
        }
    }

    /**
     * Verifica si las 2 contraseñas dadas son iguales
     * @param int $contrasena2
     * @param int $contrasena
     * @return boolean $es_igual true si es igual
     */
    function _verificar_contrasena($contrasena2, $contrasena) {
        if ($contrasena2 == $contrasena)
            return TRUE;
        else {
            $this->form_validation->set_message('_verificar_contrasena', 'La confirmación de la contraseña no es igual a la contraseña escrita.');
            return FALSE;
        }
    }

    /**
     * Actualiza la cantidad de una autoparte en el carrito del compras
     */
    function actualizar_carrito_compras() {
        try {
            $this->load->model('promocion_model');
            $rowid = $this->input->post('row', TRUE);
            $cantidad = $this->input->post('cantidad', TRUE);

            $item = array(
                'rowid' => $rowid,
                'qty' => $cantidad
            );
            $this->cart->update($item);
            foreach ($this->cart->contents() as $item) {
                if ($item['name'] == 'oferta') {
                    $oferta = $this->promocion_model->dar_oferta($item['id']);
                    $ofertatemp = new stdClass();
                    $ofertatemp->dco_feria = $oferta->dco_feria;
                    $ofertatemp->qty = $item['qty'];
                    if ($oferta->dco_feria != 0):
                        $precio = $oferta->precio;
                        $iva = round($oferta->iva);
                        $dco = $oferta->dco_feria;
                        $base = $precio - $iva;
                        $ivaPorce = $iva / $base;
                        $valorDco = $base * ((100 - $dco) / 100);
                        $precionConDco = ($valorDco * (1 + $ivaPorce));
                        $ofertatemp->iva = round($precionConDco - $valorDco);
                        $ofertatemp->precio = round($precionConDco);
                        $precioTotal += ($ofertatemp->precio * $ofertatemp->qty);
                        $ivaTotal += ($ofertatemp->iva * $ofertatemp->qty);
                    else:
                        $ofertatemp->iva = round($oferta->iva);
                        $ofertatemp->precio = $oferta->precio;
                        $precioTotal += ($ofertatemp->precio * $ofertatemp->qty);
                        $ivaTotal += ($ofertatemp->iva * $ofertatemp->qty);
                    endif;
                }else if ($item['name'] == 'autoparte') {
                    $this->load->model('autoparte_model');
                    $autoparte_establecimiento = $this->autoparte_model->dar_autoparte_establecimiento($item['id'], $item['id_establecimiento']);
                    $autopartetemp = new stdClass();
                    $autopartetemp->qty = $item['qty'];
                    $autopartetemp->rowid = $item['rowid'];
                    $autopartetemp->precio = round($autoparte_establecimiento->precio);
                    $autopartetemp->iva = round($autoparte_establecimiento->precio - ($autoparte_establecimiento->precio / 1.16));
                    $precioTotal += ($autopartetemp->precio * $autopartetemp->qty);
                    $ivaTotal += ($autopartetemp->iva * $autopartetemp->qty);
                }
            }


            $err['total'] = round($precioTotal);
            $err['devolucion'] = $err['total'] - round($ivaTotal);
            $err['iva'] = round($ivaTotal);
            $err['items'] = $this->cart->total_items();
            echo 'true|' . json_encode($err);
        } catch (Exception $exc) {
            echo 'false|' . $exc->getTraceAsString();
        }
    }

    /**
     * Agrega un elemento al carrito de compras
     */
    function agregar_carrito_compras() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_autoparte',
                'label' => 'identificador de laautoparte',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_establecimiento',
                'label' => 'identificador del establecimiento',
                'rules' => 'trim|required|numeric|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_autoparte = $this->input->post('id_autoparte', TRUE);
        if (!$this->form_validation->run()) {
            redirect(base_url() . "autopartes");
//            $data = $this->_ver_autoparte($id_autoparte);
//            $data['titulo'] = 'Detalle de autoparte';
//            $data['header_view'] = 'autoparte/header/autoparte_detalle_view';
//            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'autopartes">Autopartes</a> :: ' . $data['autoparte']->nombre;
//            $data['navegacion_view'] = 'autopartes';
//            $data['contenido_view'] = 'autoparte/autoparte_detalle_view';
//            $this->load->view('template/template', $data);
        } else {
            $id_establecimiento = $this->input->post('id_establecimiento', TRUE);

            $this->load->model('autoparte_model');
            $autoparte_establecimiento = $this->autoparte_model->dar_autoparte_establecimiento($id_autoparte, $id_establecimiento);
            // Revisa si ya se tiene la autoparte en el carrito. Si es así, suma 1 a la cantidad.
            $existe = FALSE;
            foreach ($this->cart->contents() as $autoparte) {
                if ($autoparte_establecimiento->id_autoparte == $autoparte['id'] && $autoparte['name'] == 'autoparte') {
                    $item = array(
                        'rowid' => $autoparte['rowid'],
                        'qty' => ( $autoparte['qty'] + 1 )
                    );
                    $this->cart->update($item);
                    $existe = TRUE;
                }
            }

            if ($existe == FALSE) {
                // Agrega un nuevo item al carrito
                $item = array(
                    'id' => $autoparte_establecimiento->id_autoparte,
                    'qty' => 1,
                    'price' => $autoparte_establecimiento->precio,
//                    'iva' => round($autoparte_establecimiento->precio - ($autoparte_establecimiento->precio / 1.16)),
                    'name' => 'autoparte',
//                    'nombre' => str_replace('/', '-', $autoparte_establecimiento->nombre) . ' MARCA ' . $autoparte_establecimiento->marca . ' PARA ' . $autoparte_establecimiento->vehiculo_marca,
//                    'options' => array(
                    'id_establecimiento' => $autoparte_establecimiento->id_establecimiento
//                        'nombre_establecimiento' => $autoparte_establecimiento->establecimiento,
//                        'foto' => $autoparte_establecimiento->imagen,
//                        'descripcion' => character_limiter($autoparte_establecimiento->descripcion, 400)
//                    )
                );

                $this->cart->insert($item);
            }
            redirect(base_url() . "carrito");
        }
    }

    /**
     * Agrega un elemento al carrito de compras
     */
    function agregar_carrito_compras_promo() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_oferta',
                'label' => 'identificador de la oferta',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);


        if (!$this->form_validation->run()) {
            redirect(base_url() . "promociones");
        } else {
            $id_oferta = $this->input->post('id_oferta', TRUE);

            $this->load->model('promocion_model');
            $oferta = $this->promocion_model->dar_oferta($id_oferta);
            // Revisa si ya se tiene la autoparte en el carrito. Si es así, suma 1 a la cantidad.
            $existe = FALSE;
            foreach ($this->cart->contents() as $ofertaCarrito) {
                if ($oferta->id_oferta == $ofertaCarrito['id'] && $ofertaCarrito['name'] == 'oferta') {
                    $item = array(
                        'rowid' => $ofertaCarrito['rowid'],
                        'qty' => ( $ofertaCarrito['qty'] + 1 )
                    );
                    $this->cart->update($item);
                    $existe = TRUE;
                }
            }
//
            if ($existe == FALSE) {
//                if ($oferta->dco_feria != 0):
//                    $precio = $oferta->precio;
//                    $iva = round($oferta->iva);
//                    $dco = $oferta->dco_feria;
//                    $base = $precio - $iva;
//                    $ivaPorce = $iva / $base;
//                    $valorDco = $base * ((100 - $dco) / 100);
//                    $precionConDco = ($valorDco * (1 + $ivaPorce));
//                    $item = array(
//                        'id' => $oferta->id_oferta,
//                        'qty' => 1,
//                        'price' => round($precionConDco),
//                        'iva' => round($precionConDco - $valorDco),
//                        'name' => 'oferta',
//                        'nombre' => $oferta->titulo,
//                        'options' => array(
//                            'id_establecimiento' => $oferta->id_establecimiento,
//                            'nombre_establecimiento' => $oferta->establecimientoNombre,
//                            'foto' => $oferta->foto,
//                            'descripcion' => character_limiter($oferta->incluye, 400)
//                        )
//                    );
//                else:
                $item = array(
                    'id' => $oferta->id_oferta,
                    'qty' => 1,
                    'price' => $oferta->precio,
//                        'iva' => $oferta->iva,
                    'name' => 'oferta'
//                        'nombre' => $oferta->titulo,
//                        'options' => array(
//                            'id_establecimiento' => $oferta->id_establecimiento,
//                            'nombre_establecimiento' => $oferta->establecimientoNombre,
//                            'foto' => $oferta->foto,
//                            'descripcion' => character_limiter($oferta->incluye, 400)
//                        )
                );
//                endif;
                // Agrega un nuevo item al carrito


                $this->cart->insert($item);
            }
            redirect(base_url() . "carrito");
        }
    }

    /**
     * Agrega un vehículo al usuario
     */
    function agregar_vehiculo() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_vehiculo',
                'label' => 'linea',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'modelo',
                'label' => 'modelo',
                'rules' => 'trim|required|numeric|xss_clean'
            ),
            array(
                'field' => 'kilometraje',
                'label' => 'kilometraje',
                'rules' => 'trim|numeric|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run() || !$this->session->userdata('esta_registrado')) {
            $this->formulario_agregar_vehiculo();
        } else {
            $this->load->model('usuario_model');
            $id_usuario = $this->session->userdata('id_usuario');
            $id_vehiculo = $this->input->post('id_vehiculo', TRUE);

            $modelo = $this->input->post('modelo', TRUE);
            $kilometraje = $this->input->post('kilometraje', TRUE);
            $placa = $this->input->post('placa', TRUE);

            if ($kilometraje < 0) {
                $usuario = $this->usuario_model->dar_usuario($id_usuario);
                $tasa_ciudad = $this->usuario_model->dar_kilometraje_ciudad($usuario->lugar);

                $ano_actual = date('Y');
                $diferencia = $ano_actual - $modelo;
                $kilometraje = $diferencia * $tasa_ciudad;
            }

            $id_usuario_vehiculo = $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $id_vehiculo, '', $modelo, $kilometraje, '', $placa);

            $this->load->library('upload');
            if (!is_dir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo)) {
                mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo, 0777, TRUE);
                mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/thumb', 0777, TRUE);
            }

            // Limpiar el nombre del archivo
            $caracteres = array(
                "<!--",
                ".",
                "-->",
                "'",
                "<",
                ">",
                '"',
                '&',
                '$',
                '=',
                ';',
                '?',
                '/',
                "%20",
                "%22",
                "%3c", // <
                "%253c", // <
                "%3e", // >
                "%0e", // >
                "%28", // (
                "%29", // )
                "%2528", // (
                "%26", // &
                "%24", // $
                "%3f", // ?
                "%3b", // ;
                "%3d"  // =
            );

            $nombreArchivo = str_replace($caracteres, '', $nombre);
            $nombreArchivo = stripslashes($nombreArchivo);

            $config = array(
                'upload_path' => 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'file_name' => $nombreArchivo,
                'max_size' => '10240'
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload('imagen')) {
                $imagen = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'new_image' => 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/thumb',
                    'width' => 99,
                    'height' => 99,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $imagen_url = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
                $imagen_thumb_url = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/thumb/' . $imagen['file_name'];
                $this->usuario_model->actualizar_usuario_vehiculo_imagen_url($id_usuario_vehiculo, $imagen_url, $imagen_thumb_url);
            }
            $this->_mi_cuenta('vehiculos');
        }
    }

    /**
     * Agrega un vehículo simple al usuario
     */
    function _agregar_vehiculo_registro() {
        $this->load->model('usuario_model');

        $id_usuario = $this->session->userdata('id_usuario');
        $id_vehiculo = $this->input->post('vehiculo_id', TRUE);
//        if ($kilometraje < 0) {
//            $ciudad = $this->input->post('ciudad_registrarse', TRUE);
//            $tasa_ciudad = $this->usuario_model->dar_kilometraje_ciudad($ciudad);
//
//            $ano_actual = date('Y');
//            $diferencia = $ano_actual - $modelo;
//            $kilometraje = $diferencia * $tasa_ciudad;
//        }

        $id_usuario_vehiculo = $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $id_vehiculo, '', '', '', '', '');
        $this->index();
    }

    /**
     * Destruye la sesión y redirecciona a la página principal
     */
    function cerrar_sesion() {
        $this->session->unset_userdata('tipo');
        $this->session->unset_userdata('esta_registrado');
        $this->session->unset_userdata('nombres');
        $this->session->unset_userdata('apellidos');
        $this->session->unset_userdata('correo');
        $this->session->unset_userdata('ciudad');
        $this->session->unset_userdata('usuario');
        $this->session->unset_userdata('id_usuario');
//        $this->session->sess_destroy();
        $data['confirmacion'] = 'Sesión cerrada con éxito.';
        $this->_login($data);
    }

    /**
     * Destruye la sesión y redirecciona a la página principal
     */
    function cerrar_sesion_ajax() {
        $this->session->unset_userdata('tipo');
        $this->session->unset_userdata('esta_registrado');
        $this->session->unset_userdata('nombres');
        $this->session->unset_userdata('apellidos');
        $this->session->unset_userdata('correo');
        $this->session->unset_userdata('ciudad');
        $this->session->unset_userdata('usuario');
        $this->session->unset_userdata('id_usuario');
//        $this->session->sess_destroy();        
        echo 'true';
    }

    /**
     * Hace el checkout de las autopartes en el carrito de compras
     */
    function checkout_carrito_compras() {
        $respuesta = 'false';
        if (!$this->session->userdata('esta_registrado')) {
            $this->ver_carrito_compras('Lo sentimos, debe iniciar su sesión como usuario registrado para realizar esta acción');
            $respuesta = 'false';
        } else {

            $this->load->model('usuario_model');
            $this->load->model('refventa_model');
            $refVenta = $this->input->post('refVenta', TRUE);
            $id_usuario = $this->session->userdata('id_usuario');
            if (sizeof($this->cart->contents()) != 0) {
                $id_carrito_compra = $this->usuario_model->agregar_carrito_compras($id_usuario, 'Revisando disponibilidad de autopartes', $this->cart->total());
                foreach ($this->cart->contents() as $autoparte)
                    $this->usuario_model->agregar_carrito_compras_articulo($id_carrito_compra, $autoparte['options']['id_establecimiento'], $autoparte['id'], $autoparte['price'], $autoparte['qty'], $autoparte['options']['descripcion']);
                $this->refventa_model->agregar_RefVenta($refVenta, $id_carrito_compra);
                $this->cart->destroy();
                $respuesta = 'true';
            }
            else
                $respuesta = 'false';
        }
        echo $respuesta;
    }

    /**
     * Hace el checkout de las autopartes en el carrito de compras
     * Valida el usuario e inicia sesión
     */
    function checkout_carrito_compras_ingresar() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email_ingresar',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'contrasena_ingresar',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $this->ver_carrito_compras();
        } else {
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email_ingresar', TRUE));
            $contrasena = sha1($this->input->post('contrasena_ingresar', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);
            if (!$resultado) {
                $this->ver_carrito_compras();
            } else {

                $this->load->model('usuario_model');
                $id_usuario = $this->session->userdata('id_usuario');
                if (sizeof($this->cart->contents()) != 0) {
                    $id_carrito_compra = $this->usuario_model->agregar_carrito_compras($id_usuario, 'Revisando disponibilidad de autopartes', $this->cart->total());
                    foreach ($this->cart->contents() as $autoparte)
                        $this->usuario_model->agregar_carrito_compras_articulo($id_carrito_compra, $autoparte['options']['id_establecimiento'], $autoparte['id'], $autoparte['price'], $autoparte['qty'], $autoparte['options']['descripcion_autoparte']);
                    $this->cart->destroy();

                    // Enviar mail
                    $this->load->library('email');
                    $email = $this->usuario_model->dar_usuario($id_usuario)->email;
                    $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co - Mi cuenta');
                    $this->email->to($email);
                    $this->email->bcc('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
                    $this->email->subject('[LasPartes.com.co] Gracias por su compra');
                    $this->email->message('
                        Usted ha registrado una nueva compra con nosotros.
                        <br />
                        <br />
                        En breve nos comunicaremos con usted para continuar con su proceso de compra.
                        <br />
                        <br />
                        Para ver el estado de su compra en cualquier momento puede revisar su cuenta <a href="' . base_url() . 'usuario">aquí</a> ingresando con su email y password registrados.
                        <br />
                        <br />
                        Cordialmente,<br />
                        -------------------------------------------------------<br />
                        Servicio al cliente<br />
                        <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
                    ');
                    $this->email->send();

                    $this->_mi_cuenta('carritos-compras', 'Su compra ha sido registrada satisfactoriamente. En breve nos comunicaremos con usted para continuar su proceso de compra');
                }
                else
                    $this->_mi_cuenta('carritos-compras', 'Su carrito de compras no tiene elementos para comprar.');
            }
        }
    }

    /**
     * Hace el checkout de las autopartes en el carrito de compras
     * Registra un usuario e inicia sesión
     */
    function checkout_carrito_compras_registrarse() {
        $contrasena = $this->input->post('contrasena_registrarse', TRUE);
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'nombre_registrarse',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'apellidos_registrarse',
                'label' => 'apellidos',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'ciudad_registrarse',
                'label' => 'ciudad',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'usuario_registrarse',
                'label' => 'usuario',
                'rules' => 'trim|required|callback__no_existe_usuario|xss_clean'
            ),
            array(
                'field' => 'email_registrarse',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|callback__no_existe_email|xss_clean'
            ),
            array(
                'field' => 'contrasena_registrarse',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'contrasena2_registrarse',
                'label' => 'repita la contraseña',
                'rules' => 'trim|required|callback__verificar_contrasena[' . $contrasena . ']|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $this->ver_carrito_compras();
        } else {
            $this->load->model('usuario_model');
            $nombre = strtolower($this->input->post('nombre_registrarse', TRUE));
            $apellidos = strtolower($this->input->post('apellidos_registrarse', TRUE));
            $ciudad = strtolower($this->input->post('ciudad_registrarse', TRUE));
            $usuario = strtolower($this->input->post('usuario_registrarse', TRUE));
            $email = strtolower($this->input->post('email_registrarse', TRUE));
            $contrasena = sha1($this->input->post('contrasena_registrarse', TRUE));
            $id_usuario = $this->usuario_model->agregar_usuario($nombre, $apellidos, $usuario, $email, $contrasena, $ciudad, 30);
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $usuario_sesion = array(
                'id_usuario' => $usuario->id_usuario,
                'tipo' => $usuario->tipo,
                'esta_registrado' => TRUE
            );
            $this->session->set_userdata($usuario_sesion);


            $this->load->model('usuario_model');
            $id_usuario = $this->session->userdata('id_usuario');
            if (sizeof($this->cart->contents()) != 0) {
                $id_carrito_compra = $this->usuario_model->agregar_carrito_compras($id_usuario, 'Revisando disponibilidad de autopartes', $this->cart->total());
                foreach ($this->cart->contents() as $autoparte)
                    $this->usuario_model->agregar_carrito_compras_articulo($id_carrito_compra, $autoparte['options']['id_establecimiento'], $autoparte['id'], $autoparte['price'], $autoparte['qty'], $autoparte['options']['descripcion_autoparte']);
                $this->cart->destroy();

                // Enviar mail
                $this->load->library('email');
                $email = $this->usuario_model->dar_usuario($id_usuario)->email;
                $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co - Mi cuenta');
                $this->email->to($email);
                $this->email->bcc('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
                $this->email->subject('[LasPartes.com.co] Gracias por su compra');
                $this->email->message('
                    Usted ha registrado una nueva compra con nosotros.
                    <br />
                    <br />
                    En breve nos comunicaremos con usted para continuar con su proceso de compra.
                    <br />
                    <br />
                    Para ver el estado de su compra en cualquier momento puede revisar su cuenta <a href="' . base_url() . 'usuario">aquí</a> ingresando con su email y password registrados.
                    <br />
                    <br />
                    Cordialmente,<br />
                    -------------------------------------------------------<br />
                    Servicio al cliente<br />
                    <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
                ');
                $this->email->send();

                $this->_mi_cuenta('carritos-compras', 'Su compra ha sido registrada satisfactoriamente. En breve nos comunicaremos con usted para continuar su proceso de compra');
            }
            else
                $this->_mi_cuenta('carritos-compras', 'Su carrito de compras no tiene elementos para comprar.');
        }
    }

    /**
     * Da las líneas de una marca por ajax
     * @return array $lineas
     */
    function dar_vehiculos_lineas_ajax() {
        $marca = $this->input->get_post('marca', TRUE);
        $this->load->model('usuario_model');
        echo json_encode($this->usuario_model->dar_vehiculos_lineas($marca));
    }

    /**
     * Elimina una autoparte del carrito de compras
     */
    function eliminar_carrito_compras() {
        try {
            $rowid = $this->input->post('id', TRUE);
            $item = array(
                'rowid' => $rowid,
                'qty' => 0
            );
            $this->cart->update($item);
            $err['total'] = $this->cart->total();
            $err['devolucion'] = $err['total'] / 1.16;
            $err['iva'] = $err['total'] - $err['devolucion'];
            $err['items'] = $this->cart->total_items();
            echo 'true|' . json_encode($err);
        } catch (Exception $exc) {
            echo 'false|' . $exc->getTraceAsString();
        }
    }

    /**
     * Elimina un vehículo asociado al usuario
     */
    function eliminar_vehiculo() {
        if (!$this->session->userdata('esta_registrado'))
            $this->_login(NULL);
        else {
            $this->load->model('usuario_model');
            $id_usuario = $this->session->userdata('id_usuario');
            $id_usuario_vehiculo = $this->uri->segment(3);
            $vehiculo = $this->usuario_model->dar_usuario_vehiculo($id_usuario_vehiculo);
            if ($vehiculo->imagen_thumb_url != '' || $vehiculo->imagen_thumb_url != NULL) {
                unlink($vehiculo->imagen_url);
                unlink($vehiculo->imagen_thumb_url);
            }
            $this->usuario_model->eliminar_usuario_vehiculo($id_usuario, $id_usuario_vehiculo);

            $this->_mi_cuenta('vehiculos');
        }
    }

    /**
     * Muestra el formulario para agregar un nuevo vehículo al usuario
     */
    function formulario_agregar_vehiculo() {
        $esta_registrado = $this->session->userdata('esta_registrado');
        if (!isset($esta_registrado) || !$esta_registrado)
            $this->_login(NULL);
        else {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->model('usuario_model');
            $data['marcas'] = $this->usuario_model->dar_vehiculos_marcas();
            $data['titulo'] = 'Agregar Vehículo';
            $data['header_view'] = 'usuario/header/usuario_vehiculo_agregar_view';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'usuario">Mi Cuenta</a> :: Agregar Vehículo';
            $data['navegacion_view'] = 'micuenta';
            $data['contenido_view'] = 'usuario/usuario_vehiculo_agregar_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Muestra la página para editar el perfil
     */
    function formulario_modificar_perfil() {
        $esta_registrado = $this->session->userdata('esta_registrado');
        if (!isset($esta_registrado) || !$esta_registrado)
            $this->_login(NULL);
        else {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->model('usuario_model');
            $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
            $data['titulo'] = 'Editar Mi Perfil';
            $data['header_view'] = 'usuario/header/perfil_modificar_view';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'usuario">Mi Cuenta</a> :: Editar Mi Perfil';
            $data['navegacion_view'] = 'micuenta';
            $data['contenido_view'] = 'usuario/perfil_modificar_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Modifica un vehículo del usuario
     */
    function formulario_modificar_vehiculo() {
        $esta_registrado = $this->session->userdata('esta_registrado');
        if (!isset($esta_registrado) || !$esta_registrado)
            $this->_login(NULL);
        else {
            $id_usuario_vehiculo = $this->uri->segment(3);
            $data = $this->_formulario_modificar_vehiculo($id_usuario_vehiculo);
            $data['titulo'] = 'Editar Vehículo';
            $data['header_view'] = 'usuario/header/usuario_vehiculo_modificar_view';
            $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'usuario">Mi Cuenta</a> :: Editar Vehículo';
            $data['navegacion_view'] = 'micuenta';
            $data['contenido_view'] = 'usuario/usuario_vehiculo_modificar_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Muestra la página principal del usuario
     */
    function index() {
        $this->_login(NULL);
    }

    /**
     * Muestra la página principal del usuario
     */
    function stcolombia() {
        $data['referenciado'] = "stcolombia";
        $this->_login($data);
    }

    /**
     * Muestra la información del usuario
     */
    function mi_cuenta() {
        if (!$this->session->userdata('esta_registrado'))
            $this->_login(NULL);
        else {
            $this->_mi_cuenta('vehiculos');
        }
    }

    /**
     * Modifica el perfil del usuario actual
     */
    function modificar_perfil() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'usuario',
                'label' => 'usuario',
                'rules' => 'trim|required|callback__no_existe_usuario_sesion_iniciada|xss_clean'
            ),
            array(
                'field' => 'nombres',
                'label' => 'nombres',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'apellidos',
                'label' => 'apellidos',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'lugar',
                'label' => 'lugar',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|valid_email|callback__no_existe_email_sesion_iniciada|xss_clean'
            ),
            array(
                'field' => 'email2',
                'label' => 'confirmar el correo electrónico',
                'rules' => 'trim|valid_email|matches[email]|xss_clean'
            ),
            array(
                'field' => 'contrasena',
                'label' => 'contraseña',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'contrasena2',
                'label' => 'confirmar contraseña',
                'rules' => 'trim|matches[contrasena2]|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $this->formulario_modificar_perfil();
        } else {
            if (!$this->session->userdata('esta_registrado'))
                $this->_login(NULL);
            else {
                $this->load->model('usuario_model');
                $id_usuario = $this->session->userdata('id_usuario');
                $usuario = strtolower($this->input->post('usuario', TRUE));
                $nombres = ucwords(strtolower($this->input->post('nombres', TRUE)));
                $apellidos = ucwords(strtolower($this->input->post('apellidos', TRUE)));
                $email = strtolower($this->input->post('email', TRUE));
                $lugar = ucwords(strtolower($this->input->post('lugar', TRUE)));
                $contrasena = sha1($this->input->post('contrasena', TRUE));
                $this->usuario_model->actualizar_usuario($id_usuario, $usuario, $nombres, $apellidos, $email, $lugar);
                if ($this->input->post('contrasena', TRUE) != '')
                    $this->usuario_model->actualizar_usuario_contrasena($id_usuario, $contrasena);

                $this->load->library('upload');
                if (!is_dir('resources/images/usuarios/' . $id_usuario)) {
                    mkdir('resources/images/usuarios/' . $id_usuario, 0777, TRUE);
                    mkdir('resources/images/usuarios/' . $id_usuario . '/thumb', 0777, TRUE);
                }

                // Limpiar el nombre del archivo
                $caracteres = array(
                    "<!--",
                    ".",
                    "-->",
                    "'",
                    "<",
                    ">",
                    '"',
                    '&',
                    '$',
                    '=',
                    ';',
                    '?',
                    '/',
                    "%20",
                    "%22",
                    "%3c", //<
                    "%253c", //<
                    "%3e", // >
                    "%0e", // >
                    "%28", // (
                    "%29", // )
                    "%2528", // (
                    "%26", // &
                    "%24", // $
                    "%3f", // ?
                    "%3b", // ;
                    "%3d"// =
                );

                $nombreArchivo = str_replace($caracteres, '', $usuario);
                $nombreArchivo = stripslashes($nombreArchivo);

                $config = array(
                    'upload_path' => 'resources/images/usuarios/' . $id_usuario,
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'file_name' => $nombreArchivo,
                    'max_size' => '10240'
                );

                $this->upload->initialize($config);

                if ($this->upload->do_upload('imagen')) {
                    $imagen = $this->upload->data();

                    $this->load->library('image_lib');
                    $config = array(
                        'source_image' => $imagen['full_path'],
                        'quality' => '100%',
                        'new_image' => 'resources/images/usuarios/' . $id_usuario . '/thumb',
                        'width' => 99,
                        'height' => 99,
                        'master_dim' => 'width'
                    );
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $imagen_url = 'resources/images/usuarios/' . $id_usuario . '/' . $imagen['file_name'];
                    $imagen_thumb_url = 'resources/images/usuarios/' . $id_usuario . '/thumb/' . $imagen['file_name'];

                    $this->usuario_model->actualizar_usuario_imagen_url($id_usuario, $imagen_url, $imagen_thumb_url);
                }
                $this->mi_cuenta();
            }
        }
    }

    /**
     * Modifica un vehículo de un usuario
     */
    function modificar_vehiculo() {
        if (!$this->session->userdata('esta_registrado'))
            $this->_login(NULL);
        else {

            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_usuario_vehiculo',
                    'label' => 'identificador del vehículo del usuario',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'id_vehiculo',
                    'label' => 'linea',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'modelo',
                    'label' => 'modelo',
                    'rules' => 'trim|required|numeric|xss_clean'
                ),
                array(
                    'field' => 'kilometraje',
                    'label' => 'kilometraje',
                    'rules' => 'trim|numeric|xss_clean'
                ),
                array(
                    'field' => 'placa',
                    'label' => 'placa',
                    'rules' => 'trim|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo', TRUE);
            $id_usuario = $this->session->userdata('id_usuario');
            if (!$this->form_validation->run()) {
                $data = $this->_formulario_modificar_vehiculo($id_usuario_vehiculo);
                $data['titulo'] = 'Editar Vehículo';
                $data['header_view'] = 'usuario/header/usuario_vehiculo_modificar_view';
                $data['breadcrumb'] = '<a href="' . base_url() . '">Inicio</a> :: <a href="' . base_url() . 'usuario">Mi Cuenta</a> :: Editar Vehículo';
                $data['navegacion_view'] = 'micuenta';
                $data['contenido_view'] = 'usuario/usuario_vehiculo_modificar_view';
                $this->load->view('template/template', $data);
            } else {
                $this->load->model('usuario_model');
                $id_vehiculo = $this->input->post('id_vehiculo', TRUE);
                $serie = $this->input->post('serie', TRUE);
                $modelo = $this->input->post('modelo', TRUE);
                $kilometraje = $this->input->post('kilometraje', TRUE);

                if ($kilometraje < 0) {
                    $usuario = $this->usuario_model->dar_usuario($id_usuario);
                    $tasa_ciudad = $this->usuario_model->dar_kilometraje_ciudad($usuario->lugar);

                    $ano_actual = date('Y');
                    $diferencia = $ano_actual - $modelo;
                    $kilometraje = $diferencia * $tasa_ciudad;
                }

                $placa = $this->input->post('placa', TRUE);
                $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo, $id_vehiculo, '', $modelo, $kilometraje, '', $placa);

                $this->load->library('upload');
                if (!is_dir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo)) {
                    mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo, 0777, TRUE);
                    mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/thumb', 0777, TRUE);
                }

                // Limpiar el nombre del archivo
                $caracteres = array(
                    "<!--",
                    ".",
                    "-->",
                    "'",
                    "<",
                    ">",
                    '"',
                    '&',
                    '$',
                    '=',
                    ';',
                    '?',
                    '/',
                    "%20",
                    "%22",
                    "%3c", // <
                    "%253c", // <
                    "%3e", // >
                    "%0e", // >
                    "%28", // (
                    "%29", // )
                    "%2528", // (
                    "%26", // &
                    "%24", // $
                    "%3f", // ?
                    "%3b", // ;
                    "%3d"  // =
                );

                $nombreArchivo = str_replace($caracteres, '', $nombre);
                $nombreArchivo = stripslashes($nombreArchivo);

                $config = array(
                    'upload_path' => 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo,
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'file_name' => $nombreArchivo,
                    'max_size' => '10240'
                );
                $this->upload->initialize($config);

                if ($this->upload->do_upload('imagen')) {
                    $vehiculo = $this->usuario_model->dar_usuario_vehiculo($id_usuario_vehiculo);
                    $this->usuario_model->eliminar_usuario_vehiculo_imagen($id_usuario_vehiculo);
                    if ($vehiculo->imagen_thumb_url != '' || $vehiculo->imagen_thumb_url != NULL) {
                        unlink($vehiculo->imagen_url);
                        unlink($vehiculo->imagen_thumb_url);
                    }
                    $imagen = $this->upload->data();

                    $this->load->library('image_lib');
                    $config = array(
                        'source_image' => $imagen['full_path'],
                        'quality' => '100%',
                        'new_image' => 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/thumb',
                        'width' => 99,
                        'height' => 99,
                        'master_dim' => 'width'
                    );
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $imagen_url = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
                    $imagen_thumb_url = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/thumb/' . $imagen['file_name'];
                    $this->usuario_model->actualizar_usuario_vehiculo_imagen_url($id_usuario_vehiculo, $imagen_url, $imagen_thumb_url);
                }
            }
            $this->_mi_cuenta('vehiculos');
        }
    }

    /**
     * Solicita las tareas para el vehículo
     * @param el id del vehículo del usuario
     * @return la lista de tareas del vehículo
     */
    function dar_tareas_vehiculo_ajax() {
        $id_usuario_vehiculo = $this->input->get_post('id_usuario_vehiculo', TRUE);
        $this->load->model('usuario_model');
        $tareas = $this->usuario_model->dar_tareas_vehiculo_usuario($id_usuario_vehiculo);
        echo json_encode($tareas);
    }

    /**
     * Solicita la última realización de la tarea
     * @return la fecha de la última realización, si no existe retorna 0000
     */
    function dar_ultima_realizacion_ajax() {
        $id_usuario_vehiculo = $this->input->get_post('id_usuario_vehiculo', TRUE);
        $id_tarea = $this->input->get_post('id_tarea', TRUE);
        $this->load->model('usuario_model');
        $tarea = $this->usuario_model->dar_tarea_realizada_vehiculo($id_usuario_vehiculo, $id_tarea);
        $fecha = false;
        if ($tarea) {
            $fecha = $tarea->ultima_fecha;
        }
        echo json_encode($tarea);
    }

    /**
     * Registra la última ves que se realizó una tarea para un carro dado
     */
    function registrar_ultima_realizacion_tarea_ajax() {
        $id_usuario_vehiculo = $this->input->get_post('id_usuario_vehiculo', TRUE);
        $id_tarea = $this->input->get_post('id_tarea', TRUE);

        $fecha = date("Y-m-d");
        $this->load->model('usuario_model');
        $id_tarea = $this->usuario_model->registrar_tarea_realizada_vehiculo($id_usuario_vehiculo, $id_tarea, $fecha);
        echo json_encode($id_tarea);
    }

    function eliminar_realizacion_tarea_ajax() {
        $id_registro = $this->input->get_post('id_registro', TRUE);
        $this->load->model('usuario_model');
        $result = $this->usuario_model->eliminar_tarea_realizada_vehiculo($id_registro);
        echo json_encode($result);
    }

    /**
     * Valida si NO existe un usuario
     * @return String-bool $existe_usuario true si no existe
     */
    function no_existe_usuario_ajax() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'usuario',
                'label' => 'usuario',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            echo 'false';
        else {
            $usuario = strtolower($this->input->post('usuario', TRUE));
            $resultado = $this->_no_existe_usuario($usuario);
            if ($resultado)
                echo 'true';
            else
                echo 'false';
        }
    }

    /**
     * Valida si NO existe un email
     * @return String-bool $existe_email true si no existe
     */
    function no_existe_email_ajax() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            echo 'false';
        else {
            $email = strtolower($this->input->post('email', TRUE));
            $resultado = $this->_no_existe_email($email);
            if ($resultado === true)
                echo 'true';
            else if($resultado === false)
                echo 'false';
        }
    }

    /**
     * Valida si NO existe un email
     * @return String-bool $existe_email true si no existe
     */
    function no_existe_email_CRM_ajax() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            echo 'false';
        else {
            $email = strtolower($this->input->post('email', TRUE));
            $resultado = $this->_no_existe_email_CRM($email);
            if ($resultado === true)
                echo 'true';
            else if($resultado === false)
                echo 'false';
        }
    }

    /**
     * Valida si NO existe un email
     * @return String-bool $existe_email true si no existe
     */
    function dar_usuario_CRM_ajax() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            echo 'false';
        else {
            $email = strtolower($this->input->post('email', TRUE));
            $resultado = $this->_dar_usuario_CRM($email);
            if ($resultado === true)
                echo 'true';
            else if($resultado === false)
                echo 'false';
            else
                echo json_encode($resultado);
        }
    }

    /**
     * Valida si existe un email
     * @return String-bool $existe_email false si no existe
     */
    function existe_email_ajax() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            echo 'false';
        else {
            $email = strtolower($this->input->post('email', TRUE));
            $resultado = $this->_no_existe_email($email);
            if ($resultado)
                echo 'false';
            else
                echo 'true';
        }
    }

    /**
     * Registra un nuevo usuario
     */
    function registrar_usuario() {
        $this->load->library('form_validation');
        $contrasena = $this->input->post('input_registrate_contrasena', TRUE);
        $reglas = array(
            array(
                'field' => 'input_registrate_nombre',
                'label' => 'nombres',
                'rules' => 'trim|required|xss_clean'
            )
            ,
            array(
                'field' => 'input_registrate_apellidos',
                'label' => 'apellidos',
                'rules' => 'trim|required|xss_clean'
            )
            ,
            array(
                'field' => 'ciudad_registrarse',
                'label' => 'ciudad',
                'rules' => 'trim|required|xss_clean'
            )
            ,
            array(
                'field' => 'input_registrate_usuario',
                'label' => 'usuario',
                'rules' => 'trim|required|callback__no_existe_usuario|xss_clean'
            )
            ,
            array(
                'field' => 'input_registrate_email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|callback__no_existe_email|xss_clean'
            )
            ,
            array(
                'field' => 'input_registrate_contrasena',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            )
            ,
            array(
                'field' => 'input_registrate_contrasena_repite',
                'label' => 'repita la contraseña',
                'rules' => 'trim|required|callback__verificar_contrasena[' . $contrasena . ']|xss_clean'
            )
            ,
            array(
                'field' => 'ckbox_registrate_chkbox',
                'label' => 'de aceptar los términos y condiciones',
                'rules' => 'trim|required|xss_clean'
            )
            ,
            array(
                'field' => 'vehiculo_id',
                'label' => 'Marca y línea de vehículo',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'id_vehiculos',
                'label' => 'Marca y línea de vehículo',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'captcha_registrarse',
                'label' => 'captcha',
                'rules' => 'trim|required|callback__verificar_captcha|xss_clean|numeric'
            ),
            array(
                'field' => 'input_registrate_placa',
                'label' => 'placa',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'select_registrate_kilometraje',
                'label' => 'kilometraje',
                'rules' => 'trim||required|xss_clean|numeric'
            )
        );
        $this->form_validation->set_rules($reglas);
        if (!$this->form_validation->run()) {
            $this->load->helper('captcha');
            $this->load->model('vehiculo_model');
            $data['allvehiculos'] = $this->vehiculo_model->dar_vehiculos();
            $index = 0;
            foreach ($data['allvehiculos'] as $vehiculo) {
                $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
                $data['allvehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
                $index++;
            }
            $config = array(
                'img_path' => 'resources/images/captcha/',
                'img_url' => base_url() . 'resources/images/captcha/',
                'length' => 4
            );
            $data['captcha'] = create_captcha($config);
            $this->usuario_model->agregar_captcha(round($data['captcha']['time']), $this->input->ip_address(), $data['captcha']['word']);
            $this->registrate(validation_errors('<div class="mensaje-error">', '</div>'));
        } else {
            $referenciado = "";
            if ($this->input->post('referenciado') == TRUE)
                $referenciado = $this->input->post('referenciado', TRUE);

            $this->load->model('usuario_model');
            $nombre = ucwords($this->input->post('input_registrate_nombre', TRUE));
            $apellidos = ucwords($this->input->post('input_registrate_apellidos', TRUE));
            $usuario = strtolower($this->input->post('input_registrate_usuario', TRUE));
            $email = strtolower($this->input->post('input_registrate_email', TRUE));
            $ciudad = $this->input->post('ciudad_registrarse', TRUE);
            $contrasena_simple = $this->input->post('input_registrate_contrasena', TRUE);
            $contrasena = sha1($this->input->post('input_registrate_contrasena', TRUE));
            $id_vehiculo = $this->input->post('vehiculo_id', TRUE);
            $kilometraje = $this->input->post('select_registrate_kilometraje', TRUE);
            $placa = $this->input->post('input_registrate_placa', TRUE);
            $id_usuario = $this->usuario_model->agregar_usuario($nombre, $apellidos, $usuario, $email, $contrasena, $ciudad, 30, $referenciado);



            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $vehiculo = split(' ', $this->input->post('id_vehiculos', TRUE), 2);

            if (sizeof($vehiculo) >= 2) {
                $this->load->model('usuario_model');
                $this->load->model('vehiculo_model');
                $this->load->helper('mail');

                if (is_numeric($id_usuario) && $this->vehiculo_model->existe_vehiculo($id_vehiculo))
                    $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $id_vehiculo, '', '', $kilometraje, '', $placa);
                else {
                    $existeVehiculo = $this->vehiculo_model->existe_vehiculo_marca_linea($vehiculo[0], $vehiculo[1]);
                    if ($existeVehiculo == false) {
                        $nuevoVehiculo = $this->vehiculo_model->agregar_vehiculo($vehiculo[0], $vehiculo[1]);
                        $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $nuevoVehiculo, '', '', $kilometraje, '', $placa);

                        $destinatario = new stdClass();
                        $destinatario->email = 'tallerenlinea@laspartes.com.co';
                        $destinatarios[] = $destinatario;
                        send_mail($destinatarios, "[LasPartes.com] Nuevo Carro", "", 'El vehiculo: ' . $this->input->post('id_vehiculos', TRUE) . ' con id_vehiculo: ' . $nuevoVehiculo . ' fue ingresada al sistema por el usuario: ' . strtolower($this->input->post('input_registrate_usuario', TRUE)) . ' con id_usuario: ' . $id_usuario);
                    } else {
                        $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $existeVehiculo->id_vehiculo, '', '', $kilometraje, '', $placa);
                    }
                }
                $resultado = $this->usuario_model->validar_usuario($usuario->email, $usuario->contrasena);

                // Enviar mail



                ob_start();
                $data1['usuario'] = $usuario;
                $this->load->view('emails/registro_correo_view', $data1);
                $contenidoHTML = ob_get_contents();
                ob_end_clean();
                ob_flush();
                $destinatarios = array();
                $destinatario = new stdClass();
                $destinatario->email = $email;
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = 'tallerenlinea@laspartes.com.co';
                $destinatarios[] = $destinatario;
                send_mail($destinatarios, "[LasPartes.com] Gracias por registrarte con nosotros", $contenidoHTML, "", $fileName);


                if (!$resultado) {
                    $data['error'] = 'Correo electrónico o contraseña inválidos.';
                    $this->_login($data);
                } else {
                    $url = base_url() . 'usuario';
                    echo "<script type='text/javascript'>top.location = '" . $url . "';</script>";
                }
            } else {
                $this->registrate('<div class="mensaje-error">Debes ingresar la marca y línea de tu vehículo</div>');
            }
        }
    }

    /**
     * Modifica el kilometraje del vehículo por ajax
     */
    function modificar_kilometraje_ajax() {
        $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo', TRUE);
        $kilometraje = $this->input->post('kilometraje', TRUE);
        $this->load->model('usuario_model');
        echo $this->usuario_model->modificar_kilometraje_vehiculo($id_usuario_vehiculo, $kilometraje);
    }

    /**
     * Modifica la placa del vehículo por ajax
     */
    function modificar_placa_ajax() {
        $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo', TRUE);
        $placa = $this->input->post('placa', TRUE);
        $this->load->model('usuario_model');
        echo $this->usuario_model->modificar_placa_vehiculo($id_usuario_vehiculo, $placa);
    }

    /**
     * Registra un nuevo usuario por ajax
     */
    function registrar_usuario_ajax() {
        $this->load->library('form_validation');
        $contrasena = $this->input->post('input_registrate_contrasena', TRUE);
        $reglas = array(
            array(
                'field' => 'input_registrate_nombre',
                'label' => 'Nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'input_registrate_apellidos',
                'label' => 'Apellidos',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'ciudad_registrarse',
                'label' => 'Ciudad',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'input_registrate_telefono',
                'label' => 'Telefono',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'input_registrate_email',
                'label' => 'Correo electrónico',
                'rules' => 'trim|required|valid_email|callback__no_existe_email_CRM|xss_clean'
            ),
            array(
                'field' => 'input_registrate_contrasena',
                'label' => 'Contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'input_registrate_contrasena_repite',
                'label' => 'repita la contraseña',
                'rules' => 'trim|required|callback__verificar_contrasena[' . $contrasena . ']|xss_clean'
            ),
            array(
                'field' => 'ckbox_registrate_chkbox',
                'label' => 'de aceptar los términos y condiciones',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'captcha_registrarse',
                'label' => 'captcha',
                'rules' => 'trim|required|callback__verificar_captcha|xss_clean|numeric'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => false, 'msg' => validation_errors()));
        } else {
            $referenciado = "";
            if ($this->input->post('referenciado') == TRUE)
                $referenciado = $this->input->post('referenciado', TRUE);

            $this->load->model('usuario_model');
            $nombre = $this->input->post('input_registrate_nombre', TRUE);
            $apellidos = $this->input->post('input_registrate_apellidos', TRUE);
            $email = strtolower($this->input->post('input_registrate_email', TRUE));
            list($usuario, $dominio) = split('@', $email);
            $this->load->model('usuario_model');
            $existeEmail = $this->usuario_model->existe_email_usuario_Referencia_CRM($email);
            if($existeEmail !== false && $existeEmail !== true){
                $usuarioPrecreado = $existeEmail;
                $id_usuario = $usuarioPrecreado->id_usuario; 
            }

            $existe = $this->usuario_model->existe_usuario_Referencia_CRM($usuario);
            if ($existe === true)
                $usuario = $this->_generar_usuario($usuario);
            
                
            $telefono = $this->input->post('input_registrate_telefono', TRUE);
            $ciudad = $this->input->post('ciudad_registrarse', TRUE);
            $contrasena_simple = $this->input->post('input_registrate_contrasena', TRUE);
            $contrasena = sha1($this->input->post('input_registrate_contrasena', TRUE));
            if(isset($usuarioPrecreado)){
                $this->usuario_model->actualizar_usuario($usuarioPrecreado->id_usuario, $usuarioPrecreado->usuario, $nombre, $apellidos, $email, $ciudad, 'CRM_Activo', 'Activo');
                $this->usuario_model->actualizar_usuario_contrasena($id_usuario, $contrasena);
            }else
                $id_usuario = $this->usuario_model->agregar_usuario($nombre, $apellidos, $usuario, $email, $contrasena, $ciudad, 30, $referenciado, "Colombia", $telefono);

            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $this->load->model('usuario_model');

            $this->load->helper('mail');


            $resultado = $this->usuario_model->validar_usuario($usuario->email, $usuario->contrasena);

            // Enviar mail
            ob_start();
            $data1['usuario'] = $usuario;
            $this->load->view('emails/registro_correo_view', $data1);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();

            $destinatario = new stdClass();
            $destinatario->email = $email;
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = 'tallerenlinea@laspartes.com.co';
            $destinatarios[] = $destinatario;
            send_mail($destinatarios, "[LasPartes.com] Gracias por registrarte con nosotros", $contenidoHTML, "", $fileName);

            if (!$resultado)
                echo json_encode(array('status' => false, 'msg' => '*Se generó un error en el registro'));
            else {
                echo json_encode(array('status' => true, 'msg' => $this->session->userdata('id_usuario')));
            }
        }
    }

    /**
     * Genera un usuario aleatorio a partir del usuario dado
     * @param type $usuario
     */
    function _generar_usuario($usuario) {
        $this->load->model('usuario_model');
        $code = md5(uniqid(rand(), true));
        $code = substr($code, 0, 5);

        $existe = $this->usuario_model->existe_usuario($usuario);
        if (!$existe)
            return $usuario;
        else
            return $this->_generar_usuario($usuario . $code);
    }

    /**
     * Valida el correo electrónico y contraseña para iniciar sesión
     */
    function validar_usuario() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'contrasena',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            $this->_login(NULL);
        else {
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email', TRUE));
            $contrasena = sha1($this->input->post('contrasena', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);

            if (!$resultado) {
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $this->_login($data);
            } else {
                $this->_login(NULL);
            }
        }
    }

    /**
     * Valida el correo electrónico y contraseña para iniciar sesión
     * @return String-bool true si es correcto el correo electrónico y contraseña
     */
    function validar_usuario_ajax() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'contrasena',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => false, 'msg' => validation_errors()));
        } else {
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email', TRUE));
            $contrasena = sha1($this->input->post('contrasena', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);

            if (!$resultado)
                echo json_encode(array('status' => false));
            else {
                echo json_encode(array('status' => true, 'msg' => $this->session->userdata('id_usuario')));
            }
        }
    }

    /**
     * Envía una sugerencia al correo de laspartes
     * @return String-bool success si es correcto el correo electrónico y contraseña
     */
    function hacer_sugerencia() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'asunto',
                'label' => 'asunto',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'mensaje',
                'label' => 'mensaje',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            echo 'false';
        else {
            $email = strtolower($this->input->post('email', TRUE));
            $asunto = $this->input->post('asunto', TRUE);
            $sugerencia = $this->input->post('mensaje', TRUE);

            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
            $this->email->cc($email);
            $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
            $this->email->subject('[Las Partes] Sugerencia');
            $this->email->message('
                Muchas gracias por contar con <a href="' . base_url() . '">Laspartes.com.co</a><br />
                <br />
                Agradecemos nos haya contactado para la siguiente sugerencia:
                <br />
                <br />
                Asunto: ' . $asunto . '<br />
                Sugerencia: ' . $sugerencia . '
                <br />
                <br />
                Cordialmente,<br />
                -------------------------------------------------------<br />
                Servicio al cliente<br />
                <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
                
            ');
            $this->email->send();
            echo 'success';
        }
    }

    /**
     * Valida el correo electrónico y contraseña para iniciar sesión
     * Redirecciona a la URL indicada
     */
    function validar_usuario_redireccionar() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'contrasena',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'redireccionar',
                'label' => 'redireccionar',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            $this->_login(NULL);
        else {
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email', TRUE));
            $contrasena = sha1($this->input->post('contrasena', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);
            if (!$resultado) {
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $this->_login($data);
            } else {
                $redireccionar = $this->input->post('redireccionar', TRUE);
                redirect(base_url() . $redireccionar, 'refresh');
            }
        }
    }

    /**
     * registra los datos de envía en la tabla de carritos compras 
     */
    function registrar_datos_envio_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'emailComprador',
                    'label' => 'correo electrónico',
                    'rules' => 'trim|required|valid_email|xss_clean'
                ),
                array(
                    'field' => 'nombreComprador',
                    'label' => 'Nombres y apellidos',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'ciudadEnvio',
                    'label' => 'Ciudad de envío',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'direccionEnvio',
                    'label' => 'Dirección de envío',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'telefonoMovil',
                    'label' => 'Teléfono de contacto',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'refVenta',
                    'label' => 'Referencia de venta',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'di',
                    'label' => 'Identificación',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'carro',
                    'label' => 'Marca y línea de vehículo',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'placa',
                    'label' => 'Número de placa',
                    'rules' => 'trim|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run())
                echo validation_errors();
            else {
                $this->load->model('usuario_model');
                $this->load->model('refventa_model');
                $this->load->model('autoparte_model');
                $this->load->model('promocion_model');
                $email = strtolower($this->input->post('emailComprador', TRUE));
                $solicitud_nombres = $this->input->post('nombreComprador', TRUE);
                $ciudad_registrarse = $this->input->post('ciudadEnvio', TRUE);
                $direccion = $this->input->post('direccionEnvio', TRUE);
                $telefonoMovil = $this->input->post('telefonoMovil', TRUE);
                $refVenta = $this->input->post('refVenta', TRUE);
                $di = $this->input->post('di', TRUE);
                $carro = $this->input->post('carro', TRUE);
                $placa = $this->input->post('placa', TRUE);
                $total = 0;
                foreach ($this->cart->contents() as $item):
                    if ($item['name'] == 'autoparte') {
                        $autoparteModel = $this->autoparte_model->dar_autoparte_establecimiento_primero($item['id']);
                        $total += $autoparteModel->precio * $item['qty'];
                    } else if ($item['name'] == 'oferta') {
                        $ofertamodel = $this->promocion_model->dar_oferta($item['id']);
                        if ($ofertamodel->dco_feria != 0):
                            $precio = $ofertamodel->precio;
                            $iva = round($ofertamodel->iva);
                            $dco = $ofertamodel->dco_feria;
                            $base = $precio - $iva;
                            $ivaPorce = $iva / $base;
                            $valorDco = $base * ((100 - $dco) / 100);
                            $precionConDco = ($valorDco * (1 + $ivaPorce));
                            $total += ($precionConDco * $item['qty']);
                        else:
                            $total += ($ofertamodel->precio * $item['qty']);
                        endif;
                    }
                endforeach;

                $ids_usuario = $this->session->userdata('id_usuario');
                $usuario = $this->usuario_model->dar_usuario($ids_usuario);
                $id_carrito = $this->usuario_model->agregar_carrito_compras($usuario->id_usuario, 'no pago', round($total), $solicitud_nombres, $ciudad_registrarse, $telefonoMovil, $direccion, $email, $di, $carro, $placa);
                $this->refventa_model->agregar_RefVenta($refVenta, $id_carrito);
                foreach ($this->cart->contents() as $item):
                    if ($item['name'] == 'autoparte') {
                        $autoparteModel = $this->autoparte_model->dar_autoparte_establecimiento($item['id'], $item['id_establecimiento']);
                        $usuario = $this->usuario_model->agregar_carrito_compras_articulo($id_carrito, $autoparteModel->id_establecimiento, $autoparteModel->id_autoparte, $autoparteModel->precio, $item['qty'], $autoparteModel->descripcion);
                    } else if ($item['name'] == 'oferta') {
                        $this->usuario_model->agregar_carrito_compras_ofertas($id_carrito, $item['id'], $item['qty']);
                    }
                endforeach;
                echo 'true';
            }
        }
    }

    /**
     * Muestra el formulario con los datos de envío del carrito de compras 
     */
    function datos_envio() {
        if ($this->hay_sesion_activa()) {
            $this->load->model('usuario_model');
            $this->load->model('autoparte_model');
            $this->load->model('promocion_model');
            $data['usuario'] = $this->usuario_model->dar_usuario($this->session->userdata('id_usuario'));
            $vehiculos = $this->usuario_model->dar_vehiculos_usuario($data['usuario']->id_usuario);
            $data['vehiculo'] = $vehiculos[0];
            $valorSum = 0;
            $ivaSum = 0;
            foreach ($this->cart->contents() as $item) {
                if ($item['name'] == 'oferta') {
                    $this->load->model('promocion_model');
                    $oferta = $this->promocion_model->dar_oferta($item['id']);
                    $ofertatemp = new stdClass();
                    $ofertatemp->id = $oferta->id_oferta;
                    $ofertatemp->titulo = $oferta->titulo;
                    $ofertatemp->contenido = $oferta->incluye;
                    $ofertatemp->dco_feria = $oferta->dco_feria;
                    $ofertatemp->qty = $item['qty'];
                    $ofertatemp->rowid = $item['rowid'];
                    $ofertatemp->url = base_url() . 'promociones/' . $ofertatemp->id . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $ofertatemp->titulo);
                    if ($oferta->dco_feria != 0):
                        $precio = $oferta->precio;
                        $iva = round($oferta->iva);
                        $dco = $oferta->dco_feria;
                        $base = $precio - $iva;
                        $ivaPorce = $iva / $base;
                        $valorDco = $base * ((100 - $dco) / 100);
                        $precionConDco = ($valorDco * (1 + $ivaPorce));
                        $ofertatemp->iva = round($precionConDco - $valorDco);
                        $ofertatemp->precio = round($precionConDco);
                        $precioTotal += ($ofertatemp->precio * $ofertatemp->qty);
                        $ivaTotal += ($ofertatemp->iva * $ofertatemp->qty);
                    else:
                        $ofertatemp->iva = $oferta->iva;
                        $ofertatemp->precio = $oferta->precio;
                        $precioTotal += ($ofertatemp->precio * $ofertatemp->qty);
                        $ivaTotal += ($ofertatemp->iva * $ofertatemp->qty);
                    endif;
                    $items[] = $ofertatemp;
                }else if ($item['name'] == 'autoparte') {
                    $this->load->model('autoparte_model');
                    $autoparte_establecimiento = $this->autoparte_model->dar_autoparte_establecimiento($item['id'], $item['id_establecimiento']);
                    $autopartetemp = new stdClass();
                    $autopartetemp->id = $autoparte_establecimiento->id_autoparte;
                    $autopartetemp->titulo = $autoparte_establecimiento->nombre;
                    $autopartetemp->contenido = $autoparte_establecimiento->descripcion;
                    $autopartetemp->qty = $item['qty'];
                    $autopartetemp->rowid = $item['rowid'];
                    $autopartetemp->precio = $autoparte_establecimiento->precio;
                    $autopartetemp->iva = round($autoparte_establecimiento->precio - ($autoparte_establecimiento->precio / 1.16));
                    $precioTotal += round($autopartetemp->precio * $autopartetemp->qty);
                    $ivaTotal += round($autopartetemp->iva * $autopartetemp->qty);
                    $autopartetemp->url = base_url() . 'autopartes/' . $autopartetemp->id . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $autopartetemp->titulo);
                    $items[] = $autopartetemp;
                }
            } 
            
            $data['items'] = $items;
            $valorSum = round($precioTotal);
            $data['valor'] = $valorSum;
            $data['iva'] = round($ivaTotal);
            $data['baseDevolucionIva'] = $precioTotal - $ivaTotal;
            $llave_encripcion = "13733cb5a73";
            $urlPagosOnline = "https://gateway.pagosonline.net/apps/gateway/index.html"; //https://gateway.pagosonline.net/apps/gateway/index.html para produccion
            $usuarioId = 84442;
            $refVenta = 0;
            $this->load->model('refventa_model');
            $refVenta = $this->refventa_model->generar_RefVenta_Unico();
            $descripcion = "Compra de servicios";

            //campos adicionales
            $this->load->model('usuario_model');
            $idUsuario = $this->session->userdata('id_usuario');
            $usuario = $this->usuario_model->dar_usuario($idUsuario);
            $emailComprador = $usuario->email;
            $prueba = 1;
            if(ENVIRONMENT == 'production')
                $prueba = 0; //0 para produccion
            $moneda = "COP";
            $url_respuesta = base_url() . "usuario/pago_confirmacion";
            $url_confirmacion = base_url() . "usuario/confirmacion_pol";

            
            $firma_cadena = "$llave_encripcion~$usuarioId~$refVenta~$valorSum~$moneda"; //concatenación para realizar la firma
            $firma = md5($firma_cadena);

            $data['urlPagosOnline'] = $urlPagosOnline;
            $data['usuarioId'] = $usuarioId;
            $data['refVenta'] = $refVenta;
            $data['descripcion'] = $descripcion;
            $data['emailComprador'] = $emailComprador;
            $data['prueba'] = $prueba;
            $data['moneda'] = $moneda;
            $data['url_respuesta'] = $url_respuesta;
            $data['firma'] = $firma;
            $data['url_confirmacion'] = $url_confirmacion;
            $data['titulo'] = 'Laspartes.com: Carrito de Compras';
            $data['header_view'] = 'usuario/header/datos_envio_view';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="' . base_url() . 'carrito">Mi carrito</a></div> <div class="div-breadcrumb-espaciador"></div>Datos de envío';
            $data['navegacion_view'] = 'micarrito';
            $data['contenido_view'] = 'usuario/datos_envio_view';
            $this->load->view('template/template', $data);
        } else {
            redirect('carrito');
        }
    }

    /**
     * Muestra el carrito de compras de la sesión actual
     */
    function ver_carrito_compras($mensaje = '') {
        foreach ($this->cart->contents() as $item) {
            if ($item['name'] == 'oferta') {
                $this->load->model('promocion_model');
                $oferta = $this->promocion_model->dar_oferta($item['id']);
                $ofertatemp = new stdClass();
                $ofertatemp->id = $oferta->id_oferta;
                $ofertatemp->titulo = $oferta->titulo;
                $ofertatemp->contenido = $oferta->incluye;
                $ofertatemp->dco_feria = $oferta->dco_feria;
                $ofertatemp->qty = $item['qty'];
                $ofertatemp->rowid = $item['rowid'];
                $ofertatemp->url = base_url() . 'promociones/' . $ofertatemp->id . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $ofertatemp->titulo);
                if ($oferta->dco_feria != 0):
                    $precio = $oferta->precio;
                    $iva = round($oferta->iva);
                    $dco = $oferta->dco_feria;
                    $base = $precio - $iva;
                    $ivaPorce = $iva / $base;
                    $valorDco = $base * ((100 - $dco) / 100);
                    $precionConDco = ($valorDco * (1 + $ivaPorce));
                    $ofertatemp->iva = round($precionConDco - $valorDco);
                    $ofertatemp->precio = round($precionConDco);
                    $precioTotal += ($ofertatemp->precio * $ofertatemp->qty);
                    $ivaTotal += ($ofertatemp->iva * $ofertatemp->qty);
                else:
                    $ofertatemp->iva = $oferta->iva;
                    $ofertatemp->precio = $oferta->precio;
                    $precioTotal += ($ofertatemp->precio * $ofertatemp->qty);
                    $ivaTotal += ($ofertatemp->iva * $ofertatemp->qty);
                endif;
                $items[] = $ofertatemp;
            }else if ($item['name'] == 'autoparte') {
                $this->load->model('autoparte_model');
                $autoparte_establecimiento = $this->autoparte_model->dar_autoparte_establecimiento($item['id'], $item['id_establecimiento']);
                $autopartetemp = new stdClass();
                $autopartetemp->id = $autoparte_establecimiento->id_autoparte;
                $autopartetemp->titulo = $autoparte_establecimiento->nombre;
                $autopartetemp->contenido = $autoparte_establecimiento->descripcion;
                $autopartetemp->qty = $item['qty'];
                $autopartetemp->rowid = $item['rowid'];
                $autopartetemp->precio = $autoparte_establecimiento->precio;
                $autopartetemp->iva = round($autoparte_establecimiento->precio - ($autoparte_establecimiento->precio / 1.16));
                $precioTotal += round($autopartetemp->precio * $autopartetemp->qty);
                $ivaTotal += round($autopartetemp->iva * $autopartetemp->qty);
                $autopartetemp->url = base_url() . 'autopartes/' . $autopartetemp->id . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $autopartetemp->titulo);
                $items[] = $autopartetemp;
            }
        }
        $data['items'] = $items;
        $data['precio'] = round($precioTotal);
        $data['iva'] = round($ivaTotal);
        $data['base'] = $precioTotal - $ivaTotal;

        $data['metaDescripcion'] = 'Compra en línea los repuestos que necesites de manera rápida y segura. Envíos a todo el país';
        $data['titulo'] = 'Laspartes.com: Carrito de Compras';
        $data['header_view'] = 'usuario/header/carrito_compras_lista_view';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div><div>Carrito de Compras</div>';
        $data['navegacion_view'] = 'micarrito';
        $data['contenido_view'] = 'usuario/carrito_compras_lista_view';


        if ($mensaje != '')
            $data['error'] = $mensaje;
        $this->load->view('template/template', $data);
    }

    /**
     * Le presenta al usuario la página de confirmación de pago 
     */
    function respuesta_de_pago() {
        $llave = "13733cb5a73"; /////llave de usuario de pruebas 2
        $uri = $_SERVER['REQUEST_URI'];
        list($ur, $usu, $datos) = split('/', $uri);
        $uri = $datos;
        list($l1, $l2) = split('\?', $uri);
        $uri = $l2;
        $array = split('&', $uri);
        $valores = array();
        foreach ($array as $row) {
            list($val1, $val2) = split('=', $row);
            $valores[$val1] = $val2;
        }
        $usuario_id = $valores[usuario_id];
        $ref_venta = $valores[ref_venta];
        $valor = $valores[valor];
        $moneda = $valores[moneda];
        $estado_pol = $valores[estado_pol];
        $firma_cadena = "$llave~$usuario_id~$ref_venta~$valor~$moneda~$estado_pol";
        $firmacreada = md5($firma_cadena); //firma que generaron ustedes
        $firma = $valores[firma]; //firma que envía nuestro sistema
        $fecha_procesamiento = $valores[fecha_procesamiento];
        $ref_pol = $valores[ref_pol];
        $cus = $valores[cus];
        $banco_pse = $valores[banco_pse];
        if ($estado_pol == 6) {
            //transacción fallida
            $data['respuesta'] = "Transacci&oacute;n fallida!";
            $data['mensaje'] = "El pago no se debito de tu cuenta vuelve a intentar hacer la compra por favor.";
            $this->load->view('POL/respuesta_POL1', $data);
        } else if ($estado_pol == 12) {
            $estadoTx = "";
            //transaccion pendiente
            $data['respuesta'] = "Tu transacci&oacute;n se encuentra pendiente!";
            $data['mensaje'] = "Pendiente, Por favor revisar si el d&eacute;bito fue realizado en el Banco";
            $this->load->view('POL/respuesta_POL1', $data);
        } else if ($estado_pol == 4) {
            //transaccion aprobada
            $data['respuesta'] = "Felicitaciones tu transacci&oacute;n ha sido Aprobada!";
            $data['mensaje'] = "El pago fue debitado de tu cuenta, dentro de poco nos comunicaremos contigo para concretar la entrega del producto.";
            $this->load->view('POL/respuesta_POL1', $data);
        } else if ($estado_pol == 6) {
            //transacción en validacion
            $data['respuesta'] = "Tu transacción se encuentra en validación!";
            $data['mensaje'] = "Tu pago está siendo confirmado para procesar tu orden no intentes hacer la compra por el mismo producto hasta que recibas un correo con el estado de la transacción.";
            $this->load->view('POL/respuesta_POL1', $data);
        } else {
            //transacción en validacion
            $data['respuesta'] = "Tu transacción no se pudo realizar!";
            $data['mensaje'] = "El pago no se debito de tu cuenta vuelve a intentar hacer la compra por favor.";
            $this->load->view('POL/respuesta_POL1', $data);
        }
    }

    /**
     * Le presenta al usuario la página de confirmación de pago 
     */
    function pago_confirmacion() {
        $llave = "13733cb5a73";
        $uri = $_SERVER['REQUEST_URI']; 
        list($ur, $usu, $datos) = split('/', $uri);
        $uri = $datos;
        list($l1, $l2) = split('\?', $uri);
        $uri = $l2;
        $array = split('&', $uri);
        $valores = array();
        foreach ($array as $row) {
            list($val1, $val2) = split('=', $row);
            $valores[$val1] = $val2;
        }
        $usuario_id = $valores[usuario_id];
        $ref_venta = $valores[ref_venta];
        $valor = $valores[valor];
        $moneda = $valores[moneda];
        $estado_pol = $valores[estado_pol];
        $firma_cadena = "$llave~$usuario_id~$ref_venta~$valor~$moneda~$estado_pol";
        $firmacreada = md5($firma_cadena); //firma que generaron ustedes
        $firma = $valores[firma]; //firma que envía nuestro sistema
        $fecha_procesamiento = $valores[fecha_procesamiento];
        $ref_pol = $valores[ref_pol];
        $cus = $valores[cus];
        $banco_pse = $valores[banco_pse];
        if ($estado_pol == 6) {
            //transacción fallida
            $data['respuesta'] = "Transacci&oacute;n fallida!";
            $data['mensaje'] = "El pago no se debito de tu cuenta vuelve a intentar hacer la compra por favor.";
        } else if ($estado_pol == 12) {
            $estadoTx = "";
            //transaccion pendiente
            $data['respuesta'] = "Tu transacci&oacute;n se encuentra pendiente!";
            $data['mensaje'] = "Pendiente, Por favor revisar si el d&eacute;bito fue realizado en el Banco";
        } else if ($estado_pol == 4) {
            //transaccion aprobada
            $data['respuesta'] = "Felicitaciones tu transacci&oacute;n ha sido Aprobada!";
            $data['mensaje'] = "El pago fue debitado de tu cuenta, dentro de poco nos comunicaremos contigo para concretar la entrega del producto.";
        } else if ($estado_pol == 7) {
            //transacción en validacion
            $data['respuesta'] = "Tu transacción se encuentra en validación!";
            $data['mensaje'] = "Tu pago está siendo confirmado para procesar tu orden no intentes hacer la compra por el mismo producto hasta que recibas un correo con el estado de la transacción.";
        } else {
            //transacción en validacion
            $data['respuesta'] = "Tu transacción no se pudo realizar!";
            $data['mensaje'] = "El pago no se debito de tu cuenta vuelve a intentar hacer la compra por favor.";
        }
        foreach ($this->cart->contents() as $item) {
            if ($item['name'] == 'oferta') {
                $this->load->model('promocion_model');
                $oferta = $this->promocion_model->dar_oferta($item['id']);
                $ofertatemp = new stdClass();
                $ofertatemp->id = $oferta->id_oferta;
                $ofertatemp->titulo = $oferta->titulo;
                $ofertatemp->contenido = $oferta->incluye;
                $ofertatemp->dco_feria = $oferta->dco_feria;
                $ofertatemp->qty = $item['qty'];
                $ofertatemp->rowid = $item['rowid'];
                $ofertatemp->url = base_url() . 'promociones/' . $ofertatemp->id . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $ofertatemp->titulo);
                if ($oferta->dco_feria != 0):
                    $precio = $oferta->precio;
                    $iva = round($oferta->iva);
                    $dco = $oferta->dco_feria;
                    $base = $precio - $iva;
                    $ivaPorce = $iva / $base;
                    $valorDco = $base * ((100 - $dco) / 100);
                    $precionConDco = ($valorDco * (1 + $ivaPorce));
                    $ofertatemp->iva = round($precionConDco - $valorDco);
                    $ofertatemp->precio = round($precionConDco);
                    $precioTotal += ($ofertatemp->precio * $ofertatemp->qty);
                    $ivaTotal += ($ofertatemp->iva * $ofertatemp->qty);
                else:
                    $ofertatemp->iva = $oferta->iva;
                    $ofertatemp->precio = $oferta->precio;
                    $precioTotal += ($ofertatemp->precio * $ofertatemp->qty);
                    $ivaTotal += ($ofertatemp->iva * $ofertatemp->qty);
                endif;
                $items[] = $ofertatemp;
            }else if ($item['name'] == 'autoparte') {
                $this->load->model('autoparte_model');
                $autoparte_establecimiento = $this->autoparte_model->dar_autoparte_establecimiento($item['id'], $item['id_establecimiento']);
                $autopartetemp = new stdClass();
                $autopartetemp->id = $autoparte_establecimiento->id_autoparte;
                $autopartetemp->titulo = $autoparte_establecimiento->nombre;
                $autopartetemp->contenido = $autoparte_establecimiento->descripcion;
                $autopartetemp->qty = $item['qty'];
                $autopartetemp->rowid = $item['rowid'];
                $autopartetemp->precio = $autoparte_establecimiento->precio;
                $autopartetemp->iva = round($autoparte_establecimiento->precio - ($autoparte_establecimiento->precio / 1.16));
                $precioTotal += round($autopartetemp->precio * $autopartetemp->qty);
                $ivaTotal += round($autopartetemp->iva * $autopartetemp->qty);
                $autopartetemp->url = base_url() . 'autopartes/' . $autopartetemp->id . '-' . preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $autopartetemp->titulo);
                $items[] = $autopartetemp;
            }
        }
        $data['items'] = $items;
        $data['precio'] = round($precioTotal);
        $data['iva'] = round($ivaTotal);
        $data['base'] = $precioTotal - $ivaTotal;
        $data['titulo'] = 'Laspartes.com: Confirmación de pago';
        $data['header_view'] = 'POL/header/respuesta_POL';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="' . base_url() . 'carrito">Mi carrito</a></div> <div class="div-breadcrumb-espaciador"></div>Confirmación de pago';
        $data['navegacion_view'] = 'micarrito';
        $data['contenido_view'] = 'POL/respuesta_POL';
        $this->load->view('template/template', $data);
    }

    /**
     * Función para realizar la confirmación de pago en el servidor
     */
    function confirmacion_pol() {
        $llave = "13733cb5a73"; /////llave de usuario de pruebas 2
        $usuario_id = $_REQUEST['usuario_id'];
        $ref_venta = $_REQUEST['ref_venta'];
        $valor = $_REQUEST['valor'];
        $moneda = $_REQUEST['moneda'];
        $estado_pol = $_REQUEST['estado_pol'];
        $firma_cadena = "$llave~$usuario_id~$ref_venta~$valor~$moneda~$estado_pol";
        $firmacreada = md5($firma_cadena); //firma que generaron ustedes
        $firma = $_REQUEST['firma']; //firma que envía nuestro sistema
        $ref_venta = $_REQUEST['ref_venta'];
        $fecha_procesamiento = $_REQUEST['fecha_procesamiento'];
        $ref_pol = $_REQUEST['ref_pol'];
        $codigo_respuesta = $_REQUEST['codigo_respuesta_pol'];
        $cus = $_REQUEST['cus'];
        $extra1 = $_REQUEST['extra1'];
        $banco_pse = $_REQUEST['banco_pse'];
        $estadoTx = "";
        if (strtoupper($firma) == strtoupper($firmacreada)) {//comparacion de las firmas para comprobar que los datos si vienen de Pagosonline
            $this->load->model('refventa_model');
            $this->load->model('usuario_model');
            $this->load->model('generico_model');

            $id_carrito_compra = $this->refventa_model->dar_Venta($ref_venta)->id_carrito_compra;
            if ($_REQUEST['estado_pol'] == 6) {
                $estadoTx = "Transacción fallida";
                $this->usuario_model->actualizar_carrito_compra($id_carrito_compra, $estadoTx);
                $this->_generar_factura($ref_venta, "error", $estadoTx . $estadoTx . ' Estado pol: ' . $_REQUEST['estado_pol'] . ' codigo de respuesta: ' . $_REQUEST['codigo_respuesta_pol']);
            } else if ($_REQUEST['estado_pol'] == 12) {
                $estadoTx = "Pendiente, Por favor revisar si el débito fue realizado en el Banco";
                $this->usuario_model->actualizar_carrito_compra($id_carrito_compra, $estadoTx);
                $this->_generar_factura($ref_venta, "error", $estadoTx . ' Estado pol: ' . $_REQUEST['estado_pol'] . ' codigo de respuesta: ' . $_REQUEST['codigo_respuesta_pol']);
            } else if ($_REQUEST['estado_pol'] == 4) {
                $estadoTx = "Transacción aprobada";
                $this->usuario_model->actualizar_carrito_compra($id_carrito_compra, $estadoTx);
                $this->refventa_model->actualizar_referencia_ventaPOL($ref_venta, $ref_pol);
                $this->_generar_factura($ref_venta, "email", $estadoTx);
            } else {
                $estadoTx = $_REQUEST['mensaje'];
                $this->usuario_model->actualizar_carrito_compra($id_carrito_compra, $estadoTx);
                $this->_generar_factura($ref_venta, "error", $estadoTx . $estadoTx . ' Estado pol: ' . $_REQUEST['estado_pol'] . ' codigo de respuesta: ' . $_REQUEST['codigo_respuesta_pol']);
            }
        }
    }

    /**
     * Muestra el formulario para recuperar la contraseña
     */
    function formulario_olvido_contrasena($mensaje = '') {
        $this->load->helper('captcha');
        $this->load->model('usuario_model');

        $config = array(
            'img_path' => 'resources/images/captcha/',
            'img_url' => base_url() . 'resources/images/captcha/' 
        );
        $data['captcha'] = create_captcha($config);
        $this->usuario_model->agregar_captcha(round($data['captcha']['time']), $this->input->ip_address(), $data['captcha']['word']);

        $data['titulo'] = 'Olvidé mi contraseña';
        $data['header_view'] = 'usuario/header/olvido_contrasena_view';
        $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="' . base_url() . 'usuario">Mi Cuenta</a></div> <div class="div-breadcrumb-espaciador"></div>Olvidé mi contraseña';
        $data['navegacion_view'] = 'micuenta';
        $data['contenido_view'] = 'usuario/olvido_contrasena_view';
        if ($mensaje != '')
            $data['confirmacion'] = $mensaje;
        $this->load->view('template/template', $data);
    }

    /**
     * Muestra el formulario para cambiar la contraseña en caso en el que el que el
     * código de activación sea válido
     * @param String $codigo_activacion
     */
    function formulario_cambiar_contrasena($codigo, $mensaje = '') {
        // Verificar el código de activación
        $codigo_activacion = $this->uri->segment(3);
        $this->load->model('usuario_model');
        $usuario = $this->usuario_model->dar_usuario_segun_codigo($codigo_activacion);
        if (!$usuario) {
            $this->formulario_olvido_contrasena();
        } else {
            // Mostrar el formulario de cambio de contraseña ya que el código de activación es correcto
            $data['id_usuario'] = $usuario->id_usuario;
            $data['codigo'] = $codigo_activacion;

            $data['titulo'] = 'Cambiar mi contraseña';
            $data['header_view'] = 'usuario/header/cambio_contrasena_view';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div><a href="' . base_url() . 'usuario/formulario_olvido_contrasena">Olvidé mi contraseña</a></div> <div class="div-breadcrumb-espaciador"></div>Cambiar contraseña';
            $data['navegacion_view'] = 'micuenta';
            $data['contenido_view'] = 'usuario/cambio_contrasena_view';
            if ($mensaje != '')
                $data['confirmacion'] = $mensaje;
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Cambia la contraseña del usuario
     */
    function cambio_contrasena() {
        $this->load->library('form_validation');
        $contrasena = $this->input->post('contrasena_registrarse', TRUE);
        $reglas = array(
            array(
                'field' => 'contrasena_registrarse',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'contrasena2_registrarse',
                'label' => 'repita la contraseña',
                'rules' => 'trim|required|callback__verificar_contrasena[' . $contrasena . ']|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            $this->formulario_cambiar_contrasena($this->input->post('codigo', TRUE), '<div class="mensaje-error">Los datos ingresados son incorrectos.</div>');
        else {
            // Cambiar la contraseña
            $this->load->model('usuario_model');


            $id_usuario = $this->input->post('id_usuario', TRUE);
            $contrasena_cifrada = sha1($this->input->post('contrasena_registrarse', TRUE));
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $this->usuario_model->actualizar_usuario_contrasena($id_usuario, $contrasena_cifrada);
            $this->usuario_model->actualizar_usuario_codigo_activacion($id_usuario, '');
            $this->usuario_model->actualizar_usuario_estado($id_usuario, 'Activo');

            $this->usuario_model->validar_usuario($usuario->email, $usuario->contrasena);
            
            ob_start();
            $data1['contrasena'] = $contrasena;
            $this->load->view('emails/cambiar_contrasena_view', $data1);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();

            $this->load->helper('mail');

            $destinatario = new stdClass();
            $destinatario->email = $usuario->email;
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = 'tallerenlinea@laspartes.com.co';
            $destinatarios[] = $destinatario;
            send_mail($destinatarios, "[Las Partes] Cambio de contraseña", $contenidoHTML, "", $fileName);


            $this->index();
        }
    }

    /**
     * Recupera la constraseña de un usuario. Pide el email y muestra un captcha
     */
    function olvido_contrasena() {
        $this->load->library('form_validation');


        $reglas = array(
            array(
                'field' => 'email_registrarse',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|callback__existe_email|xss_clean'
            ),
            array(
                'field' => 'captcha_registrarse',
                'label' => 'captcha',
                'rules' => 'trim|required|callback__verificar_captcha|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            $this->formulario_olvido_contrasena('<div class="mensaje-error">Los datos ingresados son incorrectos.</div>');
        } else {
            $this->load->model('usuario_model');

            $email = strtolower($this->input->post('email_registrarse', TRUE));

            // Desactivar usuario para que cambie su contrasena y generar el código de activación
            $usuario = $this->usuario_model->dar_usuario_segun_mail($email);
            $this->usuario_model->actualizar_usuario_estado($usuario->id_usuario, 'No Activo');
            $codigo_activacion = uniqid('CO', true);
            $link_seguro = base_url() . 'usuario/formulario_cambiar_contrasena/' . $codigo_activacion;
            $this->usuario_model->actualizar_usuario_codigo_activacion($usuario->id_usuario, $codigo_activacion);


            ob_start();
            $this->load->helper('date');
            $data1['link_seguro'] = $link_seguro;  
            $this->load->view('emails/recuperar_contrasena_view', $data1);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();

            $this->load->helper('mail');

            $destinatario = new stdClass();
            $destinatario->email = $email;
            $destinatarios[] = $destinatario;
            send_mail($destinatarios, "[Las Partes] Recuperar contraseña", $contenidoHTML, "", $fileName);


            // Mostrar que se envió el mail satisfactoriamente
            $this->formulario_olvido_contrasena('<div class="mensaje-ok">Las instrucciones para cambiar tu contraseña han sido enviadas a tu correo.</div>');
        }
    }

    /**
     * Muestra el formulario de reportar abuso usando ajax
     */
    function formulario_reportar_abuso_ajax() {
        $data['seccion'] = $this->uri->segment(3, '');
        $data['tipo'] = $this->uri->segment(4, '');
        $data['id'] = $this->uri->segment(5, '');

        $this->load->view('ajax/formulario_reporte_abuso_ajax_view', $data);
    }

    /**
     * Reporta el abuso de un comentario en el sitio
     */
    function reportar_abuso() {
        $this->load->library('form_validation');


        $reglas = array(
            array(
                'field' => 'seccion',
                'label' => 'seccion',
                'rules' => 'trim|xss_clean'
            ), array(
                'field' => 'tipo',
                'label' => 'tipo',
                'rules' => 'trim|required|xss_clean'
            ), array(
                'field' => 'id',
                'label' => 'id',
                'rules' => 'trim|required|xss_clean'
            ), array(
                'field' => 'motivo_reporte',
                'label' => 'motivo_reporte',
                'rules' => 'trim|required|xss_clean'
            ), array(
                'field' => 'comentarios_reporte',
                'label' => 'comentarios_reporte',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'captcha_registrarse',
                'label' => 'captcha',
                'rules' => 'trim|required|callback__verificar_captcha|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            echo validation_errors();
        else {
            $seccion = $this->input->post('seccion', TRUE);
            $tipo = $this->input->post('tipo', TRUE);
            $id = $this->input->post('id', TRUE);
            $motivo = $this->input->post('motivo_reporte', TRUE);
            $comentarios = $this->input->post('comentarios_reporte', TRUE);

            // Enviar mail
            $this->load->library('email');
            $this->email->from('no-responder@laspartes.com.co', 'LasPartes.com.co');
            $this->email->to('tallerenlinea@laspartes.com.co', 'LasPartes.com.co');
            $this->email->subject('[Las Partes] Reportar abuso');
            $this->email->message('
            Un usuario ha reportado el siguiente elemento:
            <br /><br />
            Motivo: ' . $motivo . '<br />
            Comentarios: ' . $comentarios . '<br />
            Secci&oacute;n: ' . $seccion . '<br />
            Tipo: ' . $tipo . '<br />
            Id: ' . $id . '<br />
            <br />
            <br />
            Cordialmente,<br />
            -------------------------------------------------------<br />
            Servicio al cliente<br />
            <a href="' . base_url() . '">Laspartes.com.co</a> - Todo para su vehículo
        ');
            $this->email->send();
            echo 'Tu reporte ha sido enviado';
        }
    }

    function registrate($mensaje = '') {
        if ($this->session->userdata('esta_registrado')) {
            $this->_mi_cuenta('vehiculos');
        } else {
            $this->load->helper('captcha');
            $this->load->model('usuario_model');
            $this->load->model('vehiculo_model');
            $data['fb_data'] = $this->session->userdata('fb_data');

            $data['allmarcas'] = $this->vehiculo_model->dar_vehiculos_marca();
            $index = 0;
            foreach ($data['allmarcas'] as $marca) {
                $data['allmarcas'][$index]->label = $marca->marca;
                $data['allmarcas'][$index]->value = $marca->marca;
                $index++;
            }
            $config = array(
                'img_path' => 'resources/images/captcha/',
                'img_url' => base_url() . 'resources/images/captcha/',
                'length' => 4
            );
            $data['captcha'] = create_captcha($config);
            $this->usuario_model->agregar_captcha(round($data['captcha']['time']), $this->input->ip_address(), $data['captcha']['word']);
            $data['titulo'] = 'Laspartes.com :: Registra tu vehíuculo';
            $data['header_view'] = 'login/header/formulario_view';
            $data['navegacion_view'] = 'registrate';
            $data['contenido_view'] = 'login/formulario_view';
            $data['show_login'] = true;
            if ($mensaje != '')
                $data['confirmacion'] = $mensaje;
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Este método devuelve el html correspondiente a las 5 preguntas que ha hecho 
     * el usuario siguientes al offset que llega por  POST. El método debe verificar que 
     * la sesión del usuario esté activa. Si no está activa, no devuelve nada. 
     * Recibe por POST el offset (offset), llama al método 
     * preguntas_model -> dar_preguntas_usuario($id_usuario, $offset) y con las 
     * preguntas que recibe las envía por parámetro ($preguntas) a la vista que 
     * se encarga de escribirlas en un div. 
     */
    function mostrar_mas_preguntas_perfil_ajax() {
        if ($this->hay_sesion_activa()) {
            $id_usuario = $this->input->get_post('id_usuario', TRUE);
            $offset = $this->input->get_post('offset', TRUE);
            $this->load->model('pregunta_model');
            $data['preguntas'] = $this->pregunta_model->dar_preguntas_usuario($id_usuario, $offset);
            $this->load->view('usuario/ajax/preguntas_listado_view', $data);
        }
    }

    /**
     *  Este método devuelve el html correspondiente a las 5 respuestas siguientes 
     * al offset que llega por POST. El método debe verificar que la sesión del usuario esté activa. 
     * Si no está activa, no devuelve nada. Recibe por POST el offset (offset), 
     * llama al método preguntas_model -> dar_preguntas_he_respondido($id_usuario, $offset) 
     * y con las preguntas que recibe las envía por parámetro ($preguntas) a la vista 
     * que se encarga de escribirlas en un div.  
     */
    function mostrar_mas_respuestas_perfil_ajax() {
        if ($this->hay_sesion_activa()) {
            $id_usuario = $this->input->get_post('id_usuario', TRUE);
            $offset = $this->input->get_post('offset', TRUE);
            $this->load->model('pregunta_model');
            $this->load->model('usuario_model');
            $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
            $data['respuestas'] = $this->pregunta_model->dar_preguntas_he_respondido($id_usuario, $offset);
            $this->load->view('usuario/ajax/respuestas_listado_view', $data);
        }
    }

    /**
     * Este método devuelve el html correspondiente a los 5 talleres que he 
     * calificado siguientes al offset que llega por POST. 
     * El  método debe verificar que la sesión del usuario esté activa. Si no está activa, 
     * no devuelve nada. Recibe por POST el offset (offset), llama al método 
     * establecimientos_model -> dar_talleres_he_calificado($id_usuario, $offset) 
     * y con  los talleres que recibe los envía por parámetro ($talleres) a la 
     * vista que se encarga de escribirlas en un div. 
     */
    function mostrar_mas_talleres_perfil_ajax() {
        if ($this->hay_sesion_activa()) {
            $id_usuario = $this->input->get_post('id_usuario', TRUE);
            $offset = $this->input->get_post('offset', TRUE);
            $this->load->model('establecimiento_model');
            $this->load->model('usuario_model');
            $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
            $data['establecimientos'] = $this->establecimiento_model->dar_talleres_he_calificado($id_usuario, $offset);
            $this->load->view('usuario/ajax/talleres_listado_view', $data);
        }
    }

    /**
     * Muestra las tareas de un vehículo y las compras que realizó un usuario
     * @return [type] [description]
     */
    function mostrar_vehiculo_tareas_ajax() {
        if ($this->hay_sesion_activa()) {
            $id_usuario = $this->input->get_post('id_vehiculo', TRUE);
            $id_usuario_vehiculo = $this->input->get_post('id_usuario_vehiculo', TRUE);

            $this->load->helper('date');
            $this->load->model('usuario_model');
            $this->load->model('establecimiento_model');
            $data['usuario'] = $this->usuario_model->dar_usuario($this->session->userdata('id_usuario'));
            setlocale(LC_ALL, 'es_ES');

            $kilometraje_ciudad = $this->usuario_model->dar_kilometraje_ciudad($data['usuario']->lugar);
            $data['kilometraje_ciudad'] = $kilometraje_ciudad;
            $vehiculos = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
            $data['vehiculos'] = $vehiculos;
            $vehiculoseleccionado = $this->usuario_model->dar_vehiculo($id_usuario_vehiculo);
            $data['vehiculoseleccionado'] = $vehiculoseleccionado;
            $tareas = array();
            
            $tareas_vehiculo = $this->_dar_tareas_vehiculo($vehiculoseleccionado, $kilometraje_ciudad);
            $tareas = $tareas_vehiculo;
            foreach ($tareas as $key => $tarea){
                
            }
            $data['tareas'] = $tareas;
            $data['items_compras'] = $this->usuario_model->dar_items_compra_usuario($this->session->userdata('id_usuario'));
            $this->load->view('usuario/ajax/sobre_mi_vehiculo_ajax', $data);
        }
    }

    /**
     * Este método devuelve la información de una oferta en un div html respectivo. 
     * El método debe verificar que la sesión del usuario esté activa. Si no está activa, 
     * no devuelve nada. Recibe por POST el id de la oferta (id_oferta). 
     */
    function mostrar_oferta_lightbox_ajax() {
        if ($this->hay_sesion_activa()) {
            $id_oferta = $this->input->get_post('id_oferta', TRUE);
            setlocale(LC_ALL, 'es_ES');
            $this->load->model('usuario_model');



            //----------------------
            $this->load->model('generico_model');
            $oferta = $this->generico_model->dar_tildes('oferta', 'id_oferta', $id_oferta);
            $valor = $oferta->precio;
            $descripcion = $this->fix_caracteres($oferta->titulo);
            $iva = $oferta->iva;
            $baseDevolucionIva = $valor - $iva;

            $data['valor'] = $valor;
            $data['iva'] = $iva;
            $data['baseDevolucionIva'] = $baseDevolucionIva;
            $data['firma'] = $firma;
            $data['usuarioId'] = $usuarioId;
            $data['descripcion'] = $descripcion;


            //-----------

            $data['oferta'] = $this->usuario_model->dar_oferta($id_oferta);
            $this->load->view('usuario/ajax/oferta_sencilla_view', $data);
        }
    }

    /**
     *  Este método devuelve el html correspondiente a las 6 ofertas siguientes 
     * al offset que llega por POST. El método debe verificar que la sesión del
     *  usuario esté activa. Si no está activa, no devuelve nada. 
     * Recibe por POST el offset (offset), llama al método 
     * usuario_model -> dar_ofertas_vigentes($id_usuario, $offset) y con las ofertas
     *  que recibe las envía por parámetro ($ofertas) a la vista que se encarga de escribirlas en un div
     */
    function mostrar_mas_ofertas_perfil_ajax() {
        if ($this->hay_sesion_activa()) {
            $offset = $this->input->get_post('offset', TRUE);
            $id_usuario = $this->input->get_post('id_usuario', TRUE);
            setlocale(LC_ALL, 'es_ES');
            $this->load->model('usuario_model');
            $data['allofertas'] = $this->usuario_model->dar_todas_ofertas($id_usuario, $offset);
            $this->load->view('usuario/ajax/ofertas_listado_view', $data);
        }
    }

    /**
     * Este método devuelve el html correspondiente a las 6 compras siguientes al 
     * offset que llega por POST. El método debe verificar que la sesión del usuario esté activa. 
     * Si no está activa, no devuelve nada. Recibe por POST el offset (offset), 
     * llama al método usuario_model -> dar_carritos_compras_usuario($id_usuario, $offset) 
     * y con las compras que recibe las envía por parámetro ($compras) a la 
     * vista que se encarga de escribirlas en un div. 
     */
    function mostrar_mas_compras_perfil_ajax() {
        if ($this->hay_sesion_activa()) {
            $id_usuario = $this->input->get_post('id_usuario', TRUE);
            $offset = $this->input->get_post('offset', TRUE);
            setlocale(LC_ALL, 'es_ES');
            $this->load->model('usuario_model');
            $data['carritos_compras'] = $this->usuario_model->dar_carritos_compras_usuario($id_usuario, $offset);
            $data['carritos_compras_autopartes'] = $this->usuario_model->dar_carritos_compras_autopartes_usuario($id_usuario);
            $this->load->view('usuario/ajax/compras_listado_view', $data);
        }
    }

    /**
     * Dado un id de un carro_usuario y un id_tarea, se agrega un nuevo registro de tarea realizada
     */
    function tarea_realizada_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_tarea',
                    'rules' => 'trim|required|xss_clean|numeric',
                    'label' => 'id de tarea'
                ), array(
                    'field' => 'id_usuario',
                    'rules' => 'trim|required|xss_clean|numeric',
                    'label' => 'id del vehículo'
                ), array(
                    'field' => 'kilometraje',
                    'rules' => 'trim|required|xss_clean|numeric',
                    'label' => 'kilometraje'
                ),
                array(
                    'field' => 'fecha',
                    'rules' => 'trim|required|xss_clean',
                    'label' => 'fecha'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()) {
                $this->form_validation->set_error_delimiters('', '');
                echo json_encode(array('status' => false, 'msg' => validation_errors()));
            } else {
                $this->load->model('usuario_model');
                $this->load->helper('date');
                setlocale(LC_ALL, 'es_ES');
                $id_tarea = $this->input->get_post('id_tarea', TRUE);
                $tarea = $this->usuario_model->dar_tarea($id_tarea);
                $id_usuario_vehiculo = $this->input->get_post('id_usuario', TRUE);
                $kilometraje = $this->input->get_post('kilometraje', TRUE);
                $fecha_realizado = $this->input->get_post('fecha', TRUE);
                $this->load->library('upload');
                $this->load->model('usuario_model');
                $id_usuario = $this->session->userdata('id_usuario');
                $upload_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/adjuntos/';
                if (!is_dir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/adjuntos')) {
                    mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/adjuntos', 0777, TRUE);
                }
                $nombreArchivo = 'adjunto-' . $this->_getUniqueCode(10);
                $config = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => 'gif|jpg|png|doc|txt|pdf|tiff|docx|rtf',
                    'max_size' => '10000',
                    'file_name' => $nombreArchivo
                );
                $this->upload->initialize($config);

                if ($this->upload->do_upload('tarea_realizada_adjunto')) {
                    $imagen = $this->upload->data();
                    $id = $this->usuario_model->registrar_tarea_realizada_vehiculo($id_usuario_vehiculo, $id_tarea, $fecha_realizado, $kilometraje, $upload_path . $imagen['file_name']);
                    echo json_encode(array('status' => true, 'msg' => strftime("%B %d de %Y", strtotime($fecha_realizado)) . "|" . $id . "|" . $tarea->nombre . "|" . $upload_path . $imagen['file_name']));
                } else {
                    $id = $this->usuario_model->registrar_tarea_realizada_vehiculo($id_usuario_vehiculo, $id_tarea, $fecha_realizado, $kilometraje);
                    if ($this->input->get_post('tarea_realizada_adjunto') != null) {
                        echo json_encode(array('status' => false, 'msg' => $this->upload->display_errors('', '')));
                    } else {
                        echo json_encode(array('status' => true, 'msg' => strftime("%B %d de %Y", strtotime($fecha_realizado)) . "|" . $id . "|" . $tarea->nombre));
                    }
                }
            }
        }
    }

    function tarea_no_realizada_ajax() {
        if ($this->hay_sesion_activa()) {
            //forma
            $this->load->model('usuario_model');
            $this->load->helper('date');
            $id_tarea_realizada = $this->input->get_post('id_tarea_realizada', TRUE);
            setlocale(LC_ALL, 'es_ES');
            $this->usuario_model->registrar_tarea_no_realizada_vehiculo($id_tarea_realizada);
        }
    }

    /**
     * Función que genera un valor alfanumérico para el valor de la referencia de la factura
     * @param type $length
     * @return String código único 
     */
    function _getUniqueCode($length = "") {
        $code = md5(uniqid(rand(), true));
        if ($length != "")
            return substr($code, 0, $length);
        else
            return $code;
    }

    //Valida que el id_usuario_vehiculo corresponda al usuario que tiene la sesion
    function usuario_vehiculo_check_validate($str) {
        $this->load->model('usuario_model');
        $id_usuario = $this->session->userdata('id_usuario');
        $vehiculos = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
        $bool = false;
        foreach ($vehiculos as $vehiculo) {
            if ($vehiculo->id_usuario_vehiculo == $str) {
                $bool = true;
            }
        }
        if ($bool == false) {
            $this->form_validation->set_message('usuario_vehiculo_check_validate', 'El vehículo que especificaste no se puede modificar');
            return false;
        }else
            return true;
    }

    /**
     * Este método edita un vehículo existente. Recibe el siguiente parámetro: 
     * id_vehiculo_usuario y opcionalmente recibe id_vehiculo, modelo, 
     * kilometraje y placa. 
     */
    function editar_vehiculo_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $this->load->model('usuario_model');
            $reglas = array(
                array(
                    'field' => 'id_vehiculo',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'modelo',
                    'rules' => 'trim|required|xss_clean|numeric|greater_than[1950]|less_than[2013]'
                ),
                array(
                    'field' => 'kilometraje',
                    'rules' => 'trim|required|xss_clean|max_length[10]|is_natural'
                ),
                array(
                    'field' => 'placa',
                    'rules' => 'trim|xss_clean|max_length[7]'
                ),
                array(
                    'field' => 'id_usuario_vehiculo',
                    'rules' => 'trim|required|xss_clean|is_natural|callback_usuario_vehiculo_check_validate'
                ),
                array(
                    'field' => 'vehiculo',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);
            $this->form_validation->set_message('id_vehiculo', 'El vehículo que especificaste no se encuentra registrado en nuestra base de datos');
            if (!$this->form_validation->run()) {
                $this->form_validation->set_error_delimiters('', '');

                $err['email'] = form_error('modelo', '', '');
                $err['usuario'] = form_error('kilometraje', '', '');
                $err['apellidos'] = form_error('placa', '', '');
                $err['lugar'] = form_error('id_usuario_vehiculo', '', '');
                $err['nombres'] = form_error('id_vehiculo', '', '');
                echo 'false|' . json_encode($err);
            } else {
                $this->load->helper('date');
                $id_vehiculo = $this->input->get_post('id_vehiculo', TRUE);
                $id_usuario_vehiculo = $this->input->get_post('id_usuario_vehiculo', TRUE);
                $modelo = $this->input->get_post('modelo', TRUE);
                $kilometraje = $this->input->get_post('kilometraje', TRUE);
                $placa = $this->input->get_post('placa', TRUE);
                $placa = str_replace(" ", "", $placa);
                $placa = str_replace("-", "", $placa);

                $this->load->model('usuario_model');
                $this->load->model('vehiculo_model');
                $this->load->helper('mail');

                $vehiculo = split(' ', $this->input->post('vehiculo', TRUE), 2);
                if (sizeof($vehiculo) >= 2) {
                    if (is_numeric($id_vehiculo) && $this->vehiculo_model->existe_vehiculo($id_vehiculo))
                        $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo, $id_vehiculo, '', $modelo, $kilometraje, '', $placa);
                    else {

                        $nuevoVehiculo = $this->vehiculo_model->agregar_vehiculo($vehiculo[0], $vehiculo[1]);
                        $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo, $nuevoVehiculo, '', $modelo, $kilometraje, '', $placa);

                        $destinatario = new stdClass();
                        $destinatario->email = 'tallerenlinea@laspartes.com.co';
                        $destinatarios[] = $destinatario;
                        send_mail($destinatarios, "[LasPartes.com] Nuevo Carro", "", 'El vehiculo: ' . $this->input->post('vehiculo', TRUE) . ' con id_vehiculo: ' . $nuevoVehiculo . ' fue ingresada al sistema por el id_usuario: ' . $id_usuario);
                    }
                    echo 'true';
                } else {
                    echo 'false|*Debes ingresar la marca y línea de tu vehículo';
                }
            }
        }
    }

    /**
     * Este método edita un vehículo existente. Recibe el siguiente parámetro: 
     * id_vehiculo_usuario y opcionalmente recibe id_vehiculo, modelo, 
     * kilometraje y placa. 
     */
    function editar_vehiculo_fix() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $this->load->model('usuario_model');
            $reglas = array(
                array(
                    'field' => 'modelo',
                    'rules' => 'trim|required|xss_clean|numeric|greater_than[1950]|less_than[2013]',
                    'label' => 'modelo'
                ),
                array(
                    'field' => 'kilometraje',
                    'rules' => 'trim|required|xss_clean|max_length[10]|is_natural',
                    'label' => 'kilometraje'
                ),
                array(
                    'field' => 'placa',
                    'rules' => 'trim|xss_clean|max_length[7]',
                    'label' => 'placa'
                ),
                array(
                    'field' => 'id_usuario_vehiculo',
                    'rules' => 'trim|required|xss_clean|is_natural|callback_usuario_vehiculo_check_validate',
                    'label' => 'id del vehiculo'
                ),
                array(
                    'field' => 'marca',
                    'rules' => 'trim|required|xss_clean',
                    'label' => 'marca'
                ),
                array(
                    'field' => 'linea',
                    'rules' => 'trim|required|xss_clean',
                    'label' => 'linea'
                ),
                array(
                    'field' => 'vida_util',
                    'rules' => 'trim|required|xss_clean',
                    'label' => 'vida últil'
                )

            );
            $this->form_validation->set_rules($reglas);
            $this->form_validation->set_message('id_vehiculo', 'El vehículo que especificaste no se encuentra registrado en nuestra base de datos');
            if (!$this->form_validation->run()) {
                $this->form_validation->set_error_delimiters('', '');

                $err['email'] = form_error('modelo', '', '');
                $err['usuario'] = form_error('kilometraje', '', '');
                $err['apellidos'] = form_error('placa', '', '');
                $err['lugar'] = form_error('id_usuario_vehiculo', '', '');
                $err['nombres'] = form_error('id_vehiculo', '', '');
                echo 'false|' . json_encode($err);
            } else {
                $this->load->helper('date');
                $id_usuario_vehiculo = $this->input->get_post('id_usuario_vehiculo', TRUE);
                $modelo = $this->input->get_post('modelo', TRUE);
                $kilometraje = $this->input->get_post('kilometraje', TRUE);
                $placa = $this->input->get_post('placa', TRUE);
                $marca = $this->input->get_post('marca', TRUE);
                $linea = $this->input->get_post('linea', TRUE);
                $vida_util = $this->input->get_post('vida_util', TRUE);
                $placa = str_replace(" ", "", $placa);
                $placa = str_replace("-", "", $placa);

                $this->load->model('vehiculo_model');
                $this->load->model('flota_model');
                $this->load->helper('mail');

                $vehiculo = $this->vehiculo_model->existe_vehiculo_marca_linea($marca, $linea);

                if ($vehiculo != false){
                    $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo, $vehiculo->id_vehiculo, '', $modelo, $kilometraje, '', $placa);
                    $extras['vida_util'] = $vida_util;
                    $this->flota_model->actualizar_flota_usuario_vehiculo('', $id_usuario_vehiculo, $extras);
                } else {
                    $nuevoVehiculo = $this->vehiculo_model->agregar_vehiculo($marca, $linea);
                    $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo, $nuevoVehiculo, '', $modelo, $kilometraje, '', $placa);
                    $extras['vida_util'] = $vida_util;
                    $this->flota_model->actualizar_flota_usuario_vehiculo('', $id_usuario_vehiculo, $extras);

                    $destinatario = new stdClass();
                    $destinatario->email = 'luis.cabarique@laspartes.com.co';
                    $destinatarios[] = $destinatario;
                    send_mail($destinatarios, "[LasPartes.com] Nuevo Carro", "", 'El vehiculo: ' . $marca .' '. $linea . ' con id_vehiculo: ' . $nuevoVehiculo . ' fue ingresada al sistema por el id_usuario: ' . $this->session->userdata('id_usuario'));
                }
                echo 'true';
            }
        }
    }

    /**
     * agrega el vehículo desde el formulario de registro por medio de ajax 
     */
    function agregar_vehiculo_registro_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'input_vehiculo_marca',
                    'label' => 'Marca',
                    'rules' => 'trim|required|xss_clean|max_length[20]'
                ),
                array(
                    'field' => 'input_vehiculo_linea',
                    'label' => 'Línea',
                    'rules' => 'trim|required|xss_clean|max_length[50]'
                ),
                array(
                    'field' => 'input_vehiculo_kilometraje',
                    'label' => 'Kilometraje',
                    'rules' => 'trim|required|xss_clean|max_length[10]|is_natural'
                ),
                array(
                    'field' => 'input_vehiculo_modelo',
                    'label' => 'Modelo',
                    'rules' => 'trim|required|xss_clean|numeric|greater_than[1950]|less_than[2015]'
                ),
                array(
                    'field' => 'input_vehiculo_placa',
                    'label' => 'Placa',
                    'rules' => 'trim|xss_clean|max_length[7]'
                ),
                array(
                    'field' => 'input_vehiculo_id_usuario_vehiculo',
                    'label' => 'Placa',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'input_id_flota',
                    'label' => 'id flota',
                    'rules' => 'trim|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()) {
                $this->form_validation->set_error_delimiters('', '');
                echo 'false|' . validation_errors();
            } else {
                $this->load->helper('date');
                $id_usuario_vehiculo_precreado =$this->input->get_post('input_vehiculo_id_usuario_vehiculo', TRUE);
                $marca = $this->input->get_post('input_vehiculo_marca', TRUE);
                $linea = $this->input->get_post('input_vehiculo_linea', TRUE);
                $modelo = $this->input->get_post('input_vehiculo_modelo', TRUE);
                $kilometraje = $this->input->get_post('input_vehiculo_kilometraje', TRUE);
                $placa = $this->input->get_post('input_vehiculo_placa', TRUE);
                $id_flota = $this->input->get_post('input_id_flota', TRUE);
                $placa = str_replace(' ', '', $placa);
                $id_usuario = $this->session->userdata('id_usuario');

                $this->load->model('usuario_model');
                $this->load->model('vehiculo_model');
                $this->load->helper('mail');

                $vehiculo = $this->vehiculo_model->existe_vehiculo_marca_linea($marca, $linea);

                $id_usuario_vehiculo = '';
                if ($vehiculo != false){
                    if(empty($id_usuario_vehiculo_precreado))
                        $id_usuario_vehiculo = $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $vehiculo->id_vehiculo, '', $modelo, $kilometraje, '', $placa);
                    else
                        $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo_precreado, $vehiculo->id_vehiculo, "", $modelo, $kilometraje , $serie, $placa );
                }else {

                    $nuevoVehiculo = $this->vehiculo_model->agregar_vehiculo($marca, $linea);
                    if(empty($id_usuario_vehiculo_precreado))
                        $id_usuario_vehiculo = $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $nuevoVehiculo, '', $modelo, $kilometraje, '', $placa);
                    else
                        $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo_precreado, $vehiculo->id_vehiculo, "", $modelo, $kilometraje , $serie, $placa );

                    $destinatario = new stdClass();
                    $destinatario->email = 'tallerenlinea@laspartes.com.co';
                    $destinatarios[] = $destinatario;
                    send_mail($destinatarios, "[LasPartes.com] Nuevo Carro", "", 'El vehiculo: ' . $marca . ' ' . $linea . ' con id_vehiculo: ' . $nuevoVehiculo . ' fue ingresada al sistema por el id_usuario: ' . $id_usuario);
                }
                //si se envía el id de la flota, este carro se agrega a una flota
                if($id_flota){
                    $this->load->model('flota_model');
                    $this->flota_model->agregar_flota_vehiculo($id_usuario_vehiculo, $id_flota);
                }

                echo 'true';
            }
        }
    }

    /**
     * agrega el vehículo desde el formulario de registro por medio de ajax 
     */
    function agregar_vehiculo_flota_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'input_vehiculo_marca',
                    'label' => 'Marca',
                    'rules' => 'trim|required|xss_clean|max_length[20]'
                ),
                array(
                    'field' => 'input_vehiculo_linea',
                    'label' => 'Línea',
                    'rules' => 'trim|required|xss_clean|max_length[50]'
                ),
                array(
                    'field' => 'input_vehiculo_kilometraje',
                    'label' => 'Kilometraje',
                    'rules' => 'trim|required|xss_clean|max_length[10]|is_natural'
                ),
                array(
                    'field' => 'input_vehiculo_modelo',
                    'label' => 'Modelo',
                    'rules' => 'trim|required|xss_clean|numeric|greater_than[1950]|less_than[2015]'
                ),
                array(
                    'field' => 'input_vehiculo_placa',
                    'label' => 'Placa',
                    'rules' => 'trim|xss_clean|max_length[7]'
                ),
                array(
                    'field' => 'input_vehiculo_id_usuario_vehiculo',
                    'label' => 'Placa',
                    'rules' => 'trim|xss_clean'
                ),
                array(
                    'field' => 'input_id_flota',
                    'label' => 'id flota',
                    'rules' => 'trim|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()) {
                $this->form_validation->set_error_delimiters('', '');
                json_encode(array('status' => false, 'msg' => validation_errors()));
            } else {
                $this->load->helper('date');
                $id_usuario_vehiculo_precreado =$this->input->get_post('input_vehiculo_id_usuario_vehiculo', TRUE);
                $marca = $this->input->get_post('input_vehiculo_marca', TRUE);
                $linea = $this->input->get_post('input_vehiculo_linea', TRUE);
                $modelo = $this->input->get_post('input_vehiculo_modelo', TRUE);
                $kilometraje = $this->input->get_post('input_vehiculo_kilometraje', TRUE);
                $placa = $this->input->get_post('input_vehiculo_placa', TRUE);
                $id_flota = $this->input->get_post('input_id_flota', TRUE);
                $placa = str_replace(' ', '', $placa);
                $id_usuario = $this->session->userdata('id_usuario');

                $this->load->model('usuario_model');
                $this->load->model('vehiculo_model');
                $this->load->helper('mail');

                $vehiculo = $this->vehiculo_model->existe_vehiculo_marca_linea($marca, $linea);

                $id_usuario_vehiculo = '';
                if ($vehiculo != false){
                    if(empty($id_usuario_vehiculo_precreado))
                        $id_usuario_vehiculo = $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $vehiculo->id_vehiculo, '', $modelo, $kilometraje, '', $placa);
                    else
                        $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo_precreado, $vehiculo->id_vehiculo, "", $modelo, $kilometraje , $serie, $placa );
                }else {

                    $nuevoVehiculo = $this->vehiculo_model->agregar_vehiculo($marca, $linea);
                    if(empty($id_usuario_vehiculo_precreado))
                        $id_usuario_vehiculo = $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $nuevoVehiculo, '', $modelo, $kilometraje, '', $placa);
                    else
                        $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo_precreado, $vehiculo->id_vehiculo, "", $modelo, $kilometraje , $serie, $placa );

                    $destinatario = new stdClass();
                    $destinatario->email = 'tallerenlinea@laspartes.com.co';
                    $destinatarios[] = $destinatario;
                    send_mail($destinatarios, "[LasPartes.com] Nuevo Carro", "", 'El vehiculo: ' . $marca . ' ' . $linea . ' con id_vehiculo: ' . $nuevoVehiculo . ' fue ingresada al sistema por el id_usuario: ' . $id_usuario);
                }
                //si se envía el id de la flota, este carro se agrega a una flota
                if($id_flota){
                    $this->load->model('flota_model');
                    $this->flota_model->agregar_flota_vehiculo($id_usuario_vehiculo, $id_flota);
                }
                $status_img = $this->_subir_imagen_usuario_vehiculo($id_usuario_vehiculo);
                echo json_encode(array('status' => true, 'id_usuario_vehiculo' => $id_usuario_vehiculo));
            }
        }
    }
    /**
     * agrega el vehículo desde el perfil por medio de ajax 
     */
    function agregar_vehiculo_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $this->load->model('usuario_model');
            $reglas = array(
                array(
                    'field' => 'id_vehiculo',
                    'rules' => 'trim|required|xss_clean'
                ),
                array(
                    'field' => 'modelo',
                    'rules' => 'trim|required|xss_clean|numeric|greater_than[1950]|less_than[2013]'
                ),
                array(
                    'field' => 'kilometraje',
                    'rules' => 'trim|required|xss_clean|max_length[10]|is_natural'
                ),
                array(
                    'field' => 'placa',
                    'rules' => 'trim|xss_clean|max_length[7]'
                ),
                array(
                    'field' => 'id_usuario',
                    'rules' => 'trim|required|xss_clean|numeric|is_natural'
                ),
                array(
                    'field' => 'vehiculo',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()) {
                $this->form_validation->set_error_delimiters('', '');
                $err['email'] = form_error('modelo', '', '');
                $err['usuario'] = form_error('kilometraje', '', '');
                $err['apellidos'] = form_error('placa', '', '');
                $err['lugar'] = form_error('id_usuario_vehiculo', '', '');
                $err['nombres'] = form_error('id_vehiculo', '', '');
                echo 'false|' . json_encode($err);
            } else {
                $this->load->helper('date');
                $id_vehiculo = $this->input->get_post('id_vehiculo', TRUE);
                $modelo = $this->input->get_post('modelo', TRUE);
                $kilometraje = $this->input->get_post('kilometraje', TRUE);
                $placa = $this->input->get_post('placa', TRUE);
                $placa = str_replace(" ", "", $placa);
                $id_usuario = $this->input->get_post('id_usuario', TRUE);

                $this->load->model('usuario_model');
                $this->load->model('vehiculo_model');
                $this->load->helper('mail');

                $vehiculo = split(' ', $this->input->post('vehiculo', TRUE), 2);
                if (sizeof($vehiculo) >= 2) {

                    if (is_numeric($id_usuario) && $this->vehiculo_model->existe_vehiculo($id_vehiculo))
                        $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $id_vehiculo, '', $modelo, $kilometraje, '', $placa);
                    else {

                        $nuevoVehiculo = $this->vehiculo_model->agregar_vehiculo($vehiculo[0], $vehiculo[1]);
                        $this->usuario_model->agregar_vehiculo_usuario($id_usuario, $nuevoVehiculo, '', $modelo, $kilometraje, '', $placa);

                        $destinatario = new stdClass();
                        $destinatario->email = 'tallerenlinea@laspartes.com.co';
                        $destinatarios[] = $destinatario;
                        send_mail($destinatarios, "[LasPartes.com] Nuevo Carro", "", 'El vehiculo: ' . $this->input->post('vehiculo', TRUE) . ' con id_vehiculo: ' . $nuevoVehiculo . ' fue ingresada al sistema por el id_usuario: ' . $id_usuario);
                    }
                    echo 'true';
                } else {
                    echo 'false|*debes ingresar la marca y línea de tu vehículo';
                }
            }
        }
    }

    /**
     * Este método sube una imagen a un espacio temporal y recibe en el POST 
     * dos variables que determinan el tamaño al que la imagen se debe cortar (ancho, alto). 
     * No puede subir imágenes de más de 10Mb. El tamaño de la imagen debe ser cambiado al 
     * tamaño que se especifique como parámetro. Si puede subir la imagen y cortarla sin problemas 
     * debe devolver el siguiente mensaje: true|<path en el servidor en donde se subió la imagen> 
     * Si hay problemas, devuelve "false|<mensaje de error> 
     */
    function subir_imagen_temp_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('upload');
            $this->load->model('usuario_model');
            $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo');
            $id_usuario = $this->input->post('id_usuario');
            if(!$id_usuario)
                $id_usuario = $this->usuario_model->dar_vehiculo($id_usuario_vehiculo)->id_usuario;
            $upload_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/';
            if (!is_dir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo)) {
                mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo, 0777, TRUE);
            }
            $config = array(
                'upload_path' => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $imagen = $this->upload->data();

                $img_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
                $img_thumb = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = $img_path;
                $config['maintain_ratio'] = FALSE;
                $img = imagecreatefromjpeg($img_path);
                $_width = imagesx($img);
                $_height = imagesy($img);
                $img_type = '';
                $thumb_size = 177;

                if ($_width > $_height) {
                    // wide image
                    $config['width'] = intval(($_width / $_height) * $thumb_size);
                    if ($config['width'] % 2 != 0) {
                        $config['width']++;
                    }
                    $config['height'] = $thumb_size;
                    $img_type = 'wide';
                } else if ($_width < $_height) {

                    // landscape image

                    $config['width'] = $thumb_size;
                    $config['height'] = intval(($_height / $_width) * $thumb_size);

                    if ($config['height'] % 2 != 0) {
                        $config['height']++;
                    }

                    $img_type = 'landscape';
                } else {

                    // square image
                    $config['width'] = $thumb_size;
                    $config['height'] = $thumb_size;
                    $img_type = 'square';
                }



                $this->load->library('image_lib');

                $this->image_lib->initialize($config);

                $this->image_lib->resize();

                // reconfigure the image lib for cropping

                $conf_new = array(
                    'image_library' => 'gd2',
                    'source_image' => $img_thumb,
                    'create_thumb' => FALSE,
                    'maintain_ratio' => FALSE,
                    'width' => $thumb_size,
                    'height' => $thumb_size
                );

                if ($img_type == 'wide') {

                    $conf_new['x_axis'] = ($config['width'] - $thumb_size) / 2;

                    $conf_new['y_axis'] = 0;
                } else if ($img_type == 'landscape') {

                    $conf_new['x_axis'] = 0;

                    $conf_new['y_axis'] = ($config['height'] - $thumb_size) / 2;
                } else {

                    $conf_new['x_axis'] = 0;

                    $conf_new['y_axis'] = 0;
                }



                $this->image_lib->initialize($conf_new);

                $this->image_lib->crop();

                $this->usuario_model->actualizar_usuario_vehiculo_imagen_url($id_usuario_vehiculo, $img_path);

                echo $img_path;
            } else {
                echo $this->upload->display_errors();
            }
        }
    }

    /**
     * Sube la la imagen al primer vehículo del usuario que tiene sesión abierta
     */
    function subir_imagen_vehiculo_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('upload');
            $this->load->model('usuario_model');
            $id_usuario = $this->session->userdata('id_usuario');
            $vehiculos = ($this->usuario_model->dar_vehiculos_usuario($id_usuario));
            $id_usuario_vehiculo = $vehiculos[0]->id_usuario_vehiculo;
            $upload_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/';
            if (!is_dir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo)) {
                mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo, 0777, TRUE);
            }
            $config = array(
                'upload_path' => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload('input_vehiculo_imagen')) {
                $imagen = $this->upload->data();

                $img_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
                $img_thumb = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = $img_path;
                $config['maintain_ratio'] = FALSE;
                $img = imagecreatefromjpeg($img_path);
                $_width = imagesx($img);
                $_height = imagesy($img);
                $img_type = '';
                $thumb_size = 177;

                if ($_width > $_height) {
                    // wide image
                    $config['width'] = intval(($_width / $_height) * $thumb_size);
                    if ($config['width'] % 2 != 0) {
                        $config['width']++;
                    }
                    $config['height'] = $thumb_size;
                    $img_type = 'wide';
                } else if ($_width < $_height) {
                    // landscape image

                    $config['width'] = $thumb_size;
                    $config['height'] = intval(($_height / $_width) * $thumb_size);

                    if ($config['height'] % 2 != 0) {
                        $config['height']++;
                    }
                    $img_type = 'landscape';
                } else {
                    // square image
                    $config['width'] = $thumb_size;
                    $config['height'] = $thumb_size;
                    $img_type = 'square';
                }



                $this->load->library('image_lib');

                $this->image_lib->initialize($config);

                $this->image_lib->resize();

                // reconfigure the image lib for cropping

                $conf_new = array(
                    'image_library' => 'gd2',
                    'source_image' => $img_thumb,
                    'create_thumb' => FALSE,
                    'maintain_ratio' => FALSE,
                    'width' => $thumb_size,
                    'height' => $thumb_size
                );

                if ($img_type == 'wide') {

                    $conf_new['x_axis'] = ($config['width'] - $thumb_size) / 2;

                    $conf_new['y_axis'] = 0;
                } else if ($img_type == 'landscape') {

                    $conf_new['x_axis'] = 0;

                    $conf_new['y_axis'] = ($config['height'] - $thumb_size) / 2;
                } else {

                    $conf_new['x_axis'] = 0;

                    $conf_new['y_axis'] = 0;
                }

                $this->image_lib->initialize($conf_new);

                $this->image_lib->crop();

                $this->usuario_model->actualizar_usuario_vehiculo_imagen_url($id_usuario_vehiculo, $img_path);

                echo $img_path;
            } else {
                echo $this->upload->display_errors();
            }
        }
    }

    /**
     * Sube la la imagen de un vehículo según su id_usuario_vehiculo
     */
    function _subir_imagen_usuario_vehiculo($id_usuario_vehiculo) {
        $this->load->library('upload');
        $id_usuario = $this->session->userdata('id_usuario');
        $upload_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/';
        if (!is_dir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo)) {
            mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo, 0777, TRUE);
        }
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size' => '10000'
        );
        $this->upload->initialize($config);

        if ($this->upload->do_upload('input_vehiculo_imagen')) {
            $imagen = $this->upload->data();

            $img_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
            $img_thumb = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/' . $imagen['file_name'];
            $config['image_library'] = 'gd2';
            $config['source_image'] = $img_path;
            $config['maintain_ratio'] = FALSE;
            $img = imagecreatefromjpeg($img_path);
            $_width = imagesx($img);
            $_height = imagesy($img);
            $img_type = '';
            $thumb_size = 177;

            if ($_width > $_height) {
                // wide image
                $config['width'] = intval(($_width / $_height) * $thumb_size);
                if ($config['width'] % 2 != 0) {
                    $config['width']++;
                }
                $config['height'] = $thumb_size;
                $img_type = 'wide';
            } else if ($_width < $_height) {
                // landscape image

                $config['width'] = $thumb_size;
                $config['height'] = intval(($_height / $_width) * $thumb_size);

                if ($config['height'] % 2 != 0) {
                    $config['height']++;
                }
                $img_type = 'landscape';
            } else {
                // square image
                $config['width'] = $thumb_size;
                $config['height'] = $thumb_size;
                $img_type = 'square';
            }



            $this->load->library('image_lib');

            $this->image_lib->initialize($config);

            $this->image_lib->resize();

            // reconfigure the image lib for cropping

            $conf_new = array(
                'image_library' => 'gd2',
                'source_image' => $img_thumb,
                'create_thumb' => FALSE,
                'maintain_ratio' => FALSE,
                'width' => $thumb_size,
                'height' => $thumb_size
            );

            if ($img_type == 'wide') {

                $conf_new['x_axis'] = ($config['width'] - $thumb_size) / 2;

                $conf_new['y_axis'] = 0;
            } else if ($img_type == 'landscape') {

                $conf_new['x_axis'] = 0;

                $conf_new['y_axis'] = ($config['height'] - $thumb_size) / 2;
            } else {

                $conf_new['x_axis'] = 0;

                $conf_new['y_axis'] = 0;
            }

            $this->image_lib->initialize($conf_new);

            $this->image_lib->crop();

            $this->usuario_model->actualizar_usuario_vehiculo_imagen_url($id_usuario_vehiculo, $img_path);

        } else {
            return $this->upload->display_errors();
        }
    }

    /**
     * Sube la imagen del perfil por ajax
     */
    function subir_imagen_perfil_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('upload');
            $this->load->model('usuario_model');
            $id_usuario = $this->input->post('id_usuario');
            $upload_path = 'resources/images/usuarios/' . $id_usuario . '/';
            if (!is_dir('resources/images/usuarios/' . $id_usuario)) {
                mkdir('resources/images/usuarios/' . $id_usuario, 0777, TRUE);
            }
            $config = array(
                'upload_path' => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $imagen = $this->upload->data();

                $img_path = 'resources/images/usuarios/' . $id_usuario . '/' . $imagen['file_name'];
                $img_thumb = 'resources/images/usuarios/' . $id_usuario . '/' . $imagen['file_name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = $img_path;
                $config['maintain_ratio'] = FALSE;
                $img = imagecreatefromjpeg($img_path);
                $_width = imagesx($img);
                $_height = imagesy($img);
                $img_type = '';
                $thumb_size = 104;

                if ($_width > $_height) {
                    // wide image
                    $config['width'] = intval(($_width / $_height) * $thumb_size);
                    if ($config['width'] % 2 != 0) {
                        $config['width']++;
                    }
                    $config['height'] = $thumb_size;
                    $img_type = 'wide';
                } else if ($_width < $_height) {

                    // landscape image

                    $config['width'] = $thumb_size;
                    $config['height'] = intval(($_height / $_width) * $thumb_size);

                    if ($config['height'] % 2 != 0) {
                        $config['height']++;
                    }

                    $img_type = 'landscape';
                } else {

                    // square image
                    $config['width'] = $thumb_size;
                    $config['height'] = $thumb_size;
                    $img_type = 'square';
                }



                $this->load->library('image_lib');

                $this->image_lib->initialize($config);

                $this->image_lib->resize();

                // reconfigure the image lib for cropping

                $conf_new = array(
                    'image_library' => 'gd2',
                    'source_image' => $img_thumb,
                    'create_thumb' => FALSE,
                    'maintain_ratio' => FALSE,
                    'width' => $thumb_size,
                    'height' => $thumb_size
                );

                if ($img_type == 'wide') {

                    $conf_new['x_axis'] = ($config['width'] - $thumb_size) / 2;

                    $conf_new['y_axis'] = 0;
                } else if ($img_type == 'landscape') {

                    $conf_new['x_axis'] = 0;

                    $conf_new['y_axis'] = ($config['height'] - $thumb_size) / 2;
                } else {

                    $conf_new['x_axis'] = 0;

                    $conf_new['y_axis'] = 0;
                }



                $this->image_lib->initialize($conf_new);

                $this->image_lib->crop();

                $this->usuario_model->actualizar_usuario_imagen_url($id_usuario, $img_path);

                echo $img_path;
            } else {
                echo $this->upload->display_errors();
            }
        }
    }

    /**
     * Este método cambia los nombres, apellidos, el usuario, el email y la ciudad del usuario que está logueado. Debe verificar lo siguiente:
    * Todos los valores son requeridos. Mensaje acerca del error: "Debes especificar todos los campos"
    * El email debe ser válido. Mensaje acerca del error: "Debes escribir un email válido"
    * El usuario no debe existir previamente. Mensaje acerca del error: "Ya existe alguien registrado con el usuario que especificaste"
    * El email no debe estar registrado a otro usuario. Mensaje acerca del error: "Ya existe alguien registrado con el mail que especificaste"
     */
    function editar_perfil_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $this->load->model('usuario_model');
            $reglas = array(
                array(
                    'field' => 'email',
                    'label' => 'email',
                    'rules' => 'trim|required|valid_email|xss_clean'
                ),
                array(
                    'field' => 'usuario',
                    'label' => 'usuario',
                    'rules' => 'trim|required|xss_clean|max_length[25]|min_length[5]'
                ),
                array(
                    'field' => 'apellidos',
                    'label' => 'apellidos',
                    'rules' => 'trim|required|xss_clean|max_length[20]'
                ),
                array(
                    'field' => 'nombres',
                    'label' => 'nombres',
                    'rules' => 'trim|required|xss_clean|max_length[20]'
                ),
                array(
                    'field' => 'lugar',
                    'label' => 'lugar',
                    'rules' => 'trim|required|xss_clean'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()) {
                $this->form_validation->set_error_delimiters('', '');
                $err['email'] = form_error('email', '', '');
                $err['usuario'] = form_error('usuario', '', '');
                $err['apellidos'] = form_error('apellidos', '', '');
                $err['lugar'] = form_error('lugar', '', '');
                $err['nombres'] = form_error('nombres', '', '');
                echo 'false|' . json_encode($err);
            } else {
                $this->load->model('usuario_model');
                $usuario = $this->input->post('usuario');
                if ($usuario != $this->session->userdata('usuario')) {
                    $usuarioValido = $this->usuario_model->validar_nombre_usuario($usuario);
                } else {
                    $usuarioValido = 'true';
                }
                $id_usuario = $this->input->post('id_usuario');
                $nombres = $this->input->post('nombres');
                $apellidos = $this->input->post('apellidos');
                $email = $this->input->post('email');
                if ($email != $this->session->userdata('correo')) {
                    $emailValido = $this->usuario_model->validar_email_existente_ajax($email);
                } else {
                    $emailValido = 'true';
                }
                $lugar = $this->input->post('lugar');
                if ($emailValido == 'true' && $usuarioValido == 'true') {
                    $this->usuario_model->actualizar_usuario($id_usuario, $usuario, $nombres, $apellidos, $email, $lugar);
                    $usuario_sesion = array(
                        'nombres' => $nombres,
                        'apellidos' => $apellidos,
                        'correo' => $email,
                        'ciudad' => $lugar,
                        'usuario' => $usuario
                    );
                    $this->session->set_userdata($usuario_sesion);
                    echo 'true';
                } else {
                    echo 'false|Ya existe alguien registrado con el mail o usuario que especificaste';
                }
            }
        }
    }

    /**
     * Valida que el usuario este disponible
     */
    function validar_usuario_existente_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->model('usuario_model');
            $usuario = $this->input->post('usuario');
            if ($usuario != $this->session->userdata('usuario')) {
                $respuesta = $this->usuario_model->validar_nombre_usuario($usuario);
                echo $respuesta;
            } else {
                echo "true";
            }
        }
    }

    /**
     * Valida que el usuario este disponible
     */
    function validar_email_existente_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->model('usuario_model');
            $email = $this->input->post('email');
            if ($email != $this->session->userdata('correo')) {
                echo $this->usuario_model->validar_email_existente_ajax($email);
            } else {
                echo "true";
            }
        }
    }

    //retorna el estado de la sesion
    function dar_sesion_activa_ajax() {
        echo $this->hay_sesion_activa();
    }

    /**
     * Muestra el formulario de registro vía ajax
     */
    function mostrar_registro_ajax() {
        $this->load->model('vehiculo_model');
        $this->load->model('usuario_model');
        $this->load->helper('captcha');
//da la lista de marcas de vehículos para el autocomplete
        $data['allmarcas'] = $this->vehiculo_model->dar_vehiculos_marca();
        $index = 0;
        foreach ($data['allmarcas'] as $marca) {
            $data['allmarcas'][$index]->label = $marca->marca;
            $data['allmarcas'][$index]->value = $marca->marca;
            $index++;
        }

        $config = array(
            'img_path' => 'resources/images/captcha/',
            'img_url' => base_url() . 'resources/images/captcha/',
            'length' => 4
        );
        $data['captcha'] = create_captcha($config);
        $this->usuario_model->agregar_captcha(round($data['captcha']['time']), $this->input->ip_address(), $data['captcha']['word']);
        $this->load->view('login/formulario_registro_login', $data);
    }

    /**
     * Muestra el formulario de registro de un vehículo vía ajax
     */
    function mostrar_registro_vehiculo_ajax() {
        $this->load->model('vehiculo_model');
        //da la lista de marcas de vehículos para el autocomplete
        $data['allmarcas'] = $this->vehiculo_model->dar_vehiculos_marca();
        $index = 0;
        foreach ($data['allmarcas'] as $marca) {
            $data['allmarcas'][$index]->label = $marca->marca;
            $data['allmarcas'][$index]->value = $marca->marca;
            $index++;
        }

        $this->load->view('usuario/ajax/formulario_registro_vehiculo', $data);
    }

    /**
     * Se encarga de cargar el html de inicio de sesión y devolverlo. 
     */
    function cargar_header_ajax() {
        $this->load->view('template/ajax/header_view_ajax');
    }

    /**
     * Muestra el cronograma de actividades
     */
    function cronograma() {
        if ($this->hay_sesion_activa()) {
            $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo');
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->helper('date');
            $this->load->model('usuario_model');
            $vehiculos = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
            foreach ($vehiculos as $i => $carro) {
                if ($carro->id_usuario_vehiculo == $id_usuario_vehiculo) {
                    $carroIndex = $i;
                }
            }
            $vehiculo = $vehiculos[$carroIndex];
            $kilometraje_ciudad = $this->usuario_model->dar_kilometraje_ciudad($data['usuario']->lugar);

            $this->load->helper('date');
            $tareas = array();
            $tareas_asignadas = array();
            $kilometraje_mensual = $kilometraje_ciudad / 12;
            $kilometraje_actual = $vehiculo->kilometraje;
//            echo 'Mi kilometraje es de: '.$kilometraje_actual.'Kms.<br/>';
            $tareas = $this->usuario_model->dar_tareas_vehiculo($vehiculo->id_vehiculo);
            $fecha_actual = mdate("%Y-%m-%d");
            foreach ($tareas as $tarea) {
                $tarea->realizado = false;
                if ($tarea->id_servicio == 9) {
                    
                } else if ($tarea->id_servicio == 10) {
                    
                } else {
                    $tarea_cronograma = new stdClass();
                    $periodicidad = $tarea->periodicidad;
                    $periodicidadMeses = $tarea->periodicidad * 12 / $kilometraje_ciudad;
                    $tarea_cronograma->titulo = 'Tarea: ' . $tarea->nombre . '. Realizar cada ' . $periodicidadMeses . ' meses o ' . $periodicidad . 'Kms.';
                    $kiloTemp = $kilometraje_actual % 5000;
                    $cincomil = 5000 - $kiloTemp;
                    $kiloTemp = $kilometraje_actual + $cincomil;
                    $tarea_cronograma_fecha = '';
                    $encontro_fecha = false;
                    for ($index = $kiloTemp; $index <= ($kiloTemp + 12000); $index+=5000) {
                        if ($index % $periodicidad == 0) {
                            $kilo_diff = $index - $kilometraje_actual;
                            $dias_diff = round($kilo_diff * 365 / $kilometraje_ciudad);
//                                    $tarea_cronograma->kilometraje =   'Tengo que realizarlo a los: '.$index.'Kms. dentro de: '.$dias_diff.' dias<br/>';
                            $time = now() + $dias_diff * 24 * 3600;
                            $siguiente_ano = now() * 24 * 3600 * 365;
                            if (strtotime($time) <= strtotime($siguiente_ano)) {
                                $tarea_cronograma_fecha .= 'Realizar el día: ' . strftime("%B %d de %Y", $time) . '<br/>';
                                $encontro_fecha = true;
                            }
                        }
                    }
                    if ($encontro_fecha) {
                        $tarea_cronograma->img = $tarea->imagen_thumb_url;
                        $tarea_cronograma->fecha = $tarea_cronograma_fecha;
                        $tareas_cronogramas[] = $tarea_cronograma;
                    }
                }
            }
            $data['tareas_cronograma'] = $tareas_cronogramas;
            $this->load->view('usuario/cronograma_listado_view', $data);
        }
    }

    /**
     * Muestra el cronograma de actividades
     */
    function cronograma_flotas($id_usuario_vehiculo) {
        if ($this->hay_sesion_activa()) {
            $id_usuario = $this->session->userdata('id_usuario');
            $this->load->helper('date');
            $this->load->model('usuario_model');
            $this->load->model('flota_model');
            $vehiculos = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
            foreach ($vehiculos as $i => $carro) {
                if ($carro->id_usuario_vehiculo == $id_usuario_vehiculo) {
                    $carroIndex = $i;
                }
            }
            $vehiculo = $vehiculos[$carroIndex];
            $kilometraje_ciudad = '32000';

            $this->load->helper('date');
            $tareas = array();
            $tareas_asignadas = array();
            $kilometraje_mensual = $kilometraje_ciudad / 12;
            $kilometraje_actual = $vehiculo->kilometraje;
            $tareas = $this->flota_model->dar_tareas_vehiculo_personalizado($vehiculo->id_usuario_vehiculo);
            if(count($tareas)  == 0)
                $tareas = $this->usuario_model->dar_tareas_vehiculo($vehiculo->id_vehiculo, $vehiculo->modelo);
            $fecha_actual = mdate("%Y-%m-%d");
            foreach ($tareas as $tarea) {
                $tarea->realizado = false;
                if ($tarea->id_servicio == 9) {
                    
                } else if ($tarea->id_servicio == 10) {
                    
                } else {
                    $tarea_cronograma = new stdClass();
                    $periodicidad = $tarea->periodicidad;
                    $periodicidadMeses = $tarea->periodicidad * 12 / $kilometraje_ciudad;
                    $tarea_cronograma->titulo = 'Tarea: ' . $tarea->nombre . '. Realizar cada ' . $periodicidadMeses . ' meses o ' . $periodicidad . 'Kms.';
                    $kiloTemp = $kilometraje_actual % 5000;
                    $cincomil = 5000 - $kiloTemp;
                    $kiloTemp = $kilometraje_actual + $cincomil;
                    $tarea_cronograma_fecha = '';
                    $encontro_fecha = false;
                    for ($index = $kiloTemp; $index <= ($kiloTemp + 12000); $index+=5000) {
                        if ($index % $periodicidad == 0) {
                            $kilo_diff = $index - $kilometraje_actual;
                            $dias_diff = round($kilo_diff * 365 / $kilometraje_ciudad);
                            $time = now() + $dias_diff * 24 * 3600;
                            $siguiente_ano = now() * 24 * 3600 * 365;
                            if (strtotime($time) <= strtotime($siguiente_ano)) {
                                $tarea_cronograma_fecha .= 'Realizar el día: ' . strftime("%B %d de %Y", $time) . '<br/>';
                                $encontro_fecha = true;
                            }
                        }
                    }
                    if ($encontro_fecha) {
                        $tarea_cronograma->img = $tarea->imagen_thumb_url;
                        $tarea_cronograma->fecha = $tarea_cronograma_fecha;
                        $tareas_cronogramas[] = $tarea_cronograma;
                    }
                }
            }
            $data['tareas_cronograma'] = $tareas_cronogramas;
            $this->load->view('usuario/cronograma_listado_view', $data);
        }
    }

    /**
     * Al hace click sobre cotizar soat, se le envía un correo a taller en línea 
     * con los datos del usuario y vehículo 
     */
    function cotizar_SOAT_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->helper('mail');
            $this->load->model('usuario_model');
            $telefono = $this->input->post('telefono');
            $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo');
            $id_usuario = $this->session->userdata('id_usuario');
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $vehiculo = $this->usuario_model->dar_usuario_vehiculo($id_usuario_vehiculo);
            $mensaje = 'El usuario: ' . $usuario->nombres . ' ' . $usuario->apellidos . ' con correo electrónico ' . $usuario->email . ' y teléfono ' . $telefono . ' quisiera cotizar el SOAT para su vehículo:<br/>';
            $mensaje .= 'Marca y línea: ' . $vehiculo->marca . ' ' . $vehiculo->linea . '<br/>';
            $mensaje .= 'Modelo: ' . $vehiculo->modelo . '<br/>';
            $mensaje .= 'Kilometraje: ' . $vehiculo->kilometraje;
            $destinatarios = array();
            $destinatario = new stdClass();
            $destinatario->email = "tallerenlinea@laspartes.com.co";
            $destinatarios[] = $destinatario;

            ob_start();
            $data1['telefono'] = $telefono;
            $data1['vehiculo'] = $vehiculo;
            $data1['usuario'] = $usuario;
            $this->load->view('emails/solicitud_soat_view', $data1);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();
            send_mail($destinatarios, "Solicitud de SOAT", $contenidoHTML, "");
        }
    }

    /**
     * Cuando se realiza click sobre qué pasa si no lo hago en la vista del perfil
     * se abre un lightbox con la información de la tarea y las tareas relacionadas a esta 
     */
    function mostrar_tarea_lightbox_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->model('usuario_model');
            $id_tarea = $this->input->post('tarea');
            $id_vehiculo = $this->input->post('id_vehiculo');
//            $id_usuario = $this->session->userdata('id_usuario'); 
//            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $data['tarea'] = $this->usuario_model->dar_tarea($id_tarea);
            $data['allofertas'] = $this->usuario_model->dar_oferta_por_tarea($id_tarea, $id_vehiculo);
            $this->load->view('usuario/ajax/tarea_view', $data);
        }
    }

    /**
     * Una ves el usuario ya ha aceptado la aplicación de laspartes en FB
     * Entra a este controlador y se hace un login o registra el usuario en el sistema
     */
    function FBLogin() {
        $this->load->model('usuario_model');
        $this->load->model('fb_model');
        $fb_data = $this->session->userdata('fb_data'); // This array contains all the user FB information
//        echo var_dump($fb_data);
        if ((!$fb_data['me'])) {
//            redirect('usuario/redirectFB', 'refresh');
            redirect('registro');
        } else {
            $valido = $this->usuario_model->validar_usuario_fb($fb_data['me']['email']);
            if ($valido == false) {
                $home = $fb_data['me']['hometown']['name'];
                list($ciudad, $pais) = split(', ', $home);
                $usuario = $fb_data['me']['username'];
                $existe = $this->usuario_model->existe_usuario($usuario);
                if ($existe)
                    $usuario = $this->_generar_usuario($usuario);
                $id_usuario = $this->usuario_model->agregar_usuario($fb_data['me']['first_name'], $fb_data['me']['last_name'], $usuario, $fb_data['me']['email'], sha1($fb_data['me']['username']), $ciudad, 30, 'Facebook', $pais);
                $this->usuario_model->actualizar_usuario_imagen_url($id_usuario, 'https://graph.facebook.com/' . $fb_data['me']['username'] . '/picture?type=large');
                $this->usuario_model->validar_usuario_fb($fb_data['me']['email']);
                $usuario = $this->usuario_model->dar_usuario($this->session->userdata("id_usuario"));
                //envia correo de bienvenida a nuestro portal
                $this->load->helper('mail');
                ob_start();
                $data1['usuario'] = $usuario;
                $this->load->view('emails/registro_correo_view', $data1);
                $contenidoHTML = ob_get_contents();
                ob_end_clean();
                ob_flush();
                $destinatarios = array();
                $destinatario = new stdClass();
                $destinatario->email = $usuario->email;
                $destinatarios[] = $destinatario;
                $destinatario = new stdClass();
                $destinatario->email = 'tallerenlinea@laspartes.com.co';
                $destinatarios[] = $destinatario;
                send_mail($destinatarios, "[LasPartes.com] Gracias por registrarte con nosotros", $contenidoHTML, "", $fileName);
            } else {
                $usuario = $this->usuario_model->dar_usuario_segun_mail($fb_data['me']['email']);
                if($usuario->referenciado == 'CRM' && $usuario->estado == 'precreado'){
                    $this->usuario_model->actualizar_usuario($usuario->id_usuario, $usuario->usuario, $usuario->nombres, $usuario->apellidos, $usuario->email, $usuario->lugar, 'CRM_Activo', 'Activo'); 
                    $this->usuario_model->actualizar_usuario_contrasena($usuario->id_usuario, sha1($usuario->usuario));
                }
                    
                if ($usuario->imagen_url == '') {
                    $this->usuario_model->actualizar_usuario_imagen_url($usuario->id_usuario, 'https://graph.facebook.com/' . $fb_data['me']['username'] . '/picture?type=large');
                }
            }

//             echo "<script type='text/javascript'>top.location = '" . $url . "';</script>";
            $data['id_usuario'] = $this->session->userdata("id_usuario");
            $this->load->view('usuario/FB', $data);
        }
    }

    function topsecret() {
        $this->load->model('fb_model');
        $data['fb_data'] = $this->session->userdata('fb_data');
        $this->load->view('usuario/FB', $data);
    }

    function redirectFB() {
        $this->load->model('fb_model');
        $data['fb_data'] = $this->session->userdata('fb_data');
        $this->load->view('usuario/FB', $data);
    }

    /**
     * Se realiza el login del usuario a través de fb por ajax
     */
    function FBLogin_AJAX() {
        $this->load->model('fb_model');
        $this->load->model('usuario_model');
        $fb_data = $this->session->userdata('fb_data'); // This array contains all the user FB information

        if ((!$fb_data['uid']) or (!$fb_data['me'])) {
            // If this is a protected section that needs user authentication
            // you can redirect the user somewhere else
            // or take any other action you need
            redirect('registro');
        } else {
            $this->usuario_model->validar_usuario_fb($fb_data['me']['email']);

            redirect('usuario');
        }
    }

    /**
     * Retorna las líneas de vehículos que pertenecen a la marca dada.
     */
    function dar_linea_vehiculos_marca_ajax() {
        $this->load->model('vehiculo_model');
        $marca = str_replace('_', ' ', $this->input->post('marca'));

        $data = $this->vehiculo_model->dar_lineas_vehiculos_marca($marca);
        $index = 0;
        foreach ($data as $linea) {
            $data[$index]->label = $linea->linea;
            $data[$index]->value = $linea->linea;
            $index++;
        }
        echo json_encode($data);
    }

    /**
     * Carga la hoja de mto correspondiente al vehículo creado
     */
    function dar_hojamto_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->model('usuario_model');
            $id_usuario = $this->session->userdata('id_usuario');
            $vehiculos = ($this->usuario_model->dar_vehiculos_usuario($id_usuario));
            $id_vehiculo = $vehiculos[0]->id_vehiculo;
            $model = $vehiculos[0]->modelo;
            $kilometraje = $vehiculos[0]->kilometraje;
            $usuario = $this->usuario_model->dar_usuario($id_usuario);
            $kilometraje_mensual = $this->usuario_model->dar_kilometraje_ciudad($usuario->lugar) / 12;
            //$kilometraje_mensual = $this->usuario_model->dar_kilometraje_ciudad('Bogotá') / 12;
            $data['kilometraje_mensual'] = $kilometraje_mensual;

            $hojaMto = $this->usuario_model->dar_tareas_vehiculo($id_vehiculo, $model);
            $data['hojaMto'] = $hojaMto;
            $data['kilometraje'] = $kilometraje;
            $this->load->view('login/ajax/hojamto_view', $data);
        }
    }

    /**
     * Agrega el historial de mto del vehículo creado
     */
    function agregar_historial_mto_ajax($vehiculo) {
        if ($this->hay_sesion_activa()) {
            $this->load->model('usuario_model');
            $this->load->helper('date');
            $id_usuario = $this->session->userdata('id_usuario', TRUE);
            $vehiculos = ($this->usuario_model->dar_vehiculos_usuario($id_usuario));
            $meses = Array();
            $kilometrajes = Array();
            $id_tareas = Array();
            parse_str($this->input->post('input_historial_id_tarea'), $id_tareas);
            parse_str($this->input->post('input_historial_mes'), $meses);
            parse_str($this->input->post('input_historial_kilometraje'), $kilometrajes);
            $size = sizeof($id_tareas['input_historial_id_tarea']);
            for ($i = 0; $i < $size; $i++) {
                $id_tarea = $id_tareas['input_historial_id_tarea'][$i];
                $mes = $meses['input_historial_mes'][$i];
                $kilometraje = $kilometrajes['input_historial_kilometraje'][$i];

                if (!empty($kilometraje) || !empty($mes)) {
                    $date = mdate("%Y-%m-%d", now());
                    $newdate = strtotime('-' . $mes . ' month', strtotime($date));
                    $fecha_realizado = mdate("%Y-%m-%d", $newdate);
                    $this->usuario_model->registrar_tarea_realizada_vehiculo($vehiculos[0]->id_usuario_vehiculo, $id_tarea, $fecha_realizado, $kilometraje);
                }
            }
            echo 'true';
        }
    }

    /**
     * Cuando se realiza click sobre qué pasa si no lo hago en la vista del perfil
     * se abre un lightbox con la información de la tarea y las tareas relacionadas a esta 
     */
    function mostrar_ya_hice_lightbox_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_tarea',
                    'rules' => 'trim|required|xss_clean|numeric',
                    'label' => 'id de tarea'
                ), array(
                    'field' => 'id_usuario_vehiculo',
                    'rules' => 'trim|required|xss_clean|numeric',
                    'label' => 'id del vehículo'
                ),
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()) {
                
            } else {
                $this->load->model('usuario_model');
                $id_tarea = $this->input->post('id_tarea');
                $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo');
                $data['vehiculo'] = $this->usuario_model->dar_vehiculo($id_usuario_vehiculo);
//            $usuario = $this->usuario_model->dar_usuario($id_usuario);
                $data['tarea'] = $this->usuario_model->dar_tarea($id_tarea);
//            $data['allofertas'] = $this->usuario_model->dar_oferta_por_tarea($id_tarea, $id_vehiculo);
                $this->load->view('usuario/ajax/ya_hice_view', $data);
            }
        }
    }

    /**
     * Se muestra el formulario con link seguro para que se pueda calificar la experiencia
     * @param type $llave llave del link
     */
    function califica_tu_experiencia($llave) {
        $this->load->model('usuario_model');
        $this->load->model('establecimiento_model');
        $carrito_califica = $this->usuario_model->dar_carrito_califica_experiencia($llave);
        if ($carrito_califica) {
            $id_carrito = $carrito_califica->id_carrito;
            $data['establecimiento'] = $this->establecimiento_model->dar_establecimiento_activo($carrito_califica->id_establecimiento);
            $data['establecimiento_calificacion'] = $this->establecimiento_model->dar_establecimiento_calificacion_promedio($carrito_califica->id_establecimiento);
            $data['id_carrito'] = $id_carrito;
            $data['llave'] = $llave;
            $data['titulo'] = 'Laspartes.com :: Califica tu experiencia';
            $data['header_view'] = 'usuario/header/califica_experiencia_view';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div><div class="div-breadcrumb-espaciador"></div><div><a href="' . base_url() . 'usuario">Mi Cuenta</a></div><div class="div-breadcrumb-espaciador"></div><div>Califica tu experiencia</div>';
            $data['navegacion_view'] = '';
            $data['contenido_view'] = 'usuario/califica_experiencia_view';
            $this->load->view('template/template', $data);
        } else {
            $data['titulo'] = 'Página no Encontrada';
            $data['breadcrumb'] = '<div><a href="' . base_url() . '">Inicio</a></div> <div class="div-breadcrumb-espaciador"></div> <div>Página no encontrada</div>';
            $data['header_view'] = 'error/404/header/404_view';
            $data['navegacion_view'] = '';
            $data['contenido_view'] = 'error/404/404_view';
            $this->load->view('template/template', $data);
        }
    }

    /**
     * Guarda el registro de la calificación de la experiencia
     */
    function calificar_experiencia() {
        $this->load->library('form_validation');
        $this->load->model('usuario_model');
        $reglas = array(
            array(
                'field' => 'llave',
                'label' => 'llave',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'mensaje',
                'label' => 'mensaje',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'calificacion',
                'label' => 'calificacion',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run()) {
            
        } else {
            $this->load->helper('mail');
            $this->load->model('establecimiento_model');
            $llave = $this->input->post('llave');
            $temp = $this->usuario_model->dar_carrito_califica_experiencia($llave);
            $mensaje = $this->input->post('mensaje');
            $data1['mensaje'] = $mensaje;
            $calificacion = $this->input->post('calificacion');
            $data1['calificacion'] = $calificacion;
            $establecimiento = $this->establecimiento_model->dar_establecimiento($temp->id_establecimiento);
            $data1['establecimiento'] = $establecimiento;
            $carrito = $this->usuario_model->dar_carrito_compra($temp->id_carrito);
            $data1['usuario'] = $this->usuario_model->dar_usuario($carrito->id_usuario);
            $this->establecimiento_model->agregar_establecimiento_comentario($establecimiento->id_establecimiento, $carrito->id_usuario, $mensaje, $calificacion);
            $url = base_url() . 'talleres/' . $establecimiento->id_establecimiento . '-' . str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)) . '#talleres-detalle-div-opiniones?utm_source=email&utm_medium=calificado&utm_campaign=calificar%2Bexperiencia';
            $data1['url'] = $url;
            $destinatarios = array();
            $destinatario = new stdClass();
            $destinatario->email = "tallerenlinea@laspartes.com.co";
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = $data1['usuario']->email;
            $destinatarios[] = $destinatario;
            $destinatario = new stdClass();
            $destinatario->email = $establecimiento->email;
            $destinatarios[] = $destinatario;

            ob_start();
            $this->load->view('emails/califica_experiencia_view', $data1);
            $contenidoHTML = ob_get_contents();
            ob_end_clean();
            ob_flush();
            send_mail($destinatarios, $data1['usuario']->nombres . ' ha calificado a ' . $data1['establecimiento']->nombre, $contenidoHTML, "");

            $this->usuario_model->eliminar_llave_califica_experiencia($temp->id_califica_experiencia);

            echo "<script type='text/javascript'>top.location = '" . $url . "';</script>";
        }
    }
    
    
    /**
     * Valida el correo electrónico y contraseña para iniciar sesión
     * @return String-bool true si es correcto el correo electrónico y contraseña
     */
    function validar_usuario_majax() {
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('input_login_email', TRUE));
            $contrasena = sha1($this->input->post('input_login_contrasena', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);

            if (!$resultado)
                echo json_encode(array('status' => false));
            else {
                echo json_encode(array('status' => true, 'msg' => $this->session->userdata('id_usuario')));
            }
    }

    function crm(){
        $this->load->helper('mail');
        $destinatario = new stdClass();
                    $destinatario->email = 'luis.cabarique@laspartes.com.co';
                    $destinatarios[] = $destinatario;
                    send_mail($destinatarios, "[LasPartes.com] Nuevo Carro", "", 'El vehiculo: con id_vehiculo:  fue ingresada al sistema por el id_usuario: ');
        // $this->load->model('usuario_model');
        // $this->usuario_model->agregar_usuario1('lucho', 'cabarique', 'ensuncho', 'borrar2as@bor.com', '1234', 'Bogotá', '30', "borrar", "Colombia", "2323");
        // 
        // $params = array();
        // $params['laspartes_id_usuario_c'] = 12331;
        // $params['first_name'] = 'lucho ';
        // $params['last_name'] = 'cabariq';
        // $params['email1'] = 'casbsdfhhw@asdf.com';
        // $params['primary_address_city'] = 'Bogotá';
        // $params['primary_address_country'] = 'Colombia';
        // $params['phone_home'] = '232332';
        // $this->crm->agregar_usuario_REST($params);
    }

    /**
     * Busca el vehículo que esté más acorde con el dado
     * @return [type] [description]
     */
    function buscar_vehiculo_similar($vehiculo_ingresado){
        $this->load->model('vehiculo_model');
        $vehiculos= $this->vehiculo_model->dar_vehiculos();
        $shortest = -1;
        $closest = -1;
        $vehiculo_seleccionado;
        $vehiculo_ingresado = strtolower($vehiculo_ingresado);
        foreach ($vehiculos as $vehiculo ){
            $word = strtolower($vehiculo->marca. ' '.$vehiculo->linea);
            // calculate the distance between the input word,
            // and the current word
            $lev = levenshtein($vehiculo_ingresado, $word);

            // check for an exact match
            if ($lev == 0) {

                // closest word is this one (exact match)
                $closest = $word;
                $shortest = 0;

                // break out of the loop; we've found an exact match
                break;
            }

            // if this distance is less than the next found shortest
            // distance, OR if a next shortest word has not yet been found
            if ($lev <= $shortest || $shortest < 0) {
                $vehiculo_seleccionado = $vehiculo;
                echo 'compara: '.$vehiculo_ingresado.' vs. '.$word.': ';
                // set the closest match, and shortest distance
                $closest  = $word;
                $shortest = $lev; echo $shortest.'<br/>';
            }
        }

        echo "vehiculo_ingresado word: $vehiculo_ingresado<br/>";
        if ($shortest <= 1) {
            echo "Exact match found: $closest levenshtein: $shortest<br/>";
        } else {
            echo "Did you mean: $closest? levenshtein: $shortest<br/>";
        }
    }

    /**
     * Busca el vehículo que esté más acorde con el dado
     * @return [type] [description]
     */
    function buscar_vehiculo_similar_ajax(){
        $this->load->model('vehiculo_model');
        $vehiculos= $this->vehiculo_model->dar_vehiculos();
        $shortest = -1;
        $closest = -1;
        $proba = -1;
        $vehiculo_similar;
        $vehiculos_seleccionados = array();
        $vehiculo_ingresado = strtolower($this->input->post('vehiculo', TRUE));
        foreach ($vehiculos as $vehiculo ){
            $word = strtolower($vehiculo->marca.' '.$vehiculo->linea);
            // calculate the distance between the input word,
            // and the current word
            $lev = levenshtein($vehiculo_ingresado, $word);

            // check for an exact match
            if ($lev == 0) {

                // closest word is this one (exact match)
                $closest = $word;
                $shortest = 0;

                // break out of the loop; we've found an exact match
                break;
            }

            // if this distance is less than the next found shortest
            // distance, OR if a next shortest word has not yet been found
            if ($lev < $shortest || $shortest < 0) {
                $vehiculos_seleccionados = array();
                $vehiculos_seleccionados[] =  $vehiculo;
                // set the closest match, and shortest distance
                $closest  = $word;
                $shortest = $lev;
            }else if($lev == $shortest){
                $vehiculos_seleccionados[] =  $vehiculo;
            }
        }
       
        if ($shortest <= 0) {
            echo 'true';
        } else {
             foreach ($vehiculos_seleccionados as $vehiculo_seleccionado) {
                $marca_linea_seleccionado = strtolower($vehiculo_seleccionado->marca.' '.$vehiculo_seleccionado->linea);
                $sim = similar_text($vehiculo_ingresado, $marca_linea_seleccionado);
                if($sim > $proba)
                    $vehiculo_similar = $vehiculo_seleccionado;
            }
            echo json_encode($vehiculo_similar);
        }
    }

    /**
     * Busca el vehículo que esté más acorde con el dado
     * @return [type] [description]
     */
    function _buscar_vehiculo_similar($vehiculo_ingresado){
        $this->load->model('vehiculo_model');
        $vehiculos= $this->vehiculo_model->dar_vehiculos();
        $shortest = -1;
        $closest = -1;
        $proba = -1;
        $vehiculo_similar;
        $vehiculo_ingresado = strtolower($vehiculo_ingresado);
        foreach ($vehiculos as $vehiculo ){
            $word = strtolower($vehiculo->marca.' '.$vehiculo->linea);
            // calculate the distance between the input word,
            // and the current word
            $lev = levenshtein($vehiculo_ingresado, $word);

            // check for an exact match
            if ($lev == 0) {

                // closest word is this one (exact match)
                $closest = $word;
                $shortest = 0;

                // break out of the loop; we've found an exact match
                break;
            }

            // if this distance is less than the next found shortest
            // distance, OR if a next shortest word has not yet been found
            if ($lev < $shortest || $shortest < 0) {
                $vehiculos_seleccionado = $vehiculo;
                // set the closest match, and shortest distance
                $closest  = $word;
                $shortest = $lev;
            }
        }
       
        if ($shortest <= 0) {
            return $vehiculos_seleccionado;
        }
    }

    /**
     * Da los datos de un vehículo que pertenece a una flota
     * @return json información del vehículo
     */
    function dar_vehiculo_flota(){
        if ($this->hay_sesion_activa()) {
            $this->load->model('usuario_model');
            $this->load->model('flota_model');
            $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo');
            $data['usuario_vehiculo'] = $this->flota_model->dar_usuario_vehiculo($id_usuario_vehiculo);
            $tareas = array();
            $opciones['trabajos'] = true;
            $tareas_vehiculo = $this->_dar_tareas_vehiculo($data['usuario_vehiculo'], '32000', $opciones);//hay que cambiar el kilometraje por el real
            $tareas = $tareas_vehiculo;
            $sort_vehiculos = array();
            foreach ($tareas as $key => $tarea) {
                if($tarea->realizado)
                    $sort_vehiculos[$key] = strtotime($tarea->fecha);
                else
                    $sort_vehiculos[$key] = 0;
            }
            arsort($sort_vehiculos, SORT_NUMERIC); 
            $fixed_tareas = array();
            foreach ($sort_vehiculos as $key => $sort_vehiculo) {
                $fixed_tareas[] = $tareas_vehiculo[$key];
            }
            $data['tareas'] = $fixed_tareas;
            $data_hmto = $this->_ver_hoja_mantenimiento($id_usuario_vehiculo, $data['usuario_vehiculo']->id_vehiculo, $data['usuario_vehiculo']->modelo);
            $data = array_merge($data, $data_hmto);

            $data['herramientas'] = $this->_ver_herramientas($id_usuario_vehiculo);
            $data['inspecciones'] = $this->_ver_inspecciones($id_usuario_vehiculo);
            // $data['items_compras'] = $this->usuario_model->dar_items_compra_usuario($this->session->userdata('id_usuario'));
            echo json_encode(array('status' => TRUE, 'data' => $data));
        }else{
            echo json_encode(array('status' => FALSE, 'msj' => 'Se encontro un error, intenta iniciar sesión denuevo'));
        }
    }

    /**
     * Da los datos de un vehículo que pertenece a una flota
     * @return json información del vehículo
     */
    function dar_tareas_flota(){
        if ($this->hay_sesion_activa()) {
            $this->load->model('usuario_model');
            $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo');
            $data['usuario_vehiculo'] = $this->usuario_model->dar_usuario_vehiculo($id_usuario_vehiculo);
            $tareas = array();
            $tareas_vehiculo = $this->_dar_tareas_vehiculo($data['usuario_vehiculo'], '32000');//hay que cambiar el kilometraje por el real
            $tareas = $tareas_vehiculo;
            $data['tareas'] = $tareas;
            echo json_encode(array('status' => TRUE, 'data' => $data));
        }else{
            echo json_encode(array('status' => FALSE, 'msj' => 'Se encontro un error, intenta iniciar sesión denuevo'));
        }
    }

    /**
     * da la hoja de mantenimiento de un vehículo y modelo dado
     * @param  int $id_vehiculo id del vehículo
     * @param  int $modelo   modelo del vehículo
     * @return array data de la hoja de mantenimiento
     */
    function _ver_hoja_mantenimiento($id_usuario_vehiculo, $id_vehiculo, $modelo) { 
        $this->load->model('generico_model');
        $this->load->model('flota_model');
        $this->load->helper('date');
        $data['hojas'] = $this->flota_model->dar_tareas_vehiculo_personalizado($id_usuario_vehiculo);
        if(count($data['hojas']) == 0)
            $data['hojas'] = $this->flota_model->dar_tareas_vehiculo($id_vehiculo, $modelo);

        $flota = $this->flota_model->dar_flota_segun_vehiculo($id_usuario_vehiculo);

        // $tareas = $this->generico_model->dar_registros('tareas');
        $tareas = $this->flota_model->dar_tareas_categoria($flota->id_flota);
        $tareaArray = Array();
        $tareaArray['0'] = 'Otro';
        foreach ($tareas as $tarea) {
            $tareaArray[$tarea->id_servicio] = $tarea->nombre;
        }
        $data['tareasCategoria'] = $tareaArray;
        return $data;
    }

    /**
     * Actualiza o agrega una tarea vía ajax al vehículo dado
     */
    function actualizar_htmo_usuario_ajax() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_usuario_vehiculo',
                'label' => 'Vehículo',
                'rules' => 'trim|required|xss_clean|numeric'
            ),array(
                'field' => 'input_periodicidad',
                'label' => 'Periodicidad',
                'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'input_rango',
                'label' => 'Rango de tolerancia',
                'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'input_categoria',
                'label' => 'Tarea',
                'rules' => 'trim|xss_clean'
            // )
            // ,array(
            //     'field' => 'hoja_mto_id_tarea_otros',
            //     'label' => 'ID del elemento',
            //     'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'input_otro',
                'label' => 'Nombre de la tarea nueva',
                'rules' => 'trim|xss_clean'
            // ),array(
            //     'field' => 'imagen',
            //     'label' => 'Imagen de la tarea',
            //     'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);
        if (!$this->form_validation->run()) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => false, 'msg' => validation_errors()));
            // $this->ver_hoja_mantenimiento($id_vehiculo, validation_errors('<div class="mensaje-error canhide">', '</div>'));
        } else {
            $this->load->model('flota_model');
            $this->load->model('vehiculo_model');
            $periodicidades = array();
            $rangos = array();
            $id_servicios = array();
            $otros = array();
            parse_str($this->input->post('input_periodicidad'), $periodicidades);
            parse_str($this->input->post('input_rango'), $rangos);
            parse_str($this->input->post('input_categoria'), $id_servicios);
            parse_str($this->input->post('input_otro'), $otros);
            $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo');
            $id_flota_vehiculo = $this->flota_model->dar_flota_vehiculo($id_usuario_vehiculo)->id_flota_usuario_vehiculo;
            $vehiculo = $this->vehiculo_model->dar_vehiculo_usuario_vehiculo($id_usuario_vehiculo);
            $this->flota_model->borrar_hmto_usuario_vehiculo($id_usuario_vehiculo);

            foreach ($id_servicios as $key => $servicio) {
                $llave = explode('_', $key);
                if($servicio == 0){
                    $id_servicio = $this->vehiculo_model->agregar_servicio_hmto($otros['hmto_otro_'.$llave[2]]);
                    $this->flota_model->agregar_hoja_mto($id_flota_vehiculo, $id_servicio, $periodicidades['hmto_periodicidad_'.$llave[2]], $rangos['hmto_rango_'.$llave[2]]);
                }else{
                    $this->flota_model->agregar_hoja_mto($id_flota_vehiculo, $servicio, $periodicidades['hmto_periodicidad_'.$llave[2]], $rangos['hmto_rango_'.$llave[2]]);

                }
            }
            echo json_encode(array('status' => true));
        }
    }

    /**
     * asigna la hmto a los carros seleccionados
     */
    function asignar_htmo(){
        $this->load->model('flota_model');
        $this->load->model('vehiculo_model');
        $asignar = $this->input->post('id_usuario_vehiculo');
        $tareas = $this->flota_model->dar_tareas_vehiculo_personalizado($asignar);
        if(count($tareas)  > 0){
            foreach (json_decode($this->input->post('asignados')) as $key => $asignado) {
                $this->flota_model->asignar_htmo($asignado, $tareas);
            }
        }else{
            $vehiculo = $this->vehiculo_model->dar_vehiculo_usuario_vehiculo($asignar);

            $tareas = $this->flota_model->dar_tareas_vehiculo($vehiculo->id_vehiculo, $vehiculo->modelo);
            if(count($tareas) > 0){
                foreach (json_decode($this->input->post('asignados')) as $key => $asignado) {
                    $this->flota_model->asignar_htmo($asignado, $tareas);
                } 
            }
        }
    }

    /**
     * Se registra un trabajo que se le halla realizado a un vehículo de un usuario
     */
    function trabajo_realizado_ajax() {
        if ($this->hay_sesion_activa()) {
            $this->load->library('form_validation');
            $reglas = array(
                array(
                    'field' => 'id_usuario_vehiculo',
                    'rules' => 'trim|required|xss_clean|numeric',
                    'label' => 'id del vehículo'
                ),array(
                    'field' => 'trabajo',
                    'rules' => 'trim|required|xss_clean',
                    'label' => 'Trabajo realizado'
                ), array(
                    'field' => 'kilometraje',
                    'rules' => 'trim|xss_clean|numeric',
                    'label' => 'Kilometraje'
                ),
                array(
                    'field' => 'fecha',
                    'rules' => 'trim|required|xss_clean',
                    'label' => 'Fecha'
                )
            );
            $this->form_validation->set_rules($reglas);

            if (!$this->form_validation->run()) {
                $this->form_validation->set_error_delimiters('', '');
                echo json_encode(array('status' => false, 'msg' => validation_errors()));
            } else {
                $this->load->model('usuario_model');
                $this->load->helper('date');
                setlocale(LC_ALL, 'es_ES');
                $id_usuario_vehiculo = $this->input->get_post('id_usuario_vehiculo', TRUE);
                $kilometraje = $this->input->get_post('kilometraje', TRUE);
                $trabajo = $this->input->get_post('trabajo', TRUE);
                $fecha_realizado = $this->input->get_post('fecha', TRUE);
                $this->load->library('upload');
                $this->load->model('usuario_model');
                $id_usuario = $this->session->userdata('id_usuario');
                $upload_path = 'resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/adjuntos/';
                if (!is_dir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/adjuntos')) {
                    mkdir('resources/images/usuarios/' . $id_usuario . '/vehiculos/' . $id_usuario_vehiculo . '/adjuntos', 0777, TRUE);
                }
                $nombreArchivo = 'adjunto-' . $this->_getUniqueCode(10);
                $config = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => 'gif|jpg|png|doc|txt|pdf|tiff|docx|rtf',
                    'max_size' => '10000',
                    'file_name' => $nombreArchivo
                );
                $this->upload->initialize($config);

                if ($this->upload->do_upload('trabajo_realizada_adjunto')) {
                    $imagen = $this->upload->data();
                    $id = $this->usuario_model->registrar_trabajo_realizado($id_usuario_vehiculo, $trabajo, $fecha_realizado, $kilometraje, $upload_path . $imagen['file_name']);
                    echo json_encode(array('status' => true, 'msg' => strftime("%B %d de %Y", strtotime($fecha_realizado)) . "|" . $id . "|" . $trabajo . "|" . $upload_path . $imagen['file_name']));
                } else {
                    $id = $this->usuario_model->registrar_trabajo_realizado($id_usuario_vehiculo, $trabajo, $fecha_realizado, $kilometraje);
                    if ($this->input->get_post('trabajo_realizada_adjunto') != null) {
                        echo json_encode(array('status' => false, 'msg' => $this->upload->display_errors('', '')));
                    } else {
                        echo json_encode(array('status' => true, 'msg' => strftime("%B %d de %Y", strtotime($fecha_realizado)) . "|" . $id . "|" . $trabajo));
                    }
                }
            }
        }
    }

    /**
     * da los trabajos realizados del vehilo de un usuario con el formato
     * para ser ingresado como tareas
     * @param  int $id_usuario_vehiculo id del vehiculo usuario
     * @return [type]                      [description]
     */
    function _dar_trabajos_realizados($id_usuario_vehiculo){
        $trabajos = $this->usuario_model->dar_trabajos_realizados($id_usuario_vehiculo);
        $tareas_asignadas = array();
        foreach ($trabajos as $key => $trabajo) {
            $tareaTemp = new stdClass();
            $tareaTemp->nombre = $trabajo->trabajo;
            $tareaTemp->adjunto = $realizado->adjunto;
            $tareaTemp->due = strftime("%B %d de %Y", strtotime($realizado->trabajo));
            $tareaTemp->fecha = $trabajo->fecha;
            $tareaTemp->realizado = true;
            $tareaTemp->trabajo = true;
            $tareas_asignadas[] = $tareaTemp;
        }
        return $tareas_asignadas;
    }

    /**
     * ve las herramientas de un usuario vehiculo
     * @param  int $id_usuario_vehiculo 
     * @return array herramientas
     */
    function _ver_herramientas($id_usuario_vehiculo){
        return $this->flota_model->dar_herramientas_uv($id_usuario_vehiculo);
    }

    /**
     * actualiza las herramientas de un vehículo
     * @return [type] [description]
     */
    function actualizar_herramientas_ajax(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_usuario_vehiculo',
                'label' => 'Vehículo',
                'rules' => 'trim|required|xss_clean|numeric'
            ),array(
                'field' => 'input_id_herramientas_new',
                'label' => 'nuevas herramientas',
                'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'input_id_herramientas_update',
                'label' => 'Herramientas actualizadas',
                'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'input_id_herramientas_delete',
                'label' => 'Herramientas borradas',
                'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'input_herramientas',
                'label' => 'Herramienta',
                'rules' => 'trim|xss_clean'
            ),array(
                'field' => 'input_vidas',
                'label' => 'Vida útil',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);
        if (!$this->form_validation->run()) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => false, 'msg' => validation_errors()));
        } else {
            $this->load->model('flota_model');
            $this->load->model('vehiculo_model');
            $new = array();
            $update = array();
            $delete = array();
            $herramientas = array();
            $vidas = array();
            parse_str($this->input->post('input_herramientas'), $herramientas);
            parse_str($this->input->post('input_id_herramientas_new'), $new);
            parse_str($this->input->post('input_id_herramientas_update'), $update);
            parse_str($this->input->post('input_id_herramientas_delete'), $delete);
            parse_str($this->input->post('input_vidas'), $vidas);
            $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo');
            // $this->flota_model->borrar_herramientas_vehiculo($id_usuario_vehiculo);
            $this->flota_model->borrar_herramientas_id($delete);

            foreach ($new as $key => $id) {
                $llave = explode('_', $key); 
                $this->flota_model->agregar_herramienta($id_usuario_vehiculo, $herramientas['herrmts_herramienta_'.$llave[2]], $vidas['herrmts_vida_'.$llave[2]]);
            }
            foreach ($update as $key => $id) {
                $llave = explode('_', $key); 
                $this->flota_model->actualizar_herramienta($id_usuario_vehiculo, $id, $herramientas['herrmts_herramienta_'.$llave[2]], $vidas['herrmts_vida_'.$llave[2]]);
            }
            echo json_encode(array('status' => true));
        }
    }

    /**
     * Deja una herramienta como inspeccionada
     */
    function inspeccionar(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_herramientas',
                'label' => 'Herramientas',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);
        if (!$this->form_validation->run()) {
            $this->form_validation->set_error_delimiters('', '');
            echo json_encode(array('status' => false, 'msg' => validation_errors()));
        } else {
            $this->load->model('flota_model');
            $this->load->model('vehiculo_model');
            $herramientas = array();
            parse_str($this->input->post('id_herramientas'), $herramientas);

            foreach ($herramientas as $key => $herramienta) {
                $this->flota_model->inspeccionar($herramienta);
            }
            echo json_encode(array('status' => true));
        }
    }

    /**
     * Da las inpecciones realizadas sobre las herramientas de un vehículo
     * @param  int $id_usuario_vehiculo
     * @return array inspecciones
     */
    function _ver_inspecciones($id_usuario_vehiculo){
        return $this->flota_model->dar_inspecciones($id_usuario_vehiculo);
    }

}

