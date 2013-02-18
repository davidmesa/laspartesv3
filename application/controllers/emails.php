<?php

require_once 'laspartes_controller.php';

/**
 * Controlador que genera el newsletter de noticias
 */
class Emails extends Laspartes_Controller {

    /**
     * Constructor de la clase Inicio
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Correo que sugiere a los clientes actualizar los datos para participar en la rifa de boletas 
     * para la feria
     */
    function actualiza_datos($dataP = array()) {
        $hashValidation = $this->input->post('param');
        if (isset($hashValidation) && $this->validarHash($hashValidation)) {
            $this->load->helper('mail');
            $this->load->model('usuario_model');

            $suscritos = array();
            $suscritos = $this->usuario_model->dar_usuarios_tipo(30);
            foreach ($suscritos as $suscrito) {
                $destinatarios = array();
                $destinatario = new stdClass();
                $destinatario->email = $suscrito->email;
//                            $destinatario->email = "camilohjimenez@gmail.com";
                $destinatarios[] = $destinatario;
                ob_start();
                $this->load->view('emails/actualiza_datos_correo_view');
                $contenidoHTML = ob_get_contents();
                ob_end_clean();
                echo $contenidoHTML;
                send_mail($destinatarios, "Todavía puedes ir al salón internacional del automóvil 2012 invitado por Laspartes.com", $contenidoHTML, "", "");
            }
        }
    }

    /**
     * Envía un email a todos los usuarios sugiriendo a los usuarios que 
     * actualicen la foto, kilometraje y placa para participar en la rifa 
     * por un mantenimiento de bomper a bomper
     */
    function mantenimiento_bomper() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//
//        $suscritos = array();
//        $suscritos = $this->usuario_model->dar_usuarios_tipo(30);
//        foreach ($suscritos as $suscrito) {
////            if($suscrito->email == 'cabarique.luis@hotmail.com'):
//            $destinatarios = array();
//            $destinatario = new stdClass();
//            $destinatario->email = $suscrito->email;
//            $destinatarios[] = $destinatario;
//            ob_start();
//            $this->load->view('emails/mantenimiento_bomper_view');
//            $contenidoHTML = ob_get_contents();
//            ob_end_clean();
////        echo $contenidoHTML;
//            send_mail($destinatarios, "Gana un mantenimiento gratis para tu carro", $contenidoHTML, "", "");
//            echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
////            endif;
//        }
    }

    /**
     * Se envía un correo a los usuarios con carros bmw o mercedes benz ofreciendo
     * un embellecimiento(lavado y polichado) en Eurocars por la compra de un cambio de 
     * aceite en tecnimercedez
     */
    function cambioAceite_mercedes_bmw() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//        $this->load->model('promocion_model');
