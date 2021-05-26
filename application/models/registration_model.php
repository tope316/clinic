<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration_Model extends CI_Model {

	function get_registration_list_dashboard()
	{
		$sqlCount = "select count(*) as xcount from registration";
		$count = $this->db->query($sqlCount)->result();
		foreach($count as $c){
			$num = $c->xcount;
		}
		
			
		$sqlInfo = "select ID, fullname, DATE_FORMAT(birthdate,'%m/%d/%Y') as birthdate from registration WHERE 1=1";
		
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
		
		$qry = "delete from registration where ID = ?";
		
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
	
	function get_registration()
	{
		
		$code = $_GET['ID'];//to get the url value
	
		$qry = $this->db->query("Select ID, fullname, DATE_FORMAT(birthdate,'%m/%d/%Y') as birthdate, sex, phone, mobile, fathers_name, mothers_name, address, delivery, bw, bl, hc, hosp, newborn_period, 
			DATE_FORMAT(bcg_date_1,'%m/%d/%Y') as bcg_date_1,
			DATE_FORMAT(hepa_b_date_1,'%m/%d/%Y') as hepa_b_date_1,
			DATE_FORMAT(hepa_b_date_2,'%m/%d/%Y') as hepa_b_date_2,
			DATE_FORMAT(hepa_b_date_3,'%m/%d/%Y') as hepa_b_date_3,
			DATE_FORMAT(hepa_b_date_4,'%m/%d/%Y') as hepa_b_date_4,
			DATE_FORMAT(dpt_date_1,'%m/%d/%Y') as dpt_date_1,
			DATE_FORMAT(dpt_date_2,'%m/%d/%Y') as dpt_date_2,
			DATE_FORMAT(dpt_date_3,'%m/%d/%Y') as dpt_date_3,
			DATE_FORMAT(dpt_date_4,'%m/%d/%Y') as dpt_date_4,
			DATE_FORMAT(dpt_date_5,'%m/%d/%Y') as dpt_date_5,
			DATE_FORMAT(opv_date_1,'%m/%d/%Y') as opv_date_1,
			DATE_FORMAT(opv_date_2,'%m/%d/%Y') as opv_date_2,
			DATE_FORMAT(opv_date_3,'%m/%d/%Y') as opv_date_3,
			DATE_FORMAT(opv_date_4,'%m/%d/%Y') as opv_date_4,
			DATE_FORMAT(opv_date_5,'%m/%d/%Y') as opv_date_5,
			DATE_FORMAT(hib_date_1,'%m/%d/%Y') as hib_date_1,
			DATE_FORMAT(hib_date_2,'%m/%d/%Y') as hib_date_2,
			DATE_FORMAT(hib_date_3,'%m/%d/%Y') as hib_date_3,
			DATE_FORMAT(hib_date_4,'%m/%d/%Y') as hib_date_4,
			DATE_FORMAT(measle_date_1,'%m/%d/%Y') as measle_date_1,
			DATE_FORMAT(rota_date_1,'%m/%d/%Y') as rota_date_1,
			DATE_FORMAT(rota_date_2,'%m/%d/%Y') as rota_date_2,
			DATE_FORMAT(rota_date_3,'%m/%d/%Y') as rota_date_3,
			DATE_FORMAT(typhoid_date_1,'%m/%d/%Y') as typhoid_date_1,
			DATE_FORMAT(influenza_date_1,'%m/%d/%Y') as influenza_date_1,
			DATE_FORMAT(influenza_date_2,'%m/%d/%Y') as influenza_date_2,
			DATE_FORMAT(influenza_date_3,'%m/%d/%Y') as influenza_date_3,
			DATE_FORMAT(influenza_date_4,'%m/%d/%Y') as influenza_date_4,
			DATE_FORMAT(influenza_date_5,'%m/%d/%Y') as influenza_date_5,
			DATE_FORMAT(influenza_date_6,'%m/%d/%Y') as influenza_date_6,
			DATE_FORMAT(varicella_date_1,'%m/%d/%Y') as varicella_date_1,
			DATE_FORMAT(varicella_date_2,'%m/%d/%Y') as varicella_date_2,
			DATE_FORMAT(hepa_a_date_1,'%m/%d/%Y') as hepa_a_date_1,
			DATE_FORMAT(hepa_a_date_2,'%m/%d/%Y') as hepa_a_date_2,
			DATE_FORMAT(hepa_a_date_3,'%m/%d/%Y') as hepa_a_date_3,
			DATE_FORMAT(pcv_date_1,'%m/%d/%Y') as pcv_date_1,
			DATE_FORMAT(pcv_date_2,'%m/%d/%Y') as pcv_date_2,
			DATE_FORMAT(pcv_date_3,'%m/%d/%Y') as pcv_date_3,
			DATE_FORMAT(pcv_date_4,'%m/%d/%Y') as pcv_date_4,
			DATE_FORMAT(pneumo_date_1,'%m/%d/%Y') as pneumo_date_1,
			DATE_FORMAT(pneumo_date_2,'%m/%d/%Y') as pneumo_date_2,
			DATE_FORMAT(mmr_date_1,'%m/%d/%Y') as mmr_date_1,
			DATE_FORMAT(mmr_date_2,'%m/%d/%Y') as mmr_date_2,
			DATE_FORMAT(meningo_date_1,'%m/%d/%Y') as meningo_date_1,
			DATE_FORMAT(hpv_date_1,'%m/%d/%Y') as hpv_date_1,
			DATE_FORMAT(hpv_date_2,'%m/%d/%Y') as hpv_date_2,
			DATE_FORMAT(hpv_date_3,'%m/%d/%Y') as hpv_date_3
			FROM registration where ID = $code");
		
		if($qry){
			$rows = $qry->result();		  
			return $rows;
		}else{
			show_error('Registration not Found!');
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
	
	public function registration_edit_save()
	{
   		$timestamp = date('Y-m-d H:i:s', time());
							
		$id = $this->input->post('ID');
		$fullname = $this->input->post('fullname');
		$birthdate = $this->conv_str_to_date($this->input->post('birthdate'));
		$sex = $this->input->post('sex');
		$phone = $this->input->post('phone');
		$mobile = $this->input->post('mobile');
		$fathers_name = $this->input->post('fathers_name');
		$mothers_name = $this->input->post('mothers_name');
		$address = $this->input->post('address');
		$delivery = $this->input->post('delivery');
		$bw = $this->input->post('bw');
		$bl = $this->input->post('bl');
		$hc = $this->input->post('hc');
		$hosp = $this->input->post('hosp');
		$newborn_period = $this->input->post('newborn_period');
		
		$bcg_date_1 = $this->conv_str_to_date($this->input->post('bcg_date_1'));
		$hepa_b_date_1 = $this->conv_str_to_date($this->input->post('hepa_b_date_1'));
		$hepa_b_date_2 = $this->conv_str_to_date($this->input->post('hepa_b_date_2'));
		$hepa_b_date_3 = $this->conv_str_to_date($this->input->post('hepa_b_date_3'));
		$hepa_b_date_4 = $this->conv_str_to_date($this->input->post('hepa_b_date_4'));
		$dpt_date_1 = $this->conv_str_to_date($this->input->post('dpt_date_1'));
		$dpt_date_2 = $this->conv_str_to_date($this->input->post('dpt_date_2'));
		$dpt_date_3 = $this->conv_str_to_date($this->input->post('dpt_date_3'));
		$dpt_date_4 = $this->conv_str_to_date($this->input->post('dpt_date_4'));
		$dpt_date_5 = $this->conv_str_to_date($this->input->post('dpt_date_5'));
		$opv_date_1 = $this->conv_str_to_date($this->input->post('opv_date_1'));
		$opv_date_2 = $this->conv_str_to_date($this->input->post('opv_date_2'));
		$opv_date_3 = $this->conv_str_to_date($this->input->post('opv_date_3'));
		$opv_date_4 = $this->conv_str_to_date($this->input->post('opv_date_4'));
		$opv_date_5 = $this->conv_str_to_date($this->input->post('opv_date_5'));
		$hib_date_1 = $this->conv_str_to_date($this->input->post('hib_date_1'));
		$hib_date_2 = $this->conv_str_to_date($this->input->post('hib_date_2'));
		$hib_date_3 = $this->conv_str_to_date($this->input->post('hib_date_3'));
		$hib_date_4 = $this->conv_str_to_date($this->input->post('hib_date_4'));
		$measle_date_1 = $this->conv_str_to_date($this->input->post('measle_date_1'));
		$rota_date_1 = $this->conv_str_to_date($this->input->post('rota_date_1'));
		$rota_date_2 = $this->conv_str_to_date($this->input->post('rota_date_2'));
		$rota_date_3 = $this->conv_str_to_date($this->input->post('rota_date_3'));
		$typhoid_date_1 = $this->conv_str_to_date($this->input->post('typhoid_date_1'));
		$influenza_date_1 = $this->conv_str_to_date($this->input->post('influenza_date_1'));
		$influenza_date_2 = $this->conv_str_to_date($this->input->post('influenza_date_2'));
		$influenza_date_3 = $this->conv_str_to_date($this->input->post('influenza_date_3'));
		$influenza_date_4 = $this->conv_str_to_date($this->input->post('influenza_date_4'));
		$influenza_date_5 = $this->conv_str_to_date($this->input->post('influenza_date_5'));
		$influenza_date_6 = $this->conv_str_to_date($this->input->post('influenza_date_6'));
		$varicella_date_1 = $this->conv_str_to_date($this->input->post('varicella_date_1'));
		$varicella_date_2 = $this->conv_str_to_date($this->input->post('varicella_date_2'));
		$hepa_a_date_1 = $this->conv_str_to_date($this->input->post('hepa_a_date_1'));
		$hepa_a_date_2 = $this->conv_str_to_date($this->input->post('hepa_a_date_2'));
		$hepa_a_date_3 = $this->conv_str_to_date($this->input->post('hepa_a_date_3'));
		$pcv_date_1 = $this->conv_str_to_date($this->input->post('pcv_date_1'));
		$pcv_date_2 = $this->conv_str_to_date($this->input->post('pcv_date_2'));
		$pcv_date_3 = $this->conv_str_to_date($this->input->post('pcv_date_3'));
		$pcv_date_4 = $this->conv_str_to_date($this->input->post('pcv_date_4'));
		$pneumo_date_1 = $this->conv_str_to_date($this->input->post('pneumo_date_1'));
		$pneumo_date_2 = $this->conv_str_to_date($this->input->post('pneumo_date_2'));
		$mmr_date_1 = $this->conv_str_to_date($this->input->post('mmr_date_1'));
		$mmr_date_2 = $this->conv_str_to_date($this->input->post('mmr_date_2'));
		$meningo_date_1 = $this->conv_str_to_date($this->input->post('meningo_date_1'));
		$hpv_date_1 = $this->conv_str_to_date($this->input->post('hpv_date_1'));
		$hpv_date_2 = $this->conv_str_to_date($this->input->post('hpv_date_2'));
		$hpv_date_3 = $this->conv_str_to_date($this->input->post('hpv_date_3'));
	
		$data = array(
			'fullname' => $fullname,
			'birthdate' => $birthdate,
			'sex' => $sex,
			'phone' => $phone,
			'mobile' => $mobile,
			'fathers_name' => $fathers_name,
			'mothers_name' => $mothers_name,
			'address' => $address,
			'delivery' => $delivery,
			'bw' => $bw,
			'bl' => $bl,
			'hc' => $hc,
			'hosp' => $hosp,
			'newborn_period' => $newborn_period,
			'bcg_date_1' => $bcg_date_1,
			'hepa_b_date_1' => $hepa_b_date_1,
			'hepa_b_date_2' => $hepa_b_date_2,
			'hepa_b_date_3' => $hepa_b_date_3,
			'hepa_b_date_4' => $hepa_b_date_4,
			'dpt_date_1' => $dpt_date_1,
			'dpt_date_2' => $dpt_date_2,
			'dpt_date_3' => $dpt_date_3,
			'dpt_date_4' => $dpt_date_4,
			'dpt_date_5' => $dpt_date_5,
			'opv_date_1' => $opv_date_1,
			'opv_date_2' => $opv_date_2,
			'opv_date_3' => $opv_date_3,
			'opv_date_4' => $opv_date_4,
			'opv_date_5' => $opv_date_5,
			'hib_date_1' => $hib_date_1,
			'hib_date_2' => $hib_date_2,
			'hib_date_3' => $hib_date_3,
			'hib_date_4' => $hib_date_4,
			'measle_date_1' => $measle_date_1,
			'rota_date_1' => $rota_date_1,
			'rota_date_2' => $rota_date_2,
			'rota_date_3' => $rota_date_3,
			'typhoid_date_1' => $typhoid_date_1,
			'influenza_date_1' => $influenza_date_1,
			'influenza_date_2' => $influenza_date_2,
			'influenza_date_3' => $influenza_date_3,
			'influenza_date_4' => $influenza_date_4,
			'influenza_date_5' => $influenza_date_5,
			'influenza_date_6' => $influenza_date_6,
			'varicella_date_1' => $varicella_date_1,
			'varicella_date_2' => $varicella_date_2,
			'hepa_a_date_1' => $hepa_a_date_1,
			'hepa_a_date_2' => $hepa_a_date_2,
			'hepa_a_date_3' => $hepa_a_date_3,
			'pcv_date_1' => $pcv_date_1,
			'pcv_date_2' => $pcv_date_2,
			'pcv_date_3' => $pcv_date_3,
			'pcv_date_4' => $pcv_date_4,
			'pneumo_date_1' => $pneumo_date_1,
			'pneumo_date_2' => $pneumo_date_2,
			'mmr_date_1' => $mmr_date_1,
			'mmr_date_2' => $mmr_date_2,
			'meningo_date_1' => $meningo_date_1,
			'hpv_date_1' => $hpv_date_1,
			'hpv_date_2' => $hpv_date_2,
			'hpv_date_3' => $hpv_date_3,
			'lastmodified' => $timestamp  
		);
		
		$this->db->where('ID',$id);
		$res = $this->db->update('registration', $data); 
		
	
		if(!$res){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			return $errMess.$errNo;
		} else {// this executes when the query is successfull.. 
			return true;
		}//end else condition if query is successfull
	}
	
	public function registration_add_save()
	{
   		$timestamp = date('Y-m-d H:i:s', time());

		$fullname = $this->input->post('fullname');
		$birthdate = $this->conv_str_to_date($this->input->post('birthdate'));
		$sex = $this->input->post('sex');
		$phone = $this->input->post('phone');
		$mobile = $this->input->post('mobile');
		$fathers_name = $this->input->post('fathers_name');
		$mothers_name = $this->input->post('mothers_name');
		$address = $this->input->post('address');
		$delivery = $this->input->post('delivery');
		$bw = $this->input->post('bw');
		$bl = $this->input->post('bl');
		$hc = $this->input->post('hc');
		$hosp = $this->input->post('hosp');
		$newborn_period = $this->input->post('newborn_period');
		
		$bcg_date_1 = $this->conv_str_to_date($this->input->post('bcg_date_1'));
		$hepa_b_date_1 = $this->conv_str_to_date($this->input->post('hepa_b_date_1'));
		$hepa_b_date_2 = $this->conv_str_to_date($this->input->post('hepa_b_date_2'));
		$hepa_b_date_3 = $this->conv_str_to_date($this->input->post('hepa_b_date_3'));
		$hepa_b_date_4 = $this->conv_str_to_date($this->input->post('hepa_b_date_4'));
		$dpt_date_1 = $this->conv_str_to_date($this->input->post('dpt_date_1'));
		$dpt_date_2 = $this->conv_str_to_date($this->input->post('dpt_date_2'));
		$dpt_date_3 = $this->conv_str_to_date($this->input->post('dpt_date_3'));
		$dpt_date_4 = $this->conv_str_to_date($this->input->post('dpt_date_4'));
		$dpt_date_5 = $this->conv_str_to_date($this->input->post('dpt_date_5'));
		$opv_date_1 = $this->conv_str_to_date($this->input->post('opv_date_1'));
		$opv_date_2 = $this->conv_str_to_date($this->input->post('opv_date_2'));
		$opv_date_3 = $this->conv_str_to_date($this->input->post('opv_date_3'));
		$opv_date_4 = $this->conv_str_to_date($this->input->post('opv_date_4'));
		$opv_date_5 = $this->conv_str_to_date($this->input->post('opv_date_5'));
		$hib_date_1 = $this->conv_str_to_date($this->input->post('hib_date_1'));
		$hib_date_2 = $this->conv_str_to_date($this->input->post('hib_date_2'));
		$hib_date_3 = $this->conv_str_to_date($this->input->post('hib_date_3'));
		$hib_date_4 = $this->conv_str_to_date($this->input->post('hib_date_4'));
		$measle_date_1 = $this->conv_str_to_date($this->input->post('measle_date_1'));
		$rota_date_1 = $this->conv_str_to_date($this->input->post('rota_date_1'));
		$rota_date_2 = $this->conv_str_to_date($this->input->post('rota_date_2'));
		$rota_date_3 = $this->conv_str_to_date($this->input->post('rota_date_3'));
		$typhoid_date_1 = $this->conv_str_to_date($this->input->post('typhoid_date_1'));
		$influenza_date_1 = $this->conv_str_to_date($this->input->post('influenza_date_1'));
		$influenza_date_2 = $this->conv_str_to_date($this->input->post('influenza_date_2'));
		$influenza_date_3 = $this->conv_str_to_date($this->input->post('influenza_date_3'));
		$influenza_date_4 = $this->conv_str_to_date($this->input->post('influenza_date_4'));
		$influenza_date_5 = $this->conv_str_to_date($this->input->post('influenza_date_5'));
		$influenza_date_6 = $this->conv_str_to_date($this->input->post('influenza_date_6'));
		$varicella_date_1 = $this->conv_str_to_date($this->input->post('varicella_date_1'));
		$varicella_date_2 = $this->conv_str_to_date($this->input->post('varicella_date_2'));
		$hepa_a_date_1 = $this->conv_str_to_date($this->input->post('hepa_a_date_1'));
		$hepa_a_date_2 = $this->conv_str_to_date($this->input->post('hepa_a_date_2'));
		$hepa_a_date_3 = $this->conv_str_to_date($this->input->post('hepa_a_date_3'));
		$pcv_date_1 = $this->conv_str_to_date($this->input->post('pcv_date_1'));
		$pcv_date_2 = $this->conv_str_to_date($this->input->post('pcv_date_2'));
		$pcv_date_3 = $this->conv_str_to_date($this->input->post('pcv_date_3'));
		$pcv_date_4 = $this->conv_str_to_date($this->input->post('pcv_date_4'));
		$pneumo_date_1 = $this->conv_str_to_date($this->input->post('pneumo_date_1'));
		$pneumo_date_2 = $this->conv_str_to_date($this->input->post('pneumo_date_2'));
		$mmr_date_1 = $this->conv_str_to_date($this->input->post('mmr_date_1'));
		$mmr_date_2 = $this->conv_str_to_date($this->input->post('mmr_date_2'));
		$meningo_date_1 = $this->conv_str_to_date($this->input->post('meningo_date_1'));
		$hpv_date_1 = $this->conv_str_to_date($this->input->post('hpv_date_1'));
		$hpv_date_2 = $this->conv_str_to_date($this->input->post('hpv_date_2'));
		$hpv_date_3 = $this->conv_str_to_date($this->input->post('hpv_date_3'));
	
		$data = array(
			'fullname' => $fullname,
			'birthdate' => $birthdate,
			'sex' => $sex,
			'phone' => $phone,
			'mobile' => $mobile,
			'fathers_name' => $fathers_name,
			'mothers_name' => $mothers_name,
			'address' => $address,
			'delivery' => $delivery,
			'bw' => $bw,
			'bl' => $bl,
			'hc' => $hc,
			'hosp' => $hosp,
			'newborn_period' => $newborn_period,
			'bcg_date_1' => $bcg_date_1,
			'hepa_b_date_1' => $hepa_b_date_1,
			'hepa_b_date_2' => $hepa_b_date_2,
			'hepa_b_date_3' => $hepa_b_date_3,
			'hepa_b_date_4' => $hepa_b_date_4,
			'dpt_date_1' => $dpt_date_1,
			'dpt_date_2' => $dpt_date_2,
			'dpt_date_3' => $dpt_date_3,
			'dpt_date_4' => $dpt_date_4,
			'dpt_date_5' => $dpt_date_5,
			'opv_date_1' => $opv_date_1,
			'opv_date_2' => $opv_date_2,
			'opv_date_3' => $opv_date_3,
			'opv_date_4' => $opv_date_4,
			'opv_date_5' => $opv_date_5,
			'hib_date_1' => $hib_date_1,
			'hib_date_2' => $hib_date_2,
			'hib_date_3' => $hib_date_3,
			'hib_date_4' => $hib_date_4,
			'measle_date_1' => $measle_date_1,
			'rota_date_1' => $rota_date_1,
			'rota_date_2' => $rota_date_2,
			'rota_date_3' => $rota_date_3,
			'typhoid_date_1' => $typhoid_date_1,
			'influenza_date_1' => $influenza_date_1,
			'influenza_date_2' => $influenza_date_2,
			'influenza_date_3' => $influenza_date_3,
			'influenza_date_4' => $influenza_date_4,
			'influenza_date_5' => $influenza_date_5,
			'influenza_date_6' => $influenza_date_6,
			'varicella_date_1' => $varicella_date_1,
			'varicella_date_2' => $varicella_date_2,
			'hepa_a_date_1' => $hepa_a_date_1,
			'hepa_a_date_2' => $hepa_a_date_2,
			'hepa_a_date_3' => $hepa_a_date_3,
			'pcv_date_1' => $pcv_date_1,
			'pcv_date_2' => $pcv_date_2,
			'pcv_date_3' => $pcv_date_3,
			'pcv_date_4' => $pcv_date_4,
			'pneumo_date_1' => $pneumo_date_1,
			'pneumo_date_2' => $pneumo_date_2,
			'mmr_date_1' => $mmr_date_1,
			'mmr_date_2' => $mmr_date_2,
			'meningo_date_1' => $meningo_date_1,
			'hpv_date_1' => $hpv_date_1,
			'hpv_date_2' => $hpv_date_2,
			'hpv_date_3' => $hpv_date_3,
			'datecreated' => $timestamp  
		);
		
		$res = $this->db->insert('registration', $data); 
		
	
		if(!$res){
			$errNo   = $this->db->_error_number();
			$errMess = $this->db->_error_message();
			return $errMess.$errNo;
		} else {// this executes when the query is successfull.. 
			return true;
		}//end else condition if query is successfull
	}
	
}

