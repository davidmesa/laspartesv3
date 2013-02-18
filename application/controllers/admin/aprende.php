<?php

/**
 * Clase que maneja las noticias, consejos y hágalo usted mismo
 */
class Aprende extends CI_Controller{

    /**
     * Constructor de la clase Aprende
     * Valida si el usuario tiene una sesión activa
     */
    function __construct(){
        parent::__construct();
        $esta_registrado = $this->session->userdata('esta_registrado');
        if(!isset($esta_registrado)||!$esta_registrado||$this->session->userdata('tipo')!=10)
            redirect(base_url().'admin/inicio', 'refresh');
    }

    /**
     * Muestra los indicadores
     * @return array $indicadores
     */
    function _ver_indicadores(){
        $this->load->model('indicador_model');
        $data['indicadores'] = $this->indicador_model->dar_indicadores();
        return $data;
    }

    /**
     * Muestra los detalles de una noticia
     * @param int $id_noticia
     * @return array con $noticia y $comentarios
     */
    function _ver_noticia($id_noticia){
        $this->load->model('noticia_model');
        $data['noticia'] = $this->noticia_model->dar_noticia($id_noticia);
        $data['comentarios'] = $this->noticia_model->dar_noticia_comentarios($id_noticia);
        return $data;
    }

    /**
     * Muestra el listado de noticias
     * @return array $noticias
     */
    function _ver_noticias(){
        $this->load->model('noticia_model');
        $data['noticias'] = $this->noticia_model->dar_noticias();
        return $data;
    }

    /**
     * Muestra los detalles de un tip
     * @param int $id_tip
     * @return array con $tip y $comentarios
     */
    function _ver_tip($id_tip){
        $this->load->model('tip_model');
        $data['tip'] = $this->tip_model->dar_tip($id_tip);
        $data['comentarios'] = $this->tip_model->dar_tip_comentarios($id_tip);
        return $data;
    }

    /**
     * Muestra el listado de tips
     * @return array $tips
     */
    function _ver_tips(){
        $this->load->model('tip_model');
        $data['tips'] = $this->tip_model->dar_tips();
        return $data;
    }

    /**
     * Muestra los detalles de un tutorial
     * @param int $id_tutorial
     * @return array con $tutorial, $pasos y $comentarios
     */
    function _ver_tutorial($id_tutorial){
        $this->load->model('tutorial_model');
        $data['tutorial'] = $this->tutorial_model->dar_tutorial($id_tutorial);
        $data['tutorial_pasos'] = $this->tutorial_model->dar_tutorial_pasos($id_tutorial);
        $data['comentarios'] = $this->tutorial_model->dar_tutorial_comentarios($id_tutorial);
        return $data;
    }

    /**
     * Muestra los detalles de un paso de un tutorial
     * @param int $id_tutorial
     * @return array con $tutorial_paso
     */
    function _ver_tutorial_paso($id_tutorial_paso){
        $this->load->model('tutorial_model');
        $data['tutorial_paso'] = $this->tutorial_model->dar_tutorial_paso($id_tutorial_paso);
        return $data;
    }

    /**
     * Muestra el listado de tuturiales
     * @return array $tuturiales
     */
    function _ver_tutoriales(){
        $this->load->model('tutorial_model');
        $data['tutoriales'] = $this->tutorial_model->dar_tutoriales();
        return $data;
    }

