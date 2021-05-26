<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function log_out()
	{
		$this->session->sess_destroy();
		$this->load->helper('cookie');
		delete_cookie('user');

		header('location: '.MAIN_URL.'');

	}
}

