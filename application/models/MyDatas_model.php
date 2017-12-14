<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyDatas_model extends CI_Model {

	public function getDatas($userid){
		$this->db->select('szolgaltatok.id,szolgaltatok.nev,szolgaltatok.szk_szolgaltato_id,szolgaltatok.adoszam,szolgaltatok.kozadoszam,szolgaltatok.csopadoszam,
				szolgaltatok.cim_orszag,szolgaltatok.cim_irszam,szolgaltatok.cim_telepules,szolgaltatok.cim_kozternev,szolgaltatok.cim_kozterjelleg,
				szolgaltatok.cim_hazszam,szolgaltatok.cim_egyeb,szolgaltatok.reg_datum,szolgaltatok.email,szolgaltatok.kisadozo,szolgaltatok.egyeni_vallalkozo,
				szolgaltatok.apikey');
		$this->db->from('szolgaltatok');
		$this->db->join('felhasznalok','felhasznalok.szolgaltato_id = szolgaltatok.id');
		$this->db->where('felhasznalok.id',$userid);
		return $this->db->get()->result_array()[0];
	}
	
	public function getBankDatas($szolgid){
		$this->db->select('szolgaltatok_bankszamlak.szolgaltato_id,szolgaltatok_bankszamlak.bankszamla,szolgaltatok_bankszamlak.bank,szolgaltatok_bankszamlak.iban,
				szolgaltatok_bankszamlak.swift');
		$this->db->from('szolgaltatok_bankszamlak');
		$this->db->join('szolgaltatok','szolgaltatok.id = szolgaltatok_bankszamlak.szolgaltato_id');
		$this->db->where('szolgaltatok_bankszamlak.szolgaltato_id',$szolgid);
		return $this->db->get()->result_array();
	}
	
	public function countBankAccount($id){
		$this->db->select('COUNT(id) as total');
		$this->db->from('szolgaltatok_bankszamlak');
		$this->db->where('szolgaltato_id',$id);
		return $this->db->get()->result_array()[0];
	}
	
	public function updateDatas($data,$companyid){
		$this->db->where('id',$companyid);
		$this->db->update('szolgaltatok',$data);

	}
	
}