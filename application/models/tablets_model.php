<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tablets_Model extends CI_Model {
	
	function get_data()
	{
		$sqlCount = "select count(*) as xcount from tablets";
		$count = $this->db->query($sqlCount)->result();
		foreach($count as $c){
			$num = $c->xcount;
		}
		
			
		$sqlInfo = "select ID, description from tablets WHERE 1=1";
		
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
	
	function del()
	{
		$code = $this->input->get('code');
		
		$data = array(
			'code' => $code
		);
		
		$qry = "delete from tablets where ID = ?";
		
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
	
	function get_record()
	{
		
		$code = $_GET['ID'];//to get the url value
	
		$qry = $this->db->query("Select ID, description FROM tablets where ID = $code");
		
		if($qry){
			$rows = $qry->result();		  
			return $rows;
		}else{
			show_error('Record not Found!');
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
	
	public function edit_save()
	{						
		$id = $this->input->post('ID');
		$description = $this->input->post('description');
	
		$data = array(
			'description' => $description  
		);
		
		$this->db->where('ID',$id);
		$res = $this->db->update('tablets', $data); 
		
	
		if(!$res){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			return $errMess.$errNo;
		} else {// this executes when the query is successfull.. 
			return true;
		}//end else condition if query is successfull
	}
	
	public function add_save()
	{

		$description = $this->input->post('description');
	
		$data = array(
			'description' => $description  
		);
		
		$res = $this->db->insert('tablets', $data); 
		
	
		if(!$res){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			return $errMess.$errNo;
		} else {// this executes when the query is successfull.. 
			return true;
		}//end else condition if query is successfull
	}
	
	function get_list()
	{			
		$qry = $this->db->query("select * from tablets WHERE 1=1");
		
		return $qry->result();
	}
	
}
