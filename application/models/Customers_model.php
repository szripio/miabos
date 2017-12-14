<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_model extends CI_Model {

	function getAllCustomer(){
		$this->db->select ('id,cegnev,adoszam,email,cim_teljes,reg_datum');
		$this->db->order_by('cegnev', 'ASC');
		$query = $this->db->get('ugyfelek');
		return $query;
	}
	
	function getCustomers($id){
		$this->db->select ('ugyfelek.id,ugyfelek.cegnev,ugyfelek.adoszam,ugyfelek.email,ugyfelek.cim_teljes,ugyfelek.reg_datum');
		$this->db->from ('ugyfelek');
		$this->db->join ('felhasznalok','felhasznalok.szolgaltato_id = ugyfelek.szolgaltato_id');
		$this->db->where ('felhasznalok.id = '.$id);
		$this->db->order_by('ugyfelek.cegnev', 'ASC');
		$query = $this->db->get();
		return $query;
	}
	
	function insertCustomer($customerdata){
		$this->db->insert("ugyfelek",$customerdata);
	}
	
	function getLatestCustomers($id){
		$this->db->select ('ugyfelek.id,ugyfelek.cegnev,ugyfelek.adoszam,ugyfelek.email,ugyfelek.cim_teljes,ugyfelek.reg_datum');
		$this->db->from ('ugyfelek');
		$this->db->join ('felhasznalok','felhasznalok.szolgaltato_id = ugyfelek.szolgaltato_id');
		$this->db->where ('felhasznalok.id = '.$id);
		$this->db->order_by('ugyfelek.id', 'DESC');
		$this->db->limit (5);
		$query = $this->db->get();
		return $query;
	}
	
	function deleteCustomer($id){
		$this->db->where("id",$id);
		$this->db->delete("ugyfelek");
	}
	
	function getCustomerId($id){
		$this->db->where('id',$id);
		$this->db->from('ugyfelek');
		return $this->db->get()->result_array()[0];
	}
	
	function updateCustomer($data,$id){
		$this->db->where('id',$id);
		$this->db->update('ugyfelek',$data);
	}

}

?>