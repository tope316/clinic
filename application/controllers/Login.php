<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('includes/header');
		$this->load->view('Login/login');
		$this->load->view('includes/footer');

	}
}

