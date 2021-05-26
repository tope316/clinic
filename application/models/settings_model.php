<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_Model extends CI_Model {
	
	function get_settings()
	{
	
		$qry = $this->db->query("SELECT * from settings");
		
		if($qry){
			$rows = $qry->result();		  
			return $rows;
		}else{
			show_error('No Settings!');
		}
		 
	}
	
	public function settings_save()
	{
   		
		$license_no = $this->input->post('license_no');
		$ptr_no = $this->input->post('ptr_no');
		$s2_no = $this->input->post('s2_no');
	
		$data = array(
			'license_no' => $license_no,
			'ptr_no' => $ptr_no,
			's2_no' => $s2_no  
		);
		
		$res = $this->db->update('settings', $data); 
		
	
		if(!$res){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			return $errMess.$errNo;
		} else {// this executes when the query is successfull.. 
			return true;
		}//end else condition if query is successfull
	}
	
}

