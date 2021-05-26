<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	function login_function(){

		$data = $this->input->post('data');
		$data = stripslashes($data);
		$json = json_decode($data);

		$username  = $json->{"username"};
		$password  = $json->{"password"};
		
		$checker = 0;
	
		$query = $this->db->query("SELECT * FROM security WHERE username = '$username' AND password = '$password'");

		foreach ($query->result() as $row)
		{

			$user_info = array(
		
			'fullname' 		=> $row->fullname,
			'is_logged_in'  => 1,
			'active'        => 0
			);
	
			$this->session->set_userdata($user_info);
			$checker = 1;
			
			$this->load->helper('cookie');
			$this->input->set_cookie('user', md5($username),7200);
							
		}

	
		echo $checker;

	}


}

