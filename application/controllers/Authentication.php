<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');

	}
	
	public function index(){
	$this->load->library('form_validation');
	$this->form_validation->set_rules('user_name','Username','required');
	$this->form_validation->set_rules('user_passw','Password','required');
		if($this->form_validation->run() == TRUE)
		{
			$username = $this->input->post('user_name');
			$password = $this->input->post('user_passw');
			$user_id = $this->User_model->getUserId($username);		
			//$sanyi = $this->User_model->canLogin($username,$password);
			if($this->User_model->canLogin($username,$password,$user_id))
			{
				$session_data = array(
						'user_name' => $username,
						'id' => $user_id);
				$this->session->set_userdata($session_data);
				redirect(base_url().'welcome');
			}
			else
			{	
				$this->session->set_flashdata('error','Invalid username or password');
				redirect(base_url().'login');
			}
		}
		else
		{
			$this->load->view('templates/view_Header');
			$this->load->view('login');
			$this->load->view('templates/view_Footer');
		}
	}

}