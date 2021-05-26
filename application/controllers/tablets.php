<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tablets extends CI_Controller {

	public function index()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{					
		
			$this->load->view('includes/header');
			$this->load->view('includes/menu');
			$this->load->view('tablets/index');
			$this->load->view('includes/footer');
		
		} else {
			header('location:../logout/log_out');
			exit;		
		}
	}
	
	public function get_data()
	{
		$this->load->model('tablets_model');
		$result = $this->tablets_model->get_data();	
		echo $result;
	}
	
	function delete(){
			
		$this->load->model('tablets_model');
		
		$bool = $this->tablets_model->del();
		
		if($bool) echo true;
		else echo false;

	}
	
	function edit_main()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
			if(isset($_GET['ID'])) {			
				
				$this->load->model('tablets_model');
				
				$data = array(
					'row' => $this->tablets_model->get_record()
				);					
			
				$this->load->view('includes/header');
				$this->load->view('includes/menu');
				$this->load->view('tablets/edit', $data);
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
		$this->load->model('tablets_model');
		$condition_redirect = $this->tablets_model->edit_save();
		
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
			$this->load->view('tablets/add');
			$this->load->view('includes/footer');
		} else {
			header('location:../logout/log_out');
			exit;		
		}
	}
	
	function add_save()
	{
		$this->load->model('tablets_model');
		$condition_redirect = $this->tablets_model->add_save();
		
		if($condition_redirect){
			header('location:index');
			exit;
		}
	}
	
}

/* End of file tablets.php */
/* Location: ./application/controllers/tablets.php */