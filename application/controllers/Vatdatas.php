<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vatdatas extends CI_Controller {

	public function index(){

		if($this->session->has_userdata('id')!=''){
			$this->load->model('VatDatas_model');
			$this->load->model('User_model');
			$userid = $this->session->userdata["id"];
			$companyid = $this->User_model->getCompanyId($userid["id"])['szolgaltato_id'];
			$list["vatlist"] = $this->VatDatas_model->getVatList($companyid);
			//de($list);
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			$this->load->view('view_VatList',$list);
		}
		else
		{
			$this->logout();		
		}				
	}
	
	public function insertVatdata(){
		if($this->session->has_userdata('id')!=''){
		$this->load->model('VatDatas_model');
		$this->load->model('User_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('vat_name','Megnevezés','required');
		$this->form_validation->set_rules('vat_value','Érték','required|is_natural');
		$this->load->view('templates/view_Header');
		$this->load->view('templates/view_Sidebar');
		if($this->form_validation->run()==TRUE)
			{
				$username = $this->session->userdata["user_name"];
				$userid = $this->User_model->getUserId($username)['id'];
				$currentdate = date('Y-m-d H:i:s');
				$companyid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
				$datas = array (
					"szolgaltato_id" => $companyid,
					"megnevezes" => $this->input->post("vat_name"),
					"ertek" => $this->input->post("vat_value"),
					"letrehozas_datum" => $currentdate,
					"letrehozo_user" => $username,
					"modositas_datum" => $currentdate,
					"modosito_user" => $username
				);
				$this->VatDatas_model->insertVat($datas);
				redirect(base_url().'afatorzs');
			}
			else
			{
				$tpl["action"] = 1;
				$this->load->view("view_VatForm",$tpl);
			}
		}
		else
		{
			$this->logout();
		}	
		
	}

	public function deleteVatdatas(){
		$id = $this->uri->segment(3);
		$this->load->model('VatDatas_model');
		$this->VatDatas_model->deleteVat($id);
		redirect(base_url().'afatorzs/deleted');
	}
	
	public function deleted(){
		$this->index();
	}
	
	public function updateVatdata(){
		if($this->session->has_userdata('id'))
		{
		$this->load->model('User_model');
		$this->load->model('VatDatas_model');
		if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('vat_name','Megnevezés','required');
				$this->form_validation->set_rules('vat_value','Érték','required|is_natural');
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				if($this->form_validation->run() == TRUE)
				{
					$username = $this->session->userdata["user_name"];
					$userid = $this->User_model->getUserId($username)['id'];
					$currentdate = date('Y-m-d H:i:s');
					//$companyid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
					$vatid = $this->input->post("hidden_id");
					$datas = array (
							//"szolgaltato_id" => $companyid,
							"megnevezes" => $this->input->post("vat_name"),
							"ertek" => $this->input->post("vat_value"),
							"letrehozas_datum" => $currentdate,
							"letrehozo_user" => $username,
							"modositas_datum" => $currentdate,
							"modosito_user" => $username
					);
					$this->VatDatas_model->updateVat($vatid,$datas);
					redirect(base_url().'afatorzs');
				}
				else
				{
					$tpl['action'] = 2;
					$this->load->view('view_VatForm',$tpl);
				}
			}
			else
			{
				$vatid = $this->uri->segment(3);
				$datas["data"] = $this->VatDatas_model->getVatById($vatid);
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				$datas['action'] = 2;
				$this->load->view('view_VatForm',$datas);
			} 
		}
		else
		{
			$this->logout();			
		}
	}
	
	
	public function logout()
	{
		$this->session->unset_userdata();
		redirect(base_url().'login');
	}
	
}