    /**
     * Agrega una noticia
     */
    function agregar_noticia(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'titulo',
                'label' => 'titulo',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'noticia',
                'label' => 'noticia',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'imagen',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if(!$this->form_validation->run())
            $this->load->view('admin/aprende/noticia_agregar_view');
        else{
            $this->load->model('noticia_model');
            $titulo = ucwords(strtolower($this->input->post('titulo', TRUE)));
            $noticia = $this->input->post('noticia', TRUE);
            $estado = $this->input->post('estado', TRUE);
            $id_noticia = $this->noticia_model->agregar_noticia($titulo, $noticia, $estado);

            $this->load->library('upload');
            if(!is_dir('resources/images/aprende/noticia/'.$id_noticia)){
                mkdir('resources/images/aprende/noticia/'.$id_noticia,0777,TRUE);
                mkdir('resources/images/aprende/noticia/'.$id_noticia.'/thumb',0777,TRUE);
            }

            $config = array(
                'upload_path' => 'resources/images/aprende/noticia/'.$id_noticia,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'new_image' => 'resources/images/aprende/noticia/'.$id_noticia.'/thumb',
                    'width' => 250,
                    'height' => 150,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $imagen_url = 'resources/images/aprende/noticia/'.$id_noticia.'/'.$imagen['file_name'];
                $imagen_thumb_url = 'resources/images/aprende/noticia/'.$id_noticia.'/thumb/'.$imagen['file_name'];
                $this->noticia_model->actualizar_noticia_imagen_url($id_noticia, $imagen_url, $imagen_thumb_url);
            }

            $this->load->model('indexacion_model');
            $indexacion = $titulo.' '.$noticia;
            $this->indexacion_model->agregar_indexacion('noticias', $id_noticia, $titulo, $noticia, $indexacion, 'aprende/noticia/'.$id_noticia.'/'.str_replace(' ', '-', convert_accented_characters($titulo)), $estado);

            $data['confirmacion'] = 'La noticia ha sido agregada con éxito';
            $data = $this->_ver_noticias();
            $this->load->view('admin/aprende/noticia_lista_view', $data);
        }
    }

    /**
     * Agrega un tip
     */
    function agregar_tip(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'titulo',
                'label' => 'titulo',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'tip',
                'label' => 'tip',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'imagen',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if(!$this->form_validation->run())
            $this->load->view('admin/aprende/tip_agregar_view');
        else{
            $this->load->model('tip_model');
            $titulo = ucwords(strtolower($this->input->post('titulo', TRUE)));
            $tip = $this->input->post('tip', TRUE);
            $estado = $this->input->post('estado', TRUE);
            $id_tip = $this->tip_model->agregar_tip($titulo, $tip, $estado);

            $this->load->library('upload');
            if(!is_dir('resources/images/aprende/tip/'.$id_tip)){
                mkdir('resources/images/aprende/tip/'.$id_tip,0777,TRUE);
                mkdir('resources/images/aprende/tip/'.$id_tip.'/thumb',0777,TRUE);
            }

            $config = array(
                'upload_path' => 'resources/images/aprende/tip/'.$id_tip,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'new_image' => 'resources/images/aprende/tip/'.$id_tip.'/thumb',
                    'width' => 99,
                    'height' => 99,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $imagen_url = 'resources/images/aprende/tip/'.$id_tip.'/'.$imagen['file_name'];
                $imagen_thumb_url = 'resources/images/aprende/tip/'.$id_tip.'/thumb/'.$imagen['file_name'];
                $this->tip_model->actualizar_tip_imagen_url($id_tip, $imagen_url, $imagen_thumb_url);
            }

            $this->load->model('indexacion_model');
            $indexacion = $titulo.' '.$tip;
            $this->indexacion_model->agregar_indexacion('tips', $id_tip, $titulo, $tip, $indexacion, 'aprende/tip/'.$id_tip.'/'.str_replace(' ', '-', convert_accented_characters($titulo)), $estado);

            $data['confirmacion'] = 'El tip ha sido agregado con éxito';
            $data = $this->_ver_tips();
            $this->load->view('admin/aprende/tip_lista_view', $data);
        }
    }

