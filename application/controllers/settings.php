<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {
	
	function index()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
				
			$this->load->model('settings_model');
			
			$data = array(
				'row' => $this->settings_model->get_settings()
			);					
		
			$this->load->view('includes/header');
			$this->load->view('includes/menu');
			$this->load->view('settings', $data);
			$this->load->view('includes/footer');
		
		} else {
			header('location:../logout/log_out');
			exit;		
		}					
	}
	
	function settings_save()
	{
		$this->load->model('settings_model');
		$condition_redirect = $this->settings_model->settings_save();
		
		if($condition_redirect){
			header('location:index');
			exit;
		}
	}
	
}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */