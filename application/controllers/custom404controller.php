<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'laspartes_controller.php';

class Custom404controller extends Laspartes_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
                    redirect(base_url().'pagina_no_encontrada', 'refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
