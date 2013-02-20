<?php

/**
 * Clase que maneja los usuarios
 */
class Usuario extends CI_Controller {

    /**
     * Constructor de la clase Usuario
     */
    function __construct() {
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');
    }

    /**
     * Verifica si existe un mail dado
     * @param String $email
     * @return boolean $no_existe_email true si no existe
     */
    function _no_existe_email($email) {
        $this->load->model('usuario_model');
        $existe = $this->usuario_model->existe_email($email);
        if (!$existe)
            return TRUE;
        else {
            $this->form_validation->set_message('_no_existe_email', 'El correo electrónico dado ya se encuentra registrado.');
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
     * Muestra un carrito de compra con sus detalles
     * @param int $id_carrito_compra
     * @return array con $carrito_compra y $carrito_compra_autopartes
     */
    function _ver_carrito_compra($id_carrito_compra) {
        $this->load->model('usuario_model');
        $data['carrito_compra'] = $this->usuario_model->dar_carrito_compra($id_carrito_compra);
        $data['carrito_compra_autopartes'] = $this->usuario_model->dar_carrito_compra_autopartes($id_carrito_compra);
        return $data;
    }

    /**
     * Da la lista de los carritos de compras
     * @return array $carritos_compras
     */
    function _ver_carritos_compras() {
        $this->load->model('usuario_model');
        $data['carritos_compras'] = $this->usuario_model->dar_carritos_compras();
        return $data;
    }

    /**
     * Muestra la información de un usuario
     * @param int $id_usuario
     * @return array con $usuario, $preguntas, $respuestas, $carritos_compras y $vehiculos
     */
    function _ver_usuario($id_usuario) {
        $this->load->model('usuario_model');
        $this->load->model('pregunta_model');
        $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
        $data['preguntas'] = $this->pregunta_model->dar_preguntas_usuario($id_usuario);
        $data['respuestas'] = $this->pregunta_model->dar_preguntas_respuestas_usuario($id_usuario);
        $data['carritos_compras'] = $this->usuario_model->dar_carritos_compras_usuario($id_usuario);
        $data['vehiculos'] = $this->usuario_model->dar_vehiculos_usuario($id_usuario);
        return $data;
    }

    /**
     * Muestra la información de un usuario
     * @param int $id_usuario
     * @return array con $usuario, $preguntas, $respuestas, $carritos_compras y $vehiculos
     */
    function _ver_recibo($id_usuario, $marca, $linea) {
        $this->load->model('usuario_model');
        $this->load->model('promocion_model');
        $this->load->model('autoparte_model');
        $data['ofertas'] = $this->promocion_model->dar_ofertas_vehiculo(str_replace('_', ' ', $marca), $linea);
        $data['autopartes'] = $this->autoparte_model->dar_autopartes_filtros_vehiculo(str_replace('_', ' ', $marca), $linea);
        $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);
        return $data;
    }

    /**
     * Muestra la información de un usuario
     * @param int $id_usuario
     * @return array $vehiculo, $marcas y $lineas
     */
    function _ver_usuario_vehiculo($id_usuario_vehiculo) { 
        $this->load->model('usuario_model');
        $data['vehiculo'] = $this->usuario_model->dar_usuario_vehiculo($id_usuario_vehiculo);
        $data['marcas'] = $this->usuario_model->dar_vehiculos_marcas();
        $data['lineas'] = $this->usuario_model->dar_vehiculos_lineas($data['vehiculo']->marca);
        $data['soat'] = $this->usuario_model->dar_fecha_legales_SOAT($id_usuario_vehiculo);
        $data['tecnomecanica'] = $this->usuario_model->dar_fecha_legales_Tecnomecanica($id_usuario_vehiculo);
        return $data;
    }

    /**
     * Da la lista de usuarios
     * @return array $usuarios
     */
    function _ver_usuarios() {
        $this->load->model('usuario_model');
        $data['usuarios'] = $this->usuario_model->dar_usuarios();
        return $data;
    }

    /**
     * Actualiza un carrito de compra
     */
    function actualizar_carrito_compra() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_carrito_compra',
                'label' => 'identificador del carrito de compra',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_carrito_compra = $this->input->post('id_carrito_compra', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_carrito_compra($id_carrito_compra);
            $this->load->view('admin/usuario/carrito_compra_detalle_view', $data);
        } else {
            $this->load->model('usuario_model');
            $estado = $this->input->post('estado', TRUE);
            $this->usuario_model->actualizar_carrito_compra($id_carrito_compra, $estado);

            $data = $this->_ver_carritos_compras();
            $data['confirmacion'] = 'El carrito de compra ha sido actualizado con éxito';
            $this->load->view('admin/usuario/carrito_compra_lista_view', $data);
        }
    }

