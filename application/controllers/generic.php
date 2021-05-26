<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generic extends CI_Controller {

	public function index()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{					
		
			$this->load->view('includes/header');
			$this->load->view('includes/menu');
			$this->load->view('generic/index');
			$this->load->view('includes/footer');
		
		} else {
			header('location:../logout/log_out');
			exit;		
		}
	}
	
	public function get_data()
	{
		$this->load->model('generic_model');
		$result = $this->generic_model->get_data();	
		echo $result;
	}
	
	function delete(){
			
		$this->load->model('generic_model');
		
		$bool = $this->generic_model->del();
		
		if($bool) echo true;
		else echo false;

	}
	
	function edit_main()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
			if(isset($_GET['ID'])) {			
				
				$this->load->model('generic_model');
				
				$data = array(
					'row' => $this->generic_model->get_record()
				);					
			
				$this->load->view('includes/header');
				$this->load->view('includes/menu');
				$this->load->view('generic/edit', $data);
				$this->load->view('includes/footer');
									
			}else{
				show_error('Missing Data to Run');
			}		
		} else {
			header('location:../logout/log_out');
			exit;		
		}					
	}
	
	function edit_save()
	{
		$this->load->model('generic_model');
		$condition_redirect = $this->generic_model->edit_save();
		
		if($condition_redirect){
			header('location:index');
			exit;
		}
	}
	
	function dashboard_addnew()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
			$this->load->view('includes/header');
			$this->load->view('includes/menu');
			$this->load->view('generic/add');
			$this->load->view('includes/footer');
		} else {
			header('location:../logout/log_out');
			exit;		
		}
	}
	
	function add_save()
	{
		$this->load->model('generic_model');
		$condition_redirect = $this->generic_model->add_save();
		
		if($condition_redirect){
			header('location:index');
			exit;
		}
	}
	
}

/* End of file generic.php */
/* Location: ./application/controllers/generic.php */