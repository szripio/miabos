<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {
	
	public function getPaymentList($id){
		$this->db->where('szolgaltato_id',$id);
		$this->db->from('fizmod_torzs');
		return $this->db->get()->result_array();
	}
	
	public function getPaymentById($id){
		$this->db->where('id',$id);
		$this->db->from('fizmod_torzs');
		return $this->db->get()->result_array()[0];
	}
	
	public function insertPaymentDatas($datas){
		$this->db->insert('fizmod_torzs',$datas);
	}
	
	public function updatePaymentDatas($id,$datas){
		$this->db->where('id',$id);
		$this->db->update('fizmod_torzs',$datas);
	}
	
	public function deletePayment($id){
		$this->db->where('id',$id);
		$this->db->delete('fizmod_torzs');
	}
}