    /**
     * Actualiza una usuario
     */
    function actualizar_usuario() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_usuario',
                'label' => 'identificador del usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'usuario',
                'label' => 'usuario',
                'rules' => 'trim|required|xss_clean'
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
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'lugar',
                'label' => 'lugar',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_usuario = $this->input->post('id_usuario', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_usuario($id_usuario);
            $this->load->view('admin/usuario/usuario_detalle_view', $data);
        } else {
            $this->load->model('usuario_model');
            $usuario = strtolower($this->input->post('usuario', TRUE));
            $nombres = ucwords(strtolower($this->input->post('nombres', TRUE)));
            $apellidos = ucwords(strtolower($this->input->post('apellidos', TRUE)));
            $email = strtolower($this->input->post('email', TRUE));
            $lugar = ucwords(strtolower($this->input->post('lugar', TRUE)));
            $estado = $this->input->post('estado', TRUE);
            $this->usuario_model->actualizar_usuario($id_usuario, $usuario, $nombres, $apellidos, $email, $lugar);
            $this->usuario_model->actualizar_usuario_estado($id_usuario, $estado);

            $data = $this->_ver_usuarios();
            $data['confirmacion'] = 'El usuario ha sido actualizado con éxito';
            $this->load->view('admin/usuario/usuario_lista_view', $data);
        }
    }

    /**
     * Actualiza el vehículo de un usuario
     */
    function actualizar_usuario_vehiculo() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_usuario',
                'label' => 'identificador del usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_usuario_vehiculo',
                'label' => 'identificador del vehículo del usuario',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_vehiculo',
                'label' => 'línea',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'modelo',
                'label' => 'modelo',
                'rules' => 'trim|required|numeric|xss_clean'
            ),
            array(
                'field' => 'kilometraje',
                'label' => 'kilomentraje',
                'rules' => 'trim|numeric|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_usuario = $this->input->post('id_usuario', TRUE);
        $id_usuario_vehiculo = $this->input->post('id_usuario_vehiculo', TRUE);
        if (!$this->form_validation->run()) {
            $data = $this->_ver_usuario_vehiculo($id_usuario_vehiculo);
            $this->load->view('admin/usuario/vehiculo_detalle_view', $data);
        } else {
            $this->load->model('usuario_model');
            $nombre = ucwords(strtolower($this->input->post('nombre', TRUE)));
            $id_vehiculo = $this->input->post('id_vehiculo', TRUE);
            $modelo = $this->input->post('modelo', TRUE);
            $kilometraje = $this->input->post('kilometraje', TRUE);
            $this->usuario_model->actualizar_vehiculo_usuario($id_usuario_vehiculo, $id_vehiculo, $nombre, $modelo, $kilometraje);

            $data = $this->_ver_usuario($id_usuario);
            $data['confirmacion'] = 'El vehículo ha sido actualizado con éxito';
            $this->load->view('admin/usuario/usuario_detalle_view', $data);
        }
    }

    /**
     * Agrega un nuevo usuario
     */
    function agregar_usuario() {
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'usuario',
                'label' => 'usuario',
                'rules' => 'trim|required|callback__no_existe_usuario|xss_clean'
            ),
            array(
                'field' => 'tipo',
                'label' => 'tipo',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'nombres',
                'label' => 'nombres',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'apellidos',
                'label' => 'apellidos',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'correo electrónico',
                'rules' => 'trim|required|valid_email|callback__no_existe_email|xss_clean'
            ),
            array(
                'field' => 'contrasena',
                'label' => 'contraseña',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'lugar',
                'label' => 'lugar',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if (!$this->form_validation->run())
            $this->load->view('admin/usuario/usuario_agregar_view');
        else {
            $this->load->model('usuario_model');
            $usuario = strtolower($this->input->post('usuario', TRUE));
            $tipo = $this->input->post('tipo', TRUE);
            $nombres = ucwords(strtolower($this->input->post('nombres', TRUE)));
            $apellidos = ucwords(strtolower($this->input->post('apellidos', TRUE)));
            $email = strtolower($this->input->post('email', TRUE));
            $contrasena = sha1($this->input->post('contrasena', TRUE));
            $lugar = ucwords(strtolower($this->input->post('lugar', TRUE)));
            $estado = $this->input->post('estado', TRUE);
            $id_usuario = $this->usuario_model->agregar_usuario($nombres, $apellidos, $usuario, $email, $contrasena, $lugar, $tipo);

            $data = $this->_ver_usuarios();
            $data['confirmacion'] = 'El usuario ha sido actualizado con éxito';
            $this->load->view('admin/usuario/usuario_lista_view', $data);
        }
    }

    /**
     * Destruye la sesión y redirecciona a la página principal
     */
    function cerrar_sesion() {
        $this->session->unset_userdata('esta_registrado');
        $this->session->sess_destroy();
        $data['confirmacion'] = 'Sesión cerrada con éxito.';
        $this->load->view('admin/login_view', $data);
    }

    /**
     * Elimina la imagen de un usuario
     */
    function eliminar_usuario_imagen() {
        $id_usuario = $this->uri->segment(4);
        $this->load->model('usuario_model');
        $usuario = $this->usuario_model->dar_usuario($id_usuario);
        $this->usuario_model->eliminar_usuario_imagen($id_usuario);
        if ($usuario->imagen_thumb_url != '' || $usuario->imagen_thumb_url != NULL) {
            unlink($usuario->imagen_url);
            unlink($usuario->imagen_thumb_url);
        }
        $data = $this->_ver_usuario($id_usuario);
        $data['confirmacion'] = 'La imagen ha sido eliminada con éxito';
        $this->load->view('admin/usuario/usuario_detalle_view', $data);
    }

    /**
     * Elimina un vehículo de un usuario
     */
    function eliminar_usuario_vehiculo() {
        $this->load->model('usuario_model');
        $id_usuario_vehiculo = $this->uri->segment(4);
        $vehiculo = $this->usuario_model->dar_usuario_vehiculo($id_usuario_vehiculo);
        if ($vehiculo->imagen_thumb_url != '' || $vehiculo->imagen_thumb_url != NULL) {
            unlink($vehiculo->imagen_url);
            unlink($vehiculo->imagen_thumb_url);
        }
        $this->usuario_model->eliminar_usuario_vehiculo($vehiculo->id_usuario, $id_usuario_vehiculo);
        $data = $this->_ver_usuario($vehiculo->id_usuario);
        $this->load->view('admin/usuario/usuario_detalle_view', $data);
    }

    /**
     * Elimina la imagen de un vehículo de un usuario
     */
    function eliminar_usuario_vehiculo_imagen() {
        $id_usuario_vehiculo = $this->uri->segment(4);
        $this->load->model('usuario_model');
        $vehiculo = $this->usuario_model->dar_usuario_vehiculo($id_usuario_vehiculo);
        $this->usuario_model->eliminar_usuario_vehiculo_imagen($id_usuario_vehiculo);
        if ($vehiculo->imagen_thumb_url != '' || $vehiculo->imagen_thumb_url != NULL) {
            unlink($vehiculo->imagen_url);
            unlink($vehiculo->imagen_thumb_url);
        }
        $data = $this->_ver_usuario_vehiculo($id_usuario_vehiculo);
        $this->load->view('admin/usuario/vehiculo_detalle_view', $data);
    }

    /**
     * Muestra el formulario para agregar un usuario
     */
    function formulario_usuario() {
        $this->load->view('admin/usuario/usuario_agregar_view');
    }

    /**
     * Muestra la lista de usuarios
     */
    function index() {
        $data = $this->_ver_usuarios();
        $this->load->view('admin/usuario/usuario_lista_view', $data);
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
            $this->load->view('admin/login_view');
        else {
            $this->load->model('usuario_model');
            $email = strtolower($this->input->post('email', TRUE));
            $contrasena = sha1($this->input->post('contrasena', TRUE));
            $resultado = $this->usuario_model->validar_usuario($email, $contrasena);

            if (!$resultado) {
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $this->load->view('admin/login_view', $data);
            } else if ($this->session->userdata('tipo') != 10) {
                $data['error'] = 'Correo electrónico o contraseña inválidos.';
                $this->session->unset_userdata('esta_registrado');
                $this->session->sess_destroy();
                $this->load->view('admin/login_view', $data);
            }
            else
                $this->load->view('admin/inicio_view');
        }
    }

    /**
     * Muestra un carrito de compra
     */
    function ver_carrito_compra() {
        $id_carrito_compra = $this->uri->segment(4);
        $data = $this->_ver_carrito_compra($id_carrito_compra);
        $this->load->view('admin/usuario/carrito_compra_detalle_view', $data);
    }

    /**
     * Muestra los carritos de compras de un usuario
     */
    function ver_carritos_compras() {
        $data = $this->_ver_carritos_compras();
        $this->load->view('admin/usuario/carrito_compra_lista_view', $data);
    }

    /**
     * Muestra los detalles de un usuario
     */
    function ver_usuario() {
        $id_usuario = $this->uri->segment(4);
        $data = $this->_ver_usuario($id_usuario);
        $this->load->view('admin/usuario/usuario_detalle_view', $data);
    }

    /**
     * Muestra los detalles de un vehículo de un usuario
     */
    function ver_usuario_vehiculo() {
        $id_usuario_vehiculo = $this->uri->segment(4);
        $data = $this->_ver_usuario_vehiculo($id_usuario_vehiculo);
        $this->load->view('admin/usuario/vehiculo_detalle_view', $data);
    }

    /**
     * Muestra los detalles de un usuario
     */
    function recibo($id_usuario, $basura, $id_vehiculo) {
        $vehiculoMarca;
        $vehiculoLinea;
        if ($id_vehiculo) {
            $temp = split("-", $id_vehiculo, 2);
            $vehiculoMarca = $temp[0];
            $vehiculoLinea = $temp[1];
        }
        $this->load->model('vehiculo_model');
        $this->load->model('generico_model');
        $data['vehiculoMarcaBusqueda'] = $vehiculoMarca;
        if (isset($vehiculoMarca)) {
            $marcaVehObj = $this->generico_model->dar_tildes('vehiculos', 'marca', str_replace('_', ' ', $vehiculoMarca));
            $vehiculoMarca = $marcaVehObj->marca;
        }
        $data['vehiculoLineaBusqueda'] = $vehiculoLinea;
        if (isset($vehiculoLinea)) {
            $marcaObj = $this->generico_model->dar_tildes('vehiculos', 'linea', str_replace('-', ' ', $vehiculoLinea));
            $vehiculoLinea = $marcaObj->linea;
        }
        $data = $this->_ver_recibo($id_usuario, $vehiculoMarca, $vehiculoLinea);
        $data['vehiculoLineaBusqueda'] = $vehiculoLinea;
        $data['vehiculoMarcaBusqueda'] = $vehiculoMarca;

        $data['allvehiculos'] = $this->vehiculo_model->dar_vehiculos();
        $index = 0;
        foreach ($data['allvehiculos'] as $vehiculo) {
            $data['allvehiculos'][$index]->label = str_replace(" ", "_", $vehiculo->marca) . ' ' . $vehiculo->linea;
            $data['allvehiculos'][$index]->value = str_replace(" ", "_", $vehiculo->marca) . ' ' . $vehiculo->linea;
            $index++;
        }
        $this->load->view('admin/usuario/usuario_recibo_view', $data);
    }

    function generar_recibo() {
        $this->load->model('usuario_model');
        $this->load->model('refventa_model');
        $this->load->model('autoparte_model');
        $this->load->model('refventa_model');
        $this->load->model('promocion_model');
        $refVenta = $this->refventa_model->generar_RefVenta_Unico();
        $id_usuario = $this->input->post('id_usuario');
        $nombres = $this->input->post('nombres');
        $documento = $this->input->post('documento');
        $email = $this->input->post('email');
        $ciudadEnvio = $this->input->post('ciudadEnvio');
        $direccionEnvio = $this->input->post('direccionEnvio');
        $telefonoMovil = $this->input->post('telefonoMovil');
        $carro = $this->input->post('id_vehiculos');
        $placa = $this->input->post('placa');
        $id_autopartes = $this->input->post('idAutoparte');
        $cant_autoparte = $this->input->post('cantAutoparte');
        $id_ofertas = $this->input->post('idOferta');
        $cant_ofertas = $this->input->post('cantOferta');
        $usuario = $this->usuario_model->dar_usuario($id_usuario);
        $total = 0;
        foreach ($id_ofertas as $index => $id_oferta):
            if ($id_oferta != 0 && $cant_ofertas[$index] != 0) {
                $ofertamodel = $this->promocion_model->dar_oferta($id_oferta);
                if ($ofertamodel->dco_feria != 0):
                    $precio = $ofertamodel->precio;
                    $iva = round($ofertamodel->iva);
                    $dco = $ofertamodel->dco_feria;
                    $base = $precio - $iva;
                    $ivaPorce = $iva / $base;
                    $valorDco = $base * ((100 - $dco) / 100);
                    $precionConDco = ($valorDco * (1 + $ivaPorce));
                    $total += ($precionConDco * $cant_ofertas[$index]);
                else:
                    $total += ($ofertamodel->precio * $cant_ofertas[$index]);
                endif;
            }
        endforeach;
        foreach ($id_autopartes as $i => $id_autoparte):
            if ($id_autopartes != 0 && $cant_autoparte[$i] != 0) {
                $autoparteModel = $this->autoparte_model->dar_autoparte_establecimiento_primero($id_autoparte);
                $total += $autoparteModel->precio * $cant_autoparte[$i];
            }
        endforeach;
        
        $id_carrito = $this->usuario_model->agregar_carrito_compras($usuario->id_usuario, 'Transacción aprobada', round($total), $nombres, $ciudadEnvio, $telefonoMovil, $direccionEnvio, $email, $documento, $carro, $placa);
        foreach ($id_ofertas as $index => $id_oferta):
            if ($id_oferta != 0 && $cant_ofertas[$index] != 0)
                $this->usuario_model->agregar_carrito_compras_ofertas($id_carrito, $id_oferta, $cant_ofertas[$index]);
        endforeach;
        foreach ($id_autopartes as $i => $id_autoparte):
            if ($id_autopartes != 0 && $cant_autoparte[$i] != 0) {
                $autoparteModel = $this->autoparte_model->dar_autoparte_establecimiento_primero($id_autoparte);
                $usuario = $this->usuario_model->agregar_carrito_compras_articulo($id_carrito, $autoparteModel->id_establecimiento, $autoparteModel->id_autoparte, $autoparteModel->precio, $cant_autoparte[$i], $autoparteModel->descripcion);
            }
        endforeach;
        $this->refventa_model->agregar_RefVenta($refVenta, $id_carrito);
        $this->_generar_factura($refVenta, $mensaje = "");
        $url = base_url().'admin/usuario/recibo/' . $id_usuario;
        echo "<script type='text/javascript'>top.location = '" . $url . "';</script>";
//        redirect('admin/usuario/recibo/' . $id_usuario);
    }

    function _generar_factura($refVenta, $mensaje = "") {
        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");
        $this->load->library('pdf');
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
        // set document information
        $this->pdf->SetSubject('Recibo de caja de laspartes.com');

        // set font
        $this->pdf->SetFont("helveticaBI", "", 11);

        // add a page
        $this->pdf->AddPage();

        $html = '<table>
                <tr>
                    <td width="30%">
                        <img width="500" height="350" src="http://www.laspartes.com/resources/template/header/logo-laspartes.png" alt="laspartes.com" />
                    </td>
                    <td width="50%">
                        LASPARTES.COM.CO LTDA.<br/>
                        NIT 900216983-8<br/>
                        Calle 98 # 18 - 71 Piso 2<br/>
                        Tel: 1-6014826 | 1-3819790<br/>
                        e-mail: contactenos@laspartes.com.co<br/>
                        Bogotá, Colombia
                    </td>
                    <td width="3%">
                    </td>
                    <td width="17%" valign="top">
                        <span style="color:#c60200;">RECIBO DE CAJA</span>
                        <div style="color:white; background-color:#c60200; ">No.</div>
                        <span style="border:1px solid #c60200; ">' . str_pad($consecutivo, 4, '0', STR_PAD_LEFT) . '</span><br/>
                        <div style="color:white; background-color:#c60200; ">FECHA</div>
                        <span style="border:1px solid #c60200; ">' . $venta->fecha . '</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="border:5px solid #c60200;">
                            <br/>&nbsp;&nbsp;CLIENTE: ' . $venta->nombre_apellido . ' <br/>
                            &nbsp;&nbsp;DOCUMENTO: ' . $venta->documento . '<br/>
                            &nbsp;&nbsp;CIUDAD: ' . $venta->ciudad . '<br/>
                            &nbsp;&nbsp;DIRECCIÓN: ' . $venta->direccion . '<br/>
                            &nbsp;&nbsp;TELEFONO: ' . $venta->telefono . '<br/>
                            &nbsp;&nbsp;CARRO: ' . $venta->carro . '<br/>
                            &nbsp;&nbsp;PLACA DEL CARRO: ' . $venta->placa . '<br/>
                        </div>
                    </td>
                    <td>
                    </td>
                    <td>
                        <div style="color:white; background-color:#c60200; ">FECHA DE PAGO</div>
                        <span style="border:1px solid #c60200; ">' . $venta->fecha . '</span><br/>
                        <div style="text-align:center;  font-size:100px;">
                        </div>
                    </td>
                </tr>
            </table>';

        // output the HTML content
        $this->pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table border="5" style="border-color:#c60200;">
                <tr align="center" style="font-size:100px;">
                    <th  width="20%" bgcolor="#c60200" style="color:white;">AUTOPARTE</th>
                    <th  width="9%" bgcolor="#c60200" style="color:white;">CANT.</th>
                    <th  width="45%" bgcolor="#c60200" style="color:white;">OBSERVACIÓN</th>
                    <th  width="13%" bgcolor="#c60200" style="color:white;">PRECIO UNIT.</th>
                    <th  width="13%" bgcolor="#c60200" style="color:white;">PRECIO TOTAL</th>
                </tr>';
        foreach ($autopartes as $row):
            $destinatario = new stdClass();
            $destinatario->email = $row->email;
            $destinatarios[] = $destinatario;
            $valorSum += $row->precio * $row->cantidad;
            $ivaSum += round($row->precio - ($row->precio / 1.16)) * $row->cantidad;
            $html .= '<tr style="font-size:90px;"><td> ' . $row->autoparte . ' <br/><br/>Taller responsable: ' . $row->establecimiento . '<br/>' . $row->direccion . '<br/>' . $row->telefonos . '</td><td style="text-align:center;">' . $row->cantidad . '</td><td>' . $row->observacion . '</td><td style="text-align:center;">$ ' . number_format($row->precio, 0, ',', '.') . '</td><td style="text-align:center;">$ ' . number_format($row->precio * $row->cantidad, 0, ',', '.') . '</td></tr>';
        endforeach;
        $html .='
                </table>';
        $this->pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table border="5" style="border-color:#c60200;">
                <tr align="center" style="font-size:100px;">
                    <th  width="20%" bgcolor="#c60200" style="color:white;">OFERTA</th>
                    <th  width="9%" bgcolor="#c60200" style="color:white;">CANT.</th>
                    <th  width="45%" bgcolor="#c60200" style="color:white;">INCLUYE</th>
                    <th  width="13%" bgcolor="#c60200" style="color:white;">PRECIO UNIT.</th>
                    <th  width="13%" bgcolor="#c60200" style="color:white;">PRECIO TOTAL</th>
                </tr>';
        foreach ($ofertas as $row1):
            $destinatario = new stdClass();
            $destinatario->email = $row1->email;
            $destinatarios[] = $destinatario;
            if ($row1->dco_feria != 0):
                $precio = $row1->precio;
                $iva = $row1->iva;
                $dco = $row1->dco_feria;
                $base = $precio - $iva;
                $ivaPorce = $iva / $base;
                $valorDco = $base * ((100 - $dco) / 100);
                $precionConDco = ($valorDco * (1 + $ivaPorce));
                $valorSum += $precionConDco * $row1->cantidad;
                $ivaSum += round($precionConDco - $valorDco) * $row1->cantidad;
                $html .= '<tr style="font-size:90px;"><td> ' . $row1->titulo . ' <br/><br/>Taller responsable: ' . $row1->establecimiento . '<br/>' . $row1->direccion . '<br/>' . $row1->telefonos . '</td><td style="text-align:center;">' . $row1->cantidad . '</td><td>' . $row1->incluye . '<br/><strong>Condiciones</strong><br/>' . $row1->condiciones . '</td><td style="text-align:center;">$ ' . number_format($precionConDco, 0, ',', '.') . '</td><td style="text-align:center;">$ ' . number_format($precionConDco * $row1->cantidad, 0, ',', '.') . '</td></tr>';
            else:
                $ivaSum += round($row1->iva) * $row1->cantidad;
                $valorSum += $row1->precio * $row1->cantidad;
                $html .= '<tr style="font-size:90px;"><td> ' . $row1->titulo . ' <br/><br/>Taller responsable: ' . $row1->establecimiento . '<br/>' . $row1->direccion . '<br/>' . $row1->telefonos . '</td><td style="text-align:center;">' . $row1->cantidad . '</td><td>' . $row1->incluye . '<br/><strong>Condiciones</strong><br/>' . $row1->condiciones .  '</td><td style="text-align:center;">$ ' . number_format($row1->precio, 0, ',', '.') . '</td><td style="text-align:center;">$ ' . number_format($row1->precio * $row1->cantidad, 0, ',', '.') . '</td></tr>';
            endif;

        endforeach;
        $html .='
                </table>';
        $this->pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table cellpadding="0" cellspacing="0"border="0">
                    <tr>
                        <td width="70%">
                            <div style="border:5px solid #c60200;">
                                OBSERVACIONES<br/>
                                La referencia de su pedido es: ' . $venta->referencia . '<br/>
                                Costos de envío no están incluídos, dependen del peso y destino de la autoparte.<br/>
                                Precios sujetos a disponibilidad.    
                            </div>
                        </td>
                        <td width="3%">
                        </td>
                        <td width="15%" style="font-size:100px;">
                           <div style="color:white; background-color:#c60200; ">
                                SUBTOTAL
                            </div> 
                            <div style="color:white; background-color:#c60200; ">
                                I.V.A
                            </div> 
                            <div style="color:white; background-color:#c60200; ">
                                TOTAL
                            </div> 
                        </td>
                        <td width="12%" style="font-size:100px;">
                           <div style="border:1px solid #c60200; ">
                                $' . number_format($valorSum - $ivaSum, 0, ',', '.') . '
                            </div> 
                            <div style="border:1px solid #c60200; ">
                                $' . number_format($ivaSum, 0, ',', '.') . '
                            </div> 
                            <div style="border:1px solid #c60200; ">
                                $' . number_format($valorSum, 0, ',', '.') . '
                            </div> 
                        </td>
                    </tr>
                </table';
        $this->pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table>
                    <tr>
                        <td width="45%">
                            <div style="border:5px solid #c60200;">
                                ACEPTADO<br/>
                            </div>
                        </td>
                        <td width="10%">
                        </td>
                        <td width="45%">
                            <div style="border:5px solid #c60200;">
                                VENDEDOR<br/>
                            </div>
                        </td>
                    </tr>
                </table';
        $this->pdf->writeHTML($html, true, false, true, false, '');


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
        $data1['mensaje'] = $mensaje;
        $data1['venta'] = $venta;
        $data1['autopartes'] = $autopartes;
        $data1['ofertas'] = $ofertas; 


        $this->load->view('emails/recibo_compra_view', $data1);
        $contenidoHTML = ob_get_contents();
        ob_end_clean();
        ob_flush();
        $filePath = 'resources/facturas';
        $fileName = 'recibo-' . $refVenta . '.pdf';
        $this->pdf->Output($filePath . '/' . $fileName, 'F');
        send_mail($destinatarios, "Recibo de compra LasPartes.com - " . strftime("%B %d de %Y"), $contenidoHTML, "", $fileName);
    }

    /**
     * Da los usuarios registrados después de la fecha 
     */
    function nuevos_usuarios() {
        $this->load->model('usuario_model');
        $data['cantidad'] = $this->usuario_model->dar_usuarios_registrados('2012-01-01');
        $data['cantidadCarros'] = $this->usuario_model->dar_carros_registrados('2012-01-01');
        $this->load->view('admin/usuario/nuevos_usuarios_view', $data);
    }

    function bono($id_usuario) {
        $this->load->model('vehiculo_model');
        $this->load->model('usuario_model');
        $this->load->model('establecimiento_model');
        $data['usuario'] = $this->usuario_model->dar_usuario($id_usuario);

        $data['allvehiculos'] = $this->vehiculo_model->dar_vehiculos();
        $index = 0;
        foreach ($data['allvehiculos'] as $vehiculo) {
            $data['allvehiculos'][$index]->label = $vehiculo->marca . ' ' . $vehiculo->linea;
            $data['allvehiculos'][$index]->value = $vehiculo->marca . ' ' . $vehiculo->linea;
            $index++;
        }
        $data['establecimientos'] = $this->establecimiento_model->dar_establecimientos();
        $this->load->view('admin/usuario/usuario_bono_view', $data);
    }

    /**
     * Genera el bono del usuario 
     */
    function generar_bono() {
        $this->load->model('usuario_model');
        $this->load->model('refventa_model');
        $this->load->model('autoparte_model');
        $this->load->model('refventa_model');
        $this->load->model('promocion_model');
        $id_usuario = $this->input->post('id_usuario');
        $nombres = $this->input->post('nombres');
        $email = $this->input->post('email');
        $ciudadEnvio = $this->input->post('ciudadEnvio');
        $direccionEnvio = $this->input->post('direccionEnvio');
        $telefonoMovil = $this->input->post('telefonoMovil');
        $id_vehiculo = $this->input->post('vehiculo_id');
        $id_taller = $this->input->post('id_talleres');
        $bono = $this->input->post('bono');
        $consecutivo = $this->usuario_model->agregar_bono_usuario($id_usuario, $id_taller, $id_vehiculo, $nombres, $email, $ciudadEnvio, $direccionEnvio, $telefonoMovil, $bono);
        $this->_generar_bono($consecutivo);

        redirect('admin/usuario/recibo/' . $id_usuario);
    }

    /**
     * Genera el el pdf del bono y se lo envía a la persona y taller en línea
     * @param type $consecutivo 
     */
    function _generar_bono($consecutivo) {
        setlocale(LC_ALL, 'es_ES');
        define("CHARSET", "iso-8859-1");
        $this->load->library('pdf');
        $this->load->model('usuario_model');
        $this->load->helper('mail');
        $destinatarios = array();
        $venta = $this->usuario_model->dar_bono($consecutivo);
        // set document information
        $this->pdf->SetSubject('Orden de remisión de laspartes.com');

        // set font
        $this->pdf->SetFont("helveticaBI", "", 11);

        // add a page
        $this->pdf->AddPage();

        $html = '<table>
                <tr>
                    <td width="30%">
                        <img width="500" height="350" src="http://www.laspartes.com/resources/template/header/logo-laspartes.png" alt="laspartes.com" />
                    </td>
                    <td width="50%">
                        LASPARTES.COM.CO LTDA.<br/>
                        NIT 900216983-8<br/>
                        Calle 98 # 18 - 71 Piso 2<br/>
                        Tel: 1-6014826 | 1-3819790<br/>
                        e-mail: contactenos@laspartes.com.co<br/>
                        Bogotá, Colombia
                    </td>
                    <td width="3%">
                    </td>
                    <td width="17%" valign="top">
                        <span style="color:#c60200;">ORDEN DE REMISIÓN</span>
                        <div style="color:white; background-color:#c60200; ">No.</div>
                        <span style="border:1px solid #c60200; ">' . str_pad($consecutivo, 4, '0', STR_PAD_LEFT) . '</span><br/>
                        <div style="color:white; background-color:#c60200; ">FECHA</div>
                        <span style="border:1px solid #c60200; ">' . $venta->fecha . '</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="border:5px solid #c60200;">
                            <br/>&nbsp;&nbsp;CLIENTE: ' . $venta->nombres . ' <br/>
                            &nbsp;&nbsp;CIUDAD: ' . $venta->lugar . '<br/>
                            &nbsp;&nbsp;DIRECCIÓN: ' . $venta->direccion . '<br/>
                            &nbsp;&nbsp;TELEFONO: ' . $venta->telefono . '<br/>
                        </div>
                    </td>
                    <td>
                    </td>
                    <td>
                        <div style="color:white; background-color:#c60200; ">FECHA DE PAGO</div>
                        <span style="border:1px solid #c60200; ">' . $venta->fecha . '</span><br/>
                        <div style="text-align:center;  font-size:100px;">
                        </div>
                    </td>
                </tr>
            </table>';

        // output the HTML content
        $this->pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table border="5" style="border-color:#c60200;">
                <tr align="center" style="font-size:100px;">
                    <th  width="20%" bgcolor="#c60200" style="color:white;">ITEM</th>
                    <th  width="9%" bgcolor="#c60200" style="color:white;">CANT.</th>
                    <th  width="60%" bgcolor="#c60200" style="color:white;">DESCRIPCIÓN</th>
                </tr>';
        $html .= '<tr style="font-size:90px;"><td> Orden de remisión <br/><br/>Taller responsable: ' . $venta->nombreEstablecimiento . '<br/>' . $venta->direccionestablecimiento . '<br/>' . $venta->telefonosEstablecimientos . '</td><td style="text-align:center;">1</td><td>' . $venta->descripcion . '</td></tr>';
        $html .='
                </table>';
        $this->pdf->writeHTML($html, true, false, true, false, '');



        $html = '<table cellpadding="0" cellspacing="0"border="0">
                    <tr>
                        <td width="70%">
                            <div style="border:5px solid #c60200;">
                                OBSERVACIONES<br/>
                                <br/>Esta orden de remisión aplica para el vehículo: ' . $venta->marca . ' ' . $venta->linea . '
                            </div>
                        </td>
                        <td width="3%">
                        </td>
                    </tr>
                </table';
        $this->pdf->writeHTML($html, true, false, true, false, '');

        $html = '<table>
                    <tr>
                        <td width="45%">
                            <div style="border:5px solid #c60200;">
                                ACEPTADO<br/>
                            </div>
                        </td>
                        <td width="10%">
                        </td>
                        <td width="45%">
                            <div style="border:5px solid #c60200;">
                                VENDEDOR<br/>
                            </div>
                        </td>
                    </tr>
                </table';
        $this->pdf->writeHTML($html, true, false, true, false, '');

        $destinatario = new stdClass();
        $destinatario->email = $venta->emailEstablecimientos;
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = $venta->email;
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = "tallerenlinea@laspartes.com.co";
        $destinatarios[] = $destinatario;
        $destinatario = new stdClass();
        $destinatario->email = "ventas@laspartes.com.co";
        $destinatarios[] = $destinatario;

        $mensajeCorreo = 'A continuación puedes ver el resumen de tu orden de remisión:<br/><br/>
            Nombres: ' . $venta->nombres . '<br/>
            Email: ' . $venta->email . ' <br/>   
            Ciudad: ' . $venta->lugar . ' <br/>  
            Direccion: ' . $venta->direccion . ' <br/>  
            Telefono: ' . $venta->telefono . '<br/>
            Orden de remisión: ' . $venta->descripcion . ' <br/>';

        $filePath = 'resources/facturas';
        $fileName = 'orden-de-remision-' . $consecutivo . '.pdf';
        $this->pdf->Output($filePath . '/' . $fileName, 'F');
        send_mail($destinatarios, "Orden de remisión a través de LasPartes.com", $mensajeCorreo, "", $fileName);
    }

}