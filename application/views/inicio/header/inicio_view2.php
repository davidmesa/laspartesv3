
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/jquery.wt-rotator.css"/>

<script src="<?php echo base_url(); ?>resources/js/jquery.easing.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.wt-rotator.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".container-rotator").wtRotator({
                width:928,
                height:250,
                button_width:24,
                button_height:24,
                button_margin:5,
                auto_start:true,
                delay:8000,
                play_once:false,
                transition:"fade",
                transition_speed:5000,
                auto_center:true,
                easing:"",
                cpanel_position:"inside",
                cpanel_align:"BL",
                timer_align:"top",
                display_thumbs:true,
                display_dbuttons:false,
                display_playbutton:true,
                display_numbers:true,
                display_timer:false,
                mouseover_pause:false,
                cpanel_mouseover:false,
                text_mouseover:false,
                text_effect:"fade",
                text_sync:false,
                tooltip_type:"image",
                lock_tooltip:true,
                shuffle:false,
                block_size:75,
                vert_size:55,
                horz_size:50,
                block_delay:25,
                vstripe_delay:75,
                hstripe_delay:180
        });
    });
</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>