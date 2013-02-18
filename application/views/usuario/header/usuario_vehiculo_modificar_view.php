<script type="text/javascript">
    $(document).ready(function() {        
         $("#marca").change(function (){
             $("#id_vehiculo").empty();
             if($("#marca").val()=='Seleccione una marca...')
                $("#id_vehiculo").append("<option>Seleccione primero una marca...</option>");
             else{
                $("#id_vehiculo").append("<option>Cargando líneas...</option>");
                $.ajax({
                    url: "<?php echo base_url(); ?>usuario/dar_vehiculos_lineas_ajax/",
                    type: "POST",
                    data: {
                        marca: function(){ return $("#marca option:selected").val(); }
                    },
                    onsubmit: false,
                    success: function(data){
                        $("#id_vehiculo").empty();
                        $.each($.parseJSON(data), function(i,item){
                            $("#id_vehiculo").append("<option value='"+item.id_vehiculo+"'>"+item.linea+"</option>");
                        });
                    }
                });
            }
        });

        $("#formulario_modificar_vehiculo").validate({
            rules: {
                nombre: {
                    required: true
                },
                marca: {
                    required: true
                },
                id_vehiculo: {
                    required: true
                },
                modelo: {
                    required: true,
                    modeloValido: true,
                    minlength: 4
                },
                kilometraje: {
                    kilometrajeValido: true
                }
            },
            messages: {
                nombre: {
                    required: "Escriba un nombre a su vehículo. Ejemplo: Mi primer carro"
                },
                marca: {
                    required: "Seleccione una marca"
                },
                id_vehiculo: {
                    required: "Seleccione una línea de vehículo"
                },
                modelo: {
                    required: "Escriba el modelo del vehículo",
                    modeloValido: "El modelo es inválido. Por favor escríbalo nuevamente.",
                    minlength: "Es necesario escribir el modelo con los cuatro dígitos. Ejemplo: 1999"
                },
                kilometraje: {
                    kilometrajeValido: "El kilometraje es inválido. Por favor escríbalo nuevamente."
                }
            },
            invalidHandler: function(form, validator){
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1
                      ? 'Se encontró el siguiente error:\n'
                      : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x=0;x<validator.errorList.length;x++) {
                            errors += "\n\u25CF " + validator.errorList[x].message;
                        }
                    }
                    alert(message + errors);
                }
                validator.focusInvalid();
            }
        });

        $.validator.setDefaults({
            errorPlacement: function(error, element){
            }
        });
        $.validator.addMethod('modeloValido', function(value) {
            if(isNaN(value))
                return false;
            return parseFloat(value) < <?php echo date("Y")+1; ?>  && parseFloat(value) > 1970;
        }, 'El modelo es inválido. Por favor escríbalo nuevamente.');
        $.validator.addMethod('kilometrajeValido', function(value) {
            if( value != '' && isNaN(value) )
                return false;
            return true;
        }, 'El kilometraje es inválido. Por favor escríbalo nuevamente.');

    });
</script>