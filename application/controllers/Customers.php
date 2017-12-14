<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Customers extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}
	
	public function index(){
		if($this->session->has_userdata('id')!=''){
			$this->load->model('Customers_model');
			$this->load->model('User_model');
			$username = $this->session->userdata["user_name"];
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			if ( $this->User_model->getUserId($username)['id'] == 1){
				$customer_data["customers"] = $this->Customers_model->getAllCustomer();
				$userid = $this->User_model->getUserId($username)['id'];
				$this->load->view('view_Customers',$customer_data);				
			}
			else 
			{
				$userid = $this->User_model->getUserId($username)['id'];
				$customer_data["latest_customers"] = $this->Customers_model->getLatestCustomers($userid);
				$customer_data["customers"] = $this->Customers_model->getCustomers($userid);
				$this->load->view('view_Customers',$customer_data);				
			}
			$this->load->view('templates/view_Footer');
		}
		else 
		{
			$this->session->unset_userdata();
			redirect('login');
		}
			
	}
	
	public function customerInsert(){
		if($this->session->has_userdata('id')!=''){
			$this->load->model('Customers_model');
			$this->load->model('User_model');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('customer_name','Név','required');
			$this->form_validation->set_rules('customer_vatnumber','Adószám','required');
			$this->form_validation->set_rules('customer_email','E-mail cim','required|valid_email');
			$this->form_validation->set_rules('customer_zipcode','Irányitószám','required');
			$this->form_validation->set_rules('customer_city','Település','required');
			$this->form_validation->set_rules('customer_street','Közterület','required');
			$this->form_validation->set_rules('customer_streettype','Közterület jellege','required');
			$this->form_validation->set_rules('customer_housenumber','Házszám','required');
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			if($this->form_validation->run() == TRUE)
			{
				$username = $this->session->userdata["user_name"];
				$userid = $this->User_model->getUserId($username)['id'];
				$companyid = $this->User_model->getCompanyId($userid)["szolgaltato_id"];
				$currentdate = date('Y-m-d H:i:s');
				$customerdata = array(
					"szolgaltato_id"  =>  $companyid,
					"cegnev" => $this->input->post("customer_name"),
					"adoszam" => $this->input->post("customer_vatnumber"),
					"kozadoszam" => $this->input->post("customer_euvatnumber"),
					"csopadoszam" => $this->input->post("customer_groupvatnumber"),
					"email" => $this->input->post("customer_email"),
					"email_tovabbiak" => $this->input->post("customer_otheremail"),
					"cim_irszam" => $this->input->post("customer_zipcode"),
					"cim_telepules" => $this->input->post("customer_city"),
					"cim_kozternev" => $this->input->post("customer_street"),
					"cim_kozterjelleg"	=> $this->input->post("customer_streettype"),
					"cim_hazszam" => $this->input->post("customer_housenumber"),
					"cim_egyeb" => $this->input->post("customer_otheraddress"),
					"cim_orszag" => $this->input->post("customer_country"),
					"cim_teljes" => $this->input->post("customer_zipcode").
									' '.$this->input->post("customer_city").
									' '.$this->input->post("customer_street").
									' '.$this->input->post("customer_streettype").
									' '.$this->input->post("customer_housenumber").
									' '.$this->input->post("customer_otheraddress"),
					"reg_datum" => $this->input->post("customer_regdate"),
					"letrehozas_datum" => $currentdate,
					"modositas_datum" => $currentdate,
					"letrehozo_user" => $username,
					"modosito_user" => $username 
				);
				$this->Customers_model->insertCustomer($customerdata);
				redirect(base_url().'customers');
			}
			else 
			{
				$tpl['action'] = 1;
				$this->load->view('view_CustomerForm',$tpl);
			}
			$this->load->view('templates/view_Footer');
		}
		else
		{
			$this->session->unset_userdata();
			redirect('login');	
		}
			
	}
	
	public function deleteCustomer(){
		$id = $this->uri->segment(3);
		$this->load->model('Customers_model');
		$this->Customers_model->deleteCustomer($id);
		redirect(base_url().'deleted');
	}
	
	public function deleted(){
		$this->index();
	}
	
	public function updateCustomer(){
		if($this->session->has_userdata('id')!=''){
			$this->load->model('Customers_model');
			$this->load->model('User_model');
			if ($_POST)
				{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('customer_name','Név','required');
				$this->form_validation->set_rules('customer_vatnumber','Adószám','required');
				$this->form_validation->set_rules('customer_email','E-mail cim','required|valid_email');
				$this->form_validation->set_rules('customer_zipcode','Irányitószám','required');
				$this->form_validation->set_rules('customer_city','Település','required');
				$this->form_validation->set_rules('customer_street','Közterület','required');
				$this->form_validation->set_rules('customer_streettype','Közterület jellege','required');
				$this->form_validation->set_rules('customer_housenumber','Házszám','required');
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				if($this->form_validation->run() == TRUE)
				{
					$username = $this->session->userdata["user_name"];
					$userid = $this->User_model->getUserId($username)['id'];
					$currentdate = date('Y-m-d H:i:s');
					$customerid = $this->input->post("hidden_id");
					$customerdata = array(
							"cegnev" => $this->input->post("customer_name"),
							"adoszam" => $this->input->post("customer_vatnumber"),
							"kozadoszam" => $this->input->post("customer_euvatnumber"),
							"csopadoszam" => $this->input->post("customer_groupvatnumber"),
							"email" => $this->input->post("customer_email"),
							"email_tovabbiak" => $this->input->post("customer_otheremail"),
							"cim_irszam" => $this->input->post("customer_zipcode"),
							"cim_telepules" => $this->input->post("customer_city"),
							"cim_kozternev" => $this->input->post("customer_street"),
							"cim_kozterjelleg"	=> $this->input->post("customer_streettype"),
							"cim_hazszam" => $this->input->post("customer_housenumber"),
							"cim_egyeb" => $this->input->post("customer_otheraddress"),
							"cim_orszag" => $this->input->post("customer_country"),
							"cim_teljes" => $this->input->post("customer_zipcode").
							' '.$this->input->post("customer_city").
							' '.$this->input->post("customer_street").
							' '.$this->input->post("customer_streettype").
							' '.$this->input->post("customer_housenumber").
							' '.$this->input->post("customer_otheraddress"),
							"reg_datum" => $this->input->post("customer_regdate"),
							"modositas_datum" => $currentdate,
							"modosito_user" => $username
					);

					$this->Customers_model->updateCustomer($customerdata,$customerid);
					redirect(base_url().'customers');
				}
				else
				{
					$tpl['action'] = 2;
					$this->load->view('view_CustomerForm',$tpl);
					//echo 'anyád1';
				}
			}
			else
			{
				$username = $this->session->userdata["user_name"];
				$userid = $this->User_model->getUserId($username)['id'];
				$customerid = $this->uri->segment(3);
				$customerdata["customerdata"] = $this->Customers_model->getCustomerId($customerid);
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				$customerdata['action'] = 2;
				$this->load->view('view_CustomerForm',$customerdata);
			}				
		}
		else 
		{
			redirect(base_url().'login');
		}

	}
}
?>