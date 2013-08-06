<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/numeral.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/typeahead.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.handsontable.full.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.json-2.4.min.js"></script>
<script src="<?php echo base_url(); ?>resources/js/bootstrap-datepicker.js"></script>

<script data-jsfiddle="example1">
var modificado = false; //si se ha modificado algo en la tabla
var ini = true; //la aplicación ha sido cargada por primera ves
var load_cotizacion = <?php echo json_encode($cotizacion);?>; //datos de la cotización
var load_items = <?php echo json_encode($items);?>; //datos de los items
var idItem = []; //id de los items
var precreado = false; //ha sido precreada la página
var $ht = $("#example1");  //la tabla
var colWidths = [100, 60, 90, 90]; //el ancho de cada una de las columnas
var establecimientos = <?php echo json_encode($all_establecimientos); ?>; //json de los establecimientos disponibles 
var proveedoresSelec = []; //los proveedores seleccionados
// console.log(establecimientos);
var autocompleteProveedor = $('#input-proveedor').typeahead({
	source: function(q, process){
		objects = [];
    	map = {};

    	$.each(establecimientos, function (i, object) {
	        map[object.label] = object;
	        objects.push(object.label);
	    });
	 
	    process(objects);
	},updater: function(item) {
        $('#input-eproveedor').val(map[item].email);
        return item;
    }
});
   // autocompleteProveedor.data('typeahead').source = establecimientos; 

if(load_cotizacion){
	$('#rete-cree').val(load_cotizacion.cree);
	$('#rete-ica').val(load_cotizacion.ica);
	$('#rete-retefuente').val(load_cotizacion.retefuente);
}

var load_iva = Create2DArray(100);
var load_id_proveedor = Create2DArray(100);
if(load_items.length > 0){
	precreado = true;
	var currentData = [];
	var mkHeader = true;
	var notas = Create2DArray(100);
	var header = new Array();
	var seleccionados = [];
	var proveedores = [];
	header.push("Item");
	header.push("Cantidad");
	var columnDef = new Array();
	columnDef.push({data: 'item', type: {renderer: itemRender}});  
	columnDef.push({data: 'cantidad', allowInvalid: false, type: 'numeric'});
	var dSchema = {};
	dSchema.item = null;
	dSchema.cantidad = 1;  
	colWidths = [100, 60];
	$.each(load_items,function(i,e){
		var curdata = [];
		curdata['item'] = e.item;
		if(!isNaN(parseFloat(e.cantidad)) && isFinite(e.cantidad))
			curdata['cantidad'] = parseInt(e.cantidad);
		idItem[i] = e.id;
		$.each(e.proveedores,function(i1,e1){
			if(mkHeader){
				header.push('<input type="text" onclick="quitarSelect()" onchange="cambiarHeader(this, '+(i1+2)+')" data-eproveedor="'+e1.email+'" value="'+e1.proveedor+'" style="width: 75px;">');
				proveedores.push(e1.proveedor);
				dSchema[e1.proveedor] = {costo: null};
				var cost = e1.proveedor+'.costo';
			    columnDef.push({data: cost, type: {renderer: selectRender}});

			    var provData = [];
				provData['proveedor'] = e1.proveedor;
				provData['email'] = e1.email;
				proveedoresSelec.push(provData); 
			}
			if(e1.elegido == 1)
				seleccionados[i] = i1+2;
			load_id_proveedor[i][i1+2] = e1.id;
			curdata[e1.proveedor] = {costo: parseFloat(e1.lp_valor)};
			if(e1.nota != null)
				notas[i][i1+2] = e1.nota;

			load_iva[i][i1+2] = e1.iva;

			colWidths.push(90);
		});
		if(mkHeader)
			mkHeader=false;

		if(!isNaN(parseFloat(e.margen)) && isFinite(e.margen))
			curdata['margen'] = parseFloat(e.margen);
		curdata['precio'] = "";
		currentData[i] = curdata;
	});
	header.push("Margen LP(%)");
	header.push("Precio al cliente");
	columnDef.push({data: 'margen', allowInvalid: false, type: 'numeric'});  
	columnDef.push({data: 'precio', type: {renderer: myAutocompleteRenderer}, readOnly: true});  
	dSchema.margen = 0;
	dSchema.precio = 0;	
	colWidths.push(90);
	colWidths.push(90);
	// console.log(header);
	// console.log(seleccionados);
	// console.log(columnDef);
	// console.log(dSchema);
	// console.log(currentData);
	// console.log('nota', notas);
	// console.log('iva', load_iva);
}else{
	var notas = Create2DArray(100); 
	var seleccionados = [];
	var proveedores = [];
	var header = new Array();
	header[0] = "Item";
	header[1] = "Cantidad";
	header[2] = "Margen LP(%)";
	header[3] = "Precio al cliente";
	var columnDef = new Array();
	columnDef.push({data: 'item'});  
	columnDef.push({data: 'cantidad', allowInvalid: false, type: 'numeric'});  
	columnDef.push({data: 'margen', allowInvalid: false, type: 'numeric'});  
	columnDef.push({data: 'precio', type: {renderer: myAutocompleteRenderer}, readOnly: true});  
	var dSchema = {};

	dSchema.item = null;
	dSchema.cantidad = 1;
	dSchema.margen = 0;
	dSchema.precio = 0;	
}

