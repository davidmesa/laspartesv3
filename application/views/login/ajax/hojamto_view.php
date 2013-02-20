<script>
    //funcion que permite alterar el slider
    $(function() {
        $( ".slider" ).slider({
            value:0,
            min: 0,
            max: 12,
            step: 1,
            slide: function( event, ui ) {
                var padre = $('.historial_div_slider').has(this);
                $('.historial_div_slider_tarea_apuntador', padre).css('left',-4+ (ui.value* 25));
                if(ui.value < 12 && ui.value > 0)
                    $(".historial_div_slider_tarea_msj", padre).css('left', -40 + (ui.value* 25));
			
                if(ui.value == 0){
                    $(".historial_div_slider_tarea_msj", padre).text('No lo sé');
                    $( ".amount", padre).val( "" );
                }
                else{
                    var kms = <?php echo $kilometraje; ?>- ui.value* <?php echo $kilometraje_mensual; ?>;
                    if(kms < 0)
                        kms = 0;
                    $( ".amount", padre).val( kms ); //kilometraje actual - (los días que pasaron * kilometraje diario de la ciudad)
                    $(".historial_div_slider_tarea_msj", padre).text('hace ' + ui.value + ' meses' );
                }
                $('.input_historial_mes', padre).val(ui.value);
            }
        });
    });
    
        $("#form_historial").validate({ 
            rules: {
                'input_historial_kilometraje[]':{
                    number: true
                },
                'input_historial_mes[]': {
                    number: true
                },
                'input_historial_id_tarea[]': {
                    required : true,
                    number: true
                }
            },
            messages: {
                'input_historial_kilometraje[]':{
                    number: "*El kilometraje debe ser un número"
                },
                'input_historial_mes[]': {
                    number: "*El número de meses debe ser un número"
                }
            }, 
            errorClass: "form-invalid",
            validClass: "form-valid",
            highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass);
                var divValid =  $(element.form).find("div[for=" + element.id + "]");
                divValid.addClass(errorClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).removeClass(validClass);
                var divValid =  $(element.form).find("div[for=" + element.id + "]");
                divValid.addClass(validClass).removeClass(errorClass);
            },
            invalidHandler: function (form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'Se encontró el siguiente error:\n' : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x = 0; x < validator.errorList.length; x++) {
                            errors += "<br/>" +  "\n\u25CF " + validator.errorList[x].message
                        }
                    }
                    confirm(message + errors, function () {
                                                        $.modal.close();
                                                    });
//                    alert(message + errors)
                }
                validator.focusInvalid()
            },
            submitHandler: function (form) {
                $(form).bind('click');
                $('.ajax_img_loader', form).show();
                $.ajax({
                    url: "<?php echo base_url(); ?>usuario/agregar_historial_mto_ajax",
                    type: "POST",
                    data: {
                        input_historial_id_tarea: function () {
                            return $(".input_historial_id_tarea", form).serialize()
                        },
                        input_historial_mes: function () {
                            return $(".input_historial_mes", form).serialize()
                        },
                        input_historial_kilometraje: function () {
                            return $(".input_historial_kilometraje", form).serialize()
                        }
                    },
                    onsubmit: false,
                    success: function (data) {
                        var callback = $('#input-registro-callback').val();
                        if (data == 'true' && callback.length > 0) {
                            try {
                                window[callback]()
                            } catch (e) {
                                confirm(e, function () {
                                                        $.modal.close();
                                                    });
//                                alert(e)
                            }
                        } else if (data == 'false') {
                            confirm('Ocurrio un error en el registro, favor intentar más tarde', function () {
                                                        $.modal.close();
                                                    });
//                            alert('Ocurrio un error en el registro, favor intentar más tarde')
                        } else{
                            window.location = '<?php echo base_url();?>usuario';
                        }
                    }
                });
                $('.ajax_img_loader', form).hide();
                $(form).unbind('click');
            }
        });
        $(".input_historial_kilometraje").each(function (item) {
            $(this).rules("add", {
                number: true
            });
        });
//    });
    //    });

    //Valida el formulario de login
    //    $("#form_historial").validate();

    
</script>
<div id="login-div-center" class="sesion-historial"> 
    <div id="login-div-sesion">
        <div id="login-div-progreso">
            <div id="login-div-progreso-vehiculo" >DATOS DEL VEHÍCULO</div>
            <div id="login-div-progreso-historial" class="login-div-progreso-selected">HISTORIAL DE MANTENIMIENTO</div>              
        </div>
        <div class="clear"></div> 
        <div id="login-div-titulo">
            <img src="<?php echo base_url(); ?>resources/images/login/mayor-que-404040.png" alt="flechas de registro"/><span>CUÁNDO FUE LA ÚLTIMA VES QUE REALIZASTE MANTENIMIENTO</span>
        </div>
        <form id="form_historial">
            <div id="historial_div_form">
                <?php foreach ($hojaMto as $tarea): if ($tarea->id_servicio == 1 || $tarea->id_servicio == 6 || $tarea->id_servicio == 11 || $tarea->id_servicio == 28 || $tarea->id_servicio == 32): ?>
                        <div class="historial_div_slider">
                            <input type="hidden" value="<?php echo $tarea->id_servicio; ?>" name="input_historial_id_tarea[]" id="input_historial_id_tarea" class="input_historial_id_tarea" />
                            <div class="historial_div_slider_tarea">
                                <label><?php echo $tarea->nombre; ?>:</label>
                                <div id="slider" class="slider"></div>
                                <input type="hidden" value="0" name="input_historial_mes[]" id="input_historial_mes" class="input_historial_mes"/>
                                <div class="historial_div_slider_tarea_dotted"></div>
                                <div class="historial_div_slider_tarea_rango meses_6">6 Meses.</div>
                                <div class="historial_div_slider_tarea_rango meses_12">12 Meses.</div>
                                <div class="historial_div_slider_tarea_apuntador"></div>
                                <div class="historial_div_slider_tarea_msj">No lo sé</div>
                            </div>
                            <div class="historial_div_slider_kms form_login_div_campo">
                                <label for="amount">Realizado a los:</label>
                                <input type="text" id="amount_kilometraje_<?php echo $tarea->id_servicio;?>" class="amount input_historial_kilometraje " name="input_historial_kilometraje[]" value=""  /><span>Kms.</span><div for="amount_kilometraje_<?php echo $tarea->id_servicio;?>"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <?php
                    endif;
                endforeach;
                ?>
                <div class="div-registrate-submit" style="margin-right: 30px;">
                    <input type="submit" name="input_vehiculo_submit" id="input-vehiculo-submit" class="input-vehiculo-submit" value="Finalizar"/>
                    <div class="clear"></div>
                    <img src="<?php echo base_url();?>resources/images/login/ajax-loader.gif" class="ajax_img_loader" />
                </div>
                <div class="clear"></div>
            </div>
        </form>
    </div>
    <div class="clear"></div>
</div>