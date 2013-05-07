<div id="home-div-content" class="margin-bottom-registro">
    <div id="novedades-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo" style="margin-top: 20px;">

                <h1 style="font-size: 30px;">NO PAGUES DE MÁS POR ARREGLAR TU CARRO</h1>
                <h1>¡COTIZAMOS LO QUE NECESITAS EN NUESTRA RED DE <?php echo $numero_establecimientos-1; ?> TALLERES ALIADOS. AL FINAL, TÚ ESCOGES LA MEJOR ALTERNATIVA!</h1>
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
                        <span style="color: #C60200;">CUÉNTANOS LO QUE NECESITAS</span>
                    </h1>
                </div>


                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>
            <div id="registrar-div-content">
                
                <div id="registar-div-content-header1">
                    AL ENVIARNOS LA SOLICITUD DE LO QUE NECESITAS...
                </div>
                <div id="registar-div-content-header2">
                    Nosotros te ayudamos a buscar los mejores talleres y las mejores cotizaciones para ayudarte con el mantenimiento de tu vehículo.
                </div>

                <div id="registrar-div-form-registro">
                    <?php $sesion = $this->session->userdata('esta_registrado'); ?>
                        <form action="<?php echo base_url(); ?>ayuda/enviar_solicitud" id="form_solicitud" method="POST">
                            <?php echo $confirmacion;?>
                            <div id="solicitud-div-datos-personales">
                                <div id="solicitud-div-datos-personales-titulo">TUS DATOS PERSONALES</div>
                                <?php if($usuario):?>
                                <label>Nombres y apellidos</label>
                                <input name="solicitud_nombres" type="text" value="<?php echo $usuario->nombres.' '.$usuario->apellidos;?>"/>
                                    <label>¿En qué ciudad vives?</label>
                                    <?php
                                    $option_ciudades = array();
                                    $selected = false;
                                    $ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
                                    foreach ($ciudades as $ciudad) {
                                        if ($ciudad != 'default') {
                                            $option_ciudades[$ciudad] = $ciudad;
                                            if (!$selected) {
                                                $selected = $ciudad;
                                            }
                                        }
                                    }
                                    echo form_dropdown('ciudad_registrarse', $option_ciudades, $usuario->lugar); //, 'id="marca_registrarse"');
                                    ?>
                                        <label>Correo:</label>
                                    <input name="solicitud_email" type="text" value="<?php echo $usuario->email;?>"/>
                                <?php else:?>   
                                    <label>Nombres y apellidos</label>
                                    <input name="solicitud_nombres" type="text"/>
                                    <label>¿En qué ciudad vives?</label>
                                    <?php
                                    $option_ciudades = array();
                                    $selected = false;
                                    $ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
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
                                     <label>Correo:</label>
                                    <input name="solicitud_email" type="text" />
                                <?php endif; ?>
                                
                            </div>
                            
                            <div id="solicitud-div-datos-auto">
                                <div id="solicitud-div-datos-personales-titulo">DATOS DE TU AUTOMÓVIL</div>
                                 <?php if($usuario):?>
                                 <label>Marca y línea del vehículo</label>
                                    <input id="solicitud-input-vehiculo" name="id_vehiculos" type="text" value="<?php echo $vehiculo[0]->marca.' '.$vehiculo[0]->linea;?>"/>
                                    <input type="hidden" value="<?php echo $vehiculo[0]->id_vehiculo;?>" name="vehiculo_id"  id="solicitud-input-vehiculo-hidden">
                                    <label>Modelo:</label>
                                     <?php
                                    $option_modelo = array();
                                    $selected = '2010';
                                    $año = intval(mdate('%Y')) + 1;
                                    for ($i = $año; $i > 1950; $i--) {
                                        $option_modelo[$i] = $i;
                                        if ($vehiculo->modelo == $i) {
                                            $selected = $i;
                                        }
                                    }
                                    echo form_dropdown('modelo', $option_modelo, $vehiculo[0]->modelo, 'class="input_modelo", id="modelo"');
                                    ?>
                                    <label>Kilometraje:</label>
                                    <input  name="kilometraje" type="text"  value="<?php echo $vehiculo[0]->kilometraje;?>"/>
                                <?php else:?>   
                                    <label>Marca y línea del vehículo</label>
                                    <input id="solicitud-input-vehiculo" name="id_vehiculos" type="text" />
                                    <input type="hidden" value="" name="vehiculo_id"  id="solicitud-input-vehiculo-hidden">
                                    <label>Modelo:</label>
                                    <?php
                                    $option_modelo = array();
                                    $selected = '2010';
                                    $año = intval(mdate('%Y')) + 1;
                                    for ($i = $año; $i > 1950; $i--) {
                                        $option_modelo[$i] = $i;
                                        if ($vehiculo->modelo == $i) {
                                            $selected = $i;
                                        }
                                    }
                                    echo form_dropdown('modelo', $option_modelo, $selected, 'class="input_modelo", id="modelo"');
                                    ?>
                                    <label>Kilometraje:</label>
                                    <input name="kilometraje" type="text" />
                                <?php endif; ?>
                                    
                                    <label>Número de teléfono de contacto:</label>
                                    <input name="telefono" type="text" />
                            </div>
                            <div class="clear"></div>
                            <label>Tu mensaje:
                            <textarea name="solicitud_mensaje"></textarea>
                            <div id="ayuda-div-condiciones">
                                <input type="checkbox" name="ckbox_registrate_chkbox" id="ckbox-registrate-chkbox"/><label id="label-registrate-condiciones">Acepto los <a target="blank" href="<?php echo base_url()?>acerca/terminos_condiciones">términos y condiciones</a> de uso de la información</label>
                            </div>
                            <div class="clear"></div>
                            <input type="submit" value="Enviar"/>
                            <div class="clear"></div>
                        </form>
                </div>
            </div>
        </div>

        <div class="div-content-center-novedades">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo">
                    <div id="autopart-div-titulo-icono" style="margin-top: 0px;"> 
                        <img src="<?php echo base_url(); ?>resources/images/home/twitter.png" alt="twitter" />
                    </div>
                    <h1>
                        <span style="font-size: 28;">TWITTER</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas"></div>
                <div class="home-div-home-twitter-tweet open-sans">
                   <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
                    <script>
                    new TWTR.Widget({
                    version: 2,
                    type: 'profile',
                    rpp: 3,
                    interval: 30000,
                    width: 200,
                    height: 300,
                    theme: {
                        shell: {
                        background: 'transparent',
                        color: '#ffffff'
                        },
                        tweets: {
                        background: 'transparent',
                        color: '#404040',
                        links: '#C60200'
                        }
                    },
                    features: {
                        scrollbar: false,
                        loop: false,
                        live: false,
                        behavior: 'all'
                    }
                    }).render().setUser('laspartes').start();
                    </script>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>