$(document).ready(function() {
	mostrar_alerta();
	
	//setea el datepicker
	$('.date-picker').datepicker();

	
	// $('.date').datepicker();
	//agrega un proveedor
	$('#agregarProveedor').submit(function(e){
		e.preventDefault();
		agregar_columna();
	});

	//previene que se envíe la forma de orden de compra por defecto
	$('#form-orden-compra').submit(function(e){
		e.preventDefault();
		generar_orden_compra(e);
	});

	numeral.language('es', {
		delimiters: {
			thousands: '.',
			decimal: ','
		},
		abbreviations: {
			thousand: 'k',
			million: 'mm',
			billion: 'b',
			trillion: 't'
		},
		ordinal : function (number) {
			var b = number % 10;
			return (b === 1 || b === 3) ? 'er' :
			(b === 2) ? 'do' :
			(b === 7 || b === 0) ? 'mo' : 
			(b === 8) ? 'vo' :
			(b === 9) ? 'no' : 'to';
		},
		currency: {
			symbol: '$'
		}
	});

  // switch between languages
  numeral.language('es');

  var maxed = false
    , resizeTimeout
    , availableWidth
    , availableHeight, 
    $window = $(window);

    var calculateSize = function () {
    var offset = $ht.offset();
    availableWidth = $window.width() - offset.left + $window.scrollLeft();
    availableHeight = $window.height() - offset.top + $window.scrollTop();
  };
  $window.on('resize', calculateSize);

  $ht.handsontable({
  	dataSchema: dSchema,
  	data: currentData,
  	startRows: 3,
  	startCols: 1,
  	minRows: 3,
  	minCols: 1,
  	colWidths: colWidths,
  	stretchH: 'all',
  	scrollH: 'auto',
  	scrollV: 'auto',
  	width: function () {
      if (maxed && availableWidth === void 0) {
        calculateSize();
      }
      return maxed ? availableWidth : 600;
    },
    height: function () {
      if (maxed && availableHeight === void 0) {
        calculateSize();
      }
      return maxed ? availableHeight : 170;
    },currentRowClassName: 'currentRow',
  	currentColClassName: 'currentCol',
  	minSpareCols: 1,
  	minSpareRows: 1,
  	colHeaders: header,
  	columns: columnDef,
  	autoWrapRow: true,
  	contextMenu: {
  		callback: function (key, options) {
  			if (key === 'seleccionar') {
  				seleccionar_item_proveedor();
  			}else if(key === 'iva'){
  				cambiar_iva();
  				dar_mejor_cotizacion();
  				motrar_cotizacion();
  			}else if(key === 'nota'){
  				editar_nota();
  			}
  		},items: {
  			'nota':{name: "Nota", disabled: function () {
            //if first, second column, disable this option
            return ($ht.handsontable('getSelected')[1] === 0 || $ht.handsontable('getSelected')[1] === 1 || $ht.handsontable('getSelected')[1] === $ht.handsontable('countCols')-2 || $ht.handsontable('getSelected')[1] === $ht.handsontable('countCols')-1);
        }
    },
    "hsep1": "---------",
    'iva': {
    	name: "IVA", disabled: function () {
            //if first, second column, disable this option
            return ($ht.handsontable('getSelected')[1] === 0 || $ht.handsontable('getSelected')[1] === 1 || $ht.handsontable('getSelected')[1] === $ht.handsontable('countCols')-2 || $ht.handsontable('getSelected')[1] === $ht.handsontable('countCols')-1);
        }
    },'seleccionar':{name: "Seleccionar", disabled: function () {
	          //if first, second column, disable this option
	          return ($ht.handsontable('getSelected')[1] === 0 || $ht.handsontable('getSelected')[1] === 1 || $ht.handsontable('getSelected')[1] === $ht.handsontable('countCols')-2 || $ht.handsontable('getSelected')[1] === $ht.handsontable('countCols')-1);
	      }
	  }
	}
},afterCreateRow: function(e){
	var currentData = this.getData();

	currentData[e]['item'] = "";
	currentData[e]['cantidad'] = "";
	for (var i = 0; i < proveedores.length; i++) {
		var probTemp = proveedores[i];
		currentData[e][probTemp] = {costo: ""};
	};
	currentData[e]['margen'] = "";
	currentData[e]['precio'] = "";
},afterChange: function(c,s){
	$ht.handsontable('render');
	motrar_cotizacion();
	if(!precreado)
		dar_mejor_cotizacion();
	precreado = false;

	if(!ini)
		modificado = true;	
	ini = false;
}
});

//formatea los valores de las retenciones como porcentajes
	$('.retenciones').mask('99.9');

});

