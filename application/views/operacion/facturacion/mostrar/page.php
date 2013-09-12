<!doctype html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php $this->load->view($nombrevista.'styles')?>
</head>

<body>


<div>
	<?php if($msj == 'facturaScs'): ?>
	<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La factura ah sido generada</div>
	<?php endif;?>
	<?php if($msj == 'reciboScs'): ?>
	<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>El recibo ah sido generado</div>
	<?php endif;?>
	<h3>Links de pago</h3>
	<div class="">
		<table class="table" id="links">
			<thead>
				<th></th>
				<th>id</th>
				<th>link de pago</th>
				<th>Titulo</th>
 			</thead>
			<tbody>
				<?php foreach ($link_pago_model as $link):?>
				<tr>
					<td><input type="checkbox" value="<?php echo $link->oferta->id_oferta?>"></td>
					<td><?php echo $link->id;?></td>
					<td><a href="<?php echo base_url().$link->url;?>" target="_blank"><?php echo base_url().$link->url;?></a></td>
					<td><?php echo $link->oferta->titulo;?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>

		<div class="row">
			<button id="generar" class="btn btn-success pull-right" onclick="generar()">Generar factura</button>
			<button id="generar" class="btn btn-success pull-right" onclick="generar_recibo()">Generar recibo</button>
			<button id="actualizar" class="btn btn-success pull-right" onclick="location.reload()">Actualizar datos</button>
		</div>
	</div>
	<div>
		<h3>Facturas generadas</h3>
		<table class="table row9">
			<thead>
				<th>id</th>
				<th>concecutivo</th>
				<th>link de la factura</th>
				<th>estado</th>
 			</thead>
			<tbody>
				<?php foreach ($facturas as $factura):?>
				<tr>
					<td><?php echo $factura->id;?></td>
					<td><?php echo $factura->id_consecutivo_factura;?></td>
					<td><a href="<?php echo base_url().$factura->url;?>" target="_blank"><?php echo base_url().$factura->url;?></a></td>
					<td><?php if($factura->anulado){echo 'Anulada';}else{?><button class="btn btn-link" onclick="anular(<?php echo $factura->id ?>, this, <?php echo $factura->id_consecutivo_factura; ?>)">Anular</button><?php }?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>

	<div>
		<h3>Recibos generados</h3>
		<table class="table row9">
			<thead>
				<th>id</th>
				<th>concecutivo</th>
				<th>link del recibo</th>
 			</thead>
			<tbody>
				<?php foreach ($recibos as $recibo):?>
				<tr>
					<td><?php echo $recibo->id;?></td>
					<td><?php echo $recibo->id_consecutivo_recibo;?></td>
					<td><a href="<?php echo base_url().$recibo->url;?>" target="_blank"><?php echo base_url().$recibo->url;?></a></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>
<?php $this->load->view($nombrevista.'scripts')?>
</body>
</html>