    /**
     * Agrega un tutorial
     */
    function agregar_tutorial(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'titulo',
                'label' => 'titulo',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'resumen',
                'label' => 'resumen',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'imagen',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        if(!$this->form_validation->run())
            $this->load->view('admin/aprende/tutorial_agregar_view');
        else{
            $this->load->model('tutorial_model');
            $titulo = ucwords(strtolower($this->input->post('titulo', TRUE)));
            $resumen = $this->input->post('resumen', TRUE);
            $estado = $this->input->post('estado', TRUE);
            $id_tutorial = $this->tutorial_model->agregar_tutorial($titulo, $resumen, $estado);

            $this->load->library('upload');
            if(!is_dir('resources/images/aprende/tutorial/'.$id_tutorial)){
                mkdir('resources/images/aprende/tutorial/'.$id_tutorial,0777,TRUE);
                mkdir('resources/images/aprende/tutorial/'.$id_tutorial.'/thumb',0777,TRUE);
            }

            $config = array(
                'upload_path' => 'resources/images/aprende/tutorial/'.$id_tutorial,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'new_image' => 'resources/images/aprende/tutorial/'.$id_tutorial.'/thumb',
                    'width' => 250,
                    'height' => 150,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $imagen_url = 'resources/images/aprende/tutorial/'.$id_tutorial.'/'.$imagen['file_name'];
                $imagen_thumb_url = 'resources/images/aprende/tutorial/'.$id_tutorial.'/thumb/'.$imagen['file_name'];
                $this->tutorial_model->actualizar_tutorial_imagen_url($id_tutorial, $imagen_url, $imagen_thumb_url);
            }

            $indexacion_pasos = '';
            $pasos = dar_tutorial_pasos($id_tutorial);
            if(sizeof($pasos)!=0){
                foreach($pasos as $paso){
                    $indexacion_pasos .= ' '.$paso->paso;
                }
            }

            $this->load->model('indexacion_model');
            $indexacion = $titulo.' '.$resumen.' '.$indexacion_pasos;
            $this->indexacion_model->agregar_indexacion('tutoriales', $id_tutorial, $titulo, $resumen, $indexacion, 'aprende/tutorial/'.$id_tutorial.'/'.str_replace(' ', '-', convert_accented_characters($titulo)), $estado);

            $data['confirmacion'] = 'El tutorial ha sido agregado con éxito. Ahora agregue los pasos a seguir del tutorial.';
            $data['id_tutorial'] = $id_tutorial;
            $this->load->view('admin/aprende/tutorial_paso_agregar_view', $data);
        }
    }

    /**
     * Agrega un nuevo paso a un tutorial
     */
    function agregar_tutorial_paso(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_tutorial',
                'label' => 'identificador del tutorial',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'paso',
                'label' => 'paso',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'imagen',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tutorial = $this->input->post('id_tutorial', TRUE);
        if(!$this->form_validation->run()){
            $data['id_tutorial'] = $id_tutorial;
            $this->load->view('admin/aprende/tutorial_paso_agregar_view', $data);
        }
        else{
            $this->load->model('tutorial_model');
            $paso = $this->input->post('paso', TRUE);
            $id_tutorial_paso = $this->tutorial_model->agregar_tutorial_paso($id_tutorial, $paso);

            $this->load->library('upload');
            if(!is_dir('resources/images/aprende/tutorial/'.$id_tutorial)){
                mkdir('resources/images/aprende/tutorial/'.$id_tutorial,0777,TRUE);
                mkdir('resources/images/aprende/tutorial/'.$id_tutorial.'/thumb',0777,TRUE);
            }

            $config = array(
                'upload_path' => 'resources/images/aprende/tutorial/'.$id_tutorial,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'file_name' => $id_tutorial_paso,
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $imagen_url = 'resources/images/aprende/tutorial/'.$id_tutorial.'/'.$imagen['file_name'];
               $this->tutorial_model->actualizar_tutorial_paso_imagen_url($id_tutorial_paso, $imagen_url);
            }

            $this->load->model('indexacion_model');
            $tutorial = $this->tutorial_model->dar_tutorial($id_tutorial);
            $tutorial_pasos = $this->tutorial_model->dar_tutorial_pasos($id_tutorial);
            $pasos_indexacion = '';
            foreach($tutorial_pasos as $tutorial_paso)
                $pasos_indexacion .= $tutorial_paso->paso.' ';
            $indexacion = $tutorial->titulo.' '.$tutorial->resumen.' '.$pasos_indexacion;
            $this->indexacion_model->actualizar_indexacion('tutoriales', $id_tutorial, $tutorial->titulo, $tutorial->resumen, $indexacion, 'aprende/tutorial/'.$id_tutorial.'/'.str_replace(' ', '-', convert_accented_characters($tutorial->titulo)), $tutorial->estado);

            $data['confirmacion'] = 'El paso del tutorial ha sido agregado con éxito. Ahora agregue el siguiente paso.';
            $data['id_tutorial'] = $id_tutorial;
            $this->load->view('admin/aprende/tutorial_paso_agregar_view', $data);
        }
    }

