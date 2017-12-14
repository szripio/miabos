<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dataimport extends CI_Controller {
	
	public function index(){
		if($this->session->has_userdata('id')!=''){
			$this->load->model('Customers_model');
			$this->load->model('User_model');
			$this->load->model('DataImport_model');
			//$data['data'] = $this->DataImport_model->getCustomersWithoutInvoiceQuantity();
			//de($data[0]['id']);
			$username = $this->session->userdata["user_name"];
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			$this->load->view('view_DataImport');
			$this->load->view('templates/view_Footer');
		}
		else
		{
			$this->session->unset_userdata();
			redirect('login');
		}
			
	}
	
	public function invoiceQuantityImport(){
			if($this->session->has_userdata('id')!=''){
			$this->load->model('Customers_model');
			$this->load->model('User_model');
			$this->load->model('DataImport_model');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('importdata_year','Év','required');
			$this->form_validation->set_rules('importdata_month','Hónap','required');
			$this->form_validation->set_rules('importdata_quantity','Darabszám','required|is_natural');
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			if($this->form_validation->run() == TRUE)
			{
				$username = $this->session->userdata["user_name"];
				$userid = $this->User_model->getUserId($username)['id'];
				$companyid = $this->User_model->getCompanyId($userid)["szolgaltato_id"];
				$currentdate = date('Y-m-d H:i:s');
				$honap = $this->input->post("importdata_month");
				$ev = $this->input->post("importdata_year");
				$data = $this->DataImport_model->getCustomersWithoutInvoiceQuantity($honap,$ev,$companyid);
				foreach ($data as $id){
					$dataimport = array(
							"szolgaltato_id"  => $companyid,
							"ugyfel_id" => $id['id'],
							"termek_id" => 1,
							"ev" => $ev,
							"honap" => $honap,
							"darabszam" => $this->input->post("importdata_quantity"),
							"letrehozas_datum" => $currentdate,
							"modositas_datum" => $currentdate,
							"letrehozo_user" => $username,
							"modosito_user" => $username
					);
					$this->DataImport_model->insertInvoiceQuantity($dataimport);
				}
				redirect(base_url().'dataimport');
			}
			else 
			{
				$tpl['action'] = 1;
				$this->load->view('view_InvoiceQuantityDataImport',$tpl);
			}
			$this->load->view('templates/view_Footer');
		}
		else
		{
			$this->session->unset_userdata();
			redirect('login');	
		}
	}
	
	public function getCustomerList(){
		
	}
}