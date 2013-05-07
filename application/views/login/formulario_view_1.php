<div id="home-div-content" class="margin-bottom-registro">
    <div id="novedades-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo" style="margin-top: 35px;">

                <h1 style="font-size: 30px;">CREA AQUÍ EL PERFIL DE TU VEHICULO</h1>
                <h1>¡Y NOSOTROS NOS ENCARGAMOS DEL MANTENIMIENTO!</h1>
            </div>  
        </div>
        <div class="clear"></div>
    </div>

    <div id="autopart-div-banner-bottom"></div>
    
    

    <div class="div-content">
        <div class="clear"></div>
        <div class="div-content-left-novedades">
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
                <?php echo $confirmacion;?>
                <div id="registar-div-content-header1">
                    ES COMO TENER TU PROPIO TALLER, ESTA VEZ EN LÍNEA
                </div>
                <div id="registar-div-content-header2">
                    Nosotros te avisamos qué debes tener en cuenta, cuándo tienes que hacerlo, y quiénes pueden hacerte el mantenimiento adecuado
                </div>

                <div id="registrar-div-form-registro">

                    <div id="login-div-center">
                        <form action="<?php echo base_url(); ?>usuario/registrar_usuario" id="form_registro" method="POST">
                            <div id="login-div-registrate">
                                <div id="login-div-registrate-titulo">
                                    <img src="<?php echo base_url(); ?>resources/images/login/mayor-que.png" alt="flechas de registro"/><span>REGÍSTRATE</span>
                                </div>

                                <div id="registrar-div-form-registro-datos">TUS DATOS PERSONALES</div>
                                <label>Nombres:</label>
                                <input type="text" name="input_registrate_nombre" id="input-registrate-nombre" />
                                <label>Apellidos:</label>
                                <input type="text" name="input_registrate_apellidos" id="input-registrate-apellidos" />
                                <label>¿En qué ciudad vives?:</label>
                                <div class="ui-widget">
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
                                    echo form_dropdown('ciudad_registrarse', $option_ciudades, 'Bogotá'); //, 'id="marca_registrarse"');
                                    ?>
                                </div>
                                <label>Escribe tu nombre de usuario: (Mínimo 4 caracteres)</label>
                                <input type="text" name="input_registrate_usuario" id="input-registrate-usuario" />
                                <label>Escribe tu correo electrónico: </label>
                                <input type="text" name="input_registrate_email" id="input-registrate-email" />
                                <label>Escribe tu contraseña:</label>
                                <input type="password" name="input_registrate_contrasena" id="input-registrate-contrasena" />
                                <label>Repite tu contraseña:</label>
                                <input type="password" name="input_registrate_contrasena_repite" id="input-registrate-contrasena-repite" />




                            </div>

                            <div id="login-div-sesion">
                                <div id="registrar-div-form-registro-datos-vehiculo">DATOS DE TU VEHÍCULO</div>
                                <label>Marca y línea: ej. Renault Twingo</label>
                                <input type="text" id="input-registrate-vehiculo" class="vehiculos"  name="id_vehiculos"  value="" /> 
                                <input type="hidden" value="na" name="vehiculo_id"  id="input-registrate-vehiculo-hidden">
                                <label>Kilometraje: (Aprox.)</label>
                                <div class="ui-widget">
                                    <?php
                                    $option_kilometraje = array();
                                    $selected = false;
                                    $option_kilometraje['-1'] = 'No recuerdo';
                                    for ($i = 1; $i < 200000; $i += 5000) {
                                        $option_kilometraje[$i - 1] = $i . ' Km. - ' . ($i + 4999) . ' Km.';
                                        if (!$selected) {
                                            $selected = $i - 1;
                                        } 
                                    }
                                    echo form_dropdown('select_registrate_kilometraje', $option_kilometraje, $selected);
                                    ?>
                                </div>
                                <label>Placa: (Opcional)</label>
                                <input type="text" name="input_registrate_placa" id="select-registrate-placa"></input>
                                <label>Escribe los 4 dígitos de la imagen:</label>
                                <div id="registrar-div-login-captcha"><?php echo $captcha['image']; ?></div>
                                <input type="text" name="captcha_registrarse" id="input_login_captcha" class="input_login_captcha"/>
                                <div class="clear"></div>
                            </div>

                            <div class="clear"></div>
                            <div id="login-div-condiciones">
                                <input type="checkbox" name="ckbox_registrate_chkbox" id="ckbox-registrate-chkbox"/><label id="label-registrate-condiciones">Acepto los <a target="blank" href="<?php echo base_url()?>acerca/terminos_condiciones">términos y condiciones</a></label>
                            </div>
                            <div class="clear"></div>
                            <div id="div-registrate-submit">
                                <input type="submit" name="input_registrate_submit" id="input-registrate-submit" value="Registrame"/>
                                <div class="clear"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="div-content-center-novedades">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo">
                    <div id="autopart-div-titulo-icono"> 
                        <img src="<?php echo base_url(); ?>resources/images/login/doble-mayor-que.png" alt="icono flechas" />
                    </div>
                    <h1>
                        <span>INICIA</span>
                        <span style="color: #C60200;"> TU SESIÓN</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas"></div>
            <div id="registrar-div-form-login">
                <form id="form_login">
                    <label id="registrar-label-email">Email:</label>
                    <input type="text" name="input_login_email" id="input_login_email" class="input_login_email"/>
                    <label>Contraseña:</label>
                    <input type="password" name="input_login_contrasena" id="input_login_contrasena" class="input_login_contrasena"/>
                    <div id="login-div-ingresarolvidar">
                        <div id="login-div-olvide">
                            <a href="<?php echo base_url(); ?>usuario/formulario_olvido_contrasena">Olvidé mi contraseña</a>
                        </div>
                        <input type="submit" name="submit_form_login" id="submit-form-login" value="Ingresar"/>
                    </div>
                </form>
                <div class="clear"></div><br/><br/>

                        <img id="home-div-facebook-button" class="home-div-facebook-button" width="100%" src="<?php echo base_url();?>resources/images/login/facebook-conectar-boton.png"/>
            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>