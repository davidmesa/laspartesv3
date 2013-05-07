<tr>
    <td>
        <table width="970" height="35" border="0" cellspacing="0" cellpadding="0" >
            <tr class="borde_inferior">
                <td width="150">&nbsp;</td>
                <?php if($navegacion_view == 'inicio') { ?>
                <td width="90" class="navegacion_barra_selected"><h1><a href="<?php echo base_url(); ?>">Inicio</a></h1></td>
                <?php } else { ?>
                    <td width="90" class="navegacion_barra"><h1><a href="<?php echo base_url(); ?>">Inicio</a></h1></td>
                <?php } ?>
                <td width="2" class="navegacion_barra">|</td>
                <?php if($navegacion_view == 'micuenta') { ?>
                    <td width="120" class="navegacion_barra_selected"><h1><a href="<?php echo base_url(); ?>usuario">Mis Veh&iacute;culos</a></h1></td>
                <?php } else { ?>
                    <td width="120" class="navegacion_barra"><h1><a href="<?php echo base_url(); ?>usuario">Mis Veh&iacute;culos</a></h1></td>
                <?php } ?>
                <td width="2" class="navegacion_barra">|</td>
                <?php if($navegacion_view == 'autopartes') { ?>
                    <td width="110" class="navegacion_barra_selected"><h1><a href="<?php echo base_url(); ?>autopartes">Autopartes</a></h1></td>
                <?php } else { ?>
                    <td width="110" class="navegacion_barra"><h1><a href="<?php echo base_url(); ?>autopartes">Autopartes</a></h1></td>
                <?php } ?>
                <td width="2" class="navegacion_barra">|</td>
                <?php if($navegacion_view == 'establecimientos') { ?>
                    <td width="140" class="navegacion_barra_selected"><h1><a href="<?php echo base_url(); ?>establecimientos">Establecimientos</a></h1></td>
                <?php } else { ?>
                    <td width="140" class="navegacion_barra"><h1><a href="<?php echo base_url(); ?>establecimientos">Establecimientos</a></h1></td>
                <?php } ?>
                <td width="2" class="navegacion_barra">|</td>
                <?php if($navegacion_view == 'tallerenlinea') { ?>
                    <td width="120" class="navegacion_barra_selected"><h1><a href="<?php echo base_url(); ?>taller_en_linea">Taller en línea</a></h1></td>
                <?php } else { ?>
                    <td width="120" class="navegacion_barra"><h1><a href="<?php echo base_url(); ?>taller_en_linea">Taller en línea</a></h1></td>
                <?php } ?>
                <td width="2" class="navegacion_barra">|</td>
                <?php if($navegacion_view == 'aprende') { ?>
                    <td width="102" class="navegacion_barra_selected"><h1><a href="<?php echo base_url(); ?>aprende">Aprende</a></h1></td>
                <?php } else { ?>
                    <td width="102" class="navegacion_barra"><h1><a href="<?php echo base_url(); ?>aprende">Aprende</a></h1></td>
                <?php } ?>
                <td width="150">&nbsp;</td>
            </tr>
        </table>
    </td>
</tr>