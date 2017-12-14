<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	function canLogin($username,$password,$id)
	{
		$this->db->where('felhasznalo_nev', $username);
		$this->db->where('jelszo', $password);
		$query = $this->db->get('felhasznalok');
	
		if($query->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function getUserId($username){
		$this->db->select ('id');
		$this->db->from ('felhasznalok');
		$this->db->where ("felhasznalo_nev = '".$username."'");
		return $this->db->get()->result_array()[0];	
		
	}
	
	//superadmin funkció
	function getAllUser(){
		$query = $this->db->get('felhasznalok');	
		return $query;
	}
	
	function usersByCompany($username){
		$this->db->select ('felhasznalok.id,felhasznalok.nev,felhasznalok.felhasznalo_nev,felhasznalok.letrehozas_datum,felhasznalok.letrehozo_user,felhasznalok.modositas_datum,felhasznalok.modosito_user');
		$this->db->from ('felhasznalok');
		$this->db->join ('szolgaltatok','szolgaltatok.id = felhasznalok.szolgaltato_id');
		$this->db->where ("felhasznalok.felhasznalo_nev = '".$username."'");
		$query = $this->db->get();
		return $query;
	}
	
	function getCompanyId($userid){
		$this->db->select ('szolgaltato_id');
		$this->db->from ('felhasznalok');
		$this->db->where ('id ='.$userid);
		return $this->db->get()->result_array()[0];
	}
}
?>