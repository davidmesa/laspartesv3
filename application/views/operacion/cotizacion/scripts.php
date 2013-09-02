<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/numeral.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/typeahead.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.handsontable.full.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.json-2.4.min.js"></script>
<script src="<?php echo base_url(); ?>resources/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.validate.js"></script>

<script data-jsfiddle="example1">
var modificado = false; //si se ha modificado algo en la tabla
var ini = true; //la aplicación ha sido cargada por primera ves
var load_items = <?php echo json_encode($items);?>; //datos de los items
console.log('items', load_items);
var idItem = []; //id de los items
var precreado = false; //ha sido precreada la página
var $ht = $("#example1");  //la tabla
var colWidths = [100, 60, 90, 90]; //el ancho de cada una de las columnas
var establecimientos = <?php echo json_encode($all_proveedores); ?>; //json de los establecimientos disponibles 
var proveedoresSelec = []; //los proveedores seleccionados
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
		$('#input-proveedor').attr('data-direccion', map[item].direccion);
		$('#input-proveedor').attr('data-telefono', map[item].telefono);
		$('#input-proveedor').attr('data-ciudad', map[item].ciudad);
        $('#input-eproveedor').val(map[item].email);
        return item;
    }
});
   // autocompleteProveedor.data('typeahead').source = establecimientos; 


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
	columnDef.push({data: 'cantidad', allowInvalid: false, type: {renderer: numberRender}});
	var dSchema = {};
	dSchema.item = '';
	dSchema.cantidad = 1;  
	colWidths = [100, 60];
	$.each(load_items,function(i,e){
		var curdata = [];
		curdata['item'] = e.item;
		if(!isNaN(parseInt(e.cantidad)) && isFinite(e.cantidad))
			curdata['cantidad'] = parseInt(e.cantidad);
		else 
			curdata['cantidad'] = 0;
		idItem[i] = e.id;
		$.each(e.proveedores,function(i1,e1){
			var formatProveedor = e1.proveedor.proveedor.replace(/[^a-z0-9\-]/ig," ");
			if(mkHeader){
				header.push('<input type="text" onclick="quitarSelect()" onchange="cambiarHeader(this, '+(i1+2)
					+')" data-direccion="'+e1.proveedor.direccion+'" data-telefono="'+e1.proveedor.telefono+'" data-ciudad="'+
				e1.proveedor.ciudad+'" data-eproveedor="'+e1.proveedor.email+'" value="'+formatProveedor+'" style="width: 75px;">');
				proveedores.push(formatProveedor);
				dSchema[formatProveedor] = {costo: 0};
				var cost = formatProveedor+'.costo'; 
			    columnDef.push({data: cost, type: {renderer: selectRender}});

			    var provData = [];
			    provData['id_proveedor'] = e1.proveedor.id;
			    provData['proveedor'] = formatProveedor;
				provData['original_proveedor'] = e1.proveedor.proveedor;
				provData['email'] = e1.proveedor.email;
				provData['telefono'] = e1.proveedor.telefono;
				provData['direccion'] = e1.proveedor.direccion;
				provData['ciudad'] = e1.proveedor.ciudad;
				proveedoresSelec.push(provData); 
			}
			if(e1.elegido == 1)
				seleccionados[i] = i1+2;
			load_id_proveedor[i][i1+2] = e1.id;
			curdata[formatProveedor] = {costo: e1.lp_valor};
			// console.log('costoCure data', i, e1.lp_valor);
			if(e1.nota != null)
				notas[i][i1+2] = e1.nota;

			load_iva[i][i1+2] = e1.iva;

			colWidths.push(90);
		});
		if(mkHeader)
			mkHeader=false;

		if(!isNaN(parseFloat(e.margen)) && isFinite(e.margen))
			curdata['margen'] = parseFloat(e.margen);
		else 
			curdata['margen'] = 0;
		curdata['precio'] = 0;
		// console.log('curdata', i, curdata);
		currentData[i] = curdata;
	});
	header.push("Margen LP(%)");
	header.push("Precio al cliente");
	columnDef.push({data: 'margen', allowInvalid: false, type: {renderer: numberRender}});  
	columnDef.push({data: 'precio', type: {renderer: myAutocompleteRenderer}, readOnly: true});  
	dSchema.margen = 0;
	dSchema.precio = 0;	
	colWidths.push(90);
	colWidths.push(90);
	// console.log('dSchema', dSchema);
	// console.log('curdata', currentData);
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
	columnDef.push({data: 'cantidad', allowInvalid: false, type: {renderer: numberRender}});  
	columnDef.push({data: 'margen', allowInvalid: false, type: {renderer: numberRender}});  
	columnDef.push({data: 'precio', type: {renderer: myAutocompleteRenderer}, readOnly: true});  
	var dSchema = {};

	dSchema.item = null;
	dSchema.cantidad = 1;
	dSchema.margen = 0;
	dSchema.precio = 0;	
}

