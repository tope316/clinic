<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medical_records_Model extends CI_Model {

	function get_mr_list_dashboard()
	{
		
		$reg_id = $_GET['reg_id'];
		
		$sqlCount = "select count(*) as xcount from medical_records where reg_id = $reg_id";
		$count = $this->db->query($sqlCount)->result();
		foreach($count as $c){
			$num = $c->xcount;
		}
		
		$sqlInfo = "select ID, reg_id, DATE_FORMAT(checkup_date,'%m/%d/%Y') as checkup_date, CONCAT(SUBSTR(diagnosis,1,20),'...') as diagnosis from medical_records WHERE reg_id = $reg_id";
		
		$queries = $this->db->query($sqlInfo)->result();
		$numRows = count($queries);
		
		$queries  = array(
						'sEcho' => '1',//$sEcho,
						'iTotalRecords' => $num,//total number of records in the db
						'iTotalDisplayRecords'=> $num,//total number of records after filtering
						'aaData' => $queries
						//'preview' => '<a href="##" id="id_doPreview"><img src="../img/magnifier.png"></a>'
					   );
		
		return json_encode( $queries );
	}
	
	function get_registration_list()
	{			
		$qry = $this->db->query("select ID, fullname from registration WHERE 1=1");
		
		return $qry->result();
	}
	
	function del()
	{
		$code = $this->input->get('code');
		
		$data = array(
			'code' => $code
		);
		
		$qry = "delete from medical_records where ID = ?";
		
		$res = $this->db->query($qry,$data);
		
		if(!$res){
		   $errNo   = $this->db->_error_number();
		   $errMess = $this->db->_error_message();
		   // Do something with the error message or just show_404();
		   echo $errMess;
		}
		else {
			return true;
		}
	}
	
	function get_mr()
	{
		
		$code = $_GET['ID'];//to get the url value
	
		$qry = $this->db->query("SELECT m.ID, m.reg_id, DATE_FORMAT(m.checkup_date,'%m/%d/%Y') AS checkup_date, m.diagnosis, 
			r.fullname, m.findings FROM medical_records AS m LEFT OUTER JOIN registration AS r ON m.reg_id = r.ID WHERE m.ID = $code");
		
		if($qry){
			$rows = $qry->result();		  
			return $rows;
		}else{
			show_error('Medical Record not Found!');
		}
		 
	}
	
	public function conv_str_to_date($mystr) 
	{
		if (empty($mystr)) $mydate = NULL;
		else {
			$time = strtotime($mystr);
			$mydate = date('Y-m-d',$time);
		}
		return $mydate;
	}
	
	public function mr_edit_save()
	{
   		$timestamp = date('Y-m-d H:i:s', time());
							
		$id = $this->input->post('ID');
		$reg_id = $this->input->post('reg_id');
		$checkup_date = $this->conv_str_to_date($this->input->post('checkup_date'));
		$findings = $this->input->post('findings');
		$diagnosis = $this->input->post('diagnosis');
	
		$data = array(
			'reg_id' => $reg_id,
			'checkup_date' => $checkup_date,
			'findings' => $findings,
			'diagnosis' => $diagnosis,
			'lastmodified' => $timestamp  
		);
		
		$this->db->where('ID',$id);
		$res = $this->db->update('medical_records', $data); 
		
	
		if(!$res){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			return $errMess.$errNo;
		} else {// this executes when the query is successfull.. 
			return true;
		}//end else condition if query is successfull
	}
	
	public function mr_add_save()
	{
   		$timestamp = date('Y-m-d H:i:s', time());

		$reg_id = $this->input->post('reg_id');
		$checkup_date = $this->conv_str_to_date($this->input->post('checkup_date'));
		$findings = $this->input->post('findings');
		$diagnosis = $this->input->post('diagnosis');
	
		$data = array(
			'reg_id' => $reg_id,
			'checkup_date' => $checkup_date,
			'findings' => $findings,
			'diagnosis' => $diagnosis,
			'datecreated' => $timestamp  
		);
		
		$res = $this->db->insert('medical_records', $data); 
		$myid = $this->db->insert_id();
	
		if(!$res){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			return $errMess.$errNo;
		} else {// this executes when the query is successfull.. 
			return $myid;
		}//end else condition if query is successfull
	}
	
	function get_treatment($code)
	{
		$sqlCount = "select count(*) as xcount from treatment where mr_id = $code";
		$count = $this->db->query($sqlCount)->result();
		foreach($count as $c){
			$num = $c->xcount;
		}
		
			
		$sqlInfo = "select * from treatment where mr_id = $code";
		
		$queries = $this->db->query($sqlInfo)->result();
		$numRows = count($queries);
		
		$queries  = array(
						'sEcho' => '1',//$sEcho,
						'iTotalRecords' => $num,//total number of records in the db
						'iTotalDisplayRecords'=> $num,//total number of records after filtering
						'aaData' => $queries
						//'preview' => '<a href="##" id="id_doPreview"><img src="../img/magnifier.png"></a>'
					   );
		
		return json_encode( $queries );
	}
	
	function delete_treatment()
	{
		$code = $this->input->get('code');
		
		$data = array(
			'code' => $code
		);
		
		$qry = "delete from treatment where ID = ?";
		
		$res = $this->db->query($qry,$data);
		
		if(!$res){
		   $errNo   = $this->db->_error_number();
		   $errMess = $this->db->_error_message();
		   // Do something with the error message or just show_404();
		   echo $errMess;
		}
		else {
			return true;
		}
	}
	
	function add_treatment() {
		
		$data = array(
			'mr_id' => $this->input->post('mr_id'),
			'generic_id' => $this->input->post('generic_id'),
			'generic_desc' => $this->input->post('generic_desc'),
			'brand_id' => $this->input->post('brand_id'),
			'brand_desc' => $this->input->post('brand_desc'),
			'prep_id' => $this->input->post('prep_id'),
			'prep_desc' => $this->input->post('prep_desc'),
			'bottle_id' => $this->input->post('bottle_id'),
			'bottle_desc' => $this->input->post('bottle_desc'),
			'tablet_id' => $this->input->post('tablet_id'),
			'tablet_desc' => $this->input->post('tablet_desc'),
			'capsule_id' => $this->input->post('capsule_id'),
			'capsule_desc' => $this->input->post('capsule_desc'),
			'dosage_id' => $this->input->post('dosage_id'),
			'dosage_desc' => $this->input->post('dosage_desc'),
			'freq_id' => $this->input->post('freq_id'),
			'freq_desc' => $this->input->post('freq_desc'),
			'dur_id' => $this->input->post('duration_id'),
			'dur_desc' => $this->input->post('duration_desc')
		);
		
		$res = $this->db->insert('treatment', $data); 
		//$myid = $this->db->insert_id();
	
		if(!$res){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			return $errMess.$errNo;
		} else {// this executes when the query is successfull.. 
			return true;
		}//end else condition if query is successfull
	}
	
	function get_mr_treatment()
	{
		
		$code = $this->input->get('code');
	
		$qry = $this->db->query("SELECT * FROM treatment where ID = $code");
		
		if($qry){
			$rows = $qry->result();		  
			return $rows;
		}else{
			show_error('Treatment Record not Found!');
		}
		 
	}
	
	function edit_treatment() {
		
		$data = array(
			'mr_id' => $this->input->post('mr_id'),
			'generic_id' => $this->input->post('generic_id'),
			'generic_desc' => $this->input->post('generic_desc'),
			'brand_id' => $this->input->post('brand_id'),
			'brand_desc' => $this->input->post('brand_desc'),
			'prep_id' => $this->input->post('prep_id'),
			'prep_desc' => $this->input->post('prep_desc'),
			'bottle_id' => $this->input->post('bottle_id'),
			'bottle_desc' => $this->input->post('bottle_desc'),
			'tablet_id' => $this->input->post('tablet_id'),
			'tablet_desc' => $this->input->post('tablet_desc'),
			'capsule_id' => $this->input->post('capsule_id'),
			'capsule_desc' => $this->input->post('capsule_desc'),
			'dosage_id' => $this->input->post('dosage_id'),
			'dosage_desc' => $this->input->post('dosage_desc'),
			'freq_id' => $this->input->post('freq_id'),
			'freq_desc' => $this->input->post('freq_desc'),
			'dur_id' => $this->input->post('duration_id'),
			'dur_desc' => $this->input->post('duration_desc')
		);
		
		$this->db->where('ID',$this->input->post('treatment_id'));
		$res = $this->db->update('treatment', $data); 
	
		if(!$res){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			return $errMess.$errNo;
		} else {// this executes when the query is successfull.. 
			return true;
		}//end else condition if query is successfull
	}
	
}