//agrega una columna a la tabla
function agregar_columna(){
	var $proveedor = $('#input-proveedor').val();
	$proveedor = $proveedor.replace(/[^a-z0-9\-]/ig,"");
	var $eproveedor = $('#input-eproveedor').val();
	if($proveedor != '' && $proveedor != 'item' && $proveedor != 'cantidad' && $proveedor != 'margen LP(%)' && $proveedor != 'precio al cliente'){
		var provData = [];
		provData['proveedor'] = $eproveedor;
		provData['email'] = $proveedor;
		proveedoresSelec[$proveedor] = provData;
		proveedores.push($proveedor);
		header.splice(header.length-2,0,'<input type="text" onclick="quitarSelect()" data-eproveedor="'+$eproveedor+'" onchange="cambiarHeader(this, '+(header.length-2)+')" value="'+$proveedor+'"  style="width: 75px;">');
		dSchema[$proveedor] = {costo: null};
    var htInstance = $ht.handsontable('getInstance');
    var cost = $proveedor+'.costo';
    columnDef.splice(header.length-3,0,{data: cost, type: {renderer: selectRender}}); 
    var currentData = htInstance.getData();
    for (var i = 0; i < htInstance.countRows(); i++) {
    	currentData[i][$proveedor] = {costo: ""};
    };
    colWidths.splice(header.length-3,0,90); 
    htInstance.updateSettings({
    	data: currentData,
    	colWidths: colWidths,
    	dataSchema: dSchema,
    	colHeaders: header,
    	columns: columnDef
    });

	$('#input-proveedor').val('');
	$('#input-eproveedor').val('');
    motrar_cotizacion();
    dar_mejor_cotizacion();
    modificado = true;
}
}



function sanitize_title_with_dashes($title) {
    $title = strip_tags($title);
    // Preserve escaped octets.
    $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
    // Remove percent signs that are not part of an octet.
    $title = str_replace('%', '', $title);
    // Restore octets.
    $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

    if (seems_utf8($title)) {
        if (function_exists('mb_strtolower')) {
            $title = mb_strtolower($title, 'UTF-8');
        }
        $title = utf8_uri_encode($title, 200);
    }

    $title = strtolower($title);
    $title = preg_replace('/&.+?;/', '', $title); // kill entities
    $title = str_replace('.', '-', $title);
    $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
    $title = preg_replace('/\s+/', '-', $title);
    $title = preg_replace('|-+|', '-', $title);
    $title = trim($title, '-');

    return $title;
}

// function bindDumpButton() {
// 	$('body').on('click', 'button[name=dump]', function () {
// 		var dump = $(this).data('dump');
// 		var $ht = $(dump);
// 		console.log('data of ' + dump, $ht.handsontable('getData'));
// 	});
// }
// bindDumpButton();

