<!-- Google Code for Registro Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1005890407;
var google_conversion_language = "es";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "7FWfCPnstQMQ59bS3wM";
var google_conversion_value = 0;
/* ]]> */
</script>
<div style="display:none;">
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
</div>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1005890407/?value=0&amp;label=7FWfCPnstQMQ59bS3wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<div id="home-div-content">
    <div id="usuario-div-mi-perfil">

        <div id="usuario-div-foto">
            <div class="usuario-div-foto-editar">
                <?php echo form_error('usuario'); ?>
                <form id="subir_imagen_perfil" action="/usuario/subir_imagen_perfil_ajax"  >
                    <input type="file" id="imagen_perfil" name="foto_perfil" size="20" class="input_imageUpload_perfil">
                </form>
            </div>                
            <div id="usuario-div-foto-marco">
                <img src="<?php
if ($usuario->imagen_url != NULL || $usuario->imagen_url != '') {
    if(strpos($usuario->imagen_url, 'http') !== false)
        echo $usuario->imagen_url;
    else
        echo base_url().$usuario->imagen_url;
} else {
    echo base_url() . 'resources/images/usuarios/avatar.gif';
}
?>" alt="foto de perfil" />
            </div>
        </div>

        <div id="usuario-div-perfil-info">
            <form id="usuario_formulario_perfil" method="POST" >
                <h1>BIENVENIDO AL TALLER EN LÍNEA</h1>
                <h1 style="color: #C60200;" id ="usuario-div-perfil-info-nombresapellidos" class="editar-perfil-show"><?php echo $usuario->nombres . " " . $usuario->apellidos; ?></h1>
                <div class="usuario-div-perfil-info-editar editar-perfil-hidden">
                    <label for="nombres"></label>
                    <?php
                    echo form_input('nombres', $usuario->nombres, 'id="usuario_input_perfil_nombres", maxlength="20"');
                    echo form_input('apellidos', $usuario->apellidos, 'id="usuario_input_perfil_apellidos", maxlength="20"');
                    ?>
                </div>

                <div id="usuario-div-perfil-info-user" class="open-sans editar-perfil-show">
                    <span id="usuario-div-perfil-info-usuario"><?php echo $usuario->usuario; ?></span><br/>
                    <span id="usuario-div-perfil-info-email"><?php echo $usuario->email; ?></span>
                    <span id="usuario-div-perfil-info-lugar"><?php echo $usuario->lugar; ?></span>
                </div>
                <div class="usuario-div-perfil-info-editar editar-perfil-hidden">
                    <div id="error_form_email"></div>
                    <label for="email"></label>
                    <?php
                    echo form_input('usuario', $usuario->usuario, 'id="usuario_input_perfil_usuario", maxlength="25"');
                    echo form_input('email', $usuario->email, 'id="usuario_input_perfil_email"');

                    $option_ciudades = array();
                    $selected = "Bogotá";
                    $ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
                    foreach ($ciudades as $ciudad) {
                        $option_ciudades[$ciudad] = $ciudad;
                        if ($ciudad == $usuario->lugar) {
                            $selected = $ciudad;
                        }
                    }
                    echo form_dropdown('lugar', $option_ciudades, $selected, 'id="usuario_input_perfil_lugar"'); //, 'id="marca_registrarse"');
                    ?>
                </div>

                <div class="usuario-div-editar editar-perfil-show">
                    Editar Perfil
                </div>
                <div class="usuario-div-editar-submit editar-perfil-hidden">
                    <?php echo form_button('Cancelar', 'Cancelar', 'class="cancelar-formulario"'); ?>
                    <?php echo form_submit('Guardar', 'Guardar'); ?>
                </div>
            </form>
        </div>

        <div id="usuario-div-perfil-tareas" class="open-sans">

            <div class="usuario-div-perfil-misvehiculos usuario-div-perfil-tarea activo">
                <img src="<?php echo base_url(); ?>/resources/images/micuenta/mis-vehiculos.png" alt="mis vehiculos" />
                <div class="usuario-div-perfil-misvehiculos-cantidad">
                    <span class="usuario-span-perfil-titulosesion">Mis vehículos</span><br/>
                    <span class="usuario-span-cantidad">( <?php echo $numVehiculos; ?> )</span>
                </div>
            </div>

            <div class="usuario-div-perfil-sobrevehiculo usuario-div-perfil-tarea inactivo">
                <img src="<?php echo base_url(); ?>/resources/images/micuenta/sobre-vehiculo-inactivo.png" alt="sobre mi vehiculo" />
                <div class="usuario-div-perfil-sobrevehiculo-cantidad">
                    <span class="usuario-span-perfil-titulosesion">Sobre mi vehículo</span><br/>
                    <span class="usuario-span-cantidad">( <?php echo sizeof($tareas); ?> )</span>
                </div>
            </div>

            <div class="usuario-div-perfil-ofertas usuario-div-perfil-tarea inactivo">
                <img src="<?php echo base_url(); ?>/resources/images/micuenta/ofertas-inactivo.png" alt="ofertas" />
                <div class="usuario-div-perfil-ofertas-cantidad">
                    <span class="usuario-span-perfil-titulosesion">Ofertas</span><br/>
                    <span class="usuario-span-cantidad">( <?php echo $numOfertas; ?> )</span>
                </div>
            </div>

            <div class="usuario-div-perfil-comunidad usuario-div-perfil-tarea inactivo">
                <img src="<?php echo base_url(); ?>/resources/images/micuenta/comunidad-inactivo.png" alt="comunidad" />
                <div class="usuario-div-perfil-comunidad-cantidad">
                    <span class="usuario-span-perfil-titulosesion">Comunidad</span><br/>
                </div>
            </div>

            <div class="clear"></div>
        </div>

        <div class="clear"></div>

    </div>

    <div id="usuario-div-mi-perfil-bottom"></div>

    <div class="usuario-div-perfil-contenedor">
        <div class="usuario-div-breadcrumb open-sans">
            <div style="color:white; background-color:black; font-weight:bold;">>></div>

            <?php echo $breadcrumb;?>
        </div>

        <div class="clear"></div>

        <div id="usuario-div-mis-vehiculos" class="sesion">
            <div id="usuario-div-mv-top">
                <div id="usuario-div-mv-titulo">
                    <img src="<?php echo base_url(); ?>/resources/images/micuenta/mi-vehiculo.png" alt="<mi vehiculo" />
                    <h1><span>MIS</span>&nbsp;<span style="color: #C60200;">VEHÍCULOS</span></h1>
                </div>

                <div id="usuario-div-mv-anadir">
                    <img src="<?php echo base_url(); ?>/resources/images/micuenta/mi-vehiculo-2.png" alt="<mi vehiculo" />
                    AÑADIR VEHÍCULO
                </div>

                <div class="clear"></div>
            </div>

            <div class="div-separador-titulo"></div>

            <div id="usuario-div-mv-all">

                <?php
                $temp_impar = true;
                $temp_seleccionado = true;
                foreach ($vehiculos as $vehiculo):
                    ?>

                    <div id="usuario-div-mv-vehiculo-<?php echo $vehiculo->id_vehiculo; ?>" class="usuario-div-mv-vehiculo <?php
                if ($temp_impar) {
                    echo impar;
                    $temp_impar = false;
                } else {
                    $temp_impar = true;
                }
                    ?> <?php
                if ($temp_seleccionado) {
                    echo 'carroseleccionado carroactivo';
                    $temp_seleccionado = false;
                } else {
                    echo 'carroinactivo';
                }
                    ?>">

                        <div class="usuario_div_id_usuario_vehiculo"><?php echo $vehiculo->id_usuario_vehiculo; ?></div>
                        <div class="usuario_div_id_vehiculo"><?php echo $vehiculo->id_vehiculo; ?></div>
                        <div class="usuario-div-mv-vehiculo-left">
                            <div class="usuario-div-mv-vehiculo-marco">
                                <div class="usuario-div-mv-vehiculo-marco-contenedor">
                                    <img src="
                                    <?php
                                    if ($vehiculo->imagen_url != NULL || $vehiculo->imagen_url != '') {
                                        echo base_url() . $vehiculo->imagen_url;
                                    } else {
                                        echo base_url() . 'resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd1.png';
                                    }
                                    ?>" alt="foto carro" />
                                </div>
                                <div class="usuario-div-foto-editar">
                                    <form class="subir_imagen_automovil" action="/usuario/subir_imagen_temp_ajax" >
                                        <input type="file" id="imageUpload_<?php echo $vehiculo->id_usuario_vehiculo; ?>" name="imageUpload" size="20" class="input_imageUpload_automovil">
                                    </form>
                                </div>
                            </div>

                            <div class="usuario-div-mv-vehiculo-actualizacion open-sans">Última actualización: <?php echo strftime("%d de %B de %Y", strtotime($vehiculo->fecha)); ?></div>
                        </div>

                        <div class="usuario-div-mv-vehiculo-center">
                            <form class="usuario_formulario_editar_vehiculo">
                                <div class="usuario-div-mv-vehiculo-marca font-universe editar-vehiculo-show">
                                    <span class="usuario-span-marca-carro"><?php echo $vehiculo->marca . " " . $vehiculo->linea; ?></span>
                                </div>
                                <div class="usuario-div-mv-vehiculo-lineamarca-editar editar-vehiculo-hidden ui-widget">
                                    <input type="hidden" value="<?php echo $vehiculo->id_vehiculo; ?>" name="vehiculo_id" class="hidden_carro_selected">
                                    <input class="vehiculos"  name="id_vehiculos[]" type="text" value="<?php echo $vehiculo->marca . " " . $vehiculo->linea; ?>" /> 
                                </div>
                                <div class="usuario-div-mv-vehiculo-subtitulo">Modelo:</div>
                                <div class="usuario-div-mv-vehiculo-modelo dato editar-vehiculo-show"><?php echo $vehiculo->modelo; ?></div>
                                <div class="usuario-div-mv-vehiculo-modelo-editar editar-vehiculo-hidden ui-widget">
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

                                </div>
                                <div class="usuario-div-mv-vehiculo-subtitulo">Kilometraje: 
                                    <div class="imagen-interogacion"><img src="<?php echo base_url(); ?>/resources/images/micuenta/interogacion.png" alt="interrogacion"  />
                                        <div class="usuario-div-mensaje">
                                            Necesitamos el kilometraje para poder ser más exactos 
                                            con los datos.
                                        </div>
                                    </div>

                                </div>                     
                                <div class="usuario-div-mv-vehiculo-kilometraje dato editar-vehiculo-show"><?php echo number_format($vehiculo->kilometraje, 0, ",", "."); ?> Kms
                                </div>
                                <div class="usuario-div-mv-vehiculo-kilometraje-editar editar-vehiculo-hidden ui-widget">
                                    <?php
                                    echo form_input('kilometraje', $vehiculo->kilometraje);
                                    ?>
                                </div>

                                <div class="usuario-div-mv-vehiculo-subtitulo">Placa: 
                                    <div class="imagen-interogacion"><img src="<?php echo base_url(); ?>/resources/images/micuenta/interogacion.png" alt="interrogacion"  />
                                        <div class="usuario-div-mensaje">Necesitamos la placa para poder ser más exactos 
                                            con los datos.</div>
                                    </div>
                                </div>           
                                <div class="usuario-div-mv-vehiculo-placa dato editar-vehiculo-show"><?php echo $vehiculo->numero_placa; ?></div>  
                                <div class="usuario-div-mv-vehiculo-placa-editar editar-vehiculo-hidden ui-widget">
                                    <?php
                                    echo form_input('placa', $vehiculo->numero_placa);
                                    ?>
                                </div>
                                <div class="usuario-div-editar editar-vehiculo-show">
                                    Editar
                                </div>
                                <div class="usuario-div-editar-submit editar-vehiculo-hidden">
                                    <?php echo form_button('Cancelar', 'Cancelar', 'class="cancelar-formulario"'); ?>
                                    <?php echo form_submit('Guardar', 'Guardar'); ?>
                                </div>
                            </form>
                        </div>

                        <div class="clear"></div>  

                    </div>

                <?php endforeach; ?>

                    <div class="usuario-div-mv-vehiculo adicionar">

                    <div class="usuario-div-mv-vehiculo-left">
                        <div class="usuario-div-mv-vehiculo-marco"><img src="<?php echo base_url(); ?>/resources/images/micuenta/mi-vehiculo-agregar.png" alt="foto perfil" />

                            <div class="usuario-div-mv-vehiculo-adicionar-texto">
                                <div class="usuario-div-mv-vehiculo-adicionar-texto-registra">REGISTRA TU VEHÍCULO!</div>
                                <div class="usuario-div-mv-vehiculo-adicionar-texto-mantente">Y MANTENTE AL DÍA</div>
                            </div>
                            <div class="usuario-div-foto-editar"></div>
                        </div>
                    </div>

                    <div class="usuario-div-mv-vehiculo-center">
                        <form id="usuario_formulario_agregar_vehiculo" >
                            <div class="usuario-div-mv-vehiculo-marca font-universe editar-vehiculo-show">
                                <span class="usuario-span-marca-carro">MARCA VEHÍCULO</span>
                            </div>
                            <div class="usuario-div-mv-vehiculo-lineamarca-editar editar-vehiculo-hidden ui-widget">
                                <input type="hidden" value="na" name="vehiculo_id" class="hidden_carro_selected">
                                <input class="vehiculos"  name="id_vehiculos" type="text" value="MARCA VEHÍCULO" /> 
                            </div>
                            <div class="usuario-div-mv-vehiculo-subtitulo">Modelo:</div>
                            <div class="usuario-div-mv-vehiculo-modelo dato editar-vehiculo-show">2005</div>
                            <div class="usuario-div-mv-vehiculo-modelo-editar editar-vehiculo-hidden ui-widget">
                                <?php
                                $option_modelo = array();
                                $selected = '2010';
                                $año = intval(mdate('%Y')) +1;
                                for ($i = $año; $i > 1950; $i--) {
                                    $option_modelo[$i] = $i;
                                }
                                echo form_dropdown('modelo', $option_modelo, $selected, 'class="input_modelo", id="modelo"');
                                ?>

                            </div>
                            <div class="usuario-div-mv-vehiculo-subtitulo">Kilometraje: 
                                <div class="imagen-interogacion"><img src="<?php echo base_url(); ?>/resources/images/micuenta/interogacion.png" alt="interrogacion"  />
                                    <div class="usuario-div-mensaje">
                                        Necesitamos el kilometraje para poder ser más exactos 
                                        con los datos.
                                    </div>
                                </div>

                            </div>                     
                            <div class="usuario-div-mv-vehiculo-kilometraje dato editar-vehiculo-show">0 Kms
                            </div>
                            <div class="usuario-div-mv-vehiculo-kilometraje-editar editar-vehiculo-hidden ui-widget">
                                <?php
                                echo form_input('kilometraje', '', 'maxlength="10"');
                                ?>
                            </div>

                            <div class="usuario-div-mv-vehiculo-subtitulo">Placa: 
                                <div class="imagen-interogacion"><img src="<?php echo base_url(); ?>/resources/images/micuenta/interogacion.png" alt="interrogacion"  />
                                    <div class="usuario-div-mensaje">Necesitamos la placa para poder ser más exactos 
                                        con los datos.</div>
                                </div>
                            </div>           
                            <div class="usuario-div-mv-vehiculo-placa dato editar-vehiculo-show"></div>  
                            <div class="usuario-div-mv-vehiculo-placa-editar editar-vehiculo-hidden ui-widget">
                                <?php
                                echo form_input('placa', '', 'maxlength="7"');
                                ?>
                            </div>
                            <div class="usuario-div-editar editar-vehiculo-show">
                                Editar
                            </div>
                            <div class="usuario-div-editar-submit editar-vehiculo-hidden">
                                <?php echo form_button('Cancelar', 'Cancelar', 'class="cancelar-formulario"'); ?>
                                <?php echo form_submit('Guardar', 'Guardar'); ?>
                            </div>

                        </form>
                    </div>

                    <div class="clear"></div> 
                </div>

                <div class="clear"></div>                    
            </div>

        </div>
    </div>

    <div id="usuario-div-smv" class="sesion">

        <div id="usuario-div-smv-header">
            <div id="usuario-div-smv-header-izq">
                <img src="<?php echo base_url(); ?>/resources/images/micuenta/icono-titulo-smv.png" alt="icono sobre mi vehiculo" />
                <h1>SOBRE MI <span style="color: #C60200;">VEHÍCULO</span></h1>
            </div>

            <div id="usuario-div-smv-header-derecha">
                <?php
                $temp_primero = true;
                foreach ($vehiculos as $vehiculo):
                    ?>
                    <span class="usuario-span-titulo-carro <?php
                if ($temp_primero) {
                    echo 'tituloseleccionado';
                    $temp_primero = false;
                }
                    ?>"><?php echo $vehiculo->marca . " " . $vehiculo->linea; ?></span><div class="usuario-div-smv-header-separador"></div>
                      <?php endforeach; ?>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>

            <div class="div-separador-titulo"></div>
        </div>

        <div id="usuario-div-smv-content">
            <div id="usuario-div-smv-content-header">
                <img src="<?php echo base_url(); ?>/resources/images/micuenta/mayor-que-rojo.png" alt="mayor que" />
                <div id="usuario-div-smv-content-carro" class="font-universe"><?php echo $vehiculos[0]->marca . " " . $vehiculos[0]->linea; ?></div>
                <div id="usuario-div-smv-content-te-contamos" class="open-sans">
                    <div id="usuario-div-smv-content-te-contamos-txt1">TE CONTAMOS LO QUE DEBES HACER Y LO QUE HAS HECHO CON TU VEHÍCULO!</div>
                    <div id="usuario-div-smv-content-te-contamos-txt2">Te recordamos qué cosas has hecho para tú vehículo, cuáles debes cumplir de manera urgente y cuáles están pendientes por hacer; además, tendrás un historial de las preguntas, respuesta y talleres sobre los que has hablado!!
                    </div>
                </div> 
                    
                <div class="usuario-div-smv-cronograma">Ver lo que tengo que hacer el durante el año</div>
                <div class="clear"></div>
                <div>
                    <div class="usuario-div-smv-soat">Cotizar SOAT para mi vehículo</div>
                    <div class="usuario-div-smv-soat-telefono">
                        <div>Teléfono:</div>
                        <input class="usuario-input-smv-telefono" type="text" /><input class="usuario-input-smv-soat" type="submit" value="Enviar"/>
                        <div class="usuario-div-smv-soat-agentes">En breve uno de nuestros agentes se comunicará contigo.</div>
                    </div>
                    <div class="clear"></div> 
                </div>
                <div class="clear"></div>   
            </div>

            <div id="usuario-div-smv-content-sub">
                <div id="usuario-div-smv-lightbox-realizar"></div>
                <div id="usuario-div-smv-debo-hacer">
                    <div class="usuario-div-smv-subtitulo">DEBO HACER</div>
                    <div id="usuario-div-smv-db-content" class="open-sans smv_div_tareas"  style="padding-bottom: 50px;">
                        <div id="usuario-div-smv-db-content-t1">PRIORIDAD ALTA</div>
                        <div id="usuario-div-smv-db-content-t2">PARA HACER LO MÁS PRONTO!</div>


                        <div class="div-separador-titulo"></div>

                        <?php
                        $indexDebo = 0;
                        foreach ($tareas as $tarea): if ($tarea->realizado == false &&
                                    ( ($tarea->mensaje_dias_restantes == "TE QUEDAN: " && $tarea->dias_restantes <= 15) ||
                                    ($tarea->mensaje_dias_restantes == "DEBES HACERLO") )): 
                                $indexDebo++;
                                ?>
                                <div class="usuario-div-smv-tarea smv_tarea_realizar <?php if($indexDebo>2) echo 'tarea_hidden';?>">

                                    <div class="usuario-div-smv-tarea-izq">
                                        <div class="usuario-div-smv-tarea-foto"><img src="<?php echo base_url() . $tarea->imagen_thumb_url; ?>" alt="tarea" /></div>
                                        <div class="usuario-div-smv-tarea-chkbox">
                                            <?php if($tarea->id_servicio != 9 && $tarea->id_servicio != 10):?>
                                            <input class="usuario-input-smv-tarea-chkbox" name ="" type="checkbox" value="<?php echo $tarea->id_servicio; ?>" /> YA LO HICE!
                                            <?php else:?>
                                            <input  disabled="disabled" class="usuario-input-smv-tarea-chkbox" name ="" type="checkbox" value="<?php echo $tarea->id_servicio; ?>" /> YA LO HICE!
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="usuario-div-smv-tarea-der">
                                        <div class="usuario-div-tarea-nombre"><span><?php echo $tarea->nombre; ?></span></div>
                                        <div class="usuario-div-tarea-progreso"><span style="background-color: #c60200;"><?php echo $tarea->mensaje_dias_restantes . $tarea->dias_restantes . $tarea->mensaje_dias_restantes2; ?></span></div>
                                        <div class="usuario-div-tarea-descripcion">
                                            <?php
                                            $text = strip_tags($tarea->descripcion);
                                            $words = explode(" ", $text);
                                            $content = "";
                                            $i = 0;
                                            foreach ($words as $word) {
                                                if ($i == 30) {
                                                    break;
                                                }
                                                if ($i) {
                                                    $content .= " ";
                                                }
                                                $content .= $word;
                                                $i++;
                                            }
                                            echo $content . "…";
                                            ?>
                                        </div>
                                        <div id="usuario-div-smv-db-content-t3" class="usuario-div-smv-db-content-t3">¿QUÉ PASA SI NO LO HAGO?</div>
                                    </div>

                                    <div class="clear"></div>
                                </div>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>


                <div id="usuario-div-smv-pendiente">
                    <div class="usuario-div-smv-subtitulo">TENGO PENDIENTE</div>
                    <div id="usuario-div-smv-tp-content" class="open-sans smv_div_tareas" style="padding-bottom: 50px;">
                        <div id="usuario-div-smv-tp-content-t">ESTAS COSAS, DEBES TENERLAS EN CUENTA PRÓXIMAMENTE...</div>

                        <div class="div-separador-titulo"></div>

                        <?php
                        $indexPendiente = 0;
                        foreach ($tareas as  $tarea): if ($tarea->realizado == false &&
                                    ($tarea->mensaje_dias_restantes == "TE QUEDAN: " && $tarea->dias_restantes > 15)):
                                    $indexPendiente++;
                                ?>
                                <div class="usuario-div-tp-tarea smv_tarea_realizar <?php if($indexPendiente>2) echo 'tarea_hidden';?>"> 

                                    <div class="usuario-div-tp-tarea-izq">
                                        <div class="usuario-div-tp-tarea-foto"><img src="<?php echo base_url() . $tarea->imagen_thumb_url; ?>" alt="tarea" /></div>
                                        <div class="usuario-div-smv-tarea-chkbox">
                                            <?php if($tarea->id_servicio != 9 && $tarea->id_servicio != 10):?>
                                            <input  class="usuario-input-smv-tarea-chkbox" name ="" type="checkbox" value="<?php echo $tarea->id_servicio; ?>" /> YA LO HICE!
                                            <?php else:?>
                                            <input  disabled="disabled" class="usuario-input-smv-tarea-chkbox" name ="" type="checkbox" value="<?php echo $tarea->id_servicio; ?>" /> YA LO HICE!
                                            <?php endif; ?>
                                        </div> 
                                    </div>

                                    <div class="usuario-div-tp-tarea-der">
                                        <div class="usuario-div-tarea-nombre"><span><?php echo $tarea->nombre; ?></span></div>
                                        <div class="usuario-div-tarea-progreso"><span style="background-color: #ef6b00;"><?php echo $tarea->mensaje_dias_restantes . $tarea->dias_restantes . $tarea->mensaje_dias_restantes2; ?></span></div>
                                        <div class="usuario-div-tarea-descripcion">
                                            <?php
                                            $text = strip_tags($tarea->descripcion);
                                            $words = explode(" ", $text);
                                            $content = "";
                                            $i = 0;
                                            foreach ($words as $word) {
                                                if ($i == 30) {
                                                    break;
                                                }
                                                if ($i) {
                                                    $content .= " ";
                                                }
                                                $content .= $word;
                                                $i++;
                                            }
                                            echo $content . "…";
                                            ?>
                                        </div>
                                        <div id="usuario-div-smv-db-content-t3" class="usuario-div-smv-db-content-t3">¿QUÉ PASA SI NO LO HAGO?</div>
                                    </div>

                                    <div class="clear"></div>

                                </div>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>


                <div id="usuario-div-smv-hecho">
                    <div class="usuario-div-smv-subtitulo">ESTÁ HECHO</div>

                    <div id="usuario-div-smv-hecho-content" class="open-sans">
                        <div id="usuario-div-smv-hecho-content-t">TAREAS QUE YA CUMPLISTE!</div>

                        <div class="div-separador-titulo"></div>

                        <div class="usuario-div-smv-hecho-tareas open-sans smv_div_tareas">
                            <ul>
                                <?php
                                $indexT = 0;
                                foreach ($tareas as $tarea): if ($tarea->realizado == true):
                                         $indexT ++;
                                        ?>
                                         <li class="usario-li-tarea-realizada <?php if($indexT> 8) echo 'tarea_hidden';?>">
                                             <span class="usuario-div-smv-hecho-tareas-id-tarea"><?php echo $tarea->id_tarea_realizada;?></span>
                                                 <?php echo $tarea->nombre; ?> ........ 
                                            <span>
                                                <?php
                                                if ($tarea->due != '0000-00-00'): echo $tarea->due;
                                                endif;
                                                ?> |
                                            </span>
                                            <?php if($tarea->id_servicio != 9 && $tarea->id_servicio != 10):?>     
                                                 <span class="usuario-span-tareas-deshacer">Deshacer</span><?php if (!empty($tarea->adjunto)){?><span class="usuario-span-tareas-adjunto"> | <a target="_blank" href="<?php echo $tarea->adjunto;?>">Adjunto</a></span><?php }?> 
                                            <?php endif; ?>
                                        </li>
                                        <?php
                                    endif;
                                endforeach;
                                 foreach ($items_compras as $i =>$carrito_compra): 
                                        ?>
                                         <li class="usario-li-tarea-realizada <?php if($indexT+$i> 7) echo 'tarea_hidden';?>">
                                             <span class="usuario-div-smv-hecho-tareas-id-tarea"><?php echo $tarea->id_tarea_realizada;?></span>
                                                 <?php  echo character_limiter($carrito_compra->titulo, 73, '');?> ........ 
                                            <span>
                                                <?php
                                                if ($carrito_compra->fecha != '0000-00-00'): echo strftime("%B %d de %Y", strtotime($carrito_compra->fecha));
                                                endif;
                                                ?><span class="usuario-span-tareas-adjunto"> | <a target="_blank" href="<?php echo base_url().'usuario/recibo/'.$carrito_compra->refVenta;?>">Adjunto</a></span>
                                            </span>
                                        </li>
                                        <?php
                                 endforeach;
                                ?>
                            </ul>
                        </div>
                    </div> 
                </div>

                <div class="clear"></div>
                <div class="usuario-div-smv-vermas rojo smv_realizada_vermas <?php if($indexDebo <= 2 && ($indexT+sizeof($items_compras)) <8  && $indexPendiente<=2) echo 'tarea_realizada_hidden' ?>">Ver más</div>    
            </div>
        </div>

    </div>

    <div id="usuario-div-ofertas" class="sesion">
        <div id="usuario-div-ofertas-header">
            <div id="usuario-div-ofertas-header-izq">
                <img src="<?php echo base_url(); ?>/resources/images/micuenta/icono-ofertas.png" alt="icono ofertas" />
                <h1>OFERTAS <span style="color: #C60200;">DE MANTENIMIENTO</span></h1>
            </div>

            <div class="div-separador-titulo"></div>
        </div>



        <div id="usuario-div-ofertas-all">

            <?php
            $var_impar = false;
            $var = 1;
            $sizeAllofertas = sizeof($allofertas);
            $contador = 0;
            foreach ($allofertas as $oferta):
                $contador ++;
                ?>
                <div class="usuario-div-oferta <?php 
                if(($sizeAllofertas%2 == 0 && $contador < $sizeAllofertas-1)) echo "subsesion";
                else if($sizeAllofertas%2 ==1 && $contador != $sizeAllofertas) echo "subsesion";
                ?> open-sans <?php
            if ($var_impar) {
                echo 'oferta-derecha';
                $var_impar = false;
            } else {
                $var_impar = true;
            }
                ?>">
                    <div class="usuario-div-id_oferta"><?php echo $oferta->id_oferta; ?></div>
                    <div class="usuario-div-oferta-left">

                        <div class="usuario-div-oferta-marco  lightboxme">
                            <img src="<?php echo $oferta->logo; ?>" alt="icono oferta" />
                        </div>

                        <div class="usuario-div-oferta-precio lightboxme">
                            <?php if($oferta->dco_feria != 0): 
                                    $precio = $oferta->precio;
                                    $iva = $oferta->iva;
                                    $dco = $oferta->dco_feria;
                                    $base = $precio-$iva;
                                    $ivaPorce = $iva/$base;
                                    $valorDco = $base*((100-$dco)/100);
                                    $precionConDco = ($valorDco*(1+$ivaPorce));    
                                
                            ?>
                            <span>$ <?php echo number_format($precionConDco, 0, ",", "."); ?></span>
                            <div class="usuario-div-oferta-precio-sin-descuento">Antes: <strike>$ <?php echo number_format($oferta->precio, 0, ",", "."); ?></strike></div>
                            <?php else: ?>
                            <span>$ <?php echo number_format($oferta->precio, 0, ",", "."); ?></span>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="usuario-div-oferta-right">
                        <div class="usuario-div-oferta-titulo lightboxme">
                            <?php echo $oferta->titulo; ?>
                        </div>

                        <div class="usaurio-div-oferta-validez-desde">
                            
                        </div>

                        <div class="usuario-div-oferta-validez-hasta">
                            OFERTA VÁLIDA HASTA EL <?php echo strftime("%d de %B de %Y", strtotime($oferta->vigencia)); ?>
                        </div>

                        <div style="font-size:12px; color:black;  margin-top: 20px; font-weight: bold;">Incluye:</div>

                        <div class="usuario-div-oferta-incluye">
                            <?php echo $oferta->incluye; ?>
                        </div>

                        <div class="usuario-div-oferta-comprar lightboxme">
                            <input type="button" value="COMPRAR" />
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>

                <?php
                if ($var % 2 == 0) {
                    echo '<div class="clear"></div>';
                }
                $var++;
                ?>
            <?php endforeach; ?>




            <div class="clear"></div>

        </div>
        <div class="div-ver-mas">
            <div class="usuario-div-ofertas-vermas rojo usuario-span-ofertas-vermas">Ver más</div>    
