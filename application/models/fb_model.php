<?php

class Fb_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $config = array(
            'appId' => '382292381857467',
            'secret' => '48487b43acc554f1324f6c4599156cad',
            'fileUpload' => true, // Indicates if the CURL based @ syntax for file uploads is enabled.
        );

        $this->load->library('Facebook', $config);

        $user = $this->facebook->getUser();

        // We may or may not have this data based on whether the user is logged in.
        //
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the user logged out of Facebook.
        $profile = null;
        if ($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $profile = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }

        $fb_data = array(
            'me' => $profile
        );

        $this->session->set_userdata('fb_data', $fb_data);
    }

    /**
     * Dado los parametros se publica el post en FB
     * @param type $mensaje
     * @param type $nombre
     * @param type $caption
     * @param type $url
     * @param type $descripcion
     * @param type $img
     */
    function hacer_publicacion($mensaje, $nombre, $caption, $url, $descripcion, $img) {
        $fb_data = $this->session->userdata('fb_data'); // This array contains all the user FB information
        if ($fb_data['me']) {
            $wall_post = array(
                'message' => $mensaje,
                'name' => $nombre,
                'caption' => $caption,
                'link' => $url,
                'description' => $descripcion,
                'picture' => $img,
                'actions' => array(array('name' => 'laspartes.com',
                        'link' => base_url()))
            );
            $this->facebook->api('/me/feed/', 'post', $wall_post);
        }
    }

}
