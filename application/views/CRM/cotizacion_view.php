<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.10.1.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/numeral.min.js"></script>
  <link href="<?php echo base_url(); ?>resources/css/jquery.handsontable.full.css" rel="stylesheet" type="text/css" media="screen">
  <script src="<?php echo base_url(); ?>resources/js/jquery.handsontable.full.js" type="text/javascript"></script>
  <style>
  .handsontable .currentRow {
    background-color: #E7E8EF;
  }
  .handsontable .currentCol {
    background-color: #F9F9FB;
  }

  .handsontable .seleccionado.current  {
    border: 1px solid #ccc;
  }

  .handsontable td{
    position: relative;
  }
  .seleccionado{
    background-color: rgb(53, 170, 71) !important;
    color: white;
  }

  #cotizacion th, #cotizacion td{
    border: 1px solid #ccc;
  }

  #cotizacion td{
    text-align: center;
    padding: 5px;
  }

  </style>
</head>

<body>
	<input type="text" id="input-proveedor"> <input type="button" value="agregar proveedor" onclick="agregar_columna()"><br/><br/>
 <div id="example1"></div>

 <p>
   <button name="dump" data-dump="#example1" title="Prints current data source to Firebug/Chrome Dev Tools">Dump
     data to console
   </button>

   <button name="dump" onclick="dar_mejor_cotizacion()">dar mejor cotización</button>

   <button name="dump" onclick="motrar_cotizacion()">mostrar cotización</button>
 </p>

 <div id="cotizacion">
   <h3>Cotización</h3>
   <table id="cotizacion">
    <thead>
     <th>Item</th>
     <th>Proveedor</th>
     <th>Cantidad</th>
     <th>Iva</th>
     <th>Costo</th>
     <th>Valor</th>
     <th>Ganancia con iva</th> 
     <th>Ganancia sin iva</th> 
   </thead>
   <tbody>
   </tbody>
 </table>
</div>

<p>
   <button name="dump" onclick="cotizar()">Guardar</button>
</p>


 <script data-jsfiddle="example1">
 var $ht = $("#example1");  
 var proveedores = [];
 var header = new Array();
 header[0] = "Item";
 header[1] = "Cantidad";
 var columnDef = new Array();
 columnDef.push({data: 'item'});  
 columnDef.push({data: 'cantidad'});  
 var dSchema = {};
  // dSchema['item'] = null;

  dSchema.item = null;
  dSchema.cantidad = 1;

  $(document).ready(function() {

  numeral.language('es', {
      delimiters: {
          thousands: '.',
          decimal: ','
      },
      abbreviations: {
          thousand: 'k',
          million: 'm',
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


    $ht.handsontable({
     dataSchema: dSchema,
     startRows: 3,
     startCols: 1,
     minRows: 3,
     minCols: 1,
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
        }
      },items: {
      'iva': {
        name: "IVA", disabled: function () {
            //if first, second column, disable this option
            return ($ht.handsontable('getSelected')[1] === 0 || $ht.handsontable('getSelected')[1] === 1);
          }
        },'seleccionar':{name: "Seleccionar", disabled: function () {
	          //if first, second column, disable this option
	          return ($ht.handsontable('getSelected')[1] === 0 || $ht.handsontable('getSelected')[1] === 1);
	        }}
        }
      },afterCreateRow: function(e){
        var currentData = this.getData();
        for (var i = 0; i < proveedores.length; i++) {
          var probTemp = proveedores[i];
          currentData[e]['item'] = "";
          currentData[e]['cantidad'] = "";
          currentData[e][probTemp] = {costo: "", valor: ""};
        };
      },afterChange: function(c,s){
        dar_mejor_cotizacion();
        motrar_cotizacion();
      }
    });

  	//si se da click a una casilla se le muestra la cajita para 
  	$('#example1').on('click', '.current', function(){
  		// var div = $('<div>').addClass('dfghj');
  	});

  });

