<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {

	public function index()
	{	
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
			$this->load->view('includes/header');
			$this->load->view('includes/menu');
			$this->load->view('registration/index');
			$this->load->view('includes/footer');
		} else {
			header('location:../logout/log_out');
			exit;		
		}
	}
	
	public function get_registration_data()
	{
		$this->load->model('registration_model');
		$result = $this->registration_model->get_registration_list_dashboard();	
		echo $result;
	}
	
	function delete_registration(){
			
		$this->load->model('registration_model');
		
		$bool = $this->registration_model->del();
		
		if($bool) echo true;
		else echo false;

	}
	
	function registration_edit_main()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
			if(isset($_GET['ID'])) {			
				
				$this->load->model('registration_model');
				
				$data = array(
					'row' => $this->registration_model->get_registration()
				);					
			
				$this->load->view('includes/header');
				$this->load->view('includes/menu');
				$this->load->view('registration/edit', $data);
				$this->load->view('includes/footer');
									
			}else{
				show_error('Missing Data to Run');
			}		
		} else {
			header('location:../logout/log_out');
			exit;		
		}					
	}
	
	function registration_edit_save()
	{
		$this->load->model('registration_model');
		$condition_redirect = $this->registration_model->registration_edit_save();
		
		if($condition_redirect){
			//header('location:../success/?url=category_controller&page=Category&func=category_dashboard');
			header('location:index');
			exit;
		}
	}
	
	function registration_dashboard_addnew()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
			$this->load->view('includes/header');
			$this->load->view('includes/menu');
			$this->load->view('registration/add');
			$this->load->view('includes/footer');
		} else {
			header('location:../logout/log_out');
			exit;		
		}
	}
	
	function registration_add_save()
	{
		$this->load->model('registration_model');
		$condition_redirect = $this->registration_model->registration_add_save();
		
		if($condition_redirect){
			header('location:index');
			exit;
		}
	}
	
}

/* End of file registration.php */
/* Location: ./application/controllers/registration.php */