    /**
     * Actualiza un indicador
     */
    function actualizar_indicadores(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_indicadores[]',
                'label' => 'identificador del indicador',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $id_indicadores = $this->input->post('id_indicadores', TRUE);
        if(is_array($id_indicadores) && sizeof($id_indicadores)!=0){
                foreach($id_indicadores as $id_indicador){
                    $nombre = array(
                        'field' => 'nombre-'.$id_indicador,
                        'label' => 'nombre de los indicadores',
                        'rules' => 'trim|required|xss_clean'
                    );
                    $valor = array(
                        'field' => 'valor-'.$id_indicador,
                        'label' => 'valor de los indicadores',
                        'rules' => 'trim|required|xss_clean'
                    );
                    array_push($reglas, $nombre, $valor);
                }
        }
        $this->form_validation->set_rules($reglas);

        if(!$this->form_validation->run()){
            $data = $this->_ver_indicadores();
            $this->load->view('admin/aprende/indicador_lista_view', $data);
        }
        else{
            $this->load->model('indicador_model');
            if(is_array($id_indicadores) && sizeof($id_indicadores)!=0){
                foreach($id_indicadores as $id_indicador){
                    $nombre = $this->input->post('nombre-'.$id_indicador, TRUE);
                    $valor = $this->input->post('valor-'.$id_indicador, TRUE);
                    $this->indicador_model->actualizar_indicador($id_indicador, $nombre, $valor);
                }
            }
            
            $data = $this->_ver_indicadores();
            $data['confirmacion'] = 'Los indicadores han sido actualizados con éxito';
            $this->load->view('admin/aprende/indicador_lista_view', $data);
        }
    }

    /**
     * Actualiza una noticia
     */
    function actualizar_noticia(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_noticia',
                'label' => 'identificador de la noticia',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'titulo',
                'label' => 'titulo',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'noticia',
                'label' => 'noticia',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'imagen',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_noticia = $this->input->post('id_noticia', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_noticia($id_noticia);
            $this->load->view('admin/aprende/noticia_detalle_view', $data);
        }
        else{
            $this->load->model('noticia_model');
            $titulo = ucwords(strtolower($this->input->post('titulo', TRUE)));
            $noticia = $this->input->post('noticia', TRUE);
            $estado = $this->input->post('estado', TRUE);
            $this->noticia_model->actualizar_noticia($id_noticia, $titulo, $noticia, $estado);

            $this->load->library('upload');
            if(!is_dir('resources/images/aprende/noticia/'.$id_noticia)){
                mkdir('resources/images/aprende/noticia/'.$id_noticia,0777,TRUE);
                mkdir('resources/images/aprende/noticia/'.$id_noticia.'/thumb',0777,TRUE);
            }

            $config = array(
                'upload_path' => 'resources/images/aprende/noticia/'.$id_noticia,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'new_image' => 'resources/images/aprende/noticia/'.$id_noticia.'/thumb',
                    'width' => 250,
                    'height' => 150,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $imagen_url = 'resources/images/aprende/noticia/'.$id_noticia.'/'.$imagen['file_name'];
                $imagen_thumb_url = 'resources/images/aprende/noticia/'.$id_noticia.'/thumb/'.$imagen['file_name'];
                $this->noticia_model->actualizar_noticia_imagen_url($id_noticia, $imagen_url, $imagen_thumb_url);
            }

            $this->load->model('indexacion_model');
            $indexacion = $titulo.' '.$noticia;
            $this->indexacion_model->actualizar_indexacion('noticias', $id_noticia, $titulo, $noticia, $indexacion, 'aprende/noticia/'.$id_noticia.'/'.str_replace(' ', '-', convert_accented_characters($titulo)), $estado);

            $data['confirmacion'] = 'La noticia ha sido actualizada con éxito';
            $data = $this->_ver_noticias();
            $this->load->view('admin/aprende/noticia_lista_view', $data);
        }
    }

