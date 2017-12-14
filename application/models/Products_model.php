<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {
	
	public function getProductList($szolgid){
		$this->db->where('szolgaltato_id',$szolgid);
		return $this->db->get('termekek')->result_array();
	}
	
	public function insertProduct($datas){
		$this->db->insert('termekek',$datas);
	}
	
	public function deleteProduct($id){
		$this->db->where('id',$id);
		$this->db->delete('termekek');
	}
	
	public function updateProduct($id,$data){
		$this->db->where('id',$id);
		$this->db->update('termekek',$data);
	}
	
	public function getProductById($id){
		$this->db->where('id',$id);
		$this->db->from('termekek');
		return $this->db->get()->result_array()[0];
	}
}