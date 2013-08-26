<!doctype html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php $this->load->view($nombrevista.'styles')?>
</head>

<body>


<div>
	<h3>Ordenes de compra</h3>
	<a href="<?php echo base_url()?>operacion/ordenRemision/form_orden/<?php echo $id_pipeline.'/'.$id_usuario;?>">Agregar orden de compra</a>
	<div class="row">
		<table class="table span9">
			<thead>
				<th>id</th>
				<th>link de pago</th>
				<!-- <th>Acciones</th>
 -->			</thead>
			<tbody>
				<?php foreach ($ordenes as $orden):?>
				<tr>
					<td><?php echo $orden->id_bono;?></td>
					<td><a href="<?php echo base_url().'resources/remisiones/orden-de-remision-' . $orden->id_bono . '.pdf';?>" target="_blank"><?php echo base_url().'resources/remisiones/orden-de-remision-' . $orden->id_bono . '.pdf';?></a></td>
					<!-- <td>
						<button class="btn btn-link" title="Ver link de pago" onclick="editar_oferta('<?php echo $link->id_oferta;?>', '<?php echo $link->id;?>')"><img src="<?php echo base_url();?>resources/admin/images/pencil.png" alt="Ver o Actualizar Link de pago"></button>
					</td> -->
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>
<?php $this->load->view($nombrevista.'scripts')?>
</body>
</html>