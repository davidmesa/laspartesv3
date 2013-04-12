<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: usuarios :: Lista de Usuarios</title>

        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/styles.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/facebox.css" />

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery1.4.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/scripts.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/facebox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.flot.pack.js"></script>
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery-ui.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/scripts.js"></script>
        <script src=http://cdn.pubnub.com/pubnub-3.1.min.js></script>
        <script src=http://pubnub.s3.amazonaws.com/socket.io.min.js></script>
        <!--[if IE]>
            <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/excanvas.pack.js"></script>
        <![endif]-->

        <!--[if IE 6]>
            <script src="<?php echo base_url(); ?>resources/admin/js/pngfix.js"></script>
            <script>
                DD_belatedPNG.fix('.png_bg');
            </script>
        <![endif]-->
    </head>

    <body>
        <?php include_once './resources/admin/templates/header_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Chat</h2>
                <button onclick="pedirPermisosNotificacion();">Permitir notificaciones</button> *solo sirve para google chrome

                <div id="div-chat-wrapper">
                    <div id="div-chat-users">
                        <h4>Usuarios</h4>
                        <div id="div-chat-users-list">
                            <?php foreach($usuarios as $usuario):?>
                                <div id="div-usuario-chat-<?php echo $usuario->id_chat;?>" class="div-usuario-chat">
                                    <input type="hidden" class="input-chat-usuario" value="<?php echo $usuario->usuario;?>"/>
                                    <input type="hidden" class="input-chat-id-usuario" value="<?php echo $usuario->id_usuario;?>"/>
                                    <input type="hidden" class="input-chat-id-chat" value="<?php echo $usuario->id_chat;?>"/>
                                    <span id="span-usuario-chat-<?php echo $usuario->id_usuario?>" class="span-usuario-chat"><?php echo $usuario->nombres;?></span>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div id="div-chat-content-box">
                        <div id="div-chat-box-usuario"></div>
                        <div id="div-chat-content">
                            <?php foreach($usuarios as $usuario):?>
                                <div id="div-chat-content-text-<?php echo $usuario->id_chat;?>" class="div-chat-content-text">
                                    <?php foreach ($usuario->chats as $chat){ ?>
                                        <div class="chat-msj"><strong class="username-chat"><?php if($chat->tipo == 10) echo 'Taller en línea'; else echo $chat->nombres;?>: </strong><?php echo $chat->comentario; ?></div>
                                    <?php }?>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <div id="div-chat-text-write">
                            <form id="chat-form">
                                <input type="text" id="chat-message-text"/>
                                <input type="submit" value="enviar" class="submit" onclick="mandarMsj();"/>
                            </form>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
        <script>
            var nombre = 'Taller en línea';
            var nombreUsuario = '';
            var usuario = '';
            var socket;
            var id_chat;
            var sockets = new Array();
            var focusFlag;
            var id_usuarios_conectados = [];
            
            
            // PUBNUB SETUP
            // -----------------------------------------------------------------------
            var box = PUBNUB.$('div-chat-content-text'), input = PUBNUB.$('chat-message-text'), channel = 'laspartes';
            var pubnub_setup = {
                    channel       : channel,
                    publish_key   : 'pub-c-82907999-cf60-4c3e-818b-349077678be3',
                    subscribe_key : 'sub-c-078086c0-8d79-11e2-9ebd-12313f022c90'
            };
            
            
            
            $(document).ready(function() {
                jQuery(window).bind("focus",function(event){
                    focusFlag = 1;
                }).bind("blur", function(event){
                    focusFlag = 0;
                });
               conectarChats();
               
               setInterval(function() {
                   $.ajax({
                    url: "http://www.laspartes.com/admin/mobile/dar_nuevos_chats",
                    type: "POST",
                    onsubmit: false,
                    data:{
                        id_usuarios:id_usuarios_conectados
                    },success: function(data){
                        data = JSON.parse(data); 
                        if(data.status){
                          $.each(data.ids, function(i, e){
                              var encontro = false;
                              $.each(id_usuarios_conectados, function(ind, elem){
                                  if(elem==e.id_usuario){
                                      encontro = true;
                                      return false;
                                  }
                              });
                                if(encontro == false){
                                    cargarUsuariosNuevos(e.id_chat, e.usuario, e.id_usuario, e.nombres);
                                    id_usuarios_conectados.push(e.id_usuario);
                                    conectarChat(e.id_chat, e.usuario, e.id_usuario);
                                    displayNotification('Te ha escrito', e.nombres);
                                } 
                                cargarChatNuevo(e.id_chat, e.comentario, e.tipo, e.nombres);
                                playSound();
                            });
                        }
                    }
                });
              }, 10000);
               
               $('form#chat-form').submit(function(){return false;});
               
               $('.div-usuario-chat').live('click',function(){
                    $('.div-usuario-chat.active').removeClass('active');
                    $(this).addClass('active');
                    usuario = $('.input-chat-usuario', this).val();
                    id_usuario = $('.input-chat-id-usuario', this).val();
                    nombreUsuario = $('.span-usuario-chat', this).text();
                    id_chat = $('.input-chat-id-chat', this).val();
                    prepararChat();
                    //conectarChat();
                }); 
            });
            
            //carga los chats nuevos
            function cargarChatNuevo(id_chat, comentario, tipo, nombres){
                var chatMsj = $('<div>').attr('class', 'chat-msj');
                if(tipo == 10)
                    var strong = $('<strong>').attr('class', 'username-chat').text('Taller en línea: ');
                else
                    var strong = $('<strong>').attr('class', 'username-chat').text(nombres+': ');
                chatMsj.append(strong);
                chatMsj.append(comentario);
                $('#div-chat-content-text-'+id_chat).append(chatMsj);
                
            }
            //carga los nuevos usuarios en div-chat-users-list
            function cargarUsuariosNuevos(id_chat, usuario, id_usuario, nombres){
                var usuarioChat = $('<div>').attr('id', 'div-usuario-chat-'+id_chat).attr('class', 'div-usuario-chat');
                var inputUsuario = $('<input>').attr('type', 'hidden').attr('class', 'input-chat-usuario').val(usuario);
                var inputIdUsuario = $('<input>').attr('type', 'hidden').attr('class', 'input-chat-id-usuario').val(id_usuario);
                var inputIdChat = $('<input>').attr('type', 'hidden').attr('class', 'input-chat-id-chat').val(id_chat);
                var spanNombre = $('<span>').attr('id', 'span-usuario-chat-'+id_usuario).attr('class', 'span-usuario-chat').css('font-weight', 'bold').text(nombres);
                usuarioChat.append(inputUsuario);
                usuarioChat.append(inputIdUsuario);
                usuarioChat.append(inputIdChat);
                usuarioChat.append(spanNombre);
                $('#div-chat-users-list').append(usuarioChat);
                
                //cargar caja de chats
                var chatContentText = $('<div>').attr('id', 'div-chat-content-text-'+id_chat).attr('class', 'div-chat-content-text');
                $('#div-chat-content').append(chatContentText);
            }
            
            //prepara el chat antes de cargar datos
            function prepararChat(){
                $('.div-chat-content-text.active').css('display', 'none');
                $('.div-chat-content-text.active').removeClass('active');
                $('#div-chat-content-text-'+id_chat).css('display', 'block');
                $('#div-chat-content-text-'+id_chat).addClass('active');
                $('#div-usuario-chat-'+id_chat+' span').css('font-weight', 'normal');
                $('#div-chat-box-usuario').empty();
                var linkUsuario = $('<a>').attr('href', '<?php echo base_url();?>admin/usuario/ver_usuario/'+id_usuario).attr('class', 'a-chat-usuario').attr('target', '_blank').text(nombreUsuario);
                $('#div-chat-box-usuario').append(linkUsuario);
            }
            
            //conecta un chat dado
            function conectarChat(id_chat, usuario, id_usuario){  
                    var newSocket = '';
                    newSocket = io.connect( 'http://pubsub.pubnub.com/'+usuario, pubnub_setup );
                    newSocket.on( 'connect', function() {
                            console.log('conectando a chat'+ id_chat);
                            //mandarMsjFix('Bienvenido al taller en línea');
                    });
                    sockets[id_chat] = newSocket;
                    //recibe mensajes
                    newSocket.on( 'message', function(text) {
                        var content = $('#div-chat-content-text-'+id_chat);
                        $('#span-usuario-chat-'+id_usuario).css('font-weight', 'bold');
                        var newContent = ('<div class="chat-msj"><strong class="username-chat">'+text.usuario+':</strong> '+text.text+'</div>').replace( /[]/g, '' ); 
                        content.append(newContent);
                        if(focusFlag == 0){
                            playSound();
                            displayNotification(text.text, text.usuario);
                        }
                            
                    });    
            }
            //conecta los chats activos
            function conectarChats(){
                // -----------------------------------------------------------------------
                // CREATE CONNECTION FOR USER EVENTS
                // -----------------------------------------------------------------------
                <?php foreach ($usuarios as $i =>$usuario):?>
                    
                    id_usuarios_conectados.push(<?php echo $usuario->id_usuario;?>);  
                    var i = <?php echo $usuario->id_chat;?>;
                    var newSocket = '';
                    newSocket = io.connect( 'http://pubsub.pubnub.com/<?php echo $usuario->usuario;?>', pubnub_setup );
                    newSocket.on( 'connect', function() {
                            console.log('conectando a chat<?php echo $usuario->id_chat;?>');
                            //mandarMsjFix('Bienvenido al taller en línea');
                    });
                    sockets[i] = newSocket;
                    //recibe mensajes
                    newSocket.on( 'message', function(text) {
                        var content = $('#div-chat-content-text-<?php echo $usuario->id_chat;?>');
                        $('#span-usuario-chat-<?php echo $usuario->id_usuario?>').css('font-weight', 'bold');
                        var newContent = ('<div class="chat-msj"><strong class="username-chat">'+text.usuario+':</strong> '+text.text+'</div>').replace( /[]/g, '' ); 
                        content.append(newContent);
                        if(focusFlag == 0){
                            playSound();
                            displayNotification(text.text, text.usuario);
                        }
                    });    
                <?php endforeach;?>
            }
            
            //permite mostrar notificaciones
            function pedirPermisosNotificacion(){
                //pedir permisos de notificacion
                if (window.webkitNotifications.checkPermission() == 0) { console.log('no necesita permisos'); 
                  } else {console.log('necesita permisos');
                    window.webkitNotifications.requestPermission();
                  }
            }
            
            //despliega una notificación de escritorio
            function displayNotification(mensaje, usuario){
                //pedir permisos de notificacion
                if (window.webkitNotifications) {
                    if (window.webkitNotifications.checkPermission() == 0) { console.log('no necesita permisos'); // 0 is PERMISSION_ALLOWED
                        // function defined in step 2
                        notification =  window.webkitNotifications.createNotification(
                        'http://www.laspartes.com/resources/template/header/logo-laspartes.png', usuario+ ' ha escrito', mensaje);
                        notification.show();

                    } else {console.log('necesita permisos');
                        window.webkitNotifications.requestPermission();
                    }
                }
            }
            
            //cuando llega un mensaje se reproduce un ringtone
            function playSound(){
                 var audioElement = document.createElement('audio');
                audioElement.setAttribute('src', '<?php echo base_url();?>resources/admin/ringtones/chat-alert.mp3');
                audioElement.setAttribute('autoplay', 'autoplay');
                //audioElement.load()
                $.get();
                audioElement.addEventListener("load", function() {
                audioElement.play();
                }, true);
                audioElement.play();
            }
            
            function mandarMsjFix(mensaje){
                var message = {};
                message.text = mensaje;
                message.usuario = nombre;
                var str = JSON.stringify(message);
                json =  str.replace(/\\/g, "");
                json = JSON.parse(json);
                socket.send(json);
            }
            
            function mandarMsj(){
                var input = PUBNUB.$('chat-message-text');
                var message = {};
                message.text = input.value;
                message.usuario = nombre;
                var str = JSON.stringify(message);
                json =  str.replace(/\\/g, "");
                json = JSON.parse(json);
                sockets[id_chat].send(json);
                $(input).val("");
                $.ajax({
                    url: "http://www.laspartes.com/mobile/usuario/guardar_mensaje",
                    type: "POST",
                    onsubmit: false,
                    data:{
                        id_chat:id_chat,
                        mensaje: message.text,
                        id_usuario: id_usuario
                    },success: function(data, status){}
                });
            }
        </script>
    </body>
</html>