//selecciona un item para el proveedor
function seleccionar_item_proveedor(){
	var htInstance = $ht.handsontable('getInstance');
	var selected = htInstance.getSelected();
	var cell = htInstance.getCell(selected[0], selected[1]);
	var tieneClase = false;
	if($(cell).hasClass('seleccionado'))
		tieneClase = true;

	if(!tieneClase){
		seleccionados[selected[0]] = selected[1];
	}else{
		seleccionados[selected[0]] = '';
	}
	
	htInstance.render();
	dar_mejor_cotizacion();
	motrar_cotizacion();
	modificado = true;
}


//selecciona una casilla y la marca como seleccionada
var seleccionarCotizados = function (instance, td, row, col, prop, value, cellProperties) {
	Handsontable.TextCell.renderer.apply(this, arguments);
	$(td).addClass('sugerido');
}

//Muestra la cotización hecha para el cliente
function dar_mejor_cotizacion(){
	var htInstance = $ht.handsontable('getInstance');
	var currentData = htInstance.getData();
	var proveedorSelect = [];
	for (var i = 0; i < htInstance.countRows(); i++) {
		if(!seleccionados[i]){
			var item = currentData[i]['item'];
			var ganancia = -1;
			var ivaTEMP = 0.16;
			var colTemp = -1;
      //dar la celda
      for (var col = 2; col < htInstance.countCols()-2; col++) {
      	var costo = htInstance.getDataAtCell(i, col);
      	if(costo != "" && costo != null){
      		var td =  htInstance.getCell(i, col);
      		var cellMeta = htInstance.getCellMeta(i, col);
      		var prop = cellMeta.prop;
      		prop = prop.split(".");
      		prov = prop[0];
      		if($(td).attr('data-iva')){
      			ivaTEMP = parseFloat($(td).attr('data-iva'));
      		}

      		var iva = (costo -(costo/(1+ivaTEMP)));
      		var costoTEMP = costo + iva;
      		if(costoTEMP < ganancia || ganancia < 0){
      			ganancia = costoTEMP;
      			colTemp = col;
      		}
      	}
        }//end if costo vacio 
        var td =  htInstance.getCell(i, colTemp);
        $(td).addClass('sugerido');
    }
  }//fin for rows
}

