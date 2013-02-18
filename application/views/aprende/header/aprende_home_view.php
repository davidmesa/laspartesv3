<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />

<script>
    $(document).ready(function() {
        //imprime 5 preguntas, respuestas o talleres nuevos según sea el caso
        var ver_mas_noticias = 3;
        var ver_mas_tips = 5;
        $('.div-ver-mas').click(function(){
            var este = $(this);
            var span = $('span', this);
            if(span.hasClass('noticia-ver-mas') ){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>aprende/mostrar_mas_noticias_ajax",
                    async: false,
                    data: "offset=" + ver_mas_noticias,
                    success: function(data){
                        ver_mas_noticias += 3;
                        $('#novedades-div-noticia-content').append(data);
                        if(ver_mas_noticias >= parseInt(<?php echo $numNoticias; ?>) ){
                            este.css('display', 'none');
                        }
                    }
                }); 
                    
            }else if(span.hasClass('tips-ver-mas') ){
            
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>aprende/mostrar_mas_tips_ajax",
                    async: false,
                    data: "offset=" + ver_mas_tips ,
                    success: function(data){
                        ver_mas_tips += 5;
                        if(parseInt(ver_mas_tips) >= parseInt(<?php echo $numTips; ?>) ){
                            este.css('display', 'none');
                        }
                        $('#novedades-div-tips-content').append(data);
                    }
                }); 
                
            }
        });
        
        
        //esconde el span de ver más para los casos de que el offset sea mayor
        //al número de preguntas, respuestas o talleres
        if(parseInt(ver_mas_noticias) >= parseInt(<?php echo $numNoticias; ?>) ){
            $('.usuario-div-respuestas-vermas').css('display', 'none');
        }
        if(ver_mas_tips >= parseInt(<?php echo $numTips; ?>) ){
            $('.usuario-div-preguntas-vermas').css('display', 'none');
        }
        
    });
</script>