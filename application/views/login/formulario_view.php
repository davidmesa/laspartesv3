<div id="home-div-content" class="margin-bottom-registro">
    <div id="novedades-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo" style="margin-top: 35px;">

                <h1 style="font-size: 30px;">CREA AQUÍ EL PERFIL DE TU VEHÍCULO</h1>
                <h1>¡Y NOSOTROS NOS ENCARGAMOS DEL MANTENIMIENTO!</h1>
            </div>  
        </div>
        <div class="clear"></div>
    </div>

    <div id="autopart-div-banner-bottom"></div>



    <div class="div-content">
        <div class="clear"></div>
        <div class="div-content-registro">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono">
                    <img src="<?php echo base_url(); ?>resources/images/autopartes/mi-vehiculo.png" alt="icono autopartes" />
                </div>
                <div id="autopart-div-titulo">
                    <h1>
                        <span style="color: #C60200;">REGISTRAR</span>
                        <span> MI VEHÍCULO</span>
                    </h1>
                </div>


                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>
            <div id="registrar-div-content">
                <?php echo $confirmacion; ?>
                <div id="registar-div-content-header1">
                    ES COMO TENER TU PROPIO TALLER, ESTA VEZ EN LÍNEA
                </div>
                <div id="registar-div-content-header2">
                    Nosotros te avisamos qué debes tener en cuenta, cuándo tienes que hacerlo, y quiénes pueden hacerte el mantenimiento adecuado
                </div>

                <div id="registrar-div-form-registro">
                    <input type="hidden" value="" id="input-registro-callback"/>
                    <div id="loging-div" class="login-div-registro">
                        <div id="login-div-center"  class="sesion-login">


                            <div id="login-div-sesion">
                                <div id="login-div-titulo">
                                    <img src="<?php echo base_url(); ?>resources/images/login/mayor-que-404040.png" alt="flechas de registro"/><span>INICIA TU SESIÓN</span>
                                </div>
                                <form id="form_login">
                                    <div class="form_login_div_campo">
                                        <label>Email:</label>
                                        <input type="text" name="input_login_email" id="input_login_email" class="input_login_email form_login_input"/><div for="input_login_email"></div>
                                    </div>
                                    <div class="form_login_div_campo">
                                        <label>Contraseña:</label>
                                        <input type="password" name="input_login_contrasena" id="input_login_contrasena" class="input_login_contrasena form_login_input"/><div for="input_login_contrasena"></div>
                                    </div>
                                    <div id="login-div-ingresarolvidar">
                                        <div id="login-div-olvide">
                                            <a href="<?php echo base_url(); ?>usuario/formulario_olvido_contrasena">Olvidé mi contraseña</a>
                                        </div>
                                        <input type="submit" name="input_login_contrasena" id="input-login-contrasena" class="input-registrate-submit" value="Ingresar"/>
                                        <img src="<?php echo base_url(); ?>resources/images/login/ajax-loader.gif" class="ajax_img_loader" />
                                        <div class="clear"></div>
                                    </div>
                                    <br/>
                                    <img id="home-div-facebook-button" class="home-div-facebook-button" src="<?php echo base_url(); ?>resources/images/login/facebook-conectar-boton.png"/>
                                </form>
                            </div>
                            <div id="login-div-registrate">
                                <div id="login-div-titulo">
                                    <img src="<?php echo base_url(); ?>resources/images/login/mayor-que-404040.png" alt="flechas de registro"/><span>REGÍSTRATE</span>
                                </div>

                                <form id="form_registro">
                                    <div class="form_login_div_campo">
                                        <label>Correo electrónico: </label>
                                        <input class="form_registro_input" onblur="validar_correo(this)"  type="text" name="input_registrate_email" id="input-registrate-email"  title="Ingresa tu correo electrónico"/><div for="input-registrate-email"></div>
                                    </div>
                                    <div class="form_login_div_campo">
                                        <label>Contraseña:</label>
                                        <input class="form_registro_input" type="password" name="input_registrate_contrasena" id="input-registrate-contrasena"  title="Ingresa tu contraseña"/><div for="input-registrate-contrasena"></div>
                                    </div>
                                    <div class="form_login_div_campo">
                                        <label>Repite tu contraseña:</label>
                                        <input class="form_registro_input" type="password" name="input_registrate_contrasena_repite" id="input-registrate-contrasena-repite"  title="Repite tu contraseña"/><div for="input-registrate-contrasena-repite"></div>
                                    </div>
                                    <div class="form_login_div_campo">
                                        <label>Nombres:</label>
                                        <input class="form_registro_input" type="text" name="input_registrate_nombre" id="input-registrate-nombre" title="Ingresa tus nombres"/><div for="input-registrate-nombre"></div>
                                    </div>
                                    <div class="form_login_div_campo">
                                        <label>Apellidos:</label>
                                        <input class="form_registro_input" type="text" name="input_registrate_apellidos" id="input-registrate-apellidos"  title="Ingresa tus apellidos"/><div for="input-registrate-apellidos"></div>
                                    </div>
                                    <div class="form_login_div_campo">
                                        <label>Número telefónico: *opcional</label>
                                        <input class="form_registro_input" type="text" name="input_registrate_telefono" id="input-registrate-telefono"  title="Ingresa tu número telefónico" /><div for="input-registrate-telefono"></div>
                                    </div>
                                    <div class="form_login_div_campo">
                                        <label>¿En qué ciudad vives?:</label>
                                        <?php
                                        $option_ciudades = array();
                                        $selected = false;
                                        $ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Cúcuta", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
                                        foreach ($ciudades as $ciudad) {
                                            if ($ciudad != 'default') {
                                                $option_ciudades[$ciudad] = $ciudad;
                                                if (!$selected) {
                                                    $selected = $ciudad;
                                                }
                                            }
                                        }
                                        echo form_dropdown('ciudad_registrarse', $option_ciudades, 'Bogotá', 'id="input-registrate-ciudad" title="En qué ciudad vives" class="form_registro_ie_select"'); //, 'id="marca_registrarse"');
                                        ?>
                                    </div> 
                                    <div class="form_login_div_campo">
                                        <label>Escribe los 4 dígitos de la imagen:</label>
                                        <div id="registrar-div-login-captcha"><?php echo $captcha['image']; ?></div>
                                        <input type="text" name="captcha_registrarse" id="input_login_captcha" class="input_login_captcha form_registro_input"/>
                                    </div>

                                    <div class="form_login_div_campo div_campo_chkbox">
                                        <input type="checkbox" name="ckbox_registrate_chkbox" id="ckbox-registrate-chkbox"/><label id="label-registrate-condiciones">Acepto los <a href="<?php echo base_url(); ?>acerca/terminos_condiciones"><span>términos y condiciones</span></a></label>
                                    </div>   
                                    <div id="div-registrate-submit" class="div-registrate-submit">
                                        <input type="submit" name="input_registrate_submit" id="input-registrate-submit" class="input-registrate-submit" value="Enviar"/>
                                        <img src="<?php echo base_url(); ?>resources/images/login/ajax-loader.gif" class="ajax_img_loader" />
                                        <div class="clear"></div>
                                    </div>
                                </form>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div>

                    <!--vista que contiene la información del vehículo-->
                    <div id="loging-div" class="login-div-vehiculo">
                        <div id="login-div-center" class="sesion-vehiculo">


                            <div id="login-div-sesion">
                                <div id="login-div-progreso">
                                    <div id="login-div-progreso-vehiculo" class="login-div-progreso-selected">DATOS DEL VEHÍCULO</div>
                                    <div id="login-div-progreso-historial">HISTORIAL DE MANTENIMIENTO</div>              
                                </div>
                                <div class="clear"></div> 


                                <div id="login-div-titulo">
                                    <img src="<?php echo base_url(); ?>resources/images/login/mayor-que-404040.png" alt="flechas de registro"/><span>INGRESA LOS DATOS DE TU VEHÍCULO</span>
                                </div>
                                <form action="<?php echo base_url(); ?>usuario/subir_imagen_vehiculo_ajax" id="form_vehiculo_file">
                                    <div id="foto_div_form">
                                        <label>Adjunta la imagen de tu carro: (*opcional)</label>
                                        <div id="foto_form_marco">
                                            <img src="http://www.laspartes.com/resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd1.png"  />
                                        </div>
                                        <input type="file" id="input_vehiculo_imagen" name="input_vehiculo_imagen" onchange="fotoPreview(this);" />
                                    </div>
                                </form>
                                <form id="form_vehiculo">
                                    <div id="vehiculo_div_form">
                                        <input type="hidden" id="nuevo_carro" value="1">
                                        <input type="hidden" name="input_vehiculo_id_usuario_vehiculo" id="input_vehiculo_id_usuario_vehiculo" class="input_vehiculo_id_usuario_vehiculo form_vehiculo_input" maxlength="20"/>
                                        <div class="form_login_div_campo">
                                            <label>Marca: ej. Renault</label>
                                            <input type="text" name="input_vehiculo_marca" id="input_vehiculo_marca" class="input_vehiculo_marca form_vehiculo_input" maxlength="20"/><div for="input_vehiculo_marca"></div>
                                        </div>
                                        <div class="form_login_div_campo">
                                            <label>Línea: ej. logan</label>
                                            <input type="text" name="input_vehiculo_linea" id="input_vehiculo_linea" class="input_vehiculo_linea form_vehiculo_input" maxlength="50"/><div for="input_vehiculo_linea"></div>
                                        </div>
                                        <div class="form_login_div_campo div_quisiste_decir">
                                            <label>Quisiste decir: </label>
                                            <input type="hidden" id="quisiste_decir_marca">
                                            <input type="hidden" id="quisiste_decir_linea">
                                            <span id="quisiste_decir" onclick="carro_sugerido()"></span>
                                        </div>
                                        <div class="form_login_div_campo">
                                            <label>Placa: (*opcional)</label>
                                            <input type="text" name="input_vehiculo_placa" id="input_vehiculo_placa" class="input_vehiculo_palca form_vehiculo_input" maxlength="7"/><div for="input_vehiculo_placa"></div>
                                        </div>
                                        <div id="vehiculo_form_div_kilo" class="form_login_div_campo">
                                            <label>Kilometraje Aproximado:</label>
                                            <?php
                                            $option_kilometraje = array();
                                            for ($i = 0; $i < 200000; $i += 5000) {
                                                $option_kilometraje[$i] = $i . ' Km.';
                                            }
                                            echo form_dropdown('input_vehiculo_kilometraje', $option_kilometraje, '5000', 'id="input_vehiculo_kilometraje" class="input_vehiculo_kilometraje" title="Selecciona el kilometraje aproximado de tu carro"');
                                            ?><div for="input_vehiculo_kilometraje"></div>
                                        </div>
                                        <div id="vehiculo_form_div_model" class="form_login_div_campo">
                                            <label>Modelo:</label>
                                            <?php
                                            $this->load->helper('date');
                                            $option_modelo = array();
                                            $selected = '2010';
                                            $año = intval(mdate('%Y')) + 1;
                                            for ($i = $año; $i > 1950; $i--) {
                                                $option_modelo[$i] = $i;
                                                if ($vehiculo->modelo == $i) {
                                                    $selected = $i;
                                                }
                                            }
                                            echo form_dropdown('input_vehiculo_modelo', $option_modelo, $selected, 'id="input_vehiculo_modelo" class="input_vehiculo_modelo" title="Selecciona el modelo de tu carro"');
                                            ?><div for="input_vehiculo_modelo"></div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="div-registrate-submit">
                                            <input type="submit" name="input_vehiculo_submit" id="input-vehiculo-submit" class="input-vehiculo-submit" value="Siguente"/>
                                            <img src="<?php echo base_url(); ?>resources/images/login/ajax-loader.gif" class="ajax_img_loader" />
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </form>
                            </div>


                            <div class="clear"></div>
                        </div>
                    </div>

                    <!--Vista que contiene el historial del carro-->
                    <div id="loging-div" class="login-div-historial"></div>
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>