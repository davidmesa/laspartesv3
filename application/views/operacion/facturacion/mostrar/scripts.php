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

//Anula la una orden de compra según el id de la orden
function anular(id, elem, consecutivo){
	var answer = confirm("¿Está seguro de que sea anular la factura con consecutivo "+consecutivo+"?");
	$(elem).attr('disabled', 'disabled');
	$(elem).text('Anulando...');
	if (answer){
		$.ajax({
		    type: "POST",
		    url: "<?php echo base_url(); ?>operacion/facturacion/anular",
		    data: { 
	    	'id': id,
		    },success: function(data){
		    	var data = $.parseJSON(data);
		    	if(data.status == true){
		        	var td = $('td').has(elem);
		        	$(td).html('<span>Anulada</span>');
		        	var td2 = $(td).prev(td);
		        	var pdf = $('a', td2).text();
		        	var split = pdf.split(".pdf");
		        	$('a', td2).text(split[0]+'-anulado.pdf').attr('href', split[0]+'-anulado.pdf');
		        }else if(!data.status && !isEmpty(data.dbsesion)){
		    		$('body').prepend('<div class="alert alert-danger" style="display: block;"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.dbsesion+' <a href="'+data.dburl+'" target="_blank">'+data.dburl+'</a></div>');
		    		$('.modal').modal('hide');
		    		$("body").scrollTop(0);
		    	}else{
		    		alert(data.msg);
		    	}
		    },error: function(XMLHttpRequest, textStatus, errorThrown){
		    	mostrar_alerta('msjError');
		    	$('.modal-orden-compra').has(elem).modal('hide');
	    		$('.submit-oc').removeAttr('disabled');
	    		$(elem).text('Anular');
				$(elem).removeAttr('disabled');
		    }
		});
	}else{
		$(elem).text('Anular');
		$(elem).removeAttr('disabled');
	}
}
</script>