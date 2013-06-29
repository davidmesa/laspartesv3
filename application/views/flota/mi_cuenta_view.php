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

                <div class="usuario-div-editar editar-perfil-show" onClick="clickEditarPerfil()">
                    Editar Perfil
                </div>
                <div class="usuario-div-editar-submit editar-perfil-hidden">
                    <?php echo form_button('Cancelar', 'Cancelar', 'class="cancelar-formulario" onClick="cancelFormPerfil()"'); ?>
                    <?php echo form_submit('Guardar', 'Guardar'); ?>
                </div>
            </form>
        </div>

        <div id="usuario-div-perfil-tareas" class="open-sans">

            <div class="usuario-div-perfil-misvehiculos usuario-div-perfil-tarea activo">
                <img src="<?php echo base_url(); ?>/resources/images/micuenta/mis-vehiculos.png" alt="mis vehiculos" />
                <div class="usuario-div-perfil-misvehiculos-cantidad">
                    <span class="usuario-span-perfil-titulosesion">Mis vehículos</span><br/>
                    <!-- <span class="usuario-span-cantidad">( <?php echo $numVehiculos; ?> )</span> -->
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

        <div id="usuario-div-mis-vehiculos" class="sesion">
            <?php foreach ($flotas as $flota):?>
            <?php $nombreFlota = explode(' ', $flota->nombre, '2');?>
            <div id="usuario-div-mv-top">
                <div id="usuario-div-mv-titulo">
                    <img src="<?php echo base_url(); ?>/resources/images/micuenta/mi-vehiculo.png" alt="mi vehiculo" />
                    <h1>
                    <?php if($nombreFlota):?>
                        <span><?php echo $nombreFlota[0]; ?></span>
                        <span style="color: #C60200;"><?php echo $nombreFlota[1]; ?></span>
                    <?php else:?>
                        <span>Mi</span>
                        <span style="color: #C60200;">Flota</span>
                    <?php endif;?>
                    </h1>
                </div>

                <div id="usuario-div-mv-anadir" onclick="mostrar_agregar_vehiculo(this, <?php echo $flota->id_flota;?>)">
                    <img src="<?php echo base_url(); ?>/resources/images/micuenta/mi-vehiculo-2.png" alt="agregar vehiculo" />
                    AÑADIR VEHÍCULO
                </div>

                <div class="clear"></div>
            </div>

            <div class="div-separador-titulo"></div>
            <div id="usuario-div-mv-all">
                <div id="overlay" style="display: none;">
                Porfavor esperar...
                </div>
                
                <div id="pager" class="pager">
                    <form>
                        <img src="<?php echo base_url();?>resources/images/micuenta/pager/first.png" class="first"/>
                        <img src="<?php echo base_url();?>resources/images/micuenta/pager/prev.png" class="prev"/>
                        <input type="text" class="pagedisplay"/>
                        <img src="<?php echo base_url();?>resources/images/micuenta/pager/next.png" class="next"/>
                        <img src="<?php echo base_url();?>resources/images/micuenta/pager/last.png" class="last"/>
                        <select class="pagesize">
                            <option selected="selected"  value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option  value="40">40</option>
                        </select>
                    </form>
                </div>
                <div class="clear"></div>
                <table class="tablesorter" id="tablesorter">             
                <thead>
                    <tr> 
                        <th data-placeholder="Placa">Placa</th> 
                        <th data-placeholder="Marca">Marca</th> 
                        <th data-placeholder="Línea">Línea</th> 
                        <th data-placeholder="Kilometraje"  class="filter-false" >Kilometraje</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <?php foreach ($vehiculos[$flota->id_flota] as $car):?>
                    <tr id="carro-<?php echo $car->id_usuario_vehiculo;?>" onClick="dar_vehiculo(this, <?php echo $car->id_usuario_vehiculo;?>)"> 
                        <td><?php if($car->notificacion >0): ?><div class="notificacion-tarea"><?php echo $car->notificacion;?></div>&nbsp;&nbsp;&nbsp;<?php endif; echo $car->numero_placa;?></td> 
                        <td><?php echo $car->marca;?></td> 
                        <td><?php echo $car->linea;?></td> 
                        <td><?php echo $car->kilometraje;?></td> 
                    </tr> 
                    <?php endforeach; ?>
                </tbody> 
            </table>
            </div>
            <?php endforeach; ?>
            <div id="flota-div-template" class="flota-div-template open-sans">
                <div class="asignar-lb-close flota-t-close">&#10006;</div>
                <div class="flota-inf-carro"> 
                    <div class="inf-carro-marco">
                        
                        <img src="<?php echo base_url();?>resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd1.png" alt="foto del vehículo">
                        <div class="usuario-div-foto-editar">
                            <form class="subir_imagen_automovil" action="/usuario/subir_imagen_temp_ajax" >
                                <input type="file" name="imageUpload" size="20" class="input_imageUpload_automovil">
                            </form>
                        </div>
                    </div>
                    <div class="inf-carro-datos">
                        <form  class="editar-vehiculo">
                            <input type="hidden" class="nuevo_carro" value="1">
                            <input type="hidden" class="editar_id_usuario_vehiculo">
                            <div class="inf-dato marca-linea">
                                <span class="span-dato font-universe editar-perfil-show"></span>
                                <span class="titl-dato-h editar-perfil-hidden">Marca: </span><span class="titl-dato-h editar-perfil-hidden">Linea: </span><br/>
                                <input name="editar_marca" class="editar-perfil-hidden marca" type="text" value="">
                                <input name="editar_linea" class="editar-perfil-hidden linea" type="text" value="">
                            </div>
                            <div class="div_quisiste_decir">
                                <label style="font-size: 15px;">Quisiste decir: </label>
                                <input type="hidden" class="quisiste_decir_marca"><input type="hidden" class="quisiste_decir_linea">
                                <div class="quisiste_decir" onclick="carro_sugerido(this)"></div>
                            </div>
                            <div class="inf-dato modelo">
                                <span class="titl-dato">Modelo: </span>
                                <span class="span-dato editar-perfil-show"></span>
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
                                    echo form_dropdown('editar_modelo', $option_modelo, $selected, 'class="editar-perfil-hidden"');
                                ?>
                            </div>
                            <div class="inf-dato kilometraje">
                                <span class="titl-dato">Kilometraje: </span>
                                <span class="span-dato editar-perfil-show"></span>
                                <input name="editar_kms" class="editar-perfil-hidden" type="text" value="">
                            </div>
                            <div class="inf-dato placa">
                                <span class="titl-dato">Placa: </span>
                                <span class="span-dato editar-perfil-show"></span>
                                <input name="editar_placa" class="editar-perfil-hidden" type="text" value="">
                            </div>
                            <div class="inf-dato-editar editar-perfil-show" onclick="clickEditarCarro()">
                                Editar
                            </div>
                            <div class="inf-dato-editar-submit editar-perfil-hidden">
                                <button name="Cancelar" type="button" class="cancelar-formulario" onclick="cancelFormCarro()">Cancelar</button>                    
                                <input type="submit" name="Guardar" value="Guardar">                
                            </div>
                        </form>
                    </div> 
                </div>
                <div class="clear"></div>
                <div class="flota-tareas">
                    <div class="tareas-debo">
                        <div class="tarea-titulo">DEBO HACER</div>
                        <div class="tarea-sub-titulo">
                            <div style="color: #c60200;">PRIORIDAD ALTA</div>
                            <div>PARA HACER LO MÁS PRONTO!</div>
                        </div>
                        <div class="tarea-content"></div>
                    </div>
                    <div class="tareas-pendiente">
                        <div class="tarea-titulo">TENGO PENDIENTE</div>
                        <div class="tarea-sub-titulo">
                            <div>ESTAS COSAS, DEBES TENERLAS EN</div>
                            <div>CUENTA PRÓXIMAMENTE...</div>
                        </div>
                         <div class="tarea-content"></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="flotas-menu">
                    <div class="menu-header">
                        <div class="hist-titulo-hist fm-act" onClick="select_menu(this, false)">
                            <span class="font-universe">Historial</span>
                            <img src="<?php echo base_url();?>resources/images/micuenta/trangulo.png">
                        </div>
                        <div class="hist-titulo-hmto" onClick="select_menu(this, true)">
                            <span class="font-universe">Hoja de Mantenimiento</span>
                            <img src="<?php echo base_url();?>resources/images/micuenta/trangulo.png">
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="flota-registrar-trabajo">
                        <input type="button" class="flota-rt-button" value="&#10010;  Registrar Preventivo/Correctivo" onclick="ver_realizar_trabajo(this)">
                        <div class="flota-rt-div">
                            
                        </div>
                    </div>
                    <div class="clear"></div>

                    <div class="menu-content">
                        <div class="menu-hist">
                        </div>
                        <div class="menu-hmto fc-inactive">
                            <form class="hmto-form">
                                <table class="hmto-table">
                                    <thead>
                                        <th><input type="checkbox"></th>
                                        <th>Tarea</th>
                                        <th>Periodicidad*</th>
                                        <th>Rango de tolerancia(%)*</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="hmto-acciones">
                                    <div class="acciones-titulo font-universe">Acciones</div>
                                    <div class="htmo-div-button accion-agregar"  onclick="agregar_tarea(this)">
                                        Agregar tarea
                                    </div>
                                    <div class="htmo-div-button accion-eliminar" onclick="eliminar_tareas(this)">
                                        Eliminar tarea
                                    </div>
                                    <div class="htmo-div-button  hmto-asignar"  onclick="lighbox_asignar(this)">
                                        Asignar...
                                    </div>
                                    <div class="asignar-lightbox">
                                        <div class="asignar-lb-titulo"><span>Asigna este mantenimiento a tus otros carros</span><div class="asignar-lb-close" onclick="cerrar_asignar(this)">&#10006;</div></div>
                                        <hr>
                                        <div class="asignar-lb-carros">
                                            <?php foreach ($flotas as $flota):?>
                                            <?php foreach ($vehiculos[$flota->id_flota] as $car):?>
                                            <div class="asignar-lb-carro" data-id-usuario-vehiculo="<?php echo $car->id_usuario_vehiculo;?>" onclick="asignar_vehiculo(this)">
                                                <span class="asignar-lb-img">
                                                    <img  width="30" height="30" src="<?php 
                                                    if(!empty($car->imagen_thumb_url)){ echo base_url().$car->imagen_thumb_url;  
                                                        }else if(!empty($car->imagen_url)){ echo base_url().$car->imagen_url;
                                                        }else {echo base_url().'resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd_30x.png';} ?>" alt="<?php echo $car->numero_placa;?> (<?php echo $car->linea;?>)">
                                                </span>
                                                <span class="asignar-lb-desc">
                                                    <?php echo $car->numero_placa;?> (<?php echo $car->linea;?>)
                                                </span>
                                                <span class="asignar-lb-chk">&#10004;</span>
                                                <div class="clear"></div>
                                            </div>
                                            <?php endforeach;?>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                    <div class="htmo-div-button">
                                        Vista PDF
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <input type="submit" class="hmto-guardar htmo-div-button" value="Guardar">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loging-div" class="login-div-vehiculo">
    <div class="asignar-lb-close flota-t-close close" style="z-index: 9;">✖</div>
    <div id="login-div-center" class="sesion-vehiculo">
        <div id="login-div-sesion">
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
                        <label style="font-size: 15px;">Quisiste decir: </label>
                        <input type="hidden" id="quisiste_decir_marca">
                        <input type="hidden" id="quisiste_decir_linea">
                        <div id="quisiste_decir" onclick="carro_sugerido2()"></div>
                    </div>
                    <div class="form_login_div_campo">
                        <label>Placa:</label>
                        <input type="text" name="input_vehiculo_placa" id="input_vehiculo_placa" class="input_vehiculo_palca form_vehiculo_input" maxlength="7"/><div for="input_vehiculo_placa"></div>
                    </div>
                    <div id="vehiculo_form_div_kilo" class="form_login_div_campo">
                        <label>Kilometraje:</label>
                        <input type="text" name="input_vehiculo_kilometraje" id="input_vehiculo_kilometraje" class="input_vehiculo_kilometraje form_vehiculo_input"/><div for="input_vehiculo_kilometraje"></div>
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
                        <input type="submit" name="input_vehiculo_submit" id="input-vehiculo-submit" class="input-vehiculo-submit" value="Crear"/>
                        <input type="button" id="input-vehiculo-close" class="input-vehiculo-close close" value="Cancelar"/>
                        <img src="<?php echo base_url(); ?>resources/images/login/ajax-loader.gif" class="ajax_img_loader" />
                    </div>
                    <div class="clear"></div>
                </div>
            </form>
        </div>


        <div class="clear"></div>
    </div>
</div>