//agrega una columna a la tabla
function agregar_columna(){
	var $proveedor = $('#input-proveedor').val();
  proveedores.push($proveedor);
	header.push($proveedor+'(Valor)');
	header.push($proveedor+'(Costo)');
	dSchema[$proveedor] = {costo: null, valor: null};
	// console.log('schema: ',dSchema);
	var htInstance = $ht.handsontable('getInstance');
	var valo = $proveedor+'.valor';
	var cost = $proveedor+'.costo';
	columnDef.push({data: valo, type: 'numeric', allowInvalid: false, format: '$0,0'});
	columnDef.push({data: cost, type: 'numeric', allowInvalid: false, format: '$0,0'});
	// console.log('columnDef: ',columnDef);
	var currentData = htInstance.getData();
	for (var i = 0; i < htInstance.countRows(); i++) {
		currentData[i][$proveedor] = {costo: "", valor: ""};
	};
	// console.log('current1: ',currentData);
	htInstance.updateSettings({
		data: currentData,
    dataSchema: dSchema,
    colHeaders: header,
    columns: columnDef
  });
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
  //quita el estilo de la fila
  for (var i = htInstance.countCols() - 1; i >= 0; i--) {
      var td = htInstance.getCell(selected[0], i);
      $(td).removeClass('seleccionado');
  }
  var cell = htInstance.getCell(selected[0], selected[1]);
  if(!$(cell).hasClass('seleccionado')){
    $(cell).addClass('seleccionado');
    if(selected[1]%2 == 0){
       htInstance.selectCell(selected[0], selected[1]+1);
     }else{
       htInstance.selectCell(selected[0], selected[1]-1);
     }
    $('.current').addClass('seleccionado');
  }
  motrar_cotizacion();
}


//selecciona una casilla y la marca como seleccionada
var seleccionarCotizados = function (instance, td, row, col, prop, value, cellProperties) {
  Handsontable.TextCell.renderer.apply(this, arguments);
  $(td).addClass('seleccionado');
}

//Muestra la cotización hecha para el cliente
function dar_mejor_cotizacion(){
  var htInstance = $ht.handsontable('getInstance');
  var currentData = htInstance.getData();
  var proveedorSelect = [];
  for (var i = 0; i < htInstance.countRows(); i++) {
    var item = currentData[i]['item'];
    var ganancia = -1;
    
    var proveedorIndex;
    for (var j = 0; j < proveedores.length; j++) {
      proveedor = proveedores[j];
      var costo = currentData[i][proveedor]['costo'];
      var valor = currentData[i][proveedor]['valor'];
      if(costo != ""){
        if(valor == "")
          valor = costo*1.30;
        var ivaTEMP = 0.16;
        //dar la celda
        for (var col = 0; col < htInstance.countCols(); col++) {
          var cellMeta = htInstance.getCellMeta(i, col);
          var prop = cellMeta.prop;
          prop = prop.split(".");
          prov = prop[0];
          if(prov === proveedor){
            console.log('proveedor', 'prov1: '+prov, 'prov2: '+proveedor);
            var td =  htInstance.getCell(i, col);
            if($(td).attr('data-iva')){
              ivaTEMP = parseFloat($(td).attr('data-iva'));
              console.log('ivamejor', ivaTEMP);
            }
          }
        }

        var iva = (valor -(valor/(1+ivaTEMP)));
        var gananciaTEMP = valor - costo - iva;
        if(gananciaTEMP > ganancia){
          ganancia = gananciaTEMP;
          proveedorSelect[i] = proveedor;
        }
      }
    }//fin for
  }//fin for rows
  $ht.handsontable({
    cells: function (row, col, prop) {
      $este = this;
      $.each(proveedorSelect, function(i, value){
        if(row === i && (prop === (value+'.valor') ||  prop === (value+'.costo'))) {
            $este.renderer = seleccionarCotizados;
          }
      });
    }
  });//fin handsontable
}

