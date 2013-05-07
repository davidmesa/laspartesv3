<link href="<?php echo base_url(); ?>resources/css/home.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>resources/js/jquery.easing.1.3.js"></script>
<script src="<?php echo base_url(); ?>resources/js/slides.min.jquery.js"></script>

<script type="text/javascript">
    $(function(){
        $('#slides').slides({
            preload: true,
            preloadImage: '<?php echo base_url(); ?>resources/images/home/loading.gif',
            play: 7000,
            pause: 3500,
            hoverPause: true
        });
    });
    
    preload([
        '<?php echo base_url();?>resources/images/home/noticias/baner-novedades-h.png',
        '<?php echo base_url();?>resources/images/home/noticias/baner-talleres-h.png',
        '<?php echo base_url();?>resources/images/home/noticias/baner-autopartes-h.png',
        '<?php echo base_url();?>resources/images/home/noticias/baner-ofertas-h.png'

    ]);
    
    $('#slider-div-novedades').hover(function () {
        this.src = '<?php echo base_url();?>resources/images/home/noticias/baner-novedades-h.png';
    }, function () {
        this.src = '<?php echo base_url();?>resources/images/home/noticias/baner-novedades.png';
    });
    
    $('#slider-div-talleres').hover(function () {
        this.src = '<?php echo base_url();?>resources/images/home/noticias/baner-talleres-h.png';
    }, function () {
        this.src = '<?php echo base_url();?>resources/images/home/noticias/baner-talleres.png';
    });
    
    $('#slider-div-autopartes').hover(function () {
        this.src = '<?php echo base_url();?>resources/images/home/noticias/baner-autopartes-h.png';
    }, function () {
        this.src = '<?php echo base_url();?>resources/images/home/noticias/baner-autopartes.png';
    });
    
    $('#slider-div-ofertas').hover(function () {
        this.src = '<?php echo base_url();?>resources/images/home/noticias/baner-ofertas-h.png';
    }, function () {
        this.src = '<?php echo base_url();?>resources/images/home/noticias/baner-ofertas.png';
    });
    
    
    
    
    
</script>


