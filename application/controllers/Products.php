<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function index(){
		if($this->session->has_userdata('id') != '')
		{
			$this->load->model('User_model');
			$this->load->model('Products_model');
			$username = $this->session->userdata["user_name"];
			$userid = $this->User_model->getUserId($username)['id'];
			$szolgaltatoid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
			$list["products"] = $this->Products_model->getProductList($szolgaltatoid);
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			$this->load->view('view_ProductsList',$list);
			$this->load->view('templates/view_Footer');
		}
		else
		{
			$this->session->unset_userdata();
			redirect(base_url().'login');			
		}
	}
	
	public function insertProduct(){
		if($this->session->has_userdata('id') != '')
		{
			$this->load->library('form_validation');
			$this->load->model('User_model');
			$this->load->model('Products_model');
			$this->load->model('VatDatas_model');
			
			$username = $this->session->userdata["user_name"];
			$userid = $this->User_model->getUserId($username)['id'];
			$currentdate = date('Y-m-d H:i:s');
			$companyid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
			$tpl['afakulcss'] = $this->VatDatas_model->getVatList($companyid);
			$this->form_validation->set_rules('product_name','Megnevezés','required');
			$this->form_validation->set_rules('product_quantity','Mennyiség','required');
			$this->form_validation->set_rules('product_unit_price','Nettó egységár','required');
			$this->form_validation->set_rules('product_net_value','Nettó ár','required');
			$this->form_validation->set_rules('product_vat_value','Áfa érték','required');
			$this->form_validation->set_rules('vat_rate_id','Áfakulcs','required');
			$this->form_validation->set_rules('product_gross_value','Bruttó ár','required');
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');

			if($this->form_validation->run() == TRUE)
				{
					/*$username = $this->session->userdata["user_name"];
					$userid = $this->User_model->getUserId($username)['id'];
					$currentdate = date('Y-m-d H:i:s');
					$companyid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
					$datas = $this->VatDatas_model->getVatList($companyid); */
					$datas = array (
							"szolgaltato_id" => $companyid,
							"termeknev" => $this->input->post("product_name"),
							"menny" => $this->input->post("product_quantity"),
							"mennyegys" => $this->input->post("product_quantity_unit"),
							"nettoegysegar" => $this->input->post("product_unit_price"),
							"nettoar" => $this->input->post("product_net_value"),
							"afaertek" => $this->input->post("product_vat_value"),
							"afakulcs_id" => $this->input->post("vat_rate_id"),
							"afakulcs" => $this->VatDatas_model->getVatnameById($this->input->post("vat_rate_id"))['megnevezes'],
							"bruttoar" => $this->input->post("product_gross_value"),
							"letrehozas_datum" => $currentdate,
							"letrehozo_user" => $username,
							"modositas_datum" => $currentdate,
							"modosito_user" => $username
					);
					//de($datas);
					$this->Products_model->insertProduct($datas);
					redirect(base_url().'products');						
				}
				else
				{
					$tpl["action"] = 1;
					$this->load->view("view_ProductForm",$tpl);
				}
				
		}
		else
		{
			$this->session->unset_userdata();
			redirect(base_url().'login');
		}
	}

	public function deleteProduct(){
		$id = $this->uri->segment(3);
		$this->load->model('Products_model');
		$this->Products_model->deleteProduct($id);
		redirect(base_url().'products/deleted');
	}
	
	public function deleted(){
		$this->index();
	}
	
	public function updateProduct(){
		if($this->session->has_userdata('id'))
		{
			$this->load->model('User_model');
			$this->load->model('VatDatas_model');
			$this->load->model('Products_model');
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('product_name','Megnevezés','required');
				$this->form_validation->set_rules('product_quantity','Mennyiség','required');
				$this->form_validation->set_rules('product_unit_price','Nettó egységár','required');
				$this->form_validation->set_rules('product_net_value','Nettó ár','required');
				$this->form_validation->set_rules('product_vat_value','Áfa érték','required');
				$this->form_validation->set_rules('vat_rate_id','Áfakulcs','required');
				$this->form_validation->set_rules('product_gross_value','Bruttó ár','required');
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				if($this->form_validation->run() == TRUE)
				{
					$username = $this->session->userdata["user_name"];
					$userid = $this->User_model->getUserId($username)['id'];
					$currentdate = date('Y-m-d H:i:s');
					$companyid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
					$productid = $this->input->post("hidden_id");
					$datas = array (
							"szolgaltato_id" => $companyid,
							"termeknev" => $this->input->post("product_name"),
							"menny" => $this->input->post("product_quantity"),
							"mennyegys" => $this->input->post("product_quantity_unit"),
							"nettoegysegar" => $this->input->post("product_unit_price"),
							"nettoar" => $this->input->post("product_net_value"),
							"afaertek" => $this->input->post("product_vat_value"),
							"afakulcs_id" => $this->input->post("vat_rate_id"),
							"afakulcs" => $this->VatDatas_model->getVatnameById($this->input->post("vat_rate_id"))['megnevezes'],
							"bruttoar" => $this->input->post("product_gross_value"),
							"letrehozas_datum" => $currentdate,
							"letrehozo_user" => $username,
							"modositas_datum" => $currentdate,
							"modosito_user" => $username
							);
					//de($datas);
					$this->Products_model->updateProduct($productid,$datas);
					redirect(base_url().'products');
				}
				else
				{
					$tpl['action'] = 2;
					$this->load->view('view_ProductForm',$tpl);
				}
			}
			else
			{
				$productid = $this->uri->segment(3);
				$datas["data"] = $this->Products_model->getProductById($productid);
				$datas["afakulcss"] = $this->VatDatas_model->getVatList($datas["data"]["szolgaltato_id"]);
				//de($datas);
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				$datas['action'] = 2;
				$this->load->view('view_ProductForm',$datas);
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