    /**
     * Actualiza un tip
     */
    function actualizar_tip(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_tip',
                'label' => 'identificador del tip',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'titulo',
                'label' => 'titulo',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'tip',
                'label' => 'tip',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tip = $this->input->post('id_tip', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_tip($id_tip);
            $this->load->view('admin/aprende/tip_detalle_view', $data);
        }
        else{
            $this->load->model('tip_model');
            $titulo = ucwords(strtolower($this->input->post('titulo', TRUE)));
            $tip = $this->input->post('tip', TRUE);
            $estado = $this->input->post('estado', TRUE);
            $this->tip_model->actualizar_tip($id_tip, $titulo, $tip, $estado);

            $this->load->library('upload');
            if(!is_dir('./resources/images/aprende/tip/'.$id_tip)){
                mkdir('./resources/images/aprende/tip/'.$id_tip,0777,TRUE);
                mkdir('./resources/images/aprende/tip/'.$id_tip.'/thumb',0777,TRUE);
            }

            $config = array(
                'upload_path' => './resources/images/aprende/tip/'.$id_tip,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'new_image' => './resources/images/aprende/tip/'.$id_tip.'/thumb',
                    'width' => 99,
                    'height' => 99,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $imagen_url = base_url().'/resources/images/aprende/tip/'.$id_tip.'/'.$imagen['file_name'];
                $imagen_thumb_url = base_url().'/resources/images/aprende/tip/'.$id_tip.'/thumb/'.$imagen['file_name'];
                $this->tip_model->actualizar_tip_imagen_url($id_tip, $imagen_url, $imagen_thumb_url);
            }

            $this->load->model('indexacion_model');
            $indexacion = $titulo.' '.$tip;
            $this->indexacion_model->agregar_indexacion('tips', $id_tip, $titulo, $tip, $indexacion, 'aprende/tip/'.$id_tip.'/'.str_replace(' ', '-', convert_accented_characters($titulo)), $estado);

            $data['confirmacion'] = 'El tip ha sido actualizado con éxito';
            $data = $this->_ver_tips();
            $this->load->view('admin/aprende/tip_lista_view', $data);
        }
    }

    /**
     * Actualiza un tutorial
     */
    function actualizar_tutorial(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_tutorial',
                'label' => 'identificador del tutorial',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'titulo',
                'label' => 'titulo',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'resumen',
                'label' => 'resumen',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'imagen',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tutorial = $this->input->post('id_tutorial', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_tutorial($id_tutorial);
            $this->load->view('admin/aprende/tutorial_detalle_view', $data);
        }
        else{
            $this->load->model('tutorial_model');
            $titulo = ucwords(strtolower($this->input->post('titulo', TRUE)));
            $resumen = $this->input->post('resumen', TRUE);
            $estado = $this->input->post('estado', TRUE);
            $this->tutorial_model->actualizar_tutorial($id_tutorial, $titulo, $resumen, $estado);

            $this->load->library('upload');
            if(!is_dir('resources/images/aprende/tutorial/'.$id_tutorial)){
                mkdir('resources/images/aprende/tutorial/'.$id_tutorial,0777,TRUE);
                mkdir('resources/images/aprende/tutorial/'.$id_tutorial.'/thumb',0777,TRUE);
            }

            $config = array(
                'upload_path' => 'resources/images/aprende/tutorial/'.$id_tutorial,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $this->load->library('image_lib');
                $config = array(
                    'source_image' => $imagen['full_path'],
                    'quality' => '100%',
                    'new_image' => 'resources/images/aprende/tutorial/'.$id_tutorial.'/thumb',
                    'width' => 250,
                    'height' => 150,
                    'master_dim' => 'width'
                );
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                $imagen_url = 'resources/images/aprende/tutorial/'.$id_tutorial.'/'.$imagen['file_name'];
                $imagen_thumb_url = 'resources/images/aprende/tutorial/'.$id_tutorial.'/thumb/'.$imagen['file_name'];
                $this->tutorial_model->actualizar_tutorial_imagen_url($id_tutorial, $imagen_url, $imagen_thumb_url);
            }

            $this->load->model('indexacion_model');
            $tutorial_pasos = $this->tutorial_model->dar_tutorial_pasos($id_tutorial);
            $pasos_indexacion = '';
            foreach($tutorial_pasos as $tutorial_paso)
                $pasos_indexacion .= $tutorial_paso->paso.' ';
            $indexacion = $titulo.' '.$resumen.' '.$pasos_indexacion;
            $this->indexacion_model->actualizar_indexacion('tutoriales', $id_tutorial, $titulo, $resumen, $indexacion, 'aprende/tutorial/'.$id_tutorial.'/'.str_replace(' ', '-', convert_accented_characters($titulo)), $estado);


            $data['confirmacion'] = 'El tutorial ha sido actualizado con éxito';
            $data = $this->_ver_tutoriales();
            $this->load->view('admin/aprende/tutorial_lista_view', $data);
        }
    }

