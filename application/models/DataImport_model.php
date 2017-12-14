<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataImport_model extends CI_Model {
	
	public function getCustomersWithoutInvoiceQuantity($honap,$ev,$szolgid){
		$this->db->select('id');
		$this->db->from('ugyfelek');
		$this->db->where('NOT EXISTS(SELECT honap from szamlak_darabszam where szamlak_darabszam.ugyfel_id = ugyfelek.id and honap='.$honap.' and ev='.$ev.')');
		$this->db->where('szolgaltato_id',$szolgid);		
		return $this->db->get()->result_array();
	}
	
	public function insertInvoiceQuantity($data){
		$this->db->insert('szamlak_darabszam',$data);
	}
}