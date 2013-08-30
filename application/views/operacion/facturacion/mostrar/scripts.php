<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>

<script>
//genera la factura
function generar(){
	var chkbxs = $('input[type=checkbox]:checked', '#links');
	if(chkbxs.length > 0){
		var url = '';
		$.each(chkbxs, function(i,e){
			url += $(e).val()+'-';
		});
		url = url.slice(0, url.lastIndexOf("-"));
		window.location = "<?php echo base_url();?>operacion/facturacion/form_factura/<?php echo $id_pipeline;?>/<?php echo $id_usuario?>/"+url+'/';
	}else{
		alert('Debes escoger almenos 1 item para generar la factura');
	}
}

//genera la factura
function generar_recibo(){
	var chkbxs = $('input[type=checkbox]:checked', '#links');
	if(chkbxs.length > 0){
		var url = '';
		$.each(chkbxs, function(i,e){
			url += $(e).val()+'-';
		});
		url = url.slice(0, url.lastIndexOf("-"));
		window.location = "<?php echo base_url();?>operacion/facturacion/form_recibo/<?php echo $id_pipeline;?>/<?php echo $id_usuario?>/"+url+'/';
	}else{
		alert('Debes escoger almenos 1 item para generar el recibo');
	}
}
</script>