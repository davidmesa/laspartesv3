<div id="home-div-content">
    <div id="home-div-home">
        <div id="home-div-home-foto-slide">
            <div id="shadow-div">
                <div id="example">
                    <div id="slides">
                        <div class="slides_container">
                            <a class="slides_container_a" href="<?php echo base_url();?>ayuda" title="Consigue lo que necesitas"><img src="<?php echo base_url(); ?>resources/images/home/noticias/baner3.png" width="980" height="365" alt="nosotros conseguimos lo que necesitas"></a>
                            <a class="slides_container_a" href="<?php echo base_url();?>registro" title="Registra tu vehículo"><img src="<?php echo base_url(); ?>resources/images/home/noticias/baner2.png" width="980" height="365" alt="imagen de registro de tu vehículo"></a>
                            <div title="" id="noticia-baner-todo-vehiculo"> 
                                <div id="noticia-baner-encuentra-titulo">Encuentra</div>
                                <div id="noticia-baner-encuentra-todo">TODO PARA TU VEHÍCULO! <span>en un solo lugar:</span></div>
                                <div id="noticia-baner-encuentra-iconos">
                                    <a style="margin-right: 20px;" class="noticia-baner-encuentra-icono-a" href="<?php echo base_url(); ?>talleres">
                                        <img id="slider-div-talleres" src="<?php echo base_url(); ?>resources/images/home/noticias/baner-talleres.png" alt="autopartes"/>
                                        <div class="noticia-baner-encuentra-iconos-titulo">TALLERES</div>
                                    </a>
                                    <a style="margin-right: 20px;" class="noticia-baner-encuentra-icono-a" href="<?php echo base_url(); ?>autopartes"> 
                                        <img id="slider-div-autopartes" src="<?php echo base_url(); ?>resources/images/home/noticias/baner-autopartes.png" alt="talleres"/>
                                        <div class="noticia-baner-encuentra-iconos-titulo">AUTOPARTES</div>
                                    </a>
                                    <a style="margin-right: 20px;" class="noticia-baner-encuentra-icono-a" href="<?php echo base_url(); ?>preguntas">
                                        <img id="slider-div-novedades" src="<?php echo base_url(); ?>resources/images/home/noticias/baner-novedades.png" alt="preguntas"/>
                                        <div class="noticia-baner-encuentra-iconos-titulo">PREGUNTAS</div>
                                    </a>
                                    <a class="noticia-baner-encuentra-icono-a" href="<?php echo base_url(); ?>promociones">
                                        <img id="slider-div-ofertas" src="<?php echo base_url(); ?>resources/images/home/noticias/baner-ofertas.png" alt="ofertas"/>
                                        <div class="noticia-baner-encuentra-iconos-titulo">OFERTAS</div>
                                    </a>
                                    <div class="clear"></div>
                                </div>
                                <div id="noticia-baner-encuentra-registrate"><a href="<?php echo base_url();?>registro">REGISTRATE AHORA</a></div>
                            </div>
                            <a class="slides_container_a" href="<?php echo base_url();?>acerca/contactenos_taller" title="Registra tu taller"><img src="<?php echo base_url(); ?>resources/images/home/noticias/baner1.png" width="980" height="365" alt="imagen de registro de talleres"></a>x
                        </div>

                        <a href="#" class="prev"><img src="<?php echo base_url(); ?>resources/images/home/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
                        <a href="#" class="next"><img src="<?php echo base_url(); ?>resources/images/home/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>

                    </div>

                </div>
            </div>
        </div>

        <div id="home-div-home-informacion">
            <div  id="home-div-home-destacados">
                <div>
                    <a href="<?php echo base_url();?>talleres">
                        <div id="home-div-home-destacados-icono">
                            <img src="<?php echo base_url(); ?>resources/images/home/pinones.png" alt="piñones"/>
                        </div>
                    </a>
                    <div class="home-div-home-destacados-titulo">
                        <a href="<?php echo base_url();?>talleres"><div><h1><span>TALLERES</span> <span style="color: #c60200;">RECOMENDADOS</span></h1></div></a>
                        <div id="home-div-home-destacados-subtitulo">
                            <h2>LOS MEJORES TALLERES<br/>
                                A TU SERVICIO!</h2>
                        </div>
                    </div>                       
                    <div class="clear"></div>
                </div>
                <div class="home-div-home-destacados-separador-titulo"></div>
                
                <?php foreach ($establecimientos as $establecimiento): ?>
                <div class="home-div-home-talleres">
                    <div class="home-div-home-talleres-imagen"> 
                        <a href="<?php  echo base_url()."talleres/".$establecimiento->idestablecimiento."-".  str_replace(" ", "-",$establecimiento->nombre); ?>"><img width="100px" src="<?php echo base_url().$establecimiento->logo_url;?>" alt="imagen-taller" /></a>
                    </div>
                    <div class="home-div-home-talleres-informacion">
                        <h3><a href="<?php  echo base_url()."talleres/".$establecimiento->idestablecimiento."-".  str_replace(" ", "-",$establecimiento->nombre); ?>"><?php echo $establecimiento->nombre; ?></a></h3>
                        <p><?php echo character_limiter($establecimiento->descripcion, 100); ?><br/>
                            <span><a href="http://<?php echo $establecimiento->web; ?>" target="_blank"><?php echo $establecimiento->web; ?></a></span>
                        </p>
                        <div class="home-div-home-talleres-direccion"><?php echo $establecimiento->ciudad.', '.$establecimiento->zona; ?></div><!--
                        <div class="home-div-home-talleres-telefono"><strong>Tel:</strong><?php echo $establecimiento->telefonos; ?></div>--> 
                        <div class="home-div-home-talleres-calificacion font-universe">
                            <span class="home-span-home-talleres-calificacion">CALIFICACIÓN USUARIOS <img src="<?php echo base_url(); ?>resources/images/home/mayor-que.png" alt="mayor que" /><img src="<?php echo base_url(); ?>resources/images/home/mayor-que.png" alt="mayor que" /></span>
                            <span class="font-universe home-span-home-calificacion"><?php echo (round($establecimiento->promedio)*100)/5 ; ?>%
                            </span> 
                            <div class="home-div-home-talleres-porcentaje estrellas-sin-clasificar">
                                <div class="home-div-home-talleres-porcentaje-completo estrellas-clasificadas"><span><?php echo round($establecimiento->promedio)*20;?>%</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="home-div-home-destacados-separador-establecimiento">
                        <img src="<?php echo base_url(); ?>resources/images/home/separador-establecimiento.png" alt="separador-noticia" />
                    </div>
                    <div class="clear"></div>
                </div>

                <?php endforeach; ?>

               

                <div id="home-div-home-destacados-ver-talleres"><a href="<?php  echo base_url()."talleres"?>">VER OTROS TALLERES</a>&nbsp;&nbsp;<img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que rojo" /><img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que rojo" /></div>
            </div>

            <div  id="home-div-home-tallerenlinea">

                <div>
                    <a href="<?php echo base_url();?>preguntas">
                    <div id="home-div-home-destacados-icono">
                        <img  src="<?php echo base_url(); ?>resources/images/home/preguntas.png" alt="preguntas"/>
                    </div>  
                    </a>    
                    <div class="home-div-home-destacados-titulo">
                         <a href="<?php echo base_url();?>preguntas"><div><h1><span>PREGÚNTALE</span><span style="color: #c60200;"> A LOS TALLERES</span></h1></h1></div></a>
                        <div id="home-div-home-destacados-subtitulo">
                            <h2>OBTÉN LA RESPUESTA<br/>
                                DE MECÁNICOS EXPERTOS!</h2>
                        </div>
                    </div>                       
                    <div class="clear"></div>
                    
                </div>
                <div class="home-div-home-destacados-separador-titulo"></div>

                <?php foreach ($preguntas as $pregunta): ?>
                    <div class="home-div-home-talleres">
                        <div class="home-div-home-tallerlinea-imagen">
                            <img width="10px" src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo-pregunta.png" alt="mayor que rojo" />
                        </div>
                        <div class="home-div-home-tallerlinea-pregunta">
                            <h3><a href="<?php echo base_url()."preguntas/".$pregunta->id_pregunta."-". preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'),$pregunta->titulo_pregunta) ;?>"><?php echo character_limiter($pregunta->titulo_pregunta, 50); ?></a></h3>
                            <div class="home-div-home-tallerlinea-pregunta-txt"><span><?php echo character_limiter($pregunta->cuerpo_pregunta, 50); ?></span></div>
                            <div class="home-div-home-tallerlinea-pregunta-autor"><span>Por: <?php echo $pregunta->nombres . " " . $pregunta->apellidos; ?></span></div>
                            <div class="home-div-home-tallerlinea-pregunta-fecha"><span><?php echo strftime("%d de %B de %Y", strtotime($pregunta->fecha)); ?></span></div>
                        </div>
                        <div class="clear"></div>
                    </div>

                <?php endforeach; ?>

                <div id="home-div-home-destacados-ver-preguntas"><div id="home-div-home-quiero-preguntar" class="open-sans"><a href="<?php echo base_url()."preguntas"?>">PREGUNTAR</a></div>   <a href="<?php echo base_url()."preguntas"; ?>">VER MÁS PREGUNTAS</a>&nbsp;&nbsp;<img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que rojo" /><img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que rojo" /></div>

            </div>
            <div id="home-div-home-twitter">
                <div>
                    <div id="home-div-home-destacados-icono">
                        <img  src="<?php echo base_url(); ?>resources/images/home/twitter.png" alt="icono twitter"/>
                    </div>                        
                    <div class="home-div-home-destacados-titulo">
                        <div><h1><span>TWITTER</span></h1></div>
                        
                    </div>                       
                    <div class="clear"></div>
                    <div id="home-div-home-destacados-subtitulo">
                        <h2>ENCUÉNTRANOS EN REDES SOCIALES</h2>
                    </div>
                </div>
                <div class="home-div-home-destacados-separador-titulo"></div>
                <div class="home-div-home-twitter-tweet open-sans">
                   <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
                    <script>
                    new TWTR.Widget({
                    version: 2,
                    type: 'profile',
                    rpp: 3,
                    interval: 30000,
                    width: 200,
                    height: 300,
                    theme: {
                        shell: {
                        background: 'transparent',
                        color: '#ffffff'
                        },
                        tweets: {
                        background: 'transparent',
                        color: '#404040',
                        links: '#C60200'
                        }
                    },
                    features: {
                        scrollbar: false,
                        loop: false,
                        live: false,
                        behavior: 'all'
                    }
                    }).render().setUser('laspartes').start();
                    </script>
                </div>
                <div class="home-div-home-twitter-separador"></div>
                <div class="home-div-home-twitter-laspartes open-sans">
                    @laspartes <img  src="<?php echo base_url(); ?>resources/images/home/twitter-small.png" alt="icono twitter" />
                </div>
                <div id="home-div-home-publicidad-titulo" class="font-universe">
                    <div>PUBLICIDAD</div>
                </div>
                <div class="home-div-home-publicidad-imagen">
                    <img src="<?php echo base_url(); ?>resources/images/home/imagen-publicidad.png" alt="imagen publicidad" />
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div id="home-div-home-degrade"></div>
    </div>
</div>