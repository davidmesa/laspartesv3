$(document).ready(function(){

    var fecha = $("#Range").val();
    var parsedDate = $.datepicker.parseDate('yy-mm-dd', fecha);
    $("#fromCalendar").datepicker({ appendText: "(yyyy-mm-dd)", altField: "#Range", altFormat: 'yy-mm-dd', rangeSelect: false });
     $("#fromCalendar").datepicker("setDate", parsedDate );
    
});