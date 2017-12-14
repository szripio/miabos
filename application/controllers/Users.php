<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}
	
	public function index(){
		if($this->session->has_userdata('id')!=''){
			$this->load->model('User_model');
			$username = $this->session->userdata('user_name');
			$data["user_data"] = $this->User_model->usersByCompany($username);
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			if ($this->session->userdata["user_name"] == "superadmin")
			{
				$data["user_data"] = $this->User_model->getAllUser();
			}
			$this->load->view('view_UserList', $data);
			$this->load->view('templates/view_Footer');
		}
		else {
			$this->session->unset_userdata();
			redirect('login');
		}
			
	}
}
?>