//
//        //carros BMW
//        $suscritos = array();
//        $suscritos = $this->usuario_model->dar_usuarios_marcaVehiculo('BMW');
//        foreach ($suscritos as $suscrito) {
//                $destinatarios = array();
//                $destinatario = new stdClass();
//                $destinatario->email = $suscrito->email;
//                $destinatarios[] = $destinatario;
//                $data['usuario'] = $suscrito;
//                $data['titulo'] = 'Lavado y polichado gratis por compra de cambio de aceite para tu BMW';
//                $data['oferta'] = $this->promocion_model->dar_oferta(190);
//                $data['condiciones'] = '* promoción válida por compras de cambios de aceite en Tecnimercedes para carros BMW en el mes de Diciembre.<br/>* Lavado y polichado sujetas a disponibilidad de inventario.';
//                if ($suscrito->tipoVehiculo == '1')
//                    $data['url'] = 'http://www.laspartes.com/promociones/190-Cambio-de-aceite-por-388-484-a-trav-s-de-laspartes-com/buscar/categoria/Cambio-de-aceite';
//                elseif ($suscrito->tipoVehiculo == '2')
//                    $data['url'] = 'http://www.laspartes.com/promociones/191-Cambio-de-aceite-por-446-552-a-trav-s-de-laspartes-com/buscar/categoria/Cambio-de-aceite';
//                ob_start();
//                $this->load->view('emails/cambioAceite_bmw_mercedes_view', $data);
//                $contenidoHTML = ob_get_contents();
//                ob_end_clean();
////                echo $contenidoHTML;
//                send_mail($destinatarios, "Lavado general y polichado gratis por compra de cambio de aceite", $contenidoHTML, "", "");
//                echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
//        }
//
//        //carros Mercedes Benz
//        $suscritos = array();
//        $suscritos = $this->usuario_model->dar_usuarios_marcaVehiculo('Mercedes benz');
//        foreach ($suscritos as $suscrito) {
//                $destinatarios = array();
//                $destinatario = new stdClass();
//                $destinatario->email = $suscrito->email;
//                $destinatarios[] = $destinatario;
//                $data['usuario'] = $suscrito;
//                $data['titulo'] = 'Lavado y polichado gratis por compra de cambio de aceite para tu Mercedes Benz';
//                $data['oferta'] = $this->promocion_model->dar_oferta(190);
//                $data['condiciones'] = '* promoción válida por compras de cambios de aceite en Tecnimercedes para carros Mercedes Benz en el mes de Diciembre.<br/>* Lavado y polichado sujetas a disponibilidad de inventario.';
//                if ($suscrito->tipoVehiculo == '1')
//                    $data['url'] = 'http://www.laspartes.com/promociones/188-Cambio-de-aceite-por-441-612-a-trav-s-de-laspartes-com/buscar/categoria/Cambio-de-aceite';
//                elseif ($suscrito->tipoVehiculo == '2')
//                    $data['url'] = 'http://www.laspartes.com/promociones/189-Cambio-de-aceite-por-515-388-a-trav-s-de-laspartes-com/buscar/categoria/Cambio-de-aceite';
//                ob_start();
//                $this->load->view('emails/cambioAceite_bmw_mercedes_view', $data);
//                $contenidoHTML = ob_get_contents();
//                ob_end_clean();
////                echo $contenidoHTML;
//                send_mail($destinatarios, "Lavado general y polichado gratis por compra de cambio de aceite", $contenidoHTML, "", "");
//                echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
//        }
    }

    /**
     * Se envía un correo a los usuarios con carros volvo ofreciendo
     * una revisión general en voltech por la compra de un cambio de 
     * aceite en voltech
     */
    function cambioAceite_volvo() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//        $this->load->model('promocion_model');
//
//        $suscritos = array();
//        $suscritos = $this->usuario_model->dar_usuarios_marcaVehiculo('Volvo');
//        foreach ($suscritos as $suscrito) {
//            $destinatarios = array();
//            $destinatario = new stdClass();
//            $destinatario->email = $suscrito->email;
//            $destinatarios[] = $destinatario;
//            $data['usuario'] = $suscrito;
//            $data['titulo'] = 'Revisión general gratis por compra de cambio de aceite para tu Volvo';
//            if($suscrito->modelo < 2000){
//                $data['url'] = 'http://www.laspartes.com/promociones/230-Cambio-Aceite-por-300-000-a-trav-s-de-laspartes-com/buscar/categoria/Cambio-de-aceite';
//                $data['oferta'] = $this->promocion_model->dar_oferta(230);
//            }
//            else{
//                $data['url'] = 'http://www.laspartes.com/promociones/229-Revision-general-Gratis-por-la-compra-de-Cambio-de-aceite-para-carros-Volvo-con-modelos-2000-en-adelante/buscar/categoria/Cambio-de-aceite';
//                $data['oferta'] = $this->promocion_model->dar_oferta(229);
//            }
//            $data['condiciones'] = '* promoción válida por compras de cambios de aceite en Voltech para carros Volvo en el mes de Diciembre.';
//                
//            ob_start();
//            $this->load->view('emails/cambioAceite_volvo_view', $data);
//            $contenidoHTML = ob_get_contents();
//            ob_end_clean();
////            echo $contenidoHTML;
//            send_mail($destinatarios, "Revision general gratis por compra de cambio de aceite", $contenidoHTML, "", ""); 
//            echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";                
//        }
    }

    /**
     * Se envía un correo a usuarios con carros toyota(camioneta) y audi
     * invitandolos a que ingresen a darle un like en nuestra página de FB
     * preguntando qué accesorios les gustrarían para un regalo de navidad 
     */
    function likeFB_toyota_audi() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//
