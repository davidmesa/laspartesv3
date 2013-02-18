<link href="<?php echo base_url(); ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>resources/js/jquery.formatCurrency-1.4.0.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.lightbox_me.js"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.lightbox_me.js"></script>
<link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />

<script>
    $(document).ready(function(){
        $('.carrito-input-item-cantidad').change(function(){
            var padre = $('.carrito-div-item-detalles-pago').has(this);
            $('.carrito-div-item-actualizar', padre).css('display', 'block');
        }); 
        
        $('.carrito-div-item-actualizar').click(function(){
            var padre = $('.carrito-div-item-detalles-pago').has(this);
            var cantidad = $('.carrito-input-item-cantidad', padre).val();
            var precio = ($('.carrito-input-precio', padre).val())*cantidad;
            var iva = ($('.carrito-input-iva', padre).val())*cantidad;
            var row = $('.carrito-input-row-item', padre).val();
             $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/actualizar_carrito_compras",
                    async: false,
                    data: "row=" + row + "&cantidad="+cantidad,
                    success: function(data){
                         var corrio = data.split('|');
                        if(corrio[0] == 'true'){
                             var respuesta = $.parseJSON(corrio[1]);
                            $('#carrito-span-detalle-pago-total').text(respuesta.total);
                            $('#carrito-span-detalle-pago-iva').text(respuesta.iva);
                            $('#carrito-span-detalle-pago-subtotal').text(respuesta.devolucion);
                            $('#carrito-span-detalles-num-items').text(respuesta.items);    
                            $('.carrito-div-item-total', padre).text(precio);
                            $('.carrito-div-item-subtotal', padre).text(precio-iva);
                            $('.carrito-div-item-iva', padre).text(iva);
                            $('.format-precio', padre).formatCurrency({
                                roundToDecimalPlace: 0,
                                digitGroupSymbol: '.'
                            });
                            $('#carrito-span-detalle-pago-total, #carrito-span-detalle-pago-iva, #carrito-span-detalle-pago-subtotal').formatCurrency({
                                roundToDecimalPlace: 0,
                                digitGroupSymbol: '.'
                            });
                        }else{
                            alert(corrio[1]);
                        }
                    }
                }); 
            
        });
        
        
        //elimina un item del carrito de compras según el row id
        $('.carrito-div-item-eliminar').click(function(){
            var padre = $('.carrito-div-item').has(this);
            var id = $('.carrito-input-row-item', padre).val();
             $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/eliminar_carrito_compras",
                    async: false,
                    data: "id=" + id ,
                    success: function(data){
                        var corrio = data.split('|');
                        if(corrio[0] == 'true'){
                            $(padre).hide("drop", function(){ $(padre).remove(); });
                             var respuesta = $.parseJSON(corrio[1])
                            $('#carrito-span-detalle-pago-total').text(respuesta.total);
                            $('#carrito-span-detalle-pago-iva').text(respuesta.iva);
                            $('#carrito-span-detalle-pago-subtotal').text(respuesta.devolucion);
                            $('#carrito-span-detalles-num-items').text(respuesta.items);
                            $('#carrito-span-detalle-pago-total, #carrito-span-detalle-pago-iva, #carrito-span-detalle-pago-subtotal').formatCurrency({
                                roundToDecimalPlace: 0,
                                digitGroupSymbol: '.'
                            });
                        }else{
                            alert(corrio[1]);
                        }
                    }
                }); 
        });
        
        //al realizar click sobre el boton pagar se verifica que el usuario tenga sesión
        //sino tiene sesión se le muestra el formualio de resgistro/login
        //si el usuario tiene sesión, se redirecciona a carrito/datos_envio
        $('#carrito-div-pagar').click(function(){
            sesion =  $.ajax({
                url: '<?php echo base_url(); ?>usuario/dar_sesion_activa_ajax',
                type: "POST",
                success: function(data) {
                    var sesion = data;
                    if(sesion){
                        window.location = '<?php echo base_url();?>carrito/datos_envio';
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>usuario/mostrar_registro_ajax",
                            async: false,
                            success: function(data){
                                $('#registro-login-div').empty();
                                $('#registro-login-div').html(data);
                                $('#input-registro-callback').val('redireccion');
                                $('#registro-login-div').lightbox_me({
                                    centered: true
                                }); 
                            }
                        }); 
                    }
                },async: false
            }).responseText;
        });
    });
    
function onlyNumbers(evt)
    {
        var keyPressed = (evt.which) ? evt.which : event.keyCode
        return !(keyPressed > 31 && (keyPressed < 48 || keyPressed > 57));
    }
    
function redireccion(){
    window.location = '<?php echo base_url();?>carrito/datos_envio';
}    
</script>