//muestra un preview de la cotización
function motrar_cotizacion(){
  $('tbody', '#cotizacion').empty();
  var TIva = 0;
  var TCosto = 0;
  var TValor = 0;
  var TGananciIva = 0;
  var TGananciSinIva = 0;
  var htInstance = $ht.handsontable('getInstance');
  for (var row = 0; row < htInstance.countRows()-1 ; row++) {
    var tr = $('<tr>');
    var itemVal= 0;
    var cantidad = 0;
    var proveedor = 0;
    var valor = 0;
    var costo = 0;
    var ivaAttr = 0.16;
    for (var col = 0; col < htInstance.countCols(); col++) {
      var item =  htInstance.getCell(row, col);
      if(col == 0){
        var itemVal = item.innerHTML;
      }else if(col == 1){
        var cantidad = item.innerHTML;
      }else{
        if($(item).hasClass('seleccionado') && itemVal != ''){
          var cellMeta = htInstance.getCellMeta(row, col); //console.log('meta',cellMeta, item.innerHTML);
          var prop = cellMeta.prop;
          prop = prop.split(".");
          proveedor = prop[0];
          var costovalor = prop[1];
          if(costovalor == 'valor')
            valor = numeral().unformat(item.innerHTML);
          else{
            costo = numeral().unformat(item.innerHTML);
            if($(item).attr('data-iva')){
              ivaAttr = parseFloat($(item).attr('data-iva')); console.log('iva', 1+ivaAttr);
            }
              
          }
          
        }
      }
    }
      var iva = (valor -(valor/(1+ivaAttr)));
      tr.append($('<td>').text(itemVal));
      tr.append($('<td>').text(proveedor));
      tr.append($('<td>').text(cantidad));
      tr.append('<td>'+numeral(iva).format('$0,0.00') +'</td>');
      tr.append($('<td>').text(numeral(costo).format('$0,0')));
      tr.append($('<td>').text(numeral(valor).format('$0,0')));
      tr.append($('<td>').text(numeral(valor-costo).format('$0,0.00')));
      tr.append($('<td>').text(numeral(valor-costo-iva).format('$0,0.00')));
      $('tbody', '#cotizacion').append(tr);
      TIva += (iva*cantidad);
      TCosto += (costo*cantidad);
      TValor += (valor*cantidad);
      TGananciIva += ((valor-costo)*cantidad);
      TGananciSinIva += ((valor-costo-iva)*cantidad);
  }
  var tr = $('<tr>');
  tr.append($('<td>').html('<strong>Total: </strong>').attr('colspan', '3').attr('align', 'right'));
  tr.append('<td>'+numeral(TIva).format('$0,0.00') +'</td>');
  tr.append($('<td>').text(numeral(TCosto).format('$0,0')));
  tr.append($('<td>').text(numeral(TValor).format('$0,0')));
  tr.append($('<td>').text(numeral(TGananciIva).format('$0,0.00')));
  tr.append($('<td>').text(numeral(TGananciSinIva).format('$0,0.00')));
  $('tbody', '#cotizacion').append(tr);
}

//cambia el iva de un item para un proveedor
function cambiar_iva(){
  var htInstance = $ht.handsontable('getInstance');
  var selected = htInstance.getSelected();
  var td = htInstance.getCell(selected[0], selected[1]);
  var ivaTemp = 0.16;
  if($(td).attr('data-iva'))
    ivaTemp = parseFloat($(td).attr('data-iva'));
  var iva = prompt("Ingresa el IVA(escala de 0 a 1): ", ivaTemp);
  
  if(iva != null){
    $(td).attr('data-iva', iva);
    if(selected[1]%2 == 0){
       htInstance.selectCell(selected[0], selected[1]+1);
     }else{
       htInstance.selectCell(selected[0], selected[1]-1);
     }
     $('.current').attr('data-iva', iva);
     
  }
}
</script>

</body>
</html>