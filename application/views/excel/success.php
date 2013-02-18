<h1>Hola</h1>
<?php
	foreach($sheets as $sheetName => $sheet):
?>
	<h2><?php echo $sheetName; ?></h2>
<?php
		foreach($sheet as $index => $product):
?>
			<h3><?php echo $product->name; ?></h3>
				<table>
					<tr>
						<th>Marca Vehiculo</th>
						<th>Linea Vehiculo</th>
						<th>Original</th>
						<th>Marca</th>
						<th>Precio</th>
						<th>Id Producto</th>
						<th>Id Vehiculo</th>
                                                <th>año de inicio</th>
                                                <th>año final</th>
                                                <th>categoría</th>
                                                <th>precio</th> 
					</tr>
<?php
			foreach($product->items as $id => $item):
?>
					<tr>
						<td><?php echo $item->marca_vehiculo; ?></td>
						<td><?php echo $item->linea_vehiculo; ?></td>
						<td><?php echo $item->original; ?></td>
						<td><?php echo $item->marca; ?></td>
						<td><?php echo $item->precio; ?></td>
						<td><?php echo $item->autoparte; ?></td>
						<td><?php echo $item->id_vehiculo; ?></td>
                                                <td><?php echo $item->ano_inicio; ?></td>
                                                <td><?php echo $item->ano_fin; ?></td>
                                                <td><?php echo $item->categoria; ?></td>
                                                <td><?php echo $item->precio; ?></td>
					</tr>
<?php
			endforeach;
?>
				</table>
<?php
		endforeach;
	endforeach;
 ?>