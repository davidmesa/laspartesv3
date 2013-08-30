<link href="<?php echo base_url(); ?>resources/css/jquery.handsontable.full.css" rel="stylesheet" type="text/css" media="screen">
<link href="<?php echo base_url(); ?>resources/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">
<link href="<?php echo base_url(); ?>resources/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" media="screen">
<link href="<?php echo base_url(); ?>resources/css/datepicker.css" rel="stylesheet" type="text/css" media="screen">
<link href="<?php echo base_url(); ?>resources/css/halflings.css" rel="stylesheet" type="text/css" media="screen">

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
  overflow: visible;
}
.seleccionado{
  background-color: rgb(53, 170, 71) !important;
  color: white;
}

#header-ops{
  margin-bottom: 5px;
}

#cotizacion{
  border: 1px solid #ddd;
  border-collapse: separate;
  border-left: 0;
}

#cotizacion th, #cotizacion td{
  border: 1px solid #ccc;
  padding: 4px 5px;
}

#cotizacion td{
  text-align: center;
  padding: 5px;
}

.sugerido{
  border: 2px solid rgb(53, 170, 71) !important;
}

/*.handsontable table{
  table-layout: auto;
}*/

.proveedor.form-inline input[type="text"]{
  width: 160px;
}

#ordenCompra{
  margin-right: 20px;
}

.atooltip{
  position: absolute;
  top: 0px;
  right: 0px;
  width: 0;
  border-left: 15px solid transparent;
  border-right: 0px solid transparent;
  border-top: 15px solid orange;
}

.handsontable .tooltip{
  position: fixed;
}

.handsontable .htNumeric {
  text-align: left;
}

.alert{
  display: none;
}

.bs-callout-info {
  background-color: #f0f7fd;
  border-color: #d0e3f0;
}

.bs-callout {
  margin: 20px 0;
  padding: 10px 30px 10px 15px;
  border-left: 5px solid #eee;
}

.dropdown-menu{
  z-index: 1050;
}

#ordenes-compra button{
  padding: 0;
}

#cancelar{
  margin-right: 5px;
}

#actualizar{
  margin-right: 5px;
}
/*
.alert-success a{
  cursor: pointer;
}*/

</style>