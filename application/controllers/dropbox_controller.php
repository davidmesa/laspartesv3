<?php

class Dropbox_Controller extends CI_Controller
{
	var $key = 'x8o00zdl7a9r0ko';
	var $secret = '9thr39k2n62gmx7';

    function __construct(){
    	parent::__construct();
		$this->load->model('usuarios_dropbox_model');
		// $this->request_dropbox();
		// error_reporting(E_ALL);
    }

    // Call this method first by visiting http://SITE_URL/example/request_dropbox
    public function request_dropbox()
	{
		$params['key'] = $this->key;
		$params['secret'] = $this->secret;
		$usuarios_dropbox_model = new usuarios_dropbox_model();
		$usuarios_dropbox_model->dar_por_filtros(array('id_usuario' => $this->session->userdata('id_usuario')));
		if(empty($usuarios_dropbox_model->id)){
			$this->load->library('dropbox', $params);
			$data = $this->dropbox->get_request_token(site_url("dropbox_controller/access_dropbox"));
			$this->session->set_userdata('token_secret', $data['token_secret']);
			// redirect($data['redirect']);
			return json_encode(array('status' => false, 'dbsesion' => 'Debes iniciar sesión en dropbox.', 'dburl' =>$data['redirect']));
		}else{
			$this->session->set_userdata('oauth_token', $usuarios_dropbox_model->oauth_token);
			$this->session->set_userdata('oauth_token_secret', $usuarios_dropbox_model->oauth_token_secret);
			$params['access'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
								  'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
			$this->load->library('dropbox', $params);
			return json_encode(array('status' => true));
		}
	}
	//This method should not be called directly, it will be called after 
    //the user approves your application and dropbox redirects to it
	public function access_dropbox()
	{
		$params['key'] = 'x8o00zdl7a9r0ko';
		$params['secret'] = '9thr39k2n62gmx7';
		
		$this->load->library('dropbox', $params);
		
		$oauth = $this->dropbox->get_access_token($this->session->userdata('token_secret'));

		$usuarios_dropbox_model = new usuarios_dropbox_model();
		$usuarios_dropbox_model->id_usuario = $this->session->userdata('id_usuario');
		$usuarios_dropbox_model->oauth_token = $oauth['oauth_token'];
		$usuarios_dropbox_model->oauth_token_secret = $oauth['oauth_token_secret'];
		$usuarios_dropbox_model->insertar();
		
		$this->session->set_userdata('oauth_token', $oauth['oauth_token']);
		$this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
        redirect('dropbox_controller/closeWindow');
	}

	public function closeWindow(){
		echo '<script>window.close();</script>';
	}

	//Once your application is approved you can proceed to load the library
    //with the access token data stored in the session. If you see your account
    //information printed out then you have successfully authenticated with
    //dropbox and can use the library to interact with your account.
	public function test_dropbox(){
		$params['key'] = $this->key;
		$params['secret'] = $this->secret;
		$params['access'] = array('oauth_token'=>urlencode($this->session->userdata('oauth_token')),
								  'oauth_token_secret'=>urlencode($this->session->userdata('oauth_token_secret')));
			$this->load->library('dropbox', $params);

        $dbobj = $this->dropbox->account();
        $metadata = $this->dropbox->metadata('/CARPETA MAESTRA/FACTURAS LP/'.date('Y').'/');
        // if(!$metadata->is_dir)
        	// $this->dropbox->create_folder('/test API/'.date('Y'));

        // $metadata = $this->dropbox->metadata('/CARPETA MAESTRA');
        // $media = $this->dropbox->media('/CARPETA MAESTRA/Costo Repuestos Eagle.xlsx');
		
        // print_r($dbobj);
        print_r($metadata);
        // print_r($media);
        // var_dump($metadata);
	}

	// public function guardar($path, $filepath){
	// 	$dbobj = $this->dropbox->add();
	// }
}

/* End of file example.php */
/* Location: ./application/controllers/welcome.php */