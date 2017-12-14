<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	
	}
	
	public function index()
	{
		if($this->session->has_userdata('user_name')){
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			$this->load->view('view_Main');
			$this->load->view('templates/view_Footer');
		}
		else
		{
			redirect('login');	
		}
	}
	
	function logout(){
		session_unset('user_name');
		redirect('login');		
	}

}
?>