$(document).ready(function() {
	//mensaje de comfirmación antes de abandonar la página
	$(window).bind('beforeunload', function(){
	    if( modificado ){
	        return "¿Está seguro de que sea abandorar esta página y perder todos los cambios realizados?"
	    }
	});

	mostrar_alerta();

	
	//setea el datepicker
	$('.date-picker').datepicker();



	//valida el formulario de editar perfil
	$("#agregarProveedor").validate({
		rules: {
			proveedor: {
				required: true
				,minlength: 2
				,maxlength: 40
			},email:{
				required: true,
				email: true,
			}
		},messages: {
            email: {
                required: "*Escriba su correo electrónico",
                email: "*Escriba un correo electrónico válido",
            },proveedor: {
                required: "*Escriba un usuario",
                minlength: "*El usuario debe contener al menos 5 caracteres",
                maxlength: "*Porfavor no ingresar más de 20 caracteres"
            }
        },errorPlacement: function(error, element) {
            error.css('position', 'none');
		},highlight: function(element, errorClass) {
			var formGroup = $('.form-group').has(element);
			$(formGroup).addClass('has-error');
		},unhighlight: function(element, errorClass) {
			var formGroup = $('.form-group').has(element);
			$(formGroup).removeClass('has-error');
		},invalidHandler: function(form, validator){
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
				alert(errors);
			}
			validator.focusInvalid();
		},submitHandler: function(form){
			var email = $('#input-eproveedor').val();
			var proveedor = $('#input-proveedor').val();
			$.ajax({
			    type: "POST",
			    url: "<?php echo base_url(); ?>operacion/cotizaciones/existe_proveedor",
			    data: { 
			    	'email': email,
			    	'proveedor': proveedor
			    },success: function(data){
			    	var data = $.parseJSON(data);
			    	if(!data.status){
			        	// alert('no existe');
			    	}
			        else{
			        	var datamsg = $.parseJSON(data.msg);
			        	$('#input-proveedor').val(datamsg.proveedor);
			        }
					agregar_columna();
			    },error: function(XMLHttpRequest, textStatus, errorThrown){
			    	mostrar_alerta('msjError');
			    	$("body").scrollTop(0);
			    }
			});
		}
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
      return $window.width();
    },
    // height: function () {
    //   if (maxed && availableHeight === void 0) {
    //     calculateSize();
    //   }
    //   return maxed ? availableHeight : 200;
    // },
    currentRowClassName: 'currentRow',
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

});


