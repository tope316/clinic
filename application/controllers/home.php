<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function index(){

		if($this->session->userdata('is_logged_in') == 1)
		{

			$this->load->view('includes/header');
			$this->load->view('includes/menu');
			$this->load->view('home/index');
			$this->load->view('includes/footer');
		}

	}



}

