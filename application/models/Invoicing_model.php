<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoicing_model extends CI_Model {
	
	public function productQuantity($id,$ev,$termekid){
		$this->db->select('id,termek_id,honap,ev,darabszam');
		$this->db->from('szamlak_darabszam');
		$this->db->where('ugyfel_id',$id);
		$this->db->where('ev',$ev);
		$this->db->where('termek_id',$termekid);
		$this->db->group_by('honap,termek_id');
		$this->db->order_by('ev','DESC');
		$this->db->order_by('honap','ASC');
		return $this->db->get()->result_array();
	}

	public function productYearByCustomerId($id){
		$this->db->select('szamlak_darabszam.ev as ev,szamlak_darabszam.termek_id as termek_id,termekek.termeknev as termeknev');
		$this->db->from('szamlak_darabszam');
		$this->db->join('termekek','termekek.id = szamlak_darabszam.termek_id');		
		$this->db->where('ugyfel_id',$id);
		$this->db->group_by('ev,termek_id');
		$this->db->order_by('ev,honap','DESC');
		return $this->db->get()->result_array();
	}
	
	public function sumQuantity($id,$ev,$termekid){
		$this->db->select_sum('darabszam');
		$this->db->from('szamlak_darabszam');
		$this->db->where('ugyfel_id',$id);
		$this->db->where('ev',$ev);
		$this->db->where('termek_id',$termekid);
		
		return $this->db->get()->result_array()[0]['darabszam'];
	}
	
	public function insertOnCustomerInsert($data){
		
	}
}