    /**
     * Actualiza un paso de un tutorial
     */
    function actualizar_tutorial_paso(){
        $this->load->library('form_validation');
        $reglas = array(
            array(
                'field' => 'id_tutorial_paso',
                'label' => 'identificador del paso del tutorial',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'id_tutorial',
                'label' => 'identificador del tutorial',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'paso',
                'label' => 'resumen',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'imagen',
                'label' => 'imagen',
                'rules' => 'trim|xss_clean'
            )
        );
        $this->form_validation->set_rules($reglas);

        $id_tutorial = $this->input->post('id_tutorial', TRUE);
        if(!$this->form_validation->run()){
            $data = $this->_ver_tutorial($id_tutorial);
            $this->load->view('admin/aprende/tutorial_detalle_view', $data);
        }
        else{
            $this->load->model('tutorial_model');
            $id_tutorial_paso = $this->input->post('id_tutorial_paso', TRUE);
            $paso = $this->input->post('paso', TRUE);
            $this->tutorial_model->actualizar_tutorial_paso($id_tutorial_paso, $paso);

            $this->load->library('upload');
            if(!is_dir('resources/images/aprende/tutorial/'.$id_tutorial)){
                mkdir('resources/images/aprende/tutorial/'.$id_tutorial,0777,TRUE);
                mkdir('resources/images/aprende/tutorial/'.$id_tutorial.'/thumb',0777,TRUE);
            }

            $config = array(
                'upload_path' => 'resources/images/aprende/tutorial/'.$id_tutorial,
                'allowed_types' => 'jpg|jpeg|png|gif',
                'file_name' => $id_tutorial_paso,
                'max_size' => '10000'
            );
            $this->upload->initialize($config);

            if($this->upload->do_upload('imagen')){
                $imagen = $this->upload->data();

                $imagen_url = 'resources/images/aprende/tutorial/'.$id_tutorial.'/'.$imagen['file_name'];
                $this->tutorial_model->actualizar_tutorial_paso_imagen_url($id_tutorial_paso, $imagen_url);
            }

            $this->load->model('indexacion_model');
            $tutorial = $this->tutorial_model->dar_tutorial($id_tutorial);
            $tutorial_pasos = $this->tutorial_model->dar_tutorial_pasos($id_tutorial);
            $pasos_indexacion = '';
            foreach($tutorial_pasos as $tutorial_paso)
                $pasos_indexacion .= $tutorial_paso->paso.' ';
            $indexacion = $tutorial->titulo.' '.$tutorial->resumen.' '.$pasos_indexacion;
            $this->indexacion_model->actualizar_indexacion('tutoriales', $id_tutorial, $tutorial->titulo, $tutorial->resumen, $indexacion, 'aprende/tutorial/'.$id_tutorial.'/'.str_replace(' ', '-', convert_accented_characters($tutorial->titulo)), $tutorial->estado);

            $data = $this->_ver_tutorial($id_tutorial);
            $data['confirmacion'] = 'El paso del tutorial ha sido actualizado con éxito';
            $this->load->view('admin/aprende/tutorial_detalle_view', $data);
        }
    }