//muestra un preview de la cotización
function motrar_cotizacion(){
	$('tbody', '#cotizacion').empty();
	var TIvaCliente = 0;
	var TBaseCliente = 0;
	var TCosto = 0;
	var TIVALP = 0;
	var TValorLP = 0;
	var TPrecioCliente = 0;
	var TGanancia = 0;
	var htInstance = $ht.handsontable('getInstance');
	for (var row = 0; row < htInstance.countRows()-1 ; row++) {
		var tr = $('<tr>');
		var itemVal= 0;
		var cantidad = 0;
		var proveedor = 0;
		var valor = 0;
		var valorLP = 0;
		var ganancia = 0;
		var ivaAttr = 16;
		var id_proveedor;
		for (var col = 0; col < htInstance.countCols(); col++) {
			var item =  htInstance.getCell(row, col);
			if(col == 0){
				var itemVal = $(item).text();
			}else if(col == 1){
				var cantidad = $(item).text();
			}else if(col < htInstance.countCols()-2){
				if($(item).hasClass('seleccionado') && itemVal != ''){
					id_proveedor = $(item).attr('data-id-proveedor');
					proveedor = $(header[col]);
					proveedor = proveedor.val();
					$(item).remove('a.atooltip');
					valorLP = numeral().unformat($(item).text());
					if($(item).attr('data-iva'))
						ivaAttr = parseFloat($(item).attr('data-iva').replace('%', ''));  
				}
			}else if(col == htInstance.countCols()-2 && itemVal != ''){
				ganancia = $(item).text();
			}
		}
		if(valorLP>0 && cantidad>0 && !isNaN(parseFloat(ganancia)) && isFinite(ganancia)){
			costo = valorLP/(1+(ivaAttr/100));
			var ivaLP = costo*(ivaAttr/100);

			var valor_antes_iva = costo*cantidad*((1+ganancia)/100);
			var ivaCliente = valor_antes_iva*(ivaAttr/100);
			precio_cliente = valor_antes_iva + ivaCliente;

			var inputChkbox = $('<input>').attr('type', 'checkbox').val(id_proveedor);
			tr.append($('<td>').append(inputChkbox));
			tr.append($('<td>').text(itemVal));
			tr.append($('<td>').text(proveedor));
			tr.append($('<td>').text(cantidad));
			tr.append($('<td>').text(numeral(costo).format('$0,0.00')));
			tr.append($('<td>').text(numeral(ivaLP).format('$0,0.00')));
			tr.append($('<td>').text(numeral(valorLP).format('$0,0.00')));
			tr.append('<td>'+numeral(precio_cliente-ivaCliente).format('$0,0.00') +'</td>');
			tr.append('<td>'+numeral(ivaCliente).format('$0,0.00') +'</td>');
			tr.append($('<td>').text(numeral(precio_cliente).format('$0,0.00')));
			tr.append($('<td>').text(numeral(valor_antes_iva-costo).format('$0,0.00')));
			$('tbody', '#cotizacion').append(tr);
			TIvaCliente += (ivaCliente*cantidad);
			TBaseCliente += ((precio_cliente-ivaCliente)*cantidad);
			TCosto += (costo*cantidad);
			TIVALP += (ivaLP*cantidad);
			TValorLP += (valorLP*cantidad);
			TPrecioCliente += (precio_cliente*cantidad);
			TGanancia += ((valor_antes_iva-costo)*cantidad);
		}
	}
	
	if(TValorLP > 0 && TPrecioCliente>0){
		var tr = $('<tr>');
		tr.append($('<td>').html('<strong>Total: </strong>').attr('colspan', '4').attr('align', 'right'));
		tr.append($('<td>').text(numeral(TCosto).format('$0,0.00')));
		tr.append($('<td>').text(numeral(TIVALP).format('$0,0.00')));
		tr.append($('<td>').text(numeral(TValorLP).format('$0,0.00')));
		tr.append($('<td>').text(numeral(TBaseCliente).format('$0,0.00')));
		tr.append('<td>'+numeral(TIvaCliente).format('$0,0.00') +'</td>');
		tr.append($('<td>').text(numeral(TPrecioCliente).format('$0,0.00')));
		tr.append($('<td>').text(numeral(TGanancia).format('$0,0.00')));
		$('tbody', '#cotizacion').append(tr);
	}
}

//cambia el iva de un item para un proveedor
function cambiar_iva(){
	var htInstance = $ht.handsontable('getInstance');
	var selected = htInstance.getSelected();
	var td = htInstance.getCell(selected[0], selected[1]);
	var ivaTemp = 16;
	if($(td).attr('data-iva'))
		ivaTemp = $(td).attr('data-iva');
	var iva = prompt("Ingresa el IVA(escala de 0 a 100): ", ivaTemp);
	
	if(iva != null){
		$(td).attr('data-iva', iva);     
	}
	modificado = true;
}

//funcion que muestra el precio del cliente
function itemRender(instance, td, row, col, prop, value, cellProperties) {
	Handsontable.TextCell.renderer.apply(this, arguments);
	var id = idItem[row];
	if(id)
		$(td).attr('data-id-item',id);
	return td;
}

//funcion que renderisa el valor del cliente y muestra el seleccionado
function selectRender(instance, td, row, col, prop, value, cellProperties) {
	Handsontable.NumericCell.renderer.apply(this, arguments);
	//seleccinoa el item
	if(seleccionados[row] == col){
		$(td).addClass('seleccionado');
	}

	var inner = td.innerHTML;
	inner = numeral(inner).format('$0,0.00');
	td.innerHTML = inner;

	//ingresa una nota si tiene
	var nota = notas[row][col];
	if(nota){
		var a = $('<a>').attr('href', '#').attr('rel', 'tooltip').addClass('atooltip').attr('title', nota).html('&nbsp;');
		$(td).append(a);
		$(a).tooltip({
			placement: 'right'
		});
	}

	//ingresa el iva si tiene
	var iva = load_iva[row][col];
	if(iva)
		$(td).attr('data-iva', iva);

	//ingresa el id-proveedor si existe
	var proveedor = load_id_proveedor[row][col];
	if(proveedor)
		$(td).attr('data-id-proveedor', proveedor);

	return td;
}

