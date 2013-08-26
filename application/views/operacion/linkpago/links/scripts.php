<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/numeral.min.js"></script>

<script>
//redirecciona a el formulario de agregar un link de pago
function generar_link(){
	var chkbxs = $('input[type=checkbox]:checked');
	if(chkbxs.length > 0){
		var url = '';
		$.each(chkbxs, function(i,e){
			url += $(e).val()+'-';
		});
		url = url.slice(0, url.lastIndexOf("-"));
		window.location = "<?php echo base_url();?>operacion/linkPago/form_link/<?php echo $id_pipeline;?>/<?php echo $id_usuario?>/"+url+'/';
	}else{
		alert('Debes escoger almenos 1 item para generar el link de pago');
	}
}

//lo envía al formulario de link de pago
function editar_oferta(id_oferta, id){
	window.location = "<?php echo base_url();?>operacion/linkPago/editar_link/"+id_oferta+"/"+id;
}

//actualiza la vista
function actualizar_vista(){
	location.reload();
}

</script>