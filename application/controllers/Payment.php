<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function index(){
		if($this->session->has_userdata('id') != ''){
			$this->load->model('User_model');
			$this->load->model('Payment_model');
			$username = $this->session->userdata["user_name"];			
			$userid = $this->User_model->getUserId($username)['id'];
			$szolgaltatoid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
			$paymentlist["list"] = $this->Payment_model->getPaymentList($szolgaltatoid);
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			$this->load->view('view_PaymentList',$paymentlist);
			$this->load->view('templates/view_Footer');
		}
		else
		{
			$this->logout();
		}
	}
	
	public function insertPayment(){
		if($this->session->has_userdata('id') != '')
		{
			$this->load->library('form_validation');
			$this->load->model('User_model');
			$this->load->model('Payment_model');
			$this->form_validation->set_rules('payment_name','Megnevezés','required');
			$this->form_validation->set_rules('payment_value','Érték','required|is_natural');
			$this->load->view('templates/view_Header');
			$this->load->view('templates/view_Sidebar');
			if($this->form_validation->run() == TRUE){
				$username = $this->session->userdata["user_name"];
				$userid = $this->User_model->getUserId($username)['id'];
				$companyid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
				$currentdate = date('Y-m-d H:i:s');
				$datas = array (
					"szolgaltato_id" => $companyid,
					"megnevezes" => $this->input->post('payment_name'),
					"eltolas" => $this->input->post('payment_value'),
					"letrehozas_datum" => $currentdate,
					"modositas_datum" => $currentdate,
					"letrehozo_user" => $username,
					"modosito_user" => $username
				);
				//de($datas);
				$this->Payment_model->insertPaymentDatas($datas);
				redirect(base_url().'payment');
			}
			else 
			{
				$tpl["action"] = 1;
				$this->load->view('view_PaymentForm',$tpl);
			}
		}
		else 
		{
			$this->logout();	
		}
	}
	
	public function updatePayment(){
		if($this->session->has_userdata('id'))
		{
			$this->load->model('User_model');
			$this->load->model('Payment_model');
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('payment_name','Megnevezés','required');
				$this->form_validation->set_rules('payment_value','Érték','required|is_natural');
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				if($this->form_validation->run() == TRUE)
				{
					$username = $this->session->userdata["user_name"];
					$userid = $this->User_model->getUserId($username)['id'];
					$currentdate = date('Y-m-d H:i:s');
					//$companyid = $this->User_model->getCompanyId($userid)['szolgaltato_id'];
					$paymentid = $this->input->post("hidden_id");
					$datas = array (
							//"szolgaltato_id" => $companyid,
							"megnevezes" => $this->input->post("payment_name"),
							"eltolas" => $this->input->post("payment_value"),
							"letrehozas_datum" => $currentdate,
							"letrehozo_user" => $username,
							"modositas_datum" => $currentdate,
							"modosito_user" => $username
					);
					$this->Payment_model->updatePaymentDatas($paymentid,$datas);
					redirect('payment');
				}
				else
				{
					echo 'anyád';
					$tpl['action'] = 2;
					$this->load->view('view_PaymentForm',$tpl);
				}
			}
			else
			{
				$paymentid = $this->uri->segment(3);
				$datas["datas"] = $this->Payment_model->getPaymentById($paymentid);
				$this->load->view('templates/view_Header');
				$this->load->view('templates/view_Sidebar');
				$datas['action'] = 2;
				//de($datas);
				$this->load->view('view_PaymentForm',$datas);
			}
		}
		else
		{
			$this->logout();
		}		
	}
	
	public function deletePayment(){
		$id = $this->uri->segment(3);
		$this->load->model('Payment_model');
		$this->Payment_model->deletePayment($id);
		redirect(base_url().'payment/deleted');
	}
	
	public function deleted(){
		$this->index();
	}
	
	
	public function logout()
	{
		$this->session->unset_userdata();
		redirect(base_url().'login');
	}
	
}