//funcion que muestra el precio del cliente
function myAutocompleteRenderer(instance, td, row, col, prop, value, cellProperties) {
	Handsontable.NumericCell.renderer.apply(this, arguments);
	var htInstance = $ht.handsontable('getInstance');
	var ganancia = htInstance.getDataAtCell(row, col-1);
	var selected = htInstance.getDataAtCell(row, seleccionados[row]);
	var cantidad = htInstance.getDataAtCell(row, 1);
	td.innerHTML = numeral(cantidad*selected*(1+(ganancia/100))).format('$0,0.00');
	return td;
}


//cambia el nombre del proveedor
function cambiarHeader(elem, index){
	var htInstance = $ht.handsontable('getInstance');
	var currentData = htInstance.getData();
	var prov = $(elem).val();
	header[index] = '<input type="text" onclick="quitarSelect()" onchange="cambiarHeader(this, '+(header.length-2)+')" value="'+prov+'">';
	motrar_cotizacion();
}

//función que quita todas las seldas seleccionadas
function quitarSelect(){
	var htInstance = $ht.handsontable('getInstance');
	htInstance.deselectCell();
}

//edita una nota a una celda
function editar_nota(){
	var htInstance = $ht.handsontable('getInstance');
	var selected = htInstance.getSelected();
	var td = htInstance.getCell(selected[0], selected[1]);
	var nota = $(td).attr('data-nota');
	$('#mymodal textarea').val(nota);
	$('#agregar-nota').attr('onclick', 'agregar_nota('+selected[0]+','+selected[1]+')');
	htInstance.deselectCell();
	$('#myModal').modal();
}

//agrega una nota a una celda
function agregar_nota(row, col){
	var nota =  $('#nota').val();
	notas[row][col] = nota;
	$('#myModal').modal('hide');
	$ht.handsontable('render');
	modificado = true;
}

//guarda la cotización
function guardar(){
	$('#fs-btns').attr('disabled', 'disabled');
	var data = {};
	var htInstance = $ht.handsontable('getInstance');
	var retenciones = {};
	for (var row = 0; row < htInstance.countRows()-1 ; row++) {
		var item = {};
		var proveedores = {};
		var elegido;
		for (var col = 0; col < htInstance.countCols()-1 ; col++) {
			if(col == 0){
				var itemTD = htInstance.getCell(row, col);
				item.item =  $(itemTD).text();
				item.id_item = $(itemTD).attr('data-id-item');
			}else if(col == 1){
				item.cantidad =  htInstance.getDataAtCell(row, col);
			}else if(col > 1 &&  col < htInstance.countCols() -2){
				var ops = {};

				ops.email = $(header[col]).attr('data-eproveedor');
				ops.elegido = false;
				if(seleccionados[row] == col ){
					ops.elegido = true;
				}
				ops.valorLP = htInstance.getDataAtCell(row, col);
				var tdProveedor = htInstance.getCell(row, col);
				if(ops.elegido && isNaN(parseFloat(ops.valorLP)) && !isFinite(ops.valorLP))
					ops.valorLP = 0;
				ops.iva = 16;
				if($(tdProveedor).attr('data-iva'))
					ops.iva = $(tdProveedor).attr('data-iva').replace('%', '');
				if($(tdProveedor).attr('data-id-proveedor'))
					ops.id_proveedor = $(tdProveedor).attr('data-id-proveedor');
				if($('a', tdProveedor))
					ops.nota = $('a', tdProveedor).attr('data-original-title');
				proveedores[$(header[col]).val()] = ops;
			}else if(col == htInstance.countCols()-2){
				item.margen = htInstance.getDataAtCell(row, col);
			}
		}
		item.proveedores = proveedores;
		data[row] = item;
	}
	console.log(data);
	var data = $.toJSON( data );
	retenciones.cree = $('#rete-cree').val();
	retenciones.ica = $('#rete-ica').val();
	retenciones.retefuente = $('#rete-retefuente').val();
	var retenciones = $.toJSON( retenciones );
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url(); ?>operacion/cotizaciones/guardar",
	    data: { 
	    'items': data,
	    'retenciones': retenciones,
	    'id_pipeline': '<?php echo $id_pipeline;?>',
	    'id_usuario': '<?php echo $id_usuario;?>'
	    },success: function(data){
	        window.location = '<?php echo base_url()."operacion/cotizaciones/mostrar_cotizaciones/".$id_pipeline."/".$id_usuario."/msjExito";?>';
	    },error: function(XMLHttpRequest, textStatus, errorThrown){
	    	mostrar_alerta('msjError');
	    	$("body").scrollTop(0);
	    }
	});

	$('#fs-btns').removeAttr('disabled');
}

