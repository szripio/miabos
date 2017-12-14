<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mydatas extends CI_Controller {
	
	public function index(){
		if($this->session->has_userdata('id') != '')
		{
			$this->load->model('MyDatas_model');
			$this->load->model('User_model');
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			$username = $this->session->userdata["user_name"];
			$userid = $this->User_model->getUserId($username)['id'];
			$data["companydatas"] = $this->MyDatas_model->getDatas($userid);
			$companyid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
			$data["bankdatas"] = $this->MyDatas_model->getbankDatas($companyid);
			$data["counter"] = $this->MyDatas_model->countBankAccount($companyid);
			//de($data);
			$this->load->view('view_MyDatas',$data);
			$this->load->view('templates/view_Footer');
		}
		else 
		{
			$this->session->unset_userdata();
			redirect(base_url().'login');
		}
	}
	
	public function updateDatas()
	{
		if($this->session->has_userdata('id') != '')
		{
		$this->load->model('MyDatas_model');
		$this->load->model('User_model');
			if ($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('company_name','Név','required');
				$this->form_validation->set_rules('company_vatnumber','Adószám','required');
				$this->form_validation->set_rules('company_email','E-mail cim','required|valid_email');
				$this->form_validation->set_rules('company_zipcode','Irányitószám','required');
				$this->form_validation->set_rules('company_city','Település','required');
				$this->form_validation->set_rules('company_street','Közterület','required');
				$this->form_validation->set_rules('company_streettype','Közterület jellege','required');
				$this->form_validation->set_rules('company_housenumber','Házszám','required');
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				if($this->form_validation->run() == TRUE)
				{
					$username = $this->session->userdata["user_name"];
					$userid = $this->User_model->getUserId($username)['id'];
					$currentdate = date('Y-m-d H:i:s');
					$companyid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
					$mydata = array(
							"nev" => $this->input->post("company_name"),
							"adoszam" => $this->input->post("company_vatnumber"),
							"kozadoszam" => $this->input->post("company_euvatnumber"),
							"csopadoszam" => $this->input->post("company_groupvatnumber"),
							"email" => $this->input->post("company_email"),
							"apikey" => $this->input->post("company_apikey"),
							"reg_datum" => $this->input->post("company_regdate"),
							"cim_irszam" => $this->input->post("company_zipcode"),
							"cim_telepules" => $this->input->post("company_city"),
							"cim_kozternev" => $this->input->post("company_street"),
							"cim_kozterjelleg"	=> $this->input->post("company_streettype"),
							"cim_hazszam" => $this->input->post("company_housenumber"),
							"cim_egyeb" => $this->input->post("company_otheraddress"),
							"cim_orszag" => $this->input->post("company_country"),
							"cim_teljes" => $this->input->post("company_zipcode").
							' '.$this->input->post("company_city").
							' '.$this->input->post("company_street").
							' '.$this->input->post("company_streettype").
							' '.$this->input->post("company_housenumber").
							' '.$this->input->post("company_otheraddress"),
							"modositas_datum" => $currentdate,
							"modosito_user" => $username
					);
					/*$mydata = array (
						
					);*/
					$this->MyDatas_model->updateDatas($mydata,$companyid);
					redirect(base_url().'adatok');
					
				}
				else
				{
					$username = $this->session->userdata["user_name"];
					$userid = $this->User_model->getUserId($username)['id'];
					$mydata['companydatas'] = $this->MyDatas_model->getDatas($userid);
					$this->load->view('view_MyDatasForm',$mydata);
				}
			}
			else 
			{
				$username = $this->session->userdata["user_name"];
				$userid = $this->User_model->getUserId($username)['id'];
				$mydatas = $this->User_model->getCompanyId($userid);
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				$mydata['companydatas'] = $this->MyDatas_model->getDatas($userid);
				$this->load->view('view_MyDatasForm',$mydata);

			}
		}
		else 
		{
			$this->session->unset_userdata();
			redirect(base_url().'login');
		}
		
	}
	
}