<!--            <span class="usuario-span-ofertas-vermas">VER MÁS OFERTAS</span>-->
<!--            <img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" />-->
        </div>
    </div>

<!--    <div id="usuario-div-compras" class="sesion">
        <div id="usuario-div-compras-header">
            <div id="usuario-div-compras-header-izq">
                <img src="<?php echo base_url(); ?>/resources/images/micuenta/icono-carrito.png" alt="icono de mis compras" />
                <h1>MIS <span style="color: #C60200;">COMPRAS</span></h1>
            </div>

            <div class="div-separador-titulo"></div>
        </div>


        <div id="usuario-div-tareas-all">

            <?php
            $temp_impar = false;
            $var = 1;
            $sizeCarritos = sizeof($carritos_compras);
            $contador1 = 0;
            if (sizeof($carritos_compras) != 0) {
                foreach ($carritos_compras as $carrito_compra) {
                    $contador1 ++;
                    ?>
                                <div class="usuario-div-compra <?php 
                if(($sizeCarritos%2 == 0 && $contador1 < $sizeCarritos-1)) echo "subsesion";
                else if($sizeCarritos%2 ==1 && $contador1 != $sizeCarritos) echo "subsesion";
                ?> open-sans <?php
                    if ($temp_impar) {
                        echo 'compraderecha';
                        $temp_impar = false;
                    } else {
                        $temp_impar = true;
                    }
                                ?>">
                                    <div class="usuario-div-compra-left">

                                        <div class="usuario-div-compra-marco">
                                            <img src="<?php echo base_url(); ?>resources/images/micuenta/icono-carrito-temp.png" alt="icono compra" /> 
                                        </div>

                                    </div>

                                    <div class="usuario-div-compra-right">
                                        <div class="usuario-div-compra-titulo">
                                            <?php echo 'Compra # '.str_pad($carrito_compra->id_consecutivo_factura, 4, '0', STR_PAD_LEFT); ?>
                                        </div>

                                        <div class="usuario-div-compra-precio">
                                            $<?php echo number_format($carrito_compra->total, 0, ',', '.'); ?>
                                        </div>

                                        <div class="usuario-div-compra-fecha">
                                            <?php echo strftime("%B %d de %Y", strtotime($carrito_compra->fecha)); ?>
                                        </div>

                                        <div class="usuario-div-compra-estado">
                                            <strong style="color:black;">Estado:</strong> <span><?php echo $carrito_compra->estado; ?></span>
                                        </div>

                                        <div class="usuario-div-compra-factura">
                                            <a href="<?php echo base_url().'usuario/recibo/'.$carrito_compra->refVenta;?>">RECIBO</a><img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /> 
                                        </div>

                                        <div class="clear"></div>
                                    </div>

                                </div>

                                <?php
                                $numero_carrito_compra_autoparte++;
                                if ($var % 2 == 0) {
                                    echo '<div class="clear"></div>';
                                }
                                $var++;
                }
            }
            ?>
            <div class="clear"></div>
        </div>

        <div class="usuario-div-compra-vermas div-ver-mas open-sans">
            <span class="usuario-span-compras-vermas">VER MÁS COMPRAS</span>
            <img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" />
        </div>
    </div>-->

    <div id="usuario-div-comunidad">
        <div id="usuario-div-comunidad-header">
            <div id="usuario-div-comunidad-header-izq">
                <img src="<?php echo base_url(); ?>resources/images/micuenta/icono-comunidad.png" alt="icono de comunidad" />
                <h1>COMUNIDAD</h1>
            </div>

            <div class="div-separador-titulo"></div>
        </div>


        <div id="usuario-div-comunidad-all" class="open-sans">

            <div id="usuario-div-comunidad-preguntas">

                <div id="usuario-div-comunidad-header">
                    <div id="usuario-div-comunidad-header-izq">
                        <img src="<?php echo base_url(); ?>resources/images/micuenta/icono-pregunta.png" alt="icono de pregunta" />
                        <h1>MIS <span style="color: #C60200;">PREGUNTAS ( <?php echo $numPreguntas; ?> )</span></h1>
                    </div>

                    <div class="div-separador-titulo"></div>
                </div>

                <div class="usuario-div-comunidad-contenedor">

                    <?php foreach ($preguntas as $pregunta): ?>

                        <div class="usuario-div-comunidad-pregunta">

                            <img src="<?php echo base_url(); ?>resources/images/micuenta/mayor-que-rojo.png" alt="mayor que" />

                            <div class="usuario-div-comunidad-pregunta-derecha">
                                <div class="usuario-div-comunidad-pregunta-titulo">
                                    <a href="<?php echo base_url() . 'preguntas/' . $pregunta->id_pregunta . '-' . str_replace(" ", "-", convert_accented_characters($pregunta->titulo_pregunta)); ?>"><?php echo $pregunta->titulo_pregunta; ?></a>
                                </div>

                                <div class="usuario-div-comunidad-pregunta-contenido">
                                    <?php
                                    $text = strip_tags($pregunta->cuerpo_pregunta);
                                    $words = explode(" ", $text);
                                    $content = "";
                                    $i = 0;
                                    foreach ($words as $word) {
                                        if ($i == 25) {
                                            break;
                                        }
                                        if ($i) {
                                            $content .= " ";
                                        }
                                        $content .= $word;
                                        $i++;
                                    }
                                    echo $content . "…";
                                    ?>
                                </div>

                                <div class="usuario-div-comunidad-pregunta-respuestas">
                                    <a href="<?php echo base_url() . 'preguntas/' . $pregunta->id_pregunta . '-' . str_replace(" ", "-", convert_accented_characters($pregunta->titulo_pregunta)); ?>"><?php echo $pregunta->numero_respuestas; ?> respuestas</a>
                                </div>
                            </div>

                            <div class="clear"></div>

                        </div>

                    <?php endforeach; ?>

                </div>

                <div class="usuario-div-comunidad-vermas usuario-div-preguntas-vermas div-ver-mas">
                    <span class="usuario-span-comunidad-vermas-preguntas">VER MÁS PREGUNTAS</span><img style="margin-left:3px;" src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                </div>

            </div>

            <div id="usuario-div-comunidad-respuestas">

                <div id="usuario-div-comunidad-header">
                    <div id="usuario-div-comunidad-header-izq">
                        <img src="<?php echo base_url(); ?>resources/images/micuenta/icono-respuestas.png" alt="icono de respuesta" />
                        <h1>MIS <span style="color: #C60200;">RESPUESTAS ( <?php echo $numRespuestas; ?> )</span></h1>
                    </div>

                    <div class="div-separador-titulo"></div>
                </div>


                <div class="usuario-div-comunidad-contenedor">

                    <?php foreach ($respuestas as $respuesta): ?>
                        <div class="usuario-div-comunidad-pregunta">

                            <img src="<?php echo base_url(); ?>resources/images/micuenta/mayor-que-rojo.png" alt="mayor que" />

                            <div class="usuario-div-comunidad-pregunta-derecha">
                                <div class="usuario-div-comunidad-pregunta-titulo">
                                    <a href="<?php echo base_url() . 'preguntas/' . $respuesta->id_pregunta . '-' . str_replace(" ", "-", convert_accented_characters($respuesta->titulo_pregunta)); ?>"> <?php echo $respuesta->titulo_pregunta; ?></a>
                                </div>

                                <div style="position: relative;">
                                    <img id="usuario-div-comunidad-triguangulo" src="<?php echo base_url() ?>resources/images/micuenta/triangulo-caja.png" />
                                    <div class="usuario-div-comunidad-pregunta-contenido">
                                        <?php
                                        $text = strip_tags($respuesta->respuesta);
                                        $words = explode(" ", $text);
                                        $content = "";
                                        $i = 0;
                                        foreach ($words as $word) {
                                            if ($i == 35) {
                                                break;
                                            }
                                            if ($i) {
                                                $content .= " ";
                                            }
                                            $content .= $word;
                                            $i++;
                                        }
                                        echo $content . "…";
                                        ?>
                                    </div>
                                </div>

                                <div class="usuario-div-comunidad-pregunta-respuestas">
                                    <a href="<?php echo base_url() . 'preguntas/' . $respuesta->id_pregunta . '-' . str_replace(" ", "-", convert_accented_characters($respuesta->titulo_pregunta)); ?>"><?php echo $respuesta->numero_respuestas; ?> respuestas</a>

                                    <div class="usuario-div-comunidad-pregunta-autor">
                                        <div class="usuario-div-comunidad-pregunta-autor-nombre">
                                            Por: <?php echo $respuesta->nombres . " " . $respuesta->apellidos; ?>
                                        </div>
                                        <div class="usuario-div-comunidad-pregunta-autor-fecha">
                                            <?php echo strftime("%d de %B de %Y", strtotime($respuesta->fecha)); ?>
                                        </div>
                                    </div>

                                    <div class="clear"></div>
                                </div>
                            </div>

                            <div class="clear"></div>

                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="usuario-div-comunidad-vermas usuario-div-respuestas-vermas div-ver-mas">
                    <span class="usuario-span-comunidad-vermas-respuestas">VER MÁS RESPUESTAS</span><img style="margin-left:3px;" src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                </div>							
            </div>	



        </div>
        <div id="usuario-div-comunidad-talleres" class="open-sans">

            <div id="usuario-div-comunidad-header">
                <div id="usuario-div-comunidad-header-izq">
                    <img src="<?php echo base_url(); ?>resources/images/micuenta/icono-talleres.png" alt="icono de talleres" />
                    <h1>TALLERES <span style="color: #C60200;">CALIFICADOS  ( <?php echo $numEstablecimientos; ?> )</span></h1>
                </div>

                <div class="div-separador-titulo"></div>
            </div>


            <div class="usuario-div-comunidad-contenedor">
                <?php foreach ($establecimientos as $establecimiento): ?>
                    <div class="usuario-div-comunidad-talleres-fototaller">
                        <div class="usuario-div-comunidad-talleres-marco">
                            <a href="<?php echo base_url() . 'talleres/' . $establecimiento->id_establecimiento . '-' . str_replace(" ", "-", convert_accented_characters($establecimiento->nombre)); ?>"><img src="<?php echo base_url() . $establecimiento->logo_thumb_url; ?>" alt="icono establecimiento" /></a>
                        </div>
                        <div class="usaurio-div-comunidad-talleres-tallerinfo">
                            <div class="usaurio-div-comunidad-talleres-taller-nombre"><a href="<?php echo base_url() . 'talleres/' . $establecimiento->id_establecimiento . '-' . str_replace(" ", "-", convert_accented_characters($establecimiento->nombre)); ?>"><?php echo $establecimiento->nombre; ?></a></div>

                            <div class="usaurio-div-comunidad-talleres-taller-url">
                                <div class="">
                                    <?php
                                    $text = strip_tags($establecimiento->descripcion);
                                    $words = explode(" ", $text);
                                    $content = "";
                                    $i = 0;
                                    foreach ($words as $word) {
                                        if ($i == 6) {
                                            break;
                                        }
                                        if ($i) {
                                            $content .= " ";
                                        }
                                        $content .= $word;
                                        $i++;
                                    }
                                    echo $content . "…";
                                    ?>
                                </div>
                                <a href="http://<?php echo $establecimiento->web; ?>" target="_blank"><?php echo $establecimiento->web; ?></a>
                            </div>