//muestra la alerta
function mostrar_alerta(msj){
	var msjTemp = '<?php echo $msj;?>';
	if(msj == 'msjError' || msjTemp == 'msjError')
		$('.alert-danger').show();
	else if(msj == 'msjExito'  || msjTemp == 'msjExito'){
		$('.alert-success').show();
	}
}

//genera el formulario de la orden de compra
function orden_compra(){
	if(modificado){
		alert('Debes guardar primero');
	}else{
		var mostrado = false;
		$.each(proveedoresSelec, function (i, object) {

			var id_proveedor_cot = [];
			$.each($('#cotizacion tbody tr'), function (i1, object1) {
				var tds = $('td', object1);
				if($(tds[2]).text() == object['proveedor'] && $('input:checked',tds[0]).val()){
					id_proveedor_cot.push($('input:checked',tds[0]).val());
				}
			});
			if(id_proveedor_cot.length>0){ 
				id_proveedor_cot = $.toJSON( id_proveedor_cot );

				var modalClone = $('.modal-orden-compra').clone();
				$('.form-orden-compra', modalClone).submit(function(e){
					e.preventDefault();
					generar_orden_compra(this);
				});

				$('.oc-id-proveedores-cot', modalClone).val(id_proveedor_cot);
				$('.oc-proveedor', modalClone).val(object['proveedor']);
				$('.oc-email', modalClone).val(object['email']);
				modalClone.modal('show');
				$('.date-picker', modalClone).datepicker();
				mostrado = true;
			}
	    });
	}
	if(!mostrado)//si no se ha mostrado ningún modal, le muestra una alerta
		alert('Debes escoger un al menos un item para generar la orden de compra');
}

//envía la forma de orden de compra
function generar_orden_compra(elem){
	$('.submit-oc', elem).attr('disabled', 'disabled');
	var form =  $('#form-orden-compra');
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url(); ?>operacion/ordenCompra/generar_orden",
	    data: { 
	    'id-proveedores-cot': $('.oc-id-proveedores-cot', elem).val(),
	    'proveedor': $('.oc-proveedor', elem).val(),
	    'email': $('.oc-email', elem).val(),
	    'ciudad': $('.oc-ciudad', elem).val(),
	    'direccion': $('.oc-direccion', elem).val(),
	    'telefono': $('.oc-telefono', elem).val(),
	    'enviar': $('.oc-enviar', elem).val(),
	    'id_pipeline': '<?php echo $id_pipeline;?>',
	    'id_usuario': '<?php echo $id_usuario;?>'
	    },success: function(data){
	    	var data = $.parseJSON(data);
	    	var div = $('<div>').addClass('alert').addClass('alert-success');
	    	var btn = $('<button>').attr('type', 'button').addClass('close').attr('data-dismiss', 'alert').html('&times;');
	    	var a = $('<a>').attr('href','<?php echo base_url();?>'+'resources/ordenCompra/'+data.pdf).attr('target','_blank').text(data.pdf);
	    	div.append(btn);
	    	div.append('La orden de compra fue generáda. ');
	    	div.append(a);
	    	$('body').prepend(div);
	    	$(div).show();
	    	$('.modal-orden-compra').has(elem).modal('hide');
	    },error: function(XMLHttpRequest, textStatus, errorThrown){
	    	mostrar_alerta('msjError');
    		$('.submit-oc').removeAttr('disabled');
	    }
	});

}


//crea un array bi-dimensional
function Create2DArray(rows) {
	var arr = [];
	for (var i=0;i<rows;i++) {
		arr[i] = [];
	}
	return arr;
}

//crea un UUID
function guidGenerator() {
    var S4 = function() {
       return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    };
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}

</script>