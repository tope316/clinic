<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medical_records extends CI_Controller {

	public function index()
	{	
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
			$this->load->view('includes/header');
			$this->load->view('includes/menu');
			$this->load->view('medical_records/index');
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
	
	public function get_mr_data()
	{
		$this->load->model('medical_records_model');
		$result = $this->medical_records_model->get_mr_list_dashboard();	
		echo $result;
	}
	
	function delete_mr(){
			
		$this->load->model('medical_records_model');
		
		$bool = $this->medical_records_model->del();
		
		if($bool) echo true;
		else echo false;

	}
	
	function mr_edit_main()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
			if(isset($_GET['ID'])) {			
				
				$this->load->model('medical_records_model');
				$this->load->model('bottles_model');
				$this->load->model('brand_model');
				$this->load->model('capsules_model');
				$this->load->model('dosages_model');
				$this->load->model('durations_model');
				$this->load->model('frequencies_model');
				$this->load->model('generic_model');
				$this->load->model('preparations_model');
				$this->load->model('tablets_model');
				
				$data = array(
					'row' => $this->medical_records_model->get_mr(),
					'patients' => $this->medical_records_model->get_registration_list(),
					'bottles' => $this->bottles_model->get_list(),
					'brands' => $this->brand_model->get_list(),
					'capsules' => $this->capsules_model->get_list(),
					'dosages' => $this->dosages_model->get_list(),
					'durations' => $this->durations_model->get_list(),
					'freqs' => $this->frequencies_model->get_list(),
					'generics' => $this->generic_model->get_list(),
					'preparations' => $this->preparations_model->get_list(),
					'tablets' => $this->tablets_model->get_list()
				);					
			
				$this->load->view('includes/header');
				$this->load->view('includes/menu');
				$this->load->view('medical_records/edit', $data);
				$this->load->view('medical_records/addmodal');
				$this->load->view('medical_records/editmodal');
				$this->load->view('includes/footer');
									
			}else{
				show_error('Missing Data to Run');
			}		
		} else {
			header('location:../logout/log_out');
			exit;		
		}					
	}
	
	function mr_edit_save()
	{
		$this->load->model('medical_records_model');
		$condition_redirect = $this->medical_records_model->mr_edit_save();
		
		if($condition_redirect){
			if(isset($_POST['reg_id'])) header('location:mr_main?ID='.$_POST['reg_id']);
			else header('location:index');
			exit;
		}
	}
	
	function mr_dashboard_addnew()
	{
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
	
			$this->load->model('medical_records_model');
			$row = NULL;
			if(isset($_GET['ID'])) {
				$this->load->model('registration_model');
				$row = $this->registration_model->get_registration();
			}
	
			$data = array(
				'patients' => $this->medical_records_model->get_registration_list(),
				'row' => $row
			);
			
			$this->load->view('includes/header');
			$this->load->view('includes/menu');
			$this->load->view('medical_records/add',$data);
			$this->load->view('includes/footer');
		} else {
			header('location:../logout/log_out');
			exit;		
		}
	}
	
	function mr_add_save()
	{
		$this->load->model('medical_records_model');
		$condition_redirect = $this->medical_records_model->mr_add_save();
		
		/*if($condition_redirect){
			if(isset($_POST['reg_id'])) header('location:mr_main?ID='.$_POST['reg_id']);
			else header('location:index');
			exit;
		}*/
		if($condition_redirect){
			header('location:mr_edit_main?ID='.$condition_redirect);
		} else {
			header('location:index');
			exit;
		}
	}
	
	public function mr_main()
	{	
		$session_id = $this->session->userdata('session_id');
		if( isset($session_id) && $session_id != "" && isset($_COOKIE['user']) && $_COOKIE['user'] != "" )
		{
			if(isset($_GET['ID'])) {
				$this->load->model('registration_model');
				$data = array(
					'reg_id' => $_GET['ID'],
					'row' => $this->registration_model->get_registration()
				);
				$this->load->view('includes/header');
				$this->load->view('includes/menu');
				$this->load->view('medical_records/list', $data);
				$this->load->view('includes/footer');
			}else{
				show_error('Missing Data to Run');
			}
		} else {
			header('location:../logout/log_out');
			exit;		
		}
	}
	
	public function mr_print()
	{
		if(isset($_GET['ID'])) {
			
			$this->load->model('medical_records_model');
			$myrecord = $this->medical_records_model->get_mr();
			
			$this->load->library('Pdf');
	
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetTitle('Medical Record');
			$pdf->SetHeaderData('', '', 'Enriquez Medical Clinic', '', '', '');
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			// Add a page
			$pdf->AddPage();
			$html = "<h4>Patient: <u>".$myrecord[0]->fullname."</u></h4>";
			$pdf->writeHTMLCell(130,'','','',$html,'',0,false,true,'',true);
			$html = "<span>Checkup Date: ".$myrecord[0]->checkup_date."</span>";
			$pdf->writeHTMLCell(70,'','','',$html,'',1,false,true,'',true);
			$html = "<span>Diagnosis: ".$myrecord[0]->diagnosis."</span>";
			$pdf->writeHTMLCell(0,'','','','','',1,false,true,'',true);
			$pdf->writeHTMLCell(0,'','','',$html,'',1,false,true,'',true);
			$html = "<span>Treatment: ".$myrecord[0]->treatment."</span>";
			$pdf->writeHTMLCell(0,'','','','','',1,false,true,'',true);
			$pdf->writeHTMLCell(0,'','','',$html,'',1,false,true,'',true);
			$pdf->Output('example_001.pdf', 'I');
			
		}else{
			show_error('Missing Data to Run');
		}
	}
	
	public function get_treatment()
	{
		$this->load->model('medical_records_model');
		$result = $this->medical_records_model->get_treatment($_GET['ID']);	
		echo $result;
	}
	
	function delete_treatment(){
			
		$this->load->model('medical_records_model');
		
		$bool = $this->medical_records_model->delete_treatment();
		
		if($bool) echo true;
		else echo false;

	}
	
	function add_treatment(){
			
		$this->load->model('medical_records_model');
		
		$bool = $this->medical_records_model->add_treatment();
		
		if($bool) echo true;
		else echo false;

	}
	
	public function get_mr_treatment()
	{
		$this->load->model('medical_records_model');
		$result = $this->medical_records_model->get_mr_treatment();	
		echo json_encode($result);
	}
	
	function edit_treatment(){
			
		$this->load->model('medical_records_model');
		
		$bool = $this->medical_records_model->edit_treatment();
		
		if($bool) echo true;
		else echo false;

	}
	
}

/* End of file medical_records.php */
/* Location: ./application/controllers/medical_records.php */