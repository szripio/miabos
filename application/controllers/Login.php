<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}
	
	public function index()
	{
		$this->load->view('templates/view_Header');
		$this->load->view('login');
		$this->load->view('templates/view_Footer');
		
	}
}
?>