<!--                            <div class="usaurio-div-comunidad-talleres-taller-direccion">
                                <?php echo $establecimiento->direccion; ?>
                            </div>

                            <div class="usaurio-div-comunidad-talleres-taller-telefono">
                                <strong style="color:black;">Tel: </strong><?php echo $establecimiento->telefonos; ?>
                            </div>--> 

                        </div>
                        <div class="clear"></div>

                        <div style="position: relative; ">
                            <img id="usuario-div-comunidad-triguangulo" src="<?php echo base_url(); ?>resources/images/micuenta/triangulo-caja.png" />
                            <div class="usuario-div-comunidad-talleres-comentario open-sans">
                                <div class="usuario-div-comunidad-talleres-comentario-imagen">
                                    <img src="<?php
                                if ($usuario->imagen_url != NULL || $usuario->imagen_url != '') {
                                    echo base_url() . $usuario->imagen_url;
                                } else {
                                    echo base_url() . 'resources/images/usuarios/avatar.gif';
                                }
                                ?>" alt="foto usuario" />
                                </div>


                                <div class="usuario-div-comunidad-talleres-comentario-nombrefecha">
                                    <div class="usuario-div-comunidad-talleres-comentario-nombre">
                                        <?php echo $usuario->nombres; ?>
                                    </div>


                                    <div class="usuario-div-comunidad-talleres-comentario-fecha">
                                        <?php echo strftime("%d de %B de %Y", strtotime($establecimiento->fecha)); ?>
                                    </div>
                                </div>

                                <div class="usuario-div-comunidad-talleres-comentario-comentariocalificacion">
                                    <div class="usuario-div-comunidad-talleres-comentario-comentario">
                                        <?php
                                        $text = strip_tags($establecimiento->comentario);
                                        $words = explode(" ", $text);
                                        $content = "";
                                        $i = 0;
                                        foreach ($words as $word) {
                                            if ($i == 4) {
                                                break;
                                            }
                                            if ($i) {
                                                $content .= " ";
                                            }
                                            $content .= $word;
                                            $i++;
                                        }
                                        echo $content . "…";
                                        ?>

                                    </div>

                                    <div class="usuario-div-comunidad-talleres-comentario-calificacion estrellas-sin-clasificar">
                                        <div class="usuario-div-comunidad-talleres-comentario-calificacion-activa estrellas-clasificadas"><span><?php echo round($establecimiento->calificacion)*20;?>%</span></div>
                                    </div>
                                </div>

                                <div class="clear"></div>
                            </div>	
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>



            <div class="usuario-div-comunidad-vermas usuario-div-talleres-vermas div-ver-mas">
                <span class="usuario-span-comunidad-vermas-talleres  open-sans">VER OTROS TALLERES</span><img style="margin-left:3px;" src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" />
            </div>

        </div>

        <div class="clear"></div>

    </div>
</div>
<div id="usuario-div-lightbox-tarea"></div>
<div id="registro-login-div"></div> 