//        $suscritos = array();
//        $suscritosAudi = $this->usuario_model->dar_usuarios_marcaVehiculo('audi');
//        $suscritosToyota = $this->usuario_model->dar_usuarios_marcaVehiculo('toyota', '2');
//        $suscritos = array_merge((array) $suscritosAudi, (array) $suscritosToyota);
//        foreach ($suscritos as $suscrito) {
//            $destinatarios = array();
//            $destinatario = new stdClass();
//            $destinatario->email = $suscrito->email;
//            $destinatarios[] = $destinatario;
//            ob_start();
//            $this->load->view('emails/likeFB_toyota_audi_view');
//            $contenidoHTML = ob_get_contents();
//            ob_end_clean();
//            send_mail($destinatarios, "Gana un lavado y polichado", $contenidoHTML, "", ""); 
//            echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
//        }
    }
    
    /**
     * Se envía un correo a los usuarios con carros bmw o mercedes benz ofreciendo
     * un cambio de aceite en tecnimercedes por la compra de un embellecimiento(lavado y polichado)
     * en beautifulcar
     */
    function embellecimiento_mercedes_bmw() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//        $this->load->model('promocion_model');
//
//        //carros BMW
//        $suscritos = array();
//        $suscritosBMW = $this->usuario_model->dar_usuarios_marcaVehiculo('BMW');
//        $suscritosMercho = $this->usuario_model->dar_usuarios_marcaVehiculo('Mercedes benz');
//        $suscritos = array_merge((array) $suscritosBMW, (array) $suscritosMercho);
//        foreach ($suscritos as $suscrito) {
////            if($suscrito->email == 'cabarique.luis@gmail.com'):
//                $destinatarios = array();
//                $destinatario = new stdClass();
//                $destinatario->email = $suscrito->email;
//                $destinatarios[] = $destinatario;
//                $data['usuario'] = $suscrito;
//                $data['titulo'] = 'Lleva un cambio de aceite gratis por compra de lavado y polichado para tu BMW y Mercedes Benz';
//                $data['condiciones'] = '* promoción válida por compras de lavado y polichado en Beautifulcar para carros BMW y Mercedes Benz en el mes de Diciembre.<br/>* Cambio de aceite sujeto a disponibilidad de inventario.';
//                if ($suscrito->tipoVehiculo == '1'){
//                    $data['oferta'] = $this->promocion_model->dar_oferta(103);
//                    $data['url'] = 'http://www.laspartes.com/promociones/103-Embellecimiento-por-63-800-a-trav-s-de-laspartes-com/buscar/categoria/Embellecimiento';
//                } 
//                elseif ($suscrito->tipoVehiculo == '2'){
//                    $data['oferta'] = $this->promocion_model->dar_oferta(104);
//                    $data['url'] = 'http://www.laspartes.com/promociones/104-Embellecimiento-por-81-200-a-trav-s-de-laspartes-com/buscar/categoria/Embellecimiento';
//                }
//                    
//                ob_start();
//                $this->load->view('emails/embellecimiento_bmw_mercedes_view', $data);
//                $contenidoHTML = ob_get_contents();
//                ob_end_clean();
////                echo $contenidoHTML;
//                send_mail($destinatarios, "En navidad laspartes.com te regala un cambio de aceite para tu ".$suscrito->marca, $contenidoHTML, "", "");
//                echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
////            endif;
//        }
    }
    
    /**
     * Se envía un correo a todos los usuarios ofreciendo una alineación y 
     * balanceo gratis por compra de llantas
     */
    function combo_llantas_alineacion_balanceo() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//
//        $suscritos = array();
//        $suscritos = $this->usuario_model->dar_usuarios_tipo(30);
//        foreach ($suscritos as $suscrito) {
//            $destinatarios = array();
//            $destinatario = new stdClass();
//            $destinatario->email = $suscrito->email;
//            $destinatarios[] = $destinatario;
//            ob_start();
//            $this->load->view('emails/llantas_promo_view');
//            $contenidoHTML = ob_get_contents();
//            ob_end_clean();
////            echo $contenidoHTML;
//            send_mail($destinatarios, "Gana una alineación y balanceo esta navidad a través de laspartes.com!", $contenidoHTML, "", ""); 
//            echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
//        }
    }  
    
    /**
     * envía un correo que la promoción de la tecnicomecanica para los usuarios que se 
     * les venció
     */
        function tecnicomecanica_gases_promo() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//        $this->load->model('promocion_model');
