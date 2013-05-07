<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="240" rowspan="3" class="banner_logo"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>resources/images/template/logos/laspartesGrande.png" alt="Logo Laspartes.com" width="160" height="97" /></a></td>
                <td height="40" colspan="2" class="general_link banner_links_superiores" align="left"><h4> 
                        <?php $sesion = $this->session->userdata('esta_registrado');?>
                        <?php if($sesion){;?>
                            <a href="<?php echo base_url(); ?>usuario/mi_cuenta">Mis Veh&iacute;culos</a>
                            - <a href="<?php echo base_url(); ?>usuario/cerrar_sesion">Cerrar Sesión</a>
                        <?php } else { ?>
                            <a href="<?php echo base_url(); ?>usuario/registrar_usuario">Regístrate</a>
                        <?php } ?>    
                        - <a href="<?php echo base_url(); ?>acerca/quienes_somos">¿Quiénes somos?</a>
                        - <a href="<?php echo base_url(); ?>acerca/contactenos">Cont&aacute;ctenos</a>
                    </h4></td>

                <td width="110" rowspan="3" class="banner_lema" >
                	<img src="<?php echo base_url(); ?>resources/images/template/header/imgSlogan.jpg" width="94" height="96" alt="Todo para su vehículo" />
<?php 
if(!$this->session->userdata('esta_registrado')){
	$show_login = true;
}
if(isset($show_login) && $show_login != false): 
	$config = array('id' => 'formulario_ingresar_usuario');
	echo form_open(base_url().'usuario/validar_usuario', $config);
?>
				<div style="position: relative;">
                	<table class="login_float" border="0" cellspacing="0" cellpadding="0">
                		<tbody>
                			<tr>
                				<td width="90" align="right" style="padding-bottom:5px;padding-top:10px;">
                					<h3>E-mail:</h3>
                				</td>
                				<td align="right" style="padding-bottom:5px;padding-right:10px;padding-top:10px;">
                					<input class="general_cuadro_texto" type="text" name="email" id="txt_email" size="25">
                				</td>
							</tr>
							<tr>
								<td align="right" style="padding-bottom:10px;">
									<h3>Contraseña:</h3>
								</td>
								<td align="right" style="padding-bottom:10px;padding-right:10px;"><input class="general_cuadro_texto" type="password" name="contrasena" id="txt_password" size="25"></td>
							</tr>
							<tr>
								<td valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"></td>
								<td rowspan="2" align="right" valign="top" style="padding-top:5px;padding-bottom:5px;padding-right:10px;">
									<input name="btn_iniciar_sesion" type="submit" class="general_boton_secundario" id="btn_login" value="Iniciar sesión"></td>
							</tr>
							<tr>
								<td colspan="2" class="general_link" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;">
									<h3>
										<a href="<?php echo base_url().'usuario/formulario_olvido_contrasena';?>">Olvidé mi contraseña</a>
									</h3>
								</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
<?php 
	echo form_close();
endif; ?>
                	</td>
                <td width="295" rowspan="3" class="banner_fondo" >&nbsp;</td>
            </tr>
            <tr>
                <td width="100" height="40" class="banner_twitter_facebook">&nbsp;</td>
                <td width="225" ></td>
            </tr>
            <tr>
                <td height="40" align="right" valign="top"><span style="line-height: 10px;" class="banner_twitter_facebook">Encuéntrenos en:</span></td>
                <td height="40" align="left" valign="top" style="padding-left: 10px;">
                    <a style="float: left" target="_blank" href="http://www.twitter.com/laspartes" >
                        <img src="http://twitter-badges.s3.amazonaws.com/twitter-a.png" alt="Sigue a Laspartes.com en Twitter"/>
                    </a>
                    <a style="float: left; padding-left: 10px;" target="_blank" href="http://www.facebook.com/laspartes" >
                        <img src="<?php echo base_url(); ?>resources/images/template/header/facebook_logo.jpg" alt="Sigue a Laspartes.com en Facebook"/>
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>