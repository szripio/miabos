<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoicenumber_model extends CI_Model {
	
	public function getInvoicenumberList($szolgaltatoid){
		$this->db->where('szolgaltato_id',$szolgaltatoid);
		return $this->db->get('szamlatombok')->result_array();
	}
	
	public function insertInvoicenumber($data){
		$this->db->insert('szamlatombok',$data);
	}
	
	
}