<link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />

<script src="<?php echo base_url(); ?>resources/js/jquery.ui.core.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.button.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.position.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>

<style>
.ui-autocomplete-input
{
    margin: 0; padding: 0.48em 0 0.47em 0.45em;
    width: 170px;
    max-height: 30px;
}
.ui-menu .ui-menu-item a{
    font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
    font-size:13px;
    font-style:normal;
    font-weight:normal;
    padding:2px;
    margin:0;
}
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
    /* add padding to account for vertical scrollbar */
    padding-right: 20px;
}
/* IE 6 doesn't support max-height
 * we use height instead, but this forces the menu to always be this tall
 */
* html .ui-autocomplete {
    height: 200px;
}
</style>
<script type="text/javascript">
    (function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
                                                        if(ui.item.option.parentElement.id == 'combobox-marcas') {
                                                            window.location = '<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/<?php echo $orden; ?>/'+ui.item.option.value+'/todas-las-lineas/<?php echo $limit; ?>/0';
                                                        }
                                                        else {
                                                            window.location = '<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/<?php echo $orden; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/'+ui.item.option.value+'/<?php echo $limit; ?>/0';
                                                        }
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									input.data( "autocomplete" ).term = "";
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				this.button = $( "<button type='button'>&nbsp;</button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );

	$(function() {
            $( "#combobox-marcas" ).combobox();
            $( "#combobox-lineas" ).combobox();
	});
</script>