<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoicing extends CI_Controller {
	
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
				$this->load->view('view_InvoicingMainDatas',$customer_data);
			}
			else
			{
				$userid = $this->User_model->getUserId($username)['id'];
				$customer_data["latest_customers"] = $this->Customers_model->getLatestCustomers($userid);
				$customer_data["customers"] = $this->Customers_model->getCustomers($userid);
				$this->load->view('view_InvoicingMainDatas',$customer_data);
			}
			$this->load->view('templates/view_Footer');
		}
		else
		{
			$this->session->unset_userdata();
			redirect('login');
		}
			
	}
	
	public function showProductQuantity($id){
		$this->load->model('Invoicing_model');
		$this->load->model('Customers_model');
		$listYear = $this->Invoicing_model->productYearByCustomerId($id);
		$cegnev = $this->Customers_model->getCustomerId($id)['cegnev'];
		//de($cegnev);
		$sumdarab = 0;
		$result = '';
		$lastyear = '';
		$result .= '
				<br>
				<div class="margin-default-bt">
					<button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Számlázási adatok rögzítése</button>
				</div>
				<table id="example" class="table table-striped " cellspacing="0" width="98%">
				<thead>
				<tr>
				<th colspan="14" style="text-align:center;background:rgb(249, 249, 249)">'.$cegnev.'</th>'.
				'</tr>
				<tr>
				<th>Termék</th>
				<th>Január</th>
				<th>Február</th>
				<th>Március</th>
				<th>Április</th>
				<th>Május</th>
				<th>Június</th>
				<th>Július</th>
				<th>Augusztus</th>
				<th>Szeptember</th>
				<th>Október</th>
				<th>November</th>
				<th>December</th>
				<th>Összesen</th>
				</tr>
				</thead>
				<tbody>
				<tr>';
		foreach ($listYear as $ev){
			if ($ev['ev'] != $lastyear)
				{
				$result .= '<tr><td colspan="14" style="background-color: ghostwhite;text-align: center;font-weight: 600">'.$ev['ev'].'</td></tr>';
				$lastyear = $ev['ev'];
				}
			$listProduct = $this->Invoicing_model->productQuantity($id,$ev['ev'],$ev['termek_id']);
			$result .= '<td>'.$ev['termeknev'].'</td>';			
			foreach ($listProduct as $product){
					$result .= '<td>'.($product['darabszam']).' db</td>';
			}
			$sumdarab = $this->Invoicing_model->sumQuantity($id,$ev['ev'],$ev['termek_id']);
			$result .= '<td style="font-weight: 600">'.$sumdarab.' db</td></tr>';
		}
		$result .= '</tbody></table>';
		echo $result;
	}
}