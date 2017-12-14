<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VatDatas_model extends CI_Model {
	
	public function getVatList($szolgaltatoid){
		$this->db->where('szolgaltato_id',$szolgaltatoid);
		return $this->db->get('afakulcs_torzs')->result_array();
	}
	
	public function getVatById($id){
		$this->db->where('id',$id);
		$this->db->from('afakulcs_torzs');
		return $this->db->get()->result_array()[0];
	}
	
	public function getVatNameById($id){
		$this->db->select('megnevezes');
		$this->db->where('id',$id);
		$this->db->from('afakulcs_torzs');
		return $this->db->get()->result_array()[0];
	}
	
	public function insertVat($datas){
		$this->db->insert('afakulcs_torzs',$datas);
	}
	
	public function updateVat($id,$data){
		$this->db->where('id',$id);
		$this->db->update('afakulcs_torzs',$data);
	}
	
	public function deleteVat($id){
		$this->db->where('id',$id);
		$this->db->delete('afakulcs_torzs');
	}
}