    /**
     * Elimina un comentario de una noticia
     */
    function eliminar_noticia_comentario(){
        $id_noticia = $this->uri->segment(4);
        $id_noticia_comentario = $this->uri->segment(5);
        $this->load->model('noticia_model');
        $this->noticia_model->eliminar_noticia_comentario($id_noticia_comentario);

        $data = $this->_ver_noticia($id_noticia);
        $data['confirmacion'] = 'El comentario ha sido eliminado con éxito';
        $this->load->view('admin/aprende/noticia_detalle_view', $data);
    }

    /**
     * Elimina la foto de la noticia
     */
    function eliminar_noticia_imagen(){
        $id_noticia = $this->uri->segment(4);
        $this->load->model('noticia_model');
        $noticia = $this->noticia_model->dar_noticia($id_noticia);
        unlink($noticia->imagen_url);
        unlink($noticia->imagen_thumb_url);
        $this->noticia_model->eliminar_noticia_imagen($id_noticia);
        $data = $this->_ver_noticia($id_noticia);
        $data['confirmacion'] = 'La imagen de la noticia ha sido eliminado con éxito';
        $this->load->view('admin/aprende/noticia_detalle_view', $data);
    }

    /**
     * Elimina un comentario de un tip
     */
    function eliminar_tip_comentario(){
        $id_tip = $this->uri->segment(4);
        $id_tip_comentario = $this->uri->segment(5);
        $this->load->model('tip_model');
        $this->tip_model->eliminar_tip_comentario($id_tip_comentario);

        $data = $this->_ver_tip($id_tip);
        $data['confirmacion'] = 'El comentario ha sido eliminado con éxito';
        $this->load->view('admin/aprende/tip_detalle_view', $data);
    }

    /**
     * Elimina la foto de la noticia
     */
    function eliminar_tip_imagen(){
        $id_tip = $this->uri->segment(4);
        $this->load->model('tip_model');
        $tip = $this->tip_model->dar_tip($id_tip);
        unlink($tip->imagen_url);
        unlink($tip->imagen_thumb_url);
        $this->tip_model->eliminar_tip_imagen($id_tip);
        $data = $this->_ver_tip($id_tip);
        $data['confirmacion'] = 'La imagen del tip ha sido eliminado con éxito';
        $this->load->view('admin/aprende/tip_detalle_view', $data);
    }

    /**
     * Elimina un comentario de un tutorial
     */
    function eliminar_tutorial_comentario(){
        $id_tutorial = $this->uri->segment(4);
        $id_tutorial_comentario = $this->uri->segment(5);
        $this->load->model('tutorial_model');
        $this->tutorial_model->eliminar_tutorial_comentario($id_tutorial_comentario);

        $data = $this->_ver_tutorial($id_tutorial);
        $data['confirmacion'] = 'El comentario ha sido eliminado con éxito';
        $this->load->view('admin/aprende/tutorial_detalle_view', $data);
    }

    /**
     * Elimina la foto principal del tutorial
     */
    function eliminar_tutorial_imagen(){
        $id_tutorial = $this->uri->segment(4);
        $this->load->model('tutorial_model');
        $tutorial = $this->tutorial_model->dar_tutorial($id_tutorial);
        unlink($tutorial->imagen_url);
        unlink($tutorial->imagen_thumb_url);
        $this->tutorial_model->eliminar_tutorial_imagen($id_tutorial);
        $data = $this->_ver_tutorial($id_tutorial);
        $data['confirmacion'] = 'La imagen del tutorial ha sido eliminado con éxito';
        $this->load->view('admin/aprende/tutorial_detalle_view', $data);
    }

    /**
     * Elimina un paso de un tutorial
     */
    function eliminar_tutorial_paso(){
        $id_tutorial_paso = $this->uri->segment(4);
        $this->load->model('tutorial_model');
        $tutorial_paso = $this->tutorial_model->dar_tutorial_paso($id_tutorial_paso);
        if($tutorial_paso->imagen_url!='' && $tutorial_paso->imagen_url!=NULL)
            unlink($tutorial_paso->imagen_url);
        $this->tutorial_model->eliminar_tutorial_paso($id_tutorial_paso);
        $data = $this->_ver_tutorial($tutorial_paso->id_tutorial);
        $data['confirmacion'] = 'El paso del tutorial ha sido eliminado con éxito';
        $this->load->view('admin/aprende/tutorial_detalle_view', $data);
    }

