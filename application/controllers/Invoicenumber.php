<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoicenumber extends CI_Controller {

	public function index(){
		if ($this->session->has_userdata('id') != ''){
			$this->load->model('User_model');
			$this->load->model('Invoicenumber_model');
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			$username = $this->session->userdata["user_name"];
			//de($username);
			$userid = $this->User_model->getUserId($username)['id'];
			$szolgaltatoid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
			//de($szolgaltatoid);
			$data["list"] = $this->Invoicenumber_model->getInvoicenumberList($szolgaltatoid);
			$this->load->view('view_InvoicenumberList',$data);
			$this->load->view('templates/view_Footer');			
		}
		else
		{
			$this->session->unset_userdata();
			redirect(base_url().'login');	
		}
	}
	
	public function insertInvoicenumber(){
		if($this->session->has_userdata('id')!='')
		{
			$this->load->model('User_model');
			$this->load->model('Invoicenumber_model');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('invoicenumber_prefix','Előtag','required');
			$this->form_validation->set_rules('invoicenumber_suffix','Utótag','required');
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			if($this->form_validation->run() == TRUE){
				$username = $this->session->userdata["user_name"];
				$userid = $this->User_model->getUserId($username)['id'];
				$szolgaltatoid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
				$currentdate = date('Y-m-d h:m:s');
				$datas = array(
						"szolgaltato_id" => $szolgaltatoid,
						"prefix" => $this->input->post("invoicenumber_prefix"),
						"sorszam" => 1,
						"suffix" => $this->input->post("invoicenumber_suffix"),
						"letrehozas_datum" => $currentdate,
						"modositas_datum" => $currentdate,
						"letrehozo_user" => $username,
						"modosito_user" => $username
				);
				$this->Invoicenumber_model->insertInvoicenumber($datas);
				redirect(base_url().'invoicenumber');
			}
			else 
			{
				$this->load->view('view_InvoicenumberForm');
			}
		}
		else 
		{
			$this->session->unset_userdata();
			redirect(base_url().'login');
		}
	}
	
}