//        $this->load->helper('date');
//
//        $suscritos = array();
//        $suscritos = $this->usuario_model->dar_usuarios_tecnicomecanica('2013-02-28');
//        $data['oferta'] = $this->promocion_model->dar_oferta(254);
//        foreach ($suscritos as $suscrito) {
//            $destinatarios = array();
//            $destinatario = new stdClass();
//            $destinatario->email = $suscrito->email;
//            $destinatarios[] = $destinatario;
//            $data['usuario'] = $suscrito;
//            ob_start();
//            $this->load->view('emails/tecnicomecanica_promo_view', $data);
//            $contenidoHTML = ob_get_contents();
//            ob_end_clean();
//            $diff_fecha_Tecnicomecanica = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($suscrito->ultima_fecha)) / (60 * 60 * 24); 
////            echo $contenidoHTML;
//            send_mail($destinatarios, "Te quedan ". $diff_fecha_Tecnicomecanica." días para que renueves tu Técnico-mecánica!", $contenidoHTML, "", ""); 
//            echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
//        }
    }
    
    /**
     * Envía correa a todos los usuarios dando promoción de llantas michelin
     */
        function michellin_promo() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//        $this->load->model('promocion_model');
//        $this->load->helper('date');
//
//        $suscritos = array();
//        $suscritos = $this->usuario_model->dar_usuarios_tipo(30);
//        foreach ($suscritos as $suscrito) {
////            if($suscrito->email == 'cabarique.luis@hotmail.com'):
//            $destinatarios = array();
//            $destinatario = new stdClass();
//            $destinatario->email = $suscrito->email;
//            $destinatarios[] = $destinatario;
//            ob_start();
//            $this->load->view('emails/michellin_promo_view');
//            $contenidoHTML = ob_get_contents();
//            ob_end_clean(); 
//            echo $contenidoHTML;
//            send_mail($destinatarios, "Por navidad hasta un 45% dcto. en llantas michelin a través de laspartes.com", $contenidoHTML, "", ""); 
//            echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
//            endif;
//        }
    } 
    
    /**
     * Correo que se envía a todos los usuarios tipo 30, informando cuales
     * fueron los ganadores de paquetes de mantenimiento
     */
    function felicitaciones_ganadores() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//
//        $suscritos = array();
//        $suscritos = $this->usuario_model->dar_usuarios_tipo(30);
//        foreach ($suscritos as $suscrito) {
////            if($suscrito->email == 'cabarique.luis@hotmail.com'):
//            $destinatarios = array();
//            $destinatario = new stdClass();
//            $destinatario->email = $suscrito->email;
//            $destinatarios[] = $destinatario;
//            ob_start();
//            $this->load->view('emails/felicitaciones_ganadores_view');
//            $contenidoHTML = ob_get_contents();
//            ob_end_clean();
////        echo $contenidoHTML;
//            send_mail($destinatarios, "Felicitaciones a nuestros ganadores de paquetes de mantenimiento", $contenidoHTML, "", "");
//            echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
////            endif;
//        }
    }
    
    /**
     * Correo que se envía a los ganadores de paquetes de mantenimiento
     */
    function felicitaciones_ganador() {
//        $this->load->helper('mail');
//        $this->load->model('usuario_model');
//
//        $suscrito = $this->usuario_model->dar_usuario_segun_mail('p.sanchez@biomax.co'); 
//        $data['usuario'] = $suscrito;
//        $data['premio'] = 'Lavado y polichado';
//        $destinatarios = array();
//        $destinatario = new stdClass();
//        $destinatario->email = $suscrito->email;
//        $destinatarios[] = $destinatario;
//        ob_start();
//        $this->load->view('emails/felicitaciones_ganador_view', $data);
//        $contenidoHTML = ob_get_contents();
//        ob_end_clean();
//        echo $contenidoHTML;
//      send_mail($destinatarios, "Ganaste un paquete de mantenimiento para tu vehículo", $contenidoHTML, "", "");
//        echo "Correo enviado a: ".$suscrito->nombres." ".$suscrito->apellidos. " al correo: <strong>".$suscrito->email."</strong><br/>";
    }
    

    /**
     * Valida que el hash que entra como parámetro se haya generado a partir
     * de la fecha en dos formatos. Se utiliza para verificar que este controlador
     * fue llamado desde el script ubicado en la carpeta "tasks"
     * @param type $hash
     * @return type 
     */
    function validarHash($hash = '') {
        $fecha1 = date('Y-F-d');
        $fecha2 = date('Y-m-d');
        $hash1 = md5($fecha1);
        $hash2 = md5($fecha2);
        $param = $hash1 . "|" . $hash2;

        return strcmp($hash, $param) == 0;
    }

}