    /**
     * Elimina la imagen de un paso de un tutorial
     */
    function eliminar_tutorial_paso_imagen(){
        $id_tutorial_paso = $this->uri->segment(4);
        $this->load->model('tutorial_model');
        $tutorial_paso = $this->tutorial_model->dar_tutorial_paso($id_tutorial_paso);
        unlink($tutorial_paso->imagen_url);
        $this->tutorial_model->eliminar_tutorial_paso_imagen($id_tutorial_paso);
        $data = $this->_ver_tutorial_paso($id_tutorial_paso);
        $data['confirmacion'] = 'La imagen del paso del tutorial ha sido eliminado con éxito';
        $this->load->view('admin/aprende/tutorial_paso_detalle_view', $data);
    }

    /**
     * Muestra el formulario para agregar un indicador
     */
    function formulario_agregar_indicador(){
        $this->load->view('admin/aprende/indicador_agregar_view');
    }
    
    /**
     * Muestra el formulario para agregar una noticia
     */
    function formulario_agregar_noticia(){
        $this->load->view('admin/aprende/noticia_agregar_view');
    }

    /**
     * Muestra el formulario para agregar un tip
     */
    function formulario_agregar_tip(){
        $this->load->view('admin/aprende/tip_agregar_view');
    }

    /**
     * Muestra el formulario para agregar un tutorial
     */
    function formulario_agregar_tutorial(){
        $this->load->view('admin/aprende/tutorial_agregar_view');
    }

    /**
     * Agrega un paso a un tutorial ya creado
     */
    function formulario_agregar_tutorial_paso(){
        $data['id_tutorial'] = $this->uri->segment(4);
        $this->load->view('admin/aprende/tutorial_paso_agregar_view', $data);
    }

    /**
     * Muestra el listado de noticias
     */
    function index(){
        $this->load->model('noticia_model');
        $data = $this->_ver_noticias();
        $this->load->view('admin/aprende/noticia_lista_view', $data);
    }

    /**
     * Muestra los indicadores
     */
    function ver_indicadores(){
        $this->load->model('indicador_model');
        $data = $this->_ver_indicadores();
        $this->load->view('admin/aprende/indicador_lista_view', $data);
    }

    /**
     * Muestra una noticia
     */
    function ver_noticia(){
        $this->load->model('noticia_model');
        $id_noticia = $this->uri->segment(4);
        $data = $this->_ver_noticia($id_noticia);
        $this->load->view('admin/aprende/noticia_detalle_view', $data);
    }

    /**
     * Muestra un tip
     */
    function ver_tip(){
        $this->load->model('tip_model');
        $id_tip = $this->uri->segment(4);
        $data = $this->_ver_tip($id_tip);
        $this->load->view('admin/aprende/tip_detalle_view', $data);
    }

    /**
     * Muestra el listado de tips
     */
    function ver_tips(){
        $this->load->model('tip_model');
        $data = $this->_ver_tips();
        $this->load->view('admin/aprende/tip_lista_view', $data);
    }

    /**
     * Muestra un tutorial
     */
    function ver_tutorial(){
        $this->load->model('tutorial_model');
        $id_tutorial = $this->uri->segment(4);
        $data = $this->_ver_tutorial($id_tutorial);
        $this->load->view('admin/aprende/tutorial_detalle_view', $data);
    }

    /**
     * Muestra un paso de un tutorial
     */
    function ver_tutorial_paso(){
        $id_tutorial_paso = $this->uri->segment(4);
        $data = $this->_ver_tutorial_paso($id_tutorial_paso);
        $this->load->view('admin/aprende/tutorial_paso_detalle_view', $data);
    }

    /**
     * Muestra el listado de tutoriales
     */
    function ver_tutoriales(){
        $data = $this->_ver_tutoriales();
        $this->load->view('admin/aprende/tutorial_lista_view', $data);
    }
}