//agrega una columna a la tabla
function agregar_columna(){
	var $proveedor = $('#input-proveedor').val();
	var repetido = false;
	$.each(proveedoresSelec, function(i, e){
		if(e['original_proveedor'] == $proveedor || e['proveedor'] == $proveedor){
			alert('Este proveedor ya existe');
			repetido = true;
		}
	});
	if(!repetido){
		$proveedor = $proveedor.replace(/[^a-z0-9\-]/ig,"");
		var $eproveedor = $('#input-eproveedor').val();
		if($proveedor != '' && $proveedor != 'item' && $proveedor != 'cantidad' && $proveedor != 'margen LP(%)' && $proveedor != 'precio al cliente'){
			var provData = [];
			provData['proveedor'] = $proveedor;
			provData['original_proveedor'] = $('#input-proveedor').val();
			provData['email'] = $eproveedor;
			provData['ciudad'] = $('#input-proveedor').attr('data-ciudad');
			provData['direccion'] = $('#input-proveedor').attr('data-direccion');
			provData['telefono'] = $('#input-proveedor').attr('data-telefono');
			proveedoresSelec.push(provData) ; 
			proveedores.push($proveedor);
			header.splice(header.length-2,0,'<input type="text" onclick="quitarSelect()" data-eproveedor="'+$eproveedor+'" onchange="cambiarHeader(this, '+(header.length-2)+')" value="'+$proveedor+'"  style="width: 75px;">');
			dSchema[$proveedor] = {costo: null};
			var htInstance = $ht.handsontable('getInstance');
			var cost = $proveedor+'.costo';
			columnDef.splice(header.length-3,0,{data: cost, type: {renderer: selectRender}}); 
			var currentData = htInstance.getData();
			for (var i = 0; i < htInstance.countRows()-1; i++) {
				currentData[i][$proveedor] = {costo: 0};
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

function bindDumpButton() {
	$('body').on('click', 'button[name=dump]', function () {
		var dump = $(this).data('dump');
		var $ht = $(dump);
		console.log('data of ' + dump, $ht.handsontable('getData'));
	});
}
bindDumpButton();

//selecciona un item para el proveedor
function seleccionar_item_proveedor(){
	var htInstance = $ht.handsontable('getInstance');
	var selected = htInstance.getSelected();
	var cell = htInstance.getCell(selected[0], selected[1]);
	var tieneClase = false;
	var data =  numeral().unformat($(cell).text());
	if($(cell).hasClass('seleccionado'))
		tieneClase = true;

	if(data.length ==0 || data === 0 || isNaN(parseFloat(data)) && !isFinite(data)){
		alert('Debes ingresar un valor mayor a 0');
	}else{
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
				var cantidad = parseFloat($(item).text());
			}else if(col < htInstance.countCols()-2){
				if($(item).hasClass('seleccionado') && itemVal != ''){
					id_proveedor = $(item).attr('data-id-proveedor');
					proveedor = $(header[col]);
					proveedor = proveedor.val();
					$(item).remove('a.atooltip');
					valorLP = parseFloat(numeral().unformat($(item).text()));
					if($(item).attr('data-iva'))
						ivaAttr = parseFloat($(item).attr('data-iva').replace('%', ''));  
				}
			}else if(col == htInstance.countCols()-2 && itemVal != ''){
				ganancia = parseFloat(numeral().unformat($(item).text()));
			}
		}
		if(valorLP>0 && cantidad>0 && !isNaN(parseFloat(ganancia)) && isFinite(ganancia)){
			costo = valorLP/(1+(ivaAttr/100));
			var ivaLP = costo*(ivaAttr/100);

			var valor_antes_iva = costo*cantidad*(1+(ganancia/100));
			var ivaCliente = valor_antes_iva*(ivaAttr/100);
			precio_cliente = valor_antes_iva + ivaCliente;

			var inputChkbox = $('<input>').attr('type', 'checkbox').val(id_proveedor);
			tr.append($('<td>').append(inputChkbox));
			tr.append($('<td>').text(itemVal));
			tr.append($('<td>').text(proveedor));
			tr.append($('<td>').text(cantidad));
			tr.append($('<td>').text(numeral(costo*cantidad).format('$0,0.00')));
			tr.append($('<td>').text(numeral(ivaLP*cantidad).format('$0,0.00')));
			tr.append($('<td>').text(numeral(valorLP*cantidad).format('$0,0.00')));
			tr.append('<td>'+numeral(precio_cliente-ivaCliente).format('$0,0.00') +'</td>');
			tr.append('<td>'+numeral(ivaCliente).format('$0,0.00') +'</td>');
			tr.append($('<td>').text(numeral(precio_cliente).format('$0,0.00')));
			tr.append($('<td>').text(numeral(valor_antes_iva-(costo*cantidad)).format('$0,0.00')));
			$('tbody', '#cotizacion').append(tr);
			TIvaCliente += ivaCliente;
			TBaseCliente += (precio_cliente-ivaCliente);
			TCosto += (costo*cantidad);
			TIVALP += (ivaLP*cantidad);
			TValorLP += (valorLP*cantidad);
			TPrecioCliente += precio_cliente;
			TGanancia += valor_antes_iva-(costo*cantidad);
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
	Handsontable.TextCell.renderer.apply(this, arguments);

	dar_mejor_cotizacion();
	//seleccinoa el item
	if(seleccionados[row] == col){
		$(td).addClass('seleccionado');
	}

	value = Math.abs(value);
	value = numeral(value).format('$0,0[.]00');
	td.innerHTML = value;

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
	Handsontable.TextCell.renderer.apply(this, arguments);
	var htInstance = $ht.handsontable('getInstance');
	var ganancia = htInstance.getDataAtCell(row, col-1);
	var selected = htInstance.getDataAtCell(row, seleccionados[row]);
	var cantidad = htInstance.getDataAtCell(row, 1);
	var inner = Math.abs(cantidad*selected*(1+(ganancia/100)));
	td.innerHTML = numeral(inner).format('$0,0[.]00'); 
	return td;
}

//le da formato a la cantidad y la probabilidad
function numberRender(instance, td, row, col, prop, value, cellProperties) {
	Handsontable.TextCell.renderer.apply(this, arguments);
	var inner = td.innerHTML;
	inner = Math.abs(inner);
	if(col != 1){
		inner = numeral(inner).format('0,0[.]00');
	}else
		inner = numeral(inner).format('0');
	td.innerHTML = inner;
	return td;
}


//cambia el nombre del proveedor
function cambiarHeader(elem, index){
	var htInstance = $ht.handsontable('getInstance');
	var currentData = htInstance.getData();
	var prov = $(elem).val();
	header[index] = '<input type="text" onclick="quitarSelect()" data-eproveedor="'+$(elem).attr('data-eproveedor')+'" onchange="cambiarHeader(this, '+(header.length-2)+')" value="'+prov+'"  style="width: 75px;">';
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
	modificado = false;
	$('#fs-btns').attr('disabled', 'disabled');
	$('#fs-btns').val('Cargando...');
	var data = {};
	var htInstance = $ht.handsontable('getInstance');
	for (var row = 0; row < htInstance.countRows()-1 ; row++) {
		var item = {};
		var proveedores = {};
		var elegido;
		for (var col = 0; col < htInstance.countCols()-1 ; col++) {
			if(col == 0){
				var itemTD = htInstance.getCell(row, col);
				item.item =  htInstance.getDataAtCell(row, col);
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
					ops.id_proveedor_cotizacion = $(tdProveedor).attr('data-id-proveedor');
				if($('a', tdProveedor))
					ops.nota = $('a', tdProveedor).attr('data-original-title');
				proveedores[$(header[col]).val()] = ops;
			}else if(col == htInstance.countCols()-2){
				item.margen = htInstance.getDataAtCell(row, col);
			}
		}
		item.proveedores = proveedores;
		if(item.item == '')
		item.item = ' ';
			data[row] = item;
	}
	// console.log('sin json',data);
	var data = $.toJSON( data );
	// console.log('con json', data);
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url(); ?>operacion/cotizaciones/guardar",
	    data: { 
	    'items': data,
	    'id_pipeline': '<?php echo $id_pipeline;?>',
	    'id_usuario': '<?php echo $id_usuario;?>'
	    },success: function(data){
	    	var data = $.parseJSON(data);
	    	if(data.status)
	        	window.location = '<?php echo base_url()."operacion/cotizaciones/mostrar_cotizaciones/".$id_pipeline."/".$id_usuario."/msjExito";?>';
	        else
	        	alert(data.msg);
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
	var mostrado = false;
	if(modificado){
		alert('Debes guardar primero');
	}else{
		mostrado = false;
		var modalCloneOriginal = $('#modal-orden-compra').clone();
		$.each(proveedoresSelec, function (i, object) {
			var modalClone = $(modalCloneOriginal).clone();
			$(modalClone).attr('id', 'modal-orden-compra'+i);
			$.each($('.modal-orden-compra:not(#modal-orden-compra)'), function (i2,e2){
				$(e2).modal('hide').remove();
			});
			var id_proveedor_cot = [];
			$.each($('#cotizacion tbody tr'), function (i1, object1) {
				var tds = $('td', object1);
				if($(tds[2]).text() == object['proveedor'] && $('input:checked',tds[0]).val()){
					id_proveedor_cot.push($('input:checked',tds[0]).val());
				}
			});
			if(id_proveedor_cot.length>0){ 
				id_proveedor_cot = $.toJSON( id_proveedor_cot );

				// var modalClone = $(modalCloneOriginal).clone();
				$('.form-orden-compra', modalClone).submit(function(e){
					e.preventDefault();
					generar_orden_compra(this);
				});
				$('.oc-id-proveedores-cot', modalClone).val(id_proveedor_cot);
				$('.oc-id-proveedor', modalClone).val(object['id_proveedor']);
				$('.oc-proveedor', modalClone).val(object['original_proveedor']);
				$('.oc-email', modalClone).val(object['email']);
				$('.oc-direccion', modalClone).val(object['direccion']);
				$('.oc-telefono', modalClone).val(object['telefono']);
				$('.oc-ciudad', modalClone).val(object['ciudad']);
				modalClone.modal('show');
				$('.date-picker', modalClone).datepicker();
				mostrado = true;
			}
	    });
	}
	if(!mostrado && !modificado){//si no se ha mostrado ningún modal, le muestra una alerta
		alert('Debes escoger un al menos un item para generar la orden de compra');
	}	
}

//envía la forma de orden de compra
function generar_orden_compra(elem){
	$('.submit-oc', elem).attr('disabled', 'disabled');
	$('.submit-oc', elem).val('Cargando...');
	var form =  $('#form-orden-compra');
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url(); ?>operacion/ordenCompra/generar_orden",
	    data: { 
    	'id_cotizacion': '<?php echo $cotizacion->id?>',
    	'id_proveedor': $('.oc-id-proveedor', elem).val(),
    	'modificado': $('.oc-id-proveedor', elem).attr('data-modificado'),
	    'id-proveedores-cot': $('.oc-id-proveedores-cot', elem).val(),
	    'proveedor': $('.oc-proveedor', elem).val(),
	    'email': $('.oc-email', elem).val(),
	    'ciudad': $('.oc-ciudad', elem).val(),
	    'direccion': $('.oc-direccion', elem).val(),
	    'telefono': $('.oc-telefono', elem).val(),
	    'enviar': $('.oc-enviar', elem).val(),
	    'observacion': $('.oc-observaciones', elem).val(),
	    'id_pipeline': '<?php echo $id_pipeline;?>',
	    'id_usuario': '<?php echo $id_usuario;?>'
	    },success: function(data){
	    	var data = $.parseJSON(data);
	    	console.log(data);
	    	if(data.status){
		    	var div = $('<div>').addClass('alert').addClass('alert-success');
		    	var btn = $('<button>').attr('type', 'button').addClass('close').attr('data-dismiss', 'alert').html('&times;');
		    	var a = $('<a>').attr('href','<?php echo base_url();?>'+'resources/ordenCompra/'+data.pdf).attr('target','_blank').text(data.pdf);
		    	div.append(btn);
		    	div.append('La orden de compra fue generáda. ');
		    	div.append(a);
		    	$('body').prepend(div);
		    	$(div).show();
		    	$('.modal-orden-compra').has(elem).modal('hide');
		    	agregar_a_ordenes_compra(data.id, data.pdf);
	    	}else if(!data.status && !isEmpty(data.dbsesion)){
	    		$('body').prepend('<div class="alert alert-danger" style="display: block;"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.dbsesion+' <a href="'+data.dburl+'" target="_blank">'+data.dburl+'</a></div>');
	    		$('.modal').modal('hide');
	    		$("body").scrollTop(0);
	    	}else{
	    		$('body').prepend(data.msg);
	    		$("body").scrollTop(0);
	    	}
	    },error: function(XMLHttpRequest, textStatus, errorThrown){
	    	mostrar_alerta('msjError');
	    	$('.modal-orden-compra').has(elem).modal('hide');
    		$('.submit-oc').removeAttr('disabled');
	    }
	});

}

//Anula la una orden de compra según el id de la orden
function anular(id, elem){
	var answer = confirm("¿Está seguro de que sea anular la orden de compra "+str_pad(id, 4, '0', 'STR_PAD_LEFT')+"?");
	$(elem).attr('disabled', 'disabled');
	$(elem).text('Anulando...');
	if (answer){
		$.ajax({
		    type: "POST",
		    url: "<?php echo base_url(); ?>operacion/ordenCompra/anular",
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
		        	$('a', td2).text(split[0]+'-anulado.pdf').attr('href', '<?php echo base_url()?>resources/ordenCompra/'+split[0]+'-anulado.pdf');
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

//agrega al table la orden de compra
function agregar_a_ordenes_compra(id, pdf){
	var tr = $('<tr>');
	var td1 = $('<td>').text(str_pad(id, 4, '0', 'STR_PAD_LEFT'));
	var a = $('<a>').attr('href', '<?php echo base_url()?>resources/ordenCompra/'+pdf).attr('target', '_blank').text(pdf);
	var td2 = $('<td>').append(a);
	var td3 =$('<td>');
	var button = $('<button>').addClass('btn').addClass('btn-link').attr('onclick', 'anular('+id+', this)').text('Anular'); 
	td3.append(button);
	tr.append(td1);
	tr.append(td2);
	tr.append(td3); 
	$('#tbl-ordenes-compra tbody').append(tr);
}

//marca a un proveedor que ha sido modificado
function proveedor_modificado(elem){
	var padre = $('.form-orden-compra').has(elem);
	$('.oc-id-proveedor',padre).attr('data-modificado', true);
}

//refresca la vista
function cancelar(){
	var answer = confirm("¿Desea perder todos los cambios realizados?")
	if (answer){
		window.location = '<?php echo base_url()."operacion/cotizaciones/mostrar_cotizaciones/".$id_pipeline."/".$id_usuario;?>';
	}
}

function isEmpty(str) {
    return (!str || 0 === str.length);
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

function str_pad (input, pad_length, pad_string, pad_type) {
  var half = '',
    pad_to_go;

  var str_pad_repeater = function (s, len) {
    var collect = '',
      i;

    while (collect.length < len) {
      collect += s;
    }
    collect = collect.substr(0, len);

    return collect;
  };

  input += '';
  pad_string = pad_string !== undefined ? pad_string : ' ';

  if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
    pad_type = 'STR_PAD_RIGHT';
  }
  if ((pad_to_go = pad_length - input.length) > 0) {
    if (pad_type === 'STR_PAD_LEFT') {
      input = str_pad_repeater(pad_string, pad_to_go) + input;
    } else if (pad_type === 'STR_PAD_RIGHT') {
      input = input + str_pad_repeater(pad_string, pad_to_go);
    } else if (pad_type === 'STR_PAD_BOTH') {
      half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
      input = half + input + half;
      input = input.substr(0, pad_length);
    }
  }

  return input;
}

</script>